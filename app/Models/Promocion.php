<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Promocion extends Model
{
    protected $table = 'promocion'; // Nombre exacto de la tabla

    protected $primaryKey = 'ID_Promo'; // Clave primaria personalizada

    public $incrementing = true; // Auto-incremental
    protected $keyType = 'int'; // Tipo de clave primaria

    public $timestamps = false; // No tienes campos created_at y updated_at

    protected $fillable = [
        'descuento',
        'descripcion',
        'fechaInicio',
        'fechaFin',
        'estado',
        'tipo',
    ];
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'promocion_curso', 'ID_Promo', 'ID_Curso');
    }
    
    /**
     * Relación uno a muchos con promocion_curso
     */
    public function promocion_cursos()
    {
        return $this->hasMany(PromoCurso::class, 'ID_Promo');
    }
}
