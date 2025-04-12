<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctanos</title>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('CSS/styleGeneral.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/contactos.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/pie_pag.css') }}">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.8.1/mapbox-gl.css" rel="stylesheet" />
    <style>
        /* Asegúrate de que el mapa tenga un tamaño adecuado */
        #map {
            width: 100%;
            height: 300px; /* Puedes ajustar este valor */
        }
    </style>
</head>
<body>
    <div class="menu-btn">&#9776; Menu</div>
    @include('partials.nav')
    <!-- Sección de contacto -->
    <div id="main-content" class="content">
        <div class="title">
            <h1>CONTACTANOS</h1>
        </div>

        <!-- Sección de Formulario de Contacto -->
        <div class="contact-form">
            <!-- Subtítulo ¿Qué desea? -->
            <div class="form-item">
                <h2>¿Qué desea?</h2>
                <select id="contactSelect" class="form-control">
                    <option value="Cursos">Información sobre Cursos</option>
                    <option value="Ubicación">Ubicación para obtener más información</option>
                    <option value="Becas">Las becas que ofrece nuestra Fundación</option>
                    <option value="Ofertas">Las ofertas del mes</option>
                    <option value="Reconocimientos">Reconocimientos que se le ofrece al finalizar el curso</option>
                    <option value="Inscripciones">Como inscribirse a los cursos</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <!-- Botón de enviar mensaje a WhatsApp -->
            <div class="form-item">
                <a id="whatsappButton" href="https://wa.me/59171143449?text=Estimado%20equipo,%0A%0AQuisiera%20recibir%20informaci%C3%B3n%20acerca%20de%20Cursos.%0A%0ASi%20es%20posible,%20me%20gustar%C3%ADa%20conocer%20los%20detalles%20y%20cualquier%20informaci%C3%B3n%20adicional%20disponible.%0A%0AGracias%20por%20su%20tiempo%20y%20atenci%C3%B3n.%0A%0ACordialmente,%0A[Nombre_del_usuario]" class="btn" target="_blank">Enviar mensaje</a>
            </div>

            <!-- Subtítulo Visítanos -->
            <div class="form-item">
                <h2>Visítanos</h2>
                <div class="map-container" id="map"></div>
                <a href="https://maps.app.goo.gl/TuzG9U6HQpGZxKuH7" target="_blank" class="btn">Ver Mapa</a>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="{{ asset('JS/menu.js') }}"></script>
    <script>
        // Función para actualizar el enlace de WhatsApp según la opción seleccionada
        document.getElementById('contactSelect').addEventListener('change', function () {
            var selectedOption = this.value;
            var message = '';

            // Actualización del mensaje de acuerdo a la opción seleccionada
            switch (selectedOption) {
                case 'Cursos':
                    message = "Estimado%20equipo,%0A%0AQuisiera%20recibir%20informaci%C3%B3n%20acerca%20de%20Cursos.%0A%0ASi%20es%20posible,%20me%20gustar%C3%ADa%20conocer%20los%20detalles%20y%20cualquier%20informaci%C3%B3n%20adicional%20disponible.%0A%0AGracias%20por%20su%20tiempo%20y%20atenci%C3%B3n.%0A%0ACordialmente,%0A[Nombre_del_usuario]";
                    break;
                case 'Ubicación':
                    message = "Estimado%20equipo,%0A%0AQuisiera%20obtener%20informaci%C3%B3n%20sobre%20la%20ubicaci%C3%B3n%20para%20recibir%20más%20detalles.%0A%0AGracias%20por%20su%20tiempo%20y%20atenci%C3%B3n.%0A%0ACordialmente,%0A[Nombre_del_usuario]";
                    break;
                case 'Becas':
                    message = "Estimado%20equipo,%0A%0AQuisiera%20informaci%C3%B3n%20sobre%20las%20becas%20que%20ofrece%20su%20Fundaci%C3%B3n.%0A%0AGracias%20por%20su%20tiempo%20y%20atenci%C3%B3n.%0A%0ACordialmente,%0A[Nombre_del_usuario]";
                    break;
                case 'Ofertas':
                    message = "Estimado%20equipo,%0A%0AQuisiera%20saber%20más%20sobre%20las%20ofertas%20del%20mes.%0A%0AGracias%20por%20su%20tiempo%20y%20atenci%C3%B3n.%0A%0ACordialmente,%0A[Nombre_del_usuario]";
                    break;
                case 'Reconocimientos':
                    message = "Estimado%20equipo,%0A%0AQuisiera%20informaci%C3%B3n%20sobre%20los%20reconocimientos%20que%20se%20ofrecen%20al%20finalizar%20el%20curso.%0A%0AGracias%20por%20su%20tiempo%20y%20atenci%C3%B3n.%0A%0ACordialmente,%0A[Nombre_del_usuario]";
                    break;
                case 'Inscripciones':
                    message = "Estimado%20equipo,%0A%0AQuisiera%20saber%20cómo%20realizar%20la%20inscripción%20a%20los%20cursos.%0A%0AGracias%20por%20su%20tiempo%20y%20atenci%C3%B3n.%0A%0ACordialmente,%0A[Nombre_del_usuario]";
                    break;
                case 'Otro':
                    message = "Estimado%20equipo,%0A%0AQuisiera%20hacer%20una%20consulta%20adicional.%0A%0AGracias%20por%20su%20tiempo%20y%20atenci%C3%B3n.%0A%0ACordialmente,%0A[Nombre_del_usuario]";
                    break;
            }

            // Actualizar el enlace con el mensaje adecuado
            var whatsappLink = "https://wa.me/59171143449?text=" + message;
            document.getElementById('whatsappButton').setAttribute('href', whatsappLink);
        });
    </script>

    <script>
        // Inicializa Mapbox con tu token de acceso (reemplazar con el tuyo)
        mapboxgl.accessToken = 'pk.eyJ1IjoiYW5kcmVhbWluMTczMyIsImEiOiJjbTk2bGZhM2oxaTRzMmtvanlkN2g1dzZoIn0.ZIhEWO4uDqtP2M5lQ82XFw';

        // Crea el mapa centrado en la ubicación de La Paz, Bolivia
        var map = new mapboxgl.Map({
            container: 'map', // El ID del contenedor del mapa
            style: 'mapbox://styles/mapbox/streets-v11', // Estilo del mapa
            center: [-68.136632, -16.494395], // Coordenadas de La Paz, Bolivia
            zoom: 18 // Nivel de zoom
        });

        // Crea un marcador en las coordenadas
        var marker = new mapboxgl.Marker()
            .setLngLat([-68.136632, -16.494395]) // Coordenadas de La Paz
            .addTo(map);
    </script>
</body>
</html>
