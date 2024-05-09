<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banks extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['bank_name','branch_code','active'];
    protected $table = 'banks';
}
