<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\UserEvents;
use App\Models\Users;
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
        if ($request->ajax()) {
            $columns = array(
            
                0 => 'user',
                1 => 'action',
                2 => 'type',
                3 => 'month',
                4 => 'year',
                5 => 'count',
            );

        
            $totalData = UserEvents::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if (empty($request->input('search.value'))) {
                $posts = UserEvents::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $posts = UserEvents::where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->cursor();

                $totalFiltered = UserEvents::where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->count();
            }

            $data = array();
            if (!empty($posts)) {
                $i = 1;
                foreach ($posts as $key => $post) {

                    if(isset($post->users_data->name)){
                        $name= $post->users_data->name.' '.$post->users_data->surname;
                    }
                    else{
                        $name='-';
                    }
                       
                       
                   
                    $view_route = route("user-events-view",$post->id);
                    $nestedData['id'] = $i;
                    $nestedData['user_id'] = $name;
                    $nestedData['action'] = $post->action ?? '-';
                    $nestedData['type'] = $post->type ?? '-';
                    $nestedData['month'] = $post->month ?? '-';
                    $nestedData['year'] = $post->year ?? '-';
                    $nestedData['count'] = $post->count ?? '-';
                   

                    $nestedData['options'] = '<div class="">
                        <div class="btn-group mr-2 mb-2 mb-sm-0">
                            <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                data-bs-original-title="View Network" class="btn btn-primary waves-light waves-effect">
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
