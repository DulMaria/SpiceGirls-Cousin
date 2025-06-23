<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistema Gestión Académica</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --color-fondo: #1A1A1A;
            --color-panel: #2D1E2F;
            --color-texto: #CCC9DC;
            --color-hover: #3b2e48;
            --color-activo: #127475;
            --color-texto-activo: #ffffff;
            --color-accent: #e07a5f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--color-fondo);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        /* Header del sidebar */
        .sidebar-header {
            height: 70px;
            background: linear-gradient(135deg, var(--color-panel), var(--color-activo));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-texto-activo);
            font-size: 1.4rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-bottom: 3px solid var(--color-accent);
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .sidebar-header:hover::before {
            left: 100%;
        }

        .sidebar-header i {
            margin-right: 10px;
            font-size: 1.6rem;
        }

        /* Navegación */
        .sidebar-nav {
            padding: 1.5rem 1rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--color-texto);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(135deg, var(--color-activo), var(--color-accent));
            transition: width 0.3s ease;
            border-radius: 10px;
        }

        .nav-item:hover::before {
            width: 4px;
        }

        .nav-item:hover {
            background-color: var(--color-hover);
            color: var(--color-accent);
            transform: translateX(8px);
            box-shadow: 0 4px 15px rgba(224, 122, 95, 0.2);
        }

        .nav-item.active {
            background: linear-gradient(135deg, var(--color-activo), #0f5a5b);
            color: var(--color-texto-activo);
            box-shadow: 0 6px 20px rgba(18, 116, 117, 0.4);
            transform: translateX(8px);
        }

        .nav-item.active::before {
            width: 4px;
            background: var(--color-accent);
        }

        .nav-item i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            z-index: 1;
            position: relative;
        }

        .nav-item span {
            font-weight: 500;
            z-index: 1;
            position: relative;
        }

        /* Contenido principal */
        .main-content {
            margin-left: 260px;
            padding: 2rem;
            min-height: 100vh;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1001;
                background: var(--color-activo);
                color: white;
                border: none;
                border-radius: 8px;
                padding: 10px 12px;
                font-size: 1.1rem;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            }

            .mobile-toggle:hover {
                background: var(--color-accent);
                transform: scale(1.05);
            }
        }

        /* Overlay para móvil */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        @media (max-width: 768px) {
            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
</head>

<body>
    <!-- Toggle para móvil -->
    <button class="mobile-toggle d-md-none" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Overlay para móvil -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-graduation-cap"></i>
            <span>Academia</span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('docente.prinDocente') }}" class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Inicio</span>
            </a>

            <a href="{{ route('docente.misCursos') }}"
                class="nav-item {{ Route::currentRouteName() == 'docente.misCursos' ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span>Mis Cursos</span>
            </a>

            <a href="https://classroom.google.com" target="_blank" class="nav-item">
                <i class="fab fa-google"></i>
                <span>Google Classroom</span>
            </a>

            <a href="{{ route('docente.zoom.crear') }}" class="nav-item">
                <i class="fas fa-video"></i>
                <span>Crear Zoom</span>
            </a>

            <a href="#" class="nav-item" style="margin-top: auto; color: #ff6b6b;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Cerrar Sesión</span>
            </a>
        </nav>
    </aside>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');

            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        // Cerrar sidebar al hacer clic en un enlace en móvil
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>

</html>
