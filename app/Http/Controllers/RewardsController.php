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
use App\Models\Rewards;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
class RewardsController extends Controller
{   
    public function index()
    {   
        try {
            return view('admin.rewards.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
       
    }
    public function get_all_rewards(Request $request) {
		
        try {
            if ($request->ajax()) {

                $token = csrf_token();
                
                $all_datas = Rewards::select('rewards.*','respondents.name as rname','respondents.email as remail','respondents.mobile as rmobile','users.name as uname','projects.name as pname')
                ->join('respondents', 'respondents.id', '=', 'rewards.user_id') 
                ->join('users', 'users.id', '=', 'rewards.user_id') 
                ->join('projects', 'projects.id', '=', 'rewards.project_id');

                if(isset($request->id)){
                    $all_datas->where('rewards.user_id',$request->id);
                }
                $all_datas = $all_datas->orderby("rewards.id","desc")
                ->withoutTrashed()
                ->get();

                
                return Datatables::of($all_datas)
                ->addColumn('select_all', function ($all_data) {
                    return '<input class="tabel_checkbox" name="rewards[]" type="checkbox" onchange="table_checkbox(this)" id="'.$all_data->id.'">';
                })
                ->addColumn('points', function ($all_data) {
                    return $all_data->points;
                })            
                ->addColumn('status_id', function ($all_data) {
                    
                    if($all_data->status_id==1){
                        return 'Pending';
                    }else if($all_data->status_id==2){
                        return 'Approved';
                    }else if($all_data->status_id==3){
                        return '-';
                    }else if($all_data->status_id==4){
                        return 'Processed';
                    }else{  
                        return '-';
                    }

                }) 
                ->addColumn('respondent_id', function ($all_data) {
                    
                    return $all_data->rname.' - '.$all_data->remail.' - '.$all_data->rmobile;
                })    
                ->addColumn('user_id', function ($all_data) {
                    return $all_data->uname;
                }) 
                ->addColumn('project_id', function ($all_data) {
                    
                    return $all_data->pname;
                }) 
                ->addColumn('action', function ($all_data) use($token) {
        
                    return '<div class="">
                    <div class="btn-group mr-2 mb-2 mb-sm-0">
                        <button type="button" onclick="view_details(' . $all_data->id . ');" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></button>
                    </div>              
                </div>';
                    
                }) 
                ->rawColumns(['select_all','action','active','points','status_id','respondent_id','user_id','project_id'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function view_rewards(Request $request){
        try {
            
            $data = Rewards::select('rewards.*','respondents.name as rname','respondents.email as remail','respondents.mobile as rmobile','users.name as uname','projects.name as pname')
                ->join('respondents', 'respondents.id', '=', 'rewards.user_id') 
                ->join('users', 'users.id', '=', 'rewards.user_id') 
                ->join('projects', 'projects.id', '=', 'rewards.project_id') 
                ->where('rewards.id',$request->id)
                ->first();

            return view('admin.rewards.view',compact('data'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }

    public function rewards_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $rewards = Rewards::find($id);
                $rewards->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Rewards Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}