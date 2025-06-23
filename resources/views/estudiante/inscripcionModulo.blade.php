<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción al Curso</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
<!-- Agregar en el <head> de tu HTML -->
<meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
         @keyframes modalopen {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal {
            animation: modalopen 0.3s ease-out;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            body * {
                visibility: hidden;
            }
            #printableReceipt, #printableReceipt * {
                visibility: visible;
            }
            #printableReceipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-200 min-h-screen font-sans text-gray-800">
    <!-- Menú lateral -->
    @include('partials.navEstudiante')

    <div class="flex flex-col md:flex-row min-h-screen w-full">
        @include('partials.headerMovilAdmin')

        <div class="container mx-auto py-8 max-w-6xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-[#2e1a47] mb-2">Inscripción al Siguiente Módulo</h1>
                <p class="text-lg text-gray-600">Complete el formulario para avanzar al siguiente módulo de su curso</p>
            </div>

            <!-- Formulario de datos del estudiante -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-lg font-semibold text-purple-900 mb-4">Datos Personales</h2>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <span class="text-gray-500 w-32">Nombre:</span>
                        <span class="font-medium">{{ $usuario->nombre }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-32">Apellidos:</span>
                        <span class="font-medium">{{ $usuario->apellidoPaterno }}
                            {{ $usuario->apellidoMaterno }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-32">CI:</span>
                        <span class="font-medium">{{ $usuario->ci }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-32">Email:</span>
                        <span class="font-medium">{{ $usuario->email }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 w-32">Teléfono:</span>
                        <span class="font-medium">{{ $usuario->telefono }}</span>
                    </div>
                    
<!--Boton para nuevo curso este envia a la vista de cursos disponibles-->
                    <div class="mt-4">
                        <a href="{{ route('estudiante.inscripcionAntiguo') }}"
                            class="bg-[#127475] text-white px-6 py-2 rounded-lg hover:bg-[#0e5d5e] transition font-semibold">
                            Ver Cursos Disponibles
                        </a>
                    </div>
                </div>
            </div>
<!-- Información de los cursos y módulos -->
            @foreach($datosCursos as $index => $datoCurso)
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-[#127475] border-b border-gray-200 pb-3 mb-4">
                    Curso: {{ $datoCurso['curso']->nombreCurso }}
                </h2>

                <!-- Información del estudiante para este curso -->
                <div class="bg-gray-50 rounded-lg p-5 mb-6 border-l-4 border-[#127475]">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Progreso del Curso</h3>

                    <div class="space-y-2">
                        <div class="flex">
                            <span class="text-gray-600 font-medium w-40">Módulo Actual:</span>
                            <span class="text-gray-800">{{ $datoCurso['moduloActual'] }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-gray-600 font-medium w-40">Avance:</span>
                            <div class="flex items-center">
                                <span class="text-gray-800 mr-2">{{ $datoCurso['porcentajeAvance'] }}% completado</span>
                                <div class="w-24 bg-gray-200 rounded-full h-2">
                                    <div class="bg-[#127475] h-2 rounded-full" style="width: {{ $datoCurso['porcentajeAvance'] }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flex">
                            <span class="text-gray-600 font-medium w-40">Siguiente Módulo:</span>
                            <span class="text-gray-800 font-bold">{{ $datoCurso['siguienteModulo'] }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-gray-600 font-medium w-40">Estado:</span>
                            @if($datoCurso['elegibleParaAvanzar'])
                                <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-bold">Elegible para avanzar</span>
                            @else
                                <span class="bg-yellow-500 text-white px-2 py-1 rounded text-xs font-bold">En progreso</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($datoCurso['tieneSiguienteModulo'])
                <!-- Detalles del módulo -->
                <div class="bg-gray-50 rounded-lg p-5 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Detalles del {{ $datoCurso['siguienteModulo'] }}</h3>
                    <p class="text-gray-600 mb-4">{{ $datoCurso['descripcionSiguienteModulo'] ?: 'Información del módulo próximo a cursar.' }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-[#127475] mb-2">Contenido:</h4>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700">
                                <li>Contenidos avanzados del módulo</li>
                                <li>Ejercicios prácticos</li>
                                <li>Proyectos aplicados</li>
                                <li>Evaluaciones continuas</li>
                            </ul>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <h4 class="font-semibold text-[#127475]">Duración:</h4>
                                <p class="text-gray-700">{{ $datoCurso['duracionSiguiente'] }} semanas ({{ $datoCurso['horasSiguiente'] }} horas)</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#127475]">Costo:</h4>
                                <p class="text-gray-700 font-bold">Bs. {{ $datoCurso['costoSiguienteModulo'] }}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#127475]">Fecha de inicio:</h4>
                                <p class="text-gray-700">{{ $datoCurso['fechaInicioSiguiente'] }}</p>
                            </div>
                        </div>
                    </div>

                    @if($datoCurso['tieneAperturaDisponible'] && $datoCurso['elegibleParaAvanzar'])
                    <!-- Sección del formulario de inscripción corregida -->
<div class="mt-6 text-center">
    <form method="POST" action="{{ route('inscripcion.siguienteModulo') }}" id="inscripcionForm-{{ $datoCurso['curso']->ID_Curso }}">
        @csrf
        <input type="hidden" name="curso_id" value="{{ $datoCurso['curso']->ID_Curso }}">
        <input type="hidden" name="siguiente_modulo" value="{{ $datoCurso['siguienteModulo'] }}">
        <button type="submit" 
                class="bg-[#127475] text-white px-6 py-3 rounded-lg hover:bg-[#0e5d5e] transition font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                id="btnInscripcion-{{ $datoCurso['curso']->ID_Curso }}"
                onclick="return confirmarInscripcion('{{ $datoCurso['siguienteModulo'] }}', {{ $datoCurso['curso']->ID_Curso }})">
            <span class="btn-text">Inscribirse a {{ $datoCurso['siguienteModulo'] }}</span>
            <span class="btn-loading hidden">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Procesando...
            </span>
        </button>
    </form>
</div>

<script>
function confirmarInscripcion(nombreModulo, cursoId) {
    if (confirm('¿Estás seguro de que deseas inscribirte al módulo ' + nombreModulo + '?')) {
        const form = document.getElementById('inscripcionForm-' + cursoId);
        const btn = document.getElementById('btnInscripcion-' + cursoId);
        const btnText = btn.querySelector('.btn-text');
        const btnLoading = btn.querySelector('.btn-loading');
        
        // Cambiar estado del botón
        btn.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');
        
        // Enviar formulario
        form.submit();
        
        return true;
    }
    return false;
}

// Manejo de respuestas de error/éxito
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si hay mensajes de éxito o error
    @if(session('success'))
        showNotification('success', '{{ session('success') }}');
    @endif
    
    @if(session('error'))
        showNotification('error', '{{ session('error') }}');
    @endif
    
    @if($errors->any())
        @foreach($errors->all() as $error)
            showNotification('error', '{{ $error }}');
        @endforeach
    @endif
});

function showNotification(type, message) {
    // Crear notificación
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <div class="flex-shrink-0">
                ${type === 'success' ? 
                    '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>' :
                    '<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>'
                }
            </div>
            <div class="ml-3">
                <p class="font-medium">${message}</p>
            </div>
            <div class="ml-4 flex-shrink-0">
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex text-white hover:text-gray-200 focus:outline-none">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-eliminar después de 5 segundos
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}
</script>
                    @elseif(!$datoCurso['tieneAperturaDisponible'])
                    <div class="mt-6 text-center">
                        <div class="bg-yellow-50 rounded-lg p-4 border-l-4 border-yellow-400">
                            <p class="text-yellow-700 font-medium">Apertura del módulo pendiente de programación</p>
                        </div>
                    </div>
                    @endif
                </div>
                @else
                <!-- Mensaje cuando no hay siguiente módulo -->
                <div class="bg-yellow-50 rounded-lg p-5 mb-6 border-l-4 border-yellow-400">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">Información Importante</h3>
                    <p class="text-yellow-700">Modulo aun no esta disponible, espera indicaciones del Administrador</p>
                </div>
                @endif
            </div>
            @endforeach
                <!-- Métodos de pago -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-[#127475] border-b border-gray-200 pb-3 mb-4">Método de Pago
                        para
                        el Siguiente Módulo</h2>
                    <p class="text-gray-600 mb-6">Seleccione la forma en que desea realizar el pago del siguiente
                        módulo:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pago QR -->
                        <div class="bg-gray-50 rounded-xl p-6 text-center cursor-pointer transition-all hover:shadow-md hover:border-[#127475] hover:border-2"
                            onclick="openModal('qrModal')">
                            <div class="flex justify-center mb-4">
                                <div
                                    class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                    <!--[QR Code]-->
                                    <img src="{{ url('IMG/QR.png') }}" alt="Código QR de Pago" class="max-w-full max-h-full">
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Pago por QR</h3>
                            <p class="text-gray-600 text-sm">Realice su pago mediante transferencia escaneando nuestro
                                código QR</p>
                        </div>

                        <!-- Pago en efectivo -->
                        <div class="bg-gray-50 rounded-xl p-6 text-center cursor-pointer transition-all hover:shadow-md hover:border-[#127475] hover:border-2"
                            onclick="openModal('cashModal')">
                            <div class="flex justify-center mb-4">
                                <div
                                    class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                    [Efectivo]
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Pago en Efectivo</h3>
                            <p class="text-gray-600 text-sm">Imprima su comprobante y acérquese a nuestras oficinas para
                                realizar el pago</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para Pago QR con funcionalidad de zoom -->
<div id="qrModal"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6 modal">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-[#127475]">Pago para Inscripción al Siguiente Módulo</h2>
            <button onclick="closeModal('qrModal')"
                class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>

        <p class="text-gray-600 mb-6">Por favor escanee el siguiente código QR para realizar el pago de su
            inscripción al siguiente módulo:</p>

        <div class="flex justify-center my-6">
            <div class="w-64 h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400" default>
                <!--[Código QR de Pago]-->
                <img src="{{ url('IMG/qr_pago.jpg') }}" alt="Código QR de Pago" class="max-w-full max-h-full cursor-pointer" 
                     onclick="openZoomModal(this.src)">
            </div>
        </div>

        <!-- Modal para mostrar la imagen ampliada -->
        <div id="zoomModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
            <div class="relative max-w-4xl w-full flex flex-col items-center">
                <button onclick="closeModal('zoomModal')" 
                        class="absolute top-0 right-0 bg-white rounded-full p-2 m-4 text-gray-800 hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 22 22" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img id="zoomedImage" src="" alt="Imagen Ampliada" class="max-w-full max-h-[76vh] object-contain">
            </div>
        </div>

        <p class="text-gray-600 mb-6">Una vez realizado el pago, guarde el comprobante y envíelo a <strong
                class="text-[#127475]">pagos@formacioneducativa.com</strong> incluyendo su nombre completo
            y
            documento de identidad.</p>

        <div class="pt-4 border-t border-gray-200 text-center">
            <p class="text-gray-500 text-sm mb-4">¿Tiene problemas para realizar el pago? Contáctenos al
                +123
                456 7890</p>
            <button onclick="closeModal('qrModal')"
                class="bg-[#127475] text-white px-6 py-2 rounded-lg hover:bg-[#0e5d5e] transition">
                Cerrar
            </button>
        </div>
    </div>
</div>


    <!-- Modal para Pago en Efectivo - Versión mejorada -->
    <div id="cashModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-xl w-full max-w-lg p-6 modal overflow-y-auto" style="max-height: 90vh;">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-[#127475]">Comprobante de Inscripción</h2>
                    <p class="text-sm text-gray-500">Centro de Formación Educativa</p>
                </div>
                <button onclick="closeModal('cashModal')" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
            </div>

            <!-- Comprobante imprimible más compacto -->
            <div id="printableReceipt" class="bg-white p-4 border border-gray-200 rounded-lg">
                <div class="grid grid-cols-1 gap-4">
                    <!-- Encabezado -->
                    <div class="text-center border-b border-gray-200 pb-3 mb-3">
                        <h3 class="text-lg font-bold text-[#127475]">COMPROBANTE DE PAGO</h3>
                        <p class="text-xs text-gray-500">N°: INS-2025-<span id="random-num">XXXX</span></p>
                    </div>
                    
                    <!-- Datos del estudiante -->
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <p class="font-semibold text-gray-600">Fecha:</p>
                            <p id="receipt-date" class="text-gray-800">18/05/2025</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-600">Documento:</p>
                            <p id="receipt-document" class="text-gray-800">{{ $usuario->ci }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="font-semibold text-gray-600">Nombre:</p>
                            <p id="receipt-name" class="text-gray-800">{{ $usuario->nombre }} {{ $usuario->apellidoPaterno }} {{ $usuario->apellidoMaterno }}</p>
                        </div>
                    </div>
                    
                    <!-- Detalles del curso -->
                    <div class="border-t border-gray-200 pt-3 mt-2">
                        <h4 class="font-semibold text-[#127475] text-sm mb-2">DETALLES DEL CURSO</h4>
                        <div class="grid grid-cols-1 gap-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Curso:</span>
                                <span class="text-gray-800 font-medium">Desarrollo Web Full Stack</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Módulo Actual:</span>
                                <span class="text-gray-800">Módulo 2: Nivel Intermedio</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Módulo a Inscribir:</span>
                                <span class="text-gray-800 font-semibold">Módulo 3: Nivel Avanzado</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Horario:</span>
                                <span id="receipt-schedule" class="text-gray-800">Lunes y Miércoles 18:00-20:00</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Monto y firma -->
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-semibold text-gray-700">TOTAL A PAGAR:</span>
                            <span id="receipt-amount" class="text-lg font-bold text-[#127475]">$350.000</span>
                        </div>
                        <div class="text-center border-t border-gray-200 pt-3">
                            <p class="text-xs text-gray-500 mb-1">Firma del Responsable</p>
                            <div class="h-12 border-b border-gray-300 w-3/4 mx-auto"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Información adicional -->
                <div class="mt-4 text-center text-xs text-gray-500">
                    <p class="mb-1">Este comprobante debe ser presentado al momento de realizar el pago en efectivo.</p>
                    <p class="mb-1">Dirección: Av. Principal #123, Centro Educativo</p>
                    <p>Teléfono: +123 456 7890</p>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="pt-4 mt-4 border-t border-gray-200 flex flex-col sm:flex-row justify-center gap-2 no-print">
                <button onclick="printReceipt()" class="bg-[#127475] text-white px-4 py-2 rounded-lg hover:bg-[#0e5d5e] transition text-sm flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Imprimir
                </button>
                <button onclick="closeModal('cashModal')" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

     <script>
     //funcion de modal para la imagen de pagos 
            function openZoomModal(imageSrc) {
             // Establecer la imagen ampliada
            document.getElementById('zoomedImage').src = imageSrc;
            // Mostrar el modal de zoom
             document.getElementById('zoomModal').classList.remove('hidden');
            document.getElementById('zoomModal').classList.add('flex');
                // Prevenir el scroll del body
            document.body.style.overflow = 'hidden';
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
                document.getElementById(modalId).classList.remove('flex');
                // Restaurar el scroll del body cuando se cierra el modal de zoom
                if (modalId === 'zoomModal') {
                    document.body.style.overflow = '';
                }
            }
                // Función para abrir modal
                function openModal(modalId) {
                    document.getElementById(modalId).classList.remove('hidden');
                    
                    // Si es el modal de efectivo, generamos datos
                    if(modalId === 'cashModal') {
                        document.getElementById('random-num').textContent = Math.floor(Math.random() * 9000);
                    }
                }

                // Función para cerrar modales
                function closeModal(modalId) {
                    document.getElementById(modalId).classList.add('hidden');
                }

                // Función para imprimir recibo
                function printReceipt() {
                    window.print();
                }

                // Cerrar modal al hacer clic fuera del contenido
                window.addEventListener('click', function(event) {
                    if (event.target.classList.contains('fixed')) {
                        const modals = document.querySelectorAll('.fixed.hidden');
                        modals.forEach(modal => {
                            if(!modal.classList.contains('hidden')) {
                                modal.classList.add('hidden');
                            }
                        });
                    }
                });

            </script>
</body>

</html>