<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Promocion;
use App\Models\PromoCurso;
use App\Models\Curso;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

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
    public function index()
    {
        $promociones = Promocion::with('cursos')->get();
        $cursos = Curso::where('estado', 1)->get();
        
        return view('administrador.cruds.promociones.promo', compact('promociones', 'cursos'));
    }

     /**
     * Almacena una nueva promoción
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|max:100',
            'descuento' => 'required|numeric|min:1|max:100',
            'descripcion' => 'required|string',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date|after_or_equal:fechaInicio',
            'estado' => 'required|in:0,1',
            'cursos' => 'array'
        ]);

        try {
            // Crear la promoción
            $promocion = new Promocion();
            $promocion->tipo = $request->tipo;
            $promocion->descuento = $request->descuento;
            $promocion->descripcion = $request->descripcion;
            $promocion->fechaInicio = $request->fechaInicio;
            $promocion->fechaFin = $request->fechaFin;
            $promocion->estado = $request->estado;
            $promocion->save();
            
            // Asociar cursos si se han seleccionado
            //if ($request->has('cursos') && !empty($request->cursos)) {
                foreach ($request->cursos as $cursoId) {
                    $promoCurso = new PromoCurso();
                    $promoCurso->ID_Promo = $promocion->ID_Promo;
                    $promoCurso->ID_Curso = $cursoId;
                    $promoCurso->save();
                }
            //}
            
            return redirect()->route('promociones.index')
                ->with('success', 'Promoción creada correctamente');
                
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear la promoción: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Obtiene los datos para editar una promoción
     */

    public function edit($id)
    {
        try {
            //$promocion = Promocion::find($id);
            $promocion = Promocion::with('promocion_cursos')->findOrFail($id);
            //dd($promocion->promocion_cursos);
            //$cursos = $promocion->promocion_cursos;
            
            return response()->json($promocion);
        } catch (ModelNotFoundException $e) {
            Log::warning("Promoción no encontrada con ID: $id");
            return response()->json(['error' => 'Promoción no encontrada'], 404);
        } catch (\Exception $e) {
            Log::error('Error al obtener la promoción: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo obtener la promoción'], 500);
        }
    }
    

    /**
     * Actualiza una promoción existente
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|string|max:100',
            'descuento' => 'required|numeric|min:1|max:100',
            'descripcion' => 'required|string',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date|after_or_equal:fechaInicio',
            'estado' => 'required|in:0,1',
            'cursos' => 'array'
        ]);

        try {
            $promocion = Promocion::findOrFail($id);
            
            // Actualizar datos de la promoción
            $promocion->tipo = $request->tipo;
            $promocion->descuento = $request->descuento;
            $promocion->descripcion = $request->descripcion;
            $promocion->fechaInicio = $request->fechaInicio;
            $promocion->fechaFin = $request->fechaFin;
            $promocion->estado = $request->estado;
            $promocion->save();
            
            // Eliminar asignaciones anteriores
            PromoCurso::where('ID_Promo', $id)->delete();
            
            // Añadir nuevas asignaciones de cursos
            if ($request->has('cursos') && !empty($request->cursos)) {
                foreach ($request->cursos as $cursoId) {
                    $promoCurso = new PromoCurso();
                    $promoCurso->ID_Promo = $id;
                    $promoCurso->ID_Curso = $cursoId;
                    $promoCurso->save();
                }
            }
            
            return redirect()->route('promociones.index')
                ->with('success', 'Promoción actualizada correctamente');
                
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la promoción: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Cambia el estado de una promoción (activar/desactivar)
     */
    public function cambiarEstado($id)
    {
        try {
            $promocion = Promocion::findOrFail($id);
            
            // Cambiar el estado (1 = Activo, 0 = Inactivo)
            $nuevoEstado = $promocion->estado == 1 ? 0 : 1;
            $promocion->estado = $nuevoEstado;
            $promocion->save();
            
            $mensaje = $nuevoEstado == 1 ? 'Promoción activada correctamente' : 'Promoción desactivada correctamente';
            
            return redirect()->route('promociones.index')
                ->with('success', $mensaje);
                
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al cambiar el estado de la promoción: ' . $e->getMessage());
        }
    }
}

