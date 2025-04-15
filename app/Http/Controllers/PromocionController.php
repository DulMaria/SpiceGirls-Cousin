<?php

namespace App\Http\Controllers;

use App\Models\Promocion;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    public function mostrarBecas()
    {
        // Recuperar las promociones activas (estado = 1) de tipo 'beca' (tipo = 1)
        $becas = \App\Models\Promocion::where('estado', '1') // Becas activas
            ->where('tipo', '1') // Tipo 'beca'
            ->with('cursos') // Traer los cursos relacionados
            ->get();

        // Pasar los datos a la vista
        return view('pag_visitante.becasEstudiante', compact('becas'));
    }

    public function mostrarOfertas()
    {
        $ofertas = \App\Models\Promocion::where('estado', '1')
            ->where('tipo', '0') 
            ->with('cursos') // Traer los cursos relacionados
            ->get();

        // Pasar los datos a la vista
        return view('pag_visitante.ofertasEstudiante', compact('ofertas'));
    }
}
