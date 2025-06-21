<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
//log
use Illuminate\Support\Facades\Log;

class TestVocacionalController extends Controller
{
    protected $preguntas;
    
    public function __construct()
    {
        // Cargar preguntas desde la base de datos
        $this->preguntas = DB::table('test_preguntas')
            ->orderBy('orden')
            ->get()
            ->map(function($pregunta) {
                return [
                    'id' => $pregunta->id,
                    'texto' => $pregunta->texto,
                    'opciones' => json_decode($pregunta->opciones),
                    'orden' => $pregunta->orden
                ];
            })
            ->toArray();
    }

    public function mostrarFormulario(Request $request)
    {
        $respuestas = session('respuestas', []);

        // Si ya respondieron todas o llegaron al final del árbol, mostrar resultado
        if (count($respuestas) >= 15 || $this->obtenerSiguientePregunta($respuestas) === 15) {
            // Usar ML para la predicción
            $resultadoML = $this->predecirConML($respuestas);
            
            // También obtener resultado del algoritmo original para comparar
            $cursoAlgoritmo = $this->evaluarCurso($respuestas);
            
            // Guardar los datos para entrenamiento futuro
            $this->guardarDatosEntrenamiento($respuestas, $cursoAlgoritmo, $resultadoML);
            
            return view('pag_visitante.test_prediccion.resultado', [
                'curso' => $resultadoML['curso'],
                'probabilidad' => $resultadoML['probabilidad'],
                'respuestas' => $respuestas,
                'todas_probabilidades' => $resultadoML['todas_probabilidades'] ?? [],
                'curso_algoritmo' => $cursoAlgoritmo
            ]);
        }

        $index = $this->obtenerSiguientePregunta($respuestas);
        $pregunta = $this->preguntas[$index];

        return view('pag_visitante.test_prediccion.algoritmo', compact('pregunta', 'index'));
    }

    private function obtenerSiguientePregunta($respuestas)
    {
        $n = count($respuestas);

        switch ($n) {
            case 0:
                return 0; // P0
            case 1:
                return $respuestas[0] === 'No' ? 1 : 7; // P1 o P7
            case 2:
                if ($respuestas[0] === 'No') {
                    return $respuestas[1] === 'Sí' ? 2 : 3; // P2 o P3
                } else {
                    return 8;
                }
            case 3:
                if ($respuestas[0] === 'No' && $respuestas[1] === 'Sí') {
                    return 15; // Ya se puede evaluar
                } elseif ($respuestas[0] === 'No') {
                    return 4;
                } else {
                    return 9;
                }
            case 4:
                return $respuestas[0] === 'No' ? 5 : 10;
            case 5:
                return 6;
            case 6:
                return 15;
            case 7:
                return 15;
            case 8:
                return 15;
            case 9:
                return 15;
            case 10:
                return 15;
            case 11:
                return 15;
            case 12:
                return 15;
            case 13:
                return 15;
            case 14:
                return 15;
            default:
                return 15;
        }
    }
    
    public function guardarRespuesta(Request $request)
    {
        $respuesta = $request->input('respuesta');
        $index = $request->input('index');

        $respuestas = session('respuestas', []);
        $respuestas[$index] = $respuesta;
        session(['respuestas' => $respuestas]);

        return redirect()->route('test.formulario');
    }

    private function predecirConML($respuestas)
    {
        try {
            // Llamar al servicio ML (puedes usar un microservicio Python o API)
            $response = Http::timeout(30)->post('http://localhost:5000/predecir', [
                'respuestas' => $respuestas
            ]);
            // mostrar respuesta en consola
            Log::info('Respuesta del servicio ML: ' . $response->body());
            // Si la respuesta es exitosa, retornar los datos
            // Si la respuesta es exitosa, retornar los datos
            if ($response->failed()) {
                Log::error('Error en la respuesta del servicio ML: ' . $response->body());
            }

            if ($response->successful()) {
                return $response->json();
            } else {
                // Fallback al algoritmo original si falla el ML
                return [
                    'curso' => $this->evaluarCurso($respuestas),
                    'probabilidad' => 85,
                    'todas_probabilidades' => []
                ];
            }
        } catch (\Exception $e) {
            // Fallback al algoritmo original
            return [
                'curso' => $this->evaluarCurso($respuestas),
                'probabilidad' => 85,
                'todas_probabilidades' => []
            ];
        }
    }

    private function evaluarCurso($r)
    {
        if (($r[0] ?? null) === 'No') {
            if (($r[1] ?? null) === 'Sí') {
                return ($r[2] ?? null) === 'Sí' ? 'Auxiliar de Psicomotricidad' : 'Prótesis Dental';
            } else {
                if (($r[3] ?? null) === 'Sí') {
                    return ($r[4] ?? null) === 'Sí' ? 'Auxiliar de Laboratorio Forense' : 'Cursos sin sangre';
                } else {
                    if (($r[5] ?? null) === 'Teórico') {
                        return ($r[6] ?? null) === 'Sí' ? 'Auxiliar de Criminalística' : 'Cursos generales sin sangre';
                    }
                    return 'Cursos generales sin sangre';
                }
            }
        } else {
            if (($r[7] ?? null) === 'Teoría') {
                if (($r[8] ?? null) === 'Sí') {
                    return ($r[9] ?? null) === 'Sí' ? 'Toxicología Forense' : 'Auxiliar de Criminalística';
                } else {
                    return ($r[10] ?? null) === 'Sí' ? 'Auxiliar de Criminalística' : 'Cursos teóricos relacionados';
                }
            } else {
                if (($r[11] ?? null) === 'Solo') {
                    return ($r[12] ?? null) === 'Sí' ? 'Técnico en Criminalística Forense' : 'Auxiliar de Laboratorio Forense';
                } else {
                    if (($r[13] ?? null) === 'Crímenes') {
                        return 'Investigador de Crímenes';
                    } else {
                        return ($r[14] ?? null) === 'Medicina Forense' ? 'Auxiliar de Medicina Forense' : 'Investigación Forense en Accidentes de Tráfico';
                    }
                }
            }
        }
    }

    private function guardarDatosEntrenamiento($respuestas, $cursoAlgoritmo, $resultadoML)
    {
        try {
            DB::table('test_respuestas')->insert([
                'respuestas' => json_encode($respuestas),
                'curso_recomendado' => $cursoAlgoritmo,
                'precision_algoritmo' => $resultadoML['probabilidad'] ?? null,
                'ip_usuario' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'fecha_respuesta' => now()
            ]);
        } catch (\Exception $e) {
            Log::error('Error guardando datos de entrenamiento: ' . $e->getMessage());
        }
    }

    public function entrenarModelo()
    {
        try {
            // Obtener datos de entrenamiento desde la base de datos
            $datosEntrenamiento = DB::table('test_respuestas')
                ->select('respuestas', 'curso_recomendado')
                ->get()
                ->map(function($item) {
                    return [
                        'respuestas' => json_decode($item->respuestas, true),
                        'curso' => $item->curso_recomendado
                    ];
                });

            // Llamar al servicio ML para reentrenar
            $response = Http::timeout(120)->post('http://localhost:5000/entrenar', [
                'datos' => $datosEntrenamiento->toArray()
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Modelo entrenado exitosamente',
                    'metricas' => $response->json()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error entrenando el modelo'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function estadisticas()
    {
        $estadisticas = [
            'total_respuestas' => DB::table('test_respuestas')->count(),
            'cursos_mas_recomendados' => DB::table('test_respuestas')
                ->select('curso_recomendado', DB::raw('COUNT(*) as total'))
                ->groupBy('curso_recomendado')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
            'predicciones_ml' => DB::table('ml_predicciones')->count(),
            'ultima_metrica' => DB::table('ml_metricas')
                ->orderByDesc('fecha_entrenamiento')
                ->first(),
            'respuestas_por_dia' => DB::table('test_respuestas')
                ->select(DB::raw('DATE(fecha_respuesta) as fecha'), DB::raw('COUNT(*) as total'))
                ->where('fecha_respuesta', '>=', now()->subDays(30))
                ->groupBy('fecha')
                ->orderBy('fecha')
                ->get()
        ];

        return view('admin.test_estadisticas', compact('estadisticas'));
    }

    public function reiniciar()
    {
        session()->forget('respuestas');
        return redirect()->route('test.formulario');
    }
}