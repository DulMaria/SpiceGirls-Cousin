<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanelDocenteController extends Controller
{
    public function dashboard()
    {
        // Obtener el usuario autenticado (o por ID si no usas Auth)
        $usuarioId = Auth::id(); // O usar: $usuarioId = 1; para testing

        // Consulta JOIN para obtener datos del usuario y docente
        $datosCompletos = DB::table('usuario as u')
            ->join('docente as d', 'u.ID_Usuario', '=', 'd.ID_Usuario')
            ->select([
                'u.ID_Usuario',
                'u.nombre',
                'u.apellidoPaterno',
                'u.apellidoMaterno',
                'u.telefono',
                'u.direccion',
                'u.fechaNacimiento',
                'u.email',
                'u.ci',
                'u.estado',
                'd.codigoDocente',
                'd.especialidad'
            ])
            ->where('u.ID_Usuario', $usuarioId)
            ->first();

        // Si no existe el usuario/docente
        if (!$datosCompletos) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        // Crear objetos separados para el view (como en tu código original)
        $usuario = (object) [
            'ID_Usuario' => $datosCompletos->ID_Usuario,
            'nombre' => $datosCompletos->nombre,
            'apellidoPaterno' => $datosCompletos->apellidoPaterno,
            'apellidoMaterno' => $datosCompletos->apellidoMaterno,
            'telefono' => $datosCompletos->telefono,
            'direccion' => $datosCompletos->direccion,
            'fechaNacimiento' => $datosCompletos->fechaNacimiento,
            'email' => $datosCompletos->email,
            'ci' => $datosCompletos->ci,
            'estado' => $datosCompletos->estado
        ];

        $docente = (object) [
            'codigoDocente' => $datosCompletos->codigoDocente,
            'especialidad' => $datosCompletos->especialidad,
            'ID_Usuario' => $datosCompletos->ID_Usuario
        ];

        // Contar cursos activos del docente desde la base de datos
        $cursosActivos = DB::table('apertura_modulo')
            ->where('codigoDocente', $datosCompletos->codigoDocente)
            ->where('estado', 1) // Asumiendo que 'A' = Activo
            // ->where('fechaInicio', '<=', now()) // Ya iniciado
            // ->where('fechaFin', '>=', now()) // Aún no terminado
            ->count();

        // Contar total de estudiantes únicos en cursos activos del docente
        $totalEstudiantes = DB::table('historial_academico as ha')
            ->join('apertura_modulo as am', 'ha.ID_Apertura', '=', 'am.ID_Apertura')
            ->where('am.codigoDocente', $datosCompletos->codigoDocente)
            ->where('am.estado', 1) // Apertura activa
            // ->where('am.fechaInicio', '<=', now())
            // ->where('am.fechaFin', '>=', now())
            ->distinct('ha.codigoEstudiantil') // Campo correcto de la tabla historial_academico
            ->count();

        mt_srand($datosCompletos->ID_Usuario);
        $anosExperiencia = mt_rand(1, 20);

        return view('docente.prinDocente', compact(
            'usuario',
            'docente',
            'cursosActivos',
            'totalEstudiantes',
            'anosExperiencia'
        ));
    }
}
