<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SurveyHistory extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'survey_history';
    protected $fillable = ['respondent_id','survey_id','status' ];
    
   
}
