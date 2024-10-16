<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
class Users  extends Authenticatable 
{
    use HasFactory,SoftDeletes,Searchable;
    protected $guarded = ['id'];
    protected $fillable = ['name','surname','id_passport','email','password','role_id','status_id','share_link'];
    protected $hidden = ['password', 'remember_token',];
    protected $table = 'users';

    public function getAuthPassword()
    {
        return $this->password;
    }
    public function toSearchableArray()
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'surname' => $this->surname,
            'email'   => $this->email,
        ];
    }

}
