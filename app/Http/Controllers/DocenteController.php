<?php

namespace App\Http\Controllers;
use App\Models\Docente; 
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Laravel\Pail\ValueObjects\Origin\Console;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::all(); // o como los estés obteniendo

        return view('administrador.cruds.docente.docentes', compact('docentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidoPaterno' => 'required|string|max:100',
            'apellidoMaterno' => 'nullable|string|max:100',
            'especialidad' => 'nullable|string|max:100',
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
        $usuario->contrasenia = bcrypt('password'); // Aquí puedes mejorar la generación de la contraseña
        $usuario->telefono = $request->telefono;
        $usuario->direccion = $request->direccion;
        $usuario->fechaNacimiento = $request->fechaNacimiento;
        $usuario->ci = $request->ci;
        $usuario->estado = $request->estado ?? 1; // Puedes asignar un valor por defecto si no lo envían
        $usuario->ID_Rol = 2; // Rol de docente
        $usuario->save();

        // Generar automáticamente el código del docente
        $nombreInicial = strtoupper(substr($request->nombre, 0, 1));
        $apellidoPaternoInicial = strtoupper(substr($request->apellidoPaterno, 0, 1));
        $apellidoMaternoInicial = strtoupper(substr($request->apellidoMaterno ?? '', 0, 1));
        $prefijo = $nombreInicial . $apellidoPaternoInicial . $apellidoMaternoInicial;

        // Obtener el último número SIN importar el prefijo
        $ultimoDocente = \App\Models\Docente::orderByRaw('CAST(SUBSTRING(codigoDocente, 4) AS UNSIGNED) DESC')->first();
        if ($ultimoDocente && preg_match('/(\d+)$/', $ultimoDocente->codigoDocente, $coincidencias)) {
            $ultimoNumero = (int) $coincidencias[1];
        } else {
            $ultimoNumero = 0;
        }

        $nuevoNumero = str_pad($ultimoNumero + 1, 5, '0', STR_PAD_LEFT); // formato 00001, 00002, etc.

        $codigoDocente = $prefijo . $nuevoNumero;

        // Crear docente
        $docente = new Docente();
        $docente->codigoDocente = $codigoDocente;
        $docente->especialidad = $request->especialidad;
        $docente->ID_Usuario = $usuario->ID_Usuario; // Asignar el ID del usuario creado
        $docente->save();

        return redirect()->back()->with('success', 'Docente creado exitosamente.');
    }



    // Método para obtener datos del docente para editar
    public function edit($codigoDocente,$ID_Usuario)
    {
        $docente = Docente::with('usuario')->where('codigoDocente', $codigoDocente)->first();
        $usuario = Usuario::where('ID_Usuario', $ID_Usuario)->first();

        if (!$docente || !$usuario) {
            return redirect()->back()->with('error', 'Docente o usuario no encontrado');
        }

        return response()->json([
            'docente' => $docente,
            'usuario' => $usuario
        ]);
    }
    

    // Método para actualizar un docente
    public function update(Request $request, $codigoDocente)
    {
        $docente = Docente::where('codigoDocente', $codigoDocente)->first();
        
        if (!$docente) {
            return redirect()->back()->with('error', 'Docente no encontrado');
        }
        
        $usuario = Usuario::find($docente->ID_Usuario);
        
        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }
        
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidoPaterno' => 'required|string|max:100',
            'apellidoMaterno' => 'nullable|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fechaNacimiento' => 'nullable|date',
            'email' => 'required|email|unique:usuario,email,'.$usuario->ID_Usuario.',ID_Usuario',
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
        
        // Actualizar docente
        $docente->especialidad = $request->especialidad;
        $docente->save();
        
        return redirect()->route('admin.docentes.index')->with('success', 'Docente actualizado exitosamente');
    }

    public function cambiarEstado($codigoDocente)
{
    $docente = Docente::where('codigoDocente', $codigoDocente)->first();
    
    if (!$docente) {
        return redirect()->back()->with('error', 'Docente no encontrado');
    }
    
    $usuario = Usuario::find($docente->ID_Usuario);
    
    if (!$usuario) {
        return redirect()->back()->with('error', 'Usuario no encontrado');
    }
    
    // Cambiar el estado (toggle entre 0 y 1)
    $usuario->estado = $usuario->estado == 1 ? 0 : 1;
    $usuario->save();
    
    $mensaje = $usuario->estado == 1 ? 'habilitado' : 'deshabilitado';
    
    return redirect()->route('admin.docentes.index')
        ->with('success', "Docente {$mensaje} exitosamente");
}

}