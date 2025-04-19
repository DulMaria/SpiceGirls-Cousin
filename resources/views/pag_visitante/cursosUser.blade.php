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

    <!-- Sección de áreas -->
    <div id="main-content" class="content">
        <section class="hero"><br>
            <div class="hero-content">
                <h1>Áreas de Cursos</h1>
                <p>Explora nuestras áreas temáticas y descubre los cursos que ofrecemos en cada una.</p>
            </div><br>
        </section>

        <section class="course-section">
            @forelse($areas as $area)
            <div class="course-item">
                <div class="course-img">
                    @if($area->imagenArea)
                    <img src="data:image/jpeg;base64,{{ base64_encode($area->imagenArea) }}" alt="{{ $area->nombreArea }}">
                    @else
                    <img src="https://via.placeholder.com/400x250?text=Sin+imagen" alt="Sin imagen">
                    @endif
                </div>

                <div class="course-text">
                    <h2>{{ $area->nombreArea }}</h2>
                    <p>{{ $area->descripcionArea }}</p>
                    <br>
                    <a class="btn" href="{{ route('pag_visitante.curso_asociado', ['id' => $area->ID_Area]) }}">Ver cursos</a>
                </div>
            </div>
            @empty
            <p>No hay áreas registradas por el momento.</p>
            @endforelse
        </section>

        @include('partials.footer')
    </div>

    <script src="{{ asset('JS/menu.js') }}"></script>
</body>

</html>