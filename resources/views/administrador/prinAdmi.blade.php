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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                    <!-- es una cuadrícula de 4 columnas -->
                    <!-- Curso más cursado -->
                    <!-- Curso más cursado -->
                    <div class="bg-white rounded-xl shadow-md p-6 transition-transform duration-300 hover:scale-105">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-sm text-gray-500">Curso más cursado</h3>
                                <p class="text-2xl font-semibold text-purple-900">{{ $cursoMasCursado ?? 'Sin datos' }}
                                </p>
                                <p class="text-green-500 mt-1 text-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    +{{ $porcentajeMasCursado ?? '0' }}% este mes
                                </p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-900" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-900" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
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
                                    <p class="text-lg text-purple-900 font-semibold">Mujeres:
                                        {{ $distribucion['mujeres'] ?? 0 }}%</p>
                                    <p class="text-lg text-purple-700 font-semibold">Hombres:
                                        {{ $distribucion['hombres'] ?? 0 }}%</p>
                                    @if (isset($distribucion['otros']) && $distribucion['otros'] > 0)
                                        <p class="text-lg text-purple-500 font-semibold">Otros:
                                            {{ $distribucion['otros'] }}%</p>
                                    @endif
                                </div>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-900" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-purple-900 h-2.5 rounded-full"
                                    style="width: {{ $distribucion['mujeres'] ?? 0 }}%"></div>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    +8% comparado al ciclo anterior
                                </p>
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

                <!-- Filtros y gráfico de inscripciones-->

                <!--<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                    <div>
                    <h2 class="text-xl font-semibold text-gray-800">Inscripciones</h2>
                    <p class="text-sm text-gray-500">Filtra por categoría y rango de fechas</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                    <button id="btnInscripciones" class="px-3 py-1 rounded-md border border-gray-300 bg-black text-white text-sm font-medium focus:outline-none focus:ring">Inscripciones</button>
                    <button id="btnGraduados" class="px-3 py-1 rounded-md border border-gray-300 bg-white text-sm font-medium hover:bg-gray-100">Graduados</button>
                    <button id="btnTotales" class="px-3 py-1 rounded-md border border-gray-300 bg-white text-sm font-medium hover:bg-gray-100">Totales</button><!-- este es para -->
                <!--<input type="date" id="startDate" class="px-2 py-1 border border-gray-300 rounded-md text-sm">
                    <input type="date" id="endDate" class="px-2 py-1 border border-gray-300 rounded-md text-sm">
                    </div>
                </div>
                <canvas id="inscripcionesChart" height="100"></canvas>
                </div>-->


                <!-- Gráfico de Pagos con responsividad mejorada
                    <div class="mt-8 bg-white rounded-2xl p-4  shadow-md">
                        <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Pagos Recibidos por Tipo</h2>

                         Filtros con mejor adaptación a móviles
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-4 sm:mb-6">
                           <div class="w-full">
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
                            </div>
                        </div>-->

                <!-- Contenedor del gráfico con altura responsiva
                        <div class="relative" style="height: 580px;">
                            <canvas id="graficaPagos"></canvas>
                        </div>
                    </div>-->


                <!-- Cursos populares -->
                <div class="mt-8 bg-white rounded-2xl p-6 shadow-md">
                    <div class="bg-white p-4 rounded shadow mt-4">
                        <h2 class="text-xl font-semibold mb-4">Cursos Populares</h2>
                        <div id="chart-cursos-populares" style="height: 360px;"></div>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Estadísticas de rendimiento y tendencias   Tendencia de graduados
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Tendencia de Graduados</h3>
                    <div class="relative h-64">
                    <canvas id="graduadosChart"></canvas>
                    </div>
                </div>-->
                    <!-- Distribución de edades -->
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">Distribución por Edades</h3>
                        <div class="relative h-100"> <!-- Aumenté la altura para mejor visualización -->
                            <div id="chart-edades" class="w-full h-full"></div>
                        </div>
                    </div>

                    <!-- Distribución por género -->
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">Distribución por Género</h3>
                        <div class="relative h-100"> <!-- Aumenté la altura para mejor visualización -->
                            <div id="chart-genero" class="w-full h-full"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Scripts para los gráficos - Asegúrate de cargar Chart.js primero -->
            <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>-->
@push('scripts')
 <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

 <script>
    // Grafica de cursos populares
    document.addEventListener("DOMContentLoaded", () => {
        const nombres = @json($nombres ?? []);
        const inscritos = @json($inscritos ?? []);

        // Paleta de colores púrpura (6 tonos)
        const coloresPurpura = [
            '#4C1D95', '#5B21B6', '#6D28D9',
            '#7C3AED', '#8B5CF6', '#A78BFA'
        ];

        const options = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: true,
                    tools: {
                        download: true, // Mostrar solo el botón de descarga
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    },
                    export: {
                        csv: {
                            filename: 'Cursos-Populares',
                            columnDelimiter: ',',
                            headerCategory: 'Curso',
                            headerValue: 'Inscritos',
                        },
                        svg: {
                            filename: 'Cursos-Populares',
                        },
                        png: {
                            filename: 'Cursos-Populares',
                        }
                    }
                }
            },
            series: [{
                name: 'Inscritos',
                data: inscritos
            }],
            xaxis: {
                categories: nombres,
                labels: {
                    style: {
                        fontSize: '12px',
                        colors: '#6B7280'
                    },
                    formatter: function(value) {
                        // Acortar nombres muy largos
                        return value.length > 20 ? value.substring(0, 18) + '...' : value;
                    }
                },
                axisBorder: {
                    show: false
                }
            },
            yaxis: {
                min: 0,
                labels: {
                    style: {
                        colors: '#6B7280'
                    }
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 7.5,
                    columnWidth: '60%',
                    distributed: true
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: coloresPurpura,
            grid: {
                borderColor: '#E5E7EB',
                strokeDashArray: 5,
                padding: {
                    top: 0,
                    right: 60,
                    bottom: 0,
                    left: 20
                }
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value + ' inscritos';
                    }
                }
            }
            
        };

        const chart = new ApexCharts(
            document.querySelector("#chart-cursos-populares"),
            options
        );
        chart.render();
    });

    // * * * * * * Gráfico de distribución por género * * * * * * * * * *//
    document.addEventListener("DOMContentLoaded", () => {
        // Convierte los datos PHP a variables JavaScript
        const distribucion = @json($distribucion ?? []);
        
        const generoChart = {
            chart: {
                type: 'donut',
                height: 350,
                toolbar: {
                    show: true,
                    tools: {
                        download: true, // Añadido botón de descarga
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    },
                    export: {
                        csv: {
                            filename: 'Distribucion-Genero',
                            columnDelimiter: ',',
                            headerCategory: 'Genero',
                            headerValue: 'Porcentaje',
                        },
                        svg: {
                            filename: 'Distribucion-Genero',
                        },
                        png: {
                            filename: 'Distribucion-Genero',
                        }
                    }
                }
            },
            series: [
                parseFloat(distribucion.mujeres || 0),
                parseFloat(distribucion.hombres || 0),
                parseFloat(distribucion.otros || 0)
            ],
            labels: ['Mujer', 'Hombre', 'Otro'],
            colors: ['#9D4EDD', '#0077B6', '#90E0EF'], // Cambiado a lila oscuro, verde azulado y celeste
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                formatter: function(val, opts) {
                    return val.toFixed(1) + "%";
                }
            },
            tooltip: {
                y: {
                    formatter: function(val, opts) {
                        // Obtener el índice de la serie actual
                        const seriesIndex = opts.seriesIndex;

                        // Array con las cantidades absolutas
                        const cantidades = [
                            distribucion.mujeres_cantidad || 0,
                            distribucion.hombres_cantidad || 0,
                            distribucion.otros_cantidad || 0
                        ];

                        // Mostrar la cantidad absoluta según el índice
                        return cantidades[seriesIndex] + " personas";
                    }
                }
            }
        };

        new ApexCharts(
            document.querySelector("#chart-genero"),
            generoChart
        ).render();
    });

    //DISTRIBUCIÓN DE EDADES
    document.addEventListener("DOMContentLoaded", () => {
        const edadesChart = {
            chart: {
                type: 'donut',
                height: 350,
                toolbar: {
                    show: true,
                    tools: {
                        download: true, // Añadido botón de descarga
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    },
                    export: {
                        csv: {
                            filename: 'Distribucion-Edades',
                            columnDelimiter: ',',
                            headerCategory: 'Rango-Edad',
                            headerValue: 'Porcentaje',
                        },
                        svg: {
                            filename: 'Distribucion-Edades',
                        },
                        png: {
                            filename: 'Distribucion-Edades',
                        }
                    }
                }
            },
            series: @json($rangoValores ?? []),
            labels: @json($rangoLabels ?? []),
            colors: ['#6D28D9', '#9333EA', '#A855F7', '#C084FC', '#DDD6FE'],
            legend: {
                position: 'bottom'
            },

            dataLabels: {
                formatter: function(val) {
                    return val.toFixed(1) + "%";
                }
            },
            tooltip: {
                custom: function({
                    series,
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    // Obtener el contenido original del tooltip (como "18-24: 17")
                    const label = w.config.labels[seriesIndex];
                    const value = w.globals.series[seriesIndex];

                    // Simplemente añadir la palabra "personas" al final
                    return `<div class="apexcharts-tooltip-title">${label}: ${value} personas</div>`;
                }
            }
        };

        new ApexCharts(document.querySelector("#chart-edades"), edadesChart).render();
    });
</script>
@stack('scripts')
