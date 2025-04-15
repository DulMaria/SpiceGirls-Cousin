<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCurso extends Model
{
    protected $table = 'promocion_cursos';
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

    public function promocion()
    {
        return $this->belongsTo(Promocion::class, 'ID_Promo');
    }
}
