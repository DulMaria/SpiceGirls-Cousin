<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $role  ID del rol requerido para acceder
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verificar que el rol del usuario coincida con el rol requerido
        if (Auth::user()->ID_Rol != $role) {
            return $this->redirectBasedOnRole(Auth::user()->ID_Rol);
        }

        return $next($request);
    }

    /**
     * Redirecciona al usuario según su rol actual
     * 
     * @param int $rolId El ID del rol del usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole($rolId)
    {
        switch ($rolId) {
            case 1: // Administrador
                return redirect()->route('administrador.prinAdmi');
                
            case 2: // Docente
                return redirect()->route('docente.dashboard');
                
            case 3: // Estudiante
                return redirect()->route('estudiante.dashboard');
                
            default:
                // Si no coincide con ningún rol específico, redirigir a la página principal
                return redirect('/');
        }
    }
}