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
use App\Actions;
use App\Cashouts;
use App\Users;
use DB;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{   
    public function users()
    {   
       
        
        return view('admin.users.index');
    }
    public function get_all_users(Request $request) {
		
        if ($request->ajax()) {

            $token = csrf_token();
        
            
            $all_datas = DB::table('users')
            ->where('status_id','1')
            ->orderby("id","desc")
            ->get();
    
            
            return Datatables::of($all_datas)
             
            ->addColumn('name', function ($all_data) {
                return $all_data->name;
            })  
            ->addColumn('surname', function ($all_data) {
                return $all_data->surname;
            })  
            ->addColumn('id_passport', function ($all_data) {
                return $all_data->id_passport;
            })    
            ->addColumn('email', function ($all_data) {
                return $all_data->email;
            })  
            ->addColumn('role_id', function ($all_data) {
                if($all_data->role_id==1){
                    return 'Admin';
                }else if($all_data->role_id==2){
                    return 'User';
                }else if($all_data->role_id==3){
                    return 'Temp';
                }else{  
                    return '-';
                }
               
            })
            ->addColumn('share_link', function ($all_data) {
                return $all_data->share_link;
            })  
            ->addColumn('status_id', function ($all_data) {
               
                if($all_data->status_id==1){
                    return 'Active';
                }else if($all_data->status_id==2){
                    return 'Inactive';
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
            ->rawColumns(['action','name','surname','id_passport','email','role_id','share_link','status_id'])      
            ->make(true);
        }

    }
}