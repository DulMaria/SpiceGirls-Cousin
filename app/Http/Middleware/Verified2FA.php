<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Verified2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verificar que se haya completado la autenticación de dos factores
        if (!session('2fa_verified')) {
            // Si hay un código de verificación pendiente, redirigir a la página de verificación
            if (session()->has('2fa_code')) {
                return redirect()->route('verify.2fa.form');
            }
            
            // Si no hay código pendiente, cerrar sesión y redirigir al login
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')
                ->withErrors(['email' => 'Se requiere verificación de dos factores.']);
        }

        return $next($request);
    }
}