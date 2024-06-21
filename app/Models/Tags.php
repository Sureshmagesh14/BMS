<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
class Tags extends Model
{
    use HasFactory,SoftDeletes, Searchable;
    protected $fillable = ['name','colour'];
    protected $table = 'tags';

    public function toSearchableArray()
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'colour' => $this->colour,
        ];
    }
}
