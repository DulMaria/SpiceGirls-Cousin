<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Áreas - Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('CSS/promocion.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        input.border-red-500,
        textarea.border-red-500 {
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
        <div class="p-8 w-full">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-[#2e1a47]">Gestión de Áreas</h1>
                <button onclick="toggleModal('modalAdd')"
                    class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg shadow">
                    + Añadir Área
                </button>
            </div>

            <!-- Listado de Áreas en tarjetas -->
            <div class="row">
                @forelse ($areas as $area)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                @if ($area->imagenArea)
                                    <div class="text-center mb-3">
                                        <img src="data:image/jpeg;base64,{{ base64_encode($area->imagenArea) }}"
                                            class="w-40 h-40 rounded-full object-cover mx-auto" alt="Imagen del área">
                                    </div>
                                @endif

                                <h5 class="card-title font-bold text-xl">{{ $area->nombreArea }}</h5>
                                <p class="card-text text-gray-600 mb-4">{{ $area->descripcionArea }}</p>

                                <div class="flex justify-center space-x-2">
                                    <button data-id="{{ $area->ID_Area }}" data-nombre="{{ $area->nombreArea }}"
                                        data-descripcion="{{ $area->descripcionArea }}"
                                        data-imagen="{{ $area->imagenArea ? base64_encode($area->imagenArea) : '' }}"
                                        onclick="handleEditButtonClick(this)"
                                        class="editar-curso bg-purple-800 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                                        <i class="bi bi-pencil-fill"></i> Editar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-8 bg-white rounded-lg shadow">
                            <p class="text-gray-500">No hay áreas registradas aún.</p>
                        </div>
                    </div>
                @endforelse
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
                        <input type="text" name="nombreArea" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            placeholder="Ej. Criminalística" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Descripción del Área</label>
                        <textarea name="descripcionArea" required class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            placeholder="Descripción breve..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Imagen del Área</label>
                        <input type="file" name="imagenArea" accept="image/*"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2" />
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="toggleModal('modalAdd')"
                            class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Cancelar</button>
                        <button type="submit"
                            class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg">Guardar</button>
                    </div>
                </form>
                <button onclick="toggleModal('modalAdd')"
                    class="absolute top-2 right-3 text-gray-500 hover:text-black text-xl">&times;</button>
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
                        <input type="text" id="editNombre" name="nombreArea" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Descripción del Área</label>
                        <textarea id="editDescripcion" name="descripcionArea" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Imagen del Área (opcional)</label>
                        <input type="file" name="imagenArea" accept="image/*"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2" />
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="toggleModal('modalEdit')"
                            class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">Cancelar</button>
                        <button type="submit"
                            class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg">Actualizar</button>
                    </div>
                </form>
                <button type="button" onclick="toggleModal('modalEdit')"
                    class="absolute top-2 right-3 text-gray-500 hover:text-black text-xl">&times;</button>
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

            // Get the current image container (or create one if it doesn't exist)
            let imagePreviewContainer = document.getElementById('currentImagePreview');
            if (!imagePreviewContainer) {
                imagePreviewContainer = document.createElement('div');
                imagePreviewContainer.id = 'currentImagePreview';
                imagePreviewContainer.className = 'mb-4';

                // Insert it before the file input in the edit form
                const fileInputContainer = document.querySelector('#modalEdit [name="imagenArea"]').parentNode;
                fileInputContainer.parentNode.insertBefore(imagePreviewContainer, fileInputContainer);
            }

            // Update or clear the image preview
            const imageData = event.currentTarget.dataset.imagen;
            if (imageData) {
                imagePreviewContainer.innerHTML = `
                    <p class="mb-2 font-medium">Imagen actual:</p>
                    <img src="data:image/jpeg;base64,${imageData}" alt="Imagen actual" class="w-32 h-32 object-cover rounded-lg border">
                    <p class="text-xs text-gray-500 mt-1">Sube una nueva imagen para reemplazarla o deja el campo vacío para mantener esta.</p>
                `;
            } else {
                imagePreviewContainer.innerHTML = '<p class="text-gray-500 italic mb-2">Sin imagen actual</p>';
            }

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
