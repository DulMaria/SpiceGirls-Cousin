<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Usuario;

use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::all(); // o como los estés obteniendo

        return view('administrador.cruds.estudiante.estudiantes', compact('estudiantes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidoPaterno' => 'required|string|max:100',
            'apellidoMaterno' => 'nullable|string|max:100',
            'nivelAcademico' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fechaNacimiento' => 'nullable|date',
            'email' => 'required|email|unique:usuario,email',
            'ci' => 'nullable|string|max:20',
        ]);

        // Crear usuario
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->apellidoPaterno = $request->apellidoPaterno;
        $usuario->apellidoMaterno = $request->apellidoMaterno;
        $usuario->email = $request->email;
        $usuario->contrasenia = bcrypt('EST123'); // Aquí puedes mejorar la generación de la contraseña
        $usuario->telefono = $request->telefono;
        $usuario->direccion = $request->direccion;
        $usuario->fechaNacimiento = $request->fechaNacimiento;
        $usuario->ci = $request->ci;
        $usuario->estado = $request->estado ?? 1; // Puedes asignar un valor por defecto si no lo envían
        $usuario->ID_Rol = 3; // Rol de estudiante
        $usuario->save();

        // Generar automáticamente el código del estudiante
        $nombreInicial = strtoupper(substr($request->nombre, 0, 1));
        $apellidoPaternoInicial = strtoupper(substr($request->apellidoPaterno, 0, 1));
        $apellidoMaternoInicial = strtoupper(substr($request->apellidoMaterno ?? '', 0, 1));
        $prefijo = $nombreInicial . $apellidoPaternoInicial . $apellidoMaternoInicial;

        // Obtener el último número SIN importar el prefijo
        $ultimoEstudiante = \App\Models\Estudiante::orderByRaw('CAST(SUBSTRING(codigoEstudiantil, 4) AS UNSIGNED) DESC')->first();
        if ($ultimoEstudiante && preg_match('/(\d+)$/', $ultimoEstudiante->codigoEstudiantil, $coincidencias)) {
            $ultimoNumero = (int) $coincidencias[1];
        } else {
            $ultimoNumero = 0;
        }

        $nuevoNumero = str_pad($ultimoNumero + 1, 5, '0', STR_PAD_LEFT); // formato 00001, 00002, etc.

        $codigoEstudiantil = $prefijo . $nuevoNumero;

        // Crear estudiante
        $estudiante = new Estudiante();
        $estudiante->codigoEstudiantil = $codigoEstudiantil;
        $estudiante->nivelAcademico = $request->nivelAcademico;
        $estudiante->ID_Usuario = $usuario->ID_Usuario; // Asignar el ID del usuario creado
        $estudiante->save();

        return redirect()->back()->with('success', 'Estudiante creado exitosamente.');
    }



    // Método para obtener datos del Estudiante para editar
    public function edit($codigoEstudiantil, $ID_Usuario)
    {
        $estudiante = Estudiante::with('usuario')->where('codigoEstudiantil', $codigoEstudiantil)->first();
        $usuario = Usuario::where('ID_Usuario', $ID_Usuario)->first();

        if (!$estudiante || !$usuario) {
            return redirect()->back()->with('error', 'Estudiante o usuario no encontrado');
        }

        return response()->json([
            'estudiante' => $estudiante,
            'usuario' => $usuario
        ]);
    }


    // Método para actualizar un estudiante
    public function update(Request $request, $codigoEstudiantil)
    {
        $estudiante = Estudiante::where('codigoEstudiantil', $codigoEstudiantil)->first();

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado');
        }

        $usuario = Usuario::find($estudiante->ID_Usuario);

        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidoPaterno' => 'required|string|max:100',
            'apellidoMaterno' => 'nullable|string|max:100',
            'nivelAcademico' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fechaNacimiento' => 'nullable|date',
            'email' => 'required|email|unique:usuario,email,' . $usuario->ID_Usuario . ',ID_Usuario',
            'ci' => 'nullable|string|max:20',
            'estado' => 'required|in:0,1',
        ]);

        // Actualizar usuario
        $usuario->nombre = $request->nombre;
        $usuario->apellidoPaterno = $request->apellidoPaterno;
        $usuario->apellidoMaterno = $request->apellidoMaterno;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->direccion = $request->direccion;
        $usuario->fechaNacimiento = $request->fechaNacimiento;
        $usuario->ci = $request->ci;
        $usuario->estado = $request->estado;
        $usuario->save();

        // Actualizar estudiante
        $estudiante->nivelAcademico = $request->nivelAcademico;
        $estudiante->save();

        return redirect()->route('admin.estudiantes.index')->with('success', 'Estudiante actualizado exitosamente');
    }

    public function cambiarEstado($codigoEstudiantil)
    {
        $estudiante = Estudiante::where('codigoEstudiantil', $codigoEstudiantil)->first();

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado');
        }

        $usuario = Usuario::find($estudiante->ID_Usuario);

        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        // Cambiar el estado (toggle entre 0 y 1)
        $usuario->estado = $usuario->estado == 1 ? 0 : 1;
        $usuario->save();

        $mensaje = $usuario->estado == 1 ? 'habilitado' : 'deshabilitado';

        return redirect()->route('administrador.estudiantes.index')
            ->with('success', "Estudiante {$mensaje} exitosamente");
    }
}
