<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos - Página Principal</title>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('CSS/styleGeneral.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/pie_pag.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/cursosVisitante.css') }}">
</head>
<body>
    <div class="menu-btn">&#9776; Menu</div>
    @include('partials.nav')

    <!-- Sección de cursos -->
    <div id="main-content" class="content">
        <div class="title">
            <h1>Novedades</h1>
            <p>Unete y aprovecha las oportunidades que te daremos a lo largo de tu viaje.</p>
        </div>
        <section class="course-section">
            <div class="course-item">
                <div class="course-img">
                    <img src="https://www.aauniv.com/s/blog/wp-content/uploads/2020/12/tipos-becas-estudiar-universidad-distancia-aau.jpg" alt="Cursos Principales">
                </div>
                <div class="course-text">
                    <h2>Becas</h2>
                    <a href="{{ url('/becasEstudiante') }}" class="btn">Explorar tus Becas</a>
                </div>
            </div>

            <div class="course-item">
                <div class="course-img">
                    <img src="https://img.static-af.com/transform/6c735e9c-4ea3-4e79-9a5c-0f054c80a0bd/" alt="Cursos Cortos">
                </div>
                <div class="course-text">
                    <h2>Ofertas</h2>
                    <a href="{{ url('/ofertasEstudiante') }}" class="btn">Ofertas del mes</a>
                </div>
            </div>
           
        </section>
        @include('partials.footer')
    </div>
    <script src="{{ asset('JS/menu.js') }}"></script>
</body>
</html>
