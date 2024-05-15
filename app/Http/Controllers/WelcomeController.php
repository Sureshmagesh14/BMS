<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Yajra\DataTables\DataTables;
use App\Models\Respondents;
use App\Models\Contents;
use App\Models\Groups;
use App\Models\Projects;
use App\Models\Banks;
use App\Models\Rewards;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Facades\Hash;
use Exception;
use Carbon\Carbon;

class WelcomeController extends Controller
{   
    public function home(Request $request)
    {   
        try {
            if($request->r!=''){
                $referral_code = $request->r;
            
                $id =Session::get('resp_id');
                $data = Respondents::find($id);
    
                $data =Respondents::where('referral_code', $referral_code)->first();
                Session::put('refer_id',  $data->id);
                
            }else{
                $data='';
            }

            return view('welcome', compact('data'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function terms()
    {   
        try {
            $id=1;
            $data = Contents::find($id);
            return view('user.user-terms', compact('data'));
        }
        catch (Exception $e) {
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
        }
        catch (Exception $e) {
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
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_dashboard(Request $request){
        try {
            Session::put('resp_id',  $request->user()->id);
            Session::put('resp_name', $request->user()->name);
            
            $id =Session::get('resp_id');
            $data = Respondents::find($id);
            
            $pdata = DB::select("SELECT t1.id,t1.qus_count,sum(if(t2.id is not null,1,0)) as ans_count FROM survey t1 LEFT JOIN survey_response t2 ON t1.id = t2.survey_id WHERE t1.survey_type='profile' AND t2.skip IS NULL GROUP BY t1.id;");
            
            $tot_rows= count($pdata);
            $ans_c = 0;
            foreach ($pdata as $key => $value) {
                $qus_count = $value->qus_count;
                $ans_count = $value->ans_count;

                if($qus_count==$ans_count){
                    $ans_c ++;
                }
            }
            //dd($pdata);
            if($tot_rows==$ans_c){
                Respondents::where('id',$id)->update(['profile_completion_id' => 1]);
            }
       
         
            if($tot_rows==0){
                $percentage = 0;
            }else{
                $percentage = ($ans_c / $tot_rows) * 100; // 20
                $percentage = round($percentage);
            }
          

            $get_respondent = DB::table('projects')->select('projects.*','resp.is_complete','resp.is_frontend_complete')
                ->join('project_respondent as resp','projects.id','resp.project_id')
                ->where('resp.respondent_id','=',$id)
                ->where('projects.closing_date', '>=', Carbon::now())
                ->where('resp.is_frontend_complete',0)->get();

            $get_completed_survey = DB::table('projects')->select('projects.*','resp.is_complete','resp.is_frontend_complete')
                ->join('project_respondent as resp','projects.id','resp.project_id')
                ->where('resp.respondent_id',$id)
                ->where('projects.closing_date', '<', Carbon::now())->get();
           

            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{

                $get_resp = DB::table('project_respondent as resp')->select('resp.*','projects.reward')
                    ->join('projects','resp.project_id','projects.id')
                    ->where('resp.respondent_id',$id)
                    ->where('resp.is_frontend_complete',1)->get();
                
                if(!empty($get_resp)){
                    foreach($get_resp as $resp){
                        
                        if(isset($get_resp->project_id)){
                            $proj_id = $get_resp->project_id ?? 0;
                        }else{
                            $proj_id = 0;
                        }
                        if(isset($get_resp->respondent_id)){
                            $resp_id = $get_resp->respondent_id ?? 0;
                        }else{
                            $resp_id = 0;
                        }
                        if(isset($get_resp->reward)){
                            $rew_id = $get_resp->reward ?? 0;
                        }else{
                            $rew_id = 0;
                        }
                        
                        
                        if(DB::table('rewards')->where('project_id',$proj_id)->where('respondent_id',$resp_id)->doesntExist()){
                            
                            $insert_array = array(
                                'respondent_id' => $resp_id,
                                'project_id' => $proj_id,
                                'points' => $rew_id,
                                'status_id' => 1,
                            );
                            if($resp_id>0)
                            DB::table('rewards')->insert($insert_array);
                        }
                    }
                }
                
                
                return view('user.user-dashboard', compact('data','get_respondent','get_completed_survey','percentage'));
            //}
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_share(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            $get_res_phone=Respondents::select('whatsapp')->where('id', Session::get('resp_id'))->first();
            
            $data = Respondents::find($resp_id);
            $ref_code = $data->referral_code;
            
            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
                return view('user.user-share', compact('data','ref_code','get_res_phone'));
            //}
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_cashout(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');

            $get_res = DB::table('rewards')->where('respondent_id',$resp_id)->where('respondent_id',$resp_id)->get();
            
            $get_res = DB::table('rewards')->select('rewards.points','cashouts.type_id','cashouts.status_id','cashouts.amount','projects.name','cashouts.updated_at')
                ->join('cashouts','rewards.cashout_id','cashouts.id')
                ->join('projects','rewards.project_id','projects.id')
                ->where('rewards.respondent_id','=',$resp_id)->get();

            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
                return view('user.user-cashout')->with('get_res',$get_res);
            //}
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_rewards(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');

            $get_reward = Rewards::where('respondent_id',$resp_id)->where('status_id',2)->sum('points');

            $get_cashout = DB::table('respondents as resp')->select('resp.account_number','resp.account_holder','cashouts.*')
                ->join('cashouts','resp.id','cashouts.respondent_id')
                ->where('cashouts.type_id','!=',3)
                ->where('resp.id',$resp_id)->orderBy('cashouts.id','DESC')->first();

            if($get_cashout != null){
                $get_bank = DB::table('banks')->where('id',$get_cashout->bank_id)->first();;
            }
            else{
                $get_bank = null;
            }
            
            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
                return view('user.user-rewards')->with('get_reward',$get_reward)->with('get_cashout',$get_cashout)->with('get_bank',$get_bank);
            //}
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_surveys(Request $request){
        try {
            
            $up_id = $request->up;
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
            $data = Groups::where('id', $up_id)->first();

            $get_respondent = DB::table('projects')->select('projects.*','resp.is_complete','resp.is_frontend_complete')
                ->join('project_respondent as resp','projects.id','resp.project_id')
                ->where('resp.respondent_id','=',$resp_id)
                ->where('resp.is_frontend_complete',0)->get();

            $get_completed_survey = DB::table('projects')->select('projects.*','resp.is_complete','resp.is_frontend_complete')
                ->join('project_respondent as resp','projects.id','resp.project_id')
                ->where('resp.respondent_id',$resp_id)
                ->where('resp.is_frontend_complete',1)->get();

            // if($request->user()->profile_completion_id==0){
            //      return view('user.update-profile');
            // }else{
                return view('user.user-surveys',compact('data','get_respondent','get_completed_survey'));
            //}
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function user_editprofile(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
          
            $data = Respondents::find($resp_id);

            $profil   = DB::table('groups as gr')
                        ->leftjoin('survey as sr','gr.survey_id','=','sr.id') 
                        ->leftjoin('survey_response as resp','gr.survey_id','=','resp.survey_id') 
                        ->select('gr.name', 'sr.builderID','gr.type_id','resp.updated_at',DB::raw('(SELECT COUNT(*) FROM questions WHERE gr.survey_id = questions.survey_id) AS totq'),DB::raw('(SELECT COUNT(*) FROM survey_response WHERE survey_response.response_user_id='.$resp_id.' AND gr.survey_id = survey_response.survey_id AND survey_response.skip IS NULL) AS tota'))
                        ->where('gr.deleted_at', NULL)
                        ->orderBy('gr.sort_order', 'ASC')
                        ->groupBy('gr.id')
                        ->get();
            
            //dd($profil);
                        
            $prof_response   = DB::table('survey_response')
                                ->where('response_user_id', $resp_id)
                                ->get();
            
            return view('user.user-editprofile', compact('data','profil','prof_response'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_viewprofile(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
          
            $data = Respondents::find($resp_id);
            return view('user.user-viewprofile', compact('data'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_profile(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
                return view('user.user-profile');
            //}
           
        }
        catch (Exception $e) {
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
        
            if(isset($request->id)){
                if($inside_form == 'projects'){
                    $totalData = Respondents::Join('project_respondent as pr','respondents.id','pr.respondent_id')->where('pr.project_id',$request->id)->count();
                }
                else{

                    $totalData = Respondents::count();
                }
            }
            else{
                $totalData = Respondents::count();
            }

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            

            if (empty($request->input('search.value'))) {
                $posts = Respondents::select('respondents.*')->offset($start);
                    if(isset($request->id)){
                        if($inside_form == 'projects'){
                            $posts->Join('project_respondent as pr','respondents.id','pr.respondent_id')
                            ->where('pr.project_id',$request->id);
                        }
                    }
                $posts = $posts->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            }
            else {
                $search = $request->input('search.value');

                $posts = Respondents::select('respondents.*')->where('id', 'LIKE', "%{$search}%");
                    if(isset($request->id)){
                        if($inside_form == 'projects'){
                            $posts->Join('project_respondent as pr','respondents.id','pr.respondent_id')
                            ->where('pr.project_id',$request->id);
                        }
                    }
                $posts = $posts->orWhere('mobile', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->cursor();

                $totalFiltered = Respondents::where('id', 'LIKE', "%{$search}%");
                    if(isset($request->id)){
                        if($inside_form == 'projects'){
                            $totalFiltered->Join('project_respondent as pr','respondents.id','pr.respondent_id')
                            ->where('pr.project_id',$request->id);
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
                    $nestedData['select_all'] = '<input class="tabel_checkbox" name="networks[]" type="checkbox" onchange="table_checkbox(this,\'respondents_datatable\')" id="'.$post->id.'">';
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

                    $nestedData['id_show'] = '<a href="'.$view_route.'" class="rounded waves-light waves-effect">
                        '.$post->id.'
                    </a>';

                    $nestedData['options'] = '<div class="col-md-2">
                        <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                            title="Action" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-center">
                            <li class="list-group-item">
                                <a href="'.$view_route.'" class="rounded waves-light waves-effect">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </li>';
                            if (str_contains(url()->previous(), '/admin/projects')){

                                $nestedData['options'] .= '<li class="list-group-item">
                                    <a id="deattach_respondents" data-id="'.$post->id.'" class="rounded waves-light waves-effect">
                                        <i class="far fa-trash-alt"></i> De-attach
                                    </a>
                                </li>';
                            }
                            else{
                                $nestedData['options'] .= '<li class="list-group-item">
                                    <a data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                        data-bs-original-title="Edit Respondent" class="rounded waves-light waves-effect">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#!" id="delete_respondents" data-id="'.$post->id.'" class="rounded waves-light waves-effect">
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

    public function opt_out(Request $request){
        $resp_id = Session::get('resp_id');
        Respondents::where('id',$resp_id)->update(['active_status_id' => 3]);
        return response()->json([
            'status'=>200,
            'success' => true,
            'message'=> "We were bummed to hear that you're leaving us. We totally respect your decision to cancel, and we've started processing your request."
        ]);
    }

    public function cashout_form(Request $request){
        try {
            $points = $request->value;
            $banks = Banks::get();
            $returnHTML = view('user.cashout_request',compact('points','banks'))->render();

            return response()->json(
                [
                    'success' => true,
                    'html_page' => $returnHTML,
                ]
            );
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function cashout_sent(Request $request){
        $resp_id        = Session::get('resp_id');
        $banks          = $request->bank_value;
        $account_number = $request->account_number;
        $reward         = $request->reward;
        $branch_name    = $request->branch_name;
        $holder_name    = $request->holder_name;

        if($reward != 0){
            // $amount = ($reward / 10);
            $insert_array = array(
                'respondent_id' => $resp_id,
                'bank_id' => $banks,
                'type_id' => 1,
                'account_number' => $account_number,
                'amount' => $reward
            );
    
            DB::table('cashouts')->insert($insert_array);

            DB::table('respondents')->where('id',$resp_id)
                ->update(['account_number' => $account_number, 'account_holder' => $holder_name]);
        }

        return redirect()->back()->withsuccess('Request Send Successfully');
    }

}