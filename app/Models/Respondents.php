<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Respondents extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable, Searchable, SoftDeletes;

    protected $table = 'respondents';
    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token',];
    protected $fillable = ['name','surname','date_of_birth','id_passport','mobile','whatsapp','email','bank_name',
        'branch_code','account_type','account_holder','account_number','active_status_id','password','updated_at','referral_code','accept_terms','type'
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

    public function toSearchableArray()
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'surname' => $this->surname,
            'email'   => $this->email,
            'mobile'  => $this->mobile
        ];
    }

    public static function get_respondend_survey($survey_id)
    {
        return DB::table('survey')->where('id', '=', $survey_id)->first();
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'respondent_tag', 'respondent_id', 'tag_id');
    }
}
