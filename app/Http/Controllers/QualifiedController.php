<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\WelcomeEmail;
use App\Models\Banks;
use App\Models\Contents;
use App\Models\Groups;
use App\Models\Respondents;
use App\Models\RespondentProfile;
use App\Models\Rewards;
use App\Models\Users;
use App\Models\PasswordResetsViaPhone;
use App\Models\Projects;
use App\Models\Cashout;
use App\Models\Networks;
use App\Models\Charities;
use App\Models\QualifiedRespondent;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Mail;
use Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use Config;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;

class QualifiedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.qualified.index');
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
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function get_all_qualified(Request $request){
        try {
            if ($request->ajax()) {
                $all_datas = QualifiedRespondent::select('qualified_respondent.*','respondents.name','respondents.surname')
                    ->join('respondents','respondents.id', 'qualified_respondent.respondent_id');
                    if(isset($request->id)){
                        if($request->inside_form == 'projects'){
                            $all_datas->where('qualified_respondent.project_id',$request->id);
                        }
                    }
                $all_datas = $all_datas->orderby("qualified_respondent.id","desc")->get();

                return Datatables::of($all_datas)
                    ->addColumn('select_all', function ($all_data) {
                        return '<input class="tabel_checkbox" name="projects[]" type="checkbox" onchange="table_checkbox(this,\'projects_table\')" id="'.$all_data->id.'">';
                    })
                    ->addColumn('respondent_id', function ($all_data) {
                        return $all_data->respondent_id;
                    })
                    ->addColumn('name', function ($all_data) {
                        return $all_data->name;
                    })
                    ->addColumn('surname', function ($all_data) {
                        return $all_data->surname;
                    })
                    ->addColumn('points', function ($all_data) {
                        return ($all_data->points != 0) ? $all_data->points/ 10 : 0;
                    })
                    ->addColumn('status', function ($all_data) {
                        return ($all_data->status == 1) ? 'Qualified' : 'Not-Qualified';
                    })
                    ->addColumn('created_at', function ($all_data) {
                        if(isset($all_data->created_at)){
                            $created_at=date("Y-m-d, g:i A", strtotime($all_data->created_at));
                        }else{
                            $created_at='-';
                        }
                        return $created_at;
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
                                if (str_contains(url()->previous(), '/admin/projects')){
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
                                        <a href="#!" id="delete_projects" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                            <i class="far fa-trash-alt"></i> Delete
                                        </a>
                                    </li>';
                                }
                            $design .= '</ul>
                        </div>';

                        return $design;
                        
                    })
                    ->rawColumns(['select_all','respondent_id','name','points','status','created_at','action'])      
                    ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function attach_qualified_respondents(Request $request){
        try {
            $project_id = $request->project_id;
            
            if($project_id == 0){
                $project_all = Projects::select('projects.id','projects.name')->orderBy('name','ASC')->get();
                $returnHTML = view('admin.qualified.attach', compact('project_all'))->render();
            }
            else{
                $projects = Projects::select('projects.id','projects.name')->where('projects.id',$project_id)->first();
                $get_resp = DB::table('project_respondent as pro_resp')->select('resp.*')
                    ->join('respondents as resp', 'pro_resp.respondent_id', 'resp.id')
                    ->where('pro_resp.project_id',$project_id)->get();
                $returnHTML = view('admin.qualified.attach_inside', compact('projects','project_id', 'get_resp'))->render();
            }

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

    public function get_resp_details(Request $request){
        $select = '<option value="" disabled>Select Respondent</option>';
        $project_id = $request->project_id;

        $get_resp = DB::table('project_respondent as pro_resp')->select('resp.*')
            ->join('respondents as resp', 'pro_resp.respondent_id', 'resp.id')
            ->where('pro_resp.project_id',$project_id)->get();

        if(count($get_resp) > 0){
            foreach($get_resp as $resp){
                $select .= '<option value="'.$resp->id.'">'.$resp->name.' '.$resp->surname.'</option>';
            }
        }
        else{
            $select .= '<option value="">OPPS! No Respondent</option>';
        }

        return $select;
    }

    public function qualified_respondent_attach_store(Request $request){
        try {
            $project_id = $request->project_id;
            $respondents = $request->respondents;

            $projects = Projects::where('id',$project_id)->first();

            if($projects != null){
                foreach($respondents as $resp){
                    if (DB::table('qualified_respondent')->where('project_id', $projects->id)->where('respondent_id', $resp)->doesntExist()) {
                        $insert = array(
                            'respondent_id' => $resp,
                            'project_id' => $projects->id,
                            'points' => $projects->reward,
                            'status' => 1
                        );

                        QualifiedRespondent::insert($insert);
                    }
                }
            }

            return array('text_status' => true, 'message' => 'Selected Respondent is Qualified');
        }
        catch (Exception $e) {
            return array('text_status' => false, 'message' => 'Something Went Wrong');
            throw new Exception($e->getMessage());
        }
    }
}