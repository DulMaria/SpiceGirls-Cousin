@component('mail::message')
# Código de Verificación - SmartPool

Tu código de verificación es: 

@component('mail::panel')
<h1 style="text-align: center; font-size: 24px;">{{ $user->two_factor_code }}</h1>
@endcomponent

Este código expirará en 10 minutos.

**Importante:**
- No compartas este código con nadie
- Nuestro equipo nunca te pedirá este código
- Si no solicitaste este código, puedes ignorar este correo

Gracias,<br>
{{ config('app.name') }}
@endcomponent