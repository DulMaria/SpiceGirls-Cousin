<?php

namespace App\Http\Controllers;

use App\Models\AperturaModulo;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\ModuloCurso;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AperturaModuloController extends Controller
{
    public function index()
    {
        $aperturas = AperturaModulo::with(['modulo.curso', 'docente.usuario'])
            ->orderBy('fechaInicio', 'desc')
            ->get();

        $cursos = Curso::where('estado', 1)->get();

        // Cargar TODOS los módulos activos con su curso
        $modulos = ModuloCurso::with('curso')
            ->where('estado', '1')
            ->get();

        $docentes = Docente::with('usuario')->get();

        return view('administrador.cruds.Apertura_Modulo.aperturaModulo', compact('aperturas', 'cursos', 'modulos', 'docentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_Modulo' => 'required|exists:modulo_curso,ID_Modulo',
            'codigoDocente' => 'required|exists:docentes,codigoDocente',
            'CostoModulo' => 'required|numeric|min:0'
        ]);

        // Calcular fechas automáticamente
        $fechaInicio = Carbon::now()->day(8);
        if (Carbon::now()->day > 7) {
            $fechaInicio->addMonth();
        }

        $fechaFin = $fechaInicio->copy()->addMonth()->addDays(15);

        $apertura = AperturaModulo::create([
            'ID_Modulo' => $request->ID_Modulo,
            'codigoDocente' => $request->codigoDocente,
            'fechaInicio' => $fechaInicio->format('Y-m-d'),
            'fechaFin' => $fechaFin->format('Y-m-d'),
            'CostoModulo' => $request->CostoModulo,
            'estado' => 'Activo'
        ]);

        return response()->json([
            'success' => 'Apertura de módulo creada exitosamente',
            'apertura' => $apertura->load(['modulo.curso', 'docente'])
        ]);
    }

    public function show($id)
    {
        $apertura = AperturaModulo::with(['modulo.curso', 'docente.usuario'])
            ->findOrFail($id);
        return response()->json($apertura);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ID_Modulo' => 'required|exists:modulo_curso,ID_Modulo',
            'codigoDocente' => 'required|exists:docentes,codigoDocente',
            'CostoModulo' => 'required|numeric|min:0'
        ]);

        $apertura = AperturaModulo::findOrFail($id);

        // Recalcular fechas si es necesario
        if ($request->has('recalcular_fechas')) {
            $fechaInicio = Carbon::now()->day(8);
            if (Carbon::now()->day > 7) {
                $fechaInicio->addMonth();
            }

            $fechaFin = $fechaInicio->copy()->addMonth()->addDays(15);

            $apertura->update([
                'ID_Modulo' => $request->ID_Modulo,
                'codigoDocente' => $request->codigoDocente,
                'fechaInicio' => $fechaInicio->format('Y-m-d'),
                'fechaFin' => $fechaFin->format('Y-m-d'),
                'CostoModulo' => $request->CostoModulo
            ]);
        } else {
            $apertura->update([
                'ID_Modulo' => $request->ID_Modulo,
                'codigoDocente' => $request->codigoDocente,
                'CostoModulo' => $request->CostoModulo
            ]);
        }

        return response()->json([
            'success' => 'Apertura de módulo actualizada exitosamente',
            'apertura' => $apertura->load(['modulo.curso', 'docente'])
        ]);
    }

    public function toggleStatus($id)
    {
        $apertura = AperturaModulo::findOrFail($id);

        // Cambia el estado (funciona para ambos tipos)
        $apertura->estado = $apertura->estado == 1 ? 0 : 1;
        $apertura->save();

        return response()->json([
            'success' => true,
            'new_status' => $apertura->estado
        ]);
    }

    // En tu controller de AperturaModulos
    public function getModulosPorCurso($cursoId)
    {
        $modulos = ModuloCurso::where('Id_Curso', $cursoId)
            ->select('ID_Modulo', 'nombreModulo')
            ->get();

        return response()->json($modulos);
    }

    public function getAperturas()
    {
        $aperturas = AperturaModulo::with(['modulo.curso', 'docente'])
            ->orderBy('fechaInicio', 'desc')
            ->get()
            ->map(function ($apertura) {
                return [
                    'ID_Apertura' => $apertura->ID_Apertura,
                    'fechaInicio' => $apertura->fechaInicio,
                    'fechaFin' => $apertura->fechaFin,
                    'CostoModulo' => $apertura->CostoModulo,
                    'estado' => $apertura->estado,
                    'codigoDocente' => $apertura->codigoDocente,
                    'ID_Modulo' => $apertura->ID_Modulo,
                    'modulo' => [
                        'ID_Modulo' => $apertura->modulo->ID_Modulo ?? null,
                        'nombreModulo' => $apertura->modulo->nombreModulo ?? null,
                        'ID_Curso' => $apertura->modulo->ID_Curso ?? null,
                        'curso' => [
                            'ID_Curso' => $apertura->modulo->curso->ID_Curso ?? null,
                            'nombreCurso' => $apertura->modulo->curso->nombreCurso ?? null,
                        ]
                    ],
                    'docente' => [
                        'codigoDocente' => $apertura->docente->codigoDocente ?? null,
                        'nombre' => $apertura->docente->nombre ?? null,
                    ]
                ];
            });

        return response()->json($aperturas);
    }

    public function getCursos()
    {
        $cursos = Curso::where('estado', 'Activo')
            ->select('ID_Curso', 'nombreCurso')
            ->get();

        return response()->json($cursos);
    }

    public function getDocentes()
    {
        $docentes = Docente::where('estado', 'Activo')
            ->select('codigoDocente', 'nombre')
            ->get();

        return response()->json($docentes);
    }
}
