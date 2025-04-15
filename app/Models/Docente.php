<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'docente'; // Nombre de la tabla

    protected $primaryKey = 'codigoDocente'; // Llave primaria

    public $incrementing = false; // Porque la PK es un VARCHAR, no un entero autoincremental

    public $timestamps = false; // No tienes created_at ni updated_at

    protected $keyType = 'string'; // Tipo de la clave primaria (VARCHAR)

    protected $fillable = [
        'codigoDocente',
        'especialidad',
        'ID_Usuario',
    ];

    // Relación con Usuario (opcional, pero recomendado)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'ID_Usuario', 'ID_Usuario');
    }
}
