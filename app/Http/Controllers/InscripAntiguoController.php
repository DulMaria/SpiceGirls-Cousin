<?php

namespace App\Http\Controllers;
use App\Models\Estudiante;
use App\Models\Inscripcion;
use App\Models\Usuario;
use App\Models\Curso;
use App\Models\Historial_Academico;
use App\Models\AperturaModulo;
use App\Models\ModuloCurso;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class InscripAntiguoController extends Controller
{
    //mostrar formulario de inscripción
    public function index()
    {
        //recuperar el id del estudiante
        $idUsuario = Auth::id();
        //recuperar el estudiante
        $estudiante = Estudiante::where('ID_Usuario', $idUsuario)->first();
        if (!$estudiante) {
            return redirect()->back()->with('error', 'No se encontró el estudiante asociado al usuario.');
        }
        //recuperar el usuario
        $usuario = Usuario::where('ID_Usuario', $idUsuario)->first();
        if (!$usuario) {
            return redirect()->back()->with('error', 'No se encontró el usuario asociado al estudiante.');
        }
        // Recuperar todos los cursos con estado 1
        $cursos = \App\Models\Curso::where('estado', 1)->get();
        return view('estudiante.inscripcion-antiguo', compact('cursos','usuario', 'estudiante', 'idUsuario'));
    }
    public function formulario($id)
    {
        //recuperar el id del estudiante
        $idUsuario = Auth::id();
        // Recuperar todos los cursos con estado 1
        $cursos = \App\Models\Curso::where('estado', 1)->get();
        return view('pag_visitante.formInscripcion', compact('cursos','idUsuario'));
    }

    // obtener cursos disponibles con estado 1
    public function cursosDisponibles()
    {
        try {
            $idUsuario = Auth::id();
            $estudiante = Estudiante::where('ID_Usuario', $idUsuario)->first();
            
            if (!$estudiante) {
                return response()->json(['error' => 'No se encontró el estudiante asociado al usuario.'], 404);
            }
            
            // Recuperar todos los cursos
            $cursos = Curso::where('estado', 1)->get();
            
            
            // CORREGIDO: Retornar los cursos formateados en lugar de $cursos
            return response()->json($cursos->map(function ($curso) {
                return [
                    'ID_Curso' => $curso->ID_Curso,
                    'nombreCurso' => $curso->nombreCurso,
                    'descripcionCurso' => $curso->descripcionCurso,
                    'imagen' => $curso->imagen,
                    'estado' => $curso->estado,
                    'area' => $curso->area ? $curso->area->nombreArea : null, // Asegurarse de que el área exista
                ];
            }));
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los cursos disponibles: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validar los datos de entrada
            $request->validate([
                'curso' => 'required|exists:curso,ID_Curso'
            ]);

            //recuperar el id del estudiante
            $idUsuario = Auth::id();
            
            //recuperamos el código del estudiante
            $estudiante = Estudiante::where('ID_Usuario', $idUsuario)->first();
            if (!$estudiante) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'No se encontró el estudiante asociado al usuario.'], 404);
                }
                return redirect()->back()->with('error', 'No se encontró el estudiante asociado al usuario.');
            }
            
            $codigoEstudiantil = $estudiante->codigoEstudiantil;
            
            // Verificar si el estudiante ya está inscrito en este curso
            $yaInscrito = Inscripcion::where('ID_Curso', $request->curso)
                ->where('codigoEstudiantil', $codigoEstudiantil)
                ->exists();
                
            if ($yaInscrito) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Ya estás inscrito en este curso.'], 400);
                }
                return redirect()->back()->with('error', 'Ya estás inscrito en este curso.');
            }

            // Verificar que el curso esté activo
            $curso = Curso::where('ID_Curso', $request->curso)
                ->where('estado', 1)
                ->first();
                
            if (!$curso) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'El curso seleccionado no está disponible.'], 400);
                }
                return redirect()->back()->with('error', 'El curso seleccionado no está disponible.');
            }

            // Obtener el primer módulo del curso
            $modulo = ModuloCurso::where('ID_Curso', $request->curso)
                ->where('orden', 1) // Solo módulos iniciales
                ->first();

            if (!$modulo) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'No se encontró el módulo inicial para este curso.'], 400);
                }
                return redirect()->back()->with('error', 'No se encontró el módulo inicial para este curso.');
            }

            // Obtener la apertura del módulo
            $apertura = AperturaModulo::where('ID_Modulo', $modulo->ID_Modulo)
                ->where('estado', 1) // Solo aperturas activas
                ->first();
                
            if (!$apertura) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'No se encontró una apertura activa para el curso seleccionado.'], 400);
                }
                return redirect()->back()->with('error', 'No se encontró una apertura activa para el curso seleccionado.');
            }

            // Iniciar transacción para asegurar consistencia
            DB::beginTransaction();

            try {
                // Crear inscripción
                $inscripcion = new Inscripcion();
                $inscripcion->ID_Curso = $request->curso; // ID del curso al que se inscribe
                $inscripcion->codigoEstudiantil = $codigoEstudiantil; // Código del estudiante
                $inscripcion->fechaInscrip = now(); // Fecha de inscripción
                $inscripcion->save();

                // Crear historial académico
                $historialAcademico = new Historial_Academico();
                $historialAcademico->ID_Apertura = $apertura->ID_Apertura; // ID de la apertura del curso
                $historialAcademico->codigoEstudiantil = $codigoEstudiantil; // Código del estudiante
                $historialAcademico->estado = 0; // Estado de inscripción (0 = inscrito, pendiente de completar)
                $historialAcademico->fechaRegistro = now(); // Fecha de registro
                $historialAcademico->save();

                // Confirmar transacción
                DB::commit();

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Inscripción realizada exitosamente.',
                        'data' => [
                            'curso' => $curso->nombreCurso,
                            'fecha_inscripcion' => $inscripcion->fechaInscrip->format('d/m/Y')
                        ]
                    ]);
                }

                return redirect()->back()->with('success', 'Inscripción realizada exitosamente.');

            } catch (\Exception $e) {
                // Revertir transacción en caso de error
                DB::rollback();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Datos inválidos proporcionados.'], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Error al procesar la inscripción: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Error al procesar la inscripción: ' . $e->getMessage());
        }
    }
}