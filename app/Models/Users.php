<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Users extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','surname','id_passport','email','password','role_id','status_id','share_link'];
    protected $table = 'users';

    

}
