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
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <div class="header">Admin Panel</div>
        <nav>
            <a href="{{ route('administrador.prinAdmi') }}" class="text-[#127475] hover:text-[#e07a5f] text-lg font-semibold">
                <i class="fas fa-home mr-2"></i>
                Inicio
            </a>

            <a href="/administrador/areas" class="{{ Request::is('administrador/areas') ? 'active' : '' }}">
                <i class="fas fa-building"></i>
                <span>Gestionar Áreas</span>
            </a>

            <a href="/administrador/cursos" class="{{ Request::is('admininistrador/cursos') ? 'active' : '' }}">
                <i class="fas fa-book-open"></i>
                <span>Gestionar Cursos</span>
            </a>

            <a href="/admin/docentes" class="{{ Request::is('admin/docentes') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Gestionar Docentes</span>
            </a>

            <a href="/admin/estudiantes" class="{{ Request::is('admin/estudiantes') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Gestionar Estudiantes</span>
            </a>

            <a href="/admin/reportes" class="{{ Request::is('admin/reportes') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Reportes</span>
            </a>

            <a href="/admin/estadisticas" class="{{ Request::is('admin/estadisticas') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Estadísticas</span>
            </a>
        </nav>
    </aside>
</body>

</html>