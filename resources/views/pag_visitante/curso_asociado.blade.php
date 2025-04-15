<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos de {{ $area->nombreArea }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('CSS/Cursos.css') }}">
</head>
<body>

    <!-- Contador de tiempo (Antes de las clases) -->
    <div id="countdown-container">
        <h2 id="countdown-title">Tiempo de Inscripción</h2>
        <p id="countdown"></p>
    </div>

    <!-- Sección de cursos -->
    <section class="course-section">
        @foreach($cursos as $curso)
            <div class="course-item">
                <div class="course-img">
                    <img src="{{ $curso->imagen }}" alt="{{ $curso->nombreCurso }}">
                </div>
                <div class="course-text">
                    <h2>{{ $curso->nombreCurso }}</h2>
                    <p>{{ $curso->descripcion }}</p>
                    <button class="btn" onclick="openModal('{{ $curso->id }}')">Ver más</button>
                </div>
            </div>
        @endforeach
    </section>

    <!-- Ventanas modales -->
    @foreach($cursos as $curso)
    <div id="{{ $curso->id }}" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('{{ $curso->id }}')">&times;</span>
            <h2>{{ $curso->nombreCurso }}</h2>
            <ul>
                @foreach($curso->modulos as $modulo)
                    <li><strong>Módulo {{ $loop->iteration }}:</strong> {{ $modulo }}</li>
                @endforeach
            </ul>
            <p><strong>Costo:</strong> Bs. {{ $curso->costo }}</p>
            <p><strong>Duración:</strong> {{ $curso->duracion }} meses</p>
            <button onclick="goToInscription('{{ $curso->nombreCurso }}')">Inscribirse</button>
        </div>
    </div>
    @endforeach

    <a href="{{ route('pag_visitante.cursosUser') }}">Volver a las áreas</a>

    <script>
        // Función para abrir la ventana modal correspondiente
        function openModal(courseId) {
            document.getElementById(courseId).style.display = "block";
        }

        // Función para cerrar la ventana modal
        function closeModal(courseId) {
            document.getElementById(courseId).style.display = "none";
        }

        // Función para redirigir a la página de inscripción
        function goToInscription(courseName) {
            window.location.href = `/inscripcion?curso=${courseName}`;
        }

        // Contador de tiempo con reinicio mensual
        function updateCountdown() {
            const now = new Date();
            const currentDate = now.getDate();
            const currentMonth = now.getMonth(); // 0-indexed (January is 0, December is 11)

            let targetDate;
            if (currentDate < 8) {
                // Mostrar la cuenta regresiva hasta el 7
                targetDate = new Date(now.getFullYear(), currentMonth, 7, 23, 59, 59);
                document.getElementById("countdown-title").innerText = "Tiempo de Inscripción";
            } else {
                // Mostrar la cuenta regresiva hasta el 1 del siguiente mes
                targetDate = new Date(now.getFullYear(), currentMonth + 1, 1, 0, 0, 0);
                document.getElementById("countdown-title").innerText = "Tiempo para abertura de clases";
            }

            const timeRemaining = targetDate - now;

            const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            document.getElementById('countdown').innerHTML =
                `<span id="countdown-days">${days} días</span>, <span id="countdown-hours">${hours} horas</span>, <span id="countdown-minutes">${minutes} minutos</span>, <span id="countdown-seconds">${seconds} segundos</span>`;
        }

        setInterval(updateCountdown, 1000); // Actualizar el contador cada segundo
        updateCountdown(); // Inicializar contador
    </script>

</body>
</html>
