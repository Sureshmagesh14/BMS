<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SurveyQuotas extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'survey_quotas';

    protected $fillable = [
        'survey_id',
        'quota_name',
        'quota_limit',
        'question_id',
        'option_type',
        'option_value', 'created_by','redirection_qus'
    ];

}
