<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos Estudiantes!</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

    <!-- Menú lateral -->
    @include('partials.navEstudiante') 

    <!-- <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilEstudiante')         -->

        <!-- Contenido principal -->
        <main class="flex-1 px-4 py-6 md:px-10 md:py-8 mt-0">
            <div class="border-b pb-4 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <h1 class="text-2xl sm:text-3xl font-bold text-[#2e1a47] leading-tight">Mi Panel de Estudiante</h1>
                <span class="text-sm text-gray-500">Bienvenido a tu espacio personal</span>
            </div>

            <!-- Información personal del estudiante -->
            <section class="mt-6 px-4">
                <!-- Tarjetas de información -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Datos personales -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-purple-900 mb-4">Datos Personales</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Nombre:</span>
                                        <span class="font-medium">María Fernanda López</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Apellidos:</span>
                                        <span class="font-medium">López García</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">CI:</span>
                                        <span class="font-medium">45.678.901-K</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Email:</span>
                                        <span class="font-medium">maria.lopez@email.com</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Teléfono:</span>
                                        <span class="font-medium">+591 612 345 678</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Información académica -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-purple-900 mb-4">Información Académica</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Curso:</span>
                                        <span class="font-medium">Criminología Aplicada</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Módulo:</span>
                                        <span class="font-medium">3 - Técnicas de Investigación</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Aula:</span>
                                        <span class="font-medium">Aula 204 (Edificio Norte)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Horario:</span>
                                        <span class="font-medium">Lunes y Miércoles 16:00-20:00</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Docente:</span>
                                        <span class="font-medium">Dr. Javier Martínez</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progreso académico -->
                <div class="bg-white rounded-2xl p-6 shadow-md mb-8">
                    <h3 class="text-lg font-semibold text-purple-900 mb-4">Mi Progreso Académico</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Asistencia -->
                        <div class="bg-purple-50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-purple-800">Asistencia</span>
                                <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">8 de 10 clases asistidas</p>
                        </div>
                        
                        <!-- Calificación actual -->
                        <div class="bg-purple-50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-purple-800">Calificación</span>
                                <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">8.7/10</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 87%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Promedio de trabajos y exámenes</p>
                        </div>
                        
                        <!-- Próximas actividades -->
                        <div class="bg-purple-50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-purple-800">Próxima actividad</span>
                                <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">15/06</span>
                            </div>
                            <p class="text-sm font-medium">Examen parcial módulo 3</p>
                            <p class="text-xs text-gray-500 mt-1">Vence en 7 días</p>
                        </div>
                    </div>
                </div>                
            </section>
        </main>
    </div>
</body>
</html>