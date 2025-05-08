<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;
    
    // Nombre de la tabla si es diferente al nombre del modelo en plural
    protected $table = 'inscripcion';
    
    // Clave primaria
    protected $primaryKey = 'ID_Inscripcion';
    
    // Si el campo de ID no se incrementa automáticamente
    public $incrementing = true;
    
    // Si no usas los timestamps de Laravel (created_at y updated_at)
    public $timestamps = false;
    
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'fechaInscrip',
        'ID_Curso',
        'codigoEstudiantil'
    ];
    
    // Castings de los campos
    protected $casts = [
        'fechaInscrip' => 'date',
    ];
    
    // Relación con el modelo Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'ID_Curso');
    }
    
    // Relación con el modelo Estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'codigoEstudiantil', 'codigoEstudiantil');
    }
}