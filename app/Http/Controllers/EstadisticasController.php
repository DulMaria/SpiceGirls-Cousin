<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticasController extends Controller
{
    public function index()
    {
        $cursos = $this->getCursosPopulares();
        $distribucion = $this->getDistribucionGenero();
        $masCursado = $this->getCursoMasCursado();
        $edades = $this->getRangoEdades();

        return view('administrador.prinAdmi', [
            'nombres'      => $cursos['nombres'],
            'inscritos'    => $cursos['inscritos'],
            'distribucion' => $distribucion,
            'cursoMasCursado' => $masCursado['curso'],
            'porcentajeMasCursado' => $masCursado['porcentaje'],
            'rangoLabels' => $edades->pluck('rango_edad')->toArray(),
            'rangoValores' => $edades->pluck('total')->toArray(),
        ]);
    }

    private function getCursosPopulares()
    {
        $cursos = DB::table('curso')
            ->leftJoin('inscripcion', 'curso.ID_Curso', '=', 'inscripcion.ID_Curso')
            ->select('curso.nombreCurso as nombre', DB::raw('COUNT(inscripcion.ID_Inscripcion) as inscritos'))
            ->groupBy('curso.ID_Curso','curso.nombreCurso')
            ->orderByDesc('inscritos')
            ->limit(5)
            ->get();

        return [
            'nombres'   => $cursos->pluck('nombre')->toArray(),
            'inscritos' => $cursos->pluck('inscritos')->toArray()
        ];
    }

    private function getDistribucionGenero()
    {
        $generos = DB::table('estudiante')->select(DB::raw('
            SUM(CASE WHEN genero = 1 THEN 1 ELSE 0 END) as mujeres,
            SUM(CASE WHEN genero = 0 THEN 1 ELSE 0 END) as hombres,
            SUM(CASE WHEN genero = 2 THEN 1 ELSE 0 END) as otros
        '))->first();
    
        $total = $generos->mujeres + $generos->hombres + $generos->otros;
    
        if ($total == 0) {
            return [
                'mujeres' => 0, 
                'hombres' => 0, 
                'otros' => 0,
                'mujeres_cantidad' => 0,
                'hombres_cantidad' => 0,
                'otros_cantidad' => 0,
                'total' => 0
            ];
        }
    
        return [
            'mujeres' => round(($generos->mujeres / $total) * 100, 2),
            'hombres' => round(($generos->hombres / $total) * 100, 2),
            'otros'   => round(($generos->otros   / $total) * 100, 2),
            'mujeres_cantidad' => $generos->mujeres,
            'hombres_cantidad' => $generos->hombres,
            'otros_cantidad'   => $generos->otros,
            'total' => $total
        ];
    }

    private function getCursoMasCursado()
    {
        // Recupera todos los cursos con su número de inscripciones
        $cursos = DB::table('curso')
            ->leftJoin('inscripcion', 'curso.ID_Curso', '=', 'inscripcion.ID_Curso')
            ->select('curso.nombreCurso as nombre', DB::raw('COUNT(inscripcion.ID_Inscripcion) as total_inscritos'))
            ->groupBy('curso.ID_Curso','curso.nombreCurso')
            ->orderByDesc('total_inscritos')
            ->get();

        // Suma total de todas las inscripciones
        $totalInscripciones = $cursos->sum('total_inscritos');

        // Toma el curso con más inscripciones (el primero después del orderByDesc)
        $cursoMas = $cursos->first();

        // Calcula el porcentaje relativo
        $porcentaje = $totalInscripciones > 0
            ? round(($cursoMas->total_inscritos / $totalInscripciones) * 100, 2)
            : 0;

        return [
            'curso'      => $cursoMas->nombre,
            'porcentaje' => $porcentaje
        ];
    }

    private function getRangoEdades()
    {
        $rangos = DB::table(DB::raw("(SELECT 
                    CASE
                        WHEN TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) BETWEEN 18 AND 24 THEN '18-24'
                        WHEN TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) BETWEEN 25 AND 34 THEN '25-34'
                        WHEN TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) BETWEEN 35 AND 44 THEN '35-44'
                        WHEN TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) BETWEEN 45 AND 65 THEN '45-65'
                        ELSE '65+'
                    END AS rango_edad
                FROM usuario
                WHERE ID_Rol = 3) AS edades"))
            ->select('rango_edad', DB::raw('COUNT(*) as total'))
            ->groupBy('rango_edad')
            ->orderBy('rango_edad')
            ->get();

        return $rangos;
    }
}

  /*  private function getDistribucionEdad()
    {
        $edades = DB::table('estudiantes')->select(DB::raw('
            SUM(CASE WHEN edad BETWEEN 18 AND 24 THEN 1 ELSE 0 END) as "18-24",
            SUM(CASE WHEN edad BETWEEN 25 AND 34 THEN 1 ELSE 0 END) as "25-34",
            SUM(CASE WHEN edad BETWEEN 35 AND 44 THEN 1 ELSE 0 END) as "35-44",
            SUM(CASE WHEN edad BETWEEN 45 AND 70 THEN 1 ELSE 0 END) as "45-70"
        '))->first();

        $total = array_sum((array)$edades);
        $porcentajes = [];
        foreach ((array)$edades as $rango => $cantidad) {
            $porcentajes[$rango] = ($cantidad / $total) * 100;
        }
        return $porcentajes;
    }*/

    
/*
    private function getTotalGraduados()
    {
        return Inscripcion::where('estado', 'graduado')->count();
    }

    private function getMeses()
    {
        return ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    }

    private function getInscripcionesPorMes()
    {
        $datos = array_fill(0, 12, 0);
        $registros = Inscripcion::select(DB::raw('MONTH(created_at) as mes, COUNT(*) as total'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('mes')
            ->get();

        foreach ($registros as $r) {
            $datos[$r->mes - 1] = $r->total;
        }
        return $datos;
    }

    private function getGraduadosPorMes()
    {
        $datos = array_fill(0, 12, 0);
        $registros = Inscripcion::select(DB::raw('MONTH(fecha_graduacion) as mes, COUNT(*) as total'))
            ->whereNotNull('fecha_graduacion')
            ->whereYear('fecha_graduacion', date('Y'))
            ->groupBy('mes')
            ->get();

        foreach ($registros as $r) {
            $datos[$r->mes - 1] = $r->total;
        }
        return $datos;
    }

    private function getPagosPorMes()
    {
        $datos = [
            'completo' => array_fill(0, 12, 0),
            'beca' => array_fill(0, 12, 0),
            'oferta' => array_fill(0, 12, 0)
        ];

        $registros = Pago::select(
                DB::raw('MONTH(fecha_pago) as mes'),
                DB::raw('SUM(CASE WHEN tipo_pago = "completo" THEN monto ELSE 0 END) as pago_completo'),
                DB::raw('SUM(CASE WHEN tipo_pago = "beca" THEN monto ELSE 0 END) as pago_beca'),
                DB::raw('SUM(CASE WHEN tipo_pago = "oferta" THEN monto ELSE 0 END) as pago_oferta')
            )
            ->whereYear('fecha_pago', date('Y'))
            ->groupBy('mes')
            ->get();

        foreach ($registros as $r) {
            $i = $r->mes - 1;
            $datos['completo'][$i] = $r->pago_completo;
            $datos['beca'][$i] = $r->pago_beca;
            $datos['oferta'][$i] = $r->pago_oferta;
        }

        return $datos;
    }

    

    private function getGraduadosPorAño()
    {
        $registros = Inscripcion::select(DB::raw('YEAR(fecha_graduacion) as año, COUNT(*) as total'))
            ->whereNotNull('fecha_graduacion')
            ->groupBy('año')
            ->orderBy('año')
            ->get();

        return [
            'años' => $registros->pluck('año')->toArray(),
            'totales' => $registros->pluck('total')->toArray()
        ];
    }*/

