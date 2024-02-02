<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Groups;
use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
class ProfileGroupController extends Controller
{
    public function index()
    {
        try {
            return view('admin.groups.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $returnHTML = view('admin.groups.create')->render();

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bank_name' => 'required',
                'branch_code'    => 'required',
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
                $banks          = new Groups;
                $banks->bank_name = $request->input('bank_name');
                $banks->branch_code    = $request->input('branch_code');
                $banks->active    = $request->input('active');
                $banks->save();
                $banks->id;

                return response()->json([
                    'status'  => 200,
                    'success' => true,
                    'message' =>'Banks Added Successfully.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Banks::find($id);
            $returnHTML = view('admin.groups.view',compact('data'))->render();

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $banks = Groups::find($id);
            if($banks)
            {
                $returnHTML = view('admin.groups.edit',compact('banks'))->render();

                return response()->json(
                    [
                        'success' => true,
                        'html_page' => $returnHTML,
                    ]
                );
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Groups Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bank_name' => 'required',
                'branch_code'    => 'required',
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
                $banks = Groups::find($request->id);
                if($banks)
                {
                    $banks->bank_name = $request->input('bank_name');
                    $banks->branch_code    = $request->input('branch_code');
                    $banks->active    = $request->input('active');
                    $banks->update();
                    $banks->id;
                    return response()->json([
                        'status'  => 200,
                        'success' => true,
                        'message' => 'Groups Updated.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Groups Found.'
                    ]);
                }
            }
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contents = Groups::find($id);
            if($contents)
            {
                $contents->delete();
                return response()->json([
                    'status'=>200,
                    'success' => true,
                    'message'=>'Groups Deleted'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'success' => false,
                    'message'=>'No Groups Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function get_groups_banks(Request $request) {
		
        try {
            if ($request->ajax()) {
                $all_datas = Groups::latest()->get();
        
                
                return Datatables::of($all_datas)
                ->addColumn('name', function ($all_data) {
                    return $all_data->name;
                }) 
                ->addColumn('type_id', function ($all_data) {
                    if($all_data->type_id==1){
                        $type_id='<span class="badge badge-success">Basic</span>';
                    }else if($all_data->type_id==2){
                        $type_id='<span class="badge badge-primary">Essential</span>';
                    }
                    else{
                        $type_id='<span class="badge badge-secondary">Extended</span>';
                    }
                    return $type_id;
                })  
                ->addColumn('survey_url', function ($all_data) {
                            return $all_data->survey_url;
                }) 
                ->addColumn('action', function ($all_data) {
                    $edit_route = route("groups.edit",$all_data->id);
                    $view_route = route("groups.show",$all_data->id);

                    return '<div class="">
                        <div class="btn-group mr-2 mb-2 mb-sm-0">
                            <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                data-bs-original-title="View Content" class="btn btn-primary waves-light waves-effect">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                data-bs-original-title="Edit Content" class="btn btn-primary waves-light waves-effect">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" id="delete_groups" data-id="'.$all_data->id.'" class="btn btn-primary waves-light waves-effect">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>';
                })
                ->rawColumns(['name','survey_url','type_id','action'])          
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
