<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Apertura de Módulos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                        secondary: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 text-gray-800">
    <!-- Menú lateral -->
    @include('partials.navAdmi')
    <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilAdmin')

        <!-- Contenido principal -->
        <div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-primary-800">Apertura de Módulos</h1>
                <button onclick="openModal('create')"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nueva Apertura
                </button>
            </div>

            <!-- Tarjetas de aperturas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($aperturas as $apertura)
                    @php
                        $isActive =
                            $apertura->estado === 1 || $apertura->estado === '1' || $apertura->estado === 'Activo';
                        $primaryColor = $isActive ? 'teal' : 'purple';
                        $headerBg = "bg-{$primaryColor}-500";
                        $headerText = 'text-white';
                        $badgeBg = "bg-{$primaryColor}-600";
                    @endphp

                    <div
                        class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-200">
                        <!-- Encabezado tipo banner -->
                        <div class="{{ $headerBg }} px-5 py-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-xs {{ $badgeBg }} {{ $headerText }} mb-1">
                                        {{ $apertura->modulo->curso->nombreCurso ?? 'Curso' }}
                                    </span>
                                    <h3 class="text-lg font-bold {{ $headerText }}">
                                        {{ $apertura->modulo->nombreModulo ?? 'Módulo' }}</h3>
                                </div>
                                <div class="text-white/80">
                                    <i class="fas fa-book-open text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido principal -->
                        <div class="p-5">
                            <!-- Docente - Estilo minimalista -->
                            <div class="flex items-center mb-3">
                                <i class="fas fa-user-tie text-gray-500 mr-3"></i>
                                <p class="text-gray-700">
                                    @if ($apertura->docente && $apertura->docente->usuario)
                                        {{ trim($apertura->docente->usuario->nombre . ' ' . ($apertura->docente->usuario->apellidoPaterno ?? '') . ' ' . ($apertura->docente->usuario->apellidoMaterno ?? '')) ?: 'Usuario sin nombre' }}
                                    @else
                                        Docente no asignado
                                    @endif
                                </p>
                            </div>

                            <!-- Fechas - Estilo plomo -->
                            <div class="bg-gray-100 rounded-lg p-3 mb-4 text-center border border-gray-200">
                                <p class="text-sm text-gray-500 mb-1">Fechas</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($apertura->fechaInicio)->format('d M') }} -
                                    {{ \Carbon\Carbon::parse($apertura->fechaFin)->format('d M Y') }}
                                </p>
                            </div>

                            <!-- Costo -->
                            <div class="flex justify-between items-center border-t border-gray-100 pt-3">
                                <p class="text-sm text-gray-500">Inversión:</p>
                                <p class="font-bold text-{{ $primaryColor }}-600">
                                    Bs. {{ number_format($apertura->CostoModulo, 1) }}</p>
                            </div>

                            <!-- Acciones -->
                            <div class="flex justify-end space-x-2 mt-4">
                                <button onclick="openModal('edit', {{ $apertura->ID_Apertura }})"
                                    class="p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-colors"
                                    title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button onclick="toggleStatus({{ $apertura->ID_Apertura }})"
                                    class="p-2 rounded-full transition-colors
                    {{ $apertura->estado == 1 || $apertura->estado === '1' ? 'bg-teal-500 text-white hover:bg-teal-600' : 'bg-purple-500 text-white hover:bg-purple-600' }}"
                                    title="{{ $apertura->estado == 1 || $apertura->estado === '1' ? 'Desactivar' : 'Activar' }}">
                                    <i
                                        class="fas {{ $apertura->estado == 1 || $apertura->estado === '1' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal para crear/editar (se mantiene igual) -->
    <div id="aperturaModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Nueva Apertura</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="aperturaForm" class="p-6">
                @csrf
                <input type="hidden" id="aperturaId" name="id">
                <!-- Modificar tu modal para incluir todos los módulos desde el inicio -->
                <div class="mb-4">
                    <label for="ID_Curso" class="block text-sm font-medium text-gray-700 mb-1">Curso</label>
                    <select id="ID_Curso" name="ID_Curso"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        required>
                        <option value="">Seleccione un curso</option>
                        @forelse($cursos as $curso)
                            <option value="{{ $curso->ID_Curso }}" @if (old('ID_Curso') == $curso->ID_Curso) selected @endif>
                                {{ $curso->nombreCurso }}
                            </option>
                        @empty
                            <option value="" disabled>No hay cursos disponibles</option>
                        @endforelse
                    </select>
                </div>

                <div class="mb-4">
                    <label for="ID_Modulo" class="block text-sm font-medium text-gray-700 mb-1">Módulo</label>

                    <!-- Placeholder que se muestra cuando no hay curso seleccionado -->
                    <div id="moduloPlaceholder"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-500">
                        Primero seleccione un curso
                    </div>

                    <!-- Select de módulos que se muestra cuando se cargan los datos -->
                    <select id="ID_Modulo" name="ID_Modulo"
                        class="hidden w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        required>
                        <option value="">Seleccione un módulo</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="codigoDocente" class="block text-sm font-medium text-gray-700 mb-1">Docente</label>
                    <select id="codigoDocente" name="codigoDocente"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        required>
                        <option value="">Seleccione un docente</option>
                        @foreach ($docentes as $docente)
                            <option value="{{ $docente->codigoDocente }}">{{ $docente->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="fechaInicio" class="block text-sm font-medium text-gray-700 mb-1">Fecha
                            Inicio</label>
                        <input type="date" id="fechaInicio" name="fechaInicio"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                            required>
                    </div>
                    <div>
                        <label for="fechaFin" class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin</label>
                        <input type="date" id="fechaFin" name="fechaFin"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                            required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="CostoModulo" class="block text-sm font-medium text-gray-700 mb-1">Costo del
                        Módulo</label>
                    <input type="number" step="0.01" id="CostoModulo" name="CostoModulo"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        required>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Variables globales
        let currentAction = 'create';
        let currentAperturaId = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Agregar event listener al select de curso
            document.getElementById('ID_Curso').addEventListener('change', function() {
                loadModulos(this.value);
            });
        });
        // Abrir modal
        function openModal(action, id = null) {
            currentAction = action;
            currentAperturaId = id;

            const modal = document.getElementById('aperturaModal');
            const title = document.getElementById('modalTitle');
            const placeholder = document.getElementById('moduloPlaceholder');
            const moduloSelect = document.getElementById('ID_Modulo');

            if (action === 'create') {
                title.textContent = 'Nueva Apertura';
                document.getElementById('aperturaForm').reset();
                document.getElementById('aperturaId').value = '';

                // Reset del selector de módulos
                placeholder.classList.remove('hidden');
                placeholder.textContent = 'Primero seleccione un curso';
                moduloSelect.classList.add('hidden');
                moduloSelect.innerHTML = '<option value="">Seleccione un módulo</option>';
                moduloSelect.disabled = true;

            } else if (action === 'edit' && id) {
                title.textContent = 'Editar Apertura';
                fetchAperturaData(id);
            }

            modal.classList.remove('hidden');
        }

        // Cerrar modal
        function closeModal() {
            document.getElementById('aperturaModal').classList.add('hidden');
        }

        // Cargar módulos según curso seleccionado
        function loadModulos(cursoId) {
            const moduloSelect = document.getElementById('ID_Modulo');
            const placeholder = document.getElementById('moduloPlaceholder');

            if (!cursoId) {
                // Mostrar placeholder y ocultar select
                moduloSelect.classList.add('hidden');
                placeholder.classList.remove('hidden');
                placeholder.textContent = 'Primero seleccione un curso';
                return;
            }

            // Mostrar loading
            placeholder.textContent = 'Cargando módulos...';
            placeholder.classList.remove('hidden');
            moduloSelect.classList.add('hidden');

            fetch(`/apertura-modulos/modulos-por-curso/${cursoId}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Ocultar placeholder y mostrar select
                    placeholder.classList.add('hidden');
                    moduloSelect.classList.remove('hidden');

                    let options = '<option value="">Seleccione un módulo</option>';

                    if (data && data.length > 0) {
                        data.forEach(modulo => {
                            options += `<option value="${modulo.ID_Modulo}">${modulo.nombreModulo}</option>`;
                        });
                        moduloSelect.innerHTML = options;
                        moduloSelect.disabled = false;
                    } else {
                        moduloSelect.innerHTML = '<option value="">No hay módulos disponibles para este curso</option>';
                        moduloSelect.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    placeholder.textContent = 'Error al cargar módulos. Intente nuevamente.';
                    placeholder.classList.remove('hidden');
                    moduloSelect.classList.add('hidden');
                });
        }

        // Obtener datos de apertura para edición
        function fetchAperturaData(id) {
            fetch(`/apertura-modulos/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('aperturaId').value = data.ID_Apertura;
                    document.getElementById('ID_Curso').value = data.modulo.ID_Curso;
                    loadModulos(data.modulo.ID_Curso);

                    // Esperar un momento para que se carguen los módulos
                    setTimeout(() => {
                        document.getElementById('ID_Modulo').value = data.ID_Modulo;
                    }, 300);

                    document.getElementById('codigoDocente').value = data.codigoDocente;
                    document.getElementById('fechaInicio').value = data.fechaInicio;
                    document.getElementById('fechaFin').value = data.fechaFin;
                    document.getElementById('CostoModulo').value = data.CostoModulo;
                })
                .catch(error => console.error('Error:', error));
        }

        // Enviar formulario
        document.getElementById('aperturaForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const url = currentAction === 'create' ?
                '/apertura-modulos' :
                `/apertura-modulos/${currentAperturaId}`;
            const method = currentAction === 'create' ? 'POST' : 'PUT';

            fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.success,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        closeModal();
                        setTimeout(() => location.reload(), 1600);
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Cambiar estado (Activo/Inactivo)
        function toggleStatus(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres cambiar el estado de esta apertura?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/apertura-modulos/toggle-status/${id}`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Estado cambiado',
                                    text: 'El estado se ha actualizado correctamente',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                // Recargar la página para mostrar los cambios
                                setTimeout(() => location.reload(), 1600);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        }
    </script>
</body>

</html>
