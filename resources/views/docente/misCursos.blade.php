<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Académica - Mis Cursos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <!-- Menú lateral -->
    @include('partials.navDocente')

    <!-- Contenido principal con padding adecuado -->
    <div class="ml-0 lg:ml-64 transition-all duration-300 p-4 lg:p-6">
        <!-- Header móvil -->
        @include('partials.headerMovilAdmin')

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                <i class="fas fa-book text-purple-600 mr-2"></i>Gestión Académica - Mis Cursos
            </h2>
        </div>

        @if ($cursosPorDocente->count() > 0)
            <!-- Courses Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($cursosPorDocente as $cursoData)
                    <!-- Course Card -->
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition duration-300">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <h5 class="font-semibold text-gray-800">
                                <i
                                    class="fas fa-graduation-cap text-purple-600 mr-2"></i>{{ $cursoData['nombre_curso'] }}
                            </h5>
                        </div>
                        <div class="p-4">
                            <div class="mb-3">
                                <span class="font-medium text-gray-700">Código:</span>
                                <span
                                    class="ml-2 bg-gray-200 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $cursoData['codigo_curso'] }}</span>
                            </div>

                            <div class="mb-3 flex items-center">
                                <i class="fas fa-users text-purple-600 mr-2"></i>
                                <span class="font-medium text-gray-700">Inscripciones:</span>
                                <span class="ml-2 text-gray-600">{{ $cursoData['total_inscripciones'] }}</span>
                            </div>

                            <div class="mb-3">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-teal-600 mr-2"></i>
                                    <span class="font-medium text-gray-700">Horario:</span>
                                </div>
                                <p class="text-sm text-gray-600 ml-6">{{ $cursoData['horarios'] }}</p>
                            </div>

                            <div class="mb-4 flex items-center">
                                <i class="fas fa-map-marker-alt text-purple-500 mr-2"></i>
                                <span class="font-medium text-gray-700">Aula:</span>
                                <span class="ml-2 text-gray-600">{{ $cursoData['aulas'] }}</span>
                            </div>

                            <div class="mb-3 flex items-center">
                                <i class="fas fa-layer-group text-teal-600 mr-2"></i>
                                <span class="font-medium text-gray-700">Módulos:</span>
                                <span class="ml-2 text-gray-600">{{ $cursoData['total_modulos'] }}</span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-3">
                                <div class="bg-purple-600 h-2.5 rounded-full"
                                    style="width: {{ min(($cursoData['total_inscripciones'] / 35) * 100, 100) }}%">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 text-center">{{ $cursoData['total_inscripciones'] }}/35
                                inscripciones</p>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                            <div class="grid grid-cols-3 gap-2">
                                <a href="{{ route('docente.seguimiento', $cursoData['ID_Curso']) }}"
                                    class="text-center text-teal-600 hover:text-white hover:bg-teal-600 border border-teal-600 rounded-md px-3 py-1.5 text-sm transition duration-300">
                                    <i class="fas fa-chart-line mr-1"></i> Seguimiento
                                </a>
                                <a href="{{ route('docente.analisis', $cursoData['ID_Curso']) }}"
                                    class="text-center text-purple-400 hover:text-white hover:bg-purple-400 border border-purple-400 rounded-md px-3 py-1.5 text-sm transition duration-300">
                                    <i class="fas fa-analytics mr-1"></i> Análisis
                                </a>
                                <a href="{{ route('docente.reportes', $cursoData['ID_Curso']) }}"
                                    class="text-center text-teal-500 hover:text-white hover:bg-teal-500 border border-teal-500 rounded-md px-3 py-1.5 text-sm transition duration-300">
                                    <i class="fas fa-file-alt mr-1"></i> Reportes
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- General Statistics -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <h5 class="font-semibold text-gray-800">
                        <i class="fas fa-chart-bar text-purple-600 mr-2"></i>Resumen General
                    </h5>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <h3 class="text-3xl font-bold text-purple-600">{{ $estadisticas['total_cursos'] }}</h3>
                            <p class="text-gray-500">Cursos Activos</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-3xl font-bold text-teal-600">{{ $estadisticas['total_inscripciones'] }}
                            </h3>
                            <p class="text-gray-500">Total Inscripciones</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-3xl font-bold text-purple-400">
                                {{ round($estadisticas['total_inscripciones'] / max(1, $estadisticas['total_cursos']), 1) }}
                            </h3>
                            <p class="text-gray-500">Promedio por Curso</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-3xl font-bold text-teal-500">
                                {{ $estadisticas['total_estudiantes_unicos'] }}</h3>
                            <p class="text-gray-500">Estudiantes Únicos</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Sin cursos asignados -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No tienes cursos asignados</h3>
                <p class="text-gray-500">Contacta con el administrador para que te asigne cursos.</p>
            </div>
        @endif
    </div>
</body>

</html>