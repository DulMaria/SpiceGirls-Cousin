<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundación Santa Germana Cousin</title>
    <link rel="stylesheet" href="{{ asset('CSS/styleGeneral.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/pie_pag.css') }}">
</head>

<body>
    <!-- Botón para abrir el menú -->
    <div class="menu-btn">&#9776; Menu</div>
    @include('partials.nav')

    <div id="main-content" class="content">            
        <!-- Banner -->
        <div class="banner-container">
            <img src="{{ asset('img/slogan.png') }}" alt="Banner" class="banner-cropped" onclick="showFullImage()">
        </div>

        <!-- Imagen completa que se mostrará al hacer clic -->
        <div class="full-image-container" id="fullImage" style="display: none;">
            <img src="{{ asset('img/slogan.png') }}" alt="Banner Completo" class="banner-full" onclick="hideFullImage()">
        </div>    

        <div class="contenedor-titulo_ini">
            <img src="{{ asset('img/Icon_Playa.png') }}" alt="Piscina" width="300" height="200">
            <h2 class="Titulo_pag">Fundación</h2>
            <h2 class="Titulo_pag">"Santa Germana Cousin"</h2>
        </div><br>

        <!-- Contenido principal -->
        <section class="principal">
            <div class="container-principal">     
                <div class="heading-principal">
                    <h1>Aquí comienza tu camino hacia la comprensión</h1>
                </div>
                <div class="description-principal">
                    <p>Empieza un camino donde aprender es también cuestionar, crecer y entender realidades difíciles. 
                        Juntos vamos a descubrir cómo el estudio puede ser una forma de luchar contra la violencia y 
                        hacer del mundo un lugar mejor.</p>
                </div>
                @guest
                    <div class="login-button">
                        <a href="{{ url('/login') }}"
                            class="btn hover:bg-blue-700 transition duration-300 shadow-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="mr-2"
                                viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                            </svg>
                            Iniciar Sesión
                        </a>
                    </div>
                @endguest
            </div>
        </section><br>

        <!-- Apartado de informaciones -->
        <section class="features">
            <div class="feature-item">
                <img src="https://www.telefonica.com/es/wp-content/uploads/sites/4/2024/12/beneficios-educacion-digital.jpg" alt="Cursos">
                <div class="feature-text">
                    <h2>Cursos</h2>
                    <p>Explora una amplia variedad de cursos diseñados para ayudarte a crecer profesional y personalmente.</p>
                    <a href="{{ url('/cursosUser') }}" class="btn">Ver Cursos</a>
                </div>
            </div>

            <div class="feature-item">                
                <div class="feature-text">
                    <h2>Promociones</h2>
                    <p>Aprovecha ofertas exclusivas y descuentos especiales pensados para ti y tu crecimiento.</p>
                    <a href="{{ url('/news') }}" class="btn">Más información</a>
                </div>
                <img src="https://media.licdn.com/dms/image/v2/C4D12AQFkI_TSq1FF7w/article-cover_image-shrink_720_1280/article-cover_image-shrink_720_1280/0/1600821882221?e=2147483647&v=beta&t=6p2TZguMFqWSxrFb3IXu4ydFeFcGuPp66zCsHUcJqiY" alt="Promociones">
            </div>

            <div class="feature-item">
                <img src="https://www.xplora.eu/wp-content/uploads/como-escribir-web-sobre-nosotros.jpg" alt="Informaciones">
                <div class="feature-text">
                    <h2>Sobre Nosotros</h2>
                    <p>Conoce más sobre nuestra misión, valores y el equipo que hace posible este proyecto.</p>
                    <a href="{{ url('/sobreNosotros') }}" class="btn">Conoce a la Familia</a>
                </div>
            </div>

            <div class="feature-item">                
                <div class="feature-text">
                    <h2>Contactanos</h2>
                    <p>¿Tienes dudas o sugerencias? Estamos aquí para escucharte y ayudarte en lo que necesites.</p>
                    <a href="{{ url('/contacto') }}" class="btn">Comunicate</a>
                </div>
                <img src="https://img.freepik.com/fotos-premium/pongase-contacto-nosotros-mano-empresario-sosteniendo-telefono-inteligente-movil-icono-correo-telefono-correo-electronico_52701-38.jpg" alt="Contactos">
            </div>
        </section>
        <a href="{{ route('administrador.prinAdmi') }}" class="text-[#127475] hover:text-[#e07a5f] text-lg font-semibold">Ir al Panel de Administración</a>


        @include('partials.footer')
    </div>
    
    <script src="{{ asset('JS/menu.js') }}"></script>
</body>
</html>