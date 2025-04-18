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

        <!-- Carrusel -->
        <section class="carousel-section">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{ asset('img/ejemplo1.jpg') }}" alt="Evento 1">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('img/ejemplo2.jpg') }}" alt="Evento 2">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>

        <!-- Estilos y JS del carrusel -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <style>
            .carousel-section {
                margin: 2rem 0;
            }

            .swiper-slide img {
                width: 100%;
                height: 400px;
                object-fit: cover;
                border-radius: 10px;
            }
        </style>
        <script>
            const swiper = new Swiper(".mySwiper", {
                autoplay: {
                    delay: 3000
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                },
            });
        </script>

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

        <!-- Botones interactivos - Beneficios -->
        <section class="benefits">
            <h2 class="section-title">Nuestros Beneficios</h2>
            <div class="benefit-item">
                <button class="benefit-btn">📚 Educación Gratuita <span class="arrow">▼</span></button>
                <div class="benefit-content">
                    <p>Cursos certificados sin costo para comunidades vulnerables.</p>
                </div>
            </div>
            <div class="benefit-item">
                <button class="benefit-btn">👥 Apoyo Psicológico <span class="arrow">▼</span></button>
                <div class="benefit-content">
                    <p>Sesiones con profesionales para superar situaciones difíciles.</p>
                </div>
            </div>
        </section>

        <style>
            .benefits {
                max-width: 800px;
                margin: 2rem auto;
            }

            .benefit-btn {
                width: 100%;
                padding: 1rem;
                text-align: left;
                background: #127475;
                color: white;
                border: none;
                cursor: pointer;
                border-radius: 5px;
                margin: 5px 0;
                display: flex;
                justify-content: space-between;
            }

            .benefit-content {
                padding: 0 1rem;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
                background: #f0f0f0;
                border-radius: 0 0 5px 5px;
            }

            .benefit-content p {
                padding: 1rem;
            }
        </style>
        <script>
            document.querySelectorAll('.benefit-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const content = button.nextElementSibling;
                    content.style.maxHeight = content.style.maxHeight ? null : `${content.scrollHeight}px`;
                    button.querySelector('.arrow').textContent =
                        content.style.maxHeight ? '▲' : '▼';
                });
            });
        </script>

        <!-- Estadísticas -->
        <section class="stats">
            <div class="stat-item">
                <span class="stat-number" data-target="1500">0</span>
                <span class="stat-text">Estudiantes graduados</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-target="85">0</span>
                <span class="stat-text">Cursos impartidos</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-target="5000">0</span>
                <span class="stat-text">Personas ayudadas</span>
            </div>
        </section>

        <style>
            .stats {
                display: flex;
                justify-content: space-around;
                background: #127475;
                color: white;
                padding: 2rem;
                margin: 2rem 0;
                text-align: center;
            }

            .stat-number {
                font-size: 3rem;
                font-weight: bold;
                display: block;
            }
        </style>
        <script>
            function animateStats() {
                document.querySelectorAll('.stat-number').forEach(stat => {
                    const target = +stat.getAttribute('data-target');
                    const duration = 2000;
                    const step = target / (duration / 16);
                    let current = 0;
                    const update = () => {
                        current += step;
                        if (current < target) {
                            stat.textContent = Math.floor(current);
                            requestAnimationFrame(update);
                        } else {
                            stat.textContent = target;
                        }
                    };
                    update();
                });
            }
            // Activar al hacer scroll a la sección
            window.addEventListener('scroll', () => {
                const statsSection = document.querySelector('.stats');
                if (statsSection.getBoundingClientRect().top < window.innerHeight - 100) {
                    animateStats();
                    window.removeEventListener('scroll', this);
                }
            });
        </script>
        <a href="{{ route('administrador.prinAdmi') }}" class="text-[#127475] hover:text-[#e07a5f] text-lg font-semibold">Ir al Panel de Administración</a>


        @include('partials.footer')
    </div>

    <script src="{{ asset('JS/menu.js') }}"></script>
</body>

</html>