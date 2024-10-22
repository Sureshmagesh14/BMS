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
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Config;
use App\Models\Project_respondent;
use App\Mail\Respondentprojectmail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

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

                    // Get the selected personal income from the request
        

            if($profile != null){
                $pid = $profile->pid;
            }
            else{
                $get_pid = RespondentProfile::orderBy('pid','DESC')->first();
                $pid = ($get_pid != null) ? $get_pid->pid+1 : 1;
            }
            $basic_details = ($profile != null) ? (($profile->basic_details != null) ? json_decode($profile->basic_details, true) : array()) : array();
            $essential_details = ($profile != null) ? (($profile->essential_details != null) ? json_decode($profile->essential_details, true) : array()) : array();
            $extended_details  = ($profile != null) ? (($profile->extended_details != null) ? json_decode($profile->extended_details, true) : array()) : array();
            $child_details     = ($profile != null) ? (($profile->children_data != null) ? json_decode($profile->children_data, true) : array()) : array();
            $vehicle_details   = ($profile != null) ? (($profile->vehicle_data != null) ? json_decode($profile->vehicle_data, true) : array()) : array();

            $get_suburb = (isset($essential_details['province'])) ? DB::table('district')->where('type',$essential_details['province'])->whereNull('deleted_at')->orderBy('district','ASC')->get() : array();
            $get_area  = (isset($essential_details['suburb'])) ? DB::table('metropolitan_area')->where('district_id',$essential_details['suburb'])->whereNull('deleted_at')->orderBy('area','ASC')->get() : array();

            $check_basic = ($profile != null) ? (($profile->basic_details != null) ? json_decode($profile->basic_details, true) : array()) : array();
            $check_ess   = ($profile != null) ? (($profile->essential_details != null) ? json_decode($profile->essential_details, true) : array()) : array();
            $check_ext   = ($profile != null) ? (($profile->extended_details != null) ? json_decode($profile->extended_details, true) : array()) : array();

         

            $fully_completed = $resp_details->percentage_calc($resp_id);
            $completion_status = ($fully_completed['full'] >= 100) ? 1 : 0;
           
            if(count($check_basic) > 0 && count($check_ess) > 0 && count($check_ext) > 0){
                if(count($check_basic) == count(array_filter($check_basic)) && count($check_ess) == count(array_filter($check_ess)) && count($check_ext) == count(array_filter($check_ext))){
                    Respondents::where('id',$resp_id)->update(['profile_completion_id' => 1]);
                }
                else{
                    Respondents::where('id',$resp_id)->update(['profile_completion_id' => $completion_status]);
                }
            }
            else{
                Respondents::where('id',$resp_id)->update(['profile_completion_id' => $completion_status]);
            }
            // Create an associative array for income ranges
            $incomeRanges = $income_per_month->pluck('income', 'id')->toArray();
           
            if ($profile !== null && isset($profile->essential_details)) {
                $essential_details = json_decode($profile->essential_details, true);
            } else {
                // Handle the case where $profile is null or $essential_details is not set
                $essential_details = null; // or set a default value, or handle the error
            }
            
        
            // Get the selected personal income id
            $selectedPersonalIncomeId = $essential_details['personal_income_per_month'] ?? null;
        
            // Extract the personal income value
            $personalIncomeValue = $income_per_month->where('id', $selectedPersonalIncomeId)->first() ?? 0;

            if($profile != null){
                if($profile->children_data == null){
                    $children_set = (isset($essential_details['no_children'])) ? (($essential_details['no_children'] != "") ? $essential_details['no_children'] : 0) : 0;
                }

                if($profile->vehicle_data == null){
                    $vehicle_set = (isset($essential_details['no_vehicle'])) ? (($essential_details['no_vehicle'] != "") ? $essential_details['no_vehicle'] : 0) : 0;
                }
            }

            $resp_datas =  RespondentProfile::where('respondent_id', $resp_id)->first();
            

            if(isset($resp_datas->basic_details) && ($resp_datas->basic_details!='')){

                $percent1 = $resp_datas->basic_details;
                $json_array  = json_decode($percent1, true);
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
                unset($json_array['employment_status_other'],$json_array['industry_my_company_other']);
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

            if(isset($resp_datas->extended_details) && ($resp_datas->extended_details!='')){

                $percent3 = $resp_datas->extended_details;
                $json_array  = json_decode($percent3, true);
                unset($json_array['bank_main_other'],$json_array['home_lang_other'], $json_array['business_org_other']);

                $tot_count  = count($json_array);
           
                $fill_count =0;
                foreach ($json_array as $key => $value) {
                    if (!strlen($value)) {
                       
                    }else{
                        $fill_count ++;
                    }
                }

                $percent3 = ($fill_count/$tot_count)*100;
                $percent3 = round($percent3);

            }else{
                $percent3 =0;
            }
            // Default page value
            $page = 1;

            // Check if the section parameter is provided
            if ($request->section) {
                switch ($request->section) {
                    case 'basic':
                        $page = 0;
                        break;
                    case 'essential':
                        $page = 1;
                        break;
                    case 'extended':
                        $page = 2;
                        break;
                }
            } else {
                // If section is not provided, determine the page based on percentages
                if ($percent1 == '100.0' && $percent2 == '100.0' && $percent3 == '100.0') {
                    $page = 0;
                } elseif ($percent1 == '100.0' && $percent2 < '100.0' && $percent3 == '100.0') {
                    $page = 1;
                } elseif ($percent1 == '100.0' && $percent3 < '100.0' && $percent2 == '100.0') {
                    $page = 2;
                } elseif ($percent2 == '100.0' && $percent1 < '100.0' && $percent3 == '100.0') {
                    $page = 0;
                }
                // Default value is already set to 0, so no need to set it here
            }

            // The resulting value of $page is ready to be used


           
            
            

        
           




  
            return view('user.profile_wizard', compact('pid','resp_details','state','industry_company','income_per_month','banks','essential_details','extended_details','get_suburb','get_area','child_details','vehicle_details','vehicle_master','get_year','children_set','vehicle_set', 'personalIncomeValue','incomeRanges','page','basic_details'));
        }
        catch (Exception $e) {
            $lineNumber = $e->getLine(); // Get the line number where the exception was thrown
    $message = $e->getMessage(); // Get the original exception message
    throw new Exception("Error on line $lineNumber: $message");
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
        $resp_details = Respondents::find($resp_id);
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
                'updated_at'    => now() 
            );

            if(RespondentProfile::where('respondent_id',$resp_id)->doesntExist()){
                RespondentProfile::insert($basic_data);
            }
            else{
                $current_profile = RespondentProfile::where('respondent_id', $resp_id)->first();
                $current_basic_details = $current_profile->basic_details;
                $current_basic_array = json_decode($current_basic_details, true);
                $new_basic_array = json_decode($basic_details, true);
        
                if ($current_basic_array != $new_basic_array) {
                    $new_basic_array['updated_at'] = date('Y-m-d H:i:s'); // update the updated_at field
                    $basic_details = json_encode($new_basic_array);
                    RespondentProfile::where('respondent_id',$resp_id)->update([
                        'basic_details' => $basic_details,
                    ]);
                }
              
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

            // $profile_data = [];
            if(isset($request->child_val)){
                $profile_data['children_data'] = json_encode($request->child_val);
            }

            if(isset($request->vehicle_val)){
                $profile_data['vehicle_data'] = json_encode($request->vehicle_val);
            }

            // Define default values to prevent undefined index warnings

            $vehicle_data = isset($profile_data['vehicle_data']) ? $profile_data['vehicle_data'] : null;
            $children_data = isset($profile_data['children_data']) ? $profile_data['children_data'] : null;
       
            // if($total_ques == $total_ans){
            //     $profile_data['profile_completion'] = 1;
            // }
            
            if(RespondentProfile::where('respondent_id',$resp_id)->doesntExist()){
                RespondentProfile::insert($profile_data);
                $step_word = ($steps == 2) ? "Essential Details Added" : "Extended Details Added";
            }
            else{

              
                $current_profile = RespondentProfile::where('respondent_id', $resp_id)->first();
                $current_essential_details = $current_profile->essential_details;
                $current_essential_array = json_decode($current_essential_details, true);
                $new_essential_array = json_decode($essential_details, true);
        
                if ($current_essential_array != $new_essential_array) {
                    $new_essential_array['updated_at'] = date('Y-m-d H:i:s'); // update the updated_at field
                    $essential_details = json_encode($new_essential_array);
                    RespondentProfile::where('respondent_id',$resp_id)->update([
                        'essential_details' => $essential_details,
                        
                    ]);
                }

             
                $current_extended_details = $current_profile->extended_details;
                $current_extended_array = json_decode($current_extended_details, true);
                $new_extended_array = json_decode($extended_details, true);
        
                if ($current_extended_array != $new_extended_array) {
                    $new_extended_array['updated_at'] = date('Y-m-d H:i:s'); // update the updated_at field
                    $extended_details = json_encode($new_extended_array);
                    RespondentProfile::where('respondent_id',$resp_id)->update([
                        'extended_details' => $extended_details,
                        'vehicle_data' => $vehicle_data ?? $current_profile->vehicle_data,
                        'children_data' => $children_data ?? $current_profile->children_data,
                    ]);
                }
                $step_word = ($steps == 2) ? "Essential Details Updated" : "Extended Details Updated";
            }
        }
       
        $profile = RespondentProfile::where('respondent_id',$resp_id)->first();

        $check_basic = ($profile != null) ? (($profile->basic_details != null) ? json_decode($profile->basic_details, true) : array()) : array();
        $check_ess   = ($profile != null) ? (($profile->essential_details != null) ? json_decode($profile->essential_details, true) : array()) : array();
        $check_ext   = ($profile != null) ? (($profile->extended_details != null) ? json_decode($profile->extended_details, true) : array()) : array();

      

        $fully_completed = $resp_details->percentage_calc($resp_id);
        // dd($fully_completed);
        $completion_status = ($fully_completed['full'] >= 100) ? 1 : 0;
        if(count($check_basic) > 0 && count($check_ess) > 0 && count($check_ext) > 0){
            if(count($check_basic) == count(array_filter($check_basic)) && count($check_ess) == count(array_filter($check_ess)) && count($check_ext) == count(array_filter($check_ext))){
                Respondents::where('id',$resp_id)->update(['profile_completion_id' => 1]);
            }
            else{
                Respondents::where('id',$resp_id)->update(['profile_completion_id' => $completion_status]);
            }
        }
        else{
            Respondents::where('id',$resp_id)->update(['profile_completion_id' => $completion_status]);
        }
       
        return response()->json([
            'status'  => 200,
            'success' => true,
            'message' => $step_word. ' Successfully'
        ]);
    }

    public function emailChangeOtpSend(Request $request){
        try {
            $resp_id = Session::get('resp_id');
            $getResp =  Respondents::select('mobile','whatsapp')->where('id',$resp_id)->first();

            if($getResp != null){
                // Clean and validate phone number
                $phone = str_replace(' ', '', $getResp->mobile);
                
                // Ensure phone number contains only digits
                if (!ctype_digit($phone)) {
                    return redirect()->route('updateprofile_wizard')->with('error', 'Invalid phone number format');
                }

                // Validate phone number length (less than or equal to 9 digits)
                if (strlen($phone) > 9) {
                    return redirect()->route('updateprofile_wizard')->with('error', 'Invalid phone number format: Must be 9 digits or less');
                }

                $otp = random_int(100000, 999999);
                // Prepare SMS content
                $smsContent = "Reset Password Notification\n\n";
                $smsContent .= "OTP: $otp.\n";
                $smsContent .= "If you did not change the email, no further action is required.\n";
                $smsContent .= "This OTP will expire in 60 minutes.";
                
                Respondents::where('id',$resp_id)->update(['email_or_phone_change_otp' => $otp]);

                // Parameters for the SMS
                $postData = [
                    'username' => config('constants.username'),
                    'password' => config('constants.password'),
                    'account'  => config('constants.account'),
                    'da'       => config('constants.phone') . $phone, // Destination number with country code
                    'ud'       => $smsContent, // SMS content
                ];

                // Initialize cURL session
                $curl = curl_init();

                // Set cURL options
                curl_setopt_array($curl, [
                    CURLOPT_URL => 'http://apihttp.pc2sms.biz/submit/single/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => http_build_query($postData),
                ]);

                // Execute cURL session
                $response = curl_exec($curl);

                // Check for cURL execution errors
                if ($response === false) {
                    throw new Exception(curl_error($curl), curl_errno($curl));
                }

                // Close cURL session
                curl_close($curl);

                // Log the full response for debugging
                // Log::info('SMS API Response: ' . $response);

                // Check if response indicates success
                if (strpos($response, 'Accepted for delivery') !== false) {
                    return view('user.email_chage_otp');
                }
                else {
                    return redirect()->route('updateprofile_wizard')->with('error', 'Failed to send SMS! Please try after sometime');
                    throw new Exception('Failed to send SMS. API response: ' . $response);
                }
            }
        }
        catch (Exception $e) {
            // Log the exception with more details
            Log::error('SMS API Error: ' . $e->getMessage() . ' - Code: ' . $e->getCode());
    
            return redirect()->route('updateprofile_wizard')->with('error', 'Failed to send SMS! Please try after sometime');
        }
    }

    public function emailChangeOtpCheck(Request $request){
        (int) $otp = $request->otp;

        $resp_id = Session::get('resp_id');
        $getResp =  Respondents::where('id',$resp_id)->where('email_or_phone_change_otp',$otp)->first();
        
        if($getResp != null){
            Respondents::where('id',$resp_id)->update(['email_or_phone_change_otp' => 0]);
            return 1;
        }
        else{
            return 0;
        }
    }

    public function emailChange(Request $request){
        $resp_id = Session::get('resp_id');
        $email_id = $request->email_id;
        Respondents::where('id',$resp_id)->update(['email' => $email_id]);

        return redirect()->route('updateprofile_wizard')->with('status', 'Email ID Changed!');
    }

    public function mobileChangeOtpSend(Request $request){
        try {

            $resp_id = Session::get('resp_id');
            $otp = random_int(100000, 999999);
            Respondents::where('id',$resp_id)->update(['email_or_phone_change_otp' => $otp]);

            $get_email  = Respondents::where('id', $resp_id)->first();
            $to_address = $get_email->email;

            $data = ['subject' => 'OTP for mobile number change','type' => 'mobile_change_otp', 'otp' => $get_email->email_or_phone_change_otp];

            Mail::to($to_address)->send(new WelcomeEmail($data));
          
            return view('user.mobile_change_otp');
    
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function mobileChange(Request $request){
        $resp_id = Session::get('resp_id');
        $phone_no = $request->phone_no;
        Respondents::where('id',$resp_id)->update(['mobile' => $phone_no]);

        return redirect()->route('updateprofile_wizard')->with('status', 'Mobile Changed!');
    }
}
