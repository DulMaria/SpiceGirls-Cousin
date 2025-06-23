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
            @if(isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $error }}
                </div>
            @elseif(isset($datosCurso))
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
                                <h3 class="text-2xl font-bold">{{ $datosCurso['curso']['nombre'] }}</h3>
                                <p class="text-sm opacity-80 mt-1">Código: {{ $datosCurso['curso']['codigo'] }}</p>
                            </div>
                        </div>
                        
                        <!-- Información detallada -->
                        <div class="p-6 md:w-2/3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Columna izquierda -->
                                <div>
                                    <div class="mb-4">
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Módulo Actual</h4>
                                        <p class="text-lg font-medium text-[#127475]">{{ $datosCurso['modulo']['nombre'] }}</p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Docente</h4>
                                        <div class="flex items-center mt-1">
                                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-2">
                                                <i class="fas fa-user text-gray-500"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">{{ $datosCurso['docente']['nombre'] }}</p>
                                                <p class="text-xs text-gray-500">{{ $datosCurso['docente']['especialidad'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Horario</h4>
                                        <p class="font-medium"><i class="far fa-calendar-alt mr-2 text-[#127475]"></i> {{ $datosCurso['horario']['dias'] }}</p>
                                        <p class="text-sm ml-6">{{ $datosCurso['horario']['hora'] }}</p>
                                    </div>
                                </div>
                                
                                <!-- Columna derecha -->
                                <div>
                                    <div class="mb-4">
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Aula</h4>
                                        <p class="font-medium"><i class="fas fa-door-open mr-2 text-[#127475]"></i> {{ $datosCurso['aula']['nombre'] }}</p>
                                        <p class="text-sm ml-6">{{ $datosCurso['aula']['plataforma'] }}</p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</h4>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            @if($datosCurso['progreso']['estado'] == 'En progreso') bg-green-100 text-green-800
                                            @elseif($datosCurso['progreso']['estado'] == 'Completado') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            <i class="fas fa-check-circle mr-1"></i> {{ $datosCurso['progreso']['estado'] }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Progreso</h4>
                                        <div class="flex items-center mt-1">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                                <div class="bg-[#127475] h-2.5 rounded-full" style="width: {{ $datosCurso['progreso']['porcentaje'] }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium">{{ $datosCurso['progreso']['porcentaje'] }}%</span>
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
                            @foreach($datosCurso['contenido'] as $contenido)
                                <li class="flex items-start">
                                    @if($contenido['completado'])
                                        <i class="fas fa-check text-green-500 mr-2 mt-1 text-xs"></i>
                                    @else
                                        <i class="far fa-circle text-gray-300 mr-2 mt-1 text-xs"></i>
                                    @endif
                                    <span class="{{ $contenido['completado'] ? '' : 'text-gray-600' }}">{{ $contenido['tema'] }}</span>
                                </li>
                            @endforeach
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
                            @foreach($datosCurso['proximasClases'] as $index => $clase)
                                <div class="border-l-4 {{ $index == 0 ? 'border-[#127475]' : 'border-gray-200' }} pl-3 py-1">
                                    <p class="font-medium">{{ $clase['fecha'] }}</p>
                                    <p class="text-sm text-gray-600">Tema: {{ $clase['tema'] }}</p>
                                    <p class="text-xs text-gray-500"><i class="far fa-clock mr-1"></i> {{ $clase['hora'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Recursos y contacto -->
                    <div class="bg-white p-6 rounded-xl shadow-md">                    
                        <div class="space-y-3">
                            @if($datosCurso['comunidad']['whatsapp'])
                                <a href="#" class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-comments text-green-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $datosCurso['comunidad']['nombre'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $datosCurso['comunidad']['descripcion'] }}</p>
                                    </div>
                                </a>
                            @endif
                            
                            @if($datosCurso['contacto']['disponible'])
                                <a href="mailto:{{ $datosCurso['contacto']['email'] }}" class="flex items-center p-2 rounded-lg hover:bg-gray-50 transition">
                                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-envelope text-red-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $datosCurso['contacto']['texto'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $datosCurso['contacto']['email'] }}</p>
                                    </div>
                                </a>
                            @endif
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
                                <p>Criminología</p>
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
                                <h4 class="font-medium">{{ $datosCurso['modulo']['nombre'] }}</h4>
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $datosCurso['progreso']['estado'] }}</span>
                            </div>
                            <div class="text-sm text-gray-600 mb-3">
                                <p>{{ $datosCurso['modulo']['descripcion'] }}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-xs text-gray-500">
                                    <i class="far fa-calendar mr-1"></i> {{ $datosCurso['modulo']['fechaInicio'] }} - {{ $datosCurso['modulo']['fechaFin'] }}
                                </div>
                                <div class="flex items-center">
                                    <div class="w-16 bg-gray-200 rounded-full h-1.5 mr-2">
                                        <div class="bg-[#127475] h-1.5 rounded-full" style="width: {{ $datosCurso['progreso']['porcentaje'] }}%"></div>
                                    </div>
                                    <span class="text-xs">{{ $datosCurso['progreso']['porcentaje'] }}%</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Módulo próximo -->
                        <div class="border rounded-lg p-4 opacity-70">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-medium">Módulo 3: Huellografia </h4>
                                <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">Próximo</span>
                            </div>
                            <div class="text-sm text-gray-600 mb-3">
                                <p>Criminología practica </p>
                            </div>
                            <div class="text-xs text-gray-500">
                                <i class="far fa-calendar mr-1"></i> 22 May - 30 Jun
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <h1 class="text-3xl md:text-4xl font-bold text-[#2e1a47] mb-2">Mi Curso Actual</h1>
                    <p class="text-lg text-gray-600">No tienes cursos activos en este momento</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($datosCurso))
                const progress = {{ $datosCurso['progreso']['porcentaje'] }};
                const circle = document.querySelector('.progress-ring__circle');
                if (circle) {
                    const radius = circle.r.baseVal.value;
                    const circumference = radius * 2 * Math.PI;
                    const offset = circumference - (progress / 100) * circumference;
                    circle.style.strokeDasharray = `${circumference} ${circumference}`;
                    circle.style.strokeDashoffset = offset;
                }
            @endif
        });
    </script>
</body>
</html>