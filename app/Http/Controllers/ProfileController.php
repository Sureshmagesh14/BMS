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
           
            $state = DB::table('state')->whereNull('deleted_at')->get();
            $industry_company = DB::table('industry_company')->whereNull('deleted_at')->get();
            $income_per_month = DB::table('income_per_month')->whereNull('deleted_at')->get();
            $banks = Banks::whereNull('deleted_at')->where('active',1)->get();
            $profile = RespondentProfile::where('respondent_id',$resp_id)->first();

            if($profile != null){
                $pid = $profile->pid;
            }
            else{
                $get_pid = RespondentProfile::orderBy('pid','DESC')->first();
                $pid = ($get_pid != null) ? $get_pid->pid+1 : 1;
            }

            $profile_data = ($profile != null) ? json_decode($profile->profile_data, true) : array();
          
            return view('user.profile_wizard', compact('pid','resp_details','state','industry_company','income_per_month','banks', 'profile_data'));
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
        $unique_id = $request->get_unique_id;
        $resp_id   = Session::get('resp_id');
        $parse_array = array();
        parse_str($request->serialize_data, $parse_array);

        $total_ques = count($parse_array);
        $total_ans  = count(array_filter($parse_array));

        if($steps == 1){
            $resp_save = array(
                'name'          => $parse_array['first_name'],
                'surname'       => $parse_array['last_name'],
                'date_of_birth' => $parse_array['date_of_birth'],
                'email'         => $parse_array['email'],
                'mobile'        => $parse_array['mobile_number'],
                'whatsapp'      => $parse_array['whatsapp_number']
            );

            Respondents::where('id',$resp_id)->update($resp_save);

            $step_word = "Basic Details Updated";
        }
        else{
            $profile_data = array(
                'pid' => $parse_array['unique_id'],
                'respondent_id' => $resp_id,
                'profile_data' => json_encode($parse_array),
            );

            if($total_ques == $total_ans){
                $profile_data['profile_completion'] = 1;
            }
            
            if(RespondentProfile::where('id',$resp_id)->doesntExist()){
                RespondentProfile::insert($profile_data);
                $step_word = ($steps == 2) ? "Essential Details Added" : "Extended Details Added";
            }
            else{
                RespondentProfile::where('respondent_id',$resp_id)->update($profile_data);
                $step_word = ($steps == 2) ? "Essential Details Updated" : "Extended Details Updated";
            }
        }

        return response()->json([
            'status'  => 200,
            'success' => true,
            'message' => $step_word. ' Successfully'
        ]);
    }
}
