<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol'; // Nombre de la tabla

    protected $primaryKey = 'ID_Rol'; // Llave primaria

    public $timestamps = false; // No tienes columnas created_at ni updated_at

    protected $fillable = [
        'ID_Rol',
        'nombreRol',
        'descripcion',
    ];
}
