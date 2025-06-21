<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AperturaModulo extends Model
{

    // Nombre de la tabla
    protected $table = 'apertura_modulo';

    // Clave primaria
    protected $primaryKey = 'ID_Apertura';

    // La clave primaria no es auto-incremental
    public $incrementing = false;

    // Tipo de clave primaria
    protected $keyType = 'int';

    // No se usan timestamps
    public $timestamps = false;

    // Asignación masiva
    protected $fillable = [
        'ID_Apertura',
        'fechaInicio',
        'fechaFin',
        'estado',
        'ID_Modulo',
        'codigoDocente',
        'CostoModulo',
    ];

    /**
     * Relación con el modelo Modulo
     */
    public function modulo()
    {
        return $this->belongsTo(ModuloCurso::class, 'ID_Modulo');
    }

    /**
     * Relación con el modelo Docente
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'codigoDocente', 'codigoDocente');
    }

    /**
     * Relación con el modelo HistorialAcademico
     */
    public function historiales()
    {
        return $this->hasMany(Historial_Academico::class, 'ID_Apertura');
    }

    // En app/Models/ModuloCurso.php
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'ID_Curso');
    }
}
