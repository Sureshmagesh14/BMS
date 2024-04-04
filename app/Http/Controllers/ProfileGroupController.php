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
                'name' => 'required',
                'type_id'    => 'required',
                'survey_url'    => 'required',
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
                $groups          = new Groups;
                $groups->name = $request->input('name');
                $groups->type_id    = $request->input('type_id');
                $groups->survey_url    = $request->input('survey_url');
                $groups->save();
                $groups->sort_order=$groups->id;

                return response()->json([
                    'status'  => 200,
                    'success' => true,
                    'message' =>'Groups Added Successfully.'
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
            
            $data = Groups::find($id);

            return view('admin.groups.view',compact('data'));

           
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
            $groups = Groups::find($id);
            if($groups)
            {
                $returnHTML = view('admin.groups.edit',compact('groups'))->render();

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
                'name' => 'required',
                'type_id'    => 'required',
                'survey_url'    => 'required',
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
                $groups = Groups::find($request->id);
                if($groups)
                {
                $groups->name = $request->input('name');
                $groups->type_id    = $request->input('type_id');
                $groups->survey_url    = $request->input('survey_url');
                $groups->update();
                $groups->id;
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
                $all_datas = Groups::get();
        
                
                return Datatables::of($all_datas)
                ->addColumn('select_all', function ($all_data) {
                    return '<input class="tabel_checkbox" name="networks[]" type="checkbox" onchange="table_checkbox(this,\'groups_table\')" id="'.$all_data->id.'">';
                })
                ->addColumn('id_show', function ($all_data) {
                    $view_route = route("groups.show",$all_data->id);
                    return '<a href="'.$view_route.'" class="rounded waves-light waves-effect">
                        '.$all_data->id.'
                    </a>';
                })
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

                    return '<div class="col-md-2">
                        <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                            title="Action" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="list-group-item">
                                <a href="'.$view_route.'" class="rounded waves-light waves-effect">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                    data-bs-original-title="Edit Profile Group" class="rounded waves-light waves-effect">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#!" id="delete_groups" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                    <i class="far fa-trash-alt"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['id_show','select_all','name','survey_url','type_id','action'])          
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function groups_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $contents = Groups::find($id);
                $contents->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Groups Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
}
