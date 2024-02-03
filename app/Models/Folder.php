<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Folder extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'folders';

    protected $fillable = [
        'folder_name',
        'folder_type',
        'user_ids',
        'survery_count',
        'created_by'
    ];

    public function surveycount()
    {
        return $this->hasMany('App\Models\Survey', 'folder_id', 'id');
    }


}
