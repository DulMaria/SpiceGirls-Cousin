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
        [x-cloak] { display: none !important; }
    </style>

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
    
   /* Estilos para los filtros */
.filter-section {
    background: linear-gradient(135deg, #2e7d32 0%, #5e35b1 100%);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.filter-input {
    transition: all 0.3s ease;
    border: 2px solid transparent;
    background-color: #f3f4f6;
    color: #2f2f2f;
}

.filter-input:focus {
    border-color: #388e3c;
    box-shadow: 0 0 0 3px rgba(56, 142, 60, 0.2);
    transform: translateY(-2px);
}

.filter-button {
    transition: all 0.3s ease;
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
}

.filter-button:hover {
    background-color: #388e3c;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.filter-button:active {
    transform: translateY(-1px);
}

/* Botón de reinicio */
.reset-button {
    background: linear-gradient(45deg, #9a1b1b, #7d2e2e);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
}

.reset-button:hover {
    background: linear-gradient(45deg, #2e7d32, #6a1b9a);
}

/* Animación para mostrar/ocultar filtros */
.filter-collapse {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    max-height: 0;
    opacity: 0;
}

.filter-collapse.show {
    max-height: 500px;
    opacity: 1;
}

/* Efectos visuales adicionales */
.glass-effect {
    backdrop-filter: blur(8px);
    background: rgba(50, 50, 50, 0.1);
    border: 1px solid rgba(100, 100, 100, 0.2);
}

/* Contador de resultados */
.results-counter {
    background: linear-gradient(45deg, #388e3c, #5e35b1);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 0.9rem;
    box-shadow: 0 4px 15px rgba(50, 50, 50, 0.3);
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

            <!-- Sección de Filtros -->
            <div class="filter-section p-6 mb-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-funnel-fill text-2xl"></i>
                        <h2 class="text-xl font-bold">Filtros de Búsqueda</h2>
                    </div>
                    <button 
                        onclick="toggleFilters()" 
                        id="toggleFiltersBtn"
                        class="filter-button bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-lg flex items-center gap-2 glass-effect">
                        <i class="bi bi-chevron-down" id="chevronIcon"></i>
                        <span>Mostrar Filtros</span>
                    </button>
                </div>
                
                <div id="filtersContent" class="filter-collapse">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <!-- Filtro por ID -->
                        <div class="space-y-2">
                            <label for="filtroId" class="block text-sm font-medium">
                                <i class="bi bi-hash mr-1"></i>ID del Curso
                            </label>
                            <input 
                                type="number" 
                                id="filtroId" 
                                placeholder="Ej: 123"
                                class="filter-input w-full px-4 py-2 rounded-lg bg-white bg-opacity-90 text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none">
                        </div>

                        <!-- Filtro por Área -->
                        <div class="space-y-2">
                            <label for="filtroArea" class="block text-sm font-medium">
                                <i class="bi bi-collection mr-1"></i>Área
                            </label>
                            <select 
                                id="filtroArea" 
                                class="filter-input w-full px-4 py-2 rounded-lg bg-white bg-opacity-90 text-gray-800 focus:bg-white focus:outline-none">
                                <option value="">Todas las áreas</option>
                                @foreach($areas as $area)
                                <option value="{{ $area->nombreArea }}">{{ $area->nombreArea }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro por Nombre del Curso -->
                        <div class="space-y-2">
                            <label for="filtroCurso" class="block text-sm font-medium">
                                <i class="bi bi-book mr-1"></i>Nombre del Curso
                            </label>
                            <input 
                                type="text" 
                                id="filtroCurso" 
                                placeholder="Buscar curso..."
                                class="filter-input w-full px-4 py-2 rounded-lg bg-white bg-opacity-90 text-gray-800 placeholder-gray-500 focus:bg-white focus:outline-none">
                        </div>

                        <!-- Filtro por Estado -->
                        <div class="space-y-2">
                            <label for="filtroEstado" class="block text-sm font-medium">
                                <i class="bi bi-toggle-on mr-1"></i>Estado
                            </label>
                            <select 
                                id="filtroEstado" 
                                class="filter-input w-full px-4 py-2 rounded-lg bg-white bg-opacity-90 text-gray-800 focus:bg-white focus:outline-none">
                                <option value="">Todos los estados</option>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex flex-wrap gap-3 items-center justify-between">
                        <div class="flex gap-3">
                            <button 
                                onclick="aplicarFiltros()" 
                                class="filter-button bg-[#127475] hover:bg-[#0f5f5e] px-6 py-2 rounded-lg flex items-center gap-2 font-medium">
                                <i class="bi bi-search"></i>
                                Buscar
                            </button>
                            <button 
                                onclick="limpiarFiltros()" 
                                class="filter-button reset-button px-6 py-2 rounded-lg flex items-center gap-2 font-medium text-white">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Limpiar
                            </button>
                        </div>
                        
                        <!-- Contador de resultados -->
                        <div class="results-counter" id="contadorResultados">
                            Total: <span id="totalCursos">{{ count($cursos) }}</span> cursos
                        </div>
                    </div>
                </div>
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
                    <tbody id="tablaCursos">
                        @foreach ($cursos as $curso)
                        <tr class="border-b hover:bg-gray-100 curso-row" 
                            data-id="{{ $curso->ID_Curso }}"
                            data-area="{{ $curso->area->nombreArea ?? 'Sin Área' }}"
                            data-curso="{{ $curso->nombreCurso }}"
                            data-estado="{{ $curso->estado }}">
                            <td class="px-6 py-4">{{ $curso->ID_Curso }}</td>
                            <td class="px-6 py-4">{{ $curso->area->nombreArea ?? 'Sin Área' }}</td>
                            <td class="px-6 py-4">{{ $curso->nombreCurso }}</td>
                            <td class="px-6 py-4">{{ $curso->descripcionCurso }}</td>
                            <td class="px-6 py-4">
                                <div class="inline-flex items-center gap-2">
                                    <span class="w-3.5 h-3.5 rounded-full {{ $curso->estado == 1 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    <span class="text-sm">
                                    {{ $curso->estado == 1 ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </td>
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
                            <td class="px-6 py-4 text-center" x-data="{ showModal: false }" x-init="$nextTick(() => showModal = false)">
                                <!-- Botón que activa el modal -->
                                <button
                                    type="button"
                                    @click="showModal = !showModal"
                                    class="bg-black hover:bg-black-700 text-white px-3 py-2 rounded-full flex items-center justify-center gap-2">
                                    
                                    <i class="bi" :class="showModal ? ' bi-eye-slash' : 'bi-eye'" class="text-lg"></i>
                                </button>

                                <!-- Modal -->
                                <div
                                    x-show="showModal"
                                    x-transition
                                    x-cloak
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
                                <!-- Formulario Habilitar / Deshabilitar -->
                                <form id="formCambiarEstado" method="POST" action="{{ route('curso.cambiarEstado', ['id' => $curso->ID_Curso]) }}"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="{{ $curso->estado == 1 
                                            ? 'bg-[#e74c3c] hover:bg-[#c0392b]'  
                                            : 'bg-[#2ecc71] hover:bg-[#27ae60]' }} 
                                            text-white px-4 py-3 rounded-full flex items-center gap-3 text-sm font-medium shadow-sm transition duration-300">
                                        
                                        @if ($curso->estado == 1)
                                        <i class="bi bi-x-circle-fill"></i> 
                                        @else
                                        <i class="bi bi-check-circle-fill"></i> 
                                        @endif
                                    </button>
                                </form>

                            </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Mensaje cuando no hay resultados -->
                <div id="noResultados" class="hidden p-8 text-center text-gray-500">
                    <div class="flex flex-col items-center space-y-4">
                        <i class="bi bi-search text-6xl text-gray-300"></i>
                        <h3 class="text-xl font-medium">No se encontraron cursos</h3>
                        <p class="text-gray-400">Intenta ajustar los filtros de búsqueda</p>
                        <button 
                            onclick="limpiarFiltros()" 
                            class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg">
                            Mostrar todos los cursos
                        </button>
                    </div>
                </div>
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
    
    <!-- Modal de confirmación personalizado -->
    <div id="confirmacionModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80 max-w-md">
            <div class="mb-4">
                <p class="text-lg font-semibold text-[#2e1a47]">La fundación dice:</p>
                <p class="mt-2" id="confirmacionMensaje"></p>
            </div>
            <div class="flex justify-end gap-3">
                <button id="cancelarConfirmacion" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg">Cancelar</button>
                <button id="aceptarConfirmacion" class="px-4 py-2 bg-[#127475] hover:bg-[#0f5f5e] text-white rounded-lg">Aceptar</button>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    // =========================
// FUNCIONES DE FILTRADO COMPLETAS
// =========================

// Función para mostrar/ocultar la sección de filtros
function toggleFilters() {
    const filtersContent = document.getElementById('filtersContent');
    const chevronIcon = document.getElementById('chevronIcon');
    const toggleBtn = document.getElementById('toggleFiltersBtn');
    
    if (filtersContent.classList.contains('show')) {
        filtersContent.classList.remove('show');
        chevronIcon.classList.remove('bi-chevron-up');
        chevronIcon.classList.add('bi-chevron-down');
        toggleBtn.querySelector('span').textContent = 'Mostrar Filtros';
    } else {
        filtersContent.classList.add('show');
        chevronIcon.classList.remove('bi-chevron-down');
        chevronIcon.classList.add('bi-chevron-up');
        toggleBtn.querySelector('span').textContent = 'Ocultar Filtros';
    }
}

// Función para aplicar los filtros
function aplicarFiltros() {
    const filtroId = document.getElementById('filtroId').value.trim();
    const filtroArea = document.getElementById('filtroArea').value.trim();
    const filtroCurso = document.getElementById('filtroCurso').value.trim().toLowerCase();
    const filtroEstado = document.getElementById('filtroEstado').value;
    
    const filas = document.querySelectorAll('#tablaCursos .curso-row');
    const tabla = document.querySelector('#tablaCursos').closest('table');
    const noResultados = document.getElementById('noResultados');
    let cursosVisibles = 0;
    
    filas.forEach(fila => {
        let mostrar = true;
        
        // Filtro por ID
        if (filtroId && !fila.dataset.id.includes(filtroId)) {
            mostrar = false;
        }
        
        // Filtro por área
        if (filtroArea && fila.dataset.area !== filtroArea) {
            mostrar = false;
        }
        
        // Filtro por nombre del curso
        if (filtroCurso && !fila.dataset.curso.toLowerCase().includes(filtroCurso)) {
            mostrar = false;
        }
        
        // Filtro por estado
        if (filtroEstado && fila.dataset.estado !== filtroEstado) {
            mostrar = false;
        }
        
        // Mostrar u ocultar la fila
        if (mostrar) {
            fila.style.display = '';
            cursosVisibles++;
        } else {
            fila.style.display = 'none';
        }
    });
    
    // Actualizar contador de resultados
    actualizarContador(cursosVisibles);
    
    // Mostrar u ocultar mensaje de "no hay resultados"
    if (cursosVisibles === 0) {
        tabla.style.display = 'none';
        noResultados.classList.remove('hidden');
    } else {
        tabla.style.display = 'table';
        noResultados.classList.add('hidden');
    }
    
    // Mostrar animación visual de búsqueda aplicada
    mostrarAnimacionBusqueda();
}

// Función para limpiar todos los filtros
function limpiarFiltros() {
    // Limpiar todos los campos de filtro
    document.getElementById('filtroId').value = '';
    document.getElementById('filtroArea').value = '';
    document.getElementById('filtroCurso').value = '';
    document.getElementById('filtroEstado').value = '';
    
    // Mostrar todas las filas
    const filas = document.querySelectorAll('#tablaCursos .curso-row');
    filas.forEach(fila => {
        fila.style.display = '';
    });
    
    // Actualizar contador con total de cursos
    const totalCursos = filas.length;
    actualizarContador(totalCursos);
    
    // Ocultar mensaje de "no hay resultados" y mostrar tabla
    const tabla = document.querySelector('#tablaCursos').closest('table');
    const noResultados = document.getElementById('noResultados');
    
    tabla.style.display = 'table';
    noResultados.classList.add('hidden');
    
    // Mostrar animación de filtros limpiados
    mostrarAnimacionLimpiar();
}

// Función para actualizar el contador de resultados
function actualizarContador(cantidad) {
    const totalCursos = document.getElementById('totalCursos');
    const contadorResultados = document.getElementById('contadorResultados');
    
    if (totalCursos) {
        totalCursos.textContent = cantidad;
        
        // Cambiar el color del contador según la cantidad
        contadorResultados.className = 'results-counter';
        if (cantidad === 0) {
            contadorResultados.style.background = 'linear-gradient(45deg, #e74c3c, #c0392b)';
        } else if (cantidad < 5) {
            contadorResultados.style.background = 'linear-gradient(45deg, #f39c12, #e67e22)';
        } else {
            contadorResultados.style.background = 'linear-gradient(45deg, #4facfe, #00f2fe)';
        }
        
        // Animación de actualización del contador
        contadorResultados.style.transform = 'scale(1.1)';
        setTimeout(() => {
            contadorResultados.style.transform = 'scale(1)';
        }, 200);
    }
}

// Función para mostrar animación cuando se aplican los filtros
function mostrarAnimacionBusqueda() {
    const btnBuscar = document.querySelector('button[onclick="aplicarFiltros()"]');
    const iconoBuscar = btnBuscar.querySelector('i');
    
    // Cambiar temporalmente el ícono
    iconoBuscar.classList.remove('bi-search');
    iconoBuscar.classList.add('bi-check-circle-fill');
    btnBuscar.style.background = 'linear-gradient(45deg, #2ecc71, #27ae60)';
    
    setTimeout(() => {
        iconoBuscar.classList.remove('bi-check-circle-fill');
        iconoBuscar.classList.add('bi-search');
        btnBuscar.style.background = '';
    }, 1500);
}

// Función para mostrar animación cuando se limpian los filtros
function mostrarAnimacionLimpiar() {
    const btnLimpiar = document.querySelector('button[onclick="limpiarFiltros()"]');
    const iconoLimpiar = btnLimpiar.querySelector('i');
    
    // Animación de rotación
    iconoLimpiar.style.transform = 'rotate(360deg)';
    iconoLimpiar.style.transition = 'transform 0.6s ease';
    
    setTimeout(() => {
        iconoLimpiar.style.transform = 'rotate(0deg)';
    }, 600);
}

// Función para aplicar filtros automáticamente mientras se escribe
function configurarFiltroEnTiempoReal() {
    const filtroId = document.getElementById('filtroId');
    const filtroCurso = document.getElementById('filtroCurso');
    const filtroArea = document.getElementById('filtroArea');
    const filtroEstado = document.getElementById('filtroEstado');
    
    // Configurar filtrado en tiempo real con debounce
    let timeoutId;
    
    function aplicarFiltroConDelay() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            aplicarFiltros();
        }, 300); // 300ms de delay
    }
    
    // Agregar event listeners
    if (filtroId) {
        filtroId.addEventListener('input', aplicarFiltroConDelay);
    }
    
    if (filtroCurso) {
        filtroCurso.addEventListener('input', aplicarFiltroConDelay);
    }
    
    if (filtroArea) {
        filtroArea.addEventListener('change', aplicarFiltros);
    }
    
    if (filtroEstado) {
        filtroEstado.addEventListener('change', aplicarFiltros);
    }
}

// Función para resaltar texto coincidente en los resultados
function resaltarTextoCoincidente() {
    const filtroCurso = document.getElementById('filtroCurso').value.trim().toLowerCase();
    
    if (!filtroCurso) {
        // Remover resaltados existentes
        document.querySelectorAll('.highlight').forEach(el => {
            el.outerHTML = el.innerHTML;
        });
        return;
    }
    
    const filasVisibles = document.querySelectorAll('#tablaCursos .curso-row[style=""]');
    
    filasVisibles.forEach(fila => {
        const celdaCurso = fila.children[2]; // Tercera columna (nombre del curso)
        const textoOriginal = fila.dataset.curso;
        
        // Crear regex para buscar coincidencias
        const regex = new RegExp(`(${filtroCurso})`, 'gi');
        const textoResaltado = textoOriginal.replace(regex, '<span class="highlight" style="background-color: #fff3cd; padding: 2px 4px; border-radius: 3px;">$1</span>');
        
        celdaCurso.innerHTML = textoResaltado;
    });
}

// Función para exportar resultados filtrados (funcionalidad adicional)
function exportarResultadosFiltrados() {
    const filasVisibles = document.querySelectorAll('#tablaCursos .curso-row[style=""]');
    
    if (filasVisibles.length === 0) {
        alert('No hay cursos para exportar con los filtros actuales.');
        return;
    }
    
    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "ID,Área,Nombre del Curso,Descripción,Estado\n";
    
    filasVisibles.forEach(fila => {
        const id = fila.dataset.id;
        const area = fila.dataset.area;
        const curso = fila.dataset.curso;
        const descripcion = fila.children[3].textContent.trim();
        const estado = fila.dataset.estado === '1' ? 'Activo' : 'Inactivo';
        
        csvContent += `"${id}","${area}","${curso}","${descripcion}","${estado}"\n`;
    });
    
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "cursos_filtrados.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Función para guardar filtros en localStorage (persistencia)
function guardarFiltros() {
    const filtros = {
        id: document.getElementById('filtroId').value,
        area: document.getElementById('filtroArea').value,
        curso: document.getElementById('filtroCurso').value,
        estado: document.getElementById('filtroEstado').value
    };
    
    localStorage.setItem('filtrosCursos', JSON.stringify(filtros));
}

// Función para cargar filtros guardados
function cargarFiltrosGuardados() {
    const filtrosGuardados = localStorage.getItem('filtrosCursos');
    
    if (filtrosGuardados) {
        const filtros = JSON.parse(filtrosGuardados);
        
        document.getElementById('filtroId').value = filtros.id || '';
        document.getElementById('filtroArea').value = filtros.area || '';
        document.getElementById('filtroCurso').value = filtros.curso || '';
        document.getElementById('filtroEstado').value = filtros.estado || '';
        
        // Aplicar los filtros cargados
        aplicarFiltros();
    }
}

// Función para mostrar estadísticas de filtrado
function mostrarEstadisticasFiltrado() {
    const totalCursos = document.querySelectorAll('#tablaCursos .curso-row').length;
    const cursosVisibles = document.querySelectorAll('#tablaCursos .curso-row[style=""]').length;
    const cursosOcultos = totalCursos - cursosVisibles;
    
    console.log(`Estadísticas de filtrado:
    Total de cursos: ${totalCursos}
    Cursos visibles: ${cursosVisibles}
    Cursos ocultos: ${cursosOcultos}
    Porcentaje mostrado: ${((cursosVisibles / totalCursos) * 100).toFixed(1)}%`);
}

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Configurar filtrado en tiempo real
    configurarFiltroEnTiempoReal();
    
    // Cargar filtros guardados (opcional)
    // cargarFiltrosGuardados();
    
    // Agregar event listener para guardar filtros al cambiar
    ['filtroId', 'filtroArea', 'filtroCurso', 'filtroEstado'].forEach(id => {
        const elemento = document.getElementById(id);
        if (elemento) {
            elemento.addEventListener('change', guardarFiltros);
        }
    });
    
    // Configurar teclas de acceso rápido
    document.addEventListener('keydown', function(e) {
        // Ctrl + F para enfocar en el filtro de curso
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            document.getElementById('filtroCurso').focus();
        }
        
        // Escape para limpiar filtros
        if (e.key === 'Escape') {
            limpiarFiltros();
        }
        
        // Enter para aplicar filtros cuando se está en un campo de filtro
        if (e.key === 'Enter' && 
            ['filtroId', 'filtroCurso'].includes(e.target.id)) {
            aplicarFiltros();
        }
    });
});

// Función adicional para agregar un botón de exportar (opcional)
function agregarBotonExportar() {
    const contadorResultados = document.getElementById('contadorResultados');
    
    if (contadorResultados && !document.getElementById('btnExportar')) {
        const btnExportar = document.createElement('button');
        btnExportar.id = 'btnExportar';
        btnExportar.className = 'ml-3 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-sm flex items-center gap-1';
        btnExportar.innerHTML = '<i class="bi bi-download"></i> Exportar';
        btnExportar.onclick = exportarResultadosFiltrados;
        
        contadorResultados.parentNode.appendChild(btnExportar);
    }
}

    // Función para mostrar el modal de confirmación personalizado
    function mostrarConfirmacion(mensaje) {
        return new Promise((resolve) => {
            const modal = document.getElementById('confirmacionModal');
            const mensajeElement = document.getElementById('confirmacionMensaje');
            
            mensajeElement.textContent = mensaje;
            modal.classList.remove('hidden');
            
            const btnAceptar = document.getElementById('aceptarConfirmacion');
            const btnCancelar = document.getElementById('cancelarConfirmacion');
            
            function limpiarEventos() {
                btnAceptar.removeEventListener('click', handleAceptar);
                btnCancelar.removeEventListener('click', handleCancelar);
            }
            
            function handleAceptar() {
                modal.classList.add('hidden');
                limpiarEventos();
                resolve(true);
            }
            
            function handleCancelar() {
                modal.classList.add('hidden');
                limpiarEventos();
                resolve(false);
            }
            
            btnAceptar.addEventListener('click', handleAceptar);
            btnCancelar.addEventListener('click', handleCancelar);
        });
    }

    // Reemplazar el confirm en los formularios de cambio de estado
    document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('formCambiarEstado');
            
            form.addEventListener('submit', async function (e) {
                e.preventDefault(); // Detiene el envío por defecto
                
                const mensaje = "{{ $curso->estado == 1 ? '¿Estás seguro de deshabilitar este curso?' : '¿Estás seguro de habilitar este curso?' }}";

                const confirmar = await mostrarConfirmacion(mensaje);

                if (confirmar) {
                    form.submit(); // Envía el formulario si acepta
                }
            });
        });
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
        const editButtons = document.querySelectorAll('.editar-curso');

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