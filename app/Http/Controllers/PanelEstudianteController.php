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
    
    // Recuperar todos los cursos con estado 1
    $cursos = \App\Models\Curso::where('estado', 1)->get();

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

    return view('estudiante.inscripcionModulo', compact('usuario', 'estudiante', 'cursosInscritos', 'datosCursos','cursos'));
}

public function cursos()
{
    // Obtener ID del usuario autenticado
    $idUsuario = Auth::id();

    // Consulta para obtener datos de estudiante
    $estudiante = DB::table('estudiante')
        ->where('ID_Usuario', $idUsuario)
        ->select('codigoEstudiantil', 'nivelAcademico', 'genero')
        ->first();

    // Verificar si se encontraron datos del estudiante
    if (!$estudiante) {
        return redirect()->back()->with('error', 'No se encontraron datos del estudiante');
    }

    // Obtener el módulo actual que está cursando el estudiante (activo)
    $moduloActual = DB::table('historial_academico')
        ->where('codigoEstudiantil', $estudiante->codigoEstudiantil)
        ->where('historial_academico.estado', '1') // Solo módulos activos
        ->join('apertura_modulo', 'historial_academico.ID_Apertura', '=', 'apertura_modulo.ID_Apertura')
        ->join('modulo_curso', 'apertura_modulo.ID_Modulo', '=', 'modulo_curso.ID_Modulo')
        ->join('curso', 'modulo_curso.ID_Curso', '=', 'curso.ID_Curso')
        ->select(
            'modulo_curso.ID_Modulo',
            'modulo_curso.nombreModulo',
            'modulo_curso.descripcionModulo',
            'modulo_curso.orden',
            'apertura_modulo.ID_Apertura',
            'apertura_modulo.fechaInicio',
            'apertura_modulo.fechaFin',
            'apertura_modulo.CostoModulo',
            'curso.ID_Curso',
            'curso.nombreCurso',
            'curso.descripcionCurso'
            // Removed 'curso.codigoCurso' as it doesn't exist
        )
        ->orderBy('apertura_modulo.fechaInicio', 'desc')
        ->first();

    if (!$moduloActual) {
        return view('estudiante.misCursos', [
            'error' => 'No tienes ningún módulo activo en este momento'
        ]);
    }

    // Obtener información del docente del módulo actual
    $docente = DB::table('apertura_modulo')
        ->where('apertura_modulo.ID_Apertura', $moduloActual->ID_Apertura)
        ->join('docente', 'apertura_modulo.codigoDocente', '=', 'docente.codigoDocente')
        ->join('usuario', 'docente.ID_Usuario', '=', 'usuario.ID_Usuario')
        ->select(
            'usuario.nombre',
            'usuario.apellidoPaterno',
            'usuario.apellidoMaterno',
            'usuario.email',
            'docente.especialidad'
        )
        ->first();

    // Obtener el aula asignada al módulo
    $aula = DB::table('apertura_modulo')
        ->where('apertura_modulo.ID_Apertura', $moduloActual->ID_Apertura)
        ->join('modulo_curso', 'apertura_modulo.ID_Modulo', '=', 'modulo_curso.ID_Modulo')
        ->join('curso', 'modulo_curso.ID_Curso', '=', 'curso.ID_Curso')
        ->join('area', 'curso.ID_Area', '=', 'area.ID_Area')
        ->select(
            'area.nombreArea',
            'area.descripcionArea'
        )
        ->first();

    // Calcular el progreso del módulo
    $fechaInicio = \Carbon\Carbon::parse($moduloActual->fechaInicio);
    $fechaFin = \Carbon\Carbon::parse($moduloActual->fechaFin);
    $fechaActual = \Carbon\Carbon::now();

    $porcentajeProgreso = 0;
    $estadoModulo = 'No iniciado';

    if ($fechaActual >= $fechaFin) {
        $porcentajeProgreso = 100;
        $estadoModulo = 'Completado';
    } elseif ($fechaActual < $fechaInicio) {
        $porcentajeProgreso = 0;
        $estadoModulo = 'No iniciado';
    } else {
        $diferenciaTotal = $fechaFin->diffInDays($fechaInicio);
        $diferenciaActual = $fechaActual->diffInDays($fechaInicio);
        $porcentajeProgreso = $diferenciaTotal > 0 ? round(($diferenciaActual / $diferenciaTotal) * 100, 0) : 0;
        $estadoModulo = 'En progreso';
    }

    // Obtener el horario del módulo (días de la semana)
    $horario = DB::table('apertura_modulo')
        ->where('ID_Apertura', $moduloActual->ID_Apertura)
        ->select('fechaInicio', 'fechaFin')
        ->first();

    // Simular horario (puedes ajustar según tu estructura de BD)
    $diasSemana = ['Lunes', 'Miércoles']; // Esto debería venir de tu BD
    $horaInicio = '18:00';
    $horaFin = '20:00';

    // Obtener contenido del módulo (todos los módulos del mismo curso)
    $contenidoModulo = DB::table('modulo_curso')
        ->where('modulo_curso.ID_Curso', $moduloActual->ID_Curso) // Usar ID_Curso en lugar de ID_Modulo
        ->where('modulo_curso.estado', '1') // Solo módulos activos
        ->select(
            'modulo_curso.ID_Modulo',
            'modulo_curso.nombreModulo as tema',
            'modulo_curso.descripcionModulo',
            'modulo_curso.orden'
        )
        ->orderBy('modulo_curso.orden', 'asc')
        ->get();

    // Mapear el contenido al formato esperado por la vista
    $contenidoModulo = $contenidoModulo->map(function($item) use ($moduloActual) {
        // Verificar si este módulo es el actual (completado) o posterior (no completado)
        $completado = $item->orden <= $moduloActual->orden;
        
        return [
            'tema' => $item->tema,
            'descripcion' => $item->descripcionModulo,
            'completado' => $completado
        ];
    })->toArray();

    // Obtener próximas clases (simulado - ajustar según tu estructura)
    $proximasClases = [
        [
            'fecha' => 'Lunes, 15 Mayo',
            'tema' => 'Clases de introducción ',
            'hora' => '18:00 - 20:00'
        ],
        [
            'fecha' => 'Miércoles, 17 Mayo',
            'tema' => 'Práctica guiada',
            'hora' => '18:00 - 20:00'
        ],
        [
            'fecha' => 'Lunes, 22 Mayo',
            'tema' => 'Revisión de conceptos',
            'hora' => '18:00 - 20:00'
        ]
    ];

    // Generate a course code based on available data or use a default pattern
    $codigoCurso = 'CURSO-' . str_pad($moduloActual->ID_Curso, 4, '0', STR_PAD_LEFT);

    // Preparar datos para la vista
    $datosCurso = [
        'curso' => [
            'nombre' => $moduloActual->nombreCurso,
            'codigo' => $codigoCurso, // Use generated code instead of non-existent column
            'descripcion' => $moduloActual->descripcionCurso
        ],
        'modulo' => [
            'nombre' => $moduloActual->nombreModulo,
            'descripcion' => $moduloActual->descripcionModulo,
            'orden' => $moduloActual->orden,
            'fechaInicio' => $fechaInicio->locale('es')->translatedFormat('j \d\e F \d\e Y'),
            'fechaFin' => $fechaFin->locale('es')->translatedFormat('j \d\e F \d\e Y')
        ],
        'docente' => [
            'nombre' => $docente ? $docente->nombre . ' ' . $docente->apellidoPaterno . ' ' . $docente->apellidoMaterno : 'No asignado',
            'especialidad' => $docente ? $docente->especialidad : 'Especialista en React',
            'email' => $docente ? $docente->email : ''
        ],
        'aula' => [
            'nombre' => $aula ? $aula->nombreArea : 'Aula Virtual 3',
            'plataforma' => 'Zoom (Enlace en Classroom)',
            'descripcion' => $aula ? $aula->descripcionArea : ''
        ],
        'horario' => [
            'dias' => implode(' y ', $diasSemana),
            'hora' => $horaInicio . ' - ' . $horaFin . ' hrs'
        ],
        'progreso' => [
            'porcentaje' => $porcentajeProgreso,
            'estado' => $estadoModulo
        ],
        'contenido' => $contenidoModulo,
        'proximasClases' => $proximasClases,
        'comunidad' => [
            'whatsapp' => true,
            'nombre' => 'Grupo de WhatsApp',
            'descripcion' => 'Comunidad del curso'
        ],
        'contacto' => [
            'disponible' => true,
            'texto' => 'Contactar docente',
            'email' => $docente ? $docente->email : ''
        ]
    ];

    return view('estudiante.misCursos', compact('datosCurso'));
}
    public function calendario()
    {
        return view('estudiante.calendario');
    }
}
