namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\TwoFactorCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

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

    // Verificar el código ingresado
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6', // Validar que el código tenga exactamente 6 dígitos
        ]);

        $user = Auth::user(); // Obtener al usuario autenticado

        // Verificar si el código 2FA almacenado en la sesión coincide con el ingresado por el usuario
        if ($request->code !== session('two_factor_code') || now()->isAfter(session('two_factor_expires_at'))) {
            return back()->withErrors(['code' => 'El código no es válido o ha expirado.']);
        }

        // Limpiar los datos de verificación de la sesión
        session()->forget('two_factor_code');
        session()->forget('two_factor_expires_at');

        // Marcar la verificación 2FA como exitosa
        session()->put('two_factor_verified', true);

        // Redirigir al usuario a la página de destino o la página principal
        return redirect()->intended(route('home'));
    }

    // Reenviar el código
    public function resend()
    {
        $user = Auth::user(); // Obtener al usuario autenticado

        // Verificar el rol del usuario para enviar un mensaje personalizado
        if ($user->rol->nombre == 'admin') {
            // Si el usuario es un admin
            $message = 'Se ha enviado un nuevo código de verificación para el administrador.';
        } elseif ($user->rol->nombre == 'empleado') {
            // Si el usuario es un empleado
            $message = 'Se ha enviado un nuevo código de verificación para el empleado.';
        } else {
            // Si el usuario es un cliente
            $message = 'Se ha enviado un nuevo código de verificación para el cliente.';
        }

        // Generar un nuevo código de verificación 2FA
        $code = rand(100000, 999999); // Generar un código de 6 dígitos
        $expiresAt = now()->addMinutes(10); // Establecer la expiración del código en 10 minutos

        // Guardar el código y la expiración en la sesión
        session(['two_factor_code' => $code, 'two_factor_expires_at' => $expiresAt]);

        // Enviar el código de verificación por correo electrónico
        Mail::to($user->email)->send(new TwoFactorCode($user, $code));

        // Mostrar un mensaje al usuario indicando que el código fue reenviado
        return back()->with('status', $message);
    }
}
