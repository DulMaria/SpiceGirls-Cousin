<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Docentes - Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <!-- Menú lateral -->
    @include('partials.navAdmi')

    <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilAdmin')

        <div class="p-8 w-full">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-[#2e1a47]">Gestión de Docentes</h1>
                <button onclick="toggleModal('modalAddDocente')" class="bg-[#127475] hover:bg-[#0f5f5e] text-white px-4 py-2 rounded-lg shadow">
                    + Añadir Docente
                </button>
            </div>

            <!-- Tabla de Docentes -->
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="w-full min-w-[1000px] text-sm text-left">

                    <thead class="bg-[#1f1b2e] text-white">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Código</th>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Especialidad</th>
                            <th class="px-6 py-3">Telefono</th>
                            <th class="px-6 py-3">Direccion</th>
                            <th class="px-6 py-3">fecha Nacimiento</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">CI</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($docentes as $index => $docente)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $docente->codigoDocente }}</td>
                            <td class="px-6 py-4">
                                {{ $docente->usuario->nombre }}
                                {{ $docente->usuario->apellidoPaterno }}
                                {{ $docente->usuario->apellidoMaterno }}
                            </td>
                            <td class="px-6 py-4">{{ $docente->especialidad }}</td>
                            <td class="px-6 py-4">
                                {{ $docente->usuario->telefono }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $docente->usuario->direccion }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $docente->usuario->fechaNacimiento }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $docente->usuario->email }}  
                            </td>
                            <td class="px-6 py-4">
                                {{ $docente->usuario->ci }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $docente->usuario->estado == 1 ? 'Activo' : 'Inactivo'}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="openEditModal('{{ $docente->codigoDocente }}', '{{ $docente->ID_Usuario }}')" class="text-indigo-600 hover:text-indigo-900">
                                    Editar
                                </button>

                                @if($docente->usuario->estado == 1)
    <form method="POST" action="{{ route('docentes.cambiarEstado', $docente->codigoDocente) }}" class="inline-block">
        @csrf
        <button type="submit" class="text-orange-600 hover:text-orange-900" onclick="return confirm('¿Está seguro que desea deshabilitar este docente?')">
            Deshabilitar
        </button>
    </form>
@else
    <form method="POST" action="{{ route('docentes.cambiarEstado', $docente->codigoDocente) }}" class="inline-block">
        @csrf
        <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('¿Está seguro que desea habilitar este docente?')">
            Habilitar
        </button>
    </form>
@endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No hay docentes registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Añadir Docente -->
    <div id="modalAddDocente" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl">
            <h2 class="text-2xl font-bold mb-6 text-[#2e1a47]">Añadir Docente</h2>
            <form method="POST" action="{{ route('docentes.store') }}">
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
                        <label class="block text-gray-700">Especialidad:</label>
                        <input type="text" name="especialidad" class="w-full border rounded px-3 py-2">
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
                    <button type="button" onclick="toggleModal('modalAddDocente')" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#127475] text-white rounded hover:bg-[#0f5f5e]">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
<!-- Modal Editar Docente -->
<div id="modalEditDocente" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl">
        <h2 class="text-2xl font-bold mb-6 text-[#2e1a47]">Editar Docente</h2>
        <form id="formEditDocente" method="POST" action="">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="hidden" id="edit_codigo_docente" name="codigoDocente">
                
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
                    <label class="block text-gray-700">Especialidad:</label>
                    <input type="text" id="edit_especialidad" name="especialidad" class="w-full border rounded px-3 py-2">
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
                <button type="button" onclick="toggleModal('modalEditDocente')" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-[#127475] text-white rounded hover:bg-[#0f5f5e]">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

    
    <!-- Scripts opcionales -->
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
function validarEspecialidad(input) {
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
    'La especialidad solo debe contener letras (máximo 50 caracteres)'
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
  
  // Validar especialidad
  const especialidad = form.querySelector('[name="especialidad"]');
  if (especialidad && !validarEspecialidad(especialidad)) formValido = false;
  
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
document.querySelectorAll('input[name="especialidad"]')
  .forEach(input => input.setAttribute('maxlength', '50'));
  
  // Validar formularios al enviar
  const formularios = document.querySelectorAll('#modalAddDocente form, #formEditDocente');
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
  
  // Validar especialidad con restricción de solo letras
  const camposEspecialidad = document.querySelectorAll('input[name="especialidad"]');
  camposEspecialidad.forEach(input => {
    input.setAttribute('required', 'required');
    input.addEventListener('input', () => validarEspecialidad(input));
    input.addEventListener('blur', () => validarEspecialidad(input));
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

    function openEditModal(codigoDocente, idUsuario) {
    // Agrega el prefijo "/administrador" para que coincida con tu definición de ruta
    fetch(`/administrador/docentes/${codigoDocente}/${idUsuario}/edit`)
        .then(response => response.json())
        .then(data => {
            console.log('Datos del docente:', data);
            document.getElementById('edit_codigo_docente').value = data.docente.codigoDocente;
            document.getElementById('edit_nombre').value = data.usuario.nombre;
            document.getElementById('edit_apellido_paterno').value = data.usuario.apellidoPaterno;
            document.getElementById('edit_apellido_materno').value = data.usuario.apellidoMaterno || '';
            document.getElementById('edit_especialidad').value = data.docente.especialidad || '';
            document.getElementById('edit_telefono').value = data.usuario.telefono || '';
            document.getElementById('edit_direccion').value = data.usuario.direccion || '';
            document.getElementById('edit_fecha_nacimiento').value = data.usuario.fechaNacimiento ? data.usuario.fechaNacimiento.split(' ')[0] : '';
            document.getElementById('edit_email').value = data.usuario.email || '';
            document.getElementById('edit_ci').value = data.usuario.ci || '';
            document.getElementById('edit_estado').value = data.usuario.estado;
            
            // Actualiza la acción del formulario para incluir también el prefijo administrador
            document.getElementById('formEditDocente').action = `/administrador/docentes/${codigoDocente}`;
            
            // Muestra el modal
            toggleModal('modalEditDocente');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los datos del docente');
        });
}

function confirmarCambioEstado(codigo, estado) {
        const accion = estado == 1 ? 'deshabilitar' : 'habilitar';
        if (confirm(`¿Está seguro que desea ${accion} este docente?`)) {
            document.getElementById(`form-estado-${codigo}`).submit();
        }
    }


</script>
</body>

</html>