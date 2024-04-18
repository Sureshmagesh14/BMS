<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Projects extends Model
{
    use HasFactory,SoftDeletes, Searchable;
    protected $fillable = ['number','client','name','user_id','type_id','reward','project_link','status_id','description','description1','description2','survey_duration','published_date','closing_date','access_id','survey_link'];
    protected $table = 'projects';

    public function toSearchableArray()
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'client' => $this->client
        ];
    }
}
