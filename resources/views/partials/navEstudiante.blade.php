<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-fondo: #1A1A1A;
            --color-panel: #2D1E2F;
            --color-texto: #CCC9DC;
            --color-hover: #3b2e48;
            --color-activo: #CCC9DC;
            --color-texto-activo: #1A1A1A;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: var(--color-fondo);
            color: var(--color-texto);
            display: flex;
        }

        aside {
            width: 260px;
            background-color: var(--color-fondo);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .header {
            height: 64px;
            background-color: var(--color-panel);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            font-weight: bold;
            letter-spacing: 1px;
            color: var(--color-texto);
        }

        nav {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        nav h2 {
            font-size: 0.8rem;
            text-transform: uppercase;
            margin-bottom: 1rem;
            color: var(--color-texto);
        }

        nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.8rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--color-texto);
            margin-bottom: 0.5rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav a:hover {
            background-color: var(--color-hover);
            color: white;
        }

        nav a.active {
            background-color: var(--color-activo);
            color: var(--color-texto-activo);
        }

        /* Íconos con tamaño uniforme */
        nav i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* Responsivo: colapsar menú */
        @media (max-width: 768px) {
            aside {
                width: 100%;
                position: relative;
                z-index: 1000;
            }

            nav a {
                justify-content: center;
            }

            nav span {
                display: inline-block;
                margin-left: 10px;
            }

            .header {
                font-size: 1rem;
            }
        }

        .sidebar {
            width: 260px;
            background-color: #1A1A1A;
            color: #CCC9DC;
            min-height: 100vh;
            position: relative;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                height: 100vh;
                width: 260px;
                transition: left 0.3s ease-in-out;
                z-index: 999;
            }

            .sidebar.open {
                left: 0;
            }
        }

        .logout-btn {
            margin-top: auto;
            padding: 0.8rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #5c2e3a;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <div class="header">Panel del Estudiante</div>
        <nav>
            <!-- Inicio -->
            <a href="{{ route('estudiante.prinEstudiante') }}" class="text-[#127475] hover:text-[#e07a5f] text-lg font-semibold">
                <i class="fas fa-home"></i>
                <span>Inicio</span>
            </a>

            <!-- Mis Cursos 
            <a href="{{ route('estudiante.cursos') }}" class="{{ Request::is('estudiante/cursos') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span>Mis Cursos</span>
            </a>

            <!-- Horario 
            <a href="{{ route('estudiante.horario') }}" class="{{ Request::is('estudiante/horario') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Mi Horario</span>
            </a>

            <!-- Calificaciones 
            <a href="{{ route('estudiante.calificaciones') }}" class="{{ Request::is('estudiante/calificaciones') ? 'active' : '' }}">
                <i class="fas fa-star"></i>
                <span>Calificaciones</span>
            </a>

            <!-- Asistencia 
            <a href="{{ route('estudiante.asistencia') }}" class="{{ Request::is('estudiante/asistencia') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check"></i>
                <span>Mi Asistencia</span>
            </a>

            <!-- Pagos 
            <a href="{{ route('estudiante.pagos') }}" class="{{ Request::is('estudiante/pagos') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i>
                <span>Pagos y Facturas</span>
            </a>
            <!-- Botón de Cerrar Sesión -->
            <form action="{{ route('logout') }}" method="POST" class="logout-btn">
                @csrf
                <button type="submit" class="w-full text-left flex items-center gap-3 text-current bg-transparent border-none">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </nav>
    </aside>
</body>

</html>