<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Curso Actual</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .progress-ring__circle {
            transition: stroke-dashoffset 0.5s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <!-- Menú lateral -->
    @include('partials.navEstudiante')

    <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilAdmin')

        <div class="container mx-auto py-8 px-4 max-w-6xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-[#2e1a47] mb-2">Mi Curso Actual</h1>
                <p class="text-lg text-gray-600">Revisa toda la información sobre tu formación en progreso</p>
            </div>

            <!-- Tarjeta principal del curso -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 course-card transition duration-300">
                <div class="md:flex">
                    <!-- Imagen del curso -->
                    <div class="md:w-1/3 bg-gradient-to-br from-[#127475] to-[#2e1a47] flex items-center justify-center p-6">
                        <div class="text-center text-white">
                            <i class="fas fa-laptop-code text-6xl mb-4"></i>
                            <h3 class="text-2xl font-bold">Desarrollo Web Full Stack</h3>
                            <p class="text-sm opacity-80 mt-1">Código: DWFS-2025-03</p>
                        </div>
                    </div>
                    
                    <!-- Información detallada -->
                    <div class="p-6 md:w-2/3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Columna izquierda -->
                            <div>
                                <div class="mb-4">
                                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Módulo Actual</h4>
                                    <p class="text-lg font-medium text-[#127475]">Módulo 2: Frontend Intermedio</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Docente</h4>
                                    <div class="flex items-center mt-1">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-2">
                                            <i class="fas fa-user text-gray-500"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium">Lic. Ana María Rodríguez</p>
                                            <p class="text-xs text-gray-500">Especialista en React</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Horario</h4>
                                    <p class="font-medium"><i class="far fa-calendar-alt mr-2 text-[#127475]"></i> Lunes y Miércoles</p>
                                    <p class="text-sm ml-6">18:00 - 20:00 hrs</p>
                                </div>
                            </div>
                            
                            <!-- Columna derecha -->
                            <div>
                                <div class="mb-4">
                                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Aula</h4>
                                    <p class="font-medium"><i class="fas fa-door-open mr-2 text-[#127475]"></i> Aula Virtual 3</p>
                                    <p class="text-sm ml-6">Plataforma: Zoom (Enlace en Classroom)</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</h4>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> En progreso
                                    </span>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Progreso</h4>
                                    <div class="flex items-center mt-1">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                            <div class="bg-[#127475] h-2.5 rounded-full" style="width: 65%"></div>
                                        </div>
                                        <span class="text-sm font-medium">65%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de detalles adicionales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Detalles del módulo -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-[#127475] bg-opacity-10 text-[#127475] mr-3">
                            <i class="fas fa-book-open text-lg"></i>
                        </div>
                        <h3 class="text-lg font-semibold">Contenido del Módulo</h3>
                    </div>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                            <span>React Hooks y Context API</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                            <span>Estado avanzado con Redux</span>
                        </li>
                        <li class="flex items-start">
                            <i class="far fa-circle text-gray-300 mr-2 mt-1 text-xs"></i>
                            <span>Autenticación con JWT</span>
                        </li>
                        <li class="flex items-start">
                            <i class="far fa-circle text-gray-300 mr-2 mt-1 text-xs"></i>
                            <span>Testing con Jest</span>
                        </li>
                        <li class="flex items-start">
                            <i class="far fa-circle text-gray-300 mr-2 mt-1 text-xs"></i>
                            <span>Proyecto integrador</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Próximas clases -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-[#2e1a47] bg-opacity-10 text-[#2e1a47] mr-3">
                            <i class="fas fa-calendar-alt text-lg"></i>
                        </div>
                        <h3 class="text-lg font-semibold">Próximas Clases</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="border-l-4 border-[#127475] pl-3 py-1">
                            <p class="font-medium">Lunes, 15 Mayo</p>
                            <p class="text-sm text-gray-600">Tema: Autenticación con JWT</p>
                            <p class="text-xs text-gray-500"><i class="far fa-clock mr-1"></i> 18:00 - 20:00 hrs</p>
                        </div>
                        <div class="border-l-4 border-gray-200 pl-3 py-1">
                            <p class="font-medium">Miércoles, 17 Mayo</p>
                            <p class="text-sm text-gray-600">Tema: Práctica guiada</p>
                            <p class="text-xs text-gray-500"><i class="far fa-clock mr-1"></i> 18:00 - 20:00 hrs</p>
                        </div>
                        <div class="border-l-4 border-gray-200 pl-3 py-1">
                            <p class="font-medium">Lunes, 22 Mayo</p>
                            <p class="text-sm text-gray-600">Tema: Testing con Jest</p>
                            <p class="text-xs text-gray-500"><i class="far fa-clock mr-1"></i> 18:00 - 20:00 hrs</p>
                        </div>
                    </div>
                </div>
                
                <!-- Recursos y contacto -->
                <div class="bg-white p-6 rounded-xl shadow-md">                    
                    <div class="space-y-3">
                       
                        <a href="#" class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <i class="fas fa-comments text-green-500"></i>
                            </div>
                            <div>
                                <p class="font-medium">Grupo de WhatsApp</p>
                                <p class="text-xs text-gray-500">Comunidad del curso</p>
                            </div>
                        </a>
                        <a href="#" class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition">
                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                <i class="fas fa-envelope text-red-500"></i>
                            </div>
                            <div>
                                <p class="font-medium">Contactar docente</p>
                                <p class="text-xs text-gray-500">arodriguez@instituto.edu</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Progreso del curso -->
            <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-chart-line text-[#127475] mr-2"></i>
                    Progreso del Curso
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Módulo completado -->
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-medium">Módulo 1: Fundamentos</h4>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Completado</span>
                        </div>
                        <div class="text-sm text-gray-600 mb-3">
                            <p>HTML5, CSS3 y JavaScript básico</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                <i class="far fa-calendar mr-1"></i> 15 Mar - 10 Abr
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                <span class="text-xs">100%</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Módulo actual -->
                    <div class="border-2 border-[#127475] rounded-lg p-4 relative">
                        <div class="absolute -top-2 -right-2 bg-[#127475] text-white text-xs px-2 py-1 rounded-full">
                            Actual
                        </div>
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-medium">Módulo 2: Frontend Intermedio</h4>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">En progreso</span>
                        </div>
                        <div class="text-sm text-gray-600 mb-3">
                            <p>React, Redux y APIs</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                <i class="far fa-calendar mr-1"></i> 12 Abr - 20 May
                            </div>
                            <div class="flex items-center">
                                <div class="w-16 bg-gray-200 rounded-full h-1.5 mr-2">
                                    <div class="bg-[#127475] h-1.5 rounded-full" style="width: 65%"></div>
                                </div>
                                <span class="text-xs">65%</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Módulo próximo -->
                    <div class="border rounded-lg p-4 opacity-70">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-medium">Módulo 3: Backend</h4>
                            <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">Próximo</span>
                        </div>
                        <div class="text-sm text-gray-600 mb-3">
                            <p>Node.js, Express y MongoDB</p>
                        </div>
                        <div class="text-xs text-gray-500">
                            <i class="far fa-calendar mr-1"></i> 22 May - 30 Jun
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Aquí puedes agregar interactividad si es necesario
        document.addEventListener('DOMContentLoaded', function() {
            // Ejemplo: Actualizar el círculo de progreso
            const progress = 65; // Porcentaje de progreso
            const circle = document.querySelector('.progress-ring__circle');
            if (circle) {
                const radius = circle.r.baseVal.value;
                const circumference = radius * 2 * Math.PI;
                const offset = circumference - (progress / 100) * circumference;
                circle.style.strokeDasharray = `${circumference} ${circumference}`;
                circle.style.strokeDashoffset = offset;
            }
        });
    </script>
</body>
</html>