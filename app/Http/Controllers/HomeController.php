<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class HomeController extends Controller
{
    public function index()
    {
        return view('home'); // Vista para la página de inicio
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

    public function totalCurso()
    {
        // Obtener el número de cursos desde la base de datos
        $numeroDeCursos = Curso::count();
        // Pasar los datos a la vista
        return view('home', compact('numeroDeCursos'));
    }

    public function Certificaiones()
    {
        return view('pag_visitante.certificados'); // Vista para la página de certificaciones
    }
}
