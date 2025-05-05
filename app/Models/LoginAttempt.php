<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $table = 'login_attempts';

    protected $fillable = [
        'email',
        'ip_address',
        'user_agent',
        'successful',
    ];
}
