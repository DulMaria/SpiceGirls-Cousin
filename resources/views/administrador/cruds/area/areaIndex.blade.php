<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Áreas - Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <!-- Menú lateral -->
    @include('partials.navAdmi')
    <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilAdmin')
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-[#2e1a47]">Gestión de Áreas</h1>
                <button onclick="toggleModal('modalAdd')" class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg shadow">
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
                        @forelse ($areas as $index => $area)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $area->nombreArea }}</td>
                            <td class="px-6 py-4">{{ $area->descripcionArea }}</td>
                            <td class="px-6 py-4">
                                @if ($area->imagenArea)
                                <img src="data:image/jpeg;base64,{{ base64_encode($area->imagenArea) }}" class="w-12 h-12 rounded-full" alt="Imagen del área">
                                @else
                                <span class="text-gray-400 italic">Sin imagen</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="openEditModal({{ $area->ID_Area }}, '{{ addslashes($area->nombreArea) }}', '{{ addslashes($area->descripcionArea) }}')" class="text-blue-600 hover:underline">
                                    <!-- Icono de lápiz SVG ajustado -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6" stroke="currentColor">
                                        <path opacity="0.5" d="M1 12C1 6.81455 1 4.22183 2.61091 2.61091C4.22183 1 6.81455 1 12 1C17.1854 1 19.7782 1 21.3891 2.61091C23 4.22183 23 6.81455 23 12C23 17.1854 23 19.7782 21.3891 21.3891C19.7782 23 17.1854 23 12 23C6.81455 23 4.22183 23 2.61091 21.3891C1 19.7782 1 17.1854 1 12Z" fill="#1c4a25"></path>
                                        <path d="M13.9261 14.3018C14.1711 14.1107 14.3933 13.8885 14.8377 13.4441L20.378 7.90374C20.512 7.7698 20.4507 7.53909 20.2717 7.477C19.6178 7.25011 18.767 6.82414 17.9713 6.02835C17.1755 5.23257 16.7495 4.38186 16.5226 3.72788C16.4605 3.54892 16.2298 3.48761 16.0959 3.62156L10.5555 9.16192C10.1111 9.60634 9.88888 9.82854 9.69778 10.0736C9.47235 10.3626 9.27908 10.6753 9.12139 11.0062C8.98771 11.2867 8.88834 11.5848 8.68959 12.181L8.43278 12.9515L8.02443 14.1765L7.64153 15.3252C7.54373 15.6186 7.6201 15.9421 7.8388 16.1608C8.0575 16.3795 8.38099 16.4559 8.67441 16.3581L9.82308 15.9752L11.0481 15.5668L11.8186 15.31L11.8186 15.31C12.4148 15.1113 12.7129 15.0119 12.9934 14.8782C13.3243 14.7205 13.637 14.5273 13.9261 14.3018Z" fill="#1c4a25"></path>
                                        <path d="M22.1127 6.16905C23.2952 4.98656 23.2952 3.06936 22.1127 1.88687C20.9302 0.704377 19.013 0.704377 17.8306 1.88687L17.6524 2.06499C17.4806 2.23687 17.4027 2.47695 17.4456 2.7162C17.4726 2.8667 17.5227 3.08674 17.6138 3.3493C17.796 3.87439 18.14 4.56368 18.788 5.21165C19.4359 5.85961 20.1252 6.20364 20.6503 6.38581C20.9129 6.4769 21.1329 6.52697 21.2834 6.55399C21.5227 6.59693 21.7627 6.51905 21.9346 6.34717L22.1127 6.16905Z" fill="#1c4a25"></path>
                                    </svg>
                                </button>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No hay áreas registradas aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal para Añadir Área -->
        <div id="modalAdd" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">
                <h2 class="text-2xl font-semibold mb-4 text-[#2e1a47]">Añadir Nueva Área</h2>
                <form action="{{ route('admin.areas.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Nombre del Área</label>
                        <input type="text" name="nombreArea" required class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Ej. Criminalística" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Descripción del Área</label>
                        <textarea name="descripcionArea" required class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Descripción breve..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Imagen del Área</label>
                        <input type="file" name="imagenArea" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" />
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="toggleModal('modalAdd')" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Cancelar</button>
                        <button type="submit" class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg">Guardar</button>
                    </div>
                </form>
                <button onclick="toggleModal('modalAdd')" class="absolute top-2 right-3 text-gray-500 hover:text-black text-xl">&times;</button>
            </div>
        </div>

        <!-- Modal para Editar Área -->
        <div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">
                <h2 class="text-2xl font-semibold mb-4 text-[#2e1a47]">Editar Área</h2>
                <form id="formEdit" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editId" name="id">
                    <input type="hidden" name="_method" value="PUT" />
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Nombre del Área</label>
                        <input type="text" id="editNombre" name="nombreArea" required class="w-full border border-gray-300 rounded-lg px-3 py-2" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Descripción del Área</label>
                        <textarea id="editDescripcion" name="descripcionArea" required class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Imagen del Área (opcional)</label>
                        <input type="file" name="imagenArea" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" />
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="toggleModal('modalEdit')" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Cancelar</button>
                        <button type="submit" class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg">Actualizar</button>
                    </div>
                </form>
                <button type="button" onclick="toggleModal('modalEdit')" class="absolute top-2 right-3 text-gray-500 hover:text-black text-xl">&times;</button>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            document.getElementById(id).classList.toggle('hidden');
        }

        function openEditModal(id, nombre, descripcion) {
            document.getElementById('editNombre').value = nombre;
            document.getElementById('editDescripcion').value = descripcion;
            document.getElementById('editId').value = id;

            const form = document.getElementById('formEdit');
            form.action = `/administrador/areas/actualizar/${id}`;

            toggleModal('modalEdit');
        }

        document.getElementById('formEdit').addEventListener('submit', async function(event) {
            event.preventDefault();

            const form = this;
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');

            // Deshabilitar botón durante el envío
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Procesando... <i class="fa fa-spinner fa-spin"></i>';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Error en el servidor');
                }

                // Recargar la página con mensaje de éxito
                window.location.href = data.redirect + '?success=' + encodeURIComponent(data.message);

            } catch (error) {
                console.error('Error:', error);

                // Mostrar error al usuario
                const errorDiv = document.createElement('div');
                errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded';
                errorDiv.textContent = error.message;
                document.body.appendChild(errorDiv);

                setTimeout(() => errorDiv.remove(), 5000);

            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Actualizar';
            }
        });
    </script>
</body>

</html>