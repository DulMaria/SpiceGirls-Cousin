<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas</title>
    <link rel="stylesheet" href="{{ asset('CSS/styleGeneral.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/pie_pag.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/promocion.css') }}">
</head>

<body>
    <div class="menu-btn">&#9776; Menu</div>
    @include('partials.nav')

    <div id="main-content" class="content">
        <div class="title">
            <h1>Ofertas Disponibles</h1>
        </div>

        <div class="row">
            @foreach ($ofertas as $oferta)
            @if ($oferta->estado == 1 && $oferta->tipo == 0 ) 
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $oferta->descripcion }}</h5>
                        <p class="card-text">Descuento: {{ $oferta->descuento }}%</p>
                        <p class="card-text">Válida desde: {{ $oferta->fechaInicio }} hasta: {{ $oferta->fechaFin }}</p>

                        <!-- Mostrar los cursos asociados -->
                        <!-- Mostrar los cursos asociados solo si hay -->
                        @if ($oferta->cursos->isNotEmpty())
                        <h6>Cursos asociados:</h6>
                        <ul>
                            @foreach ($oferta->cursos as $curso)
                            <li>{{ $curso->nombreCurso }}</li>
                            @endforeach
                        </ul>
                        @endif


                        <!-- Botón que activa el modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#becaModal{{ $oferta->ID_Promo }}">
                            Ver más
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="becaModal{{ $oferta->ID_Promo }}" tabindex="-1" aria-labelledby="becaModalLabel{{ $oferta->ID_Promo }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="becaModalLabel{{ $oferta->ID_Promo }}">{{ $oferta->descripcion }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Descuento:</strong> {{ $oferta->descuento }}%</p>
                            <p><strong>Fecha de Inicio:</strong> {{ $oferta->fechaInicio }}</p>
                            <p><strong>Fecha de Fin:</strong> {{ $oferta->fechaFin }}</p>
                            <p><strong>Tipo:</strong> Oferta</p>
                            <p><strong>Descripción:</strong> {{ $oferta->descripcion }}</p>

                            <!-- Mostrar los cursos en el modal -->
                            <!-- Mostrar los cursos en el modal solo si hay -->
                            @if ($oferta->cursos->isNotEmpty())
                            <h6>Cursos asociados:</h6>
                            <ul>
                                @foreach ($oferta->cursos as $curso)
                                <li>{{ $curso->nombreCurso }}</li>
                                @endforeach
                            </ul>
                            @endif

                            <!-- Botón de WhatsApp dentro del modal -->
                            <a class="btn btn-success mt-3"
                                href="https://wa.me/59177762869?text={{ urlencode('Hola, estoy interesado/a en la oferta: ' . $oferta->descripcion . '. Quisiera recibir más información sobre la oferta disponibles y los requisitos para acceder.')}}"
                                target="_blank">
                                Comunicarse por WhatsApp
                            </a>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach

        </div><br>
        @include('partials.footer')
    </div>

    <script>
        // Reemplazo de data-bs-toggle para mostrar el modal personalizado
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-bs-target').replace('#', '');
                const modal = document.getElementById(targetId);
                if (modal) modal.classList.add('show');
            });
        });

        document.querySelectorAll('.btn-close, .modal-footer .btn-secondary').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.modal').classList.remove('show');
            });
        });
    </script>
    <script src="{{ asset('JS/menu.js') }}"></script>
</body>

</html>