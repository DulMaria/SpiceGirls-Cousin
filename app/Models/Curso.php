<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    // Nombre de la tabla
    protected $table = 'curso';

    // Clave primaria
    protected $primaryKey = 'ID_Curso';

    // No es autoincrementable
    public $incrementing = false;

    // Tipo de la clave primaria
    protected $keyType = 'int';

    // No maneja created_at y updated_at
    public $timestamps = false;

    // Atributos asignables
    protected $fillable = [
        'ID_Curso',
        'ID_Area',
        'nombreCurso',
        'descripcionCurso',
        'estado',
        'imagen',
    ];

    // 🚀 RELACIÓN: Un curso pertenece a un área
    public function area()
    {
        return $this->belongsTo(Area::class, 'ID_Area', 'ID_Area');
        // belongsTo(RelatedModel, foreign_key, owner_key)
    }
    public function modulos()
    {
        return $this->hasMany(ModuloCurso::class, 'ID_Curso', 'ID_Curso');
    }

}
