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
use DB;
use Yajra\DataTables\DataTables;
use Exception;
class TagsController extends Controller
{   
    public function tags()
    {   
      
        try {
            return view('admin.tags.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }
    public function get_all_tags(Request $request) {
		
        try {
            if ($request->ajax()) {

                $token = csrf_token();
            
                
                $all_datas = DB::table('tags')
                ->orderby("id","desc")
                ->get();
        
                
                return Datatables::of($all_datas)
                ->addColumn('name', function ($all_data) {
                    return $all_data->name;
                })            
                ->addColumn('colour', function ($all_data) {
                    return '<button type="button" class="btn btn-primary waves-effect waves-light" style="background-color: '.$all_data->name.'; border-color: '.$all_data->name.';"></button>';
                }) 
                ->addColumn('action', function ($all_data) use($token) {
        
                    return '<div class="">
                    <div class="btn-group mr-2 mb-2 mb-sm-0">
                        <button type="button" onclick="view_details(' . $all_data->id . ');" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></button>
                    </div>              
                </div>';
                    
                }) 
                ->rawColumns(['action','name','colour'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function view_tags(Request $request){
        try {
            
            $data = DB::table('tags')->where('id',$request->id)->first();

            return view('admin.tags.view',compact('data'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }

    public function edit_tags($id){
        try {
            $content = DB::table('tags')::find($id);
            if($content)
            {
                return view('admin.tags.edit',compact('content'));
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Panels Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }
}