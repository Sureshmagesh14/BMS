<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Banks;
use App\Contents;
use App\Networks;
use App\Charities;
use App\Groups;
use App\Tags;
use App\Respondents;
use App\Projects;
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
            
                
                $all_datas = DB::table('projects')
                ->orderby("id","desc")
                ->limit(10)
                ->get();
        
                
                return Datatables::of($all_datas)
                 
                ->addColumn('numbers', function ($all_data) {
                    return $all_data->number;
                })  
                ->addColumn('client', function ($all_data) {
                    return $all_data->client;
                })  
                ->addColumn('name', function ($all_data) {
                    return $all_data->name;
                }) 
                ->addColumn('creator', function ($all_data) {
                    return '-';
                })
                ->addColumn('type', function ($all_data) {
                    return '-';
                })
                ->addColumn('reward_amount', function ($all_data) {
                    return '-';
                })
                ->addColumn('project_link', function ($all_data) {
                    return '-';
                })
                ->addColumn('created', function ($all_data) {
                    return '-';
                })
                ->addColumn('status', function ($all_data) {
                    return '-';
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