<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Models\UserEvents;
use App\Models\Respondents;
use App\Models\RespondentProfile;
use DB;
use Session;
use Exception;
use Hash;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
class AdminLoginController extends Controller
{

    protected $redirectTo = '/admin/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        //$this->middleware('guest:admin')->except('logout');
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function showLoginForm(){
        try {
        
            return view('admin.auth.login');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function forgot_password(){
        try {
            return view('admin.auth.admin-forgot-password');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (\Auth::guard('admin')->attempt($request->only(['email','password']), $request->get('remember'))){

            if(isset($request->remember) && !empty($request->remember)){
                setcookie("email",$request->email,time()+3600);
                setcookie("password",$request->password,time()+3600);
            }
            else{
                setcookie("email","");
                setcookie("password","");
            }

            return redirect()->route('admin.dashboard');
        }

        if (!Users::where('email', $request->email)->first()) {
            return back()->with('error','Invalid Username or Password');
        }
        
        if (!Users::where('email', $request->email)->where('password', bcrypt($request->password))->first()) {
            $mess= strip_tags("<strong>Incorrect Password.</strong>");
            return back()->with('pass_error',$mess);
        }

       
    }

    public function admin_dashboard(Request $request){
        try {
            try {
                $active_val   = DB::table('respondents')->where("active_status_id",1)->count();
                $deactive_val = DB::table('respondents')->where("active_status_id",2)->count();
                $unsub_val    = DB::table('respondents')->where("active_status_id",3)->count();
                $pending_val  = DB::table('respondents')->where("active_status_id",4)->count();
                $black_val    = DB::table('respondents')->where("active_status_id",5)->count();
                $complete = DB::table('respondents')->where("profile_completion_id",1)->count();
                $incomplete = DB::table('respondents')->where("profile_completion_id",0)->count();
                $tot=$complete+$incomplete;
               
                $act_per= ($tot > 0) ? number_format( $active_val/$tot * 100, 2 ) . ' %' : 0;
              

                $dec_per=($tot > 0) ? number_format( $deactive_val/$tot * 100, 2 ) . ' %' : 0;
            

                $unsub_per=($tot > 0) ? number_format( $unsub_val/$tot * 100, 2 ) . ' %' : 0;
          

                $pen_per=($tot > 0) ? number_format( $pending_val/$tot * 100, 2 ) . ' %' : 0;
               

                $bla_per=($tot > 0) ? number_format( $black_val/$tot * 100, 2 ) . ' %' : 0;
                

                $comp_per=($tot > 0) ? number_format( $complete/$tot * 100, 2 ) . ' %' : 0;
              
                $incomp_per=($tot > 0) ? number_format( $incomplete/$tot * 100, 2 ) . ' %' : 0;

                $share_link  = DB::table('users')->select('share_link')->where("id",Auth::guard('admin')->user()->id)->first();
               
                
                $from = date("2023-m-01");
                $to = date("2023-12-d");
                
                $all_datas = DB::table('users as u')
                ->select('u.id', 'u.name', 'u.surname')
                ->selectSub(function ($query) {
                    $query->select(DB::raw('count(*)'))
                          ->from('user_events')
                          ->whereColumn('user_events.user_id', 'u.id')
                          ->where('user_events.action', '=', 'created')
                          ->where('user_events.type', '=', 'respondent');
                }, 'createCount')
                ->selectSub(function ($query) {
                    $query->select(DB::raw('count(*)'))
                          ->from('user_events')
                          ->whereColumn('user_events.user_id', 'u.id')
                          ->where('user_events.action', '=', 'updated')
                          ->where('user_events.type', '=', 'respondent');
                }, 'updateCount')
                ->selectSub(function ($query) {
                    $query->select(DB::raw('count(*)'))
                          ->from('user_events')
                          ->whereColumn('user_events.user_id', 'u.id')
                          ->where('user_events.action', '=', 'deactivated')
                          ->where('user_events.type', '=', 'respondent');
                }, 'deactCount')
                ->get();
                
                // $all_datas = DUsers::select('users.id','users.name', 'users.surname', 'user_events.*')
                // ->join('user_events', 'user_events.user_id', 'users.id')
                // ->orderby("user_events.id", "desc")
                // ->where('type', '=', 'respondent');
                // if($from != null && $to != null){
                //     $all_datas = $all_datas->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                // }
                // $all_datas = $all_datas->groupBy('user_events.user_id');
                // $all_datas = $all_datas->get();

                // $total_created = Users::select('users.name', 'users.surname', 'user_events.*')
                //     ->join('user_events', 'user_events.user_id', 'users.id')
                //     ->orderby("user_events.id", "desc")
                //     ->where("user_events.action", "created")
                //     ->where('type', '=', 'respondent');

                // if($from != null && $to != null){
                //     $total_created = $total_created->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                // }
                //$total_created = $total_created->groupBy('user_events.user_id');
                //$total_created = $total_created->get()->count();
                
                // $dashboard_data = array();
                // foreach ($all_datas as $all_data) {

                //     $newdata =  array (
                //         'id' => $all_data->id,
                //         'name' => $all_data->name . " " . $all_data->surname,
                //         'createCount' => $all_data->createCount,
                //         'updateCount' => $all_data->updateCount,
                //         'deactCount' => $all_data->deactCount,
                //     );

                //     array_push($dashboard_data, $newdata);
                // }

                //dd($dashboard_data);
                $dashboard_data='';
;                return view('admin.dashboard',compact('active_val','deactive_val','unsub_val','black_val','pending_val','complete','incomplete','tot','comp_per','incomp_per','act_per','dec_per','unsub_per','pen_per','bla_per','share_link','dashboard_data'));
                
                return redirect("/")->withSuccess('You are not allowed to access');
            }
            catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function get_activity_data(Request $request) {
        if ($request->ajax()) {
            // Base query
            $query = DB::table('users as u')
                ->select('u.id', DB::raw('CONCAT(u.name, " ", u.surname) AS full_name'))
                ->selectSub(function ($query) {
                    $query->select(DB::raw('count(*)'))
                        ->from('user_events')
                        ->whereColumn('user_events.user_id', 'u.id')
                        ->where('user_events.action', 'created')
                        ->where('user_events.type', 'respondent');
                }, 'createCount')
                ->selectSub(function ($query) {
                    $query->select(DB::raw('count(*)'))
                        ->from('user_events')
                        ->whereColumn('user_events.user_id', 'u.id')
                        ->where('user_events.action', 'updated')
                        ->where('user_events.type', 'respondent');
                }, 'updateCount')
                ->selectSub(function ($query) {
                    $query->select(DB::raw('count(*)'))
                        ->from('user_events')
                        ->whereColumn('user_events.user_id', 'u.id')
                        ->where('user_events.action', 'deactivated')
                        ->where('user_events.type', 'respondent');
                }, 'deactCount');
    
           
            // Apply filters based on DataTables search input
            // if (!empty($request->input('year')) || !empty($request->input('month'))) {
            //     $year = $request->input('year');
            //     $month = $request->input('month');
            //     $query->where(function ($query) use ($year,$month) {
            //         $query->orWhere('user_events.year','=',$year)
            //                   ->orWhere('user_events.month','=',$month);
            //     });
            // }

            if ($request->filled('year') || $request->filled('month')) {
                $year = $request->input('year');
                $month = $request->input('month');
                
                $query->whereExists(function ($subQuery) use ($year, $month) {
                    $subQuery->select(DB::raw(1))
                             ->from('user_events')
                             ->whereColumn('user_events.user_id', 'u.id')
                             ->where(function ($query) use ($year, $month) {
                                 if (!empty($year)) {
                                     $query->whereYear('user_events.created_at', '=', $year);
                                 }
                                 if (!empty($month)) {
                                     $query->orWhereMonth('user_events.created_at', '=', $month);
                                 }
                             });
                });
            }
            

              
        
    
            // Count total records before pagination
            $totalRecords = $query->count();
    
            // Ordering and pagination
            $query->offset($request->input('start'))
                  ->limit($request->input('length'));
    
            // Get data
            $data = $query->get();
    
            // Prepare JSON response for DataTables
            $json_data = [
                "draw" => intval($request->input('draw')),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords, // For simplicity, assuming no search filter on server
                "data" => $data,
            ];
    
            return response()->json($json_data);
        }
    }

    public function admin_password_reset_save(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $user = Users::where('email', $request->email)->first();
    
        if (!$user) {
            return back()->withErrors(['email' => __('We could not find a user with that email address.')]);
        }
    
        // Generate password reset token
        $token = Password::getRepository()->create($user);
    
        // Generate password reset URL
        $resetUrl = URL::temporarySignedRoute(
            'admin_password_reset', now()->addMinutes(60), ['token' => $token, 'email' => $user->email]
        );
     
        try {
            // Send password reset email
            $data = [
                'subject' => 'Reset Password Notification',
                'type' => 'forgot_password_email',
                'token' => $token,
                'resetUrl' => $resetUrl,
            ];
    
            Mail::to($user->email)->send(new ResetPasswordEmail($data));
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Log the exception for debugging
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
            return back()->withErrors(['email' => __('Failed to send password reset email. Please try again later.')]);
        }
    
        return back()->with('status', __('Password reset email sent! Please check your email.'));
    }


    public function admin_password_reset_update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
    'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // Get the user by email
        $user = Users::where('email', $request->email)->first();

        // Check if the current password is correct
      

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/admin')->with('status', 'Password updated successfully.');
    }
    

    public function signOut(){
        try {
            Session::flush();
            Auth::guard('admin')->logout();
            return Redirect()->route('admin.showlogin');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function get_education($data, $type){

        if($type == 'education'){
            $array = array(
                'Matric' => 'matric',
                'Post Matric Courses / Higher Certificate' => 'post_matric_courses',
                'Post Matric Diploma' => 'post_matric_diploma',
                'Undergrad University Degree' => 'ug',
                'Post Grad Degree - Honours, Masters, PhD, MBA' => 'pg',
                'School But No Matric' => 'school_no_metric'
            );

            if (array_key_exists($data, $array)) {
                return $array[$data];
            } else {
                return null;
            }
        }
        else if($type == "employment"){
            $array = array(
                'Employed Full-Time' => 'emp_full_time',
                'Employed Part-Time' => 'emp_part_time',
                'Self-Employed' => 'self',
                'Studying' => 'study',
                'Working & Studying' => 'working_and_studying',
                'Stay at Home Person' => 'home_person',
                'Retired' => 'retired',
                'Unemployed' => 'unemployed',
                'Stay at Home Person' => 'home_person',
            );

            if (array_key_exists($data, $array)) {
                return $array[$data];
            } else {
                return null;
            }
        }
        else if($type == "role_organization"){
            $array = array(
                'Owner / director (CEO, COO, CFO)' => 'owner_director',
                'Senior Manager' => 'senior_manager',
                'Mid-Level Manager' => 'mid_level_manager',
                'Team leader / Supervisor' => 'team_leader',
                'General Worker (e.g., Admin, Call Centre Agent, Nurse, Teacher, Carer, etc.)' => 'general_worker',
                'Worker (e.g., Security Guard, Cleaner, Helper, etc.)' => 'worker_etc',
                'Recruiter' => 'recruiter',
            );

            if (array_key_exists($data, $array)) {
                return $array[$data];
            } else {
                return null;
            }
        }
    }

    public function resp_db_import(Request $request){
        $total = $request->total;
        $count_ass = $request->count_ass;
        $get_import_data = DB::table('profile_data')->where('imported_status',0)->take($total)->get();
        $password = Hash::make('Change@123');
        $resp_inc_get = Respondents::orderBy('id','DESC')->first();
        $res_inc = ($resp_inc_get != null) ? ($resp_inc_get->id + 1) : 1;
        foreach($get_import_data as $resp){
            $no_vehicle = 0;
            $no_children = 0;

            if($resp->car_3_brand != null && $resp->car_3_brand != ''){
                $no_vehicle = 3;
            }
            else if($resp->car_2_brand != null && $resp->car_2_brand != ''){
                $no_vehicle = 2;
            }
            else if($resp->car_1_brand != null && $resp->car_1_brand != ''){
                $no_vehicle = 1;
            }

            if($resp->child_4_birth != null && $resp->child_4_birth != ''){
                $no_children = 4;
            }
            else if($resp->child_4_birth != null && $resp->child_4_birth != ''){
                $no_children = 3;
            }
            else if($resp->child_4_birth != null && $resp->child_4_birth != ''){
                $no_children = 2;
            }
            else if($resp->child_4_birth != null && $resp->child_4_birth != ''){
                $no_children = 1;
            }
            
            $respondent_insert = array(
                'id'        => $resp->id,
                'name'      => $resp->fname,
                'surname'   => $resp->lname,
                'date_of_birth' => $resp->dob,
                'email'     => $resp->main_email,
                'mobile'    => $resp->pnumber,
                'whatsapp'  => $resp->whatsapp,
                'bank_name' => $resp->bank_main,
                'password'  => $password,
                'opted_in'  => $resp->opted_id,
                'active_status_id' => ($resp->blacklist > 0 ? 5 : ($resp->unregistered > 0 ? 6 : 0))
            );

            $basic_details = array(
                'email'           => $resp->main_email,
                'last_name'       => $resp->fname,
                'first_name'      => $resp->lname,
                'updated_at'      => date('Y-m-d H:i:s'),
                'mobile_number'   => $resp->pnumber,
                'whatsapp_number' => $resp->whatsapp
            );

            $get_industry_in = DB::table('industry_company')->where(DB::raw('REPLACE(company, " ", "")'), 'like', '%' . str_replace(' ', '', $resp->industry_my_company) . '%')->first();
            $get_percenal_income = DB::table('income_per_month')->where(DB::raw('REPLACE(income, " ", "")'), 'like', '%' . str_replace(' ', '', $resp->personal_income) . '%')->first();
            $get_house_income = DB::table('income_per_month')->where(DB::raw('REPLACE(income, " ", "")'), 'like', '%' . str_replace(' ', '', $resp->personal_income) . '%')->first();
            $get_bank = DB::table('banks')->where(DB::raw('REPLACE(bank_name, " ", "")'), 'like', '%' . str_replace(' ', '', $resp->bank_main) . '%')->first();

            $essential_details = array(
                'gender'                     => ($resp->gender == 'Male') ? 'male' : 'female',
                'suburb'                     => '',
                'province'                   => '',
                'metropolitan_area'          => '',
                'job_title'                  => $resp->job_title,
                'no_vehicle'                 => $no_vehicle,
                'no_children'                => $no_children,
                'ethnic_group'               => ($resp->ethnic_group_race != null && $resp->ethnic_group_race != '') ? strtolower($resp->ethnic_group_race) : null,
                'education_level'            => $this->get_education($resp->highest_level_education, 'education'),
                'employment_status'          => $this->get_education($resp->highest_level_education, 'employment'),
                'industry_my_company'        => ($get_industry_in != null) ? $get_industry_in->id : 0,
                'relationship_status'        => ($resp->relationship_status != null && $resp->relationship_status != '') ? strtolower($resp->relationship_status) : null,
                'personal_income_per_month'  => ($get_percenal_income != null) ? $get_percenal_income->id : 0,
                'household_income_per_month' => ($get_house_income != null) ? $get_house_income->id : 0,
                'updated_at'                 => date('Y-m-d H:i:s')
            );

            $extended_details = array(
                'bank_main'                 => ($get_bank != null) ? $get_bank->id : 0,
                'home_lang'                 => ($resp->home_language != null && $resp->home_language != '') ? strtolower($resp->home_language) : null,
                'updated_at'                => date('Y-m-d H:i:s'),
                'org_company'               => $this->get_education($resp->role_business_organization, 'role_organization'),
            );

            $child_detials = array();
            $car_detials   = array();

            $resp_profile = array(
                'pid'               => $resp->id,
                'respondent_id'     => $resp->id,
                'basic_details'     => json_encode($basic_details),
                'essential_details' => json_encode($essential_details),
                'extended_details'  => json_encode($extended_details),
            );

            if($no_children > 0){
                for($ch = 1; $ch <= $no_children; $ch++){
                    $child_birth_var = 'child_'.$ch.'_birth';
                    $child_gender_var = 'child_'.$ch.'_gender';

                    $child_json = array(
                        "date" => $resp->$child_birth_var,
                        "gender" => ($resp->$child_gender_var == "Male") ? 'male' : 'female'
                    );

                    array_push($child_detials, $child_json);
                }

                $resp_profile['children_data'] = json_encode($child_detials);
            }

            if($no_vehicle > 0){
                for($ch = 1; $ch <= $no_vehicle; $ch++){
                    $car_brand_var   = 'car_'.$ch.'_brand';
                    $car_model_var   = 'car_'.$ch.'_model';
                    $car_vehicle_var = 'car_'.$ch.'_vehicle';
                    $car_year_var    = 'car_'.$ch.'_year';

                    $car_json = array(
                        "type" => ($resp->$car_vehicle_var != null && $resp->$car_vehicle_var != '') ? strtolower($resp->$car_vehicle_var) : null,
                        "year" => $resp->$car_year_var,
                        "brand" => $resp->$car_brand_var,
                        "model" => ($resp->$car_model_var != null && $resp->$car_model_var != '') ? strtolower($resp->$car_model_var) : null,
                    );

                    array_push($car_detials, $car_json);
                }

                $resp_profile['vehicle_data'] = json_encode($car_detials);
            }
           

            Respondents::insert($respondent_insert);
            RespondentProfile::insert($resp_profile);
            DB::table('profile_data')->where('id',$resp->id)->update(['imported_status' => 1]);
            $res_inc++;
        }

        return $count_ass;
    }
    
}
