<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
class Tags extends Model
{
    use HasFactory, Searchable;
    use SoftDeletes;
    
    protected $fillable = ['id','name','colour'];
    protected $table = 'tags';

    public function toSearchableArray()
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'colour' => $this->colour,
        ];
    }

    public function respondents()
    {
        return $this->belongsToMany(Respondents::class, 'respondent_tag', 'tag_id', 'respondent_id');
    }
}
