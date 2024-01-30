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
use App\Models\Action;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
class ActionController extends Controller
{   
    public function actions()
    {   
        try {
            return view('admin.action.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }
    public function get_all_actions(Request $request) {
        try {
            if ($request->ajax()) {

                $token = csrf_token();
            
            $all_datas = Action::select('action_events.*','users.name as uname')
            ->join('users', 'users.id', '=', 'action_events.user_id') 
            ->limit(30)
            ->get();
  
            
            return Datatables::of($all_datas)
             
            ->addColumn('name', function ($all_data) {
                return $all_data->name;
            })  
            ->addColumn('uname', function ($all_data) {
                return $all_data->uname;
            })  
            ->addColumn('target_id', function ($all_data) {
                return $all_data->target_id;
            })  
            ->addColumn('status', function ($all_data) {
                return $all_data->status;
            })
            ->addColumn('updated_at', function ($all_data) {
                return date("M j, Y, g:i A", strtotime($all_data->updated_at));
            })  
            ->addColumn('action', function ($all_data) use($token) {
    
                return '<div class="">
                <div class="btn-group mr-2 mb-2 mb-sm-0">
                    <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></button>
                </div></div>';
                
            })
            ->rawColumns(['action','name','uname','target_id'])      
            ->make(true);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        

    }
}