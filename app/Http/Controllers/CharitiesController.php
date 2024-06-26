<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Charities;
use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
class CharitiesController extends Controller
{
    public function index()
    {
        try {
            return view('admin.charities.index');
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
            $returnHTML = view('admin.charities.create')->render();

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
                'name' => 'required',
                'data'    => 'required',
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
                $content          = new Charities;
                $content->name = $request->input('name');
                $content->data    = $request->input('data');
                $content->save();
                $content->id;

                return response()->json([
                    'status'  => 200,
                    'success' => true,
                    'message' =>'Charities Added Successfully.'
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
            $data = Charities::find($id);
            $returnHTML = view('admin.charities.view',compact('data'))->render();

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
            $charities = Charities::find($id);
            if($charities)
            {
                $returnHTML = view('admin.charities.edit',compact('charities'))->render();

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
                    'message'=>'No Charities Found.'
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
                'name'=> 'required',
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
                $content = Charities::find($request->id);
                if($content)
                {
                    $content->name = $request->input('name');
                    $content->data    = $request->input('data');
                    $content->update();
                    $content->id;
                    return response()->json([
                        'status'  => 200,
                        'success' => true,
                        'message' => 'Charities Updated.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Charities Found.'
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
            $contents = Charities::find($id);
            if($contents)
            {
                $contents->delete();
                return response()->json([
                    'status'=>200,
                    'success' => true,
                    'message'=>'Charities Deleted'
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

    public function get_all_charities(Request $request) {
		
        try {
            if ($request->ajax()) {
                $all_datas = Charities::latest()->get();
        
                
                return Datatables::of($all_datas)
                ->addColumn('select_all', function ($all_data) {
                    return '<input class="tabel_checkbox" name="networks[]" type="checkbox" onchange="table_checkbox(this,\'charities_table\')" id="'.$all_data->id.'">';
                })
                ->addColumn('id_show', function ($all_data) {
                    $view_route = route("charities.show",$all_data->id);
                    return ' <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                        data-bs-original-title="View Charities" class="waves-light waves-effect">
                        '.$all_data->id.'
                    </a>';
                })
                ->addColumn('name', function ($all_data) {
                    return $all_data->name;
                })
                ->addColumn('data', function ($all_data) {
                    return $all_data->data;
                })      
                ->addColumn('action', function ($all_data) {
                    $edit_route = route("charities.edit",$all_data->id);
                    $view_route = route("charities.show",$all_data->id);

                    return '<div class="col-md-2">
                        <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                            title="Action" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="list-group-item">
                                <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                    data-bs-original-title="View Charities" class="waves-light waves-effect">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                    data-bs-original-title="Edit Charities" class="rounded waves-light waves-effect">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#!" id="delete_charities" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                    <i class="far fa-trash-alt"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['id_show','select_all','action','name','data'])          
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function charities_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $charitie = Charities::find($id);
                $charitie->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Charities Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
