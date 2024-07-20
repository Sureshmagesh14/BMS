<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Questions extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'questions';

    protected $fillable = [
        'survey_id',
        'question_name',
        'qus_order_no',
        'question_description',
        'qus_template',
        'qus_type','survey_thankyou_page',
        'qus_ans', 'created_by'
    ];

}
