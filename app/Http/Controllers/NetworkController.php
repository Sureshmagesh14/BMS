<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Networks;
use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\DataTables\DataTables;
use Exception;

class NetworkController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.networks.index');
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
           
            $returnHTML = view('admin.networks.create')->render();

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
               'name'=> 'required',
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
                $network = new Networks;
                $network->name = $request->input('name');
                $network->save();
                $network->id;
                return response()->json([
                    'status'=>200,
                    'last_insert_id' => $network->id,
                    'message'=>'Network Added Successfully.'
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
            $data = Networks::find($id);
            $returnHTML = view('admin.networks.view',compact('data'))->render();

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
           
            $network = Networks::find($id);
            if($network)
            {
                $returnHTML = view('admin.networks.edit',compact('network'))->render();
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
                    'message'=>'No Network Found.'
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
               
                $content = Networks::find($request->id);
                if($content)
                {
                    $content->name = $request->input('name');
                    $content->update();
                    $content->id;
                    return response()->json([
                        'status'=>200,
                        'last_insert_id' => $content->id,
                        'message' => 'Networks Updated.',
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Network Found.'
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
            $contents = Networks::find($id);
            if($contents)
            {
                $contents->delete();
                return response()->json([
                    'status'=>200,
                    'success' => true,
                    'message'=>'Network Deleted Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'success' => false,
                    'message'=>'No Network Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }

    public function get_all_networks(Request $request) {
		
        try {
            if ($request->ajax()) {
                $all_datas = Networks::latest()->get();
        
                return Datatables::of($all_datas)
                ->addColumn('select_all', function ($all_data) {
                    return '<input class="tabel_checkbox" name="networks[]" type="checkbox" onchange="table_checkbox(this,\'network_table\')" id="'.$all_data->id.'">';
                })
                ->addColumn('name', function ($all_data) {
                    return $all_data->name;
                })     
                ->addColumn('action', function ($all_data) {
                    $edit_route = route("networks.edit",$all_data->id);
                    $view_route = route("networks.show",$all_data->id);

                    return '<div class="col-md-2">
                        <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                            title="Action" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="list-group-item">
                                <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                    data-bs-original-title="View Network" class="waves-light waves-effect">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                    data-bs-original-title="Edit Network" class="rounded waves-light waves-effect">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#!" id="delete_network" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                    <i class="far fa-trash-alt"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['select_all','action','name'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function networks_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $contents = Networks::find($id);
                $contents->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Networks Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
}
