<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuloCurso extends Model
{
    // Nombre de la tabla
    protected $table = 'modulo_curso';

    // Clave primaria
    protected $primaryKey = 'ID_Modulo';

    // No es autoincrementable
    public $incrementing = false;

    // Tipo de la clave primaria
    protected $keyType = 'int';

    // No maneja created_at y updated_at
    public $timestamps = false;

    // Atributos asignables
    protected $fillable = [
        'ID_Modulo',
        'nombreModulo',
        'descripcionModulo',
        'estado',
        'orden',
        'ID_Curso',
    ];

    // 🚀 RELACIÓN: Un módulo pertenece a un curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'ID_Curso', 'ID_Curso');
        // belongsTo(RelatedModel, foreign_key, owner_key)
    }
}
