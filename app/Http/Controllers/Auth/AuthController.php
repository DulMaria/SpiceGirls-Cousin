<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCode;

class AuthController extends Controller
{
    // Mostrar vista de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $user = Usuario::where('email', $email)->first();

        // Verificar si el usuario está activo
        if (!$user || $user->estado != '1') {
            // Registrar intento fallido: usuario inactivo o no existe
            LoginAttempt::create([
                'email' => $email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'successful' => 0
            ]);
            return back()->withErrors(['email' => 'Usuario no activo.']);
        }

        // VERIFICACIÓN MEJORADA DE BLOQUEO
        // Verificamos si hay bloqueo activo para este email
        $cacheKey = "login_attempts_$email";
        if (Cache::has($cacheKey)) {
            $lockoutTime = Cache::get($cacheKey);

            // Aseguramos que $lockoutTime sea un objeto Carbon
            if (is_string($lockoutTime)) {
                $lockoutTime = \Carbon\Carbon::parse($lockoutTime);
            }

            // Verificamos si todavía está en tiempo de bloqueo
            if (now()->lt($lockoutTime)) {
                $minutesLeft = now()->diffInMinutes($lockoutTime);

                // Registrar intento fallido: usuario bloqueado
                LoginAttempt::create([
                    'email' => $email,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'successful' => 0
                ]);

                return back()->withErrors(['email' => "Cuenta bloqueada por $minutesLeft minutos más."]);
            } else {
                // El tiempo de bloqueo ya pasó, eliminamos la clave
                Cache::forget($cacheKey);
            }
        }

        // Intento de login
        if (Auth::attempt(['email' => $email, 'password' => $request->password])) {
            // Login exitoso - reiniciamos el contador de intentos fallidos
            Cache::forget("login_attempts_count_$email");

            // Registrar en tabla login_attempts
            LoginAttempt::create([
                'email' => $email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'successful' => 1
            ]);

            $code = rand(100000, 999999); // Genera código

            // Establecer el código y su tiempo de expiración (por ejemplo, 10 minutos)
            $request->session()->put('2fa_code', $code);
            $request->session()->put('2fa_expires_at', now()->addMinutes(10));

            // Envía el email (versión simple)
            Mail::to($user->email)->send(new TwoFactorCode($code));

            return redirect()->route('verify-2fa');
        }

        // Login fallido - registrar e incrementar contador
        LoginAttempt::create([
            'email' => $email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'successful' => 0
        ]);

        // MEJORA EN EL MANEJO DE BLOQUEOS
        $this->handleFailedLoginImproved($request, $email);

        return back()->withErrors(['email' => 'Las credenciales no son válidas.']);
    }

    // Manejar login fallido y bloqueos progresivos (versión mejorada)
    private function handleFailedLoginImproved(Request $request, $email)
    {
        // Incrementar contador de intentos fallidos
        $countKey = "login_attempts_count_$email";
        $attempts = Cache::get($countKey, 0) + 1;

        // Guardar el contador - importante: tiempo en segundos (3600 = 1 hora)
        Cache::put($countKey, $attempts, 3600);

        $lockKey = "login_attempts_$email";

        // Determinar acción según el número de intentos
        if ($attempts >= 3 && $attempts < 6) {
            // 3-5 intentos: bloqueo por 5 minutos
            $lockoutTime = now()->addMinutes(5);
            Cache::put($lockKey, $lockoutTime, 300); // 300 segundos = 5 minutos

            // Log para debugging
            Log::info("Usuario $email bloqueado por 5 minutos. Intentos: $attempts");
        } elseif ($attempts >= 6 && $attempts < 9) {
            // 6-8 intentos: bloqueo por 60 minutos
            $lockoutTime = now()->addMinutes(60);
            Cache::put($lockKey, $lockoutTime, 3600); // 3600 segundos = 60 minutos

            // Log para debugging
            Log::info("Usuario $email bloqueado por 60 minutos. Intentos: $attempts");
        } elseif ($attempts >= 9) {
            // 9+ intentos: desactivar la cuenta
            $user = Usuario::where('email', $email)->first();
            if ($user) {
                $user->estado = '0';
                $user->save();

                // Log para debugging
                Log::info("Usuario $email desactivado por exceso de intentos: $attempts");

                // Limpiar cache ya que la cuenta fue desactivada
                Cache::forget($countKey);
                Cache::forget($lockKey);
            }
        }
    }

    // Mostrar formulario de verificación 2FA
    public function show2faForm()
    {
        // Verificar si hay un código pendiente
        if (!session()->has('2fa_code')) {
            return redirect()->route('login')->withErrors(['email' => 'No hay código de verificación pendiente.']);
        }

        return view('auth.verify-2fa');
    }

    // Verificar código de 2FA
    public function verify2fa(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        // Verificar si hay un código en la sesión
        if (!$request->session()->has('2fa_code') || !$request->session()->has('2fa_expires_at')) {
            return redirect()->route('login')
                ->withErrors(['email' => 'No hay código de verificación pendiente. Inicia sesión nuevamente.']);
        }

        // 1. Verificar expiración primero
        if (now()->gt($request->session()->get('2fa_expires_at'))) {
            // Limpiar la sesión para evitar intentos con códigos expirados
            $request->session()->forget(['2fa_code', '2fa_expires_at']);
            return back()->withErrors(['code' => 'El código ha expirado. Por favor inicia sesión nuevamente.']);
        }

        // 2. Comparación segura (evita problemas de tipo)
        if ((string)$request->session()->get('2fa_code') === (string)$request->input('code')) {

            // 3. Limpiar toda la data de 2FA de la sesión
            $request->session()->forget(['2fa_code', '2fa_expires_at']);

            // 4. Marcar como autenticado completamente
            $request->session()->put('2fa_verified', true);

            // 5. Obtener el rol directamente del usuario autenticado (mejor que de sesión)
            $user = Auth::user();
            $rolId = $user->ID_Rol;
            // Registrar verificación 2FA exitosa
            LoginAttempt::create([
                'email' => $user->email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'successful' => 1
            ]);

            // 6. Redirección basada en el ID del rol
            return $this->redirectBasedOnRole($rolId);
        }

        return back()->withErrors(['code' => 'Código inválido. Inténtalo nuevamente.']);
    }

    /**
     * Redirecciona al usuario según su rol
     * 
     * @param int $rolId El ID del rol del usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole($rolId)
    {
        // Asegúrate de que $rolId es un número
        $rolId = (int)$rolId;

        switch ($rolId) {
            case 1: // Administrador
                return redirect()->route('administrador.prinAdmi');

            case 2: // Docente
                return redirect()->route('docente.dashboard');

            case 3: // Estudiante
                return redirect()->route('estudiante.dashboard');

            default:
                return redirect('/');
        }
    }

    // Reenviar código 2FA
    public function resend2faCode(Request $request)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Genera un nuevo código numérico de 6 dígitos
        $code = rand(100000, 999999);

        // Importante: Guardar solo el código numérico, no el objeto usuario
        $request->session()->put('2fa_code', $code);
        $request->session()->put('2fa_expires_at', now()->addMinutes(10));

        try {
            // Importante: Pasar SOLO el código numérico, no el objeto usuario
            Mail::to($user->email)->send(new TwoFactorCode($code));

            $request->validate([
                'code' => 'required|numeric|digits:6',
            ]);

            // Para debugging
            Log::info("Código 2FA reenviado a: {$user->email}. Código: {$code}");

            return back()->with('status', 'Se ha enviado un nuevo código de verificación a tu correo.');
        } catch (\Exception $e) {
            Log::error("Error al enviar código 2FA: " . $e->getMessage());
            return back()->withErrors(['email' => 'Error al enviar el código. Por favor intenta nuevamente.']);
        }
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
