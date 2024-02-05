<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $fillable = ['name','surname','id_passport','email','password','password_confirmation','role_id','status_id','share_link'];
    protected $table = 'users';

}
