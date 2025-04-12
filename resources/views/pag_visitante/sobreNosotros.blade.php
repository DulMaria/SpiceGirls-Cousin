<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - Fundación Santa Germana Cousin</title>
    <link rel="stylesheet" href="{{ asset('css/historia.css') }}">    
    <link rel="stylesheet" href="{{ asset('CSS/styleGeneral.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/pie_pag.css') }}">

</head>
<body>
    <!-- Botón para abrir el menú -->
    <div class="menu-btn">&#9776; Menu</div>
    @include('partials.nav')

    <div id="main-content" class="content">
        <div class="titulo">
            <header>
                <h1>Historia de la Fundación "Santa Germana Cousin"</h1>
            </header>
        </div>
        <div class="contenedor-interno">
            <section class="historia">
                <h2>¿Quiénes Somos?</h2>
                <p>
                    La Fundación "Santa Germana Cousin" nace del corazón y visión de la Dra. María del Rosario Rovira Gómez,
                    una mujer comprometida con la transformación social. Fue fundada como respuesta directa a la situación de vulnerabilidad
                    que vivían muchas mujeres víctimas de violencia doméstica, exclusión social y falta de oportunidades.
                </p>
                <p>
                    Nuestra misión comenzó impartiendo clases de capacitación y apoyo a mujeres en situación de violencia, brindándoles herramientas
                    para romper el ciclo de violencia, fortalecer su autoestima y acceder a un empleo digno.
                </p>
                <p>
                    Con el tiempo, la Fundación amplió su mirada e incluyó también a hombres víctimas de violencia, quienes muchas veces son invisibilizados por la sociedad. 
                    Hoy, trabajamos con personas de todos los géneros, promoviendo la igualdad, el respeto y la resiliencia familiar.
                </p>
                <p>
                    Aunque seguimos creciendo, no olvidamos nuestras raíces. Seguimos luchando día a día por guiar a quienes han sido silenciados por el miedo y el abuso,
                    ayudándolos a reconstruir sus vidas y encontrar una nueva oportunidad para salir adelante.
                </p>
                <img src="https://www.uanl.mx/wp-content/uploads/2019/01/alto-a-la-violencia-2.jpg" alt="Fundación Imagen" class="section-image fade-in">
            </section>

        <section class="timeline">
            <h2>Nuestra Historia</h2>
            <ul class="timeline">
                <li class="timeline-item fade-in">
                    <div class="line"></div>
                    <div class="text">
                        <span class="year">2009</span>
                        <p>La Dra. María del Rosario Rovira Gómez, impactada por la realidad de muchas mujeres víctimas de abuso, decide iniciar un pequeño grupo de ayuda en su comunidad.</p>
                    </div>
                    <div class="image">
                        <img src="https://lac.unwomen.org/sites/default/files/2023-11/01_hechos_y_cifras_-_thumbnail.png" alt="Fundación 2009">
                    </div>
                </li>
                <li class="timeline-item timeline-item-left fade-in">
                    <div class="line"></div>
                    <div class="text">
                        <span class="year">2010</span>
                        <p>Se funda oficialmente la Fundación "Santa Germana Cousin". Se comienzan a impartir auxiliaturas de ciencias forences, criminología, cursos de protesis dental, entre otros a mujeres en situación de violencia.</p>
                    </div>
                    <div class="image">
                        <img src="https://www.ambitojuridico.com/sites/default/files/node/deflt/field_image/1970-01/genetica-laboratorio-examen1shut-1509242025.jpg" alt="Fundación 2010">
                    </div>
                </li>
                <li class="timeline-item fade-in">
                    <div class="line"></div>
                    <div class="text">
                        <span class="year">2014</span>
                        <p>Se amplía el programa incluyendo a hombres víctimas de violencia. Se promueven campañas de sensibilización sobre nuevas masculinidades y salud emocional.</p>
                    </div>
                    <div class="image">
                        <img src="https://harta.uy/wp-content/uploads/2020/09/Harta_violencia-1.jpg" alt="Fundación 2014">
                    </div>
                </li>
                <li class="timeline-item timeline-item-left fade-in">
                    <div class="line"></div>
                    <div class="text">
                        <span class="year">2018</span>
                        <p>La fundación llega a dar certificados calificados por la Universidad San Francisco de Asis "USFA" para que aquellas personas egresadas de la fundación sean reconocidas y cuenten con su título.</p>
                    </div>
                    <div class="image">
                        <img src="https://i.ytimg.com/vi/3TDy-UzD3jE/maxresdefault.jpg" alt="Fundación 2018">
                    </div>
                </li>
                <li class="timeline-item fade-in">
                    <div class="line"></div>
                    <div class="text">
                        <span class="year">2025</span>
                        <p>Actualmente, seguimos trabajando con pasión y esperanza. Nuestra comunidad crece cada día, pero nuestra meta sigue siendo la misma: sanar, empoderar y transformar vidas.</p>
                    </div>
                    <div class="image">
                        <img src="https://coacharte.mx/wp-content/uploads/2023/11/empoderar-i-3-1024x684.webp" alt="Fundación 2023">
                    </div>
                </li>
            </ul>
        </section>

        <section id="vision-mission">
            <div class="vision-mission">
                <div class="fade-in">
                    <h3>Visión</h3>
                    <p>
                        Ser una institución líder en el ámbito de la formación en ciencias forenses en la región. Buscamos contribuir al desarrollo de la justicia y la seguridad pública, a través de la capacitación de expertos en áreas como criminalística, odontología forense, medicina forense, investigación de accidentes y psicomotricidad. Aspiramos a expandir nuestros programas educativos a nivel nacional e internacional, promoviendo la educación accesible para todos.
                    </p>
                </div>
                <div class="fade-in">
                    <h3>Misión</h3>
                    <p>
                        Proporcionar formación integral y especializada en ciencias forenses a través de programas educativos, dirigidos tanto a profesionales como a personas interesadas en estas disciplinas. Al mismo tiempo, también se enfoca en brindar oportunidades a personas en situación de vulnerabilidad, como víctimas de violencia y aquellos sin título de bachillerato, a través de becas y apoyos que faciliten su acceso a la educación.
                    </p>
                </div>
            </div>
        </section>
        </div>        
        @include('partials.footer')
    </div>
    <script src="{{ asset('JS/menu.js') }}"></script>
</body>
</html>
