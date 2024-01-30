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
            
                
                $all_datas = Action::limit(30)->get();
      
                
                return Datatables::of($all_datas)
                 
                ->addColumn('name', function ($all_data) {
                    return $all_data->name;
                })  
                ->addColumn('action', function ($all_data) use($token) {
        
                    return '<div class="">
                    <div class="btn-group mr-2 mb-2 mb-sm-0">
                        <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></button>
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
}