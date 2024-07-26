<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use DB;
class Projects extends Model
{
    use HasFactory,SoftDeletes, Searchable;
    protected $fillable = ['id','number','client','name','user_id','type_id','reward','project_link','project_name_resp','status_id','description','description1','published_date','closing_date','access_id','survey_link'];
    protected $table = 'projects';

    public function toSearchableArray()
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'client' => $this->client
        ];
    }

    public static function get_user_name($userid){
        return User::where('id',$userid)->first();
    }

    public static function get_survey($id){
        return DB::table('survey')->where('id',$id)->first();
    }

}
