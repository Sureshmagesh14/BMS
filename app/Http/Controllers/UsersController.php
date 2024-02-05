<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Exception;

class UsersController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.users.index');
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
           
            $returnHTML = view('admin.users.create')->render();

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
               'surname'=> 'required',
               'id_passport'=> 'required',
               'email'=> 'required',
               'password'=> 'required',
               'role_id'=> 'required',
               'status_id'=> 'required',
               'share_link'=> 'required',

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
                $users = new Users;
                $users->name = $request->input('name');
                $users->surname = $request->input('surname');
                $users->id_passport = $request->input('id_passport');
                $users->email = $request->input('email');
                $users->password = $request->input('password');
                $users->password_confirmation = $request->input('password_confirmation');
                $users->role_id = $request->input('role_id');
                $users->status_id = $request->input('status_id');
                $users->share_link = $request->input('share_link');
                $users->save();
                $users->id;
                return response()->json([
                    'status'=>200,
                    'last_insert_id' => $users->id,
                    'message'=>'Users Added Successfully.'
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
            $data = Users::find($id);
            $returnHTML = view('admin.users.view',compact('data'))->render();

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
           
            $users = Users::find($id);
            if($users)
            {
                $returnHTML = view('admin.users.edit',compact('users'))->render();
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
                    'message'=>'No Users Found.'
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
                'surname'=> 'required',
                'id_passport'=> 'required',
                'email'=> 'required',
                'password'=> 'required',
                'role_id'=> 'required',
                'status_id'=> 'required',
                'share_link'=> 'required',
 
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
               
                $users = Users::find($request->id);
                if($users)
                {
                    
                    $users->name = $request->input('name');
                    $users->surname = $request->input('surname');
                    $users->id_passport = $request->input('id_passport');
                    $users->email = $request->input('email');
                    $users->password = $request->input('password');
                    $users->password_confirmation = $request->input('password_confirmation');
                    $users->role_id = $request->input('role_id');
                    $users->status_id = $request->input('status_id');
                    $users->share_link = $request->input('share_link');
                    $users->update();
                    $users->id;
                    return response()->json([
                        'status'=>200,
                        'last_insert_id' => $users->id,
                        'message' => 'Users Updated.',
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Users Found.'
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
            $users = Users::find($id);
            if($users)
            {
                $users->delete();
                return response()->json([
                    'status'=>200,
                    'success' => true,
                    'message'=>'Users Deleted Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'success' => false,
                    'message'=>'No Users Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }
    public function get_all_users(Request $request) {
		
        try {
            if ($request->ajax()) {

                $token = csrf_token();
            
                
                $all_datas = DB::table('users')
                ->where('status_id','1')
                ->orderby("id","desc")
                ->get();
        
                
                return Datatables::of($all_datas)
                 
                ->addColumn('name', function ($all_data) {
                    return $all_data->name;
                })  
                ->addColumn('surname', function ($all_data) {
                    return $all_data->surname;
                })  
                ->addColumn('id_passport', function ($all_data) {
                    return $all_data->id_passport;
                })    
                ->addColumn('email', function ($all_data) {
                    return $all_data->email;
                })  
                ->addColumn('role_id', function ($all_data) {
                    if($all_data->role_id==1){
                        return 'Admin';
                    }else if($all_data->role_id==2){
                        return 'User';
                    }else if($all_data->role_id==3){
                        return 'Temp';
                    }else{  
                        return '-';
                    }
                   
                })
                ->addColumn('share_link', function ($all_data) {
                    return $all_data->share_link;
                })  
                ->addColumn('status_id', function ($all_data) {
                   
                    if($all_data->status_id==1){
                        return 'Active';
                    }else if($all_data->status_id==2){
                        return 'Inactive';
                    }else{  
                        return '-';
                    }
                })  
                ->addColumn('action', function ($all_data) use($token) {
                    $edit_route = route("users.edit",$all_data->id);
                    $view_route = route("users.show",$all_data->id);
                    return '<div class="">
                                <div class="btn-group mr-2 mb-2 mb-sm-0">
                                    <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                        data-bs-original-title="View Project" class="btn btn-primary waves-light waves-effect">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                        data-bs-original-title="Edit Network" class="btn btn-primary waves-light waves-effect">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" id="delete_projects" data-id="'.$all_data->id.'" class="btn btn-primary waves-light waves-effect">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>';
                        })
                ->rawColumns(['action','name','surname','id_passport','email','role_id','share_link','status_id'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       

    }
    
}
