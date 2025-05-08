<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promociones - Administración</title>
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
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <!-- Menú lateral -->
    @include('partials.navAdmi')
    <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilAdmin')
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-[#2e1a47]">Gestión de Promociones</h1>
                <button onclick="toggleModal()" class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg shadow">
                    + Añadir Promoción
                </button>
            </div>

            <!-- Tabla de Promociones -->
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-[#1f1b2e] text-white">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Tipo</th>
                            <th class="px-6 py-3">Descuento</th>
                            <th class="px-6 py-3">Descripción</th>
                            <th class="px-6 py-3">Fecha Inicio</th>
                            <th class="px-6 py-3">Fecha Fin</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Cursos</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($promociones as $promocion)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $promocion->ID_Promo }}</td>
                            <td class="px-6 py-4">
                                @if ($promocion->tipo == 0)
                                    OFERTAS
                                @elseif ($promocion->tipo == 1)
                                    BECAS
                                @else
                                    Desconocido
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $promocion->descuento }}%</td>
                            <td class="px-6 py-4">{{ $promocion->descripcion }}</td>
                            <td class="px-6 py-4">{{ date('d/m/Y', strtotime($promocion->fechaInicio)) }}</td>
                            <td class="px-6 py-4">{{ date('d/m/Y', strtotime($promocion->fechaFin)) }}</td>
                            <td class="px-6 py-4">
                                <div class="inline-flex items-center gap-2">
                                    <span class="w-3.5 h-3.5 rounded-full {{ $promocion->estado == 1 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    <span class="text-sm">
                                    {{ $promocion->estado == 1 ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center" x-data="{ showModal: false }" x-init="$nextTick(() => showModal = false)">
                                <!-- Botón que activa el modal -->
                                <button
                                    type="button"
                                    @click="showModal = !showModal"
                                    class="bg-black hover:bg-black-700 text-white px-3 py-2 rounded-full flex items-center justify-center gap-2">
                                    
                                    <i class="bi" :class="showModal ? 'bi-eye' : 'bi-eye-slash'" class="text-lg"></i>
                                </button>

                                <!-- Modal -->
                                <div
                                    x-show="showModal"
                                    x-transition
                                    x-cloak
                                    class="fixed inset-0 z-50 flex items-center justify-center"
                                    style="background-color: rgba(0, 0, 0, 0.5);">
                                    <div class="bg-white rounded-lg shadow-lg z-50 max-w-md w-full p-6 relative">
                                        <h2 class="text-xl font-semibold mb-4">Cursos con esta Promoción</h2>

                                        <ul class="list-disc pl-5 space-y-2 max-h-64 overflow-y-auto">
                                            @foreach ($promocion->cursos as $curso)
                                            <li>
                                                <div class="font-medium">{{ $curso->nombreCurso }}</div>
                                                <div class="text-sm text-gray-500">{{ $curso->descripcionCurso }}</div>
                                            </li>
                                            @endforeach
                                            
                                            @if($promocion->cursos->count() == 0)
                                            <li class="text-gray-500">No hay cursos asignados a esta promoción</li>
                                            @endif
                                        </ul>

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
                                <div class="flex items-center gap-4">
                                    <!-- Botón de Editar -->
                                    <button type="button"
                                        data-promo-id="{{ $promocion->ID_Promo }}"
                                        class="editar-promocion bg-purple-800 hover:bg-purple-700 text-white px-4 py-3 rounded-full flex items-center gap-5">
                                        <i class="bi bi-pencil-fill"></i> 
                                    </button>

                                    <!-- Formulario Habilitar / Deshabilitar -->
                                    <form method="POST" action="{{ route('promocion.cambiarEstado', ['id' => $promocion->ID_Promo]) }}"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="{{ $promocion->estado == 1 
                                                ? 'bg-[#e74c3c] hover:bg-[#c0392b]'  
                                                : 'bg-[#2ecc71] hover:bg-[#27ae60]' }} 
                                                text-white px-4 py-3 rounded-full flex items-center gap-3 text-sm font-medium shadow-sm transition duration-300">
                                            
                                            @if ($promocion->estado == 1)
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
            </div>
        </div>

        <!-- Modal para Añadir Promoción -->
        <div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
            <div class="bg-white p-8 rounded-lg shadow-lg w-11/12 max-h-[90vh] overflow-y-auto">
                <h2 class="text-2xl font-semibold mb-4">Añadir Nueva Promoción</h2>
                <form action="{{ route('promocion.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Promoción</label>
                        <select id="tipo" name="tipo" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                            
                            <option value="0">Ofertas</option>
                            <option value="1">Becas</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="descuento" class="block text-sm font-medium text-gray-700">Descuento (%)</label>
                        <input type="text" id="descuento" name="descuento" min="1" max="100" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="fechaInicio" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                            <input type="date" id="fechaInicio" name="fechaInicio" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="fechaFin" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                            <input type="date" id="fechaFin" name="fechaFin" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="estado" name="estado" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Cursos</label>
                        <div class="max-h-60 overflow-y-auto border border-gray-300 rounded-lg p-3">
                            @foreach($cursos as $curso)
                            <div class="flex items-center mb-2">
                                <input type="checkbox" id="curso_{{ $curso->ID_Curso }}" name="cursos[]" value="{{ $curso->ID_Curso }}" class="mr-2">
                                <label for="curso_{{ $curso->ID_Curso }}" class="text-sm">{{ $curso->nombreCurso }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#127475] text-white px-4 py-2 rounded-lg shadow hover:bg-[#0f5f5e]">Guardar</button>
                        <button type="button" onclick="toggleModal()" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal para Editar Promoción -->
        <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
            <div class="bg-white p-8 rounded-lg shadow-lg w-11/12 max-h-[90vh] overflow-y-auto">
                <h2 class="text-2xl font-semibold mb-4">Editar Promoción</h2>
                <form id="formEditarPromocion" action="{{ route('promocion.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editPromoId" name="ID_Promo" value="">

                    <div class="mb-4">
                        <label for="editTipo" class="block text-sm font-medium text-gray-700">Tipo de Promoción</label>
                        <select id="editTipo" name="tipo" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                            <option value="0">Ofertas</option>
                            <option value="1">Becas</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="editDescuento" class="block text-sm font-medium text-gray-700">Descuento (%)</label>
                        <input type="text" id="editDescuento" name="descuento" min="1" max="100" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="editDescripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea id="editDescripcion" name="descripcion" rows="3" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="editFechaInicio" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                            <input type="date" id="editFechaInicio" name="fechaInicio" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="editFechaFin" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                            <input type="date" id="editFechaFin" name="fechaFin" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="editEstado" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="editEstado" name="estado" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar Cursos</label>
                        <div class="max-h-60 overflow-y-auto border border-gray-300 rounded-lg p-3" id="editCursosContainer">
                            <!-- Los checkboxes de cursos se cargarán dinámicamente aquí -->
                        </div>
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

    <script>
        // Función para el modal de añadir
        function toggleModal() {
            document.getElementById('modal').classList.toggle('hidden');
        }

        // Función para el modal de editar
        function toggleEditModal() {
            document.getElementById('editModal').classList.toggle('hidden');
        }

        // Configuración de validación de fechas
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener fecha actual en formato YYYY-MM-DD
            const today = new Date().toISOString().split('T')[0];
            
            // Establecer fecha mínima para los campos de fecha
            document.getElementById('fechaInicio').min = today;
            document.getElementById('fechaFin').min = today;
            
            // Validación al cambiar fechaInicio
            document.getElementById('fechaInicio').addEventListener('change', function() {
                document.getElementById('fechaFin').min = this.value;
            });

            // Similar para los campos de edición
            document.getElementById('editFechaInicio').addEventListener('change', function() {
                document.getElementById('editFechaFin').min = this.value;
            });

            // Configurar botones de editar
            const editButtons = document.querySelectorAll('.editar-promocion');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const promoId = this.getAttribute('data-promo-id');
                    cargarDatosPromocion(promoId);
                });
            });
            // Configurar formulario de edición para evitar problemas de envío
        const formEditarPromocion = document.getElementById('formEditarPromocion');
        if (formEditarPromocion) {
            formEditarPromocion.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevenir envío por defecto
                
                // Obtener ID de promoción
                const promoId = document.getElementById('editPromoId').value;
                
                // Actualizar la acción del formulario con el ID correcto
                this.action = `/administrador/promociones/${promoId}`;
                
                // Verificar si hay cursos seleccionados
                const cursosSeleccionados = document.querySelectorAll('#editCursosContainer input[type="checkbox"]:checked');
                if (cursosSeleccionados.length === 0) {
                    // Si no hay cursos seleccionados, crear un input hidden para enviar un array vacío
                    const emptyInput = document.createElement('input');
                    emptyInput.type = 'hidden';
                    emptyInput.name = 'cursos';
                    emptyInput.value = '';
                    this.appendChild(emptyInput);
                }
                
                // Enviar el formulario
                this.submit();
            });
        }
        });

        // Función para cargar datos de promoción en el modal de edición
function cargarDatosPromocion(promoId) {
    // Mostrar un indicador de carga (opcional)
    console.log('Cargando datos de la promoción:', promoId);
    
    // Realizar la petición para obtener los datos de la promoción
    fetch(`/administrador/promociones/${promoId}/edit`)
        .then(response => {
            console.log('Respuesta del servidor:', response);
            // Verificar si la respuesta es correcta
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recuperados:', data);
            
            // Llenar el formulario con los datos recibidos
            document.getElementById('editPromoId').value = data.ID_Promo ? data.ID_Promo : "";
            document.getElementById('editTipo').value = data.tipo? data.tipo : "";
            console.log('Tipo de promoción:', data.descuento);
            document.getElementById('editDescuento').value = data.descuento ? data.descuento : "";
            document.getElementById('editDescripcion').value = data.descripcion? data.descripcion: "";
            
            // Formatear las fechas en YYYY-MM-DD para el input date
            const fechaInicio = data.fechaInicio? new Date(data.fechaInicio): "";
            const fechaFin = data.fechaFin? new Date(data.fechaFin):"";
            
            document.getElementById('editFechaInicio').value = fechaInicio.toISOString().split('T')[0];
            document.getElementById('editFechaFin').value = fechaFin.toISOString().split('T')[0];
            document.getElementById('editEstado').value = data.estado.toString();
            
            // Cargar los cursos disponibles y marcar los seleccionados
            const cursosContainer = document.getElementById('editCursosContainer');
            cursosContainer.innerHTML = ''; // Limpiar el contenedor
            
            // Obtener los IDs de los cursos asociados a esta promoción
            const cursosSeleccionados = data.promocion_cursos.map(curso => curso.ID_Curso);
            
            // Cargar todos los cursos desde el controlador
            fetch('/administrador/cursos-disponibles')
                .then(response => response.json())
                .then(cursos => {
                    // Crear los checkboxes para cada curso
                    cursos.forEach(curso => {
                        // Verificar si este curso está seleccionado para esta promoción
                        const estaSeleccionado = cursosSeleccionados.includes(curso.ID_Curso);
                        
                        // Crear el elemento HTML para el checkbox
                        const checkboxDiv = document.createElement('div');
                        checkboxDiv.className = 'flex items-center mb-2';
                        
                        // Crear el input checkbox
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.id = `editCurso_${curso.ID_Curso}`;
                        checkbox.name = 'cursos[]';
                        checkbox.value = curso.ID_Curso;
                        checkbox.className = 'mr-2';
                        checkbox.checked = estaSeleccionado; // Marcar si está seleccionado
                        
                        // Crear la etiqueta para el checkbox
                        const label = document.createElement('label');
                        label.htmlFor = `editCurso_${curso.ID_Curso}`;
                        label.className = 'text-sm';
                        label.textContent = curso.nombreCurso;
                        
                        // Agregar elementos al div
                        checkboxDiv.appendChild(checkbox);
                        checkboxDiv.appendChild(label);
                        
                        // Agregar el div al contenedor de cursos
                        cursosContainer.appendChild(checkboxDiv);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar los cursos:', error);
                    cursosContainer.innerHTML = '<p class="text-red-500">Error al cargar los cursos disponibles</p>';
                });
            
            // Mostrar el modal
            toggleEditModal();
        })
        .catch(error => {
            console.error('Error al cargar datos:', error);
            alert(`Error al cargar los datos de la promoción: ${error.message}. Por favor, intenta de nuevo o contacta al administrador.`);
        });
}


// Script para validar formularios de promociones
document.addEventListener('DOMContentLoaded', function() {
    // Obtener referencias a los formularios
    const formAgregar = document.querySelector('form[action*="promocion.store"]');
    const formEditar = document.getElementById('formEditarPromocion');
    
    // Referencias a los campos del formulario para añadir
    const camposAgregar = {
        tipo: document.getElementById('tipo'),
        descuento: document.getElementById('descuento'),
        descripcion: document.getElementById('descripcion'),
        fechaInicio: document.getElementById('fechaInicio'),
        fechaFin: document.getElementById('fechaFin'),
        estado: document.getElementById('estado')
    };
    
    // Referencias a los campos del formulario para editar
    const camposEditar = {
        tipo: document.getElementById('editTipo'),
        descuento: document.getElementById('editDescuento'),
        descripcion: document.getElementById('editDescripcion'),
        fechaInicio: document.getElementById('editFechaInicio'),
        fechaFin: document.getElementById('editFechaFin'),
        estado: document.getElementById('editEstado')
    };
    
    // Configurar fecha mínima (hoy) para los inputs de fecha
    const today = new Date().toISOString().split('T')[0];
    
    if (camposAgregar.fechaInicio) {
        camposAgregar.fechaInicio.min = today;
    }
    
    if (camposEditar.fechaInicio) {
        camposEditar.fechaInicio.min = today;
    }
    
    // ----- VALIDACIONES PARA FORMULARIO DE AGREGAR -----
    
    // Validar campo de descuento (sólo números entre 1-100, máximo 2 decimales)
    if (camposAgregar.descuento) {
        camposAgregar.descuento.addEventListener('input', function() {
            validarDescuento(this);
        });
    }
    
    // Validar fechas
    if (camposAgregar.fechaInicio) {
        camposAgregar.fechaInicio.addEventListener('change', function() {
            validarFechaInicio(camposAgregar.fechaInicio, camposAgregar.fechaFin);
        });
    }
    
    if (camposAgregar.fechaFin) {
        camposAgregar.fechaFin.addEventListener('change', function() {
            validarFechaFin(camposAgregar.fechaInicio, camposAgregar.fechaFin);
        });
    }
    
    // Validar descripción (no vacía)
    if (camposAgregar.descripcion) {
        camposAgregar.descripcion.addEventListener('input', function() {
            validarCampoNoVacio(this, 'La descripción no puede estar vacía');
        });
    }
    
    // ----- VALIDACIONES PARA FORMULARIO DE EDITAR -----
    
    // Validar campo de descuento (sólo números entre 1-100, máximo 2 decimales)
    if (camposEditar.descuento) {
        camposEditar.descuento.addEventListener('input', function() {
            validarDescuento(this);
        });
    }
    
    // Validar fechas
    if (camposEditar.fechaInicio) {
        camposEditar.fechaInicio.addEventListener('change', function() {
            validarFechaInicio(camposEditar.fechaInicio, camposEditar.fechaFin);
        });
    }
    
    if (camposEditar.fechaFin) {
        camposEditar.fechaFin.addEventListener('change', function() {
            validarFechaFin(camposEditar.fechaInicio, camposEditar.fechaFin);
        });
    }
    
    // Validar descripción (no vacía)
    if (camposEditar.descripcion) {
        camposEditar.descripcion.addEventListener('input', function() {
            validarCampoNoVacio(this, 'La descripción no puede estar vacía');
        });
    }
    
    // ----- VALIDACIÓN DE FORMULARIOS COMPLETOS -----
    
    // Validación al enviar formulario de agregar
    if (formAgregar) {
        formAgregar.addEventListener('submit', function(e) {
            if (!validarFormularioCompleto(camposAgregar)) {
                e.preventDefault();
                mostrarAlerta('Por favor, corrige los errores antes de enviar el formulario');
            }
        });
    }
    
    // Validación al enviar formulario de editar
    if (formEditar) {
        formEditar.addEventListener('submit', function(e) {
            if (!validarFormularioCompleto(camposEditar)) {
                e.preventDefault();
                mostrarAlerta('Por favor, corrige los errores antes de enviar el formulario');
            }
        });
    }
    
    // ----- FUNCIONES DE VALIDACIÓN -----
    
    // Validar campo de descuento
    function validarDescuento(input) {
        // Eliminar caracteres no numéricos excepto el punto decimal
        input.value = input.value.replace(/[^\d.]/g, '');
        
        // Asegurar que solo hay un punto decimal
        const parts = input.value.split('.');
        if (parts.length > 2) {
            input.value = parts[0] + '.' + parts.slice(1).join('');
        }
        
        // Limitar a dos decimales
        if (parts.length > 1 && parts[1].length > 2) {
            input.value = parts[0] + '.' + parts[1].substring(0, 2);
        }
        
        // Verificar rango (1-100)
        const valor = parseFloat(input.value);
        
        if (isNaN(valor) || valor <= 0 || valor > 100) {
            mostrarError(input, 'El descuento debe estar entre 1 y 100');
            return false;
        } else {
            eliminarError(input);
            return true;
        }
    }
    
    // Validar fecha de inicio
    function validarFechaInicio(fechaInicioInput, fechaFinInput) {
        const fechaInicio = fechaInicioInput.value;
        const today = new Date().toISOString().split('T')[0];
        
        if (!fechaInicio) {
            mostrarError(fechaInicioInput, 'La fecha de inicio es obligatoria');
            return false;
        }
        
        if (fechaInicio < today) {
            mostrarError(fechaInicioInput, 'La fecha de inicio no puede ser anterior a hoy');
            return false;
        }
        
        eliminarError(fechaInicioInput);
        
        // Actualizar fecha mínima para la fecha de fin
        if (fechaFinInput) {
            // Calcular el día siguiente a la fecha de inicio
            const nextDay = new Date(fechaInicio);
            nextDay.setDate(nextDay.getDate() + 1);
            const nextDayFormatted = nextDay.toISOString().split('T')[0];
            
            fechaFinInput.min = nextDayFormatted;
            
            // Si la fecha de fin ya tiene un valor, validarla de nuevo
            if (fechaFinInput.value) {
                validarFechaFin(fechaInicioInput, fechaFinInput);
            }
        }
        
        return true;
    }
    
    // Validar fecha de fin
    function validarFechaFin(fechaInicioInput, fechaFinInput) {
        const fechaInicio = fechaInicioInput.value;
        const fechaFin = fechaFinInput.value;
        
        if (!fechaFin) {
            mostrarError(fechaFinInput, 'La fecha de fin es obligatoria');
            return false;
        }
        
        if (fechaInicio && fechaFin <= fechaInicio) {
            mostrarError(fechaFinInput, 'La fecha de fin debe ser posterior a la fecha de inicio');
            return false;
        }
        
        eliminarError(fechaFinInput);
        return true;
    }
    
    // Validar que un campo no esté vacío
    function validarCampoNoVacio(input, mensaje) {
        if (!input.value.trim()) {
            mostrarError(input, mensaje);
            return false;
        } else {
            eliminarError(input);
            return true;
        }
    }
    
    // Validar el formulario completo
    function validarFormularioCompleto(campos) {
        let formularioValido = true;
        
        // Validar cada campo del formulario
        if (campos.descuento && !validarDescuento(campos.descuento)) {
            formularioValido = false;
        }
        
        if (campos.descripcion && !validarCampoNoVacio(campos.descripcion, 'La descripción no puede estar vacía')) {
            formularioValido = false;
        }
        
        if (campos.fechaInicio && !validarFechaInicio(campos.fechaInicio, campos.fechaFin)) {
            formularioValido = false;
        }
        
        if (campos.fechaFin && !validarFechaFin(campos.fechaInicio, campos.fechaFin)) {
            formularioValido = false;
        }
        
        // Validar selección de cursos
        const cursosSeleccionados = document.querySelectorAll('input[name="cursos[]"]:checked');
        const cursosContainer = campos === camposAgregar ? document.querySelector('.max-h-60') : document.getElementById('editCursosContainer');
        
        if (cursosSeleccionados.length === 0) {
            if (cursosContainer) {
                // Mostrar mensaje de error para la selección de cursos
                let errorElement = cursosContainer.nextElementSibling;
                if (!errorElement || !errorElement.classList.contains('error-message')) {
                    errorElement = document.createElement('span');
                    errorElement.className = 'error-message';
                    cursosContainer.parentNode.insertBefore(errorElement, cursosContainer.nextSibling);
                }
                errorElement.textContent = 'Debe seleccionar al menos un curso';
            }
            formularioValido = false;
        } else {
            // Eliminar mensaje de error si existe
            const errorElement = cursosContainer?.nextElementSibling;
            if (errorElement && errorElement.classList.contains('error-message')) {
                errorElement.remove();
            }
        }
        
        return formularioValido;
    }
    
    // ----- FUNCIONES AUXILIARES -----
    
    // Mostrar mensaje de error para un campo
    function mostrarError(input, mensaje) {
        input.classList.add('border-red-500');
        
        // Verificar si ya existe un mensaje de error
        let errorElement = input.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('error-message')) {
            errorElement = document.createElement('span');
            errorElement.className = 'error-message';
            input.parentNode.insertBefore(errorElement, input.nextSibling);
        }
        
        errorElement.textContent = mensaje;
    }
    
    // Eliminar mensaje de error de un campo
    function eliminarError(input) {
        input.classList.remove('border-red-500');
        
        const errorElement = input.nextElementSibling;
        if (errorElement && errorElement.classList.contains('error-message')) {
            errorElement.remove();
        }
    }
    
    // Mostrar alerta general
    function mostrarAlerta(mensaje) {
        // Usar el modal de confirmación existente
        const confirmacionModal = document.getElementById('confirmacionModal');
        const mensajeElement = document.getElementById('confirmacionMensaje');
        
        if (confirmacionModal && mensajeElement) {
            mensajeElement.textContent = mensaje;
            confirmacionModal.classList.remove('hidden');
            
            // Configurar botones
            const btnCancelar = document.getElementById('cancelarConfirmacion');
            const btnAceptar = document.getElementById('aceptarConfirmacion');
            
            btnCancelar.style.display = 'none'; // Ocultar botón de cancelar
            
            // Configurar el botón aceptar para cerrar la alerta
            btnAceptar.textContent = 'Entendido';
            btnAceptar.onclick = function() {
                confirmacionModal.classList.add('hidden');
                btnCancelar.style.display = ''; // Restaurar visibilidad
            };
        } else {
            // Fallback a alerta estándar si no existe el modal
            alert(mensaje);
        }
    }
});
    </script>

</body>

</html>