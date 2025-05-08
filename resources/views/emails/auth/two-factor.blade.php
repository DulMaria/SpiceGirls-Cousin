<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Seguridad - Fundación Santa Germana Cousin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-teal-100 via-purple-100 to-teal-50 min-h-screen flex items-center justify-center font-sans">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md border border-purple-200">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-purple-700">Verificación de Seguridad</h2>
            <p class="text-teal-700 mt-2 text-sm">Protege tu cuenta con verificación en dos pasos</p>
        </div>

        @if (session('status'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md text-sm">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md text-sm">
                @foreach ($errors->all() as $error)
                    <span class="block sm:inline">{{ $error }}</span>
                @endforeach
            </div>
        @endif

        <div class="bg-purple-50 rounded-lg p-4 mb-6 border border-purple-200">
            <p class="text-sm text-purple-800">
                Hemos enviado un código de verificación a tu correo electrónico:
                <strong>{{ substr(auth()->user()->Email, 0, 3) }}...{{ strstr(auth()->user()->Email, '@') }}</strong>
            </p>
        </div>

        <form method="POST" action="{{ route('verify-2fa.submit') }}">
            @csrf
            <div class="mb-6">
                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                    Ingresa el código de 6 dígitos
                </label>
                <input type="text" 
                       name="code" 
                       id="code" 
                       class="w-full px-4 py-2 border border-teal-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-center text-lg tracking-widest"
                       placeholder="000000"
                       maxlength="6"
                       pattern="\d{6}"
                       required 
                       autofocus>
            </div>

            <div class="flex flex-col space-y-3">
                <button type="submit" 
                        class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-1">
                    Verificar Código
                </button>

                <button type="button"
                        onclick="event.preventDefault(); document.getElementById('resend-form').submit();"
                        class="w-full bg-teal-100 text-teal-700 py-2 px-4 rounded-md hover:bg-teal-200 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:ring-offset-1">
                    Reenviar Código
                </button>
            </div>
        </form>

        <form id="resend-form" action="{{ route('2fa.resend') }}" method="POST" class="hidden">
            @csrf
        </form>

        <div class="mt-6 text-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:text-red-800 underline">
                    Cancelar y cerrar sesión
                </button>
            </form>
        </div>
    </div>

    <script>
        // Script para limpiar y limitar el campo a 6 dígitos
        document.getElementById('code').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    </script>
</body>
</html>
