<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        return view('pag_visitante.cursosUser', compact('areas'));
    }
}
