<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Áreas - Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-[#2e1a47]">Gestión de Áreas</h1>
            <button onclick="toggleModal()" class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg shadow">
                + Añadir Área
            </button>
        </div>

        <!-- Tabla de Áreas -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left">
                <thead class="bg-[#1f1b2e] text-white">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Nombre del Área</th>
                        <th class="px-6 py-3">Descripción</th>
                        <th class="px-6 py-3">Imagen</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ejemplo estático -->
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-6 py-4">1</td>
                        <td class="px-6 py-4">Criminología</td>
                        <td class="px-6 py-4">Área enfocada al análisis del delito.</td>
                        <td class="px-6 py-4"><img src="https://via.placeholder.com/50" alt="img" class="w-12 h-12 rounded-full"></td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-blue-600 hover:underline mr-3">Editar</button>
                            <button class="text-red-600 hover:underline">Eliminar</button>
                        </td>
                    </tr>
                    <!-- Puedes duplicar filas para simular más datos -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">
            <h2 class="text-2xl font-semibold mb-4 text-[#2e1a47]">Añadir Nueva Área</h2>
            <form>
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Nombre del Área</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Ej. Criminalística">
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Descripción del Área</label>
                    <textarea class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Descripción breve..."></textarea>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Imagen del Área</label>
                    <input type="file" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="toggleModal()" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Cancelar</button>
                    <button type="submit" onclick="confirmarCRUD(event)" class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg">Guardar</button>
                </div>
            </form>

            <!-- Botón de cierre -->
            <button onclick="toggleModal()" class="absolute top-2 right-3 text-gray-500 hover:text-black text-xl">&times;</button>
        </div>
    </div>

    <!-- Confirmación flotante -->
    <div id="toast" class="fixed top-6 right-6 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden transition-opacity duration-500">
        <p>Área registrada exitosamente ✅</p>
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
        }

        function confirmarCRUD(e) {
            e.preventDefault();
            toggleModal();
            const toast = document.getElementById('toast');
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
</html>
