<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvents extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','action','type','month','year','count'];
    protected $table = 'user_events';
}
