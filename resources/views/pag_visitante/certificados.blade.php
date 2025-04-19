<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificaciones Profesionales | Fundación Nombre</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('CSS/styleGeneral.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/pie_pag.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/certificaciones.css') }}">
</head>

<body>
    <!-- Botón para abrir el menú -->
    <div class="menu-btn">&#9776; Menu</div>
    @include('partials.nav')

    <div id="main-content" class="content">
        <section class="hero">
            <div class="hero-content">
                <h1>Certificaciones Profesionales Reconocidas</h1>
                <p>Obtén certificados avalados por universidades que impulsarán tu carrera profesional y te abrirán nuevas oportunidades laborales.</p>
            </div>
        </section>
        <section class="benefits" id="beneficios">
            <div class="container">
                <h2 class="section-title">Beneficios de Nuestras Certificaciones</h2>
                <p class="section-subtitle">Nuestros programas de certificación están diseñados para proporcionarte las habilidades que el mercado laboral demanda, con reconocimiento oficial.</p>

                <div class="benefits-grid">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <h3>Aval Universitario</h3>
                        <p>Todas nuestras certificaciones cuentan con el respaldo de la Universidad San Francisco de Asís, los cuales nos brindan su apoyo para toda nuestra comunidad.</p>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>Reconocimiento</h3>
                        <p>Cuenta con el reconocimiento al haber sido participe de nuestra fundación las cuales serán de calidad y agradecimiento.</p>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h3>Certificados</h3>
                        <p>Obten un certificado que te ayudara para salir al mercado laboral, o ya sea para que mejores tu perfil actualizandote en alguna de nuestras áreas que ofrecemos.</p>
                    </div>

                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Comunidad Profesional</h3>
                        <p>Forma parte de una red de profesionales certificados para compartir experiencias y oportunidades.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="certificates" id="certificados">
            <div class="container">
                <h2 class="section-title">Nuestras Certificaciones</h2>
                <p class="section-subtitle">Descubre las certificaciones reconocidas que puedes obtener al completar nuestros programas especializados.</p>

                <div class="certificates-grid">
                    <!-- Certificación 1 -->
                    <div class="certificate-card">
                        <div class="certificate-img">
                            <img src="https://i.ytimg.com/vi/3TDy-UzD3jE/maxresdefault.jpg" alt="Certificado" class="certificate-img-image">
                        </div>
                        <div class="certificate-content">
                            <h3>Certificado Avalado por la USFA</h3>
                            <p>Obtén un certificado reconocido por la Universidad de San Francisco de Asís (USFA) para mejorar tu perfil profesional.</p>
                            <ul class="certificate-details">
                                <li><i class="fas fa-check-circle"></i> Certificación oficial</li>
                                <li><i class="fas fa-check-circle"></i> Reconocimiento nacional</li>
                                <li><i class="fas fa-check-circle"></i> Avalado por una institución educativa de prestigio</li>
                            </ul>
                            <center><a href="{{ url('/cursosUser') }}" class="btn btn-primary">Más información</a></center> 
                        </div>
                    </div>

                    <!-- Certificación 2 -->
                    <div class="certificate-card">
                        <div class="certificate-img">
                            <img src="https://www.aprendemas.com/mx/blog/images/2024/02/TSU.jpg" alt="Certificado" class="certificate-img-image">
                        </div>
                        <div class="certificate-content">
                            <h3>Certificación Técnica Superior</h3>
                            <p>Adquiere un certificado técnico superior que respalda tus competencias en el área profesional que elijas.</p>
                            <ul class="certificate-details">
                                <li><i class="fas fa-check-circle"></i> Certificación técnica de nivel superior</li>
                                <li><i class="fas fa-check-circle"></i> Reconocimiento para empleo inmediato</li>
                                <li><i class="fas fa-check-circle"></i> Avalado por instituciones especializadas</li>
                            </ul>
                            <center><a href="{{ url('/cursosUser') }}" class="btn btn-primary">Más información</a></center> 
                        </div>
                    </div>

                    <!-- Certificación 3 -->
                    <div class="certificate-card">
                        <div class="certificate-img">
                            <img src="https://i0.wp.com/www.somospsicologos.es/wp-content/uploads/2020/10/como-gestionar-necesidad-reconocimiento.jpg?fit=450%2C274&ssl=1" alt="Certificado" class="certificate-img-image">
                        </div>
                        <div class="certificate-content">
                            <h3>Certificación de Reconocimiento Profesional</h3>
                            <p>Obtén una certificación que valida tu experiencia y habilidades con reconocimiento en la industria.</p>
                            <ul class="certificate-details">
                                <li><i class="fas fa-check-circle"></i> Reconocimiento profesional a nivel global</li>
                                <li><i class="fas fa-check-circle"></i> Potencia tu perfil para nuevos proyectos laborales</li>
                                <li><i class="fas fa-check-circle"></i> Ideal para abrir puertas en múltiples sectores</li>
                            </ul>
                            <center><a href="{{ url('/cursosUser') }}" class="btn btn-primary">Más información</a></center> 
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta" id="inscribirse">
            <div class="container">
                <h2>¿Listo para impulsar tu carrera profesional?</h2>
                <p>Inscríbete ahora en nuestros programas de certificación y da el primer paso hacia un futuro laboral más prometedor.</p>
                <a href="{{ url('/cursosUser') }}" class="btn btn-light">Inscribirme Ahora</a>
            </div>
        </section>

        <section class="faq" id="faq">
            <div class="container">
                <h2 class="section-title">Preguntas Frecuentes</h2>
                <p class="section-subtitle">Resolvemos tus dudas sobre nuestros programas de certificación.</p>

                <div class="faq-container">
                    <div class="faq-item">
                        <div class="faq-question">
                            ¿Quiénes pueden acceder a las certificaciones gratuitas?
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Nuestras certificaciones están disponibles de forma gratuita para personas en situación de vulnerabilidad económica, víctimas de violencia, madres solteras, jóvenes de comunidades marginadas y otros grupos prioritarios. Durante el proceso de inscripción se realiza una evaluación socioeconómica para determinar si puede contar con alguna ayuda o beca.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            ¿Qué requisitos necesito para inscribirme?
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Para inscribirte necesitas: documento de identidad, saber sobre sus datos personales, el tiempo en que usted quiere solicitar la clase, el pago de su primer módulo. No se requiere el grado de estudio, pero igual será pedido para poder brindarle o informarle sobre los certificados. Tras esto solo debe apersonarse y tras pagar el primer módulo de forma presencial se le entregaran sus credenciales para que pueda iniciar sesión en el curso escogido.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            ¿Las certificaciones tienen validez oficial?
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Sí, todas nuestras certificaciones cuentan con reconocimiento oficial y son valoradas en el mercado laboral. Además de eso contara con el certificado avalado por la universidad de la USFA.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('partials.footer')
    </div>

    <script>
        // Toggle FAQ answers
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const icon = question.querySelector('i');

                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else {
                    answer.style.display = 'block';
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });
        });

        // Initialize - Hide all answers
        document.querySelectorAll('.faq-answer').forEach(answer => {
            answer.style.display = 'none';
        });
    </script>
    <script src="{{ asset('JS/menu.js') }}"></script>
</body>

</html>