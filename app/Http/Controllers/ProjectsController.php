<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Projects;
use App\Models\Users;
use DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Exception;

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
            $returnHTML = view('admin.projects.create',compact('users'))->render();

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
                $returnHTML = view('admin.projects.edit',compact('projects','users'))->render();
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
                    ->join('users', 'users.id', '=', 'projects.user_id') 
                    ->orderby("id","desc");
                    if(isset($request->id)){
                        $all_datas->where('user_id',$request->id);
                    }
                $all_datas = $all_datas->get();

                return Datatables::of($all_datas)
                    ->addColumn('select_all', function ($all_data) {
                        return '<input class="tabel_checkbox" name="projects[]" type="checkbox" onchange="table_checkbox(this)" id="'.$all_data->id.'">';
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
                        return $all_data->uname;
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
                                </li>
                                <li class="list-group-item">
                                    <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                        data-bs-original-title="Edit Project" class="rounded waves-light waves-effect">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#!" id="delete_projects" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                        <i class="far fa-trash-alt"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>';

                        if(Auth::user()->role_id == 1){
                            return $design;
                        }
                        else{
                            if(Auth::user()->id == $all_data->user_id){
                                return $design;
                            }
                            else{
                                return '-';
                            }
                        }
                    })
                    ->rawColumns(['select_all','action','numbers','client','name','creator','type','reward_amount','project_link','created','status'])      
                    ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function projects_export($type) {

        $type='xlsx';

        $all_datas = Projects::select('projects.*','projects.name as uname')
        ->join('users', 'users.id', '=', 'projects.user_id') 
        ->orderby("id","desc")
        ->limit(10)
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
        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
            $writer->save("export/".$fileName);
            
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/export/".$fileName);
    }

    public function projects_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
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
}