<?php

namespace App\Http\Controllers;
use App\Models\Estudiante;
use App\Models\Usuario;
use App\Models\Curso;
use App\Models\Inscripcion;

use App\Models\Historial_Academico;
use App\Models\AperturaModulo;
use App\Models\ModuloCurso;

use Illuminate\Http\Request;

class InscripVisitanteController extends Controller
{
    public function formulario($id)
    {
        // Recuperar el curso por ID y mostrar el formulario de inscripción
        $curso = \App\Models\Curso::findOrFail($id);
        return view('pag_visitante.formInscripcion', compact('curso'));
    }

    // Método para verificar si el email ya existe (AJAX)
    public function verificarEmail(Request $request)
    {
        $email = $request->input('email');
        
        // Verificar si el email ya existe en la base de datos
        $emailExiste = Usuario::where('email', $email)->exists();
        
        return response()->json([
            'existe' => $emailExiste
        ]);
    }

    public function store(Request $request)
    {
        // Validación inicial con reglas personalizadas
        $request->validate([
            'nombre' => 'required|string|max:30|regex:/^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/',
            'apellidoPaterno' => 'nullable|string|max:30|regex:/^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]*$/',
            'apellidoMaterno' => 'nullable|string|max:30|regex:/^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]*$/',
            'genero' => 'required|in:0,1,2',
            'nivelAcademico' => 'required|in:Primaria,Secundaria,Bachiller,Licenciado,Otros',
            'telefono' => 'required|regex:/^\d{8}$/',
            'direccion' => 'required|string|max:150',
            'fechaNacimiento' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d') . '|after_or_equal:' . now()->subYears(70)->format('Y-m-d'),
            'email' => 'required|email|max:50',
            'ci' => 'required|regex:/^\d{6,10}$/',
            'curso' => 'required|exists:curso,ID_Curso'
        ], [
            // Mensajes personalizados
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo debe contener letras.',
            'nombre.max' => 'El nombre no debe exceder los 30 caracteres.',
            'apellidoPaterno.regex' => 'El apellido paterno solo debe contener letras.',
            'apellidoPaterno.max' => 'El apellido paterno no debe exceder los 30 caracteres.',
            'apellidoMaterno.regex' => 'El apellido materno solo debe contener letras.',
            'apellidoMaterno.max' => 'El apellido materno no debe exceder los 30 caracteres.',
            'genero.required' => 'Debe seleccionar un género.',
            'genero.in' => 'El género seleccionado no es válido.',
            'nivelAcademico.required' => 'Debe seleccionar un nivel académico.',
            'nivelAcademico.in' => 'El nivel académico seleccionado no es válido.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono debe contener exactamente 8 dígitos.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no debe exceder los 150 caracteres.',
            'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fechaNacimiento.before_or_equal' => 'Debe ser mayor de 18 años.',
            'fechaNacimiento.after_or_equal' => 'La edad máxima permitida es 70 años.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ingresar un email válido.',
            'email.max' => 'El email no debe exceder los 50 caracteres.',
            'ci.required' => 'El CI es obligatorio.',
            'ci.regex' => 'El CI debe contener entre 6 y 10 dígitos.',
            'curso.required' => 'Debe seleccionar un curso.',
            'curso.exists' => 'El curso seleccionado no es válido.'
        ]);

        // Validación adicional: al menos un apellido debe estar presente
        if (empty($request->apellidoPaterno) && empty($request->apellidoMaterno)) {
            return back()->withErrors([
                'apellidoPaterno' => 'Debe ingresar al menos un apellido (paterno o materno).'
            ])->withInput();
        }

        // Verificar si el email ya existe en la base de datos
        $emailExiste = Usuario::where('email', $request->email)->exists();
        
        if ($emailExiste) {
            return back()->with('email_error', 'El email ingresado ya está registrado en nuestro sistema. Por favor, contacte con administración para más información o utilice un email diferente.')
                        ->withInput();
        }

        try {
            // Crear usuario
            $usuario = new Usuario();
            $usuario->nombre = $request->nombre;
            $usuario->apellidoPaterno = $request->apellidoPaterno;
            $usuario->apellidoMaterno = $request->apellidoMaterno;
            $usuario->email = $request->email;
            $usuario->contrasenia = bcrypt('123456789'); // Aquí puedes mejorar la generación de la contraseña
            $usuario->telefono = $request->telefono;
            $usuario->direccion = $request->direccion;
            $usuario->fechaNacimiento = $request->fechaNacimiento;
            $usuario->ci = $request->ci;
            $usuario->estado = 0; // Puedes asignar un valor por defecto si no lo envían
            $usuario->ID_Rol = 3; // Rol de estudiante
            $usuario->save();

            // Generar automáticamente el código del estudiante
            $nombreInicial = strtoupper(substr($request->nombre, 0, 1));
            
            // Para el código de estudiante, usamos la lógica de duplicar la inicial si solo hay un apellido
            if (!empty($request->apellidoPaterno)) {
                $apellidoPaternoInicial = strtoupper(substr($request->apellidoPaterno, 0, 1));
            } else {
                $apellidoPaternoInicial = '';
            }
            
            if (!empty($request->apellidoMaterno)) {
                $apellidoMaternoInicial = strtoupper(substr($request->apellidoMaterno, 0, 1));
            } else {
                $apellidoMaternoInicial = '';
            }
            
            // Si solo hay un apellido, duplicamos su inicial para el código
            if (empty($apellidoPaternoInicial) && !empty($apellidoMaternoInicial)) {
                $apellidoPaternoInicial = $apellidoMaternoInicial;
            } elseif (!empty($apellidoPaternoInicial) && empty($apellidoMaternoInicial)) {
                $apellidoMaternoInicial = $apellidoPaternoInicial;
            }
            
            $prefijo = $nombreInicial . $apellidoPaternoInicial . $apellidoMaternoInicial;

            // Obtener el último número SIN importar el prefijo
            $ultimoEstudiante = \App\Models\Estudiante::orderByRaw('CAST(SUBSTRING(codigoEstudiantil, 4) AS UNSIGNED) DESC')->first();
            if ($ultimoEstudiante && preg_match('/(\d+)$/', $ultimoEstudiante->codigoEstudiantil, $coincidencias)) {
                $ultimoNumero = (int) $coincidencias[1];
            } else {
                $ultimoNumero = 0;
            }

            $nuevoNumero = str_pad($ultimoNumero + 1, 5, '0', STR_PAD_LEFT); // formato 00001, 00002, etc.

            $codigoEstudiantil = $prefijo . $nuevoNumero;

            // Crear estudiante
            $estudiante = new Estudiante();
            $estudiante->codigoEstudiantil = $codigoEstudiantil;
            $estudiante->nivelAcademico = $request->nivelAcademico;
            $estudiante->ID_Usuario = $usuario->ID_Usuario; // Asignar el ID del usuario creado
            //asignar el genero
            $estudiante->genero = $request->genero;
            $estudiante->save();

            // Crear inscripción
            $inscripcion = new Inscripcion();
            $inscripcion->ID_Curso = $request->curso; // ID del curso al que se inscribe
            $inscripcion->codigoEstudiantil = $codigoEstudiantil; // Código del estudiante
            $inscripcion->fechaInscrip = now(); // Fecha de inscripción
            $inscripcion->save();

            //obtener el modulo
            $modulo = ModuloCurso::where('ID_Curso', $request->curso)
                ->where('orden', 1) // Solo módulos iniciales
                ->first();

            // Obtener la apertura del curso
            $apertura = AperturaModulo::where('ID_Modulo', $modulo->ID_Modulo)
                ->where('estado', 1) // Solo aperturas activas
                ->first();
                
            if (!$apertura) {
                return redirect()->back()->with('error', 'No se encontró una apertura activa para el curso seleccionado.');
            }

            // Crear historial académico
            $historialAcademico = new Historial_Academico();
            $historialAcademico->ID_Apertura = $apertura->ID_Apertura; // ID de la apertura del curso
            $historialAcademico->codigoEstudiantil = $codigoEstudiantil; // Código del estudiante
            $historialAcademico->estado = 0; // Estado de inscripción
            $historialAcademico->fechaRegistro = now(); // Fecha de registro
            $historialAcademico->save();
             
            // Obtener el número de cursos desde la base de datos
            $numeroDeCursos = Curso::count();
            
            // Pasar los datos a la vista con mensaje de éxito
            return view('home', compact('numeroDeCursos'))->with('success', 'Inscripción realizada exitosamente. Su código de estudiante es: ' . $codigoEstudiantil);

        } catch (\Exception $e) {
            // En caso de error, regresar con mensaje de error
            return back()->with('error', 'Ocurrió un error durante la inscripción. Por favor, contacte con administración.')
                        ->withInput();
        }
    }
}