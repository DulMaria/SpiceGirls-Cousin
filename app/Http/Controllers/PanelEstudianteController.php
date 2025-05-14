<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelEstudianteController extends Controller
{
    public function dashboard()
    {
        return view('estudiante.prinEstudiante');  // Vista principal de Estudiante
    }
}
