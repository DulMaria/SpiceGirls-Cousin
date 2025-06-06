<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'success',
        'failure_reason',
    ];

    /**
     * Get the user that owns the login log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
