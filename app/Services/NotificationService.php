<?php

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail; // Asegúrate de tener esta clase de Mail creada

class NotificationService
{
    // Método para enviar el correo de recuperación de contraseña
    public function sendPasswordResetEmail(Usuario $user, $token)
    {
        // Aquí se maneja el envío del correo, asegúrate de tener la clase Mail configurada para esto
        try {
            Mail::to($user->Email)->send(new PasswordResetMail($user, $token)); 
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
