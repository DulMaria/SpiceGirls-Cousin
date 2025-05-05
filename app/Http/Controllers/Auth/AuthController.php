<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\LoginAttempt;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
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
            return back()->withErrors(['email' => 'Usuario no activo.']);
        }

        // Verificar si hay bloqueos previos de intentos
        if (Cache::has("login_attempts_$email")) {
            $lockoutTime = Cache::get("login_attempts_$email");
            $minutesLeft = now()->diffInMinutes($lockoutTime);

            if ($minutesLeft > 0) {
                return back()->withErrors(['email' => "Cuenta bloqueada por $minutesLeft minutos más."]);
            } else {
                Cache::forget("login_attempts_$email");
            }
        }

        // Intento de login exitoso
        if (Auth::attempt(['email' => $email, 'password' => $request->password])) {
            // Verificación de 2FA
            $code = rand(100000, 999999); // Código de 6 dígitos
            $request->session()->put('2fa_code', $code);

            // Enviar código de verificación por correo
            Mail::to($user->email)->send(new TwoFactorCode($code));

            // Registrar intento exitoso
            LoginAttempt::create([
                'email'      => $email,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'successful' => true,
            ]);

            // // Redirigir según el rol del usuario
            // if ($user->role == 'admin') {
            //     return redirect()->route('admin.dashboard'); // Redirigir a panel de administración
            // } elseif ($user->role == 'employee') {
            //     return redirect()->route('employee.dashboard'); // Redirigir a dashboard de empleados
            // } else {
            //     return redirect()->route('home'); // Redirigir a la página principal para clientes
            // }

            return redirect()->route('verify-2fa'); // Mostrar formulario para el código de 2FA
        }

        // Registrar intento fallido
        $this->handleFailedLogin($request, $email);

        return back()->withErrors(['email' => 'Las credenciales no son válidas.']);
    }

    // Manejar login fallido y bloqueos progresivos
    private function handleFailedLogin(Request $request, $email)
    {
        $attempts = Cache::get("login_attempts_count_$email", 0) + 1;
        Cache::put("login_attempts_count_$email", $attempts, 60);

        // Si se superan los intentos, se establece el bloqueo progresivo
        if ($attempts >= 3 && $attempts < 6) {
            // Bloquear por 5 minutos
            Cache::put("login_attempts_$email", now()->addMinutes(5), 5);
        } elseif ($attempts >= 6 && $attempts < 9) {
            // Bloquear por 1 hora
            Cache::put("login_attempts_$email", now()->addMinutes(60), 60);
        } elseif ($attempts >= 9) {
            // Desactivar usuario después de 9 intentos fallidos
            $user = Usuario::where('email', $email)->first();
            if ($user) {
                $user->estado = '0'; // Desactivar
                $user->save();
            }
            Cache::forget("login_attempts_count_$email");
            Cache::forget("login_attempts_$email");
            return back()->withErrors(['email' => 'Cuenta desactivada debido a múltiples intentos fallidos.']);
        }
    }

    // Verificar código de 2FA
    public function verify2fa(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        if ($request->session()->get('2fa_code') == $request->input('code')) {
            // Limpiar código de 2FA
            $request->session()->forget('2fa_code');
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['code' => 'Código inválido.']);
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
