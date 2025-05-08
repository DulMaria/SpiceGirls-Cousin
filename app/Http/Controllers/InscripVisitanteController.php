<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InscripVisitanteController extends Controller
{
    public function formulario($id)
    {
        // Recuperar el curso por ID y mostrar el formulario de inscripción
        $curso = \App\Models\Curso::findOrFail($id);
        return view('pag_visitante.formInscripcion', compact('curso'));
    }
}
