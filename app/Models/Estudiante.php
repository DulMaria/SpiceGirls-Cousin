<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    // Nombre de la tabla
    protected $table = 'estudiante';

    // Clave primaria personalizada
    protected $primaryKey = 'codigoEstudiantil';

    // Laravel por defecto espera que la clave primaria sea un entero autoincremental
    // Como en este caso es un string (VARCHAR), se debe indicar que no es incrementable y que no es de tipo entero
    public $incrementing = false;
    protected $keyType = 'string';

    // Desactivar timestamps si no usas created_at y updated_at
    public $timestamps = false;

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'codigoEstudiantil',
        'nivelAcademico',
        'ID_Usuario',
    ];

    // Relaciones (opcional, si tienes una tabla Usuario relacionada)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'ID_Usuario');
    }
    // Relación con el modelo Inscripcion
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'codigoEstudiantil', 'codigoEstudiantil');
    }
}
