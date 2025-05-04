<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCurso extends Model
{
    protected $table = 'promocion_curso';
    protected $primaryKey = 'ID_PromoCurso';
    public $timestamps = false;

    protected $fillable = [
        'ID_Curso',
        'ID_Promo'
    ];

    // Relaciones inversas si las necesitas
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'ID_Curso');
    }

     /**
     * Relación inversa con la promoción
     */
    public function promocion()
    {
        return $this->belongsTo(Promocion::class, 'ID_Promo', 'ID_Promo');
    }
}
