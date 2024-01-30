<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Banks;
use App\Models\Contents;
use App\Models\Networks;
use App\Models\Charities;
use App\Models\Groups;
use App\Models\Tags;
use App\Models\Respondents;
use App\Models\Projects;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
class ProjectsController extends Controller
{   
    public function projects()
    {   
        try {
            return view('admin.projects.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    
    }

    public function get_all_projects(Request $request) {
		
        try {
                    if ($request->ajax()) {


                        $token = csrf_token();
                    
                        $all_datas = Projects::select('projects.*','projects.name as uname')
                        ->join('users', 'users.id', '=', 'projects.user_id') 
                        ->orderby("id","desc")
                        ->get();
                
                        
                        return Datatables::of($all_datas)
                        
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
                        ->addColumn('action', function ($all_data) use($token) {
                
                            return '<div class="">
                            <div class="btn-group mr-2 mb-2 mb-sm-0">
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></button>
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class="far fa-trash-alt"></i></button>
                            </div>              
                        </div>';
                            
                        })
                        ->rawColumns(['action','numbers','client','name','creator','type','reward_amount','project_link','created','status'])      
                        ->make(true);
                            
                      
                    }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
        

    }
}