<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recuperación de contraseña</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #f9fafb; padding: 20px; border-radius: 10px;">
        <h2 style="color: #2563eb; text-align: center;">Recuperación de contraseña</h2>
        <p>Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace para crear una nueva contraseña:</p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('password.reset', $token) }}" 
               style="background: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Restablecer contraseña
            </a>
        </div>
        <p>Este enlace expirará en 2 horas.</p>
        <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>
        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">
        <p style="color: #6b7280; font-size: 0.875rem; text-align: center;">
            SmartPool © {{ date('Y') }}
        </p>
    </div>
</body>
</html>