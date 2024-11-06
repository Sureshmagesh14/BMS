<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RespondentTags; 
class Respondents extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable, Searchable, SoftDeletes;

    protected $table = 'respondents';
    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token',];
    protected $fillable = ['name','surname','date_of_birth','id_passport','mobile','whatsapp','email','bank_name',
        'branch_code','account_type','account_holder','account_number','active_status_id','password','updated_at','referral_code','accept_terms','type','deactivated_date','opted_status'
    ];
    
    public function getAuthPassword()
    {
        return $this->password;
    }

    public static function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
        $pass = []; //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = random_int(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass); //turn the array into a string
    }

    public function toSearchableArray()
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'surname' => $this->surname,
            'email'   => $this->email,
            'mobile'  => $this->mobile
        ];
    }

    public static function get_respondend_survey($survey_id)
    {
        return DB::table('survey')->where('id', '=', $survey_id)->first();
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'respondent_tag', 'respondent_id', 'tag_id');
    }

    public static function percentage_calc($id){
        $resp_datas =  RespondentProfile::where('respondent_id', $id)->first();
            
        if(isset($resp_datas->basic_details) && ($resp_datas->basic_details!='')){

            $percent1 = $resp_datas->basic_details;
            $json_array  = json_decode($percent1, true);
            unset($json_array['updated_at']);
            $tot_count  = count($json_array);
            
            $fill_count =0;
            foreach ($json_array as $key => $value) {
                if (!strlen($value)) {
                    
                }else{
                    $fill_count ++;
                }
            }

            $percent1 = ($fill_count/$tot_count)*100;
            $percent1 = round($percent1);

        }else{
            $percent1 =0;
        }
            
        if(isset($resp_datas->essential_details) && ($resp_datas->essential_details!='')){

            $percent2 = $resp_datas->essential_details;
            
            $json_array  = json_decode($percent2, true);
            if($json_array['employment_status']=='working_and_studying' || $json_array['employment_status'] ==='emp_full_time' || $json_array['employment_status'] ==='emp_part_time' || $json_array['employment_status'] ==='self'){
                unset($json_array['employment_status_other'],$json_array['industry_my_company_other'],$json_array['updated_at']);
            }else{
                unset($json_array['employment_status_other'],$json_array['industry_my_company_other'],$json_array['job_title'],$json_array['industry_my_company'],$json_array['updated_at']);
            }
            
            $tot_count  = count($json_array);
         
            $fill_count =0;
            foreach ($json_array as $key => $value) {
                if (!strlen($value)) {
                    
                }else{
                    $fill_count ++;
                }
            }

            $percent2 = ($fill_count/$tot_count)*100;
            $percent2 = round($percent2);


        }else{
            $percent2 =0;
        }

        if (isset($resp_datas->extended_details) && !empty($resp_datas->extended_details)) {

            // Decode 'extended_details' and 'essential_details'
            $json_array = json_decode($resp_datas->extended_details, true);
            $essential_details = $resp_datas->essential_details;
            $json_arr = json_decode($essential_details, true);
        
            // Perform unsetting based on employment status
            if (isset($json_arr['employment_status']) && $json_arr['employment_status'] === 'working_and_studying' || $json_arr['employment_status'] ==='emp_full_time' || $json_arr['employment_status'] ==='emp_part_time' || $json_arr['employment_status'] ==='self') {
                unset(
                    $json_array['bank_main_other'],
                    $json_array['home_lang_other'],
                    $json_array['business_org_other'],
                    $json_array['bank_secondary_other'],
                    $json_array['secondary_home_lang_other'],
                    $json_array['updated_at'],
                );
            } else {
                unset(
                    $json_array['bank_main_other'],
                    $json_array['home_lang_other'],
                    $json_array['business_org_other'],
                    $json_array['bank_secondary_other'],
                    $json_array['secondary_home_lang_other'],
                    $json_array['business_org'],
                    $json_array['org_company'],
                    $json_array['updated_at'],
                );
            }
        
            // Calculate the total and filled count
            $tot_count = count($json_array);
            $fill_count = 0;
        
            foreach ($json_array as $value) {
                if (!empty($value)) {
                    $fill_count++;
                }
            }
        
            // Calculate the percentage of filled values
            $percent3 = ($tot_count > 0) ? round(($fill_count / $tot_count) * 100) : 0;
        
        } else {
            // Handle the case where 'extended_details' is not set or is empty
            $percent3 = 0;
        }

        $fully_completed = ($percent1 + $percent2 + $percent3) / 3;

        $array_send = array(
            'full'     => $fully_completed,
            'percent1' => $percent1,
            'percent2' => $percent2,
            'percent3' => $percent3
        );

        return $array_send;
    }

    public function respondentTags()
{
    return $this->hasMany(RespondentTags::class, 'respondent_id', 'id');
}
}
