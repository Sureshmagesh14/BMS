<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetsViaPhone extends Model
{
    use HasFactory;
    protected $table = 'password_reset_tokens_via_phone';

    protected $fillable = [
        'phone',
        'token',
        'created_at',
        // other fillable fields if any
    ];
}
