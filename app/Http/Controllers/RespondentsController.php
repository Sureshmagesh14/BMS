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
use DB;
use Yajra\DataTables\DataTables;

class RespondentsController extends Controller
{   
    public function respondents()
    {   
        try {
            if (!Auth::check()) {
                return redirect("/")->withSuccess('You are not allowed to access');
            }
            
            return view('admin.respondents.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }
    public function get_all_respondents(Request $request) {
		
        try {
            if ($request->ajax()) {

                $token = csrf_token();
            
                
                $all_datas = DB::table('respondents')
                ->orderby("id","desc")
                ->limit(10)
                ->get();
        
                
                return Datatables::of($all_datas)
                ->addColumn('name', function ($all_data) {
                    return $all_data->name;
                })  
                ->addColumn('surname', function ($all_data) {
                    return $all_data->surname;
                })  
                ->addColumn('mobile', function ($all_data) {
                    return $all_data->mobile;
                })  
                ->addColumn('whatsapp', function ($all_data) {
                    return $all_data->whatsapp;
                })  
                ->addColumn('email', function ($all_data) {
                    return $all_data->email;
                }) 
                ->addColumn('age', function ($all_data) {
                    return $all_data->date_of_birth;
                })
                ->addColumn('gender', function ($all_data) {
                    return '-';
                })
                ->addColumn('race', function ($all_data) {
                    return '-';
                })
                ->addColumn('status', function ($all_data) {
                    return '-';
                })
                ->addColumn('profile_completion', function ($all_data) {
                    return '-';
                })
                ->addColumn('inactive_until', function ($all_data) {
                    return '-';
                })
                ->addColumn('opeted_in', function ($all_data) {
                    return '-';
                })
                ->rawColumns(['name','surname','mobile','whatsapp','email','age','gender','race','status','profile_completion','inactive_until','opeted_in'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        

    }
}