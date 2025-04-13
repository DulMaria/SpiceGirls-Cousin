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

    <!-- Menú lateral -->
    @include('partials.navAdmi')

    <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilAdmin')        

        <!-- Contenido principal -->
        <main class="flex-1 px-4 py-6 md:px-10 md:py-8 mt-0">
            <div class="border-b pb-4 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <h1 class="text-2xl sm:text-3xl font-bold text-[#2e1a47] leading-tight">Panel de Administración</h1>
                <span class="text-sm text-gray-500">Bienvenido al sistema de gestión</span>
            </div>

            <div class="bg-white p-4 sm:p-6 md:p-8 rounded-lg shadow text-center text-gray-600">
                <p class="text-base sm:text-lg">Selecciona una opción en el menú lateral izquierdo para comenzar.</p>
            </div>
        </main>
    </div>
</body>
</html>
