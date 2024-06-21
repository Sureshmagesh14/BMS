<?php

namespace App\Http\Controllers;

use App\Models\UserEvents;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use DB;

class InternalReportController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $users = Users::withoutTrashed()->get();
            return view('admin.internal_report.index', compact('users'));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public  function call_activity($role, $auth_id, $action, $type)
    {

       // Get the current month in lowercase (e.g., "january", "february")
    $currentMonth = strtolower(now()->format('F'));

    // Find or create a record in UserEvents for the current month and action
    $userEvent = UserEvents::updateOrCreate(
        [
            'user_id' => $auth_id,
            'action' => $action,
            'month' => $currentMonth,
            'year' => now()->year,
        ],
        [
            'role' => $role,
            'type' => $type,
            'year' => now()->year,
            'count' => DB::raw('count + 1'), // Increment count by 1
            'created_at' => now(), // Automatically set creation time
            'updated_at' => now(), // Automatically set update time
        ]
    );
// dd($userEvent);
        return $userEvent;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {

            $users = $request->users;
            $roles = $request->roles;
            $action = $request->action;
            $type = $request->type;
            $year = $request->year;
            $month = $request->month;

            $columns = array(
                0 => 'id',
                1 => 'action',
                2 => 'type',
                3 => 'month',
                4 => 'year',
                5 => 'count',
            );

            $totalData = UserEvents::select('user_events.*');
            if ($users != null) {$totalData->where('user_id', $users);}
            if ($roles != null) {$totalData->join('users', 'user_events.user_id', 'users.id')->where('role_id', $roles);}
            if ($action != null) {$totalData->where('action', $action);}
            if ($type != null) {$totalData->where('type', $type);}
            if ($year != null) {$totalData->where('year', $year);}
            if ($month != null) {$totalData->where('month', $month);}

            $totalData = $totalData->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if (empty($request->input('search.value'))) {
                $posts = UserEvents::select('user_events.*')->offset($start);
                if ($users != null) {$posts->where('user_id', $users);}
                if ($roles != null) {$posts->join('users', 'user_events.user_id', 'users.id')->where('role_id', $roles);}
                if ($action != null) {$posts->where('action', $action);}
                if ($type != null) {$posts->where('type', $type);}
                if ($year != null) {$posts->where('year', $year);}
                if ($month != null) {$posts->where('month', $month);}
                

                $posts = $posts->limit($limit)->orderBy($order, $dir)->get();
            } else {
                $search = $request->input('search.value');

                $posts = UserEvents::select('user_events.*')
                    ->orwhere('user_events.id', 'LIKE', "%{$search}%")
                    ->orWhere('user_events.action', 'LIKE', "%{$search}%")
                    ->orWhere('user_events.type', 'LIKE', "%{$search}%")
                    ->orWhere('user_events.month', 'LIKE', "%{$search}%")
                    ->orWhere('user_events.year', 'LIKE', "%{$search}%")
                    ->orWhere('user_events.count', 'LIKE', "%{$search}%")
                    ->join('users', 'user_events.user_id', 'users.id')
                    ->orWhere('users.name', 'LIKE', "%{$search}%")
                    ->orWhere('users.surname', 'LIKE', "%{$search}%");
                if ($users != null) {$posts->where('user_id', $users);}
                if ($roles != null) {$posts->join('users', 'user_events.user_id', 'users.id')->where('role_id', $roles);}
                if ($action != null) {$posts->where('action', $action);}
                if ($type != null) {$posts->where('type', $type);}
                if ($year != null) {$posts->where('year', $year);}
                if ($month != null) {$posts->where('month', $month);}

                $posts = $posts->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->cursor();

                $totalFiltered = UserEvents::where('user_events.id', 'LIKE', "%{$search}%")
                    ->orWhere('user_events.action', 'LIKE', "%{$search}%")
                    ->orWhere('user_events.type', 'LIKE', "%{$search}%")
                    ->orWhere('user_events.month', 'LIKE', "%{$search}%")
                    ->orWhere('user_events.year', 'LIKE', "%{$search}%")
                    ->orWhere('user_events.count', 'LIKE', "%{$search}%")
                    ->join('users', 'user_events.user_id', 'users.id')
                    ->orWhere('users.name', 'LIKE', "%{$search}%")
                    ->orWhere('users.surname', 'LIKE', "%{$search}%");

                if ($users != null) {$totalFiltered->where('user_id', $users);}
                if ($roles != null) {$totalFiltered->join('users', 'user_events.user_id', 'users.id')->where('role_id', $roles);}
                if ($action != null) {$totalFiltered->where('action', $action);}
                if ($type != null) {$totalFiltered->where('type', $type);}
                if ($year != null) {$totalFiltered->where('year', $year);}
                if ($month != null) {$posts->where('month', $month);}
                $totalFiltered = $totalFiltered->count();
            }

            $data = array();
            if (!empty($posts)) {
                $i = 1;
                foreach ($posts as $key => $post) {

                    if (isset($post->users_data->name)) {
                        $name = $post->users_data->name . ' ' . $post->users_data->surname;
                    } else {
                        $name = '-';
                    }

                    $view_route = route("user-events-view", $post->id);
                    $nestedData['id'] = $post->id;
                    $nestedData['user_id'] = $name;
                    $nestedData['action'] = $post->action ?? '-';
                    $nestedData['type'] = $post->type ?? '-';
                    $nestedData['month'] = $post->month ?? '-';
                    $nestedData['year'] = $post->year ?? '-';
                    $nestedData['count'] = $post->count ?? '-';

                    $nestedData['id_show'] = '
                            <a href="#!" data-url="' . $view_route . '" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                data-bs-original-title="View Internal Reports" class="waves-light waves-effect">
                                ' . $post->id . '
                            </a>';

                    $nestedData['options'] = '<div class="">
                        <div class="btn-group mr-2 mb-2 mb-sm-0">
                            <a href="#!" data-url="' . $view_route . '" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
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
            $data = UserEvents::find($id);
            $returnHTML = view('admin.internal_report.view', compact('data'))->render();

            return response()->json(
                [
                    'success' => true,
                    'html_page' => $returnHTML,
                ]
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
