<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model implements Authenticatable
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

    // Implementación de los métodos requeridos por Authenticatable

    public function getAuthIdentifierName()
    {
        return 'ID_Usuario'; // Este es el campo que identifica al usuario
    }

    public function getAuthIdentifier()
    {
        return $this->ID_Usuario; // El valor único que identifica al usuario
    }

    public function getAuthPassword()
    {
        return $this->contrasenia; // Devuelve la contraseña
    }

    public function getRememberToken()
    {
        return $this->remember_token; // Este es el campo que Laravel usa para recordar la sesión del usuario (opcional si no usas "remember me")
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value; // Establece el token de "remember me" en el usuario
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Nombre de la columna en la base de datos para el "remember token"
    }

    // Método requerido por la interfaz Authenticatable
    public function getAuthPasswordName()
    {
        return 'contrasenia'; // Este es el nombre del campo donde se guarda la contraseña
    }

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
}
