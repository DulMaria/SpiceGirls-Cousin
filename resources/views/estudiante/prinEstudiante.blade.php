<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .bg-teal-700-custom {
            background-color: #127475;
        }
        .text-teal-700-custom {
            color: #127475;
        }
        .border-teal-700-custom {
            border-color: #127475;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans text-gray-800">

    <!-- Menú lateral -->
    @include('partials.navEstudiante')

    <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilAdmin')

        <!-- Contenido principal -->
        <main class="flex-1 px-4 py-6 md:px-10 md:py-8 mt-0">
            <div class="border-b pb-4 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <h1 class="text-2xl sm:text-3xl font-bold text-[#2e1a47] leading-tight">Mi Panel de Estudiante</h1>
                <span class="text-sm text-gray-500">Bienvenido a tu espacio personal, {{ $usuario->nombre }}</span>
            </div>

            <!-- Información personal del estudiante -->
            <section class="mt-6">
                <!-- Tarjetas de información -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Datos personales -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex justify-between items-start">
                            <div class="w-full">
                                <h3 class="text-lg font-semibold text-purple-900 mb-4">Datos Personales</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Nombre:</span>
                                        <span class="font-medium">{{ $usuario->nombre }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Apellidos:</span>
                                        <span class="font-medium">{{ $usuario->apellidoPaterno }}
                                            {{ $usuario->apellidoMaterno }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">CI:</span>
                                        <span class="font-medium">{{ $usuario->ci }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Email:</span>
                                        <span class="font-medium">{{ $usuario->email }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Teléfono:</span>
                                        <span class="font-medium">{{ $usuario->telefono }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-900" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Información adicional del estudiante -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex justify-between items-start">
                            <div class="w-full">
                                <h3 class="text-lg font-semibold text-purple-900 mb-4">Información Adicional</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-40">Código Estudiantil:</span>
                                        <span class="font-medium">{{ $estudiante->codigoEstudiantil }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-40">Nivel Académico:</span>
                                        <span class="font-medium">{{ $estudiante->nivelAcademico }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-40">Género:</span>
                                        <span
                                            class="font-medium">{{ $estudiante->genero == 1 ? 'Masculino' : 'Femenino' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-900" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path
                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel de información académica -->
                <div class="bg-white rounded-2xl p-6 shadow-md mb-8">
                    <h3 class="text-lg font-semibold text-purple-900 mb-4">Mi Progreso Académico</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Asistencia -->
                        <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-teal-700-custom">Asistencia</span>
                                <span class="text-xs bg-teal-100 text-teal-700-custom px-2 py-1 rounded-full">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-teal-700-custom h-2 rounded-full" style="width: 85%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">8 de 10 clases asistidas</p>
                        </div>

                        <!-- Calificación actual -->
                        <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-teal-700-custom">Calificación</span>
                                <span class="text-xs bg-teal-100 text-teal-700-custom px-2 py-1 rounded-full">8.7/10</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-teal-700-custom h-2 rounded-full" style="width: 87%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Promedio de trabajos y exámenes</p>
                        </div>

                        <!-- Próximas actividades -->
                        <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-teal-700-custom">Próxima actividad</span>
                                <span class="text-xs bg-teal-100 text-teal-700-custom px-2 py-1 rounded-full">15/06</span>
                            </div>
                            <p class="text-sm font-medium text-teal-700-custom">Examen parcial módulo 3</p>
                            <p class="text-xs text-gray-500 mt-1">Vence en 7 días</p>
                        </div>
                    </div>
                </div>

                <!-- Cursos actuales -->
                <div class="bg-white rounded-2xl p-6 shadow-md mb-8">
                    <h3 class="text-lg font-semibold text-purple-900 mb-4">Mis Cursos Actuales</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-purple-50">
                                <tr>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">
                                        Curso</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">
                                        Docente</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">
                                        Horario</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">
                                        Progreso</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Criminología Aplicada</div>
                                        <div class="text-sm text-gray-500">Técnicas de Investigación</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Dr. Javier Martínez</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Lunes y Miércoles</div>
                                        <div class="text-xs text-gray-500">16:00 - 20:00</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                            <div class="bg-teal-700-custom h-2 rounded-full" style="width: 75%"></div>
                                        </div>
                                        <div class="text-xs text-gray-500">75% completado</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Psicología Forense</div>
                                        <div class="text-sm text-gray-500">Perfilación Criminal</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Dra. Carmen Villalba</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Martes y Jueves</div>
                                        <div class="text-xs text-gray-500">14:00 - 18:00</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                            <div class="bg-teal-700-custom h-2 rounded-full" style="width: 60%"></div>
                                        </div>
                                        <div class="text-xs text-gray-500">60% completado</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>