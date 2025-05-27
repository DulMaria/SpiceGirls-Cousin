<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Estudiantil 8AM - 8PM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .clase-block {
            transition: all 0.2s ease;
        }
        .clase-block:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 20;
        }
        .hora-cell {
            height: 3rem; /* 48px */
        }
        @media (min-width: 768px) {
            .hora-cell {
                height: 4rem; /* 64px */
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-200 min-h-screen font-sans text-gray-800">
    <!-- Menú lateral -->
    @include('partials.navEstudiante')

    <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilAdmin')
    <div class="container mx-auto max-w-6xl">
        <!-- Componente del Calendario -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Encabezado con controles -->
            <div class="flex flex-col md:flex-row justify-between items-center p-6 bg-gradient-to-r from-[#2e1a47] to-[#127475] text-white">
                <h2 class="text-2xl font-bold mb-4 md:mb-0">Horario Estudiantil</h2>
                <div class="flex items-center space-x-2 md:space-x-4">
                    <button onclick="prevWeek()" class="px-3 py-1 md:px-4 md:py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition flex items-center">
                        <i class="fas fa-chevron-left mr-1"></i>
                        <span class="hidden md:inline">Anterior</span>
                    </button>
                    <span id="semana-actual" class="font-medium text-center min-w-[180px] md:min-w-[220px]">
                        25 May - 27 May
                    </span>
                    <button onclick="nextWeek()" class="px-3 py-1 md:px-4 md:py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition flex items-center">
                        <span class="hidden md:inline">Siguiente</span>
                        <i class="fas fa-chevron-right ml-1"></i>
                    </button>
                </div>
            </div>

            <!-- Calendario -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Cabecera de días -->
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 border text-center font-semibold text-[#2e1a47]">Hora</th>
                            <th class="p-3 border text-center font-semibold text-[#2e1a47]">
                                <div>Viernes</div>
                                <div id="viernes-fecha" class="text-sm font-normal text-gray-600">25 May</div>
                            </th>
                            <th class="p-3 border text-center font-semibold text-[#2e1a47]">
                                <div>Sábado</div>
                                <div id="sabado-fecha" class="text-sm font-normal text-gray-600">26 May</div>
                            </th>
                            <th class="p-3 border text-center font-semibold text-[#2e1a47]">
                                <div>Domingo</div>
                                <div id="domingo-fecha" class="text-sm font-normal text-gray-600">27 May</div>
                            </th>
                        </tr>
                    </thead>
                    
                    <!-- Cuerpo del calendario -->
                    <tbody>
                        <!-- Generar filas de 8:00 a 20:00 -->
                        <script>
                            // Datos de clases estáticas
                            const horarioClases = {
                                'Viernes': {
                                    '10:00': { materia: 'Programación Web', aula: 'A-302', docente: 'Lic. Pérez', color: 'bg-[#127475]' },
                                    '14:00': { materia: 'Bases de Datos', aula: 'Lab-4', docente: 'Ing. Gómez', color: 'bg-[#2e1a47]' },
                                    '16:00': { materia: 'Matemáticas', aula: 'B-105', docente: 'Dr. Rodríguez', color: 'bg-purple-600' },
                                    '18:00': { materia: 'Taller Práctico', aula: 'Lab-1', docente: 'Ing. Torres', color: 'bg-blue-600' }
                                },
                                'Sábado': {
                                    '8:00': { materia: 'Inglés Técnico', aula: 'C-201', docente: 'Prof. Smith', color: 'bg-blue-600' },
                                    '12:00': { materia: 'Redes', aula: 'Lab-3', docente: 'Ing. López', color: 'bg-[#127475]' },
                                    '15:00': { materia: 'Sistemas Operativos', aula: 'Lab-2', docente: 'Ing. Castro', color: 'bg-[#2e1a47]' },
                                    '19:00': { materia: 'Ética Profesional', aula: 'A-205', docente: 'Dra. Martínez', color: 'bg-purple-600' }
                                },
                                'Domingo': {
                                    '9:00': { materia: 'Proyecto Integrador', aula: 'A-301', docente: 'Lic. Fernández', color: 'bg-[#127475]' },
                                    '11:00': { materia: 'Seminario', aula: 'Auditorio', docente: 'Mg. Vargas', color: 'bg-[#2e1a47]' },
                                    '16:00': { materia: 'Tutoría', aula: 'A-103', docente: 'Lic. Pérez', color: 'bg-blue-600' }
                                }
                            };

                            // Generar filas del horario
                            document.write(Array.from({length: 13}, (_, i) => {
                                const hora = i + 8; // Desde las 8:00
                                const horaFormatted = `${hora}:00`;
                                
                                return `
                                <tr class="border-b">
                                    <td class="p-2 border-r text-center bg-gray-50 font-medium hora-cell">${horaFormatted}</td>
                                    <td class="p-0 border-r relative hora-cell">
                                        ${renderClase('Viernes', horaFormatted)}
                                    </td>
                                    <td class="p-0 border-r relative hora-cell">
                                        ${renderClase('Sábado', horaFormatted)}
                                    </td>
                                    <td class="p-0 relative hora-cell">
                                        ${renderClase('Domingo', horaFormatted)}
                                    </td>
                                </tr>
                                `;
                            }).join(''));

                            function renderClase(dia, hora) {
                                const clase = horarioClases[dia] && horarioClases[dia][hora];
                                if (!clase) return '';
                                
                                return `
                                <div class="absolute inset-1 ${clase.color} text-white rounded-md shadow-sm flex flex-col justify-center p-1 overflow-hidden clase-block" title="${clase.materia} - ${clase.aula} - ${clase.docente}">
                                    <div class="text-xs font-bold truncate">${clase.materia}</div>
                                    <div class="text-[0.6rem] opacity-90 truncate">${clase.aula}</div>
                                    <div class="text-[0.6rem] opacity-90 truncate">${clase.docente}</div>
                                </div>
                                `;
                            }
                        </script>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Leyenda -->
        <div class="mt-6 p-4 bg-white rounded-lg shadow">
            <h3 class="text-lg font-semibold text-[#2e1a47] mb-3">Leyenda de Materias</h3>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-[#127475] rounded mr-2"></div>
                    <span class="text-sm">Programación</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-[#2e1a47] rounded mr-2"></div>
                    <span class="text-sm">Bases de Datos</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-purple-600 rounded mr-2"></div>
                    <span class="text-sm">Matemáticas</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-600 rounded mr-2"></div>
                    <span class="text-sm">Inglés/Ética</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-gray-400 rounded mr-2"></div>
                    <span class="text-sm">Sin clase</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Funciones para navegación semanal
        let currentDate = new Date();
        
        function updateCalendarDates() {
            const days = getWeekDays(currentDate);
            document.getElementById('semana-actual').textContent = 
                `${formatDate(days[0])} - ${formatDate(days[2])}`;
            document.getElementById('viernes-fecha').textContent = formatDate(days[0]);
            document.getElementById('sábado-fecha').textContent = formatDate(days[1]);
            document.getElementById('domingo-fecha').textContent = formatDate(days[2]);
        }
        
        function getWeekDays(date) {
            const days = [];
            const currentDay = new Date(date);
            
            // Encuentra el jueves de la semana actual
            const dayOfWeek = currentDay.getDay();
            const diff = dayOfWeek <= 4 ? 4 - dayOfWeek : 4 - dayOfWeek + 7;
            currentDay.setDate(currentDay.getDate() + diff);
            
            // Agrega jueves, viernes y sábado
            for (let i = 0; i < 3; i++) {
                const day = new Date(currentDay);
                day.setDate(currentDay.getDate() + i);
                days.push(day);
            }
            return days;
        }
        
        function formatDate(date) {
            return date.toLocaleDateString('es-ES', {
                day: 'numeric',
                month: 'short'
            });
        }
        
        function prevWeek() {
            currentDate.setDate(currentDate.getDate() - 7);
            updateCalendarDates();
        }
        
        function nextWeek() {
            currentDate.setDate(currentDate.getDate() + 7);
            updateCalendarDates();
        }
        
        // Inicializar
        document.addEventListener('DOMContentLoaded', updateCalendarDates);
    </script>
</body>
</html>