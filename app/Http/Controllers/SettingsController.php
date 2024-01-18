<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Banks;

class SettingsController extends Controller
{
    public function banks()
    {   
        if (!Auth::check()) {
            return redirect("/")->withSuccess('You are not allowed to access');
        }
        

        return view('admin.banks');
    }
    public function get_all_banks() {
		
        $token = csrf_token();
       
        
        $all_datas = DB::table('banks')
        ->orderby("id","desc")
        ->get();
 
         
         return Datatables::of($all_datas)
          
         ->addColumn('bank_name', function ($all_data) {
                     return $all_data->bank_name;
         }) 
         ->addColumn('branch_code', function ($all_data) {
                    return $all_data->branch_code;
        }) 
        ->addColumn('active', function ($all_data) {
            return $all_data->active;
        })   
         ->addColumn('action', function ($all_data) use($token) {
 
            return '<a href="javascript:;" data-id = "' . $all_data->id . '" data-policy_id = "' . $all_data->policy_id . '" class="" onclick="delete_data(' . $all_data->id . ')" >&nbsp;<i class="fa fa-trash-o fa-lg"></i>&nbsp;</a>';
             
         }) 
         ->rawColumns(['action','active','branch_code','bank_name'])      
         ->make(true);
 
    }
}