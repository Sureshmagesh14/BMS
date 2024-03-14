<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Respondents extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'respondents';
    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token',];
    protected $fillable = ['name','surname','date_of_birth','id_passport','mobile','whatsapp','email','bank_name',
        'branch_code','account_type','account_holder','account_number','active_status_id','password','updated_at','referral_code','accept_terms'
    ];
    
    public function getAuthPassword()
    {
        return $this->password;
    }

    public static function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
        $pass = []; //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = random_int(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass); //turn the array into a string
    }
}
