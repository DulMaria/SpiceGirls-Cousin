<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-gradient-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-teal-custom {
            background-color: #127475;
        }

        .text-teal-custom {
            color: #127475;
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .profile-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans text-gray-800">
    <!-- Menú lateral -->
    @include('partials.navDocente')

    <!-- Contenido principal con margen para el sidebar -->
    <div class="ml-0 lg:ml-64 transition-all duration-300">
        <!-- Header móvil -->
        @include('partials.headerMovilAdmin')

        <!-- Contenido del dashboard -->
        <div class="min-h-screen w-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Welcome Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">Sistema Académico</h1>
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">¡Bienvenido de vuelta!</h2>
                            <p class="text-gray-600">Aquí tienes un resumen de tu perfil y actividad académica</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                                <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-5 5v-5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17H4l5 5v-5z" />
                                </svg>
                            </button>
                            <button class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                                <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Perfil del Docente -->
                    <div class="lg:col-span-1">
                        <div class="profile-card rounded-2xl p-6 text-white card-hover">
                            <div class="text-center">
                                <div
                                    class="mx-auto h-24 w-24 rounded-full bg-white bg-opacity-20 flex items-center justify-center mb-4">
                                    <svg class="h-12 w-12 text-black" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold mb-2">{{ $usuario->nombre }}
                                    {{ $usuario->apellidoPaterno }}
                                </h3>
                                <p class="text-blue-100 mb-4">{{ $docente->especialidad }}</p>
                                <div class="bg-white bg-opacity-20 rounded-lg p-3 mb-4">
                                    <p class="text-sm text-black font-semibold">Código Docente</p>
                                    <p class="text-lg text-black">{{ $docente->codigoDocente }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Información Personal -->
                        <div class="bg-white rounded-2xl shadow-lg p-6 mt-6 card-hover">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Información Personal
                            </h4>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email:</span>
                                    <span class="font-medium">{{ $usuario->email }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Teléfono:</span>
                                    <span class="font-medium">{{ $usuario->telefono }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">CI:</span>
                                    <span class="font-medium">{{ $usuario->ci }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Fecha Nac.:</span>
                                    <span
                                        class="font-medium">{{ date('d/m/Y', strtotime($usuario->fechaNacimiento)) }}</span>
                                </div>
                                <div class="pt-2 border-t">
                                    <span class="text-gray-600">Dirección:</span>
                                    <p class="font-medium mt-1">{{ $usuario->direccion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Principal -->
                    <div class="lg:col-span-2">
                        <!-- Estadísticas Rápidas -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-500 text-sm">Cursos Activos</p>
                                        <p class="text-3xl font-bold text-purple-600">{{ $cursosActivos ?? 4 }}</p>
                                    </div>
                                    <div class="bg-purple-100 p-3 rounded-full">
                                        <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-500 text-sm">Total Estudiantes</p>
                                        <p class="text-3xl font-bold text-teal-custom">{{ $totalEstudiantes ?? 156 }}
                                        </p>
                                    </div>
                                    <div class="bg-teal-50 p-3 rounded-full">
                                        <svg class="h-8 w-8 text-teal-custom" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-500 text-sm">Años Experiencia</p>
                                        <p class="text-3xl font-bold text-green-600">{{ $anosExperiencia ?? 8 }}</p>
                                    </div>
                                    <div class="bg-green-50 p-3 rounded-full">
                                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones Rápidas -->
                        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 card-hover">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Acciones Rápidas
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <button
                                    class="flex flex-col items-center p-4 rounded-xl bg-blue-50 hover:bg-blue-100 transition-colors">
                                    <div class="bg-blue-500 p-3 rounded-full mb-2">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Mis Cursos</span>
                                </button>

                                <button
                                    class="flex flex-col items-center p-4 rounded-xl bg-green-50 hover:bg-green-100 transition-colors">
                                    <div class="bg-green-500 p-3 rounded-full mb-2">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Estudiantes</span>
                                </button>

                                <button
                                    class="flex flex-col items-center p-4 rounded-xl bg-purple-50 hover:bg-purple-100 transition-colors">
                                    <div class="bg-purple-500 p-3 rounded-full mb-2">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Evaluaciones</span>
                                </button>

                                <button
                                    class="flex flex-col items-center p-4 rounded-xl bg-orange-50 hover:bg-orange-100 transition-colors">
                                    <div class="bg-orange-500 p-3 rounded-full mb-2">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Configuración</span>
                                </button>
                            </div>
                        </div>

                        <!-- Estado del Sistema -->
                        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Estado del Sistema
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-700">Conexión DB</span>
                                    </div>
                                    <span class="text-xs text-green-600 font-semibold">Activa</span>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-700">Estado:
                                            {{ $usuario->estado ?? 'Activo' }}</span>
                                    </div>
                                    <span class="text-xs text-green-600 font-semibold">Online</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
