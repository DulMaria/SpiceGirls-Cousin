<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Agrega esta línea   

use App\Models\Curso;
use App\Models\Area;
use App\Models\ModuloCurso;


class CursoController extends Controller
{
    /**
     * Devuelve la lista de cursos disponibles en formato JSON para usar en el modal
     */
    public function getCursosDisponibles()
    {
        $cursos = Curso::where('estado', 1)->get(['ID_Curso', 'nombreCurso']);
        return response()->json($cursos);
    }
    public function index()
    {
        $cursos = Curso::with(['area', 'modulos'])->get();
        $areas = Area::all();  // Recupera todas las áreas de la base de datos
        return view('administrador.cruds.cursos.cursosIndex', compact('cursos', 'areas'));  // Pasa las áreas a la vista
    }

    public function mostrarFormularioCurso()
    {
        $areas = Area::all();  // Recupera todas las áreas de la base de datos
        return view('administrador.cruds.cursos.create', compact('areas'));  // Pasa las áreas a la vista
    }

    public function store(Request $request)
    {
        // Validación actualizada con los nombres de campos correctos
        $request->validate([
            'nombreCurso' => 'required|string|max:255',
            'descripcionCurso' => 'required|string',
            'estado' => 'required|in:1,2',
            'ID_Area' => 'required|exists:area,ID_Area',
            'imagenCurso' => 'nullable|image|max:2048', // Máximo 2MB
            'modulos' => 'required|array|min:1',
            'descripcionModulo' => 'required|array|min:1', // Cambiado para coincidir con el nombre del formulario
        ]);

        // Crear nuevo curso
        $curso = new Curso();

        // Si ID_Curso no es autoincrementable, necesitas asignarle un valor
        // Por ejemplo, puedes obtener el último ID y sumarle 1
        $ultimoCurso = Curso::orderBy('ID_Curso', 'desc')->first();
        $nuevoId = $ultimoCurso ? $ultimoCurso->ID_Curso + 1 : 1;
        $curso->ID_Curso = $nuevoId;

        $curso->ID_Area = $request->ID_Area;
        $curso->nombreCurso = $request->nombreCurso;
        $curso->descripcionCurso = $request->descripcionCurso;
        $curso->estado = $request->estado;

        // Procesar imagen y guardar como antes...
        // Procesar la imagen si existe
        if ($request->hasFile('imagenCurso')) {
            $imagen = $request->file('imagenCurso');
            $curso->imagen = file_get_contents($imagen->getRealPath());
        }
        $curso->save();

        // Guardar los módulos, asegurándote de usar el ID del curso
        if ($request->has('modulos')) {
            $moduloNombres = $request->modulos;
            $descripcionesModulo = $request->descripcionModulo;

            $count = min(count($moduloNombres), count($descripcionesModulo));

            for ($i = 0; $i < $count; $i++) {
                if (empty($moduloNombres[$i])) {
                    continue;
                }

                $modulo = new ModuloCurso();

                // También necesitas asignar un ID al módulo si no es autoincrementable
                if (!$modulo->incrementing) {
                    $ultimoModulo = ModuloCurso::orderBy('ID_Modulo', 'desc')->first();
                    $nuevoIdModulo = $ultimoModulo ? $ultimoModulo->ID_Modulo + 1 : 1;
                    $modulo->ID_Modulo = $nuevoIdModulo;
                }

                $modulo->nombreModulo = $moduloNombres[$i];
                $modulo->descripcionModulo = $descripcionesModulo[$i];
                $modulo->ID_Curso = $curso->ID_Curso; // Asegúrate de que este valor no sea nulo
                $modulo->orden = $i + 1;
                $modulo->estado = 1;

                // Verifica que ID_Curso no sea nulo antes de guardar
                if ($modulo->ID_Curso) {
                    $modulo->save();
                } else {
                    // Log o manejo de error
                    logger('ID_Curso es nulo al guardar módulo: ' . $moduloNombres[$i]);
                }
            }
        }

        return redirect()->route('ruta.a.lista.de.cursos')->with('success', 'Curso creado exitosamente');
    }


    // Añadir estos métodos a tu CursoController

    /**
     * Mostrar el formulario para editar el curso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        $modulos = ModuloCurso::where('ID_Curso', $id)->orderBy('orden')->get();

        // Si hay una imagen, conviértela a base64 para enviarla en la respuesta
        if ($curso->imagen) {
            $curso->imagen = base64_encode($curso->imagen);
        }

        return response()->json([
            'curso' => $curso,
            'modulos' => $modulos
        ]);
    }

    /**
     * Actualizar el curso especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validación
        $request->validate([
            'nombreCurso' => 'required|string|max:255',
            'descripcionCurso' => 'required|string',
            'estado' => 'required|in:1,2',
            'ID_Area' => 'required|exists:area,ID_Area',
            'imagenCurso' => 'nullable|image|max:2048',
            'modulos' => 'required|array|min:1',
            'descripcionModulo' => 'required|array|min:1',
            'moduloIds' => 'nullable|array',
            'deleteModulos' => 'nullable|array',
        ]);

        // Buscar el curso
        $curso = Curso::findOrFail($id);

        // Actualizar datos del curso
        $curso->ID_Area = $request->ID_Area;
        $curso->nombreCurso = $request->nombreCurso;
        $curso->descripcionCurso = $request->descripcionCurso;
        $curso->estado = $request->estado;

        // Procesar la imagen si se proporciona una nueva
        if ($request->hasFile('imagenCurso')) {
            $imagen = $request->file('imagenCurso');
            $curso->imagen = file_get_contents($imagen->getRealPath());
        }

        $curso->save();

        // Eliminar módulos marcados para eliminar
        if ($request->has('deleteModulos')) {
            ModuloCurso::whereIn('ID_Modulo', $request->deleteModulos)->delete();
        }

        // Actualizar o crear módulos
        if ($request->has('modulos')) {
            $moduloNombres = $request->modulos;
            $descripcionesModulo = $request->descripcionModulo;
            $moduloIds = $request->moduloIds ?? [];

            $count = min(count($moduloNombres), count($descripcionesModulo));

            for ($i = 0; $i < $count; $i++) {
                if (empty($moduloNombres[$i])) {
                    continue;
                }

                // Verificar si es un módulo existente o nuevo
                $idModulo = isset($moduloIds[$i]) && !empty($moduloIds[$i]) ? $moduloIds[$i] : null;

                if ($idModulo) {
                    // Actualizar módulo existente
                    $modulo = ModuloCurso::find($idModulo);
                    if ($modulo) {
                        $modulo->nombreModulo = $moduloNombres[$i];
                        $modulo->descripcionModulo = $descripcionesModulo[$i];
                        $modulo->orden = $i + 1;
                        $modulo->save();
                    }
                } else {
                    // Crear nuevo módulo
                    $modulo = new ModuloCurso();

                    // Si ID_Modulo no es autoincrementable, necesitamos asignarle un valor
                    if (!$modulo->incrementing) {
                        $ultimoModulo = ModuloCurso::orderBy('ID_Modulo', 'desc')->first();
                        $nuevoIdModulo = $ultimoModulo ? $ultimoModulo->ID_Modulo + 1 : 1;
                        $modulo->ID_Modulo = $nuevoIdModulo;
                    }

                    $modulo->nombreModulo = $moduloNombres[$i];
                    $modulo->descripcionModulo = $descripcionesModulo[$i];
                    $modulo->ID_Curso = $curso->ID_Curso;
                    $modulo->orden = $i + 1;
                    $modulo->estado = 1;
                    $modulo->save();
                }
            }
        }

        return redirect()->route('ruta.a.lista.de.cursos')->with('success', 'Curso actualizado exitosamente');
    }

    /**
     * Eliminar el curso especificado de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Primero eliminar los módulos asociados
        ModuloCurso::where('ID_Curso', $id)->delete();

        // Luego eliminar el curso
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return redirect()->route('ruta.a.lista.de.cursos')->with('success', 'Curso eliminado exitosamente');
    }

    public function cambiarEstado($id)
    {
        try {
            $curso = Curso::findOrFail($id);
            $curso->estado = ($curso->estado == 1) ? 2 : 1;
            $curso->save();

            $mensaje = ($curso->estado == 1) ? 'habilitado' : 'deshabilitado';
            return back()->with('success', "Curso {$mensaje} exitosamente");
        } catch (\Exception $e) {
            Log::error('Error al cambiar estado del curso: ' . $e->getMessage());
            return back()->with('error', 'Error al cambiar el estado del curso');
        }
    }

    public function mostrarPorArea($id)
    {
        // Obtener el área por su ID
        $area = Area::findOrFail($id);

        // Obtener los cursos relacionados con esta área
        $cursos = Curso::where('ID_Area', $id)->get();

        // Retornar la vista con los datos del área y los cursos
        return view('pag_visitante.curso_asociado', compact('area', 'cursos'));
    }
}
