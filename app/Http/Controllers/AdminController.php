<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Página principal del administrador
    public function dashboard()
    {
        return view('administrador.prinAdmi');  // Vista principal del administrador
    }

    public function areas()
    {
        return view('administrador.cruds.area.areaIndex');
    }

    public function cursos()
    {
        return view('administrador.cruds.cursos.cursosIndex');
    }

    public function docentes()
    {
        return view('administrador.docentes');
    }

    public function estudiantes()
    {
        return view('administrador.estudiantes');
    }
}
