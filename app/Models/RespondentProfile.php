<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class RespondentProfile extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'respondent_profile';
}
