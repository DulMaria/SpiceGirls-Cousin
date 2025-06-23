<?php

namespace App\Http\Controllers;

use App\Models\AperturaModulo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DocenteCursoController extends Controller
{
    public function index(Request $request)
    {
        return $this->misCursos($request);
    }

    public function misCursos(Request $request, $cursoId = null)
    {
        $codigoDocente = Auth::user()->docente->codigoDocente ?? null;

        if (!$codigoDocente) {
            return redirect()->route('login')->with('error', 'No se encontró información del docente');
        }

        // Obtener todas las aperturas de módulos del docente
        $aperturas = AperturaModulo::with(['modulo.curso', 'docente'])
            ->where('codigoDocente', $codigoDocente)
            ->whereIn('estado', ['Activo', 1])
            ->orderBy('fechaInicio', 'desc')
            ->get();

        // Calcular inscripciones por apertura (incluyendo repetidos)
        $inscripcionesPorApertura = $this->contarInscripcionesPorApertura($aperturas);

        // Agrupar por curso
        $cursosPorDocente = $aperturas->groupBy('modulo.curso.ID_Curso')
            ->filter(function ($aperturasDelCurso) {
                return $aperturasDelCurso->first()->modulo && $aperturasDelCurso->first()->modulo->curso;
            })
            ->map(function ($aperturasDelCurso) use ($inscripcionesPorApertura) {
                $primerApertura = $aperturasDelCurso->first();
                $curso = $primerApertura->modulo->curso;

                // Calcular inscripciones para este curso (incluyendo repetidos)
                $inscripcionesCurso = 0;
                $inscripcionesPorModulo = [];

                foreach ($aperturasDelCurso as $apertura) {
                    $inscripciones = $inscripcionesPorApertura[$apertura->ID_Apertura] ?? 0;
                    $inscripcionesCurso += $inscripciones;

                    $inscripcionesPorModulo[] = [
                        'ID_Apertura' => $apertura->ID_Apertura,
                        'nombre_modulo' => $apertura->modulo->nombreModulo ?? 'Módulo sin nombre',
                        'total_inscripciones' => $inscripciones
                    ];
                }

                return [
                    'curso' => $curso,
                    'ID_Curso' => $curso->ID_Curso,
                    'codigo_curso' => $curso->codigoCurso ?? $curso->ID_Curso,
                    'nombre_curso' => $curso->nombreCurso,
                    'total_modulos' => $aperturasDelCurso->count(),
                    'total_inscripciones' => $inscripcionesCurso, // Incluye repetidos
                    'inscripciones_por_modulo' => $inscripcionesPorModulo,
                    'progreso' => $this->calcularProgreso($aperturasDelCurso),
                    'fecha_inicio' => $aperturasDelCurso->min('fechaInicio'),
                    'fecha_fin' => $aperturasDelCurso->max('fechaFin'),
                    'horarios' => $this->obtenerHorarios($aperturasDelCurso) ?? 'Horario no definido',
                    'aulas' => $this->obtenerAulas($aperturasDelCurso) ?? 'Aula no asignada'
                ];
            });

        // Estadísticas generales (sumando todas las inscripciones)
        $estadisticas = [
            'total_cursos' => $cursosPorDocente->count(),
            'total_modulos' => $aperturas->count(),
            'total_inscripciones' => $cursosPorDocente->sum('total_inscripciones'), // Suma con duplicados
            'total_estudiantes_unicos' => $this->contarEstudiantesUnicos($aperturas), // Opcional: estudiantes únicos
            'cursos_activos' => $cursosPorDocente->filter(function ($curso) {
                return $this->determinarEstadoCurso($curso) === 'Activo';
            })->count()
        ];

        $seccionActiva = $cursoId ? $request->segment(3) : 'general';
        $cursoEspecifico = $cursoId ? $cursosPorDocente->firstWhere('ID_Curso', $cursoId) : null;

        return view('docente.misCursos', compact('cursosPorDocente', 'estadisticas', 'seccionActiva', 'cursoEspecifico'));
    }

    /**
     * Cuenta todas las inscripciones activas por apertura (incluye estudiantes repetidos)
     */
    private function contarInscripcionesPorApertura($aperturas)
    {
        if ($aperturas->isEmpty()) return collect();

        return DB::table('historial_academico')
            ->whereIn('ID_Apertura', $aperturas->pluck('ID_Apertura'))
            ->where('estado', 1)
            ->select('ID_Apertura', DB::raw('COUNT(*) as total'))
            ->groupBy('ID_Apertura')
            ->get()
            ->pluck('total', 'ID_Apertura');
    }

    /**
     * Opcional: Cuenta estudiantes únicos (sin repetir)
     */
    private function contarEstudiantesUnicos($aperturas)
    {
        return DB::table('historial_academico')
            ->whereIn('ID_Apertura', $aperturas->pluck('ID_Apertura'))
            ->where('estado', 1)
            ->distinct('codigoEstudiantil')
            ->count('codigoEstudiantil');
    }

    private function calcularProgreso($aperturas)
    {
        $progresoTotal = 0;
        foreach ($aperturas as $apertura) {
            $inicio = Carbon::parse($apertura->fechaInicio);
            $fin = Carbon::parse($apertura->fechaFin);
            $ahora = now();

            $progreso = match (true) {
                $ahora < $inicio => 0,
                $ahora > $fin => 100,
                default => ($inicio->diffInDays($ahora) / max(1, $inicio->diffInDays($fin)) * 100)
            };

            $progresoTotal += $progreso;
        }

        return $aperturas->count() > 0 ? round($progresoTotal / $aperturas->count(), 1) : 0;
    }

    private function determinarEstadoCurso($curso)
    {
        $ahora = now();
        $fechaInicio = Carbon::parse($curso['fecha_inicio']);
        $fechaFin = Carbon::parse($curso['fecha_fin']);

        return match (true) {
            $ahora < $fechaInicio => 'Programado',
            $ahora > $fechaFin => 'Finalizado',
            default => 'Activo'
        };
    }

    // Métodos API manteniendo la funcionalidad original
    public function getEstudiantesApertura($aperturaId)
    {
        $estudiantes = DB::table('historial_academico as ha')
            ->join('estudiantes as e', 'ha.codigoEstudiantil', '=', 'e.codigoEstudiantil')
            ->where('ha.ID_Apertura', $aperturaId)
            ->where('ha.estado', 1)
            ->select('e.*', 'ha.fecha_inscripcion')
            ->orderBy('e.apellidos')
            ->get();

        return response()->json([
            'success' => true,
            'estudiantes' => $estudiantes,
            'total' => $estudiantes->count()
        ]);
    }
    private function obtenerHorarios($aperturas)
    {
        if ($aperturas->isEmpty()) {
            return 'Horario no definido';
        }

        $modulo = $aperturas->first()->modulo;
        $horarios = [
            'Lunes y Miércoles 08:00 - 10:00',
            'Lunes y Miércoles 14:00 - 16:00',
            'Martes y Jueves 10:00 - 12:00',
            'Martes y Jueves 16:00 - 18:00',
            'Viernes 08:00 - 12:00',
            'Sábado 08:00 - 12:00'
        ];

        return $horarios[($modulo->ID_Modulo ?? 0) % count($horarios)] ?? 'Horario no definido';
    }
    private function obtenerAulas($aperturas)
    {
        if ($aperturas->isEmpty()) {
            return 'Aula no asignada';
        }

        $modulo = $aperturas->first()->modulo ?? null;

        $aulas = ['A-101', 'A-105', 'B-204', 'B-210', 'C-302', 'C-308', 'D-105', 'LAB-01', 'LAB-02'];

        return $aulas[($modulo->ID_Modulo ?? 0) % count($aulas)] ?? 'Aula no asignada';
    }
}
