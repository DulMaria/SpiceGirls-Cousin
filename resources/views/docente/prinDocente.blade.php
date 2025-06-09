<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Docente</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons (versión CDN) -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Estilos personalizados */
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar-item.active {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .progress-ring {
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div id="app" class="flex h-screen bg-gray-100">  
        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top header -->
            <header class="bg-white border-b border-gray-200 p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="clock" class="w-5 h-5 text-purple-600 mr-2"></i>
                    <span class="text-gray-600">Hoy: <span id="current-date"></span></span>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="bg-purple-100 text-purple-800 px-4 py-2 rounded-lg hover:bg-purple-200 transition-colors">
                        Mi perfil
                    </button>
                </div>
            </header>
            
            <!-- Main dashboard -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <div class="border-b pb-4 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <h1 class="text-2xl sm:text-3xl font-bold text-[#2e1a47] leading-tight">Mi Panel de Docente</h1>
                    <span class="text-sm text-gray-500">Bienvenido a tu espacio personal, Prof. Demo</span>
                </div>
                
                <!-- Información personal del docente - Tarjeta 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex justify-between items-start">
                            <div class="w-full">
                                <h3 class="text-lg font-semibold text-purple-900 mb-4">Datos Personales</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Nombre:</span>
                                        <span class="font-medium">Profesor Demo</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Apellidos:</span>
                                        <span class="font-medium">Apellido Apellido</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">CI:</span>
                                        <span class="font-medium">12345678</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Email:</span>
                                        <span class="font-medium">profesor.demo@universidad.edu</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-32">Teléfono:</span>
                                        <span class="font-medium">+591 77777777</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <i data-lucide="user" class="h-6 w-6 text-purple-900"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información adicional del docente - Tarjeta 2 -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex justify-between items-start">
                            <div class="w-full">
                                <h3 class="text-lg font-semibold text-purple-900 mb-4">Información Adicional</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-40">Código Docente:</span>
                                        <span class="font-medium">DOC-2024</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-40">Especialidad:</span>
                                        <span class="font-medium">Matemáticas Avanzadas</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-40">Departamento:</span>
                                        <span class="font-medium">Ciencias Exactas</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-500 w-40">Antigüedad:</span>
                                        <span class="font-medium">5 años</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <i data-lucide="award" class="h-6 w-6 text-purple-900"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Panel de estadísticas -->
                <div class="bg-white rounded-2xl p-6 shadow-md mb-8">
                    <h3 class="text-lg font-semibold text-purple-900 mb-4">Mi Actividad Docente</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Asignaciones completadas -->
                        <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-teal-700">Asistencias</span>
                                <span class="text-xs bg-teal-100 text-teal-700 px-2 py-1 rounded-full">95%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-teal-700 h-2 rounded-full" style="width: 95%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">19 de 20 clases impartidas</p>
                        </div>

                        <!-- Evaluaciones realizadas -->
                        <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-teal-700">Evaluaciones</span>
                                <span class="text-xs bg-teal-100 text-teal-700 px-2 py-1 rounded-full">80%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-teal-700 h-2 rounded-full" style="width: 80%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">16 de 20 evaluaciones calificadas</p>
                        </div>

                        <!-- Material compartido -->
                        <div class="bg-teal-50 rounded-lg p-4 border border-teal-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-teal-700">Material Compartido</span>
                                <span class="text-xs bg-teal-100 text-teal-700 px-2 py-1 rounded-full">12</span>
                            </div>
                            <p class="text-sm font-medium text-teal-700">Recursos didácticos</p>
                            <p class="text-xs text-gray-500 mt-1">Documentos, presentaciones, etc.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Resumen de cursos -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total de cursos -->
                    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-purple-600">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-bold text-gray-700 mb-2">Total de Cursos</h3>
                                <p class="text-3xl font-bold text-purple-800">5</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i data-lucide="book" class="h-6 w-6 text-purple-800"></i>
                            </div>
                        </div>
                        <button class="mt-4 w-full py-2 bg-purple-100 text-purple-800 rounded font-medium hover:bg-purple-200 transition-colors">
                            Ver Mis Cursos
                        </button>
                    </div>
                    
                    <!-- Estudiantes activos -->
                    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-teal-500">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-bold text-gray-700 mb-2">Estudiantes Activos</h3>
                                <p class="text-3xl font-bold text-teal-600">87</p>
                            </div>
                            <div class="bg-teal-100 p-3 rounded-full">
                                <i data-lucide="users" class="h-6 w-6 text-teal-700"></i>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            <p>En 5 grupos diferentes</p>
                        </div>
                    </div>
                    
                    <!-- Horas de clase -->
                    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-purple-600">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-bold text-gray-700 mb-2">Horas de Clase</h3>
                                <p class="text-3xl font-bold text-purple-800">24</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i data-lucide="clock" class="h-6 w-6 text-purple-800"></i>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            <p>Por semana lectiva</p>
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
                                    <th class="py-3 px-4 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">
                                        Curso
                                    </th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">
                                        Nivel
                                    </th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">
                                        Horario
                                    </th>
                                    <th class="py-3 px-4 text-left text-xs font-medium text-purple-800 uppercase tracking-wider">
                                        Progreso
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Matemáticas Avanzadas</div>
                                        <div class="text-sm text-gray-500">Cálculo Multivariable</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Tercer Año</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Lunes y Miércoles</div>
                                        <div class="text-xs text-gray-500">09:00 - 11:00</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                            <div class="bg-teal-700 h-2 rounded-full" style="width: 75%"></div>
                                        </div>
                                        <div class="text-xs text-gray-500">75% completado</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Álgebra Lineal</div>
                                        <div class="text-sm text-gray-500">Matrices y Vectores</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Segundo Año</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Martes y Jueves</div>
                                        <div class="text-xs text-gray-500">14:00 - 16:00</div>
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                            <div class="bg-teal-700 h-2 rounded-full" style="width: 60%"></div>
                                        </div>
                                        <div class="text-xs text-gray-500">60% completado</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Inicializar los íconos de Lucide
        lucide.createIcons();
        
        // Mostrar la fecha actual
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('es-ES', options);
        
        // Simular funcionalidad de tabs (puedes mejorar esto)
        document.querySelectorAll('.sidebar-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                
                // Aquí podrías cargar contenido diferente según la pestaña seleccionada
                console.log('Cambiando a:', this.querySelector('span').textContent);
            });
        });
    </script>
</body>
</html>