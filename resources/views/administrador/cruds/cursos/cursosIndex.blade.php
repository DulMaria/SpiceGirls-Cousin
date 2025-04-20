<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos - Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Estilos adicionales para el modal */
        #modal {
            max-height: 90%;
            /* Ajusta la altura máxima */
            overflow-y: auto;
            /* Permite el desplazamiento vertical */
            max-width: 80%;
            /* Limita el ancho del modal */
            margin: auto;
        }
        /* Estilos adicionales para validación de campos */
    input.border-red-500, textarea.border-red-500, select.border-red-500 {
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
                <h1 class="text-3xl font-bold text-[#2e1a47]">Gestión de Cursos</h1>
                <button onclick="toggleModal()" class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg shadow">
                    + Añadir Curso
                </button>
            </div>

            <!-- Tabla de Cursos -->
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-[#1f1b2e] text-white">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Nombre del Área</th>
                            <th class="px-6 py-3">Nombre del Curso</th>
                            <th class="px-6 py-3">Descripción</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Imagen</th>
                            <th class="px-6 py-3">Módulos</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cursos as $curso)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $curso->ID_Curso }}</td>
                            <td class="px-6 py-4">{{ $curso->area->nombreArea ?? 'Sin Área' }}</td>
                            <td class="px-6 py-4">{{ $curso->nombreCurso }}</td>
                            <td class="px-6 py-4">{{ $curso->descripcionCurso }}</td>
                            <td class="px-6 py-4">{{ $curso->estado == 1 ? 'Activo' : 'Inactivo' }}</td>
                            <td class="px-6 py-4">
                                @if ($curso->imagen)
                                <img src="data:image/jpeg;base64,{{ base64_encode($curso->imagen) }}"
                                    alt="Imagen Curso"
                                    class="w-12 h-12 object-cover rounded-full">
                                @else
                                <img src="https://via.placeholder.com/50"
                                    alt="Sin imagen"
                                    class="w-12 h-12 object-cover rounded-full">
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center" x-data="{ showModal: false }">
                                <!-- Botón que activa el modal -->
                                <button
                                    type="button"
                                    @click="showModal = !showModal"
                                    class="bg-black hover:bg-black-700 text-white px-3 py-2 rounded-full flex items-center justify-center gap-2">
                                    
                                    <template x-if="!showModal">
                                        <i class="bi bi-eye-slash text-lg"></i> <!-- Ojo cerrado -->
                                    </template>

                                    <template x-if="showModal">
                                        <i class="bi bi-eye text-lg"></i> <!-- Ojo abierto -->
                                    </template>

                                </button>


                                <!-- Modal -->
                                <div
                                    x-show="showModal"
                                    x-transition
                                    class="fixed inset-0 z-50 flex items-center justify-center"
                                    style="background-color: rgba(0, 0, 0, 0.5);">
                                    <div class="bg-white rounded-lg shadow-lg z-50 max-w-md w-full p-6 relative">
                                        <h2 class="text-xl font-semibold mb-4">Módulos del Curso</h2>

                                        <ol class="list-decimal pl-5 space-y-2 max-h-64 overflow-y-auto">
                                            @foreach ($curso->modulos->sortBy('orden') as $modulo)
                                            <li>
                                                <div class="font-medium">{{ $modulo->nombreModulo }}</div>
                                                <div class="text-sm text-gray-500">{{ $modulo->descripcion_modulo }}</div>
                                            </li>
                                            @endforeach
                                        </ol>

                                        <!-- Botón de cerrar -->
                                        <button
                                            @click="showModal = false"
                                            class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl font-bold">
                                            &times;
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                            <div class="flex items-center gap-4"> <!-- Contenedor flex con espacio entre botones -->
                                <!-- Botón de Editar -->
                                <button type="button"
                                    data-curso-id="{{ $curso->ID_Curso }}"
                                    class="editar-curso bg-purple-800 hover:bg-purple-700 text-white px-4 py-3 rounded-full flex items-center gap-5">
                                    <!-- Nuevo ícono de Bootstrap -->
                                    <i class="bi bi-pencil-fill"></i> 
                                </button>


                                <!-- Formulario Habilitar / Deshabilitar -->
                                <form method="POST" action="{{ route('curso.cambiarEstado', ['id' => $curso->ID_Curso]) }}"
                                    class="inline" onsubmit="return confirm('¿Estás seguro de cambiar el estado de este curso?');">
                                    @csrf
                                    <button type="submit"
                                        class="{{ $curso->estado == 1 
                                            ? 'bg-[#2ecc71] hover:bg-[#27ae60]'  /* Rojo para deshabilitar */
                                            : 'bg-[#e74c3c] hover:bg-[#c0392b] ' }} /* Verde para habilitar */
                                            text-white px-4 py-3 rounded-full flex items-center gap-3 text-sm font-medium shadow-sm transition duration-300">
                                        
                                        @if ($curso->estado == 1)
                                        <!-- Icono de deshabilitar de Bootstrap -->
                                        <i class="bi bi-check-circle-fill"></i> 
                                        @else
                                        <!-- Icono de habilitar de Bootstrap -->
                                        <i class=" bi bi-x-circle-fill"></i> 
                                        @endif
                                    </button>
                                </form>
                            </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal para Añadir Curso -->
        <div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
            <div class="bg-white p-8 rounded-lg shadow-lg w-11/12 max-h-[90vh] overflow-y-auto">
                <h2 class="text-2xl font-semibold mb-4">Añadir Nuevo Curso</h2>
                <form action="{{ route('ruta.del.controlador') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="nombreCurso" class="block text-sm font-medium text-gray-700">Nombre del Curso</label>
                        <input type="text" id="nombreCurso" name="nombreCurso" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="descripcionCurso" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea id="descripcionCurso" name="descripcionCurso" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="estado" name="estado" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="area" class="block text-sm font-medium text-gray-700">Área</label>
                        <select id="area" name="ID_Area" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                            @foreach($areas as $area)
                            <option value="{{ $area->ID_Area }}">{{ $area->nombreArea }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="imagenCurso" class="block text-sm font-medium text-gray-700">Imagen</label>
                        <input type="file" id="imagenCurso" name="imagenCurso" class="mt-1 block w-full border border-gray-300 rounded-lg" accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Formatos aceptados: JPG, PNG, GIF (máx 2MB)</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Módulos</label>
                        <div id="modulosContainer">
                            <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                                <input type="text" name="modulos[]" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" placeholder="Nombre del módulo" required>
                                <textarea name="descripcionModulo[]" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Descripción del módulo" rows="2" required></textarea>
                            </div>
                        </div>
                        <button type="button" onclick="addModulo()" class="text-blue-500 mt-2">Añadir Módulo</button>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#127475] text-white px-4 py-2 rounded-lg shadow hover:bg-[#0f5f5e]">Guardar</button>
                        <button type="button" onclick="toggleModal()" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal para Editar Curso -->
        <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
            <div class="bg-white p-8 rounded-lg shadow-lg w-11/12 max-h-[90vh] overflow-y-auto">
                <h2 class="text-2xl font-semibold mb-4">Editar Curso</h2>
                <form id="formEditarCurso" action="{{ route('curso.update', 0) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editCursoId" name="ID_Curso" value="">

                    <div class="mb-4">
                        <label for="editNombreCurso" class="block text-sm font-medium text-gray-700">Nombre del Curso</label>
                        <input type="text" id="editNombreCurso" name="nombreCurso" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="editDescripcionCurso" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea id="editDescripcionCurso" name="descripcionCurso" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="editEstado" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="editEstado" name="estado" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="editArea" class="block text-sm font-medium text-gray-700">Área</label>
                        <select id="editArea" name="ID_Area" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                            @foreach($areas as $area)
                            <option value="{{ $area->ID_Area }}">{{ $area->nombreArea }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="editImagenCurso" class="block text-sm font-medium text-gray-700">Imagen</label>
                        <div class="flex items-center mb-2">
                            <img id="currentImage" src="" alt="Imagen actual" class="w-24 h-24 object-cover rounded-lg mr-4 hidden">
                            <span id="noImageText" class="text-gray-500">Sin imagen actual</span>
                        </div>
                        <input type="file" id="editImagenCurso" name="imagenCurso" class="mt-1 block w-full border border-gray-300 rounded-lg" accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Formatos aceptados: JPG, PNG, GIF (máx 2MB). Deja vacío para mantener la imagen actual.</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Módulos</label>
                        <div id="editModulosContainer">
                            <!-- Los módulos se cargarán dinámicamente aquí -->
                        </div>
                        <button type="button" onclick="addEditModulo()" class="text-blue-500 mt-2">Añadir Módulo</button>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#127475] text-white px-4 py-2 rounded-lg shadow hover:bg-[#0f5f5e]">Guardar Cambios</button>
                        <button type="button" onclick="toggleEditModal()" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

<script>
    // Función principal para validar campos y mostrar errores
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
        
        // Insertar el mensaje de error justo después del campo
        if (input.nextElementSibling) {
            input.parentNode.insertBefore(errorMsg, input.nextElementSibling);
        } else {
            input.parentNode.appendChild(errorMsg);
        }
        return false;
    }
    return true;
}

// Validar nombre del curso (solo letras y espacios, máximo 70 caracteres)
function validarNombreCurso(input) {
    // Reemplazar números mientras escribe
    input.value = input.value.replace(/[0-9]/g, '');

    // Limitar a 70 caracteres
    if (input.value.length > 70) {
        input.value = input.value.substring(0, 70);
    }

    // Validar que no esté vacío y no contenga números
    return validarCampo(
        input,
        input.value.trim() !== '' && !/[0-9]/.test(input.value),
        'El nombre no debe contener números (máximo 70 caracteres) y es obligatorio'
    );
}

// Validar descripción del curso (máximo 200 caracteres)
function validarDescripcionCurso(input) {
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

// Validar nombre del módulo (máximo 100 caracteres)
function validarNombreModulo(input) {
    // Limitar a 100 caracteres
    if (input.value.length > 100) {
        input.value = input.value.substring(0, 100);
    }

    // Validar que no esté vacío
    return validarCampo(
        input,
        input.value.trim() !== '',
        'El nombre del módulo es obligatorio (máximo 100 caracteres)'
    );
}

// Validar descripción del módulo (máximo 200 caracteres)
function validarDescripcionModulo(input) {
    // Limitar a 200 caracteres
    if (input.value.length > 200) {
        input.value = input.value.substring(0, 200);
    }

    // Validar que no esté vacío
    return validarCampo(
        input,
        input.value.trim() !== '',
        'La descripción del módulo es obligatoria (máximo 200 caracteres)'
    );
}

// Validar imagen (tipo de archivo)
function validarImagen(input) {
    if (!input.files || input.files.length === 0) {
        // Si es un modal de edición, la imagen puede ser opcional
        if (input.closest('form').id === 'formEditarCurso') {
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

// Función para validar los campos de módulos
function validarModulos(container) {
    let modulosValidos = true;
    
    // Obtener todos los módulos del contenedor
    const modulos = container.querySelectorAll('div.mb-4.p-4.border');
    
    modulos.forEach(moduloDiv => {
        // Validar nombre del módulo
        const nombreModulo = moduloDiv.querySelector('input[name="modulos[]"]');
        if (nombreModulo && !validarNombreModulo(nombreModulo)) {
            modulosValidos = false;
        }
        
        // Validar descripción del módulo
        const descripcionModulo = moduloDiv.querySelector('textarea[name="descripcionModulo[]"]');
        if (descripcionModulo && !validarDescripcionModulo(descripcionModulo)) {
            modulosValidos = false;
        }
    });
    
    return modulosValidos;
}

// Función para validar formulario completo antes de enviar
function validarFormularioCurso(event) {
    const form = event.target;
    let formValido = true;

    // Validar nombre del curso
    const nombreCurso = form.querySelector('[name="nombreCurso"]');
    if (nombreCurso && !validarNombreCurso(nombreCurso)) formValido = false;

    // Validar descripción del curso
    const descripcionCurso = form.querySelector('[name="descripcionCurso"]');
    if (descripcionCurso && !validarDescripcionCurso(descripcionCurso)) formValido = false;

    // Validar área seleccionada
    const area = form.querySelector('[name="ID_Area"]');
    if (area && !validarCampo(area, area.value !== '', 'Debe seleccionar un área')) formValido = false;
    
    // Validar estado seleccionado
    const estado = form.querySelector('[name="estado"]');
    if (estado && !validarCampo(estado, estado.value !== '', 'Debe seleccionar un estado')) formValido = false;

    // Validar imagen (solo en formulario de añadir)
    const imagenCurso = form.querySelector('[name="imagenCurso"]');
    if (imagenCurso && !validarImagen(imagenCurso)) formValido = false;

    // Validar módulos
    let modulosContainer;
    if (form.id === 'formEditarCurso') {
        modulosContainer = document.getElementById('editModulosContainer');
    } else {
        modulosContainer = document.getElementById('modulosContainer');
    }
    
    if (modulosContainer && !validarModulos(modulosContainer)) {
        formValido = false;
    }

    // Prevenir envío si hay errores
    if (!formValido) {
        event.preventDefault();
        return false;
    }

    return true;
}

// Agregar estilos CSS para los campos con error
function agregarEstilosValidacion() {
    if (!document.getElementById('validacion-estilos-cursos')) {
        const style = document.createElement('style');
        style.id = 'validacion-estilos-cursos';
        style.innerHTML = `
        input.border-red-500, textarea.border-red-500, select.border-red-500 {
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

// Actualizar la función addModulo para agregar validaciones a los nuevos módulos
const originalAddModulo = addModulo;
addModulo = function() {
    originalAddModulo();
    
    // Obtener el último módulo añadido
    const modulosContainer = document.getElementById('modulosContainer');
    const modulos = modulosContainer.querySelectorAll('div.mb-4.p-4.border');
    const ultimoModulo = modulos[modulos.length - 1];
    
    // Agregar validaciones al nuevo módulo
    const nombreModulo = ultimoModulo.querySelector('input[name="modulos[]"]');
    const descripcionModulo = ultimoModulo.querySelector('textarea[name="descripcionModulo[]"]');
    
    nombreModulo.addEventListener('input', () => validarNombreModulo(nombreModulo));
    nombreModulo.addEventListener('blur', () => validarNombreModulo(nombreModulo));
    
    descripcionModulo.addEventListener('input', () => validarDescripcionModulo(descripcionModulo));
    descripcionModulo.addEventListener('blur', () => validarDescripcionModulo(descripcionModulo));
    
    // Establecer atributos maxlength
    nombreModulo.setAttribute('maxlength', '100');
    descripcionModulo.setAttribute('maxlength', '200');
};

// Actualizar la función addEditModulo para agregar validaciones a los nuevos módulos
const originalAddEditModulo = addEditModulo;
addEditModulo = function() {
    originalAddEditModulo();
    
    // Obtener el último módulo añadido
    const modulosContainer = document.getElementById('editModulosContainer');
    const modulos = modulosContainer.querySelectorAll('div.mb-4.p-4.border');
    const ultimoModulo = modulos[modulos.length - 1];
    
    // Agregar validaciones al nuevo módulo
    const nombreModulo = ultimoModulo.querySelector('input[name="modulos[]"]');
    const descripcionModulo = ultimoModulo.querySelector('textarea[name="descripcionModulo[]"]');
    
    nombreModulo.addEventListener('input', () => validarNombreModulo(nombreModulo));
    nombreModulo.addEventListener('blur', () => validarNombreModulo(nombreModulo));
    
    descripcionModulo.addEventListener('input', () => validarDescripcionModulo(descripcionModulo));
    descripcionModulo.addEventListener('blur', () => validarDescripcionModulo(descripcionModulo));
    
    // Establecer atributos maxlength
    nombreModulo.setAttribute('maxlength', '100');
    descripcionModulo.setAttribute('maxlength', '200');
};

// Actualizar addEditModuloWithData para incluir validaciones
const originalAddEditModuloWithData = addEditModuloWithData;
addEditModuloWithData = function(modulo) {
    originalAddEditModuloWithData(modulo);
    
    // Obtener el último módulo añadido
    const modulosContainer = document.getElementById('editModulosContainer');
    const modulos = modulosContainer.querySelectorAll('div.mb-4.p-4.border');
    const ultimoModulo = modulos[modulos.length - 1];
    
    // Agregar validaciones al módulo cargado
    const nombreModulo = ultimoModulo.querySelector('input[name="modulos[]"]');
    const descripcionModulo = ultimoModulo.querySelector('textarea[name="descripcionModulo[]"]');
    
    nombreModulo.addEventListener('input', () => validarNombreModulo(nombreModulo));
    nombreModulo.addEventListener('blur', () => validarNombreModulo(nombreModulo));
    
    descripcionModulo.addEventListener('input', () => validarDescripcionModulo(descripcionModulo));
    descripcionModulo.addEventListener('blur', () => validarDescripcionModulo(descripcionModulo));
    
    // Establecer atributos maxlength
    nombreModulo.setAttribute('maxlength', '100');
    descripcionModulo.setAttribute('maxlength', '200');
};

// Inicializar validaciones cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Agregar estilos CSS
    agregarEstilosValidacion();

    // Establecer atributos maxlength directamente en los elementos
    document.querySelectorAll('input[name="nombreCurso"]')
        .forEach(input => {
        input.setAttribute('maxlength', '70');
        input.setAttribute('required', 'required');
        input.addEventListener('input', () => validarNombreCurso(input));
        input.addEventListener('blur', () => validarNombreCurso(input));
    });

    document.querySelectorAll('textarea[name="descripcionCurso"]')
        .forEach(textarea => {
        textarea.setAttribute('maxlength', '200');
        textarea.setAttribute('required', 'required');
        textarea.addEventListener('input', () => validarDescripcionCurso(textarea));
        textarea.addEventListener('blur', () => validarDescripcionCurso(textarea));
    });

    // Validar imagen del curso al cambiar
    document.querySelectorAll('input[name="imagenCurso"]')
        .forEach(input => {
        input.addEventListener('change', () => validarImagen(input));
    });

    // Configurar validación para módulos existentes
    document.querySelectorAll('#modulosContainer input[name="modulos[]"]')
        .forEach(input => {
        input.setAttribute('maxlength', '100');
        input.addEventListener('input', () => validarNombreModulo(input));
        input.addEventListener('blur', () => validarNombreModulo(input));
    });

    document.querySelectorAll('#modulosContainer textarea[name="descripcionModulo[]"]')
        .forEach(textarea => {
        textarea.setAttribute('maxlength', '200');
        textarea.addEventListener('input', () => validarDescripcionModulo(textarea));
        textarea.addEventListener('blur', () => validarDescripcionModulo(textarea));
    });

    // Validar formularios al enviar
    const formAdd = document.querySelector('#modal form');
    if (formAdd) {
        formAdd.addEventListener('submit', validarFormularioCurso);
    }

    const formEdit = document.getElementById('formEditarCurso');
    if (formEdit) {
        formEdit.addEventListener('submit', validarFormularioCurso);
    }
});
    function toggleModal() {
        const modal = document.getElementById('modal');
        modal.classList.toggle('hidden');
    }

    function addModulo() {
        const modulosContainer = document.getElementById('modulosContainer');

        const moduloDiv = document.createElement('div');
        moduloDiv.classList.add('mb-4', 'p-4', 'border', 'border-gray-200', 'rounded-lg');

        const inputModulo = document.createElement('input');
        inputModulo.type = 'text';
        inputModulo.name = 'modulos[]';
        inputModulo.classList.add('mt-1', 'block', 'w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-lg', 'mb-2');
        inputModulo.placeholder = 'Nombre del módulo';
        inputModulo.required = true;

        const descripcionModulo = document.createElement('textarea');
        descripcionModulo.name = 'descripcionModulo[]';
        descripcionModulo.classList.add('mt-1', 'block', 'w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-lg');
        descripcionModulo.placeholder = 'Descripción del módulo';
        descripcionModulo.rows = 2;
        descripcionModulo.required = true;

        moduloDiv.appendChild(inputModulo);
        moduloDiv.appendChild(descripcionModulo);
        modulosContainer.appendChild(moduloDiv);
    }


    // Agregar esto a tu script existente

    function toggleEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.toggle('hidden');
    }

    function editarCurso(cursoId) {
        // Limpiar contenedor de módulos
        const modulosContainer = document.getElementById('editModulosContainer');
        modulosContainer.innerHTML = '';

        // Hacer solicitud AJAX para obtener los datos del curso
        fetch(`/administrador/cursos/${cursoId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Actualizar la acción del formulario
                document.getElementById('formEditarCurso').action = `/administrador/cursos/${cursoId}`;

                // Llenar el formulario con los datos del curso
                document.getElementById('editCursoId').value = data.curso.ID_Curso;
                document.getElementById('editNombreCurso').value = data.curso.nombreCurso;
                document.getElementById('editDescripcionCurso').value = data.curso.descripcionCurso;
                document.getElementById('editEstado').value = data.curso.estado;
                document.getElementById('editArea').value = data.curso.ID_Area;

                // Mostrar imagen actual si existe
                if (data.curso.imagen) {
                    const currentImage = document.getElementById('currentImage');
                    currentImage.src = `data:image/jpeg;base64,${data.curso.imagen}`;
                    currentImage.classList.remove('hidden');
                    document.getElementById('noImageText').classList.add('hidden');
                } else {
                    document.getElementById('currentImage').classList.add('hidden');
                    document.getElementById('noImageText').classList.remove('hidden');
                }

                // Cargar módulos
                if (data.modulos && data.modulos.length > 0) {
                    data.modulos.forEach(modulo => {
                        addEditModuloWithData(modulo);
                    });
                } else {
                    // Añadir un módulo vacío si no hay módulos
                    addEditModulo();
                }

                // Mostrar el modal
                toggleEditModal();
            })
            .catch(error => {
                console.error('Error al cargar los datos del curso:', error);
                alert('Error al cargar los datos del curso. Por favor, intenta nuevamente.');
            });
    }

    function addEditModulo() {
        const modulosContainer = document.getElementById('editModulosContainer');

        const moduloDiv = document.createElement('div');
        moduloDiv.classList.add('mb-4', 'p-4', 'border', 'border-gray-200', 'rounded-lg', 'relative');

        // Input oculto para el ID del módulo (si ya existe)
        const inputModuloId = document.createElement('input');
        inputModuloId.type = 'hidden';
        inputModuloId.name = 'moduloIds[]';
        inputModuloId.value = ''; // Vacío para nuevos módulos

        const inputModulo = document.createElement('input');
        inputModulo.type = 'text';
        inputModulo.name = 'modulos[]';
        inputModulo.classList.add('mt-1', 'block', 'w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-lg', 'mb-2');
        inputModulo.placeholder = 'Nombre del módulo';
        inputModulo.required = true;

        const descripcionModulo = document.createElement('textarea');
        descripcionModulo.name = 'descripcionModulo[]';
        descripcionModulo.classList.add('mt-1', 'block', 'w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-lg');
        descripcionModulo.placeholder = 'Descripción del módulo';
        descripcionModulo.rows = 2;
        descripcionModulo.required = true;

        // Botón para eliminar módulo
        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.classList.add('absolute', 'top-2', 'right-2', 'text-red-500', 'hover:text-red-700');
        deleteButton.innerHTML = '&times;';
        deleteButton.onclick = function() {
            moduloDiv.remove();
        };

        moduloDiv.appendChild(inputModuloId);
        moduloDiv.appendChild(inputModulo);
        moduloDiv.appendChild(descripcionModulo);
        moduloDiv.appendChild(deleteButton);

        modulosContainer.appendChild(moduloDiv);
    }

    function addEditModuloWithData(modulo) {
        const modulosContainer = document.getElementById('editModulosContainer');

        const moduloDiv = document.createElement('div');
        moduloDiv.classList.add('mb-4', 'p-4', 'border', 'border-gray-200', 'rounded-lg', 'relative');

        // Input oculto para el ID del módulo
        const inputModuloId = document.createElement('input');
        inputModuloId.type = 'hidden';
        inputModuloId.name = 'moduloIds[]';
        inputModuloId.value = modulo.ID_Modulo;

        const inputModulo = document.createElement('input');
        inputModulo.type = 'text';
        inputModulo.name = 'modulos[]';
        inputModulo.value = modulo.nombreModulo;
        inputModulo.classList.add('mt-1', 'block', 'w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-lg', 'mb-2');
        inputModulo.placeholder = 'Nombre del módulo';
        inputModulo.required = true;

        const descripcionModulo = document.createElement('textarea');
        descripcionModulo.name = 'descripcionModulo[]';
        descripcionModulo.value = modulo.descripcionModulo;
        descripcionModulo.classList.add('mt-1', 'block', 'w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-lg');
        descripcionModulo.placeholder = 'Descripción del módulo';
        descripcionModulo.rows = 2;
        descripcionModulo.required = true;

        // Botón para eliminar módulo
        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.classList.add('absolute', 'top-2', 'right-2', 'text-white', 'bg-red-600', 'hover:bg-red-800', 'p-2', 'rounded-full', 'shadow-lg', 'transition', 'transform', 'hover:scale-110');
        deleteButton.innerHTML = '&times;';
        deleteButton.style.fontSize = '20px'; // Aumenta el tamaño de la fuente
        deleteButton.onclick = function() {
            if (confirm('¿Estás seguro de eliminar este módulo?')) {
                // Añadir un campo oculto para indicar que este módulo debe eliminarse
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'deleteModulos[]';
                deleteInput.value = modulo.ID_Modulo;
                document.getElementById('formEditarCurso').appendChild(deleteInput);

                moduloDiv.remove();
            }
        };


        moduloDiv.appendChild(inputModuloId);
        moduloDiv.appendChild(inputModulo);
        moduloDiv.appendChild(descripcionModulo);
        moduloDiv.appendChild(deleteButton);

        modulosContainer.appendChild(moduloDiv);
    }

    // Modificar el botón de editar en la tabla
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener todos los botones de editar
        const editButtons = document.querySelectorAll('.bg-blue-500');

        // Agregar evento de clic a cada botón
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Obtener el ID del curso desde la fila de la tabla
                const row = this.closest('tr');
                const cursoId = row.querySelector('td:first-child').textContent.trim();

                // Llamar a la función para editar el curso
                editarCurso(cursoId);
            });
        });
    });

    
</script>