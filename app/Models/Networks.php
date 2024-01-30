<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Networks extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'networks';
}
