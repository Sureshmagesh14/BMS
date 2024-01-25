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
use DB;
use Yajra\DataTables\DataTables;

class RewardsController extends Controller
{   
    public function rewards()
    {   
      
        
        return view('admin.rewards.index');
    }
    public function get_all_rewards(Request $request) {
		
        if ($request->ajax()) {

            $token = csrf_token();
        
            
            $all_datas = DB::table('rewards')
            ->orderby("id","desc")
            ->get();
    
            
            return Datatables::of($all_datas)
            ->addColumn('points', function ($all_data) {
                return $all_data->points;
            })            
            ->addColumn('status_id', function ($all_data) {
                return $all_data->status_id;
            }) 
            ->addColumn('respondent_id', function ($all_data) {
                return $all_data->respondent_id;
            })    
            ->addColumn('user_id', function ($all_data) {
                return $all_data->user_id;
            }) 
            ->addColumn('project_id', function ($all_data) {
                return $all_data->project_id;
            }) 
            ->addColumn('action', function ($all_data) use($token) {
    
                return '<div class="">
                <div class="btn-group mr-2 mb-2 mb-sm-0">
                    <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></button>
                </div>              
            </div>';
                
            }) 
            ->rawColumns(['action','active','points','status_id','respondent_id','user_id','project_id'])      
            ->make(true);
        }

    }
}