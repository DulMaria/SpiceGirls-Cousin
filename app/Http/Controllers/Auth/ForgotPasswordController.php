<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Usuario;
use Carbon\Carbon;
use App\Services\NotificationService;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    // Enviar enlace de recuperación
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuario,Email',
        ]);

        // Buscar al usuario por correo
        $user = Usuario::where('Email', $request->email)->first();

        // Crear un token único
        $token = Str::random(64);

        // Eliminar los tokens previos del usuario
        PasswordResetToken::where('email', $user->Email)->delete();

        // Crear un nuevo registro de token
        PasswordResetToken::create([
            'email' => $user->Email,
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addHours(2), // El token expira en 2 horas
        ]);

        // Intentar enviar el correo de recuperación
        $emailSent = $this->notificationService->sendPasswordResetEmail($user, $token);

        // Verificar si el correo fue enviado correctamente
        if (!$emailSent) {
            return back()->withErrors([
                'email' => 'Hubo un problema al enviar el correo. Por favor, intenta más tarde.'
            ]);
        }

        return back()->with('status', 'Te hemos enviado un correo con las instrucciones para restablecer tu contraseña.');
    }

    // Mostrar formulario de "Olvidé mi contraseña"
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    // Mostrar formulario para restablecer la contraseña
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Restablecer la contraseña del usuario
    public function reset(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:usuario,Email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', // Contraseña con mayúsculas, minúsculas y números
            ]
        ], [
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula y un número.'
        ]);

        // Buscar el registro del token en la base de datos
        $reset = PasswordResetToken::where('email', $request->email)
            ->where('token', $request->token)
            ->where('expires_at', '>', Carbon::now()) // Verificar si el token aún es válido
            ->first();

        // Si no se encuentra el token o está expirado
        if (!$reset) {
            return back()->withErrors(['email' => 'El enlace de recuperación no es válido o ha expirado.']);
        }

        // Buscar al usuario
        $user = Usuario::where('Email', $request->email)->first();

        // Actualizar la contraseña del usuario
        $user->Contraseña = Hash::make($request->password);
        $user->save();

        // Eliminar todos los tokens del usuario después de un restablecimiento exitoso
        PasswordResetToken::where('email', $request->email)->delete();

        // Redirigir al login con mensaje de éxito
        return redirect()->route('login')
            ->with('status', 'Tu contraseña ha sido restablecida correctamente. Ya puedes iniciar sesión.');
    }
}
