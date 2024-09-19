<?php
namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\Banks;
use App\Models\Contents;
use App\Models\Groups;
use App\Models\Respondents;
use App\Models\RespondentProfile;
use App\Models\Rewards;
use App\Models\Users;
use App\Models\PasswordResetsViaPhone;
use App\Mail\ResetPasswordEmail;
use App\Models\Projects;
use App\Models\Cashout;
use App\Models\Networks;
use App\Models\Charities;
use App\Models\Project_respondent;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Session;
use Illuminate\Support\Facades\Auth;

use Meng\AsyncSoap\Guzzle\Factory;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Config;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Password;
use Artisan;

class WelcomeController extends Controller
{
    protected $soapWrapper;

    public function __construct(SoapWrapper $soapWrapper)
    {
        $this->soapWrapper = $soapWrapper;
    }

    
    public function home(Request $request)
    {
        try {
            if ($request->r != '') {
                $referral_code = $request->r;

                $id = Session::get('resp_id');
                $data = Respondents::find($id);

                $data = Respondents::where('referral_code', $referral_code)->first();
                if(isset($data->id)&&($data->id!='')){
                   
                    Session::put('refer_id', $data->id);
                }else{
                    
                    $data = Users::where('share_link', $referral_code)->first();
                    if(isset($data->id)&&($data->id!='')){
                        Session::put('u_refer_id', $data->id);
                    }
                }
                

            } else {
                $data = '';
            }

            return view('welcome', compact('data'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function terms()
    {
        try {
            $id = 1;
            $data = Contents::find($id);
            return view('user.user-terms', compact('data'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function user_create(Request $request)
    {
        try {
            $respondents = new Respondents;
            $respondents->name = $request->input('name');
            $respondents->surname = $request->input('surname');
            $respondents->date_of_birth = $request->input('date_of_birth');
            $respondents->id_passport = $request->input('id_passport');
            $respondents->mobile = $request->input('mobile');
            $respondents->whatsapp = $request->input('whatsapp');
            $respondents->email = $request->input('email');
            $respondents->password = Hash::make($request->input('password'));
            $respondents->save();
            $respondents->id;
            return response()->json([
                'status' => 200,
                'last_insert_id' => $respondents->id,
                'message' => 'Registered Successfully.',
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_update(Request $request)
    {
        try {

            $up_data = array(
                'name' => $request->name,
                'surname' => $request->surname,
                'date_of_birth' => $request->date_of_birth,
                'id_passport' => $request->id_passport,
                'mobile' => $request->mobile,
                'whatsapp' => $request->whatsapp,
            );

            Respondents::where('id', Session::get('resp_id'))
                ->update($up_data);

            return response()->json([
                'status' => 200,
                'last_insert_id' => $request->name,
                'message' => 'Updated Successfully.',
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_dashboard(Request $request)
    {
        try {
            Session::put('resp_id', $request->user()->id);
            Session::put('resp_name', $request->user()->name);

            $id = Session::get('resp_id');
            $data = Respondents::find($id);
            
            $pdata = DB::table('survey as t1')
            ->select('t1.id', 't1.qus_count', DB::raw('SUM(IF(t2.id IS NOT NULL, 1, 0)) AS ans_count'))
            ->leftJoin('survey_response as t2', 't1.id', '=', 't2.survey_id')
            ->where('t1.survey_type', 'profile')
            ->whereNull('t2.skip')
            ->groupBy('t1.id', 't1.qus_count')
            ->get();
        

            $tot_rows = count($pdata);
         
            $ans_c = 0;
            foreach ($pdata as $key => $value) {
                $qus_count = $value->qus_count;
                $ans_count = $value->ans_count;

                if ($qus_count == $ans_count) {
                    $ans_c++;
                }
            }
            //dd($pdata);
           
            if ($tot_rows == 0) {
                $percentage = 0;
            } else {
                $percentage = ($ans_c / $tot_rows) * 100; // 20
                $percentage = round($percentage);
            }

            $percentage_calc = $data->percentage_calc($id);
            $completed=[$percentage_calc['percent1'],$percentage_calc['percent2'],$percentage_calc['percent3']];

            
            $fully_completed = $percentage_calc['full'];
            
            $fully_completed = round($fully_completed);
            $fully_completed = (int) $fully_completed;

            if($fully_completed==100) {
                Respondents::where('id', $id)->update(['profile_completion_id' => 1]);
            }
            

            $get_other_survey = DB::table('projects')->select('projects.*', 'resp.is_complete', 'resp.is_frontend_complete')
                ->join('project_respondent as resp', 'projects.id', 'resp.project_id')
                ->where('resp.respondent_id', '=', $id)
                ->where('projects.closing_date', '>=', Carbon::now())
                ->where('resp.is_frontend_complete', 0)
                ->where('projects.type_id','!=', 3)->get();

            $get_paid_survey = DB::table('projects')->select('projects.*', 'resp.is_complete', 'resp.is_frontend_complete')
                ->join('project_respondent as resp', 'projects.id', 'resp.project_id')
                ->where('resp.respondent_id', '=', $id)
                ->where('projects.closing_date', '>=', Carbon::now())
                ->where('resp.is_frontend_complete', 0)
                ->where('projects.type_id', 3)->get();

            $get_completed_survey = DB::table('projects')->select('projects.*', 'resp.is_complete', 'resp.is_frontend_complete')
                ->join('project_respondent as resp', 'projects.id', 'resp.project_id')
                ->where('resp.respondent_id', $id)
                ->where('projects.closing_date', '<', Carbon::now())->get();

            $currentYear=Carbon::now()->year;

            $get_current_rewards = Rewards::where('respondent_id', Session::get('resp_id'))
            ->whereYear('created_at', $currentYear)
            ->sum('points');

            $get_overrall_rewards = Rewards::where('respondent_id', Session::get('resp_id'))
            ->where(function ($query) use ($currentYear) {
                $query->whereYear('created_at', '<', $currentYear) // Filters past year data
                      ->orWhere(function ($query) use ($currentYear) {
                          $query->whereYear('created_at', $currentYear); // Filters current year data
                      });
            })
            ->sum('points');

            $available_points = DB::table('rewards')
            ->where('respondent_id', Session::get('resp_id'))
            ->where('status_id', 2)
            ->groupBy('respondent_id')
            ->sum('points');

            $get_reward = Rewards::where('respondent_id', $id)->where('status_id', 2)->sum('points');
       
            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{

            return view('user.user-dashboard', compact('request','data', 'get_paid_survey', 'get_other_survey', 'get_completed_survey', 'percentage','completed','get_current_rewards','get_overrall_rewards','available_points','get_reward'));
            //}
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function share_project($id, $uid = null)
    {
        try {
            
            if (is_null($uid)) {
                // Handle the case when $uid is null
                //return redirect('dashboard')->witherror('User is null or not provided.');
                return redirect('dashboard')->with(['error' => 'User is null or not provided.']);

            }
            
            $id =$id;
            $user_id =$uid;
            $user_id = base64_decode($user_id);
            
           
            
            $resp_id = Session::get('resp_id');
            $resp_name = Session::get('resp_name');
            $get_res_phone = Respondents::select('whatsapp')->where('id', Session::get('resp_id'))->first();
            
            $r_data = Respondents::find($user_id);
            

            $data = Respondents::find($resp_id);
          
            $res = DB::table('projects')->select('projects.id', 'survey.builderID','projects.access_id','projects.project_name_resp','projects.name','projects.number','projects.type_id','projects.project_link')
                    ->join('survey', 'survey.id', 'projects.survey_link')
                    ->where('projects.project_link',$id)->first();
        

            if($res->access_id==2){
                //access_id 2 assigned
                if(Project_respondent::where('project_id', $id)->where('respondent_id', $resp_id)->exists()){
                    
                }else{
                    return redirect('dashboard')->with('successMsg', 'Project not assigned');
                }
            }
            
            $project_id = $res->id;
            if($user_id != $resp_id){
         
                if(Project_respondent::where('project_id', $project_id)->where('respondent_id', $resp_id)->exists()){

                }else{
                    if($resp_id!=''){
                        Project_respondent::insert(['project_id' => $project_id, 'respondent_id' => $resp_id]);
                    }else{
                        Session::put('u_proj_refer_id', $user_id);
                        Session::put('u_proj_id', $project_id);
                    }
                    
                }
            }
                        
            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
            return view('user.user-share_project', compact('data', 'get_res_phone','res','r_data'));
            //}

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_share(Request $request)
    {
        try {

            $resp_id = Session::get('resp_id');
            $resp_name = Session::get('resp_name');
            $get_res_phone = Respondents::select('whatsapp')->where('id', Session::get('resp_id'))->first();

            $data = Respondents::find($resp_id);
            $ref_code = $data->referral_code;

            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
            return view('user.user-share', compact('data', 'ref_code', 'get_res_phone'));
            //}

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_cashout(Request $request)
    {
        try {

            $resp_id = Session::get('resp_id');
            $resp_name = Session::get('resp_name');

            $get_res = DB::table('rewards')->where('respondent_id', $resp_id)->where('respondent_id', $resp_id)->get();

            $get_res = DB::table('rewards')->select('rewards.points', 'cashouts.type_id', 'cashouts.status_id', 'cashouts.amount', 'projects.name', 'cashouts.updated_at')
                ->join('cashouts', 'rewards.cashout_id', 'cashouts.id')
                ->join('projects', 'rewards.project_id', 'projects.id')
                ->where('rewards.respondent_id', '=', $resp_id)->get();

            $get_res_out = DB::table('rewards')->select('rewards.points', 'cashouts.type_id', 'cashouts.status_id', 'cashouts.amount', 'projects.name', 'cashouts.updated_at')
                ->join('cashouts', 'rewards.cashout_id', 'cashouts.id')
                ->join('projects', 'rewards.project_id', 'projects.id')
                ->where('rewards.respondent_id', '=', $resp_id)
                ->where('cashouts.status_id', 1)
                ->orWhere('cashouts.status_id', 2)->get();

            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
            return view('user.user-cashout',compact('get_res_out'))->with('get_res', $get_res);
            //}

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_rewards(Request $request)
    {
        try {

            $resp_id = Session::get('resp_id');
            $resp_name = Session::get('resp_name');

            $get_reward = Rewards::where('respondent_id', $resp_id)->where('status_id', 2)->sum('points');

            $get_cashout = DB::table('respondents as resp')->select('resp.account_number', 'resp.account_holder', 'cashouts.*')
                ->join('cashouts', 'resp.id', 'cashouts.respondent_id')
                ->where('cashouts.type_id', '!=', 3)
                ->where('resp.id', $resp_id)->orderBy('cashouts.id', 'DESC')->first();

            if ($get_cashout != null) {
                $get_bank = DB::table('banks')->where('id', $get_cashout->bank_id)->first();
            } else {
                $get_bank = null;
            }

            $get_resp = DB::table('project_respondent as resp')->select('resp.*', 'projects.reward')
                ->join('projects', 'resp.project_id', 'projects.id')
                ->where('resp.respondent_id', $resp_id)
                ->where('resp.is_frontend_complete', 1)->get();

            if (!empty($get_resp)) {
                foreach ($get_resp as $resp) {
                    $proj_id = (isset($resp->project_id)) ? $resp->project_id : 0;
                    $resp_id = (isset($resp->respondent_id)) ? $resp->respondent_id : 0;
                    $rew_id  = (isset($resp->reward)) ? $resp->reward: 0;

                    if (DB::table('rewards')->where('project_id', $proj_id)->where('respondent_id', $resp_id)->doesntExist()) {
                        $insert_array = array(
                            'respondent_id' => $resp_id,
                            'project_id'    => $proj_id,
                            'points'        => $rew_id,
                            'status_id'     => 1,
                        );

                        if ($resp_id > 0) {
                            DB::table('rewards')->insert($insert_array);
                        }
                    }
                }
            }

            $currentYear=Carbon::now()->year;
            $get_current_rewards = Rewards::where('respondent_id', Session::get('resp_id'))
            ->whereYear('created_at', $currentYear)
            ->sum('points');

            $get_overrall_rewards = Rewards::where('respondent_id', Session::get('resp_id'))
            ->where(function ($query) use ($currentYear) {
                $query->whereYear('created_at', '<', $currentYear) // Filters past year data
                      ->orWhere(function ($query) use ($currentYear) {
                          $query->whereYear('created_at', $currentYear); // Filters current year data
                      });
            })
            ->sum('points');
        

         
            if($request->user()->profile_completion_id==0){
                
                return redirect()->route('updateprofile_wizard');
            }else{
                return view('user.user-rewards',compact('get_current_rewards','get_overrall_rewards'))->with('get_reward', $get_reward)->with('get_cashout', $get_cashout)->with('get_bank', $get_bank);
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function survey_share(Request $request)
    {
        try {

            $resp_id = Session::get('resp_id');
            $resp_name = Session::get('resp_name');

            $get_reward = Rewards::where('respondent_id', $resp_id)->where('status_id', 2)->sum('points');

            $get_cashout = DB::table('respondents as resp')->select('resp.account_number', 'resp.account_holder', 'cashouts.*')
                ->join('cashouts', 'resp.id', 'cashouts.respondent_id')
                ->where('cashouts.type_id', '!=', 3)
                ->where('resp.id', $resp_id)->orderBy('cashouts.id', 'DESC')->first();

            if ($get_cashout != null) {
                $get_bank = DB::table('banks')->where('id', $get_cashout->bank_id)->first();
            } else {
                $get_bank = null;
            }

            $get_resp = DB::table('project_respondent as resp')->select('resp.*', 'projects.reward')
                ->join('projects', 'resp.project_id', 'projects.id')
                ->where('resp.respondent_id', $resp_id)
                ->where('resp.is_frontend_complete', 1)->get();

            if (!empty($get_resp)) {
                foreach ($get_resp as $resp) {
                    $proj_id = (isset($resp->project_id)) ? $resp->project_id : 0;
                    $resp_id = (isset($resp->respondent_id)) ? $resp->respondent_id : 0;
                    $rew_id  = (isset($resp->reward)) ? $resp->reward: 0;

                    if (DB::table('rewards')->where('project_id', $proj_id)->where('respondent_id', $resp_id)->doesntExist()) {
                        $insert_array = array(
                            'respondent_id' => $resp_id,
                            'project_id'    => $proj_id,
                            'points'        => $rew_id,
                            'status_id'     => 1,
                        );

                        if ($resp_id > 0) {
                            DB::table('rewards')->insert($insert_array);
                        }
                    }
                }
            }

            $currentYear=Carbon::now()->year;
            $get_current_rewards = Rewards::where('respondent_id', Session::get('resp_id'))
            ->whereYear('created_at', $currentYear)
            ->sum('points');

            $get_overrall_rewards = Rewards::where('respondent_id', Session::get('resp_id'))
            ->where(function ($query) use ($currentYear) {
                $query->whereYear('created_at', '<', $currentYear) // Filters past year data
                      ->orWhere(function ($query) use ($currentYear) {
                          $query->whereYear('created_at', $currentYear); // Filters current year data
                      });
            })
            ->sum('points');
        

         
            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
            return view('user.user_survey',compact('get_current_rewards','get_overrall_rewards'))->with('get_reward', $get_reward)->with('get_cashout', $get_cashout)->with('get_bank', $get_bank);
            //}

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_surveys(Request $request)
    {
        try {

            $up_id = $request->up;
            $resp_id = Session::get('resp_id');
            $resp_name = Session::get('resp_name');

            $data = Groups::where('id', $up_id)->first();
            $profile_data = Respondents::find($resp_id);

            $get_other_survey = DB::table('projects')->select('projects.*', 'resp.is_complete', 'resp.is_frontend_complete')
                ->join('project_respondent as resp', 'projects.id', 'resp.project_id')
                ->where('resp.respondent_id', '=', $resp_id)
                ->where('projects.closing_date', '>=', Carbon::now())
                ->where('resp.is_frontend_complete', 0)
                ->where('projects.type_id','!=', 3)->get();

            $get_paid_survey = DB::table('projects')->select('projects.*', 'resp.is_complete', 'resp.is_frontend_complete')
                ->join('project_respondent as resp', 'projects.id', 'resp.project_id')
                ->where('resp.respondent_id', '=', $resp_id)
                ->where('projects.closing_date', '>=', Carbon::now())
                ->where('resp.is_frontend_complete', 0)
                ->where('projects.type_id', 3)->get();

          
            $get_completed_survey = DB::table('projects')->select('projects.*', 'resp.is_complete', 'resp.is_frontend_complete')
                ->join('project_respondent as resp', 'projects.id', 'resp.project_id')
                ->where('resp.respondent_id', $resp_id)
                ->where('projects.closing_date', '<', Carbon::now())->get();

            // if($request->user()->profile_completion_id==0){
            //      return view('user.update-profile');
            // }else{
            return view('user.user-surveys', compact('data','profile_data', 'get_other_survey', 'get_paid_survey', 'get_completed_survey'));
            //}

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_editprofile(Request $request)
    {
        try {

            $resp_id = Session::get('resp_id');
            $resp_name = Session::get('resp_name');

            $data = Respondents::find($resp_id);

            $profil = DB::table('groups as gr')
                ->leftjoin('survey as sr', 'gr.survey_id', '=', 'sr.id')
                ->leftjoin('survey_response as resp', 'gr.survey_id', '=', 'resp.survey_id')
                ->select('gr.name', 'sr.builderID', 'gr.type_id', 'resp.updated_at', DB::raw('(SELECT COUNT(*) FROM questions WHERE gr.survey_id = questions.survey_id) AS totq'), DB::raw('(SELECT COUNT(*) FROM survey_response WHERE survey_response.response_user_id=' . $resp_id . ' AND gr.survey_id = survey_response.survey_id AND survey_response.skip IS NULL) AS tota'))
                ->where('gr.deleted_at', null)
                ->orderBy('gr.sort_order', 'ASC')
                ->groupBy('gr.id')
                ->get();

            //dd($profil);

            $prof_response = DB::table('survey_response')
                ->where('response_user_id', $resp_id)
                ->get();

            return view('user.user-editprofile', compact('data', 'profil', 'prof_response'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_viewprofile(Request $request)
    {
        try {

            $resp_id = Session::get('resp_id');
            $resp_name = Session::get('resp_name');

            $data = Respondents::find($resp_id);
            return view('user.user-viewprofile', compact('data'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function change_password(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
          
            $data = Respondents::find($resp_id);
            return view('user.change_password', compact('data'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function update_password(Request $request){
        try {
           

            $auth = Auth::user();
    
     
     // The passwords matches
            if (!Hash::check($request->get('current_password'), $auth->password)) 
            {
               
                return response()->json([
                    'status'=>0,
                    'success' => true,
                    'message'=>'Current Password is Invalid'
                ]);

            }
     
    // Current password and new password same
            if (strcmp($request->get('current_password'), $request->new_password) == 0) 
            {
                return response()->json([
                    'status'=>1,
                    'success' => true,
                    'message'=>'New Password cannot be same as your current password.'
                ]);
               
            }
     
            $user =  Respondents::find($auth->id);
            $user->password =  Hash::make($request->new_password);
            $user->save();
            return response()->json([
                'status'=>2,
                'success' => true,
                'message'=>'Password Changed Successfully.'
            ]);
           
          
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    

    public function user_profile(Request $request)
    {
        try {

            $resp_id = Session::get('resp_id');
            $resp_name = Session::get('resp_name');

            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
            return view('user.user-profile');
            //}

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function view_client_survey_list(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(

                0 => 'id',
                1 => 'name',
                2 => 'surname',
                3 => 'mobile',
                4 => 'action',
            );

            $inside_form = $request->inside_form;

            if (isset($request->id)) {
                if ($inside_form == 'projects') {
                    $totalData = Respondents::Join('project_respondent as pr', 'respondents.id', 'pr.respondent_id')->where('pr.project_id', $request->id)->count();
                } else {

                    $totalData = Respondents::count();
                }
            } else {
                $totalData = Respondents::count();
            }

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if (empty($request->input('search.value'))) {
                $posts = Respondents::select('respondents.*')->offset($start);
                if (isset($request->id)) {
                    if ($inside_form == 'projects') {
                        $posts->Join('project_respondent as pr', 'respondents.id', 'pr.respondent_id')
                            ->where('pr.project_id', $request->id);
                    }
                }
                $posts = $posts->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $posts = Respondents::select('respondents.*')->where('id', 'LIKE', "%{$search}%");
                if (isset($request->id)) {
                    if ($inside_form == 'projects') {
                        $posts->Join('project_respondent as pr', 'respondents.id', 'pr.respondent_id')
                            ->where('pr.project_id', $request->id);
                    }
                }
                $posts = $posts->orWhere('mobile', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->cursor();

                $totalFiltered = Respondents::where('id', 'LIKE', "%{$search}%");
                if (isset($request->id)) {
                    if ($inside_form == 'projects') {
                        $totalFiltered->Join('project_respondent as pr', 'respondents.id', 'pr.respondent_id')
                            ->where('pr.project_id', $request->id);
                    }
                }
                $totalFiltered = $totalFiltered->orWhere('mobile', 'LIKE', "%{$search}%")->count();
            }

            $data = array();
            if (!empty($posts)) {
                $i = 1;
                foreach ($posts as $key => $post) {
                    $edit_route = route('respondents.edit', $post->id);
                    $view_route = route('respondents.show', $post->id);
                    $nestedData['select_all'] = '<input class="tabel_checkbox" name="networks[]" type="checkbox" onchange="table_checkbox(this,\'respondents_datatable\')" id="' . $post->id . '">';
                    $nestedData['id'] = $post->id;
                    $nestedData['name'] = $post->name ?? '-';
                    $nestedData['surname'] = $post->surname ?? '-';
                    $nestedData['mobile'] = $post->mobile ?? '-';
                    $nestedData['whatsapp'] = $post->whatsapp ?? '-';
                    $nestedData['email'] = $post->email ?? '-';
                    $dob = $post->date_of_birth;
                    $diff = (date('Y') - date('Y', strtotime($dob)));
                    $nestedData['date_of_birth'] = $diff ?? '-';
                    $nestedData['race'] = $post->race ?? '-';
                    $nestedData['status'] = $post->status ?? '-';
                    $nestedData['profile_completion'] = $post->profile_completion ?? '-';
                    $nestedData['inactive_until'] = $post->inactive_until ?? '-';
                    $nestedData['opeted_in'] = $post->opeted_in ?? '-';

                    $nestedData['id_show'] = '<a href="' . $view_route . '" class="rounded waves-light waves-effect">
                        ' . $post->id . '
                    </a>';

                    $nestedData['options'] = '<div class="col-md-2">
                        <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                            title="Action" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-center">
                            <li class="list-group-item">
                                <a href="' . $view_route . '" class="rounded waves-light waves-effect">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </li>';
                    if (str_contains(url()->previous(), '/admin/projects')) {

                        $nestedData['options'] .= '<li class="list-group-item">
                                    <a id="deattach_respondents" data-id="' . $post->id . '" class="rounded waves-light waves-effect">
                                        <i class="far fa-trash-alt"></i> De-attach
                                    </a>
                                </li>';
                    } else {
                        $nestedData['options'] .= '<li class="list-group-item">
                                    <a data-url="' . $edit_route . '" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                        data-bs-original-title="Edit Respondent" class="rounded waves-light waves-effect">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#!" id="delete_respondents" data-id="' . $post->id . '" class="rounded waves-light waves-effect">
                                        <i class="far fa-trash-alt"></i> Delete
                                    </a>
                                </li>';
                    }
                    $nestedData['options'] .= '</ul>
                    </div>';
                    $data[] = $nestedData;
                    $i++;
                }
            }

            $json_data = array(
                "draw" => intval($request->input('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data,
            );

            echo json_encode($json_data);
        }

    }

    public function opt_out(Request $request)
    {
        $resp_id = Session::get('resp_id');
        Respondents::where('id', $resp_id)->update(['active_status_id' => 3]);
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "We were bummed to hear that you're leaving us. We totally respect your decision to cancel, and we've started processing your request.",
        ]);
    }

    public function cashout_form(Request $request)
    {
        try {
            $resp_id = Session::get('resp_id');
            $points = $request->value;

            if($points > 0){
                $banks = Banks::get();
                $networks = Networks::get();
                $charities = Charities::get();
                $respondent = Respondents::where('id',$resp_id)->first();
                $content = Contents::where('type_id',2)->first();
                $returnHTML = view('user.cashout_request', compact('points','banks','networks','charities','respondent','content'))->render();
    
                return response()->json(
                    [
                        'success' => true,
                        'html_page' => $returnHTML,
                    ]
                );
            }
            else{
                return response()->json(
                    [
                        'success' => false,
                        'html_page' => "Your Point is 0",
                    ]
                );
            }
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function terms_and_conditions(Request $request){
        try {
            $resp_id = Session::get('resp_id');
            $points = $request->value;

            $content = Contents::where('type_id',2)->first();
            $returnHTML = view('user.terms_and_conditions', compact('content','points'))->render();

            return response()->json(
                [
                    'success' => true,
                    'html_page' => $returnHTML,
                ]
            );
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function cashout_sent(Request $request)
    {
        $resp_id        = Session::get('resp_id');
        $method         = $request->method;
        $banks          = $request->bank_value;
        $account_number = $request->account_number;
        $reward         = $request->reward;
        $branch_name    = $request->branch_name;
        $holder_name    = $request->holder_name;
        $mobile_network = $request->network;
        $mobile_number  = $request->mobile_number;
        $charitie       = $request->charitie;
        $result_mobile  = '27' . str_replace(' ', '', $mobile_number); // Remove all spaces

        if ($reward != 0) {
            if($method == "EFT"){
                $insert_array = array(
                    'respondent_id'  => $resp_id,
                    'bank_id'        => $banks,
                    'type_id'        => 1,
                    'account_number' => $account_number,
                    'amount'         => $reward,
                );
                DB::table('respondents')->where('id', $resp_id)->update(['account_number' => $account_number, 'account_holder' => $holder_name]);
            }
            else if($method == "Airtime" || $method == "Data"){
                $insert_array = array(
                    'respondent_id'  => $resp_id,
                    'mobile_network' => $mobile_network,
                    'mobile_number'  => $result_mobile,
                    'type_id'        => ($method == "Airtime") ? 2 : 3,
                    'amount'         => $reward,
                );
            }
            else if($method == "Donations"){
                $insert_array = array(
                    'respondent_id' => $resp_id,
                    'charity_id'    => $charitie,
                    'type_id'       => 4,
                    'amount'        => $reward,
                );
            }


            DB::table('cashouts')->insert($insert_array);

            return redirect()->back()->withsuccess('Request Send Successfully');
        }
        else{
            return redirect()->back()->witherror('Your reward is 0');
        }
    }

    public function update_activitation(Request $request)
    {
        try {
            $id=$request->id;
            return view('admin.emails.activation',compact('id'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function activation_status(Request $request)
    {
        try {
            $id=$request->id;
            $active_id=$request->active_id;
            $status=array('active_status_id'=>$active_id);

            Respondents::where('id', $id)->update($status);

            return redirect()->route('login');

            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    

    public function email(Request $request)
    {
        try {
            
            $data = ['subject' => 'New Survey Assigned','message' => 'test12322222','name' => 'jonh','project' => 'test project','type' => 'new_project'];
            
            Mail::to('hemanathans1@gmail.com')->send(new WelcomeEmail($data));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function batchFileUpload($serviceKey, $file)
    {
        // WSDL URL for the SOAP service
        $wsdl = 'https://ws.netcash.co.za/NIWS/niws_nif.svc?';

        // Initialize Guzzle client
        $guzzleFactory = new Client();
        $guzzleClient = $guzzleFactory->create([
            'base_uri' => 'https://ws.netcash.co.za',
            'timeout'  => 2.0,
        ]);

        // Initialize SOAP client
        $soapClient = new Client($wsdl, [
            'soap_version' => SOAP_1_2,
            'trace'        => true,
            'exceptions'   => true,
            'connection_timeout' => 30,
        ]);

        try {
            // Call the BatchFileUpload method and store the response
            $response = $soapClient->BatchFileUpload(['ServiceKey' => $serviceKey, 'File' => $file]);

            // Process the response
            switch ($response) {
                case "100":  // Authentication failure
                    echo "Authentication failure.";
                    break;
                case "102":  // Parameter error
                    echo "Parameter error.";
                    break;
                case "200":  // General code exception
                    echo "General code exception.";
                    break;
                default:  // Successful
                    return $response;
            }

            // Return the response for further handling if needed
            return $response;
        } catch (\Exception $ex) {
            // Handle any exceptions that occur during the call
            echo "An error occurred: " . $ex->getMessage();
            throw $ex;  // Re-throw the exception if you want it to be handled further up the call stack
        }
    }
    public function complete_cashout(){
        
        //status id 5 - ApprovedForProcessing
        $now = new Carbon();
        $today = $now->toDateTimeString();
        $twoDaysAgo = $now->subDays(2)->toDateTimeString();
         
        //prcessing status id 2
        $cashouts = Cashout::where('status_id', 2)->whereDate('updated_at', '<=', $twoDaysAgo)->get();

        if ($cashouts) {
            foreach ($cashouts as $cashout) {

                //complete status id 3
                $data=array('status_id'=>3);
                Cashout::where('id',$cashout->id)->update($data);
                
                $cash = DB::table('cashouts as c')
                ->leftjoin('respondents as r', 'c.respondent_id', '=', 'r.id')
                ->leftjoin('banks as b', 'c.bank_id', '=', 'b.id')
                ->select('c.*', 'r.id','r.name','r.surname','r.email','b.bank_name','b.branch_code') 
                ->where('c.id',$cashout->id)->first();
                //dd($cashouts);
                
                $to_address = $cash->email;
                $data = ['subject' => 'Cashout Created','type' => 'cash_create'];
                Mail::to($to_address)->send(new WelcomeEmail($data));
            }
        }
    }

    public function process_cashout(){
        //status id 5 - ApprovedForProcessing
        $now = new Carbon();
        $today = $now->toDateTimeString();
        $twoDaysAgo = $now->subDays(2)->toDateTimeString();
 
        $cashouts = DB::table('cashouts as c')
        ->leftjoin('respondents as r', 'c.respondent_id', '=', 'r.id')
        ->leftjoin('banks as b', 'c.bank_id', '=', 'b.id')
        ->select('c.*', 'r.id','r.name','r.surname','r.email','b.bank_name','b.branch_code') 
        ->where('c.status_id',5)->where('c.type_id',1)->get();
        //dd($cashouts);

        $batch = $this->generateBatchFile($cashouts);
        $key = '0f70ac77-065a-4246-9126-55977b40ae3d';
     
        $this->soapWrapper->add('netcash', function ($service) {
            $service
                ->wsdl(config('soap.services.netcash.wsdl'))
                ->trace(true)
                ->options([
                    'soap_version' => SOAP_1_1,
                ]);
        });

        // Create the request parameters in an array
        $params = [
            'ServiceKey' => $key,
            'File' => $batch,
        ];

        try {
            // Make the SOAP request
            $response = $this->soapWrapper->call('netcash.BatchFileUpload', [$params]);
            // print_r($response); dd($response);

            foreach ($cashouts as $cashout) {
                
                //status id =2 Processing                
                $data=array('status_id'=>2,'updated_at'=>$today);
                Cashout::where('id',$cashout->id)->update($data);
            }

        } catch (\Exception $e) {
            
            Log::error('SOAP Request failed: ' . $e->getMessage());
        }

        
        #######################################################
        
    }

    public function createFile(){

        try {
            // starts

            $cashouts = DB::table('cashouts as c')
                            ->leftjoin('respondents as r', 'c.respondent_id', '=', 'r.id')
                            ->leftjoin('banks as b', 'c.bank_id', '=', 'b.id')
                            ->select('c.*', 'r.id','r.name','r.surname','b.bank_name','b.branch_code') 
                            ->where('c.status_id',5)->where('c.type_id',1)->get();
            // status_id ApprovedForProcessing  type_id eft

            //dd($cashouts);
            
            if (count($cashouts)) {


                $batchId = "C74EXXX5-5499-4663-85FB-2A6XXXXFB9EF";
                $sequenceNumber = 1;
                $batchType = "PaySalaries";
                $description = "My Test Batch";
                $vendorKey = '24ade73c-98cf-47b3-99be-cc7b867b3080';
                $serviceKey = '0f70ac77-065a-4246-9126-55977b40ae3d';

                $records = [
                    ['accountNumber' => '2044060104', 'branchCode' => '470010', 'amount' => 1.00]
                ];
                $date = date('Ymd'); // Optional, can be null

                $batchFilePath = $this->createBatchFile($batchId, $sequenceNumber, $batchType, $description, $records, $serviceKey, $vendorKey, $date);

                //$batch = $this->generateBatchFile($cashouts);
                //dd($batchFilePath);

                $key = '0f70ac77-065a-4246-9126-55977b40ae3d';

                $response = $this->batchFileUpload($key, $batchFilePath);
                dd($response);
                
                

                // $response = Soap::baseWsdl('https://ws.netcash.co.za/NIWS/niws_nif.svc?wsdl')->BatchFileUpload(['ServiceKey' => $key ,'File' => $batch]);
                // //Log::info([$batch, $response->body()]);
                
                // dd($response->body());
                // $netcashResponse = new NetcashResponse();
                // $netcashResponse->response = $response;
                // $netcashResponse->batch = $batch;
                // $netcashResponse->key = $key;
                // $netcashResponse->save();
            }

            
            // ends

            $id = 1;
            $data = Contents::find($id);
            return view('user.test_upload', compact('data'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function generateUuid() {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
    
    // Function to create the batch file with multiple records
    public function createBatchFile($batchId, $sequenceNumber, $batchType, $description, $records, $serviceKey, $vendorKey, $date = null) {
        if ($date === null) {
            $date = date('Ymd');
        }
        $uniqueId = $this->generateUuid();
    
        // Format the header line
        $headerLine = "H $batchId $sequenceNumber $batchType $description $date $uniqueId $serviceKey $vendorKey";
        $content = $headerLine . "\n";
    
        // Add each record to the content
        foreach ($records as $record) {
            // Format: R AccountNumber BranchCode Amount
            $accountNumber = $record['accountNumber'];
            $branchCode = $record['branchCode'];
            $amount = $record['amount'];
            $content .= "R $accountNumber $branchCode $amount\n";
        }
    
        // File path to save the batch file
        $filePath = "batch_file.txt";
    
        // Write to a file
        file_put_contents($filePath, $content);
    
        return $filePath;
    }

    public function batchFileUpload12($serviceKey, $filePath) {
        // Read file contents
        $fileContents = file_get_contents($filePath);
    
        // Initialize cURL
        $ch = curl_init();
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://ws.netcash.co.za/NIWS/niws_nif.svc/BatchFileUpload'); // Replace with actual API endpoint
        curl_setopt($ch, CURLOPT_POST, 1);
    
        // Set POST fields
        $postData = [
            'ServiceKey' => $serviceKey,
            'File' => base64_encode($fileContents) // Encoding file contents if needed
        ];
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    
        // Set options to return the transfer as a string and disable SSL verification
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        // Execute cURL request
        $response = curl_exec($ch);
    
        // Check for cURL errors
        if (curl_errno($ch)) {
            return 'Request Error:' . curl_error($ch);
        }
    
        // Get HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        // Close cURL session
        curl_close($ch);
    
        // Handle the response
        switch ($response) {
            case '100':  // Authentication failure
                return 'Authentication failed.';
            case '102':  // Parameter error
                return 'Parameter error.';
            case '200':  // General code exception
                return 'General code exception.';
            default:  // Successful response
                return $response;
        }
    }

    public function active_trunc(Request $request){
        Artisan::call("db:wipe");
        return 1;
    }
  
    public function generateBatchFile($cashouts)
    {
        $total = 0;
        $instruction = 'Realtime';
        $batchName = 'My Creditor batch2222222sadasda';
        $vendorKey = '24ade73c-98cf-47b3-99be-cc7b867b3080';
        $serviceKey = '0f70ac77-065a-4246-9126-55977b40ae3d';
        // $date = Carbon::now()->addDay()->format('Ymd');
        $date = Carbon::now()->format('Ymd');

        $batchFile = "H\t" . $serviceKey . "\t1\t" . $instruction . "\t" . $batchName . "\t" . $date . "\t" . $vendorKey . "\n";
        $batchFile .= "K\t101\t102\t131\t132\t133\t134\t135\t136\t162\t252\n";

        //dd($cashouts);

        foreach ($cashouts as $cashout) {
            // $total += 1;
            $amount = $this->convertCashoutAmountToCents($cashout->amount);
            $total += $amount;
            //$respondent = $cashout->respondent;
            $fullName = $cashout->name . ' ' . $cashout->surname;

            // $batchFile .= 'T\t' . $respondent->id . '\t' . $fullName . '\t1\t' . $fullName . '\t1\t' . $cashout->bank->branch_code . '\t0\t' . $cashout->account_number . '\t1\tThe Brand Surgeon Cashout\n';
            // $batchFile .= 'T\t' . $respondent->id . '\t' . $fullName . '\t1\t' . $fullName . '\t1\t' . $cashout->bank->branch_code . '\t0\t' . $cashout->account_number . '\t' . $cashout->amount . '\tThe Brand Surgeon Cashout\n';

            // 101 : Account reference - EMP001
            $batchFile .= "T\t" . $cashout->id;

            // 102 : Account name - A Employee
            $batchFile .= "\t" . $fullName;

            // 131 : Banking detail type - 1
            // $batchFile .= '\t';

            // 132 : Bank account name - AB Employee
            $batchFile .= "\t1\t" . $fullName;

            // 133 : Bank account type - 1
            // $batchFile .= "\t";

            // 134 : Branch code - 632005
            $batchFile .= "\t1\t" . $cashout->branch_code;

            // 135 : Filler - 0
            // $batchFile .= "\t";

            // 136 : Bank account number - 40600000004
            $batchFile .= "\t0\t" . $cashout->account_number;

            // 162 : Amount (cents) - 110200
            $batchFile .= "\t" . $amount;

            // 252 : Beneficiary statement reference - Dated  sal test
            $batchFile .= "\tThe Brand Surgeon Cashout\n";
        }

        $batchFile .= "F\t" . $cashouts->count() . "\t" . $total . "\t9999";



        return $batchFile;
        
    }

    /**
     * Convert Cashout amount to cents
     */
    private function convertCashoutAmountToCents(int $points): int
    {
        $rands = $points / 10;
        return  $rands * 100;
    }

    public function change_profile(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
          
            $data = Respondents::find($resp_id);
            return view('user.update_image', compact('data'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function image_update(Request $request){
        try {

            $resp_id =Session::get('resp_id');
            $check_data=Respondents::find($resp_id);
            if ($request->hasFile('image')) {
                // image restriction
                $validator = \Validator::make(
                    $request->all(), [
                        'image' => 'mimes:jpeg,jpg,png,gif|required|max:20480',
                    ]
                );

                $image = request()->file('image');
                $imageName = time().'.'.$request->image->extension();
                if (!file_exists(public_path() . '/uploads/'.Session::get('resp_id'))) {
                    mkdir(public_path() . '/uploads/'.Session::get('resp_id'));
                }  
                $path = 'uploads/'.Session::get('resp_id').'/';
             
                move_uploaded_file($_FILES["image"]["tmp_name"], $path . $imageName);

                $data=array('profile_image'=>$imageName,'profile_path'=>$path);
                
                Respondents::where('id',$resp_id)->update($data);
            
                return response()->json([
                    'status'  => 200,
                    'success' => true,
                    'message' =>'Profile Image successfully Updated.'
                ]);
            }elseif($check_data->profile_image==null){
                return response()->json([
                    'status'  => 500,
                    'success' => true,
                    'message' =>'Please Upload Your Profile Image.'
                ]);
            }else{
                return response()->json([
                    'status'  => 400,
                    'success' => true,
                    'message' =>'Profile Image already Updated.'
                ]);
            }
              
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function about_the_brand(){

        try {
            
        
            return view('user.about_brand');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }


    public function forgot_password_sms(){
        try {
            
        
            return view('auth.forgot-paaswword-sms');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function forgot_password_check(Request $request) {
        try {
            // Clean and validate phone number
            $phone = str_replace(' ', '', $request->phone);
            
            // Ensure phone number contains only digits
            if (!ctype_digit($phone)) {
                return redirect()->back()->with('error', 'Invalid phone number format');
            }
    
            // Validate phone number length (less than or equal to 9 digits)
            if (strlen($phone) > 9) {
                return redirect()->back()->with('error', 'Invalid phone number format: Must be 9 digits or less');
            }
    
            // Check if the phone number exists
            $user = Respondents::where('mobile', $phone)
                ->orWhere('whatsapp', $phone)
                ->first();
    
            if (!$user) {
                throw new Exception('Mobile number not found');
            }
    
            // Create a new password reset token
            $token = Password::broker()->createToken($user);
    
            // Store the token with an expiration time (60 minutes)
            $expiresAt = now()->addMinutes(60);
            // Assuming you have a PasswordResetsViaPhone model to store the token and expiration
            PasswordResetsViaPhone::updateOrCreate(
                ['phone' => $phone],  // Use $phone variable instead of $user->phone
                ['token' => $token, 'updated_at' => Carbon::now()]
            );
    
            // Generate password reset URL
            $resetUrl = url('password_reset_sms', ['token' => $token, 'phone' => $phone]);
    
            // Prepare SMS content
            $smsContent = "Reset Password Notification\n\n";
            $smsContent .= "You are receiving this message because we received a password reset request for your account.\n";
            $smsContent .= "Click the following link to reset your password:\n";
            $smsContent .= $resetUrl . "\n\n";  // Include the reset URL
            $smsContent .= "If you did not request a password reset, no further action is required.\n";
            $smsContent .= "This password reset link will expire in 60 minutes.";
    
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
            Log::info('SMS API Response: ' . $response);
    
            // Check if response indicates success
            if (strpos($response, 'Accepted for delivery') !== false) {
                return redirect()->back()->with('status', 'SMS sent successfully!');
            } else {
                throw new Exception('Failed to send SMS. API response: ' . $response);
            }
    
        } catch (Exception $e) {
            // Log the exception with more details
            Log::error('SMS API Error: ' . $e->getMessage() . ' - Code: ' . $e->getCode());
    
            // Redirect with an error message
            return redirect()->back()->with('error', 'Failed to send SMS. ' . $e->getMessage());
        }
    }
    

    public function password_reset_sms(Request $request){
        try {
            $token = $request->route('token');
            $phone = $request->route('phone');
            return view('auth.reset-sms-password', compact('token','phone'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    

    public function admin_password_reset(Request $request){
        try {
            $token = $request->route('token');
            $email = $request->route('email');
            return view('admin.admin-reset', compact('token','email','request'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    
    public function user_get_branch_code(Request $request){
        $bank_id = $request->bank_id;
        $branch_code=Banks::where('id',$bank_id)->first();
        $repsonse=$branch_code->branch_code;

        return response()->json(['repsonse' => $repsonse], 200);
    }
    

}
