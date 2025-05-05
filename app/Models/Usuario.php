<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Usuario extends Model
{
    protected $table = 'usuario'; // Nombre de la tabla

    protected $primaryKey = 'ID_Usuario'; // Llave primaria

    public $timestamps = false; // No tienes created_at ni updated_at

    protected $fillable = [
        'ID_Usuario',
        'ID_Rol',
        'nombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'telefono',
        'direccion',
        'fechaNacimiento',
        'email',
        'ci',
        'contrasenia',
        'estado',
    ];

    // Relación con Rol (opcional, pero recomendado)
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'ID_Rol', 'ID_Rol');
    }
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'ID_Usuario', 'ID_Usuario');
    }
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'ID_Usuario', 'ID_Usuario');
    }
    public function getAuthPassword()
    {
        return $this->contrasenia;
    }

    
}
