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

class TagsController extends Controller
{   
    public function tags()
    {   
        if (!Auth::check()) {
            return redirect("/")->withSuccess('You are not allowed to access');
        }
        
        return view('admin.tags.index');
    }
    public function get_all_tags(Request $request) {
		
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
                    <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></button>
                </div>              
            </div>';
                
            }) 
            ->rawColumns(['action','name','colour'])      
            ->make(true);
        }

    }
}