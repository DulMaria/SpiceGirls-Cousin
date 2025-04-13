<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $primaryKey = 'ID_Area';
    public $timestamps = false;

    protected $fillable = [
        'nombreArea',
        'descripcionArea',
        'imagenArea',
    ];
}
