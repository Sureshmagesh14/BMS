<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Banks;
use App\Models\Contents;
use App\Models\Networks;
use App\Charities;
use App\Groups;
use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
class SettingsController extends Controller
{   
    public function groups()
    {   
        try {
            return view('admin.groups.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
       
    }
    public function get_all_groups(Request $request) {
		
        try {
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
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       

    }
    public function charities()
    {   
        try {
            return view('admin.charities.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
      
    }
    public function get_all_charities(Request $request) {
		
        try {
            if ($request->ajax()) {

                $token = csrf_token();
            
                
                $all_datas = Charities::latest()->get();
        
                
                return Datatables::of($all_datas)
                ->addColumn('name', function ($all_data) {
                    return $all_data->name;
                })
                ->addColumn('data', function ($all_data) {
                    return $all_data->data;
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
                ->rawColumns(['action','name','data'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       

    }
    public function networks()
    {   
        
        try {
            return view('admin.networks.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }

    public function create_networks(Request $request){
        try {
            return view('admin.networks.create');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    
    public function save_network(Request $request){
        try {

            $validator = Validator::make($request->all(), [
               'name'=> 'required',
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                $network = new Networks;
                $network->name = $request->input('name');
                $network->save();
                $network->id;
                return response()->json([
                    'status'=>200,
                    'last_insert_id' => $network->id,
                    'message'=>'Network Added Successfully.'
                ]);
            }

        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function edit_network($id){
        try {
            $network = Networks::find($id);
            if($network)
            {
                return view('admin.networks.edit',compact('network'));
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Network Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }

    public function view_network(Request $request){
        try {
            $data=Networks::where('id',$request->id)->first();
            return view('admin.networks.view',compact('data'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }

    public function update_network(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'name'=> 'required',
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
               
                $content = Networks::find($request->id);
                if($content)
                {
                    $content->name = $request->input('name');
                    $content->update();
                    $content->id;
                    return response()->json([
                        'status'=>200,
                        'last_insert_id' => $content->id,
                        'success'=>'Network Updated Successfully.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Network Found.'
                    ]);
                }
    
            }
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete_networks(Request $request){
        try {
            $contents = Networks::find($request->id);
            if($contents)
            {
                $contents->delete();
                return response()->json([
                    'status'=>200,
                    'message'=>'Network Deleted Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Network Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
        

    }

    public function get_all_networks(Request $request) {
		
        try {
            if ($request->ajax()) {

                $token = csrf_token();
            
                $all_datas = Networks::latest()->get();
               
                return Datatables::of($all_datas)
                ->addColumn('name', function ($all_data) {
                    return $all_data->name;
                })    
                ->addColumn('action', function ($all_data) use($token) {
        
                    return '<div class="">
                    <div class="btn-group mr-2 mb-2 mb-sm-0">
                        <a onclick="view_network(' . $all_data->id . ');" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></a>
                        <button type="button" id="edit_network" data-id="' . $all_data->id . '" class="btn btn-primary waves-light waves-effect"><i class="fa fa-edit"></i></button>
                        <button type="button" id="delete_network" data-id="' . $all_data->id . '"     class="btn btn-primary waves-light waves-effect"><i class="far fa-trash-alt"></i></button>
                    </div>              
                </div>';
                    
                }) 
                ->rawColumns(['action','name'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
        

    }
    public function contents()
    {   
        try {
            return view('admin.contents.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }
    
    public function banks()
    {   
        try {
            return view('admin.banks.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function get_all_banks(Request $request) {
		
        try {
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
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       

    }


    public function create_contents(){
        try {
            return view('admin.contents.create');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function save_contents(Request $request){
        try {

            $validator = Validator::make($request->all(), [
               'type_id'=> 'required',
                'data'=>'required',
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                $content = new Contents;
                $content->type_id = $request->input('type_id');
                $content->data = $request->input('data');
                $content->save();
                $content->id;
                return response()->json([
                    'status'=>200,
                    'last_insert_id' => $content->id,
                    'message'=>'Content Added Successfully.'
                ]);
            }

        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update_contents(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'type_id'=> 'required',
                'data'=>'required',
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
               
                $content = Contents::find($request->id);
                if($content)
                {
                    $content->type_id = $request->input('type_id');
                    $content->data = $request->input('data');
                    $content->update();
                    $content->id;
                    return response()->json([
                        'status'=>200,
                        'last_insert_id' => $content->id,
                        'success'=>'Contents Updated Successfully.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Student Found.'
                    ]);
                }
    
            }
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function edit_contents($id){
        try {
            $content = Contents::find($id);
            if($content)
            {
                return view('admin.contents.edit',compact('content'));
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Content Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }

    public function view_contents(Request $request){
        try {
            $data=Contents::where('id',$request->id)->first();
            return view('admin.contents.view',compact('data'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }

    

    public function delete_contents(Request $request){
        try {
            $contents = Contents::find($request->id);
            if($contents)
            {
                $contents->delete();
                return response()->json([
                    'status'=>200,
                    'message'=>'Contents Deleted Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Contents Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
        

    }

    
}