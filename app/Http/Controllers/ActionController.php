<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Banks;
use App\Models\Contents;
use App\Models\Networks;
use App\Models\Charities;
use App\Models\Groups;
use App\Models\Tags;
use App\Models\Respondents;
use App\Models\Projects;
use App\Models\Action;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
class ActionController extends Controller
{   
    public function actions()
    {   
        try {
            return view('admin.action.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }
    // public function get_all_actions(Request $request) {
    //     try {
    //         if ($request->ajax()) {

    //         $token = csrf_token();

    //         $all_datas = Action::select('action_events.*','users.name as uname')
    //         ->join('users', 'users.id', '=', 'action_events.user_id') 
    //         ->limit(30)
    //         ->get();


    //         return Datatables::of($all_datas)

    //         ->addColumn('name', function ($all_data) {
    //         return $all_data->name;
    //         })  
    //         ->addColumn('uname', function ($all_data) {
    //         return $all_data->uname;
    //         })  
    //         ->addColumn('target_id', function ($all_data) {
    //         return $all_data->target_id;
    //         })  
    //         ->addColumn('status', function ($all_data) {
    //         return $all_data->status;
    //         })
    //         ->addColumn('updated_at', function ($all_data) {
    //         return date("M j, Y, g:i A", strtotime($all_data->updated_at));
    //         })  
    //         ->addColumn('action', function ($all_data) use($token) {

    //         return '<div class="">
    //         <div class="btn-group mr-2 mb-2 mb-sm-0">
    //             <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></button>
    //         </div></div>';

    //         })
    //         ->rawColumns(['action','name','uname','target_id'])      
    //         ->make(true);
    //         }
    //     }
    //     catch (Exception $e) {
    //         throw new Exception($e->getMessage());
    //     }
        

    // }

    public function get_all_actions(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
            
                0 => 'id',
                1 => 'name',
                2 => 'actionable_id',
                3 => 'uname',
                4 => 'target_id',
            );

        
            $totalData = Action::select('action_events.*','users.name as uname','users.id as user_id')
                        ->join('users', 'users.id', '=', 'action_events.user_id')->count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if (empty($request->input('search.value'))) {
                $posts = Action::select('action_events.*','users.name as uname','users.id as user_id')
            ->join('users', 'users.id', '=', 'action_events.user_id')
            ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $posts =Action::select('action_events.*','users.name as uname','users.id as user_id')
                        ->join('users', 'users.id', '=', 'action_events.user_id')
                     
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->cursor();
// dd($posts);
                $totalFiltered =  Action::where('id', 'LIKE', "%{$search}%")
                ->join('users', 'users.id', '=', 'action_events.user_id') 
                ->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->count();
            }

            $data = array();
            if (!empty($posts)) {
                $i = 1;
                foreach ($posts as $key => $post) {

                $view_route = route('view-actions', $post->id);
                 
                 $nestedData['id'] = $i;
                 $nestedData['name'] = $post->name  ?? '-';
                 $nestedData['uname'] = $post->uname  ?? '-';
              
                 if($post->actionable_type =='App\Models\Respondent'){
                    $get_name=DB::table('respondents')->where('id',$post->actionable_id)->first();
                    if(isset($get_name->name)){
                        $name=$get_name->name;
                    }else{
                        $name='';
                    }

                    if(isset($get_name->surname)){
                        $surname=$get_name->surname;
                    }else{
                        $surname='';
                    }

                    if(isset($get_name->email)){
                        $email=$get_name->email;
                    }else{
                        $email='';
                    }

                    if(isset($get_name->mobile)){
                        $mobile=$get_name->mobile;
                    }else{
                        $mobile='';
                    }
                    $get_val_name='Respondent: '.$name.'-'.$surname.'-'.$email.'-'.$mobile;
                 }else if($post->actionable_type =='App\Models\Group'){

                 }else if($post->actionable_type =='App\Models\Content'){

                 }
                 else{
                    $get_name=DB::table('users')->where('id',$post->actionable_id)->first();
                    if(isset($get_name->name)){
                        $name=$get_name->name;
                    }else{
                        $name='';
                    }

                    if(isset($get_name->surname)){
                        $surname=$get_name->surname;
                    }else{
                        $surname='';
                    }
                    $get_val_name='User: '.$name.' '.$surname;
                 }
                 $nestedData['actionable_id'] = $get_val_name  ?? '-';
                 $nestedData['status'] = $post->status  ?? '-';
                 $nestedData['created_at'] = $newDateTime = date('Y-m-d h:i A', strtotime($post->created_at))  ?? '-';
                

                    $nestedData['options'] = '<div class="">
                        <div class="btn-group mr-2 mb-2 mb-sm-0">
                            <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                data-bs-original-title="View Internal Reports" class="btn btn-primary waves-light waves-effect">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>';
                    $data[] = $nestedData;
                    $i++;
                }
            }

            $json_data = array(
                "draw" => intval($request->input('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data,
            );

            echo json_encode($json_data);
        }

    }

    public function view(string $id)
    {
        
        try {
            $data = Action::select('action_events.*','users.name as uname')
            ->join('users', 'users.id', '=', 'action_events.user_id')
            ->where('action_events.id','=',$id)
            ->first();

            $returnHTML = view('admin.action.view',compact('data'))->render();

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