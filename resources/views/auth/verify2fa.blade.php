<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Seguridad - Fundación Santa Germana Cousin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-blue-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-semibold text-blue-600">Verificación de Seguridad</h2>
                <p class="text-gray-600 mt-2">Protege tu cuenta con verificación en dos pasos</p>
            </div>

            {{-- Mostrar mensajes de éxito/error --}}
            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    @foreach ($errors->all() as $error)
                        <span class="block sm:inline">{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            {{-- Info del correo electrónico --}}
            <div class="bg-blue-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800">
                    Hemos enviado un código de verificación a tu correo electrónico:
                    <strong>{{ substr(auth()->user()->email, 0, 3) }}...{{ Str::after(auth()->user()->email, '@') }}</strong>
                </p>
            </div>

            {{-- Formulario de verificación --}}
            <form method="POST" action="{{ route('verify-2fa.submit') }}">
                @csrf
                
                <div class="mb-6">
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Ingresa el código de 6 dígitos
                    </label>
                    <input type="text" 
                           name="code" 
                           id="code" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="000000"
                           maxlength="6"
                           pattern="\d{6}"
                           required 
                           autofocus>
                </div>

                <div class="flex flex-col space-y-4">
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Verificar Código
                    </button>

                    <button type="button"
                            onclick="event.preventDefault(); document.getElementById('resend-form').submit();"
                            class="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Reenviar Código
                    </button>
                </div>
            </form>

            {{-- Formulario oculto para reenvío --}}
            <form id="resend-form" action="{{ route('2fa.resend') }}" method="POST" class="hidden">
                @csrf
            </form>

            {{-- Opción para cerrar sesión --}}
            <div class="mt-6 text-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                        Cancelar y cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Script para validar el código --}}
    <script>
        document.getElementById('code').addEventListener('input', function(e) {
            // Solo permite números y limita a 6 dígitos
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    </script>
</body>
</html>