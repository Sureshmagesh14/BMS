<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Banks;
use App\Models\Contents;
use App\Networks;
use App\Charities;
use App\Groups;

use DB;
use Yajra\DataTables\DataTables;

class SettingsController extends Controller
{   
    public function groups()
    {   
        if (!Auth::check()) {
            return redirect("/")->withSuccess('You are not allowed to access');
        }
        
        return view('admin.groups.index');
    }
    public function get_all_groups(Request $request) {
		
        if ($request->ajax()) {

            $token = csrf_token();
        
            
            $all_datas = DB::table('groups')
            ->orderby("id","desc")
            ->get();
    
            
            return Datatables::of($all_datas)
            ->addColumn('name', function ($all_data) {
                return $all_data->name;
            })
            ->addColumn('type_id', function ($all_data) {
                return $all_data->type_id;
            })
            ->addColumn('survey_url', function ($all_data) {
                return $all_data->survey_url;
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
            ->rawColumns(['action','active','name','survey_url','type_id'])      
            ->make(true);
        }

    }
    public function charities()
    {   
        if (!Auth::check()) {
            return redirect("/")->withSuccess('You are not allowed to access');
        }
        
        return view('admin.charities.index');
    }
    public function get_all_charities(Request $request) {
		
        if ($request->ajax()) {

            $token = csrf_token();
        
            
            $all_datas = DB::table('charities')
            ->orderby("id","desc")
            ->get();
    
            
            return Datatables::of($all_datas)
            ->addColumn('name', function ($all_data) {
                return $all_data->name;
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
            ->rawColumns(['action','active','name'])      
            ->make(true);
        }

    }
    public function networks()
    {   
        if (!Auth::check()) {
            return redirect("/")->withSuccess('You are not allowed to access');
        }
        
        return view('admin.networks.index');
    }
    public function get_all_networks(Request $request) {
		
        if ($request->ajax()) {

            $token = csrf_token();
        
            
            $all_datas = DB::table('networks')
            ->orderby("id","desc")
            ->get();
    
            
            return Datatables::of($all_datas)
            ->addColumn('name', function ($all_data) {
                return $all_data->name;
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
            ->rawColumns(['action','active','name'])      
            ->make(true);
        }

    }
    public function contents()
    {   
        try {
            return view('admin.contents.index');
        }
        catch (Exception $e) {
            //code to handle the exception
        }
       
    }
    public function get_all_contents(Request $request) {
		
        if ($request->ajax()) {

            $token = csrf_token();
        
            
            $all_datas = DB::table('contents')
            ->orderby("id","desc")
            ->get();
    
            
            return Datatables::of($all_datas)
            ->addColumn('type_id', function ($all_data) {
                if($all_data->type_id=='1'){
                    return 'Terms of use';
                }else{
                    return 'Terms and condition';
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
            ->rawColumns(['action','active','data'])      
            ->make(true);
        }

    }
    public function banks()
    {   
        if (!Auth::check()) {
            return redirect("/")->withSuccess('You are not allowed to access');
        }
        

        return view('admin.banks.index');
    }
    public function get_all_banks(Request $request) {
		
        if ($request->ajax()) {

            $token = csrf_token();
        
            
            $all_datas = DB::table('banks')
            ->orderby("id","desc")
            ->get();
    
            
            return Datatables::of($all_datas)
            ->addColumn('bank_name', function ($all_data) {
                return $all_data->bank_name;
            }) 
            ->addColumn('bank_name', function ($all_data) {
                        return $all_data->bank_name;
            }) 
            ->addColumn('branch_code', function ($all_data) {
                        return $all_data->branch_code;
            }) 
            ->addColumn('active', function ($all_data) {
                if($all_data->active==1){
                    return '<span class="text-success">Yes</span>';
                }else{
                    return '<span class="text-danger">No</span>';
                }
                return $all_data->active;
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
            ->rawColumns(['action','active','branch_code','bank_name'])      
            ->make(true);
        }

    }


    public function create_contents(){
        try {
            return view('admin.contents.create');
        }
        catch (exception $e) {
            //code to handle the exception
        }
    }

    public function save_contents(Request $request){
        try {

            Contents::create($request->all());

            return response(['success' => 'Employee created successfully.']);
        }
        catch (exception $e) {
            //code to handle the exception
        }
    }

    
}