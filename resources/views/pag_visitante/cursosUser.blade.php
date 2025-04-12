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
            <h1>Cursos Disponibles</h1>
            <p>Explora nuestros cursos principales y cortos para mejorar tus habilidades.</p>
        </div>

        <section class="course-section">
            <div class="course-item">
                <div class="course-img">
                    <img src="https://universidadeuropea.com/resources/media/images/criminologia-y-derecho-800x450.original.jpg" alt="Cursos Principales">
                </div>
                <div class="course-text">
                    <h2>Cursos Principales</h2>
                    <a href="{{ url('/cursosPrincipales') }}" class="btn">Explorar Cursos</a>
                </div>
            </div>

            <div class="course-item">
                <div class="course-img">
                    <img src="https://blogs.iadb.org/salud/wp-content/uploads/sites/15/2020/08/SPH_Newsletters_Blogs_AUG10_GS-POST.png" alt="Cursos Cortos">
                </div>
                <div class="course-text">
                    <h2>Cursos Cortos</h2>
                    <a href="{{ url('/cursosCortos') }}" class="btn">Ver más</a>
                </div>
            </div>
           
        </section>
        @include('partials.footer')
    </div>
    <script src="{{ asset('JS/menu.js') }}"></script>
</body>
</html>
