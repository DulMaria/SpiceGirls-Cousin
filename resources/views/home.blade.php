<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundación Santa Germana Cousin</title>
    <link rel="stylesheet" href="{{ asset('CSS/styleGeneral.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/pie_pag.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>

<body>
    <!-- Botón para abrir el menú -->
    <div class="menu-btn">&#9776; Menu</div>
    @include('partials.nav')

    <div id="main-content" class="content">

        <!-- Carrusel -->
        <section class="carousel-section">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="https://cdn.leonardo.ai/users/155b71f2-4da7-4c04-a85a-d14e23b9bd41/generations/ec4e71f2-c503-4c1e-be58-36bcd5ca8116/Leonardo_Phoenix_10_Create_an_image_wider_than_tall_depicting_1.jpg" alt="Evento 1">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://cdn.leonardo.ai/users/155b71f2-4da7-4c04-a85a-d14e23b9bd41/generations/01ec9243-e5ec-4eed-b81e-4d0dba1b65c7/Leonardo_Phoenix_10_a_wide_horizontal_image_depicting_a_scient_2.jpg" alt="Evento 2">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://cdn.leonardo.ai/users/155b71f2-4da7-4c04-a85a-d14e23b9bd41/generations/c603ce4e-e8d2-4605-9219-8b881385589d/Leonardo_Phoenix_10_Create_an_image_wider_than_tall_depicting_2.jpg" alt="Evento 3">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://i.ytimg.com/vi/YKDHUZqDU0U/maxresdefault.jpg" alt="Evento 3">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section><br>

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
                    <a href="{{ route('login') }}"
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

        <!-- Sección de Beneficios Mejorada -->
        <section class="benefits">
            <h2 class="section-title">Nuestros Beneficios</h2>

            <div class="benefit-item">
                <button class="benefit-btn" aria-expanded="false" aria-controls="certificates-content">
                    <div class="benefit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                            <line x1="16" x2="16" y1="2" y2="6"></line>
                            <line x1="8" x2="8" y1="2" y2="6"></line>
                            <line x1="3" x2="21" y1="10" y2="10"></line>
                            <path d="m9 16 2 2 4-4"></path>
                        </svg>
                    </div>
                    <span class="benefit-title">Certificaciones Profesionales</span>
                    <span class="arrow">▼</span>
                </button>
                <div class="benefit-content" id="certificates-content">
                    <p>Obtén certificados reconocidos en el mercado laboral que impulsarán tu carrera profesional.</p>
                    <ul>
                        <li>Certificados avalados por la USFA</li>
                        <li>Reconocimiento por la calidad y actualidad de los certificados obtenidos</li>
                        <li>Certificados que mejoran tu perfil laboral para distintas áreas</li>
                    </ul>
                    <a href="{{ url('/certificados') }}" class="benefit-link">Ver certificaciones disponibles →</a>
                </div>
            </div><div class="benefit-item">
    <button class="benefit-btn" aria-expanded="false" aria-controls="vocacional-content">
        <div class="benefit-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 16v-4"></path>
                <path d="M12 8h.01"></path>
            </svg>
        </div>
        <span class="benefit-title">¿No sabes qué curso estudiar?</span>
        <span class="arrow">▼</span>
    </button>
    <div class="benefit-content" id="vocacional-content">
        <p>Descubre qué curso se adapta mejor a tus intereses y habilidades completando nuestro test vocacional gratuito.</p>
        <ul>
            <li>Preguntas simples y personalizadas</li>
            <li>Resultados inmediatos y orientativos</li>
            <li>Recomendaciones según tu perfil</li>
        </ul>
        <a href="{{ route('test.formulario') }}" class="benefit-link">Realizar el test vocacional →</a>
    </div>
</div>

        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const benefitButtons = document.querySelectorAll('.benefit-btn');

                benefitButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const expanded = this.getAttribute('aria-expanded') === 'true';

                        // Cerrar todos los paneles
                        benefitButtons.forEach(btn => {
                            btn.setAttribute('aria-expanded', 'false');
                        });

                        // Si estaba cerrado, abrirlo (toggle)
                        if (!expanded) {
                            this.setAttribute('aria-expanded', 'true');
                        }
                    });
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
                <span class="stat-number" data-target="{{ $numeroDeCursos }}">0</span>
                <span class="stat-text">Cursos impartidos</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-target="1000">0</span>
                <span class="stat-text">Personas ayudadas</span>
            </div>
        </section>
        <script>
            let statsAnimated = false;

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

            window.addEventListener('scroll', function onScroll() {
                const statsSection = document.querySelector('.stats');
                if (!statsAnimated && statsSection.getBoundingClientRect().top < window.innerHeight - 100) {
                    animateStats();
                    statsAnimated = true;
                    window.removeEventListener('scroll', onScroll);
                }
            });
        </script>

        <!-- Inicialización del carrusel -->
        <script>
            const swiper = new Swiper(".mySwiper", {
                autoplay: {
                    delay: 3000
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                },
                loop: true
            });
        </script>
        @include('partials.footer')
    </div>
    <script src="{{ asset('JS/menu.js') }}"></script>
</body>

</html>