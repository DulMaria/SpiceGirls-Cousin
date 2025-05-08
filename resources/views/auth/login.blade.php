<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Fundación Santa Germana Cousin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-custom {
            background: linear-gradient(135deg, #f3e8ff 0%, #e0f7fa 100%);
        }
        .btn-gradient {
            background: linear-gradient(45deg, #8b5cf6 0%, #7c3aed 50%, #4fd1c5 100%);
        }
        .btn-gradient:hover {
            background: linear-gradient(45deg, #7c3aed 0%, #6d28d9 50%, #38b2ac 100%);
        }
    </style>
</head>

<body class="bg-custom">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-purple-100">
            <!-- Logo y Nombre -->
            <div class="flex flex-col items-center mb-8">
                <img src="https://cdn.leonardo.ai/users/155b71f2-4da7-4c04-a85a-d14e23b9bd41/generations/fd8a1b37-0df6-45ea-935c-40c71ba6ff1c/Leonardo_Phoenix_10_A_modern_sleek_logo_image_featuring_the_te_3.jpg" 
                     alt="Fundacion Santa Germana Logo" 
                     class="w-32 h-32 mb-6 rounded-full object-cover border-4 border-purple-200 shadow-lg p-1 bg-purple-50">
                <h2 class="text-3xl font-bold text-purple-800">Santa Germana Cousin</h2>
                <p class="text-teal-600 mt-2 font-medium">Fundación de ayuda social</p>
            </div>

            <!-- Mensajes de Error -->
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-bold">Error</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-purple-800 mb-2">
                        Correo Electrónico
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-6 w-6 text-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="pl-12 w-full rounded-xl border-2 border-purple-100 p-3 text-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent placeholder-purple-300"
                            placeholder="ejemplo@correo.com" required>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-purple-800 mb-2">
                        Contraseña
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-6 w-6 text-teal-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password"
                            class="pl-12 w-full rounded-xl border-2 border-purple-100 p-3 text-purple-800 focus:outline-none focus:ring-2 focus:ring-teal-300 focus:border-transparent placeholder-purple-300"
                            required>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-5 w-5 text-purple-600 focus:ring-purple-400 border-purple-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-purple-700">
                            Recordarme
                        </label>
                    </div>
                    
                    <div class="text-sm">
                        <a href="" class="text-purple-600 hover:text-purple-800 font-medium">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full btn-gradient flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-lg font-bold text-white hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-400 transition-all duration-300">
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>