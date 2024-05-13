<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvents extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','role','action','type','month','year','count'];
    protected $table = 'user_events';

    public function users_data(){
        return $this->belongsTo(User::class,'user_id');
    }
}
