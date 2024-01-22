<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Banks;
use DB;
use Yajra\DataTables\Facades\DataTables;
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
       
        
        $all_datas = DB::table('banks')->select('id','bank_name','branch_code','active')
        ->latest()
        ->get();
 
         
         return Datatables::of($all_datas)
          
         ->addColumn('bank_name', function ($all_data) {
                     return $all_data->bank_name;
         }) 
         ->addColumn('branch_code', function ($all_data) {
                    return $all_data->branch_code;
        }) 
        ->addColumn('active', function ($all_data) {
            if($all_data->active==1){
                $active='Yes';
                return $active;
            }else{
                $active='No';
                return $active;
            }
        })   
         ->addColumn('action', function ($all_data) use($token) {
 
            return '<a href="javascript:;" data-id = "' . $all_data->id . '"  class="" onclick="delete_data(' . $all_data->id . ')" >&nbsp;<i class="fa fa-trash-o fa-lg"></i>&nbsp;</a>';
             
         }) 
         ->rawColumns(['action','active','branch_code','bank_name'])      
         ->make(true);
 
    }

    public function add_banks(){

        $returnHTML = view("admin.bank.create")->render();

            return response()->json([
                "success" => true,
                "html" => $returnHTML,
            ]);
    }
}