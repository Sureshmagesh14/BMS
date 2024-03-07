<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Banks;
use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
class BankController extends Controller
{
    public function index()
    {
        try {
            return view('admin.banks.index');
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
            $returnHTML = view('admin.banks.create')->render();

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
                $banks          = new Banks;
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
            $returnHTML = view('admin.banks.view',compact('data'))->render();

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
            $banks = Banks::find($id);
            if($banks)
            {
                $returnHTML = view('admin.banks.edit',compact('banks'))->render();

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
                    'message'=>'No Banks Found.'
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
                $banks = Banks::find($request->id);
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
                        'message' => 'Banks Updated.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Banks Found.'
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
            $contents = Banks::find($id);
            if($contents)
            {
                $contents->delete();
                return response()->json([
                    'status'=>200,
                    'success' => true,
                    'message'=>'Banks Deleted'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'success' => false,
                    'message'=>'No Charities Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function get_all_banks(Request $request) {
		
        try {
            if ($request->ajax()) {
                $all_datas = Banks::latest()->get();
        
                
                return Datatables::of($all_datas)
                ->addColumn('select_all', function ($all_data) {
                    return '<input class="tabel_checkbox" name="banks[]" type="checkbox" onchange="table_checkbox(this)" id="'.$all_data->id.'">';
                })
                ->addColumn('bank_name', function ($all_data) {
                    return $all_data->bank_name;
                }) 
                ->addColumn('branch_code', function ($all_data) {
                            return $all_data->branch_code;
                }) 
                ->addColumn('active', function ($all_data) {
                    if($all_data->active==1){
                        $active='<span class="badge badge-success">Yes</span>';
                    }else{
                        $active='<span class="badge badge-danger">No</span>';
                    }
                    return $active;
                })   
                ->addColumn('action', function ($all_data) {
                    $edit_route = route("banks.edit",$all_data->id);
                    $view_route = route("banks.show",$all_data->id);

                    return '<div class="">
                        <div class="btn-group mr-2 mb-2 mb-sm-0">
                            <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                data-bs-original-title="View Banks" class="btn btn-primary waves-light waves-effect">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                data-bs-original-title="Edit Banks" class="btn btn-primary waves-light waves-effect">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" id="delete_banks" data-id="'.$all_data->id.'" class="btn btn-primary waves-light waves-effect">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>';
                })
                ->rawColumns(['select_all','bank_name','branch_code','active','action'])          
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function banks_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $contents = Banks::find($id);
                $contents->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Banks Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
