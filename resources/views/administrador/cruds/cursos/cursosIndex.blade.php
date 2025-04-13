<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos - Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <style>
        /* Estilos adicionales para el modal */
        #modal {
            max-height: 90%; /* Ajusta la altura máxima */
            overflow-y: auto; /* Permite el desplazamiento vertical */
            max-width: 80%; /* Limita el ancho del modal */
            margin: auto;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

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
                            <td class="px-6 py-4">
                                <ol class="list-decimal pl-6">
                                    @foreach ($curso->modulos->sortBy('orden') as $modulo)
                                        <li>
                                            <div class="font-medium">{{ $modulo->nombreModulo }}</div>
                                            <div class="text-xs text-gray-500">{{ $modulo->descripcion_modulo }}</div>
                                        </li>
                                    @endforeach
                                </ol>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button type="button" 
                                        data-curso-id="{{ $curso->ID_Curso }}"
                                        class="editar-curso bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded">
                                    Editar
                                </button>
                                <form method="POST" action="{{ route('curso.cambiarEstado', ['id' => $curso->ID_Curso]) }}" 
                                    class="inline" onsubmit="return confirm('¿Estás seguro de cambiar el estado de este curso?');">
                                    @csrf
                                    <button type="submit" 
                                            class="{{ $curso->estado == 1 ? 'bg-yellow-500 hover:bg-yellow-700' : 'bg-green-500 hover:bg-green-700' }} text-white px-3 py-1 rounded">
                                        {{ $curso->estado == 1 ? 'Deshabilitar' : 'Habilitar' }}
                                    </button>
                                </form>
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

</body>
</html>

<script>
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
        inputModuloId.value = '';  // Vacío para nuevos módulos
        
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
        deleteButton.style.fontSize = '20px';  // Aumenta el tamaño de la fuente
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