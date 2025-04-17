<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Estudiantes - Administración</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
      /* Reemplaza el estilo actual de los modales con esto */
      #modalAddEstudiante, #modalEditEstudiante, #detailsModal {
          max-height: 90vh; /* altura máxima del 90% de la ventana */
          overflow-y: visible; /* permite scroll vertical */
          max-width: 95%; /* ancho máximo del 95% de la ventana */
          margin: 0 auto; /* centra el modal */
      }
      .modal-container {
          padding: 20px;
          max-height: calc(90vh - 40px); /* altura máxima menos padding */
          overflow-y: auto;
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
        <button onclick="toggleModal('modalAddEstudiante')" class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg shadow">
          + Añadir Estudiante
        </button>
      </div>

      <!-- Tabla de Estudiantes -->
      <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full min-w-[1000px] text-sm text-left">

          <thead class="bg-[#1f1b2e] text-white">
            <tr>
              <th class="px-6 py-3">#</th>
              <th class="px-6 py-3">Código</th>
              <th class="px-6 py-3">Nombre</th>
              <th class="px-6 py-3">Nivel Academico</th>
              <th class="px-6 py-3">Información</th>
              <!--
              <th class="px-6 py-3">Telefono</th>
              <th class="px-6 py-3">Direccion</th>
              <th class="px-6 py-3">fecha Nacimiento</th>
              <th class="px-6 py-3">Email</th>
              <th class="px-6 py-3">CI</th>
-->
              <th class="px-6 py-3">Estado</th>
              <th class="px-6 py-3 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($estudiantes as $index => $estudiante)
            <tr class="border-b hover:bg-gray-100">
              <td class="px-6 py-4">{{ $index + 1 }}</td>
              <td class="px-6 py-4">{{ $estudiante->codigoEstudiantil }}</td>
              <td class="px-6 py-4">
                {{ $estudiante->usuario->nombre }}
                {{ $estudiante->usuario->apellidoPaterno }}
                {{ $estudiante->usuario->apellidoMaterno }}
              </td>
              <td class="px-6 py-4">{{ $estudiante->nivelAcademico }}</td>
              <td class="px-6 py-4">
                <button class="bg-indigo-500 hover:bg-indigo-700 text-white px-3 py-1 rounded"
                  type="button"
                  @click="showModal = true" onclick="openDetailsModal(
                  '{{ $estudiante->usuario->telefono }}',
                  '{{ $estudiante->usuario->direccion }}',
                  '{{ $estudiante->usuario->fechaNacimiento }}',
                  '{{ $estudiante->usuario->email }}',
                  '{{ $estudiante->usuario->ci }}'
                )" class="text-blue-600 hover:text-blue-900 mr-2">
                  Ver más
                </button>
              </td>
              <!--
              <td class="px-6 py-4">
                {{ $estudiante->usuario->telefono }}
              </td>
              <td class="px-6 py-4">
                {{ $estudiante->usuario->direccion }}
              </td>
              <td class="px-6 py-4">
                {{ $estudiante->usuario->fechaNacimiento }}
              </td>
              <td class="px-6 py-4">
                {{ $estudiante->usuario->email }}
              </td>
              <td class="px-6 py-4">
                {{ $estudiante->usuario->ci }}
              </td>
-->
              <td class="px-6 py-4">
                {{ $estudiante->usuario->estado == 1 ? 'Activo' : 'Inactivo'}}
              </td>
              <td class="px-6 py-4 text-center">
                <button onclick="openEditModal('{{ $estudiante->codigoEstudiantil }}', '{{ $estudiante->ID_Usuario }}')" class="editar-curso bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6" stroke="currentColor">
                    <path opacity="0.5" d="M1 12C1 6.81455 1 4.22183 2.61091 2.61091C4.22183 1 6.81455 1 12 1C17.1854 1 19.7782 1 21.3891 2.61091C23 4.22183 23 6.81455 23 12C23 17.1854 23 19.7782 21.3891 21.3891C19.7782 23 17.1854 23 12 23C6.81455 23 4.22183 23 2.61091 21.3891C1 19.7782 1 17.1854 1 12Z" fill="#1c4a25"></path>
                    <path d="M13.9261 14.3018C14.1711 14.1107 14.3933 13.8885 14.8377 13.4441L20.378 7.90374C20.512 7.7698 20.4507 7.53909 20.2717 7.477C19.6178 7.25011 18.767 6.82414 17.9713 6.02835C17.1755 5.23257 16.7495 4.38186 16.5226 3.72788C16.4605 3.54892 16.2298 3.48761 16.0959 3.62156L10.5555 9.16192C10.1111 9.60634 9.88888 9.82854 9.69778 10.0736C9.47235 10.3626 9.27908 10.6753 9.12139 11.0062C8.98771 11.2867 8.88834 11.5848 8.68959 12.181L8.43278 12.9515L8.02443 14.1765L7.64153 15.3252C7.54373 15.6186 7.6201 15.9421 7.8388 16.1608C8.0575 16.3795 8.38099 16.4559 8.67441 16.3581L9.82308 15.9752L11.0481 15.5668L11.8186 15.31L11.8186 15.31C12.4148 15.1113 12.7129 15.0119 12.9934 14.8782C13.3243 14.7205 13.637 14.5273 13.9261 14.3018Z" fill="#1c4a25"></path>
                    <path d="M22.1127 6.16905C23.2952 4.98656 23.2952 3.06936 22.1127 1.88687C20.9302 0.704377 19.013 0.704377 17.8306 1.88687L17.6524 2.06499C17.4806 2.23687 17.4027 2.47695 17.4456 2.7162C17.4726 2.8667 17.5227 3.08674 17.6138 3.3493C17.796 3.87439 18.14 4.56368 18.788 5.21165C19.4359 5.85961 20.1252 6.20364 20.6503 6.38581C20.9129 6.4769 21.1329 6.52697 21.2834 6.55399C21.5227 6.59693 21.7627 6.51905 21.9346 6.34717L22.1127 6.16905Z" fill="#1c4a25"></path>
                  </svg>
                </button>

                @if($estudiante->usuario->estado == 1)
                <form method="POST" action="{{ route('estudiantes.cambiarEstado', $estudiante->codigoEstudiantil) }}" class="inline-block">
                  @csrf
                  <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded flex items-center gap-2" onclick="return confirm('¿Está seguro que desea deshabilitar este estudiante?')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-5 h-5" stroke="currentColor"
                      viewBox="0 0 24 24" stroke-width="2">
                      <path d="M6 6l12 12M6 18L18 6" stroke="#fff"></path>
                    </svg>
                    Deshabilitar
                  </button>
                </form>
                @else
                <form method="POST" action="{{ route('estudiantes.cambiarEstado', $estudiante->codigoEstudiantil) }}" class="inline-block">
                  @csrf
                  <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded flex items-center gap-2" onclick="return confirm('¿Está seguro que desea habilitar este estudiante?')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-5 h-5" stroke="currentColor"
                      viewBox="0 0 24 24" stroke-width="2">
                      <path d="M12 2L2 7l10 5 10-5-10-5z" stroke="#fff"></path>
                      <path d="M12 2v10l10 5v-10l-10-5z" stroke="#fff"></path>
                    </svg>
                    Habilitar
                  </button>
                </form>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-4 text-gray-500">No hay estudiantes registrados.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
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



  <!-- Scripts opcionales -->
  <script>
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

      // Validar campos de texto (nombre y apellidos)
      const camposTexto = form.querySelectorAll('[name="nombre"], [name="apellidoPaterno"], [name="apellidoMaterno"]');
      camposTexto.forEach(input => {
        if (!validarTexto(input)) formValido = false;
      });

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
      document.querySelectorAll('input[name="nombre"], input[name="apellidoPaterno"], input[name="apellidoMaterno"]')
        .forEach(input => input.setAttribute('maxlength', '30'));

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

      // Validar campos de texto (nombre, apellidos) en tiempo real
      const camposTexto = document.querySelectorAll('input[name="nombre"], input[name="apellidoPaterno"], input[name="apellidoMaterno"]');
      camposTexto.forEach(input => {
        input.setAttribute('required', 'required');
        input.addEventListener('input', () => validarTexto(input));
        input.addEventListener('blur', () => validarTexto(input));
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