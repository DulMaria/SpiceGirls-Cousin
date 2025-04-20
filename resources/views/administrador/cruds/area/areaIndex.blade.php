<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Áreas - Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
    input.border-red-500, textarea.border-red-500 {
        border: 1px solid #f56565 !important;
        background-color: #fff5f5 !important;
    }
    .error-message {
        color: #e53e3e !important;
        font-size: 0.75rem !important;
        margin-top: 0.25rem !important;
        display: block !important;
    }
    </style>
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
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded flex items-center gap-2"
                                    data-id="{{ $area->ID_Area }}"
                                    data-nombre="{{ $area->nombreArea }}"
                                    data-descripcion="{{ $area->descripcionArea }}"
                                    onclick="handleEditButtonClick(this)">
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
        
        function handleEditButtonClick(button) {
            const id = button.dataset.id;
            const nombre = button.dataset.nombre;
            const descripcion = button.dataset.descripcion;

            openEditModal(id, nombre, descripcion);
        }


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




                // Función para validar campo y mostrar error
        function validarCampo(input, condicion, mensajeError) {
        // Eliminar mensajes de error anteriores
        const errorMsgExistente = input.parentNode.querySelector('.error-message');
        if (errorMsgExistente) {
            errorMsgExistente.remove();
        }

        // Quitar clase de error
        input.classList.remove('border-red-500');

        // Si no cumple la condición, mostrar error
        if (!condicion) {
            input.classList.add('border-red-500');
            const errorMsg = document.createElement('span');
            errorMsg.className = 'error-message text-red-500 text-xs mt-1 block';
            errorMsg.textContent = mensajeError;
            input.parentNode.appendChild(errorMsg);
            return false;
        }
        return true;
        }

        // Validar nombre del área (solo letras y espacios, máximo 50 caracteres)
        function validarNombreArea(input) {
        // Reemplazar caracteres no permitidos mientras escribe
        input.value = input.value.replace(/[^A-Za-zÁáÉéÍíÓóÚúÑñ\s]/g, '');

        // Limitar a 50 caracteres
        if (input.value.length > 50) {
            input.value = input.value.substring(0, 50);
        }

        // Validar que no esté vacío y solo contenga letras
        return validarCampo(
            input,
            input.value.trim() !== '' && /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/.test(input.value),
            'El nombre solo debe contener letras (máximo 50 caracteres) y es obligatorio'
        );
        }

        // Validar descripción del área (máximo 200 caracteres)
        function validarDescripcionArea(input) {
        // Limitar a 200 caracteres
        if (input.value.length > 200) {
            input.value = input.value.substring(0, 200);
        }

        // Validar que no esté vacío
        return validarCampo(
            input,
            input.value.trim() !== '',
            'La descripción es obligatoria (máximo 200 caracteres)'
        );
        }

        // Validar campo obligatorio
        function validarObligatorio(input) {
        return validarCampo(
            input,
            input.value.trim() !== '',
            'Este campo es obligatorio'
        );
        }

        // Validar imagen (tipo de archivo)
        function validarImagen(input) {
        if (!input.files || input.files.length === 0) {
            // Si es un modal de edición, la imagen puede ser opcional
            if (input.closest('form').id === 'formEdit') {
            return true;
            }
            return validarCampo(input, false, 'Debe seleccionar una imagen');
        }
        
        const archivo = input.files[0];
        const tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        
        return validarCampo(
            input,
            tiposPermitidos.includes(archivo.type),
            'El archivo debe ser una imagen (JPG, PNG o GIF)'
        );
        }

        // Función para validar formulario completo antes de enviar
        function validarFormularioArea(event) {
        const form = event.target;
        let formValido = true;

        // Validar nombre del área
        const nombreArea = form.querySelector('[name="nombreArea"]');
        if (nombreArea && !validarNombreArea(nombreArea)) formValido = false;

        // Validar descripción del área
        const descripcionArea = form.querySelector('[name="descripcionArea"]');
        if (descripcionArea && !validarDescripcionArea(descripcionArea)) formValido = false;

        // Validar imagen (solo en formulario de añadir)
        const imagenArea = form.querySelector('[name="imagenArea"]');
        if (imagenArea && !validarImagen(imagenArea)) formValido = false;

        // Prevenir envío si hay errores
        if (!formValido) {
            event.preventDefault();
            return false;
        }

        return true;
        }

        // Agregar estilos CSS para los campos con error
        function agregarEstilosValidacion() {
        if (!document.getElementById('validacion-estilos')) {
            const style = document.createElement('style');
            style.id = 'validacion-estilos';
            style.innerHTML = `
            input.border-red-500, textarea.border-red-500 {
                border: 1px solid #f56565 !important;
                background-color: #fff5f5 !important;
            }
            .error-message {
                color: #e53e3e !important;
                font-size: 0.75rem !important;
                margin-top: 0.25rem !important;
                display: block !important;
            }
            `;
            document.head.appendChild(style);
        }
        }

        // Inicializar validaciones
        document.addEventListener('DOMContentLoaded', function() {
        // Agregar estilos CSS
        agregarEstilosValidacion();

        // Establecer atributos maxlength directamente en los elementos
        document.querySelectorAll('input[name="nombreArea"]')
            .forEach(input => {
            input.setAttribute('maxlength', '50');
            input.setAttribute('required', 'required');
            });

        document.querySelectorAll('textarea[name="descripcionArea"]')
            .forEach(textarea => {
            textarea.setAttribute('maxlength', '200');
            textarea.setAttribute('required', 'required');
            });

        // Validar formularios al enviar
        const formularios = document.querySelectorAll('#modalAdd form, #formEdit');
        formularios.forEach(form => {
            form.addEventListener('submit', validarFormularioArea);
        });

        // Validar nombre del área en tiempo real
        const camposNombre = document.querySelectorAll('input[name="nombreArea"]');
        camposNombre.forEach(input => {
            input.addEventListener('input', () => validarNombreArea(input));
            input.addEventListener('blur', () => validarNombreArea(input));
        });

        // Validar descripción del área en tiempo real
        const camposDescripcion = document.querySelectorAll('textarea[name="descripcionArea"]');
        camposDescripcion.forEach(textarea => {
            textarea.addEventListener('input', () => validarDescripcionArea(textarea));
            textarea.addEventListener('blur', () => validarDescripcionArea(textarea));
        });

        // Validar imagen del área al cambiar
        const camposImagen = document.querySelectorAll('input[name="imagenArea"]');
        camposImagen.forEach(input => {
            input.addEventListener('change', () => validarImagen(input));
        });
        });
    </script>
</body>

</html>