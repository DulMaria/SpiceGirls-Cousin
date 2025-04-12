<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Fundación Criminología</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('partials.navAdmi')

        <!-- Main Content -->
        <main class="flex-1 p-10">
            <div class="border-b pb-4 mb-6 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-[#2e1a47]">Panel de Administración</h1>
                <span class="text-sm text-gray-500">Bienvenido al sistema de gestión</span>
            </div>

            <!-- Aquí irá el contenido dinámico de cada módulo -->
            <div class="bg-white p-8 rounded-lg shadow text-center text-gray-600">
                <p class="text-lg">Selecciona una opción en el menú lateral izquierdo para comenzar.</p>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-[#1a1a1a] text-gray-300 text-center py-4">
        <p class="text-sm">&copy; 2025 Fundación Criminología Forense. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
