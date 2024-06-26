<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;
    protected $fillable = ['name','type_id','survey_url','survey_id','sort_order','id'];
    protected $table = 'groups';
}
