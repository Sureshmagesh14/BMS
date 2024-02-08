<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Survey extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'survey';

    protected $fillable = [
        'title',
        'folder_id',
        'visited_count',
        'started_count',
        'completed_count',
        'qus_count',
        'avg_completion_time',
        'builderID',
        'created_by'
    ];
    public function questions()
    {
        return $this->hasMany('App\Models\Questions', 'survey_id', 'id');
    }


}
