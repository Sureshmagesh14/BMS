<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Session;
use DB;
use Yajra\DataTables\DataTables;
use App\Models\Respondents;
use App\Models\Contents;
use App\Models\Groups;
use App\Models\Projects;
use App\Models\Banks;
use App\Models\Rewards;
use App\Models\RespondentProfile;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Facades\Hash;
use Exception;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateprofile_wizard(Request $request){
        try {
            
            $resp_id   = Session::get('resp_id');
            $resp_name = Session::get('resp_name');
            $resp_details = Respondents::select('id','name','surname','date_of_birth','email','mobile','whatsapp')->find($resp_id);
            $children_set = 0;
            $vehicle_set = 0;

            $get_date = Respondents::select('date_of_birth')->where('id',$resp_id)->first();
            $get_year = ($get_date->date_of_birth != null) ? date('Y',strtotime($get_date->date_of_birth)) : date('Y',strtotime(1990));
           
            $state = DB::table('state')->whereNull('deleted_at')->get();
            $industry_company = DB::table('industry_company')->whereNull('deleted_at')->get();
            $income_per_month = DB::table('income_per_month')->whereNull('deleted_at')->get();
            $banks = Banks::whereNull('deleted_at')->where('active',1)->get();
            $profile = RespondentProfile::where('respondent_id',$resp_id)->first();
            $vehicle_master = DB::table('vehicle_master')->whereNull('deleted_at')->get();

            if($profile != null){
                $pid = $profile->pid;
            }
            else{
                $get_pid = RespondentProfile::orderBy('pid','DESC')->first();
                $pid = ($get_pid != null) ? $get_pid->pid+1 : 1;
            }

            $essential_details = ($profile != null) ? (($profile->essential_details != null) ? json_decode($profile->essential_details, true) : array()) : array();
            $extended_details  = ($profile != null) ? (($profile->extended_details != null) ? json_decode($profile->extended_details, true) : array()) : array();
            $child_details     = ($profile != null) ? (($profile->children_data != null) ? json_decode($profile->children_data, true) : array()) : array();
            $vehicle_details   = ($profile != null) ? (($profile->vehicle_data != null) ? json_decode($profile->vehicle_data, true) : array()) : array();

            $get_suburb = (isset($essential_details['province'])) ? DB::table('district')->where('type',$essential_details['province'])->whereNull('deleted_at')->orderBy('district','ASC')->get() : array();
            $get_area  = (isset($essential_details['suburb'])) ? DB::table('metropolitan_area')->where('district_id',$essential_details['suburb'])->whereNull('deleted_at')->orderBy('area','ASC')->get() : array();

            $check_basic = ($profile != null) ? (($profile->basic_details != null) ? json_decode($profile->basic_details, true) : array()) : array();
            $check_ess   = ($profile != null) ? (($profile->essential_details != null) ? json_decode($profile->essential_details, true) : array()) : array();
            $check_ext   = ($profile != null) ? (($profile->extended_details != null) ? json_decode($profile->extended_details, true) : array()) : array();

            unset($check_ess['employment_status_other'],$check_ess['industry_my_company_other']);
            unset($check_ext['bank_main_other'],$check_ext['home_lang_other'], $check_ext['business_org_other']);

            if(count($check_basic) > 0 && count($check_ess) > 0 && count($check_ext) > 0){
                if(count($check_basic) == count(array_filter($check_basic)) && count($check_ess) == count(array_filter($check_ess)) && count($check_ext) == count(array_filter($check_ext))){
                    Respondents::where('id',$resp_id)->update(['profile_completion_id' => 1]);
                }
                else{
                    Respondents::where('id',$resp_id)->update(['profile_completion_id' => 0]);
                }
            }
            else{
                Respondents::where('id',$resp_id)->update(['profile_completion_id' => 0]);
            }

            if($profile != null){
                if($profile->children_data == null){
                    $children_set = (isset($essential_details['no_children'])) ? (($essential_details['no_children'] != "") ? $essential_details['no_children'] : 0) : 0;
                }

                if($profile->vehicle_data == null){
                    $vehicle_set = (isset($essential_details['no_vehicle'])) ? (($essential_details['no_vehicle'] != "") ? $essential_details['no_vehicle'] : 0) : 0;
                }
            }
    
            return view('user.profile_wizard', compact('pid','resp_details','state','industry_company','income_per_month','banks','essential_details','extended_details','get_suburb','get_area','child_details','vehicle_details','vehicle_master','get_year','children_set','vehicle_set'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function get_suburb(Request $request){
        $province = $request->province;
        $suburb = DB::table('district')->where('type',$province)->whereNull('deleted_at')->orderBy('district','ASC')->get();
        $options = "";

        $options .= "<option value=''>Select</option>";
        foreach($suburb as $sub){
            $options .= "<option value='".$sub->id."'> ".$sub->district." </option>";
        }

        return array(
            'type' => true,
            'data' => $options
        );
    }

    public function get_area(Request $request){
        $suburb = $request->suburb;
        $areas  = DB::table('metropolitan_area')->where('district_id',$suburb)->whereNull('deleted_at')->orderBy('area','ASC')->get();
        $options = "";

        $options .= "<option value=''>Select</option>";
        foreach($areas as $area){
            $options .= "<option value='".$area->id."'> ".$area->area." </option>";
        }

        return array(
            'type' => true,
            'data' => $options
        );
    }

    public function profile_save(Request $request){
        $steps = $request->step;
        $resp_id = Session::get('resp_id');
        $parse_array = array();
        parse_str($request->serialize_data, $parse_array);
        $unique_id = $parse_array['unique_id'];

        $basic_details     = json_encode($parse_array['basic']);
        $essential_details = json_encode($parse_array['essential']);
        $extended_details  = json_encode($parse_array['extended']);

        if($steps == 1){
            $resp_save = array(
                'name'          => $parse_array['basic']['first_name'],
                'surname'       => $parse_array['basic']['last_name'],
                'date_of_birth' => $parse_array['basic']['date_of_birth'],
                'email'         => $parse_array['basic']['email'],
                'mobile'        =>  str_replace(' ', '', $parse_array['basic']['mobile_number']),
                'whatsapp'      => str_replace(' ', '', $parse_array['basic']['whatsapp_number'])
            );
         
            Respondents::where('id',$resp_id)->update($resp_save);

            $basic_data = array(
                'pid'           => $unique_id,
                'respondent_id' => $resp_id,
                'basic_details' => $basic_details,
            );

            if(RespondentProfile::where('respondent_id',$resp_id)->doesntExist()){
                RespondentProfile::insert($basic_data);
            }
            else{
                RespondentProfile::where('respondent_id',$resp_id)->update($basic_data);
            }
            
            $step_word = "Basic Details Updated";
        }
        else{
            $profile_data = array(
                'pid'               => $unique_id,
                'respondent_id'     => $resp_id,
                'essential_details' => $essential_details,
                'extended_details'  => $extended_details,
            );

            if(isset($request->child_val)){
                $profile_data['children_data'] = json_encode($request->child_val);
            }

            if(isset($request->vehicle_val)){
                $profile_data['vehicle_data'] = json_encode($request->vehicle_val);
            }

            // if($total_ques == $total_ans){
            //     $profile_data['profile_completion'] = 1;
            // }
            
            if(RespondentProfile::where('respondent_id',$resp_id)->doesntExist()){
                RespondentProfile::insert($profile_data);
                $step_word = ($steps == 2) ? "Essential Details Added" : "Extended Details Added";
            }
            else{
                RespondentProfile::where('respondent_id',$resp_id)->update($profile_data);
                $step_word = ($steps == 2) ? "Essential Details Updated" : "Extended Details Updated";
            }
        }

        $profile = RespondentProfile::where('respondent_id',$resp_id)->first();

        $check_basic = ($profile != null) ? (($profile->basic_details != null) ? json_decode($profile->basic_details, true) : array()) : array();
        $check_ess   = ($profile != null) ? (($profile->essential_details != null) ? json_decode($profile->essential_details, true) : array()) : array();
        $check_ext   = ($profile != null) ? (($profile->extended_details != null) ? json_decode($profile->extended_details, true) : array()) : array();

        unset($check_ess['employment_status_other'],$check_ess['industry_my_company_other']);
        unset($check_ext['bank_main_other'],$check_ext['home_lang_other'], $check_ext['business_org_other']);

        if(count($check_basic) > 0 && count($check_ess) > 0 && count($check_ext) > 0){
            if(count($check_basic) == count(array_filter($check_basic)) && count($check_ess) == count(array_filter($check_ess)) && count($check_ext) == count(array_filter($check_ext))){
                Respondents::where('id',$resp_id)->update(['profile_completion_id' => 1]);
            }
            else{
                Respondents::where('id',$resp_id)->update(['profile_completion_id' => 0]);
            }
        }
        else{
            Respondents::where('id',$resp_id)->update(['profile_completion_id' => 0]);
        }
       
        return response()->json([
            'status'  => 200,
            'success' => true,
            'message' => $step_word. ' Successfully'
        ]);
    }
}
