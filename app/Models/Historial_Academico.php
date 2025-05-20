<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial_Academico extends Model
{

    // Nombre de la tabla (opcional si sigue la convención)
    protected $table = 'historial_academico';

    // Clave primaria
    protected $primaryKey = 'ID_Historial';

    // La clave primaria no es auto-incremental
    public $incrementing = false;

    // El tipo de la clave primaria
    protected $keyType = 'int';

    // No hay timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'ID_Historial',
        'estado',
        'ID_Apertura',
        'codigoEstudiantil',
        'fechaRegistro',
    ];

    /**
     * Relación con el modelo AperturaModulo (o como se llame el modelo de la tabla 'apertura')
     */
    public function apertura()
    {
        return $this->belongsTo(AperturaModulo::class, 'ID_Apertura');
    }

    /**
     * Relación con el modelo Estudiante (o como se llame el modelo de la tabla de estudiantes)
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'codigoEstudiantil', 'codigoEstudiantil');
    }
}
