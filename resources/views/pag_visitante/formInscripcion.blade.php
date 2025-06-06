
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inscripción de Estudiante</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 text-gray-800">
  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl">
      <h2 class="text-3xl font-bold mb-6 text-[#2e1a47] text-center">Inscripción de Estudiante</h2>
      
      <!-- Mensaje de error para email duplicado -->
      @if(session('email_error'))
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
        <div class="flex items-center">
          <i class="bi bi-exclamation-triangle-fill mr-2"></i>
          <div>
            <strong class="font-bold">¡Atención!</strong>
            <span class="block sm:inline">{{ session('email_error') }}</span>
          </div>
        </div>
      </div>
      @endif

      <!-- Mensajes de error generales -->
      @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
        <div class="flex items-center mb-2">
          <i class="bi bi-exclamation-triangle-fill mr-2"></i>
          <strong class="font-bold">Error en el formulario:</strong>
        </div>
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      
      <form id="formInscripcion" method="POST" action="/inscripcion/Estudiante" class="space-y-6">
        @csrf 
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          
          <!-- Nombre -->
          <div>
            <label class="block text-gray-700 font-medium mb-2">Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#127475] @error('nombre') border-red-500 @enderror" required>
            @error('nombre')
            <span class="error-message text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          
          <!-- Apellido Paterno -->
          <div>
            <label class="block text-gray-700 font-medium mb-2">Apellido Paterno:</label>
            <input type="text" name="apellidoPaterno" value="{{ old('apellidoPaterno') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#127475] @error('apellidoPaterno') border-red-500 @enderror">
            @error('apellidoPaterno')
            <span class="error-message text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          
          <!-- Apellido Materno -->
          <div>
            <label class="block text-gray-700 font-medium mb-2">Apellido Materno:</label>
            <input type="text" name="apellidoMaterno" value="{{ old('apellidoMaterno') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#127475] @error('apellidoMaterno') border-red-500 @enderror">
            @error('apellidoMaterno')
            <span class="error-message text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          
          <!-- Género -->
          <div>
            <label class="block text-gray-700 font-medium mb-2">Género:</label>
            <select name="genero" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#127475] @error('genero') border-red-500 @enderror" required>
              <option value="" disabled {{ old('genero') == '' ? 'selected' : '' }}>Seleccione un género</option>
              <option value="0" {{ old('genero') == '0' ? 'selected' : '' }}>Masculino</option>
              <option value="1" {{ old('genero') == '1' ? 'selected' : '' }}>Femenino</option>
              <option value="2" {{ old('genero') == '2' ? 'selected' : '' }}>Otros</option>
            </select>
            @error('genero')
            <span class="error-message text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          
          <!-- Nivel Académico -->
          <div>
            <label class="block text-gray-700 font-medium mb-2">Nivel Académico:</label>
            <select name="nivelAcademico" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#127475] @error('nivelAcademico') border-red-500 @enderror" required>
              <option value="" disabled {{ old('nivelAcademico') == '' ? 'selected' : '' }}>Seleccione un nivel académico</option>
              <option value="Primaria" {{ old('nivelAcademico') == 'Primaria' ? 'selected' : '' }}>Primaria</option>
              <option value="Secundaria" {{ old('nivelAcademico') == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
              <option value="Bachiller" {{ old('nivelAcademico') == 'Bachiller' ? 'selected' : '' }}>Bachiller</option>
              <option value="Licenciado" {{ old('nivelAcademico') == 'Licenciado' ? 'selected' : '' }}>Licenciado</option>
              <option value="Otros" {{ old('nivelAcademico') == 'Otros' ? 'selected' : '' }}>Otros</option>
            </select>
            @error('nivelAcademico')
            <span class="error-message text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          
          <!-- Teléfono -->
          <div>
            <label class="block text-gray-700 font-medium mb-2">Teléfono:</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#127475] @error('telefono') border-red-500 @enderror" required>
            @error('telefono')
            <span class="error-message text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          
          <!-- Dirección -->
          <div>
            <label class="block text-gray-700 font-medium mb-2">Dirección:</label>
            <input type="text" name="direccion" value="{{ old('direccion') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#127475] @error('direccion') border-red-500 @enderror" required>
            @error('direccion')
            <span class="error-message text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          
          <!-- Fecha de Nacimiento -->
          <div>
            <label class="block text-gray-700 font-medium mb-2">Fecha de Nacimiento:</label>
            <input type="date" name="fechaNacimiento" value="{{ old('fechaNacimiento') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#127475] @error('fechaNacimiento') border-red-500 @enderror" required>
            @error('fechaNacimiento')
            <span class="error-message text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          
          <!-- Email -->
          <div>
            <label class="block text-gray-700 font-medium mb-2">Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#127475] @error('email') border-red-500 @enderror" required>
            <div id="email-loading" class="hidden text-blue-500 text-xs mt-1">
              <i class="bi bi-hourglass-split animate-spin"></i> Verificando email...
            </div>
            <div id="email-duplicate-error" class="hidden text-red-500 text-xs mt-1">
              <i class="bi bi-exclamation-triangle-fill"></i> Este email ya está registrado. Contacte con administración.
            </div>
            @error('email')
            <span class="error-message text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          
          <!-- CI -->
          <div>
            <label class="block text-gray-700 font-medium mb-2">CI:</label>
            <input type="text" name="ci" value="{{ old('ci') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#127475] @error('ci') border-red-500 @enderror" required>
            @error('ci')
            <span class="error-message text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
          </div>
        </div>
        
        <!-- Curso Recuperado para la inscripcion -->
        <div>
          <input type="text" value="{{ $curso->ID_Curso }}" name="curso" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#127475]" hidden>
        </div>

        <!-- Botones de acción -->
        <div class="flex justify-center mt-8 space-x-4">
          <button type="reset" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-300">
            Limpiar
          </button>
          <button type="submit" id="btnSubmit" class="px-6 py-3 bg-[#127475] text-white rounded-lg hover:bg-[#0f5f5e] transition duration-300 flex items-center gap-2">
            <i class="bi bi-person-plus"></i> Inscribirse
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Variable para controlar si el email está siendo verificado
    let verificandoEmail = false;
    let emailDuplicado = false;

    // Función para verificar email en tiempo real
    async function verificarEmailDuplicado(email) {
      if (!email || email.trim() === '') return;
      
      verificandoEmail = true;
      emailDuplicado = false;
      
      const loadingDiv = document.getElementById('email-loading');
      const errorDiv = document.getElementById('email-duplicate-error');
      const submitBtn = document.getElementById('btnSubmit');
      
      // Mostrar loading
      loadingDiv.classList.remove('hidden');
      errorDiv.classList.add('hidden');
      
      try {
        const response = await fetch('/verificar-email', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                           document.querySelector('input[name="_token"]').value
          },
          body: JSON.stringify({ email: email })
        });
        
        const data = await response.json();
        
        if (data.existe) {
          emailDuplicado = true;
          errorDiv.classList.remove('hidden');
          submitBtn.disabled = true;
          submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
          emailDuplicado = false;
          errorDiv.classList.add('hidden');
          submitBtn.disabled = false;
          submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
      } catch (error) {
        console.error('Error verificando email:', error);
      } finally {
        verificandoEmail = false;
        loadingDiv.classList.add('hidden');
      }
    }

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

      // Validar género
      const genero = form.querySelector('[name="genero"]');
      if (genero && !validarSelect(genero)) formValido = false;

      // Validar nivel académico
      const nivelAcademico = form.querySelector('[name="nivelAcademico"]');
      if (nivelAcademico && !validarSelect(nivelAcademico)) formValido = false;

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

      // Validar formulario al enviar
      const formulario = document.getElementById('formInscripcion');
      formulario.addEventListener('submit', validarFormulario);

      // Validar nombres en tiempo real
      const camposNombre = document.querySelectorAll('input[name="nombre"]');
      camposNombre.forEach(input => {
        input.addEventListener('input', () => validarTexto(input));
        input.addEventListener('blur', () => validarTexto(input));
      });
      
      // Validar apellidos en tiempo real
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

      // Validar selects en tiempo real
      const selects = document.querySelectorAll('select[name="genero"], select[name="nivelAcademico"]');
      selects.forEach(select => {
        select.addEventListener('change', () => validarSelect(select));
        select.addEventListener('blur', () => validarSelect(select));
      });

      // Validar teléfono en tiempo real
      const camposTelefono = document.querySelectorAll('input[name="telefono"]');
      camposTelefono.forEach(input => {
        input.addEventListener('input', () => validarTelefono(input));
        input.addEventListener('blur', () => validarTelefono(input));
      });

      // Validar dirección en tiempo real
      const camposDireccion = document.querySelectorAll('input[name="direccion"]');
      camposDireccion.forEach(input => {
        input.addEventListener('input', () => validarDireccion(input));
        input.addEventListener('blur', () => validarDireccion(input));
      });

      // Configurar y validar fecha de nacimiento
      const camposFechaNacimiento = document.querySelectorAll('input[name="fechaNacimiento"]');
      camposFechaNacimiento.forEach(input => {
        // Configurar los límites de fecha (18-70 años)
        configurarLimitesFecha(input);
        input.addEventListener('change', () => validarFechaNacimiento(input));
        input.addEventListener('blur', () => validarFechaNacimiento(input));
      });

      // Validar email en tiempo real
      const camposEmail = document.querySelectorAll('input[name="email"]');
      camposEmail.forEach(input => {
        input.addEventListener('input', () => validarEmail(input));
        input.addEventListener('blur', () => validarEmail(input));
      });

      // Validar CI en tiempo real
      const camposCI = document.querySelectorAll('input[name="ci"]');
      camposCI.forEach(input => {
        input.addEventListener('input', () => validarCI(input));
        input.addEventListener('blur', () => validarCI(input));
      });
    });
  </script>
</body>
</html>