<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\UserEvents;

use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\DataTables\DataTables;
use Exception;

class InternalReportController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.internal_report.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    
    
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
     
        // print_r($all_datas);
        // echo "<pre><br>";

        try {
            if ($request->ajax()) {
                
                $all_datas = UserEvents::with('users_data')->latest()->get();
        
                return Datatables::of($all_datas)
                ->addColumn('user_show', function ($all_data) {
                    if(isset($all_data->users_data->name)){
                        return $all_data->users_data->name.' '.$all_data->users_data->surname;
                    }
                    else{
                        return '-';
                    }
                })
                ->addColumn('view', function ($all_data) {
                    $view_route = route("user-events-view",$all_data->id);
                    return '<div class="">
                        <div class="btn-group mr-2 mb-2 mb-sm-0">
                            <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                data-bs-original-title="View Network" class="btn btn-primary waves-light waves-effect">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>';
                })
                ->rawColumns(['view','user_show'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
    }

    public function view(string $id)
    {
        
        try {
            $data = UserEvents::find($id);
            $returnHTML = view('admin.internal_report.view',compact('data'))->render();

            return response()->json(
                [
                    'success' => true,
                    'html_page' => $returnHTML,
                ]
            );
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    
    
    
}
