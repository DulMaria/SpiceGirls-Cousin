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
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidoPaterno' => 'nullable|string|max:100',
            'apellidoMaterno' => 'nullable|string|max:100',
            'nivelAcademico' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fechaNacimiento' => 'nullable|date',
            'email' => 'required|email|unique:usuario,email',
            'ci' => 'nullable|string|max:20',
        ]);

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
         

        //recuperar todos los cursos con el mismo tipo de curso que el id del curso
        //$tipoCurso = Curso::find($request->curso)->ID_TipoCurso;
        //recuperar el area del curso
        //$areas = Curso::find($request->curso)->ID_Area;
        //obtener el area del curso
        //$area = \App\Models\Area::find($areas);
        //obtener cursos con el mismo tipo de curso
        //$cursos = Curso::where('ID_TipoCurso', $tipoCurso)->get();
        
        // Obtener el número de cursos desde la base de datos
        $numeroDeCursos = Curso::count();
        // Pasar los datos a la vista
        return view('home', compact('numeroDeCursos'));

        //return view('pag_visitante.curso_asociado',compact('tipoCurso','area'))->with('success', 'Inscripción exitosa.'); // Redirigir a la vista de inicio o donde desees
    }
}
