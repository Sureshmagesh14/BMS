<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects;
use App\Models\Project_respondent;

use App\Models\Users;
use App\Models\Respondents;
use DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Exception;
use Config;
use App\Mail\WelcomeEmail;

use App\Imports\RespondentsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProjectsController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.projects.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $users = Users::withoutTrashed()->select('id','name','surname')->latest()->get();
            $survey_title=DB::table('survey')->select('title','id')->where('survey_type','=','survey')->orderBy('id', 'DESC')->get();
            $returnHTML = view('admin.projects.create',compact('users','survey_title'))->render();

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        try {

            Session::forget('user_to_project');
            Session::forget('user_to_project_id');
            
            $validator = Validator::make($request->all(), [
               'client'=> 'required',
               'name'=> 'required',
               'user'=> 'required',
               'status_id'=> 'required',
               'type_id'=> 'required',
               'survey_duration'=> 'required',
               'published_date'=> 'required',
               'access_id'=> 'required',

            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
               
                $projects = new Projects;
                $projects->number = $request->input('number');
                $projects->client = $request->input('client');
                $projects->name = $request->input('name');
                $projects->user_id = $request->input('user');
                $projects->type_id = $request->input('type_id');
                $projects->reward = $request->input('reward');
                $projects->project_link = $request->input('project_link');
                $projects->status_id = $request->input('status_id');
                $projects->description = $request->input('description');
                $projects->description1 = $request->input('description1');
                $projects->description2 = $request->input('description2');
                $projects->survey_duration = $request->input('survey_duration');
                $projects->published_date = $request->input('published_date');
                $projects->closing_date = $request->input('closing_date');
                $projects->access_id = $request->input('access_id');
                $projects->survey_link = $request->input('survey_link');
                $projects->save();
                $projects->id;
                app('App\Http\Controllers\InternalReportController')->call_activity(Auth::guard('admin')->user()->role_id,Auth::guard('admin')->user()->id,'created','project');
                return response()->json([
                    'status'=>200,
                    'last_insert_id' => $projects->id,
                    'message'=>'Projects Added Successfully.'
                ]);
            }

        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        try {
            $data = Projects::find($id);
            return view('admin.projects.view',compact('data'));

           
            
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $projects = Projects::find($id);
            if($projects)
            {
                $users = Users::withoutTrashed()->select('id','name','surname')->latest()->get();
                $survey_title=DB::table('survey')->select('title','id')->where('survey_type','=','survey')->orderBy('id', 'DESC')->get();
                $returnHTML = view('admin.projects.edit',compact('projects','users','survey_title'))->render();
                
                return response()->json(
                    [
                        'success' => true,
                        'html_page' => $returnHTML,
                    ]
                );
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Projects Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
       
    }

    public function copy(string $id)
    {
        try {
           
            $projects = Projects::find($id);
            if($projects)
            {
                $users = Users::withoutTrashed()->select('id','name','surname')->latest()->get();
                $survey_title=DB::table('survey')->select('title','id')->where('survey_type','=','survey')->get();
                $returnHTML = view('admin.projects.copy',compact('projects','users','survey_title'))->render();
                return response()->json(
                    [
                        'success' => true,
                        'html_page' => $returnHTML,
                    ]
                );
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Projects Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'client'=> 'required',
                'name'=> 'required',
                'user'=> 'required',
                'status_id'=> 'required',
                'type_id'=> 'required',
                'survey_duration'=> 'required',
                'published_date'=> 'required',
                'access_id'=> 'required',
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
               
                $projects = Projects::find($request->id);
                if($projects)
                {
                    
                    $projects->number = $request->input('number');
                    $projects->client = $request->input('client');
                    $projects->name = $request->input('name');
                    $projects->user_id = $request->input('user');
                    $projects->type_id = $request->input('type_id');
                    $projects->reward = $request->input('reward');
                    $projects->project_link = $request->input('project_link');
                    $projects->status_id = $request->input('status_id');
                    $projects->description = $request->input('description');
                    $projects->description1 = $request->input('description1');
                    $projects->description2 = $request->input('description2');
                    $projects->survey_duration = $request->input('survey_duration');
                    $projects->published_date = $request->input('published_date');
                    $projects->closing_date = $request->input('closing_date');
                    $projects->access_id = $request->input('access_id');
                    $projects->survey_link = $request->input('survey_link');
                    $projects->update();
                    $projects->id;
                    app('App\Http\Controllers\InternalReportController')->call_activity(Auth::guard('admin')->user()->role_id,Auth::guard('admin')->user()->id,'updated','project');
                    return response()->json([
                        'status'=>200,
                        'last_insert_id' => $projects->id,
                        'message' => 'Projects Updated.',
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Projects Found.'
                    ]);
                }
    
            }
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $projects = Projects::find($id);
            app('App\Http\Controllers\InternalReportController')->call_activity(Auth::guard('admin')->user()->role_id,Auth::guard('admin')->user()->id,'deleted','project');
            if($projects)
            {
                $projects->delete();
                return response()->json([
                    'status'=>200,
                    'success' => true,
                    'message'=>'Projects Deleted Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'success' => false,
                    'message'=>'No Projects Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }

    public function get_all_projects(Request $request) {
		
        try {
            if ($request->ajax()) {
                $all_datas = Projects::select('projects.*','projects.name as uname')
                    ->join('users', 'users.id', '=', 'projects.user_id');
                    if(isset($request->id)){
                        if($request->inside_form == 'respondents'){
                            $all_datas->join('project_respondent','project_respondent.project_id', 'projects.id')->where('project_respondent.respondent_id',$request->id);
                        }
                    }
                $all_datas = $all_datas->orderby("id","desc")->get();

                return Datatables::of($all_datas)
                    ->addColumn('select_all', function ($all_data) {
                        return '<input class="tabel_checkbox" name="projects[]" type="checkbox" onchange="table_checkbox(this,\'projects_table\')" id="'.$all_data->id.'">';
                    })
                    ->addColumn('id_show', function ($all_data) {
                        $view_route = route("projects.show",$all_data->id);
                        $type_id='';
                        if($all_data->type_id==1){
                            $type_id= 'Pre-Screener';
                        }else if($all_data->type_id==2){
                            $type_id= 'Pre-Task';
                        }else if($all_data->type_id==3){
                            $type_id= 'Paid  survey';
                        }else if($all_data->type_id==4){
                            $type_id= 'Unpaid  survey';
                        }else{  
                            $type_id='-';
                        }
                  
                       
                        return '<a title="'.$all_data->number."-".$all_data->client."-".$all_data->name."-".$type_id.'" href="'.$view_route.'" data-bs-original-title="View Project" class="rounded waves-light waves-effect">
                            '.$all_data->number."-".$all_data->client."-".$all_data->name."-".$type_id.'
                        </a>';
                    })
                    ->addColumn('numbers', function ($all_data) {
                        return $all_data->number;
                    })  
                    ->addColumn('client', function ($all_data) {
                        return $all_data->client;
                    })  
                    ->addColumn('name', function ($all_data) {
                        return $all_data->description;
                    }) 
                    ->addColumn('creator', function ($all_data) {
                        $get_name=Projects::get_user_name($all_data->user_id);
                        return $get_name->name.''.$get_name->lname;
                    })
                    ->addColumn('type', function ($all_data) {
                        if($all_data->type_id==1){
                            return 'Pre-Screener';
                        }else if($all_data->type_id==2){
                            return 'Pre-Task';
                        }else if($all_data->type_id==3){
                            return 'Paid  survey';
                        }else if($all_data->type_id==4){
                            return 'Unpaid  survey';
                        }else{  
                            return '-';
                        }
                    })
                    ->addColumn('reward_amount', function ($all_data) {
                        return $all_data->reward;
                    })
                    ->addColumn('project_link', function ($all_data) {
                        return $all_data->project_link;
                    })
                    ->addColumn('created', function ($all_data) {
                        return date("M j, Y, g:i A", strtotime($all_data->created_at));
                    })
                    ->addColumn('status', function ($all_data) {
                        if($all_data->status_id==1){
                            return 'Pending';
                        }else if($all_data->status_id==2){
                            return 'Active';
                        }else if($all_data->status_id==3){
                            return 'Completed';
                        }else if($all_data->status_id==4){
                            return 'Cancelled';
                        }else{  
                            return '-';
                        }
                    })
                    ->addColumn('action', function ($all_data) {
                        $edit_route = route("projects.edit",$all_data->id);
                        $view_route = route("projects.show",$all_data->id);
                        $copy_route = route("projects_copy",$all_data->id);
                        $design = '<div class="col-md-2">
                            <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                                title="Action" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-center">
                                <li class="list-group-item">
                                    <a href="'.$view_route.'" data-bs-original-title="View Project" class="rounded waves-light waves-effect">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                </li>';
                                if (str_contains(url()->previous(), '/admin/respondents')){
                                    $design .= '<li class="list-group-item">
                                        <a href="#!" id="deattach_projects" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                            <i class="far fa-trash-alt"></i> Deattach
                                        </a>
                                    </li>';
                                }
                                else{
                                    $design .= '<li class="list-group-item">
                                        <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                            data-bs-original-title="Edit Project" class="rounded waves-light waves-effect">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#!" data-url="'.$copy_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                            data-bs-original-title="Copy Project" class="rounded waves-light waves-effect">
                                            <i class="fa fa-copy"></i> Copy
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#!" id="delete_projects" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                            <i class="far fa-trash-alt"></i> Delete
                                        </a>
                                    </li>';
                                }
                            $design .= '</ul>
                        </div>';

                        if(Auth::guard('admin')->user()->role_id == 1){
                            return $design;
                        }
                        else{
                            if(Auth::guard('admin')->user()->id == $all_data->user_id){
                                return $design;
                            }
                            else{
                                return '-';
                            }
                        }
                    })
                    ->rawColumns(['id_show','select_all','action','numbers','client','name','creator','type','reward_amount','project_link','created','status'])      
                    ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function projects_export(Request $request) {

        $module_name = $request->module_name;
        $from = date('Y-m-d',strtotime($request->start));
        $to = date('Y-m-d',strtotime($request->end));

        $type='xlsx';

        if($module_name=='projects_details_export'){


            $all_datas = Projects::select('projects.*','projects.name as uname')
            ->join('users', 'users.id', '=', 'projects.user_id') 
            ->orderby("id","desc")
            ->whereBetween('projects.created_at', [$from, $to])
            ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Number/Code');
            $sheet->setCellValue('B1', 'Client');
            $sheet->setCellValue('C1', 'Name');
            $sheet->setCellValue('D1', 'Creator');
            $sheet->setCellValue('E1', 'Type');
            $sheet->setCellValue('F1', 'Reward Amount');
            $sheet->setCellValue('G1', 'Project Link');

            $rows = 2;
            $i=1;
            foreach($all_datas as $all_data){

            if($all_data->type_id==1){
            $type_val = 'Pre-Screener';
            }else if($all_data->type_id==2){
            $type_val =  'Pre-Task';
            }else if($all_data->type_id==3){
            $type_val =  'Paid  survey';
            }else if($all_data->type_id==4){
            $type_val =  'Unpaid  survey';
            }else{  
            $type_val =  '-';
            }

            $sheet->setCellValue('A' . $rows, $i);
            $sheet->setCellValue('B' . $rows, $all_data->number);
            $sheet->setCellValue('C' . $rows, $all_data->client);
            $sheet->setCellValue('D' . $rows, $all_data->description);
            $sheet->setCellValue('E' . $rows, $type_val);
            $sheet->setCellValue('F' . $rows, $all_data->reward);
            $sheet->setCellValue('G' . $rows, $all_data->project_link);


            $rows++;
            $i++;
            }

            $fileName = "project_".date('ymd').".".$type;
            

        }else if($module_name=='projects_summary_export'){
        
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Month');
            $sheet->setCellValue('B1', 'Year');
            $sheet->setCellValue('C1', 'Average Response Time');
            $sheet->setCellValue('D1', 'Average Response Rate');
            $sheet->setCellValue('E1', 'Average Completion Rate');
            $sheet->setCellValue('F1', 'Average Conversion Rate (Response & Completion)');
            $sheet->setCellValue('G1', 'Average Drop-Out Rate');

            $fileName = "project_respondent_month_".date('ymd').".".$type;

        }else if($module_name=='projects_summary_resp_export'){

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(25);
            
            $sheet->setCellValue('A1', 'Respondent Profile ID');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('C1', 'Surname');
            $sheet->setCellValue('D1', 'Phone Number');
            $sheet->setCellValue('E1', 'WhatsApp Number');
            $sheet->setCellValue('F1', 'Email');
            $sheet->setCellValue('G1', 'Average Response Time');
            $sheet->setCellValue('H1', 'Response Rate');
            $sheet->setCellValue('I1', 'Completion Rate');
            $sheet->setCellValue('J1', 'Conversion Rate (Response & Completion)');
            $sheet->setCellValue('K1', 'Drop-Out Rate');
            
            $all_datas = DB::table('project_respondent')->select('respondents.name as rname','respondents.surname as rsurname','respondents.email as remail','respondents.mobile as rmobile','respondents.whatsapp as rwhatsapp')
                ->join('respondents', 'respondents.id', '=', 'project_respondent.respondent_id') 
                ->join('projects', 'projects.id', '=', 'project_respondent.project_id') 
                ->whereBetween('project_respondent.created_at', ["'".$from."'", "'".$to."'"])
                ->orderby("project_respondent.id","desc")
                ->get();

            $rows = 2;
            $sno = 1;
            foreach($all_datas as $all_data){

                $sheet->setCellValue('A' . $rows, $sno);
                $sheet->setCellValue('B' . $rows, $all_data->rname);
                $sheet->setCellValue('C' . $rows, $all_data->rsurname);
                $sheet->setCellValue('D' . $rows, $all_data->rmobile);
                $sheet->setCellValue('E' . $rows, $all_data->rwhatsapp);
                $sheet->setCellValue('F' . $rows, $all_data->remail);
                
                $sno++;
                $rows++;
            }
            
            $fileName = "project_respondent_".date('ymd').".".$type;
        }
        
        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
            $writer->save("export/".$fileName);
            
            header("Content-Type: application/vnd.ms-excel");
            return redirect(url('/')."/export/".$fileName);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function export_projects()
    {
        try {
           
            $returnHTML = view('admin.projects.export')->render();

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

    public function projects_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            app('App\Http\Controllers\InternalReportController')->call_activity(Auth::guard('admin')->user()->role_id,Auth::guard('admin')->user()->id,'deleted','project');
            foreach($all_id as $id){
                $rewards = Projects::find($id);
                $rewards->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Projects Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deattach_project($resp_id, $project_id){
        try {
            if(Project_respondent::where('project_id', $project_id)->where('respondent_id', $resp_id)->exists()){
                Project_respondent::where('project_id', $project_id)->where('respondent_id', $resp_id)->delete();
                return response()->json([
                    'text_status' => true,
                    'status' => 200,
                    'message' => 'Deattach Project Successfully.',
                ]);
            }
            else{
                return response()->json([
                    'text_status' => false,
                    'status' => 200,
                    'message' => 'Cant find respondents or projects',
                ]);
            }
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function attach_projects(Request $request){
        try {
            $respondent_id = $request->respondent_id;

            $respondents = Respondents::select('respondents.id','respondents.name','respondents.surname')->where('respondents.id',$respondent_id)->first();
           
            $returnHTML = view('admin.projects.attach', compact('respondents'))->render();

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

    public function project_seach_result(Request $request){
        try {
            $searchValue = $request['q'];
            
            if($request->filled('q')){
                $projects_data = Projects::search($searchValue)
                ->query(function ($query) {
                    $query->where('deleted_at', '=', NULL);
                })
                ->orderBy('id','ASC')
                ->get();
            }

            $projects = array();
            if(count($projects_data) > 0){
                foreach($projects_data as $resp){
                    $setUser = [
                        'id' => $resp->id,
                        'name' => $resp->name . ' - ' . $resp->surname,
                    ];
                    $projects[] = $setUser;
                }
            }

            echo json_encode($projects);
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function project_attach_store(Request $request){
        try {
            $project_id  = $request->project_id;
            $respondents = $request->respondents;

            if(Project_respondent::where('project_id', $project_id)->where('respondent_id', $respondents)->exists()){
                return response()->json([
                    'text_status' => false,
                    'status' => 200,
                    'message' => 'Project Already Attached.',
                ]);
            }
            else{
                Project_respondent::insert(['project_id' => $project_id, 'respondent_id' => $respondents]);

                $proj = Projects::where('id',$project_id)->first();
                $resp = Respondents::where('id',$respondents)->first();

                //email starts
                if($proj->name!='')
                {
                    $to_address = $resp->email;
                    //$to_address = 'hemanathans1@gmail.com';
                    $resp_name = $resp->name.' '.$resp->surname;
                    $proj_name = $proj->name;

                    $data = ['subject' => 'New Survey Assigned','name' => $resp_name,'project' => $proj_name,'type' => 'new_project'];
                
                    Mail::to($to_address)->send(new WelcomeEmail($data));
                }
                //email ends

                return response()->json([
                    'text_status' => true,
                    'status' => 200,
                    'message' => 'Project Attached Successfully.',
                ]);
            }
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function project_action(Request $request){
        try {
            $all_id = $request->all_id;
            $value  = $request->value;
           
            foreach($all_id as $id){
                $tags = Projects::where('id',$id)->update(['status_id' => $value]);
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Status Changed'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function get_survey_link(Request $request){
        $survey_id = $request->survey_id;
        $app_url=config('app.url'); 
        $get_survey=Projects::get_survey($survey_id);
        $repsonse=$app_url.'/survey/view/'.$get_survey->builderID;

        return response()->json(['repsonse' => $repsonse], 200);
    }

    public function respondent_attach_import(Request $request){
        $project_id = $request->project_id;
        $file = $request->file('file');

        // File Details 
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("csv");
        if(in_array(strtolower($extension),$valid_extension)){
            // File upload location
            $location = 'uploads/csv/'.$project_id;
            // Upload file
            $file->move($location,$filename);
            // Import CSV to Database
            $filepath = public_path($location."/".$filename);

            $file = fopen($filepath,"r");

            $importData_arr = array();
            $i = 0;
            $col=1;
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                // Skip first row (Remove below comment if you want to skip the first row)
                if($i == 0){
                    $i++;
                    continue;
                }

                if($num == $col){
                    for ($c=0; $c < $num; $c++) {
                        $set_array = array('respondent_id' => $filedata [$c],'project_id' => $project_id);
                        array_push($importData_arr,$set_array);
                    }
                    $i++;
                }
                else{
                    return redirect()->back()->with('error','Column mismatched!');
                    break;
                }
            }
            fclose($file);
            
            Project_respondent::insert($importData_arr);

            return redirect()->back()->with('success','Attached Successfully');
            
        }
        else{
            return redirect()->back()->with('error','Invalid File Extension, Please Upload CSV File Format');
        }
        
    }
    
}
