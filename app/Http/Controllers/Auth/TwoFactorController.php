<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\TwoFactorCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TwoFactorController extends Controller
{
    // Mostrar la vista de verificación
    public function show()
    {
        // Verifica si el usuario está autenticado usando Auth::check()
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirigir al login si no está autenticado
        }

        return view('emails.auth.two-factor');
    }

    // Método para enviar el código inicial (NUEVO)
    public function sendInitialCode()
    {
        $user = Auth::user();
        $code = rand(100000, 999999);
        
        session([
            '2fa_code' => $code,
            '2fa_expires_at' => now()->addMinutes(10)
        ]);

        try {
            Mail::to($user->email)->send(new TwoFactorCode($code));
            Log::info("Código 2FA inicial enviado a {$user->email}");
            return redirect()->route('2fa.show')->with('status', 'Código enviado. Revisa tu correo.');
            
        } catch (\Exception $e) {
            Log::error("Error enviando código inicial: " . $e->getMessage());
            return back()->withErrors(['email' => 'Error al enviar el código.']);
        }
    }
    
    public function verify2fa(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        // Debugging - Registrar información para depuración
        $inputCode = (string)$request->input('code');
        $sessionCode = (string)session('2fa_code');
        
        Log::info('Verificación 2FA:', [
            'input_code' => $inputCode,
            'session_code' => $sessionCode,
            'code_match' => $inputCode === $sessionCode
        ]);

        // Verificar que exista el código y su expiración
        if (!session()->has('2fa_code') || !session()->has('2fa_expires_at')) {
            return redirect()->route('login')->withErrors(['email' => 'Sesión de verificación inválida.']);
        }

        // Verificar expiración
        if (now()->gt(session('2fa_expires_at'))) {
            session()->forget(['2fa_code', '2fa_expires_at']);
            return back()->withErrors(['code' => 'El código ha expirado. Por favor inicie sesión nuevamente.']);
        }

        // Comparar códigos - asegurarse de que ambos son strings
        if ((string)session('2fa_code') === (string)$request->input('code')) {
            // Limpiar sesión 2FA
            session()->forget(['2fa_code', '2fa_expires_at']);

            // Marcar como autenticado
            session()->put('2fa_verified', true);

            // Redirección según rol
            $user = Auth::user();
            $rolId = $user->ID_Rol;

            // Registro para debug
            Log::info('Usuario autenticado con 2FA', [
                'email' => $user->email,
                'rol_id' => $rolId
            ]);
            
            // Redirección basada en el ID del rol
            return $this->redirectBasedOnRole($rolId);
        }

        // Si el código no coincide, registrarlo para debugging
        Log::warning('Código 2FA inválido', [
            'user_email' => Auth::user()->email,
            'entered_code' => $request->input('code'),
            'session_code' => session('2fa_code')
        ]);

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
            return redirect()->back()->with('error', 'Usuario no encontrado. Por favor comuníquese con soporte técnico.');    
    }
}

    // Reenviar el código - CORREGIDO
    public function resend()
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();

        // Generar un nuevo código de verificación 2FA
        $code = rand(100000, 999999); // Generar un código de 6 dígitos
        
        // Guardar el código y la expiración en la sesión
        session(['2fa_code' => $code, '2fa_expires_at' => now()->addMinutes(10)]);
        
        // Debugging - Registrar el código generado
        Log::info("Nuevo código 2FA generado:", [
            'user_email' => $user->email,
            'code' => $code,
            'session_code' => session('2fa_code')
        ]);
        
        try {
            // IMPORTANTE: Pasar SOLO el código numérico, no el objeto usuario
            Mail::to($user->email)->send(new TwoFactorCode($code));
            
            return back()->with('status', 'Se ha enviado un nuevo código de verificación a tu correo.');
        } catch (\Exception $e) {
            Log::error("Error al enviar código 2FA: " . $e->getMessage());
            return back()->withErrors(['email' => 'Error al enviar el código. Por favor intenta nuevamente.']);
        }
    }
}