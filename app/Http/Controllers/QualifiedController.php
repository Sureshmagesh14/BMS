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
                        return $all_data->name.' '.$all_data->surname;
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
}
