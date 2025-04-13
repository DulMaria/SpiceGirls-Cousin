<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AdminController extends Controller
{
    // Página principal del administrador
    public function dashboard()
    {
        return view('administrador.prinAdmi');  // Vista principal del administrador
    }

    public function areas()
    {
        $areas = Area::all();
        return view('administrador.cruds.area.areaIndex', compact('areas'));
    }
    
    public function cursos()
    {
        return view('administrador.cruds.cursos.cursosIndex');
    }

    public function guardarArea(Request $request)
    {
        $request->validate([
            'nombreArea' => 'required|max:50',
            'descripcionArea' => 'required|max:200',
            'imagenArea' => 'nullable|image|max:2048'
        ]);

        $imagenBinaria = null;
        if ($request->hasFile('imagenArea')) {
            $imagenBinaria = file_get_contents($request->file('imagenArea')->getRealPath());
        }

        Area::create([
            'nombreArea' => $request->nombreArea,
            'descripcionArea' => $request->descripcionArea,
            'imagenArea' => $imagenBinaria,
        ]);

        return redirect()->back()->with('success', 'Área registrada exitosamente.');
    }

    public function editar($id)
    {
        $area = Area::findOrFail($id); // Obtener el área con el ID
        return response()->json($area); // Enviar los datos en formato JSON
    }
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombreArea' => 'required|string|max:50',
            'descripcionArea' => 'required|string|max:200',
            'imagenArea' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $area = Area::findOrFail($id);
            $area->nombreArea = $request->nombreArea;
            $area->descripcionArea = $request->descripcionArea;

            // Manejo simplificado de la imagen (sin verificación GD)
            if ($request->hasFile('imagenArea')) {
                $image = $request->file('imagenArea');
                $area->imagenArea = file_get_contents($image->getRealPath());
            }

            $area->save();

            return response()->json([
                'success' => true,
                'message' => 'Área actualizada exitosamente',
                'redirect' => route('admin.areas.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }
}
