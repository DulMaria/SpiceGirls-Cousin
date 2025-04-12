<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home'); // Vista para la página de inicio
    }

    public function Cursos()
    {
        return view('pag_visitante.cursosUser'); // Vista para la página de cursosUser
    }

    public function Promociones()
    {
        return view('pag_visitante.news'); // Vista para la página de las promociones
    }

    public function showContact()
    {
        return view('pag_visitante.contacto'); // Vista para la página de las promociones
    }

    public function History()
    {
        return view('pag_visitante.sobreNosotros'); // Vista para la página de la informacion de la fundacion
    }
}
