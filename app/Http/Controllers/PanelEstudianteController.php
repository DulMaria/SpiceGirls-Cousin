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

        // Pasar datos a la vista
        return view('estudiante.inscripcionModulo', [
            'usuario' => $usuario,
            'estudiante' => $estudiante
        ]);
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
