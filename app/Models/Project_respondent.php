<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_respondent extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','respondent_id','response_data','is_complete','is_frontend_complete','notified_at','created_at','updated_at'];
    protected $table = 'project_respondent';
    
}
