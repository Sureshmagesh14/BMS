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
        try {
            if ($request->ajax()) {
                $all_datas = UserEvents::latest()->get();
        
                return Datatables::of($all_datas)
                // ->addColumn('user_id', function ($all_data) {
                //     $user_name=DB::table('users')->select('name')->where('id',$all_data->user_id)->first();
                //     return $user_name;
                // }) 
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
                ->rawColumns(['id','user_id','action','type','month','year','count','view'])      
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
