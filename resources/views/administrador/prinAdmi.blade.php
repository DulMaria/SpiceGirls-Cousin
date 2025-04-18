<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Fundación Criminología</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

    <!-- Menú lateral -->
    @include('partials.navAdmi') 

    <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilAdmin')        

        <!-- Contenido principal -->
        <main class="flex-1 px-4 py-6 md:px-10 md:py-8 mt-0">
            <div class="border-b pb-4 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <h1 class="text-2xl sm:text-3xl font-bold text-[#2e1a47] leading-tight">Panel de Administración</h1>
                <span class="text-sm text-gray-500">Bienvenido al sistema de gestión</span>
            </div>

    <!-- Dashboard mejorado de estadísticas -->
        <section class="mt-10 px-4">
            <!-- Tarjetas de resumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10"> <!-- es una cuadrícula de 4 columnas -->
                <!-- Curso más cursado -->
                <div class="bg-white rounded-xl shadow-md p-6 transition-transform duration-300 hover:scale-105">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-sm text-gray-500">Curso más cursado</h3>
                            <p class="text-2xl font-semibold text-purple-900">Criminología Forense</p>
                            <p class="text-green-500 mt-1 text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                +15% este mes
                            </p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Distribución de edades -->
                <div class="bg-white rounded-xl shadow-md p-6 transition-transform duration-300 hover:scale-105">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-sm text-gray-500">Distribución de Edades</h3>
                            <p class="text-2xl font-semibold text-purple-900">25-34 años</p>
                            <p class="text-gray-500 mt-1 text-sm">42% de los estudiantes</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 pt-2 border-t border-gray-100">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>18-24</span>
                            <span>25-34</span>
                            <span>35-44</span>
                            <span>45-70</span>
                        </div>
                        <div class="flex h-2 rounded-full overflow-hidden">
                            <div class="bg-purple-300 w-3/12"></div>
                            <div class="bg-purple-900 w-5/12"></div>
                            <div class="bg-purple-700 w-3/12"></div>
                            <div class="bg-purple-500 w-1/12"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Género -->
                <div class="bg-white rounded-xl shadow-md p-6 transition-transform duration-300 hover:scale-105">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-sm text-gray-500">Distribución por Género</h3>
                            <div class="flex flex-col gap-1 mt-2">
                                <p class="text-lg text-purple-900 font-semibold">Mujeres: 56%</p>
                                <p class="text-lg text-purple-700 font-semibold">Hombres: 44%</p>
                            </div>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-purple-900 h-2.5 rounded-full" style="width: 56%"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Graduados -->
                <div class="bg-white rounded-xl shadow-md p-6 transition-transform duration-300 hover:scale-105">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-sm text-gray-500">Estudiantes Graduados</h3>
                            <p class="text-3xl font-semibold text-purple-900">456</p>
                            <p class="text-green-500 mt-1 text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                +8% comparado al ciclo anterior
                            </p>
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

           <!-- Filtros y gráfico de inscripciones -->
                <div class="mt-8 bg-white rounded-2xl p-6 shadow-md">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                    <div>
                    <h2 class="text-xl font-semibold text-gray-800">Inscripciones</h2>
                    <p class="text-sm text-gray-500">Filtra por categoría y rango de fechas</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                    <button id="btnInscripciones" class="px-3 py-1 rounded-md border border-gray-300 bg-black text-white text-sm font-medium focus:outline-none focus:ring">Inscripciones</button>
                    <button id="btnGraduados" class="px-3 py-1 rounded-md border border-gray-300 bg-white text-sm font-medium hover:bg-gray-100">Graduados</button>
                    <button id="btnTotales" class="px-3 py-1 rounded-md border border-gray-300 bg-white text-sm font-medium hover:bg-gray-100">Totales</button><!-- este es para -->
                    <!--<input type="date" id="startDate" class="px-2 py-1 border border-gray-300 rounded-md text-sm">
                    <input type="date" id="endDate" class="px-2 py-1 border border-gray-300 rounded-md text-sm">-->
                    </div>
                </div>
                <canvas id="inscripcionesChart" height="100"></canvas>
                </div>
              <!-- Gráfico de Pagos con responsividad mejorada -->
                    <div class="mt-8 bg-white rounded-2xl p-4  shadow-md">
                        <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Pagos Recibidos por Tipo</h2>

                        <!-- Filtros con mejor adaptación a móviles -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-4 sm:mb-6">
                          <!--  <div class="w-full">
                                <label class="text-xs sm:text-sm font-medium block mb-1">Fecha:</label>
                                <input type="month" id="filterDate" class="w-full p-1.5 sm:p-2 border rounded-md text-sm" />
                            </div>
                            <div class="w-full">
                                <label class="text-xs sm:text-sm font-medium block mb-1">Curso:</label>
                                <select id="filterCurso" class="w-full p-1.5 sm:p-2 border rounded-md text-sm">
                                    <option value="todos">Todos</option>
                                    <option value="criminologia">Criminología</option>
                                    <option value="psicologia">Psicología</option>
                                </select>
                            </div>
                            <div class="w-full">
                                <label class="text-xs sm:text-sm font-medium block mb-1">Tipo de Pago:</label>
                                <select id="filterTipo" class="w-full p-1.5 sm:p-2 border rounded-md text-sm">
                                    <option value="todos">Todos</option>
                                    <option value="completo">Pago Completo</option>
                                    <option value="beca">Pago con Beca</option>
                                    <option value="oferta">Pago con Oferta</option>
                                </select>
                            </div>-->
                        </div>

                        <!-- Contenedor del gráfico con altura responsiva -->
                        <div class="relative" style="height: 580px;">
                            <canvas id="graficaPagos"></canvas>
                        </div>
                    </div>


                <!-- Cursos populares -->
                <div class="mt-8 bg-white rounded-2xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Cursos Más Populares</h3>
                    <div class="relative "style="height: 450px;">
                        <canvas id="cursosChart"></canvas>
                    </div>
                </div>

                <!-- Estadísticas de rendimiento y tendencias -->
                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Tendencia de graduados -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Tendencia de Graduados</h3>
                    <div class="relative h-64">
                    <canvas id="graduadosChart"></canvas>
                    </div>
                </div>
                <!-- Distribución de edades -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Distribución por Edades</h3>
                    <div class="relative h-64">
                    <canvas id="edadesChart"></canvas>
                    </div>
                </div>
                <!-- Distribución por género -->
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Distribución por Género</h3>
                    <div class="relative h-64">
                    <canvas id="generoChart"></canvas>
                    </div>
                </div>
                </div>
        </section>

<!-- Scripts para los gráficos - Asegúrate de cargar Chart.js primero -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function() {
    // Colores consistentes para gráficos
    const purpleColor = '#5B21B6';
    const purpleLightColor = 'rgba(91, 33, 182, 0.2)';
    const purplePalette = ['#5B21B6', '#7C3AED', '#8B5CF6', '#A78BFA', '#C4B5FD'];
    
    // Gráfico de inscripciones mensuales (línea)
    const ctxInscripciones = document.getElementById('inscripcionesChart').getContext('2d');

    const dataSets = {
        inscripciones: {
            label: 'Inscripciones',
            data: [50, 40, 60, 45, 70, 80, 90, 100, 110, 120, 140, 130],
            borderColor: '#7c3aed',
            backgroundColor: 'rgba(124, 58, 237, 0.1)',
            fill: true,
            tension: 0.4
        },
        graduados: {
            label: 'Graduados',
            data: [20, 25, 30, 35, 50, 45, 55, 60, 65, 70, 85, 90],
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            fill: true,
            tension: 0.4
        },
        totales: {
            label: 'Totales',
            data: [100, 110, 120, 130, 135, 140, 150, 160, 170, 180, 190, 200],
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            fill: true,
            tension: 0.4
        }
    };

    const chartConfig = {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [dataSets.inscripciones]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 50
                    }
                }
            }
        }
    };

    const inscripcionesChart = new Chart(ctxInscripciones, chartConfig);

    // Botones para cambiar dataset
    document.getElementById('btnInscripciones').addEventListener('click', () => {
        inscripcionesChart.data.datasets = [dataSets.inscripciones];
        inscripcionesChart.update();
    });

    document.getElementById('btnGraduados').addEventListener('click', () => {
        inscripcionesChart.data.datasets = [dataSets.graduados];
        inscripcionesChart.update();
    });

    document.getElementById('btnTotales').addEventListener('click', () => {
        inscripcionesChart.data.datasets = [dataSets.totales];
        inscripcionesChart.update();
    });

    // Gráfico para pagos
    const ctxPagos = document.getElementById('graficaPagos').getContext('2d');

    const graficaPagosConfig = {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago'],
            datasets: [
                {
                    label: 'Pago Completo',
                    data: [1200, 1500, 1400, 1600, 1550, 1700, 1650, 1800],
                    borderColor: 'pinck',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                },
                {
                    label: 'Pago con Beca',
                    data: [400, 450, 500, 480, 470, 490, 520, 530],
                    borderColor: 'blue',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                },
                {
                    label: 'Pago con Oferta',
                    data: [300, 350, 330, 360, 340, 370, 380, 400],
                    borderColor: 'purple',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Monto en $'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mes'
                    }
                }
            }
        }
    };

    const graficaPagos = new Chart(ctxPagos, graficaPagosConfig);

    // Lógica para actualizar con filtros (opcional)
    document.querySelectorAll('#filterDate, #filterCurso, #filterTipo').forEach(f => {
        f.addEventListener('change', () => {
            // Aquí puedes aplicar tu lógica para filtrar y actualizar los datos dinámicamente.
            console.log("Actualizar datos según los filtros");
        });
    });

    // Gráfico de cursos populares (barras)
    const cursosCtx = document.getElementById('cursosChart').getContext('2d');
    const cursosChart = new Chart(cursosCtx, {
        type: 'bar',
        data: {
            labels: ['Auxiliar de Criminalística', 'Auxiliar de Medicina Forense', 'Auxiliares de Psicomotricidad', 'Técnico en Ciencias Forenses', 'Investigador de Accidentes', 'Investigador de Crímenes', 
            'Auxiliar de Laboratorio Forense', 'Auxiliar en Odontología Forense', 'Prótesis Dental','Técnico en Criminalística Forense','Investigación Forense en Accidentes de Tráfico','Toxicología Forense'],
            datasets: [{
                label: 'Estudiantes',
                data: [50, 250, 80, 200, 90, 60, 40, 120, 60, 180, 110, 130], // Datos de estudiantes por curso
                backgroundColor: purpleColor,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#2e1a47'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6B7280'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6B7280',
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });

    // Gráfico de tendencia de graduados (línea)
    const graduadosCtx = document.getElementById('graduadosChart').getContext('2d');
    const graduadosChart = new Chart(graduadosCtx, {
        type: 'line',
        data: {
            labels: ['2020', '2021', '2022', '2023', '2024'],
            datasets: [{
                label: 'Graduados',
                data: [125, 210, 310, 380, 456], // Datos de graduados por año
                backgroundColor: 'transparent',
                borderColor: purpleColor,
                borderWidth: 3,
                pointBackgroundColor: purpleColor
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de distribución por edades (dona)
    const edadesCtx = document.getElementById('edadesChart').getContext('2d');
    const edadesChart = new Chart(edadesCtx, {
        type: 'doughnut',
        data: {
            labels: ['16-24 años', '25-34 años', '35-44 años', '45-70 años'],
            datasets: [{
                data: [25, 42, 23, 10], // ejemplo de datos de distribución por edades
                backgroundColor: purplePalette,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            },
            cutout: '60%' // es opcional, puedes ajustar el tamaño del agujero en el centro
        }
    });

    // Gráfico de distribución por género (pie)
    const generoCtx = document.getElementById('generoChart').getContext('2d');
    const generoChart = new Chart(generoCtx, {
        type: 'pie',
        data: {
            labels: ['Mujeres', 'Hombres'],
            datasets: [{
                data: [56, 44],
                backgroundColor: [purplePalette[0], purplePalette[2]],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>