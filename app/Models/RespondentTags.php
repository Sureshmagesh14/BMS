<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespondentTags extends Model
{
    use HasFactory;

    
    protected $table = 'respondent_tag';
    protected $fillable = ['respondent_id','tag_id'];
}
