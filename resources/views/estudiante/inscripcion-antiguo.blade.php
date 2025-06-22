<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción a Nuevo Curso</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-200 min-h-screen font-sans text-gray-800">
    <!-- Menú lateral -->
    @include('partials.navEstudiante')

    <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilAdmin')

        <div class="container mx-auto py-8 max-w-4xl px-4">
            <!-- Header -->
            <div class="text-center mb-8 fade-in">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-[#127475] rounded-full p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-[#2e1a47] mb-2">Inscripción a Nuevo Curso</h1>
                        <p class="text-lg text-gray-600">Amplía tus conocimientos con nuestros cursos disponibles</p>
                    </div>
                </div>
                
                <!-- Breadcrumb -->
                <nav class="flex justify-center" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#127475]">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Inscripciones
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Nuevo Curso</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Datos del Estudiante -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 fade-in">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Información del Estudiante</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <span class="text-gray-500 w-32 font-medium">Nombre:</span>
                        <span class="font-semibold text-gray-800">{{ $usuario->nombre }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-32 font-medium">Apellidos:</span>
                        <span class="font-semibold text-gray-800">{{ $usuario->apellidoPaterno }} {{ $usuario->apellidoMaterno }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-32 font-medium">CI:</span>
                        <span class="font-semibold text-gray-800">{{ $usuario->ci }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-32 font-medium">Email:</span>
                        <span class="font-semibold text-gray-800">{{ $usuario->email }}</span>
                    </div>
                </div>
            </div>

            <!-- Formulario de Inscripción -->
            <div class="bg-white rounded-xl shadow-lg p-8 fade-in">
                <div class="flex items-center mb-6">
                    <div class="bg-[#127475] rounded-full p-2 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-[#127475]">Seleccionar Curso</h2>
                </div>

                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('inscripciones.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Selector de Curso -->
                    <div>
                        <label for="curso" class="block text-sm font-semibold text-gray-700 mb-3">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#127475]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Seleccione el curso al que desea inscribirse *
                            </span>
                        </label>
                        <select id="curso" name="curso" required onchange="updateCourseInfo()" 
                                class="w-full px-4 py-4 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#127475] focus:border-[#127475] transition duration-200 text-gray-700 bg-white">
                            <option value="">-- Seleccione un curso --</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->ID_Curso }}" 
                                        data-descripcion="{{ $curso->descripcionCurso }}"
                                        data-area="{{ $curso->area ? $curso->area->nombreArea : 'Sin área definida' }}"
                                        {{ old('curso') == $curso->ID_Curso ? 'selected' : '' }}>
                                    {{ $curso->nombreCurso }}
                                </option>
                            @endforeach
                        </select>
                        @error('curso')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Información del Curso Seleccionado -->
                    <div id="courseInfo" class="hidden">
                        <div class="bg-gradient-to-r from-[#127475] to-[#0e5d5e] rounded-xl p-6 text-white">
                            <h3 class="text-lg font-semibold mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Información del Curso
                            </h3>
                            <div class="space-y-2">
                                <div>
                                    <span class="font-medium opacity-90">Área:</span>
                                    <span id="courseArea" class="ml-2"></span>
                                </div>
                                <div>
                                    <span class="font-medium opacity-90">Descripción:</span>
                                    <p id="courseDescription" class="mt-1 opacity-90"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Términos y Condiciones -->
                    <div class="bg-gray-50 rounded-lg p-6 border-l-4 border-[#127475]">
                        <div class="flex items-start">
                            <input type="checkbox" id="terms" name="terms" required 
                                   class="mt-1 h-4 w-4 text-[#127475] focus:ring-[#127475] border-gray-300 rounded">
                            <label for="terms" class="ml-3 text-sm text-gray-700">
                                <span class="font-medium">Términos y Condiciones *</span>
                                <p class="mt-1">
                                    Acepto los términos y condiciones de inscripción. Entiendo que al inscribirme me comprometo a:
                                </p>
                                <ul class="mt-2 ml-4 space-y-1 text-xs list-disc">
                                    <li>Cumplir con los horarios establecidos para el curso</li>
                                    <li>Realizar los pagos correspondientes en las fechas establecidas</li>
                                    <li>Mantener un comportamiento respetuoso durante las clases</li>
                                    <li>Completar las actividades y evaluaciones requeridas</li>
                                </ul>
                            </label>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('estudiante.prinEstudiante') }}" 
                           class="px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 text-center font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver
                        </a>
                        <button type="submit" id="submitBtn" disabled
                                class="px-8 py-3 bg-[#127475] text-white rounded-lg transition duration-200 font-semibold disabled:bg-gray-300 disabled:cursor-not-allowed hover:bg-[#0e5d5e] focus:ring-2 focus:ring-[#127475] focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Confirmar Inscripción
                        </button>
                    </div>
                </form>
            </div>

            <!-- Información Adicional -->
            <div class="mt-8 bg-blue-50 rounded-xl p-6 fade-in">
                <h3 class="text-lg font-semibold text-blue-800 mb-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Información Importante
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-700">
                    <div>
                        <h4 class="font-semibold mb-2">Proceso de Inscripción:</h4>
                        <ul class="space-y-1 list-disc ml-4">
                            <li>Seleccione el curso de su interés</li>
                            <li>Complete el formulario de inscripción</li>
                            <li>Proceda con el pago correspondiente</li>
                            <li>Recibirá confirmación por email</li>
                        </ul>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateCourseInfo() {
            const select = document.getElementById('curso');
            const courseInfo = document.getElementById('courseInfo');
            const courseArea = document.getElementById('courseArea');
            const courseDescription = document.getElementById('courseDescription');
            const submitBtn = document.getElementById('submitBtn');
            const termsCheckbox = document.getElementById('terms');
            
            if (select.value) {
                const selectedOption = select.options[select.selectedIndex];
                const descripcion = selectedOption.getAttribute('data-descripcion');
                const area = selectedOption.getAttribute('data-area');
                
                courseArea.textContent = area;
                courseDescription.textContent = descripcion;
                courseInfo.classList.remove('hidden');
                
                // Añadir animación
                courseInfo.style.opacity = '0';
                courseInfo.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    courseInfo.style.transition = 'all 0.3s ease';
                    courseInfo.style.opacity = '1';
                    courseInfo.style.transform = 'translateY(0)';
                }, 10);
                
                checkFormValidity();
            } else {
                courseInfo.classList.add('hidden');
                submitBtn.disabled = true;
            }
        }
        
        function checkFormValidity() {
            const select = document.getElementById('curso');
            const termsCheckbox = document.getElementById('terms');
            const submitBtn = document.getElementById('submitBtn');
            
            if (select.value && termsCheckbox.checked) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }
        
        // Event listeners
        document.getElementById('terms').addEventListener('change', checkFormValidity);
        
        // Validación en tiempo real
        document.getElementById('curso').addEventListener('change', function() {
            if (this.value) {
                this.classList.remove('border-red-300');
                this.classList.add('border-green-300');
            }
        });
        
        // Efecto de carga
        window.addEventListener('load', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>
</body>

</html>