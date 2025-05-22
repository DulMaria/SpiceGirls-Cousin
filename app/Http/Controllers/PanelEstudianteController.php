<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanelEstudianteController extends Controller
{
    public function dashboard()
    {
        // Obtener ID del usuario autenticado
        $idUsuario = Auth::id();

        // Consulta para obtener datos del usuario
        $usuario = DB::table('usuario')
            ->where('ID_Usuario', $idUsuario)
            ->select('ID_Usuario', 'nombre', 'apellidoPaterno', 'apellidoMaterno', 'telefono', 'email', 'ci')
            ->first();

        // Consulta para obtener datos de estudiante relacionados
        $estudiante = DB::table('estudiante')
            ->where('ID_Usuario', $idUsuario)
            ->select('codigoEstudiantil', 'nivelAcademico', 'genero')
            ->first();

        // Verificar si se encontraron datos
        if (!$usuario) {
            return redirect()->back()->with('error', 'No se encontraron datos del usuario');
        }

        // Pasar datos a la vista
        return view('estudiante.prinEstudiante', [
            'usuario' => $usuario,
            'estudiante' => $estudiante
        ]);
    }

    public function inscripcion()
{
    // Obtener ID del usuario autenticado
    $idUsuario = Auth::id();

    // Consulta para obtener datos del usuario
    $usuario = DB::table('usuario')
        ->where('ID_Usuario', $idUsuario)
        ->select('ID_Usuario', 'nombre', 'apellidoPaterno', 'apellidoMaterno', 'telefono', 'email', 'ci')
        ->first();

    // Consulta para obtener datos de estudiante relacionados
    $estudiante = DB::table('estudiante')
        ->where('ID_Usuario', $idUsuario)
        ->select('codigoEstudiantil', 'nivelAcademico', 'genero')
        ->first();

    // Verificar si se encontraron datos
    if (!$usuario || !$estudiante) {
        return redirect()->back()->with('error', 'No se encontraron datos del estudiante');
    }

    // Cursos a los que está inscrito el estudiante
    $cursosInscritos = DB::table('inscripcion')
        ->where('codigoEstudiantil', $estudiante->codigoEstudiantil)
        ->join('curso', 'inscripcion.ID_Curso', '=', 'curso.ID_Curso')
        ->select('curso.ID_Curso', 'curso.nombreCurso', 'curso.descripcionCurso')
        ->get();

    // Obtener todos los módulos actuales que está cursando el estudiante (activos)
    $modulosActuales = DB::table('historial_academico')
        ->where('codigoEstudiantil', $estudiante->codigoEstudiantil)
        ->where('historial_academico.estado', '1') // Solo módulos activos
        ->join('apertura_modulo', 'historial_academico.ID_Apertura', '=', 'apertura_modulo.ID_Apertura')
        ->join('modulo_curso', 'apertura_modulo.ID_Modulo', '=', 'modulo_curso.ID_Modulo')
        ->join('curso', 'modulo_curso.ID_Curso', '=', 'curso.ID_Curso')
        ->select(
            'modulo_curso.ID_Modulo',
            'modulo_curso.nombreModulo', 
            'modulo_curso.orden',
            'apertura_modulo.fechaInicio', 
            'apertura_modulo.fechaFin',
            'apertura_modulo.CostoModulo',
            'curso.ID_Curso',
            'curso.nombreCurso'
        )
        ->orderBy('curso.ID_Curso')
        ->orderBy('apertura_modulo.fechaInicio', 'desc')
        ->get();

    // Procesar información de cada curso
    $datosCursos = [];
    
    // Agrupar módulos por curso
    $modulosPorCurso = $modulosActuales->groupBy('ID_Curso');
    
    foreach ($cursosInscritos as $curso) {
        $moduloActual = null;
        $porcentajeAvance = 0;
        $siguienteModulo = null;
        $elegibleParaAvanzar = false;
        
        // Obtener el módulo más reciente de este curso
        if ($modulosPorCurso->has($curso->ID_Curso)) {
            $moduloActual = $modulosPorCurso[$curso->ID_Curso]->first();
            
            $fechaInicio = \Carbon\Carbon::parse($moduloActual->fechaInicio);
            $fechaFin = \Carbon\Carbon::parse($moduloActual->fechaFin);
            $fechaActual = \Carbon\Carbon::now();

            // Calcular el porcentaje de avance
            if ($fechaActual >= $fechaFin) {
                $porcentajeAvance = 100; // Completado
                $elegibleParaAvanzar = true;
            } elseif ($fechaActual < $fechaInicio) {
                $porcentajeAvance = 0; // No iniciado
            } else {
                $diferenciaTotal = $fechaFin->diffInDays($fechaInicio);
                $diferenciaActual = $fechaActual->diffInDays($fechaInicio);
                $porcentajeAvance = round(($diferenciaActual / $diferenciaTotal) * 100, 1);
                
                // Considerar elegible si tiene más del 80% de avance
                if ($porcentajeAvance >= 80) {
                    $elegibleParaAvanzar = true;
                }
            }

            // Buscar el siguiente módulo en el mismo curso
            $siguienteModulo = DB::table('modulo_curso')
                ->where('ID_Curso', $moduloActual->ID_Curso)
                ->where('orden', $moduloActual->orden + 1)
                ->where('estado', '1')
                ->select('ID_Modulo', 'nombreModulo', 'descripcionModulo', 'orden')
                ->first();
        }

        // Si hay siguiente módulo, obtener su próxima apertura disponible
        $aperturaDisponible = null;
        if ($siguienteModulo) {
            $aperturaDisponible = DB::table('apertura_modulo')
                ->where('ID_Modulo', $siguienteModulo->ID_Modulo)
                ->where('estado', '1')
                ->where('fechaInicio', '>', now())
                ->orderBy('fechaInicio', 'asc')
                ->select('fechaInicio', 'fechaFin', 'CostoModulo')
                ->first();
        }

        // Preparar datos para este curso
        $datosCursos[] = [
            'curso' => $curso,
            'moduloActual' => $moduloActual ? $moduloActual->nombreModulo : 'No disponible',
            'porcentajeAvance' => $porcentajeAvance,
            'siguienteModulo' => $siguienteModulo ? $siguienteModulo->nombreModulo : 'No disponible',
            'descripcionSiguienteModulo' => $siguienteModulo ? $siguienteModulo->descripcionModulo : '',
            'elegibleParaAvanzar' => $elegibleParaAvanzar,
            'costoSiguienteModulo' => $aperturaDisponible ? $aperturaDisponible->CostoModulo : '0',
            'fechaInicioSiguiente' => $aperturaDisponible
                ? \Carbon\Carbon::parse($aperturaDisponible->fechaInicio)->locale('es')->translatedFormat('j \d\e F \d\e Y')
                : 'Por definir',
            'duracionSiguiente' => $aperturaDisponible
                ? intval(\Carbon\Carbon::parse($aperturaDisponible->fechaInicio)->diffInWeeks(\Carbon\Carbon::parse($aperturaDisponible->fechaFin)))
                : 0,
            'horasSiguiente' => $aperturaDisponible
                ? intval(\Carbon\Carbon::parse($aperturaDisponible->fechaInicio)->diffInWeeks(\Carbon\Carbon::parse($aperturaDisponible->fechaFin))) * 9
                : 0,
            'tieneSiguienteModulo' => $siguienteModulo !== null,
            'tieneAperturaDisponible' => $aperturaDisponible !== null
        ];
    }

    return view('estudiante.inscripcionModulo', compact('usuario', 'estudiante', 'cursosInscritos', 'datosCursos'));
}


    public function cursos()
    {
        return view('estudiante.misCursos');
    }

    public function calendario()
    {
        return view('estudiante.calendario');
    }
}
