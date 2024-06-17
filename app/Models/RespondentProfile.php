<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RespondentProfile extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'respondent_profile';

    public static function get_education_level($id, $status)
    {
        $data = DB::table('respondent_profile')->where('respondent_id', '=', $id)->first();
        if (isset($data->essential_details)) {
            $get_status = json_decode($data->essential_details);
            $education_level = $get_status->education_level;

            if ($education_level == 'matric') {
                $education = 'Matric';
            } elseif ($education_level == 'post_matric_courses') {
                $education = 'Post Matric Courses / Higher Certificate';
            } elseif ($education_level == 'post_matric_diploma') {
                $education = 'Post Matric Diploma';
            } elseif ($education_level == 'ug') {
                $education = '  Undergrad University Degree';
            } elseif ($education_level == 'pg') {
                $education = 'Post Grad Degree - Honours, Masters, PhD, MBA';
            } elseif ($education_level == 'school_no_metric') {
                $education = 'School But No Matric';
            }else{
                $education = '';
            }

        } else {
            $education = '';
        }

        return $education;

    }
}
