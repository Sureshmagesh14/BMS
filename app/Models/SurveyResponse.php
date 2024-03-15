<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SurveyResponse extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'survey_response';
    protected $fillable = ['survey_id','response_user_id','question_id','answer','skip' ];
    
   
}
