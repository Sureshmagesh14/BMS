<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualifiedRespondent extends Model
{
    use HasFactory;
    protected $table = 'qualified_respondent';

    protected $fillable = [
        'respondent_id',
        'project_id',
        'status',
        'points',
        'created_at'
    ];

}
