<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaEstudiante extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Asistencia';
    protected $table = 'asistencia_estudiante';

    protected $fillable = [
        'fecha',
        'presente',
        'ID_Historial'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    // Relación con el historial académico
    public function historial()
    {
        return $this->belongsTo(Historial_Academico::class, 'ID_Historial');
    }

    // Accesor para el estado
    public function getEstadoCompletoAttribute()
    {
        return match($this->presente) {
            'P' => 'Presente',
            'A' => 'Atraso',
            'L' => 'Licencia',
            'F' => 'Falta',
            default => 'Desconocido'
        };
    }

    // Accesor para clase CSS según estado
    public function getClaseEstadoAttribute()
    {
        return match($this->presente) {
            'P' => 'bg-green-100 text-green-800',
            'A' => 'bg-yellow-100 text-yellow-800',
            'L' => 'bg-blue-100 text-blue-800',
            'F' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}