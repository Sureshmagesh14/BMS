<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respondent_referrals extends Model
{
    use HasFactory;
    protected $table = 'respondent_referrals';

    protected $fillable = [
        'respondent_id',
        'referred_respondent_id',
        'user_id',
        // other fillable fields if any
    ];
}
