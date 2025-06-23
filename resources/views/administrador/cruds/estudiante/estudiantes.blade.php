
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Estudiantes - Administración</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
      /* Reemplaza el estilo actual de los modales con esto */
      #modalAddEstudiante, #modalEditEstudiante, #detailsModal {
          max-height: 100vh; /* altura máxima del 90% de la ventana */
          overflow-y: visible; /* permite scroll vertical */
          max-width: 100%; /* ancho máximo del 95% de la ventana */
          margin: 0 auto; /* centra el modal */
      }
      .modal-container {
          padding: 20px;
          max-height: calc(90vh - 40px); /* altura máxima menos padding */
          overflow-y: auto;
      }

      /* Estilos para impresión */
      @media print {
          body * {
              visibility: hidden;
          }
          
          #printable-area, #printable-area * {
              visibility: visible;
          }
          
          #printable-area {
              position: absolute;
              left: 0;
              top: 0;
              width: 100%;
          }
          
          .print-header {
              text-align: center;
              margin-bottom: 30px;
          }
          
          .print-table {
              width: 100%;
              border-collapse: collapse;
              font-size: 12px;
          }
          
          .print-table th,
          .print-table td {
              border: 1px solid #000;
              padding: 8px;
              text-align: left;
          }
          
          .print-table th {
              background-color: #f5f5f5;
              font-weight: bold;
          }
          
          .print-footer {
              margin-top: 30px;
              text-align: center;
              font-size: 10px;
          }
          
          /* Ocultar elementos que no se deben imprimir */
          .no-print {
              display: none !important;
          }
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
        <h1 class="text-3xl font-bold text-[#2e1a47]">Gestión de Estudiantes</h1>
        <div class="flex gap-3">
          <button onclick="imprimirLista()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center gap-2">
            <i class="bi bi-printer"></i>
            Imprimir Lista
          </button>
          <button onclick="toggleModal('modalAddEstudiante')" class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg shadow">
            + Añadir Estudiante
          </button>
        </div>
      </div>

      <!-- Sección de Filtros -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-[#2e1a47] mb-4 flex items-center">
          <i class="bi bi-filter mr-2"></i>
          Filtros de Búsqueda
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
          <!-- Filtro por Código Estudiantil -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Código Estudiantil</label>
            <input 
              type="text" 
              id="filtroCodigo" 
              placeholder="Buscar por código..."
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#127475] focus:border-transparent"
            >
          </div>

          <!-- Filtro por Nombre -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
            <input 
              type="text" 
              id="filtroNombre" 
              placeholder="Buscar por nombre..."
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#127475] focus:border-transparent"
            >
          </div>

          <!-- Filtro por Estado -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
            <select 
              id="filtroEstado"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#127475] focus:border-transparent"
            >
              <option value="">Todos los estados</option>
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>

          <!-- Botones de acción -->
          <div class="flex gap-2">
            <button 
              onclick="aplicarFiltros()" 
              class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200"
            >
              <i class="bi bi-search"></i>
              Buscar
            </button>
            <button 
              onclick="limpiarFiltros()" 
              class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition duration-200"
            >
              <i class="bi bi-arrow-clockwise"></i>
              Limpiar
            </button>
          </div>
        </div>

        <!-- Contador de resultados -->
        <div class="mt-4 pt-4 border-t border-gray-200">
          <div class="flex justify-between items-center text-sm text-gray-600">
            <span id="contadorResultados">Mostrando todos los estudiantes</span>
            <span id="totalEstudiantes"></span>
          </div>
        </div>
      </div>

      <!-- Tabla de Estudiantes -->
      <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full min-w-[1000px] text-sm text-left" id="tablaEstudiantesCompleta">

          <thead class="bg-[#1f1b2e] text-white">
            <tr>
              <th class="px-6 py-3">#</th>
              <th class="px-6 py-3">Código</th>
              <th class="px-6 py-3">Nombre</th>
              <th class="px-6 py-3">Nivel Academico</th>
              <th class="px-6 py-3 no-print">Información</th>
              <th class="px-6 py-3">Estado</th>
              <th class="px-6 py-3 text-center no-print">Acciones</th>
            </tr>
          </thead>
          <tbody id="tablaEstudiantes">
            @forelse ($estudiantes as $index => $estudiante)
            <tr class="border-b hover:bg-gray-100 fila-estudiante" 
                data-codigo="{{ $estudiante->codigoEstudiantil }}" 
                data-nombre="{{ strtolower($estudiante->usuario->nombre . ' ' . $estudiante->usuario->apellidoPaterno . ' ' . $estudiante->usuario->apellidoMaterno) }}" 
                data-estado="{{ $estudiante->usuario->estado }}">
              <td class="px-6 py-4">{{ $index + 1 }}</td>
              <td class="px-6 py-4">{{ $estudiante->codigoEstudiantil }}</td>
              <td class="px-6 py-4">
                {{ $estudiante->usuario->nombre }}
                {{ $estudiante->usuario->apellidoPaterno }}
                {{ $estudiante->usuario->apellidoMaterno }}
              </td>
              <td class="px-6 py-4">{{ $estudiante->nivelAcademico }}</td>
            

              <td class="px-6 py-4 flex items-center justify-center no-print" x-data="{ showModal: false }">
                <button 
                  class="bg-black hover:bg-black-700 text-white px-3 py-2 rounded-full flex items-center  gap-2"
                  type="button"
                  @click="showModal = !showModal; openDetailsModal(
                    '{{ $estudiante->usuario->telefono }}',
                  '{{ $estudiante->usuario->direccion }}',
                  '{{ $estudiante->usuario->fechaNacimiento }}',
                  '{{ $estudiante->usuario->email }}',
                  '{{ $estudiante->usuario->ci }}'
                  )" class="text-blue-600 hover:text-blue-900 mr-2">
                  
                  <template x-if="!showModal">
                    <i class="bi bi-eye q text-lg"></i>
                  </template>
                  <template x-if="showModal">
                    <i class="bi bi-eye-slash text-lg"></i>
                  </template>
                </button>
                <!-- Modal -->
                <div x-show="showModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center" @click.away="showModal = false">
                  
                </div>
              </td>

              <td class="px-6 py-4">
                  <div class="inline-flex items-center gap-2">
                      <span class="w-3.5 h-3.5 rounded-full {{ $estudiante->usuario->estado == 1 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                      <span class="text-sm">
                          {{ $estudiante->usuario->estado == 1 ? 'Activo' : 'Inactivo' }}
                      </span>
                  </div>
              </td>

              <td class="px-6 py-4 text-center no-print">
                <div class="flex items-center gap-4">
                  <button type="button" onclick="openEditModal('{{ $estudiante->codigoEstudiantil }}', '{{ $estudiante->ID_Usuario }}')"
                          class="editar-curso bg-purple-800 hover:bg-purple-700 text-white px-4 py-3 rounded-full flex items-center gap-5">
                        <!-- Nuevo ícono de Bootstrap -->
                      <i class="bi bi-pencil-fill"></i> 
                  </button>

                  <form id="formCambiarEstado" method="POST" action="{{ route('estudiantes.cambiarEstado', $estudiante->codigoEstudiantil) }}"
                    class="inline">
                  @csrf
                  <button type="submit"
                      class="{{ $estudiante->usuario->estado == 1 
                          ? 'bg-red-500 hover:bg-red-700'  // Amarillo para deshabilitar
                          : 'bg-green-500 hover:bg-green-700' }}  // Verde para habilitar
                          text-white px-4 py-3 rounded-full flex items-center gap-3 text-sm font-medium shadow-sm transition duration-300">

                      @if($estudiante->usuario->estado == 1)
                          <i class="bi bi-x-circle-fill"></i> 
                      @else
                          <i class="bi bi-check-circle-fill"></i> 
                      @endif
                  </button>
                 </form>
              </div>

              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-gray-500">No hay estudiantes registrados.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        
        <!-- Mensaje cuando no hay resultados de filtro -->
        <div id="sinResultados" class="hidden text-center py-8">
          <div class="flex flex-col items-center justify-center text-gray-500">
            <i class="bi bi-search text-4xl mb-2"></i>
            <p class="text-lg font-medium">No se encontraron estudiantes</p>
            <p class="text-sm">Intenta ajustar los filtros de búsqueda</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Área de impresión (oculta en pantalla) -->
  <div id="printable-area" style="display: none;">
    <div class="print-header">
      <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">Lista de Estudiantes</h1>
      <p id="print-subtitle" style="font-size: 14px; color: #666;"></p>
      <p style="font-size: 12px; color: #666;">Fecha de impresión: <span id="print-date"></span></p>
    </div>
    
    <table class="print-table" id="print-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Código</th>
          <th>Nombre Completo</th>
          <th>Nivel Académico</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody id="print-table-body">
        <!-- Los datos se llenarán dinámicamente -->
      </tbody>
    </table>
    
    <div class="print-footer">
      <p>Total de estudiantes: <span id="print-total"></span></p>
      <hr style="margin: 20px 0;">
      <p>Sistema de Gestión de Estudiantes - Administración</p>
    </div>
  </div>

  <!-- Modal Añadir Estudiante -->
  <div id="modalAddEstudiante" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl">
      <div class="modal-container">

        <h2 class="text-2xl font-bold mb-6 text-[#2e1a47]">Añadir Estudiante</h2>
        <form method="POST" action="{{ route('estudiantes.store') }}">
          @csrf

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
              <label class="block text-gray-700">Nombre:</label>
              <input type="text" name="nombre" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
              <label class="block text-gray-700">Apellido Paterno:</label>
              <input type="text" name="apellidoPaterno" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
              <label class="block text-gray-700">Apellido Materno:</label>
              <input type="text" name="apellidoMaterno" class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-gray-700">Nivel Academico:</label>
              <input type="text" name="nivelAcademico" class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-gray-700">Teléfono:</label>
              <input type="text" name="telefono" class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-gray-700">Dirección:</label>
              <input type="text" name="direccion" class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-gray-700">Fecha de Nacimiento:</label>
              <input type="date" name="fechaNacimiento" class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-gray-700">Email:</label>
              <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
              <label class="block text-gray-700">CI:</label>
              <input type="text" name="ci" class="w-full border rounded px-3 py-2">
            </div>
          </div>

          <div>
            <label class="block text-gray-700">Estado:</label>
            <select name="estado" class="w-full border rounded px-3 py-2" required>
              <option value="" disabled selected>Seleccione un estado</option>
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>

          <div class="flex justify-end mt-6 space-x-4">
            <button type="button" onclick="toggleModal('modalAddEstudiante')" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
              Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-[#127475] text-white rounded hover:bg-[#0f5f5e]">
              Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal Editar Estudiante -->
  <div id="modalEditEstudiante" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl">
      <div class="modal-container">

        <h2 class="text-2xl font-bold mb-6 text-[#2e1a47]">Editar Estudiante</h2>
        <form id="formEditEstudiante" method="POST" action="">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" id="edit_codigo_estudiantil" name="codigoEstudiantil">

            <div>
              <label class="block text-gray-700">Nombre:</label>
              <input type="text" id="edit_nombre" name="nombre" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
              <label class="block text-gray-700">Apellido Paterno:</label>
              <input type="text" id="edit_apellido_paterno" name="apellidoPaterno" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
              <label class="block text-gray-700">Apellido Materno:</label>
              <input type="text" id="edit_apellido_materno" name="apellidoMaterno" class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-gray-700">Nivel Academico:</label>
              <input type="text" id="edit_nivelAcademico" name="nivelAcademico" class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-gray-700">Teléfono:</label>
              <input type="text" id="edit_telefono" name="telefono" class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-gray-700">Dirección:</label>
              <input type="text" id="edit_direccion" name="direccion" class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-gray-700">Fecha de Nacimiento:</label>
              <input type="date" id="edit_fecha_nacimiento" name="fechaNacimiento" class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-gray-700">Email:</label>
              <input type="email" id="edit_email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
              <label class="block text-gray-700">CI:</label>
              <input type="text" id="edit_ci" name="ci" class="w-full border rounded px-3 py-2">
            </div>
            <div>
              <label class="block text-gray-700">Estado:</label>
              <select id="edit_estado" name="estado" class="w-full border rounded px-3 py-2" required>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
          </div>

          <div class="flex justify-end mt-6 space-x-4">
            <button type="button" onclick="toggleModal('modalEditEstudiante')" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
              Cancelar
            </button>
            <button type="submit" class="px-4 py-2 bg-[#127475] text-white rounded hover:bg-[#0f5f5e]">
              Actualizar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal para detalles que no son importantes del todo en estudiante-->
  <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">Detalles del Estudiante</h2>
      <div class="space-y-2 text-sm">
        <p><strong>Teléfono:</strong> <span id="modalTelefono"></span></p>
        <p><strong>Dirección:</strong> <span id="modalDireccion"></span></p>
        <p><strong>Fecha de nacimiento:</strong> <span id="modalNacimiento"></span></p>
        <p><strong>Email:</strong> <span id="modalEmail"></span></p>
        <p><strong>CI:</strong> <span id="modalCI"></span></p>
      </div>
      <button onclick="closeDetailsModal()" class="mt-4 bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">
        Cerrar
      </button>
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

  <!-- Scripts opcionales -->
  <script>
    // Variables globales para el filtrado
    let filasOriginales = [];
    let totalEstudiantes = 0;

    // Función para imprimir la lista de estudiantes visibles
    function imprimirLista() {
      // Obtener filas visibles
      const filasVisibles = document.querySelectorAll('.fila-estudiante:not([style*="display: none"])');
      
      if (filasVisibles.length === 0) {
        alert('No hay estudiantes para imprimir. Verifica los filtros aplicados.');
        return;
      }

      // Limpiar tabla de impresión
      const printTableBody = document.getElementById('print-table-body');
      printTableBody.innerHTML = '';

      // Llenar tabla de impresión con datos visibles
      let contador = 1;
      filasVisibles.forEach(fila => {
        const codigo = fila.getAttribute('data-codigo');
        const nombre = fila.cells[2].textContent.trim();
        const nivelAcademico = fila.cells[3].textContent.trim();
        const estadoElement = fila.cells[5].querySelector('span:last-child');
        const estado = estadoElement ? estadoElement.textContent.trim() : '';

        const newRow = printTableBody.insertRow();
        newRow.innerHTML = `
          <td>${contador}</td>
          <td>${codigo}</td>
          <td>${nombre}</td>
          <td>${nivelAcademico}</td>
          <td>${estado}</td>
        `;
        contador++;
      });

      // Configurar información de la impresión
      const printDate = new Date().toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });

      document.getElementById('print-date').textContent = printDate;
      document.getElementById('print-total').textContent = filasVisibles.length;

      // Configurar subtítulo basado en filtros aplicados
      let subtitulo = 'Lista completa de estudiantes';
      const filtroCodigo = document.getElementById('filtroCodigo').value;
      const filtroNombre = document.getElementById('filtroNombre').value;
      const filtroEstado = document.getElementById('filtroEstado').value;

      if (filtroCodigo || filtroNombre || filtroEstado) {
        subtitulo = 'Lista filtrada de estudiantes';
        const filtrosAplicados = [];
        if (filtroCodigo) filtrosAplicados.push(`Código: "${filtroCodigo}"`);
        if (filtroNombre) filtrosAplicados.push(`Nombre: "${filtroNombre}"`);
        if (filtroEstado) {
          const estadoTexto = filtroEstado === '1' ? 'Activo' : 'Inactivo';
          filtrosAplicados.push(`Estado: ${estadoTexto}`);
        }
        subtitulo += ` (${filtrosAplicados.join(', ')})`;
      }

      document.getElementById('print-subtitle').textContent = subtitulo;

      // Mostrar área de impresión y imprimir
      const printArea = document.getElementById('printable-area');
      printArea.style.display = 'block';
      
      // Esperar un momento para que se renderice el contenido
      setTimeout(() => {
        window.print();
        // Ocultar área de impresión después de imprimir
        printArea.style.display = 'none';
      }, 100);
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

    // Función para aplicar filtros
    function aplicarFiltros() {
      const filtroCodigo = document.getElementById('filtroCodigo').value.toLowerCase().trim();
      const filtroNombre = document.getElementById('filtroNombre').value.toLowerCase().trim();
      const filtroEstado = document.getElementById('filtroEstado').value;

      const filas = document.querySelectorAll('.fila-estudiante');
      let contadorVisibles = 0;
      let numeroFila = 1;

      filas.forEach(fila => {
        const codigo = fila.getAttribute('data-codigo').toLowerCase();
        const nombre = fila.getAttribute('data-nombre');
        const estado = fila.getAttribute('data-estado');

        let mostrar = true;

        // Filtro por código
        if (filtroCodigo && !codigo.includes(filtroCodigo)) {
          mostrar = false;
        }

        // Filtro por nombre
        if (filtroNombre && !nombre.includes(filtroNombre)) {
          mostrar = false;
        }

        // Filtro por estado
        if (filtroEstado && estado !== filtroEstado) {
          mostrar = false;
        }

        if (mostrar) {
          fila.style.display = '';
          // Actualizar número de fila
          fila.querySelector('td:first-child').textContent = numeroFila;
          numeroFila++;
          contadorVisibles++;
        } else {
          fila.style.display = 'none';
        }
      });

      // Actualizar contador de resultados
      actualizarContador(contadorVisibles);
      
      // Mostrar/ocultar mensaje de sin resultados
      const sinResultados = document.getElementById('sinResultados');
      if (contadorVisibles === 0) {
        sinResultados.classList.remove('hidden');
      } else {
        sinResultados.classList.add('hidden');
      }
    }

    // Función para limpiar filtros
    function limpiarFiltros() {
      document.getElementById('filtroCodigo').value = '';
      document.getElementById('filtroNombre').value = '';
      document.getElementById('filtroEstado').value = '';
      
      // Mostrar todas las filas y resetear numeración
      const filas = document.querySelectorAll('.fila-estudiante');
      filas.forEach((fila, index) => {
        fila.style.display = '';
        fila.querySelector('td:first-child').textContent = index + 1;
      });

      // Ocultar mensaje de sin resultados
      document.getElementById('sinResultados').classList.add('hidden');
      
      // Actualizar contador
      actualizarContador(filas.length);
    }

    // Función para actualizar contador de resultados
    function actualizarContador(visible) {
      const contadorElement = document.getElementById('contadorResultados');
      const totalElement = document.getElementById('totalEstudiantes');
      
      if (visible === totalEstudiantes) {
        contadorElement.textContent = 'Mostrando todos los estudiantes';
      } else {
        contadorElement.textContent = `Mostrando ${visible} de ${totalEstudiantes} estudiantes`;
      }
      
      totalElement.textContent = `Total: ${totalEstudiantes}`;
    }

    // Función para filtrado en tiempo real
    function configurarFiltradoTiempoReal() {
      const inputs = ['filtroCodigo', 'filtroNombre', 'filtroEstado'];
      
      inputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
          input.addEventListener('input', aplicarFiltros);
          if (input.tagName === 'SELECT') {
            input.addEventListener('change', aplicarFiltros);
          }
        }
      });
    }

    // Función para permitir filtrado con Enter
    function configurarEnterParaFiltrar() {
      const inputs = ['filtroCodigo', 'filtroNombre'];
      
      inputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
          input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
              aplicarFiltros();
            }
          });
        }
      });
    }

    // Inicializar filtros cuando se carga la página
    document.addEventListener('DOMContentLoaded', function() {
      // Contar total de estudiantes
      totalEstudiantes = document.querySelectorAll('.fila-estudiante').length;
      actualizarContador(totalEstudiantes);
      
      // Configurar filtrado en tiempo real
      configurarFiltradoTiempoReal();
      
      // Configurar filtrado con Enter
      configurarEnterParaFiltrar();
    });
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
            
        const mensaje = "{{ $estudiante->usuario->estado == 1 ? '¿Estás seguro de deshabilitar este estudiante?' : '¿Estás seguro de habilitar este estudiante?' }}";

        const confirmar = await mostrarConfirmacion(mensaje);

        if (confirmar) {
        form.submit(); // Envía el formulario si acepta
        }
        });
    });
    function openDetailsModal(telefono, direccion, nacimiento, email, ci) {
      document.getElementById('modalTelefono').textContent = telefono;
      document.getElementById('modalDireccion').textContent = direccion;
      document.getElementById('modalNacimiento').textContent = nacimiento;
      document.getElementById('modalEmail').textContent = email;
      document.getElementById('modalCI').textContent = ci;
      document.getElementById('detailsModal').classList.remove('hidden');
    }

    function closeDetailsModal() {
      document.getElementById('detailsModal').classList.add('hidden');
    }
  </script>
  <script>
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

    // Validar nombre/apellidos (solo letras, máximo 30 caracteres)
    function validarTexto(input) {
      // Reemplazar caracteres no permitidos mientras escribe
      input.value = input.value.replace(/[^A-Za-zÁáÉéÍíÓóÚúÑñ\s]/g, '');

      // Limitar a 30 caracteres
      if (input.value.length > 30) {
        input.value = input.value.substring(0, 30);
      }

      // Validar que no esté vacío y solo contenga letras
      return validarCampo(
        input,
        input.value.trim() !== '' && /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/.test(input.value),
        'Este campo solo debe contener letras (máximo 30 caracteres)'
      );
    }

    // Validar especialidad (solo letras, máximo 50 caracteres)
    function validarnivelAcademico(input) {
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
        'El nivel Academico solo debe contener letras (máximo 50 caracteres)'
      );
    }
    // Validar teléfono (solo 8 dígitos numéricos)
    function validarTelefono(input) {
      // Reemplazar caracteres no permitidos mientras escribe
      input.value = input.value.replace(/[^0-9]/g, '').substring(0, 8);

      // Validar que tenga exactamente 8 dígitos
      return validarCampo(
        input,
        /^\d{8}$/.test(input.value),
        'El teléfono debe contener exactamente 8 dígitos numéricos'
      );
    }

    // Validar dirección (máximo 150 caracteres)
    function validarDireccion(input) {
      // Limitar a 150 caracteres
      if (input.value.length > 150) {
        input.value = input.value.substring(0, 150);
      }

      // Validar que no esté vacío
      return validarCampo(
        input,
        input.value.trim() !== '',
        'La dirección es obligatoria (máximo 150 caracteres)'
      );
    }

    // Validar CI (solo números, entre 6 y 10 dígitos)
    function validarCI(input) {
      // Reemplazar caracteres no permitidos mientras escribe
      input.value = input.value.replace(/[^0-9]/g, '');

      // Limitar a 10 dígitos
      if (input.value.length > 10) {
        input.value = input.value.substring(0, 10);
      }

      // Validar que tenga entre 6 y 10 dígitos
      return validarCampo(
        input,
        input.value.trim() !== '' && /^\d{6,10}$/.test(input.value),
        'El CI debe contener entre 6 y 10 dígitos numéricos'
      );
    }

    // Validar email (formato válido, máximo 50 caracteres)
    function validarEmail(input) {
      // Limitar a 50 caracteres
      if (input.value.length > 50) {
        input.value = input.value.substring(0, 50);
      }

      // Validar formato y longitud
      return validarCampo(
        input,
        input.value.trim() !== '' && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value),
        'Ingrese un email válido (máximo 50 caracteres)'
      );
    }

    // Configurar límites de fecha (18-70 años)
    function configurarLimitesFecha(input) {
      const hoy = new Date();

      // Fecha máxima (18 años atrás desde hoy)
      const fechaMax = new Date(hoy);
      fechaMax.setFullYear(hoy.getFullYear() - 18);
      const maxDate = fechaMax.toISOString().split('T')[0];

      // Fecha mínima (70 años atrás desde hoy)
      const fechaMin = new Date(hoy);
      fechaMin.setFullYear(hoy.getFullYear() - 70);
      const minDate = fechaMin.toISOString().split('T')[0];

      // Establecer atributos min y max
      input.setAttribute('max', maxDate);
      input.setAttribute('min', minDate);

      // Validar la fecha actual si ya tiene un valor
      if (input.value) {
        validarFechaNacimiento(input);
      }
    }

    // Validar fecha de nacimiento (rango 18-70 años)
    function validarFechaNacimiento(input) {
      if (!input.value) {
        return validarCampo(input, false, 'La fecha de nacimiento es obligatoria');
      }

      const fechaNac = new Date(input.value);
      const hoy = new Date();

      // Calcular edad
      let edad = hoy.getFullYear() - fechaNac.getFullYear();
      const m = hoy.getMonth() - fechaNac.getMonth();
      if (m < 0 || (m === 0 && hoy.getDate() < fechaNac.getDate())) {
        edad--;
      }

      return validarCampo(
        input,
        edad >= 18 && edad <= 70,
        'La edad debe estar entre 18 y 70 años'
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

    // Validar select obligatorio
    function validarSelect(select) {
      return validarCampo(
        select,
        select.value !== '',
        'Debe seleccionar una opción'
      );
    }

    // Función para validar formulario completo antes de enviar
    function validarFormulario(event) {
  const form = event.target;
  let formValido = true;

  // Validar nombre (siempre obligatorio)
  const nombre = form.querySelector('[name="nombre"]');
  if (nombre && !validarTexto(nombre)) formValido = false;
  
  // Validar apellidos (al menos uno debe estar presente)
  const apellidoPaterno = form.querySelector('[name="apellidoPaterno"]');
  const apellidoMaterno = form.querySelector('[name="apellidoMaterno"]');
  
  // Validar formato de texto para los apellidos que tengan contenido
  if (apellidoPaterno && apellidoPaterno.value.trim() !== '' && !validarTextoApellido(apellidoPaterno)) {
    formValido = false;
  }
  
  if (apellidoMaterno && apellidoMaterno.value.trim() !== '' && !validarTextoApellido(apellidoMaterno)) {
    formValido = false;
  }
  
  // Verificar que al menos uno de los apellidos esté presente
  if (apellidoPaterno && apellidoMaterno && 
      apellidoPaterno.value.trim() === '' && 
      apellidoMaterno.value.trim() === '') {
    validarCampo(
      apellidoPaterno,
      false,
      'Debe ingresar al menos un apellido'
    );
    formValido = false;
  }

  // Validar nivelAcademico
  const nivelAcademico = form.querySelector('[name="nivelAcademico"]');
  if (nivelAcademico && !validarnivelAcademico(nivelAcademico)) formValido = false;

  // Validar teléfono
  const telefono = form.querySelector('[name="telefono"]');
  if (telefono && !validarTelefono(telefono)) formValido = false;

  // Validar dirección
  const direccion = form.querySelector('[name="direccion"]');
  if (direccion && !validarDireccion(direccion)) formValido = false;

  // Validar fecha de nacimiento
  const fechaNacimiento = form.querySelector('[name="fechaNacimiento"]');
  if (fechaNacimiento && !validarFechaNacimiento(fechaNacimiento)) formValido = false;

  // Validar email
  const email = form.querySelector('[name="email"]');
  if (email && !validarEmail(email)) formValido = false;

  // Validar CI
  const ci = form.querySelector('[name="ci"]');
  if (ci && !validarCI(ci)) formValido = false;

  // Validar estado
  const estado = form.querySelector('[name="estado"]');
  if (estado && !validarSelect(estado)) formValido = false;

  // Prevenir envío si hay errores
  if (!formValido) {
    event.preventDefault();
    return false;
  }

  return true;
}

function validarTextoApellido(input) {
  // Reemplazar caracteres no permitidos mientras escribe
  input.value = input.value.replace(/[^A-Za-zÁáÉéÍíÓóÚúÑñ\s]/g, '');

  // Limitar a 30 caracteres
  if (input.value.length > 30) {
    input.value = input.value.substring(0, 30);
  }

  // Validar que solo contenga letras si tiene contenido
  return validarCampo(
    input,
    input.value.trim() === '' || /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/.test(input.value),
    'Este campo solo debe contener letras (máximo 30 caracteres)'
  );
}

    // Agregar estilos CSS para los campos con error
    function agregarEstilos() {
      const style = document.createElement('style');
      style.innerHTML = `
    input.border-red-500, select.border-red-500 {
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

    // Inicializar validaciones
    document.addEventListener('DOMContentLoaded', function() {
  // Agregar estilos CSS
  agregarEstilos();

  // Establecer atributos maxlength directamente en los elementos
  document.querySelectorAll('input[name="nombre"]')
    .forEach(input => {
      input.setAttribute('maxlength', '30');
      input.setAttribute('required', 'required');
    });
  
  // Configurar apellidos: paterno y materno ya no son individualmente requeridos
  document.querySelectorAll('input[name="apellidoPaterno"], input[name="apellidoMaterno"]')
    .forEach(input => {
      input.setAttribute('maxlength', '30');
      // Quitamos el atributo required ya que la validación se hará en JS
      if (input.hasAttribute('required')) {
        input.removeAttribute('required');
      }
    });

  document.querySelectorAll('input[name="direccion"]')
    .forEach(input => input.setAttribute('maxlength', '150'));

  document.querySelectorAll('input[name="email"]')
    .forEach(input => input.setAttribute('maxlength', '50'));

  document.querySelectorAll('input[name="ci"]')
    .forEach(input => {
      input.setAttribute('minlength', '6');
      input.setAttribute('maxlength', '10');
    });
  
  // Establecer atributos maxlength directamente en los elementos
  document.querySelectorAll('input[name="nivelAcademico"]')
    .forEach(input => input.setAttribute('maxlength', '50'));

  // Validar formularios al enviar
  const formularios = document.querySelectorAll('#modalAddEstudiante form, #formEditEstudiante');
  formularios.forEach(form => {
    form.addEventListener('submit', validarFormulario);
  });

  // Validar nombres en tiempo real
  const camposNombre = document.querySelectorAll('input[name="nombre"]');
  camposNombre.forEach(input => {
    input.addEventListener('input', () => validarTexto(input));
    input.addEventListener('blur', () => validarTexto(input));
  });
  
  // Validar apellidos en tiempo real pero con la nueva función
  const camposApellidos = document.querySelectorAll('input[name="apellidoPaterno"], input[name="apellidoMaterno"]');
  camposApellidos.forEach(input => {
    input.addEventListener('input', () => validarTextoApellido(input));
    input.addEventListener('blur', () => validarTextoApellido(input));
    
    // Evento adicional para verificar la combinación de apellidos
    input.addEventListener('blur', function() {
      const form = this.closest('form');
      const apellidoPaterno = form.querySelector('[name="apellidoPaterno"]');
      const apellidoMaterno = form.querySelector('[name="apellidoMaterno"]');
      
      if (apellidoPaterno && apellidoMaterno && 
          apellidoPaterno.value.trim() === '' && 
          apellidoMaterno.value.trim() === '') {
        validarCampo(
          apellidoPaterno,
          false,
          'Debe ingresar al menos un apellido'
        );
      } else {
        // Eliminar mensaje de error si ya hay al menos un apellido
        const errorMsgExistente = apellidoPaterno.parentNode.querySelector('.error-message');
        if (errorMsgExistente) {
          errorMsgExistente.remove();
        }
        apellidoPaterno.classList.remove('border-red-500');
      }
    });
  });

      // Validar nivelAcademico con restricción de solo letras
      const camposnivelAcademico = document.querySelectorAll('input[name="nivelAcademico"]');
      camposnivelAcademico.forEach(input => {
        input.setAttribute('required', 'required');
        input.addEventListener('input', () => validarnivelAcademico(input));
        input.addEventListener('blur', () => validarnivelAcademico(input));
      });

      // Validar teléfono en tiempo real
      const camposTelefono = document.querySelectorAll('input[name="telefono"]');
      camposTelefono.forEach(input => {
        input.setAttribute('required', 'required');
        input.addEventListener('input', () => validarTelefono(input));
        input.addEventListener('blur', () => validarTelefono(input));
      });

      // Validar dirección en tiempo real
      const camposDireccion = document.querySelectorAll('input[name="direccion"]');
      camposDireccion.forEach(input => {
        input.setAttribute('required', 'required');
        input.addEventListener('input', () => validarDireccion(input));
        input.addEventListener('blur', () => validarDireccion(input));
      });

      // Configurar y validar fecha de nacimiento
      const camposFechaNacimiento = document.querySelectorAll('input[name="fechaNacimiento"]');
      camposFechaNacimiento.forEach(input => {
        input.setAttribute('required', 'required');
        // Configurar los límites de fecha (18-70 años)
        configurarLimitesFecha(input);
        input.addEventListener('change', () => validarFechaNacimiento(input));
        input.addEventListener('blur', () => validarFechaNacimiento(input));
      });

      // Validar email en tiempo real
      const camposEmail = document.querySelectorAll('input[name="email"]');
      camposEmail.forEach(input => {
        input.setAttribute('required', 'required');
        input.addEventListener('input', () => validarEmail(input));
        input.addEventListener('blur', () => validarEmail(input));
      });

      // Validar CI en tiempo real
      const camposCI = document.querySelectorAll('input[name="ci"]');
      camposCI.forEach(input => {
        input.setAttribute('required', 'required');
        input.addEventListener('input', () => validarCI(input));
        input.addEventListener('blur', () => validarCI(input));
      });

      // Validar estado en tiempo real
      const camposEstado = document.querySelectorAll('select[name="estado"]');
      camposEstado.forEach(select => {
        select.setAttribute('required', 'required');
        select.addEventListener('change', () => validarSelect(select));
        select.addEventListener('blur', () => validarSelect(select));
      });
    });


    function toggleModal(id) {
      const modal = document.getElementById(id);
      if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
      } else {
        modal.classList.add('hidden');
      }
    }

    function toggleEditModal() {
      const modal = document.getElementById('editModal');
      modal.classList.toggle('hidden');
    }

    function openEditModal(codigoEstudiantil, idUsuario) {
      // Agrega el prefijo "/administrador" para que coincida con tu definición de ruta
      fetch(`/administrador/estudiantes/${codigoEstudiantil}/${idUsuario}/edit`)
        .then(response => response.json())
        .then(data => {
          console.log('Datos del estudiante:', data);
          document.getElementById('edit_codigo_estudiantil').value = data.estudiante.codigoEstudiantil;
          document.getElementById('edit_nombre').value = data.usuario.nombre;
          document.getElementById('edit_apellido_paterno').value = data.usuario.apellidoPaterno;
          document.getElementById('edit_apellido_materno').value = data.usuario.apellidoMaterno || '';
          document.getElementById('edit_nivelAcademico').value = data.estudiante.nivelAcademico || '';
          document.getElementById('edit_telefono').value = data.usuario.telefono || '';
          document.getElementById('edit_direccion').value = data.usuario.direccion || '';
          document.getElementById('edit_fecha_nacimiento').value = data.usuario.fechaNacimiento ? data.usuario.fechaNacimiento.split(' ')[0] : '';
          document.getElementById('edit_email').value = data.usuario.email || '';
          document.getElementById('edit_ci').value = data.usuario.ci || '';
          document.getElementById('edit_estado').value = data.usuario.estado;

          // Actualiza la acción del formulario para incluir también el prefijo administrador
          document.getElementById('formEditEstudiante').action = `/administrador/estudiantes/${codigoEstudiantil}`;

          // Muestra el modal
          toggleModal('modalEditEstudiante');
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al cargar los datos del estudiante');
        });
    }

    function confirmarCambioEstado(codigo, estado) {
      const accion = estado == 1 ? 'deshabilitar' : 'habilitar';
      if (confirm(`¿Está seguro que desea ${accion} este estudiante?`)) {
        document.getElementById(`form-estado-${codigo}`).submit();
      }
    }
  </script>
</body>

</html>