<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Banks;
use App\Models\Contents;
use App\Models\Networks;
use App\Charities;
use App\Groups;
use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\DataTables\DataTables;
use Exception;

class ContentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.contents.index');
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
            $returnHTML = view('admin.contents.create')->render();

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
                'type_id' => 'required',
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
                $content          = new Contents;
                $content->type_id = $request->input('type_id');
                $content->data    = $request->input('data');
                $content->save();
                $content->id;

                return response()->json([
                    'status'  => 200,
                    'success' => true,
                    'message' =>'Content Added Successfully.'
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
            $data = Contents::find($id);
            $returnHTML = view('admin.contents.view',compact('data'))->render();

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
            $content = Contents::find($id);
            if($content)
            {
                $returnHTML = view('admin.contents.edit',compact('content'))->render();

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
                    'message'=>'No Content Found.'
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
                'type_id'=> 'required',
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
                $content = Contents::where('id',$request->id)->first();
                if(!empty($content))
                {
                    $type_id = $request->type_id;
                    $data    = $request->data;
                    $data=array('type_id'=>$type_id,"data"=>$data);
                    Contents::where('id',$request->id)->update($data);
                    return response()->json([
                        'status'  => 200,
                        'success' => true,
                        'message' => 'Contents Updated.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Contents Found.'
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
            $contents = Contents::find($id);
            if($contents)
            {
                $contents->delete();
                return response()->json([
                    'status'=>200,
                    'success' => true,
                    'message'=>'Contents Deleted'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'success' => false,
                    'message'=>'No Contents Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function contents_datatable(Request $request) {
		
        try {
            if ($request->ajax()) {
                $all_datas = Contents::withoutTrashed()->latest()->get();
        
                return Datatables::of($all_datas)
                ->addColumn('type_id', function ($all_data) {
                    if($all_data->type_id=='1'){
                        return 'Terms of use';
                    }else{
                        return 'Terms and condition';
                    }
                })
                ->addColumn('select_all', function ($all_data) {
                    return '<input class="tabel_checkbox" name="contents[]" type="checkbox" onchange="table_checkbox(this,\'contents_table\')" id="'.$all_data->id.'">';
                })
                ->addColumn('id_show', function ($all_data) {
                    $view_route = route("contents.show",$all_data->id);
                    return '<a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                        data-bs-original-title="View Content" class="waves-light waves-effect">
                        '.$all_data->id.'
                    </a>';
                })
                ->addColumn('action', function ($all_data) {
                    $edit_route = route("contents.edit",$all_data->id);
                    $view_route = route("contents.show",$all_data->id);

                    return '<div class="col-md-2">
                        <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                            title="Action" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="list-group-item">
                                <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                    data-bs-original-title="View Content" class="waves-light waves-effect">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                    data-bs-original-title="Edit Content" class="rounded waves-light waves-effect">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#!" id="delete_content" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                    <i class="far fa-trash-alt"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['id_show','select_all','action','active','data'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function contents_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $contents = Contents::find($id);
                $contents->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Contents Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function check_content_duplicate(Request $request){
        try {
            if($request->form_name=="contentcreate"){
                $get_count=Contents::where('id',$request->type_id)->get()->count();
                if($get_count<1){
                    echo "true";
                }else{
                    echo "false";
                }
            }else{
                $get_count=Contents::whereNot('id',$request->type_id)->get()->count();
                if($get_count<1){
                    echo "true";
                }else{
                    echo "false";
                }
            }
            
             
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
