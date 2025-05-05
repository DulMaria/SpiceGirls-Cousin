<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'password_reset_tokens';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'email',
        'token',
        'created_at',
        'expires_at',
    ];

    // Si no utilizas las columnas created_at y updated_at
    public $timestamps = false;
}
