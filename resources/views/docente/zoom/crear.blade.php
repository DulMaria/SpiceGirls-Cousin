<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Reunión Zoom</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Configuración personalizada de Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'morado-oscuro': '#4C1D95',
                        'morado-medio': '#7C3AED',
                        'morado-claro': '#A78BFA',
                        'verde-azulado': '#0D9488',
                        'verde-azulado-claro': '#2DD4BF',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Menú lateral -->
    @include('partials.navDocente')
    <div class="container mx-auto px-4 py-8">
        <!-- Header móvil -->
        @include('partials.headerMovilAdmin')
        <!-- Formulario de creación -->
        <div id="form-container" class="max-w-md mx-auto bg-white rounded-lg shadow-xl overflow-hidden border border-morado-claro">
            <!-- Encabezado con color morado -->
            <div class="bg-morado-medio px-6 py-4">
                <h2 class="text-xl font-bold text-white">
                    <i class="fas fa-video mr-2"></i>Crear Reunión Zoom
                </h2>
            </div>
            
            <!-- Formulario -->
            <form id="meeting-form" class="p-6">
                <!-- Campo Tema -->
                <div class="mb-4">
                    <label for="topic" class="block text-sm font-medium text-morado-oscuro mb-2">
                        Tema de la reunión
                    </label>
                    <input type="text" id="topic" name="topic" 
                           class="w-full px-3 py-2 border border-morado-claro rounded-md focus:outline-none focus:ring-2 focus:ring-morado-medio focus:border-transparent"
                           placeholder="Ej: Clase de Matemáticas" required>
                </div>

                <!-- Campo Fecha/Hora -->
                <div class="mb-4">
                    <label for="start_time" class="block text-sm font-medium text-morado-oscuro mb-2">
                        Fecha y hora de inicio
                    </label>
                    <input type="datetime-local" id="start_time" name="start_time"
                           class="w-full px-3 py-2 border border-morado-claro rounded-md focus:outline-none focus:ring-2 focus:ring-morado-medio focus:border-transparent"
                           required>
                </div>

                <!-- Campo Duración -->
                <div class="mb-4">
                    <label for="duration" class="block text-sm font-medium text-morado-oscuro mb-2">
                        Duración (minutos)
                    </label>
                    <select id="duration" name="duration" 
                            class="w-full px-3 py-2 border border-morado-claro rounded-md focus:outline-none focus:ring-2 focus:ring-morado-medio focus:border-transparent">
                        <option value="30">30 minutos</option>
                        <option value="60" selected>1 hora</option>
                        <option value="90">1.5 horas</option>
                        <option value="120">2 horas</option>
                    </select>
                </div>

                <!-- Campo Descripción (opcional) -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-morado-oscuro mb-2">
                        Descripción (opcional)
                    </label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-2 border border-morado-claro rounded-md focus:outline-none focus:ring-2 focus:ring-morado-medio focus:border-transparent"
                              placeholder="Descripción de la reunión..."></textarea>
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Botón Programar (morado) -->
                    <button type="submit" 
                            class="flex-1 bg-morado-medio text-white py-2 px-4 rounded-md hover:bg-morado-oscuro transition duration-300 shadow-md hover:shadow-lg flex items-center justify-center">
                        <i class="fas fa-calendar-plus mr-2"></i>Programar Reunión
                    </button>
                    
                    <!-- Botón Iniciar Ahora (verde azulado) -->
                    <button type="button" id="start-now-btn"
                            class="flex-1 bg-verde-azulado text-white py-2 px-4 rounded-md hover:bg-verde-azulado-claro transition duration-300 shadow-md hover:shadow-lg flex items-center justify-center">
                        <i class="fas fa-play mr-2"></i>Iniciar Ahora
                    </button>
                </div>
            </form>
        </div>

        <!-- Resultado de la reunión creada (inicialmente oculto) -->
        <div id="meeting-result" class="max-w-2xl mx-auto bg-white rounded-lg shadow-xl overflow-hidden border border-green-400 mt-8 hidden">
            <div class="bg-green-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white">
                    <i class="fas fa-check-circle mr-2"></i>¡Reunión Creada Exitosamente!
                </h2>
            </div>
            
            <div class="p-6">
                <div id="meeting-details" class="space-y-4">
                    <!-- Los detalles se llenarán dinámicamente -->
                </div>
                
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <button onclick="copyMeetingInfo()" 
                            class="flex-1 bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-300 flex items-center justify-center">
                        <i class="fas fa-copy mr-2"></i>Copiar Información
                    </button>
                    <button onclick="createNewMeeting()" 
                            class="flex-1 bg-morado-medio text-white py-2 px-4 rounded-md hover:bg-morado-oscuro transition duration-300 flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>Nueva Reunión
                    </button>
                </div>
            </div>
        </div>

        <!-- Lista de reuniones programadas -->
        <div id="meetings-list" class="max-w-2xl mx-auto mt-8 hidden">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-morado-claro">
                <div class="bg-morado-medio px-6 py-4">
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-list mr-2"></i>Reuniones Programadas
                    </h2>
                </div>
                <div id="meetings-container" class="p-6">
                    <!-- Las reuniones se mostrarán aquí -->
                </div>
            </div>
        </div>
    </div>

    <!-- Notificación de copiado -->
    <div id="copy-notification" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300">
        <i class="fas fa-check mr-2"></i>¡Información copiada al portapapeles!
    </div>

    <script>
        // Array para almacenar las reuniones creadas
        let meetings = [];
        let meetingIdCounter = 1000;

        // Configurar fecha mínima y por defecto
        function setupDateTime() {
            const now = new Date();
            now.setMinutes(now.getMinutes() + 5);
            document.getElementById('start_time').min = now.toISOString().slice(0, 16);
            
            const defaultTime = new Date();
            defaultTime.setMinutes(defaultTime.getMinutes() + 10);
            document.getElementById('start_time').value = defaultTime.toISOString().slice(0, 16);
        }

        // Generar ID de reunión y contraseña
        function generateMeetingCredentials() {
            const meetingId = (Math.floor(Math.random() * 900) + 100) + '-' + 
                             (Math.floor(Math.random() * 900) + 100) + '-' + 
                             (Math.floor(Math.random() * 9000) + 1000);
            const password = Math.floor(Math.random() * 900000) + 100000;
            return { meetingId, password };
        }

        // Crear reunión
        function createMeeting(isInstant = false) {
            const form = document.getElementById('meeting-form');
            const formData = new FormData(form);
            
            const topic = formData.get('topic') || 'Reunión Zoom';
            const startTime = isInstant ? new Date() : new Date(formData.get('start_time'));
            const duration = parseInt(formData.get('duration'));
            const description = formData.get('description') || '';
            
            const credentials = generateMeetingCredentials();
            const meetingUrl = `https://zoom.us/j/${credentials.meetingId.replace(/-/g, '')}?pwd=${credentials.password}`;
            
            const meeting = {
                id: meetingIdCounter++,
                topic,
                startTime,
                duration,
                description,
                meetingId: credentials.meetingId,
                password: credentials.password,
                url: meetingUrl,
                isInstant,
                created: new Date()
            };
            
            meetings.push(meeting);
            displayMeetingResult(meeting);
            updateMeetingsList();
            
            if (!isInstant) {
                form.reset();
                setupDateTime();
            }
        }

        // Mostrar resultado de la reunión
        function displayMeetingResult(meeting) {
            const resultDiv = document.getElementById('meeting-result');
            const detailsDiv = document.getElementById('meeting-details');
            
            const startTimeFormatted = meeting.startTime.toLocaleString('es-ES');
            const endTime = new Date(meeting.startTime.getTime() + meeting.duration * 60000);
            const endTimeFormatted = endTime.toLocaleString('es-ES');
            
            detailsDiv.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-morado-oscuro mb-2">
                            <i class="fas fa-tag mr-2"></i>Tema
                        </h3>
                        <p class="text-gray-700">${meeting.topic}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-morado-oscuro mb-2">
                            <i class="fas fa-clock mr-2"></i>Duración
                        </h3>
                        <p class="text-gray-700">${meeting.duration} minutos</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-morado-oscuro mb-2">
                            <i class="fas fa-calendar mr-2"></i>Inicio
                        </h3>
                        <p class="text-gray-700">${startTimeFormatted}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-morado-oscuro mb-2">
                            <i class="fas fa-calendar-times mr-2"></i>Fin
                        </h3>
                        <p class="text-gray-700">${endTimeFormatted}</p>
                    </div>
                    
                    <div class="bg-blue-50 p-4 rounded-lg md:col-span-2">
                        <h3 class="font-semibold text-morado-oscuro mb-2">
                            <i class="fas fa-link mr-2"></i>Enlace de la Reunión
                        </h3>
                        <p class="text-blue-600 break-all">${meeting.url}</p>
                    </div>
                    
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-morado-oscuro mb-2">
                            <i class="fas fa-key mr-2"></i>ID de Reunión
                        </h3>
                        <p class="text-gray-700 font-mono">${meeting.meetingId}</p>
                    </div>
                    
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-morado-oscuro mb-2">
                            <i class="fas fa-lock mr-2"></i>Contraseña
                        </h3>
                        <p class="text-gray-700 font-mono">${meeting.password}</p>
                    </div>
                    
                    ${meeting.description ? `
                    <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                        <h3 class="font-semibold text-morado-oscuro mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Descripción
                        </h3>
                        <p class="text-gray-700">${meeting.description}</p>
                    </div>
                    ` : ''}
                </div>
            `;
            
            document.getElementById('form-container').classList.add('hidden');
            resultDiv.classList.remove('hidden');
        }

        // Actualizar lista de reuniones
        function updateMeetingsList() {
            const listDiv = document.getElementById('meetings-list');
            const containerDiv = document.getElementById('meetings-container');
            
            if (meetings.length === 0) {
                listDiv.classList.add('hidden');
                return;
            }
            
            const sortedMeetings = meetings.sort((a, b) => a.startTime - b.startTime);
            
            containerDiv.innerHTML = sortedMeetings.map(meeting => {
                const isUpcoming = meeting.startTime > new Date();
                const statusClass = isUpcoming ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600';
                const statusText = meeting.isInstant ? 'Iniciada' : (isUpcoming ? 'Programada' : 'Finalizada');
                
                return `
                <div class="border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-morado-oscuro">${meeting.topic}</h4>
                        <span class="text-xs px-2 py-1 rounded-full ${statusClass}">${statusText}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">
                        <i class="fas fa-calendar mr-1"></i>
                        ${meeting.startTime.toLocaleString('es-ES')}
                    </p>
                    <p class="text-sm text-gray-600 mb-2">
                        <i class="fas fa-clock mr-1"></i>
                        ${meeting.duration} minutos
                    </p>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">ID: ${meeting.meetingId}</span>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Contraseña: ${meeting.password}</span>
                    </div>
                </div>
                `;
            }).join('');
            
            listDiv.classList.remove('hidden');
        }

        // Copiar información de la reunión
        function copyMeetingInfo() {
            const lastMeeting = meetings[meetings.length - 1];
            if (!lastMeeting) return;
            
            const info = `
Reunión: ${lastMeeting.topic}
Fecha y hora: ${lastMeeting.startTime.toLocaleString('es-ES')}
Duración: ${lastMeeting.duration} minutos
Enlace: ${lastMeeting.url}
ID de reunión: ${lastMeeting.meetingId}
Contraseña: ${lastMeeting.password}
${lastMeeting.description ? `Descripción: ${lastMeeting.description}` : ''}
            `.trim();
            
            navigator.clipboard.writeText(info).then(() => {
                showCopyNotification();
            });
        }

        // Mostrar notificación de copiado
        function showCopyNotification() {
            const notification = document.getElementById('copy-notification');
            notification.classList.remove('translate-x-full');
            setTimeout(() => {
                notification.classList.add('translate-x-full');
            }, 3000);
        }

        // Crear nueva reunión
        function createNewMeeting() {
            document.getElementById('form-container').classList.remove('hidden');
            document.getElementById('meeting-result').classList.add('hidden');
        }

        // Event listeners
        document.getElementById('meeting-form').addEventListener('submit', function(e) {
            e.preventDefault();
            createMeeting(false);
        });

        document.getElementById('start-now-btn').addEventListener('click', function() {
            const topic = document.getElementById('topic').value || 'Reunión Inmediata';
            const duration = parseInt(document.getElementById('duration').value);
            
            // Crear reunión inmediata con datos del formulario
            const meeting = {
                id: meetingIdCounter++,
                topic,
                startTime: new Date(),
                duration,
                description: document.getElementById('description').value || '',
                ...generateMeetingCredentials(),
                isInstant: true,
                created: new Date()
            };
            
            meeting.url = `https://zoom.us/j/${meeting.meetingId.replace(/-/g, '')}?pwd=${meeting.password}`;
            meetings.push(meeting);
            displayMeetingResult(meeting);
            updateMeetingsList();
        });

        // Inicializar la aplicación
        setupDateTime();
    </script>
</body>
</html>