<?php
namespace App\Http\Controllers;

use App\Models\Respondents;
use App\Models\Projects;
use App\Models\Banks;
use App\Models\Project_respondent;
use DB;
use Exception;
use Illuminate\Http\Request;
use App\Mail\Respondentprojectmail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class RespondentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.respondents.index');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $banks=Banks::where('active','=',1)->orderBy('bank_name', 'ASC')->get();
            $returnHTML = view('admin.respondents.create',compact('banks'))->render();

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'active_status_id' => 'required',
                'password' => 'required',
                'accept_terms' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages(),
                ]);
            } else {
                $respondents = new Respondents;
                $respondents->name = $request->input('name');
                $respondents->surname = $request->input('surname');
                $respondents->date_of_birth = $request->input('date_of_birth');
                $respondents->id_passport = $request->input('id_passport');
                $respondents->mobile = $request->input('mobile');
                $respondents->whatsapp = $request->input('whatsapp');
                $respondents->email = $request->input('email');
                $respondents->bank_name = $request->input('bank_name');
                $respondents->branch_code = $request->input('branch_code');
                $respondents->account_type = $request->input('account_type');
                $respondents->account_holder = $request->input('account_holder');
                $respondents->account_number = $request->input('account_number');
                $respondents->active_status_id = $request->input('active_status_id');
                $respondents->updated_at = $request->input('updated_at');
                $respondents->referral_code = $request->input('referral_code');
                $respondents->accept_terms = $request->input('accept_terms');
                $respondents->save();
                $respondents->id;
                app('App\Http\Controllers\InternalReportController')->call_activity(Auth::guard('admin')->user()->role_id,Auth::guard('admin')->user()->id,'created','respondent');
                $ref=array('respondent_id'=>$respondents->id,'user_id'=>Auth::guard('admin')->user()->id,'created_at'=>date("Y-m-d H:i:s A"));
                DB::table('respondent_referrals')->insert($ref);
         

                //email starts
                $id =$respondents->id;
                if ($id != null) {

                    $get_email = Respondents::where('id', $id)->first();
                    $to_address = $get_email->email;
                    //$to_address = 'hemanathans1@gmail.com';

                    $data = ['subject' => 'New account created','type' => 'new_register'];

                    Mail::to($to_address)->send(new WelcomeEmail($data));
                }
                //email ends 
              
                return response()->json([
                    'status' => 200,
                    'last_insert_id' => $respondents->id,
                    'message' => 'Respondents Added Successfully.',
                ]);
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try {
            $data = Respondents::find($id);
            return view('admin.respondents.view', compact('data'));

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {

            $respondents = Respondents::find($id);
            if ($respondents) {
                $banks=Banks::where('active','=',1)->orderBy('bank_name', 'ASC')->get();
                $returnHTML = view('admin.respondents.edit', compact('respondents','banks'))->render();
                return response()->json(
                    [
                        'success' => true,
                        'html_page' => $returnHTML,
                    ]
                );
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Respondents Found.',
                ]);
            }
        } catch (Exception $e) {
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
                'email' => 'required',
                'active_status_id' => 'required',
                'accept_terms'=> 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages(),
                ]);
            } else {
// dd($request->id);
                $respondents = Respondents::find($request->id);
                if ($respondents) {
                 
                    $respondents->name = $request->input('name');
                    $respondents->surname = $request->input('surname');
                    $respondents->date_of_birth = $request->input('date_of_birth');
                    $respondents->id_passport = $request->input('id_passport');
                    $respondents->mobile = $request->input('mobile');
                    $respondents->whatsapp = $request->input('whatsapp');
                    $respondents->email = $request->input('email');
                    $respondents->bank_name = $request->input('bank_name');
                    $respondents->branch_code = $request->input('branch_code');
                    $respondents->account_type = $request->input('account_type');
                    $respondents->account_holder = $request->input('account_holder');
                    $respondents->account_number = $request->input('account_number');
                    $respondents->active_status_id = $request->input('active_status_id');
                    $respondents->updated_at = $request->input('updated_at');
                    $respondents->referral_code = $request->input('referral_code');
                    $respondents->accept_terms = $request->input('accept_terms');
                    $respondents->update();
                    $respondents->id;
                    app('App\Http\Controllers\InternalReportController')->call_activity(Auth::guard('admin')->user()->role_id,Auth::guard('admin')->user()->id,'updated','respondent');
                    return response()->json([
                        'status' => 200,
                        'last_insert_id' => $respondents->id,
                        'message' => 'Respondents Updated.',
                    ]);
                } else {
                    return response()->json([
                        'status' => 404,
                        'error' => 'No Respondents Found.',
                    ]);
                }

            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contents = Respondents::find($id);
            app('App\Http\Controllers\InternalReportController')->call_activity(Auth::guard('admin')->user()->role_id,Auth::guard('admin')->user()->id,'deleted','respondent');
            if ($contents) {
                $contents->delete();
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => 'Respondents Deleted Successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'success' => false,
                    'message' => 'No Respondents Found.',
                ]);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function respondents_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $contents = Respondents::find($id);
                $contents->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Respondents Deleted Successfully'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function get_all_respondents(Request $request)
    {

        try {
            if ($request->ajax()) {

                $token = csrf_token();

                $all_datas = Respondents::latest()->get();

                return Datatables::of($all_datas)
                    ->addColumn('name', function ($all_data) {
                        return $all_data->name;
                    })
                    ->addColumn('surname', function ($all_data) {
                        return $all_data->surname;
                    })
                    ->addColumn('mobile', function ($all_data) {
                        return $all_data->mobile;
                    })
                    ->addColumn('whatsapp', function ($all_data) {
                        return $all_data->whatsapp;
                    })
                    ->addColumn('email', function ($all_data) {
                        return $all_data->email;
                    })
                    ->addColumn('age', function ($all_data) {

                        $dob = $all_data->date_of_birth;
                        $diff = (date('Y') - date('Y', strtotime($dob)));
                        return $diff;
                    })
                    ->addColumn('gender', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('race', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('status', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('profile_completion', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('inactive_until', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('opeted_in', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('action', function ($all_data) {
                        $edit_route = route("respondents.edit", $all_data->id);
                        $view_route = route("respondents.show", $all_data->id);

                        return'<div class="col-md-2">
                            <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                                title="Action" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-center">
                                <li class="list-group-item">
                                    <a href="'.$view_route.'" class="rounded waves-light waves-effect">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                        data-bs-original-title="Edit Respondent" class="rounded waves-light waves-effect">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#!" id="delete_respondents" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                        <i class="far fa-trash-alt"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>';
                    })
                    ->rawColumns(['action', 'name', 'surname', 'mobile', 'whatsapp', 'email', 'age', 'gender', 'race', 'status', 'profile_completion', 'inactive_until', 'opeted_in'])
                    ->make(true);
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function indexDataTable(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
            
                0 => 'id',
                1 => 'name',
                2 => 'surname',
                3 => 'mobile',
                4 => 'whatsapp',
                5 => 'gender',
                6=> 'date_of_birth',
                7=> 'race',
                8 => 'status',
                9 => 'profile_completion',
                10=> 'inactive_until',
                11=> 'opeted_in',
                12 => 'action',
            );

            $inside_form = $request->inside_form;
        
            if(isset($request->id)){
                if($inside_form == 'projects'){
                    $totalData = Respondents::Join('project_respondent as pr','respondents.id','pr.respondent_id')->where('pr.project_id',$request->id)->count();
                }
                else{

                    $totalData = Respondents::count();
                }
            }
            else{
                $totalData = Respondents::count();
            }

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            

            if (empty($request->input('search.value'))) {
                $posts = Respondents::select('respondents.*')->offset($start);
                    if(isset($request->id)){
                        if($inside_form == 'projects'){
                            $posts->Join('project_respondent as pr','respondents.id','pr.respondent_id')
                            ->where('pr.project_id',$request->id);
                        }
                    }
                $posts = $posts->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            }
            else {
                $search = $request->input('search.value');

                $posts = Respondents::select('respondents.*')->where('id', 'LIKE', "%{$search}%");
                    if(isset($request->id)){
                        if($inside_form == 'projects'){
                            $posts->Join('project_respondent as pr','respondents.id','pr.respondent_id')
                            ->where('pr.project_id',$request->id);
                        }
                    }
                $posts = $posts->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('surname', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%")
                    ->orWhere('whatsapp', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->cursor();

                $totalFiltered = Respondents::where('id', 'LIKE', "%{$search}%");
                    if(isset($request->id)){
                        if($inside_form == 'projects'){
                            $totalFiltered->Join('project_respondent as pr','respondents.id','pr.respondent_id')
                            ->where('pr.project_id',$request->id);
                        }
                    }
                $totalFiltered = $totalFiltered->orWhere('name', 'LIKE', "%{$search}%")
                                                ->orWhere('surname', 'LIKE', "%{$search}%")
                                                ->orWhere('whatsapp', 'LIKE', "%{$search}%")
                                                ->orWhere('mobile', 'LIKE', "%{$search}%")
                                                ->orWhere('email', 'LIKE', "%{$search}%")
                                                ->count();
            }

            $data = array();
            if (!empty($posts)) {
                $i = 1;
                foreach ($posts as $key => $post) {
                    $edit_route = route('respondents.edit', $post->id);
                    $view_route = route('respondents.show', $post->id);
                    $nestedData['select_all'] = '<input class="tabel_checkbox" name="networks[]" type="checkbox" onchange="table_checkbox(this,\'respondents_datatable\')" id="'.$post->id.'">';
                    $nestedData['id'] = $post->id;
                    $nestedData['name'] = $post->name ?? '-';
                    $nestedData['surname'] = $post->surname ?? '-';
                    $nestedData['mobile'] = $post->mobile ?? '-';
                    $nestedData['whatsapp'] = $post->whatsapp ?? '-';
                    $nestedData['email'] = $post->email ?? '-';
                    if($post->date_of_birth!=null){
                        $bday = new \DateTime($post->date_of_birth); // Creating a DateTime object representing your date of birth.
                        $today = new \DateTime(date('m.d.y'));
                        $diff = $today->diff($bday); 
    
                        $age=$diff->y. 'year '. $diff->m. 'month '. $diff->d .'days';
                    }else{
                        $age='-';
                    }
                   
                    $nestedData['date_of_birth'] = $age;
                    $nestedData['race'] = $post->race ?? '-';
                    $nestedData['status'] = $post->status ?? '-';
                    $nestedData['profile_completion'] = $post->profile_completion ?? '-';
                    $nestedData['inactive_until'] = $post->inactive_until ?? '-';
                    $nestedData['opeted_in'] = $post->opeted_in ?? '-';

                    $nestedData['id_show'] = '<a href="'.$view_route.'" class="rounded waves-light waves-effect">
                        '.$post->id.'
                    </a>';

                    $nestedData['options'] = '<div class="col-md-2">
                        <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                            title="Action" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-center">
                            <li class="list-group-item">
                                <a href="'.$view_route.'" class="rounded waves-light waves-effect">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </li>';
                            if (str_contains(url()->previous(), '/admin/projects')){

                                $nestedData['options'] .= '<li class="list-group-item">
                                    <a id="deattach_respondents" data-id="'.$post->id.'" class="rounded waves-light waves-effect">
                                        <i class="far fa-trash-alt"></i> De-attach
                                    </a>
                                </li>';
                            }
                            else{
                                $nestedData['options'] .= '<li class="list-group-item">
                                    <a data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                        data-bs-original-title="Edit Respondent" class="rounded waves-light waves-effect">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#!" id="delete_respondents" data-id="'.$post->id.'" class="rounded waves-light waves-effect">
                                        <i class="far fa-trash-alt"></i> Delete
                                    </a>
                                </li>';
                            }
                        $nestedData['options'] .= '</ul>
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

    public function respondent_export(Request $request)
    {

        $module_name = $request->module_name;
        $from = date('Y-m-d', strtotime($request->start));
        $to = date('Y-m-d', strtotime($request->end));

        $type = 'xlsx';

        if ($module_name == 'respondent_export') {

            $all_datas = DB::table('respondents')
                ->where("active_status_id", 1)
                ->whereBetween('created_at', [$from, $to])
                ->orderby("id", "desc")
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Respondent Profile ID');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('C1', 'Surname');
            $sheet->setCellValue('D1', 'Phone Number');
            $sheet->setCellValue('E1', 'WhatsApp Number');
            $sheet->setCellValue('F1', 'Email');
            $sheet->setCellValue('G1', 'RSA ID / Passport');
            $sheet->setCellValue('H1', 'Date of Birth');
            $sheet->setCellValue('I1', 'Age');
            $sheet->setCellValue('J1', 'Gender');
            $sheet->setCellValue('K1', 'Race');
            $sheet->setCellValue('L1', 'Full Profile Completion %');
            $sheet->setCellValue('M1', 'Basic Profile Completion %');
            $sheet->setCellValue('N1', 'Essential Profile Completion %');
            $sheet->setCellValue('O1', 'Extended Profile Completion %');
            $sheet->setCellValue('P1', 'Respondent Status');
            $sheet->setCellValue('Q1', 'Data Inactive Until');
            $sheet->setCellValue('R1', 'Date Opted In');
            $sheet->setCellValue('S1', 'Date Last Updated');
            $sheet->setCellValue('T1', 'Referral Link');
            $sheet->setCellValue('U1', 'Accepted Terms');
            $sheet->setCellValue('V1', 'Created By');

            $rows = 2;
            $i = 1;
            foreach ($all_datas as $all_data) {

                $dob = $all_data->date_of_birth;
                $diff = (date('Y') - date('Y', strtotime($dob)));

                $opted_in = date('d-m-Y', strtotime($all_data->opted_in));
                $updated_at = date('d-m-Y', strtotime($all_data->updated_at));

                if ($all_data->accept_terms == 1) {
                    $accept_terms = 'Yes';
                } else {
                    $accept_terms = $all_data->accept_terms;
                }

                $sheet->setCellValue('A' . $rows, $i);
                $sheet->setCellValue('B' . $rows, $all_data->name);
                $sheet->setCellValue('C' . $rows, $all_data->surname);
                $sheet->setCellValue('D' . $rows, $all_data->mobile);
                $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
                $sheet->setCellValue('F' . $rows, $all_data->email);
                $sheet->setCellValue('G' . $rows, $all_data->id_passport);
                $sheet->setCellValue('H' . $rows, $diff);

                $sheet->setCellValue('R' . $rows, $opted_in);
                $sheet->setCellValue('S' . $rows, $updated_at);
                $sheet->setCellValue('T' . $rows, $all_data->referral_code);
                $sheet->setCellValue('U' . $rows, $accept_terms);
                $sheet->setCellValue('V' . $rows, $all_data->created_by);

                $rows++;
                $i++;
            }

            $fileName = "respondent_details_" . date('ymd') . "." . $type;

        } else if ($module_name == 'gen_respondent_res_export') {

            $all_datas = DB::table('respondents')
                ->where("active_status_id", 1)
                ->whereBetween('created_at', [$from, $to])
                ->orderby("id", "desc")
                ->limit(10)
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Respondent Profile ID');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('C1', 'Surname');
            $sheet->setCellValue('D1', 'Phone Number');
            $sheet->setCellValue('E1', 'WhatsApp Number');
            $sheet->setCellValue('F1', 'Email');
            $sheet->setCellValue('G1', 'Respondent Status');
            $sheet->setCellValue('H1', 'Profile Completion');
            $sheet->setCellValue('I1', 'Average Login Time');
            $sheet->setCellValue('J1', 'Membership Duration');
            $sheet->setCellValue('K1', 'Invite-to-Join Conversion Rate');

            $rows = 2;
            $i = 1;
            foreach ($all_datas as $all_data) {

                $dob = $all_data->date_of_birth;
                $diff = (date('Y') - date('Y', strtotime($dob)));

                $opted_in = date('d-m-Y', strtotime($all_data->opted_in));
                $updated_at = date('d-m-Y', strtotime($all_data->updated_at));

                if ($all_data->accept_terms == 1) {
                    $accept_terms = 'Yes';
                } else {
                    $accept_terms = $all_data->accept_terms;
                }

                $sheet->setCellValue('A' . $rows, $i);
                $sheet->setCellValue('B' . $rows, $all_data->name);
                $sheet->setCellValue('C' . $rows, $all_data->surname);
                $sheet->setCellValue('D' . $rows, $all_data->mobile);
                $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
                $sheet->setCellValue('F' . $rows, $all_data->email);

                $rows++;
                $i++;
            }

            $fileName = "respondent_activity_" . date('ymd') . "." . $type;

        } else if ($module_name == 'gen_respondent_mon_export') {

            $all_datas = DB::table('respondents')
                ->where("active_status_id", 1)
                ->whereBetween('created_at', [$from, $to])
                ->orderby("id", "desc")
                ->limit(10)
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Month');
            $sheet->setCellValue('B1', 'Year');
            $sheet->setCellValue('C1', 'Respondent Status Breakdown');
            $sheet->setCellValue('D1', 'Profile Completion Breakdown');
            $sheet->setCellValue('E1', 'Average Login Time');
            $sheet->setCellValue('F1', 'Membership Duration');
            $sheet->setCellValue('G1', 'Invite-to-Join Conversion Rate');

            $rows = 2;
            $i = 1;
            // foreach($all_datas as $all_data){

            //     $sheet->setCellValue('A' . $rows, $i);
            //     $sheet->setCellValue('B' . $rows, $all_data->name);
            //     $sheet->setCellValue('C' . $rows, $all_data->surname);
            //     $sheet->setCellValue('D' . $rows, $all_data->mobile);
            //     $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
            //     $sheet->setCellValue('F' . $rows, $all_data->email);

            //     $rows++;
            //     $i++;
            // }

            $fileName = "respondent_month_activity_" . date('ymd') . "." . $type;

        }

        if ($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if ($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
        $writer->save("export/" . $fileName);

        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/') . "/export/" . $fileName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function export_resp()
    {
        try {

            $returnHTML = view('admin.respondents.export')->render();

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

    public function respondents_export(Request $request){
        try {
            $id_value = $request->id_value;
            $form     = $request->form;
            $from     = date('Y-m-d', strtotime($request->start));
            $to       = date('Y-m-d', strtotime($request->end));
            $type     = 'xlsx';

            return view('admin.report.respondents')->with('form',$form)->with('id_value',$id_value);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function attach_respondents(Request $request){
        try {
            $project_id = $request->project_id;
            // $respondents = Respondents::select('respondents.id','respondents.name','respondents.surname')->whereNull('deleted_at')->take(10)->get();
            $projects = Projects::select('projects.id','projects.name')->where('projects.id',$project_id)->first();

            $returnHTML = view('admin.respondents.attach', compact('projects'))->render();

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

    public function import_respondents(Request $request){
        try {
            $project_id = $request->project_id;
            $projects = Projects::select('projects.id','projects.name')->where('projects.id',$project_id)->first();

            $returnHTML = view('admin.respondents.import', compact('projects','project_id'))->render();

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

    public function upload_respondent(Request $request){
        $import_excel = $request->import_excel;
        
        $kilobyte  = 1024;
        $megabyte  = $kilobyte * 1024;
        $size      = $_FILES["import_excel"]['size'];
        $filename  = $_FILES["file"]["name"];
        $sizein_mb = round($size / $megabyte,2);

        if($sizein_mb <= 5){

        }
        else{
            return redirect()->back()->withErrors("Please Upload Less than 5mb");
        }
    }

    public function respondent_seach_result(Request $request){
        try {
            $searchValue = $request['q'];
            
            if($request->filled('q')){
                $respondents_data = Respondents::search($searchValue)
                ->query(function ($query) {
                    $query->where('deleted_at', '=', NULL);
                })
                ->orderBy('id','ASC')
                ->get();
            }

            $respondents = array();
            if(count($respondents_data) > 0){
                foreach($respondents_data as $resp){
                    $setUser = [
                        'id' => $resp->id,
                        'name' => $resp->name . ' - ' . $resp->surname,
                    ];
                    $respondents[] = $setUser;
                }
            }

            echo json_encode($respondents);
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function respondent_attach_store(Request $request){
        try {
            $project_id  = $request->project_id;
            $respondents = $request->respondents;

            if(Project_respondent::where('project_id', $project_id)->where('respondent_id', $respondents)->exists()){
                return response()->json([
                    'text_status' => false,
                    'status' => 200,
                    'message' => 'Respondents Already Attached.',
                ]);
            }
            else{
                Project_respondent::insert(['project_id' => $project_id, 'respondent_id' => $respondents]);
                $projects=Projects::select('name')->where('id',$project_id)->first();

                 //email starts
                 $proj = Projects::where('id',$project_id)->first();
                 $resp = Respondents::where('id',$respondents)->first();
                 
                 if($proj->name!='')
                 {
                    $to_address = $resp->email;
                    //$to_address = 'hemanathans1@gmail.com';
                    $resp_name = $resp->name.' '.$resp->surname;
                    $proj_name = $proj->name;

                    $data = ['subject' => 'New Survey Assigned','name' => $resp_name,'project' => $proj_name,'type' => 'new_project'];
                
                    Mail::to($to_address)->send(new WelcomeEmail($data));
                 }
                //email ends
                

                return response()->json([
                    'text_status' => true,
                    'status' => 200,
                    'message' => 'Respondents Attached Successfully.',
                ]);
            }
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deattach_respondent($resp_id, $project_id){
        try {
            if(Project_respondent::where('project_id', $project_id)->where('respondent_id', $resp_id)->exists()){
                Project_respondent::where('project_id', $project_id)->where('respondent_id', $resp_id)->delete();
                return response()->json([
                    'text_status' => true,
                    'status' => 200,
                    'message' => 'Deattach Respondents Successfully.',
                ]);
            }
            else{
                return response()->json([
                    'text_status' => false,
                    'status' => 200,
                    'message' => 'Cant find respondents or projects',
                ]);
            }
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function user_respondent_id_check(Request $request){
        $form_name = $request->form_name;
        $email = $request->email;
        if($request->id==null){
            if($form_name == "usercreate"){
                $getCheckVal = DB::table('respondents')
                    ->whereRaw('TRIM(LOWER(`email`)) LIKE ? ', [trim(strtolower($email)) . '%'])
                    ->first();
            }
            else {
                $getCheckVal = "Not Empty";
            }
          
        }else{
            $getCheckVal = DB::table('respondents')
            ->whereRaw('TRIM(LOWER(`email`)) LIKE ? ', [trim(strtolower($email)) . '%'])
            ->whereNot('id', $request->id)
            ->first();
           
        }
        

        if ($getCheckVal == null) {
            echo "true";
            // return 1; //Success
        } else {
            echo "false";
            // return 0; //Error
        }
    }

    public function get_user_survey(Request $request)
    {

        try {
            if ($request->ajax()) {

                $token = csrf_token();

                $all_datas = Respondents::latest()->get();

                return Datatables::of($all_datas)
                    ->addColumn('name', function ($all_data) {
                        return $all_data->name;
                    })
                    ->addColumn('surname', function ($all_data) {
                        return $all_data->surname;
                    })
                    ->addColumn('mobile', function ($all_data) {
                        return $all_data->mobile;
                    })
                    ->addColumn('whatsapp', function ($all_data) {
                        return $all_data->whatsapp;
                    })
                    ->addColumn('email', function ($all_data) {
                        return $all_data->email;
                    })
                    ->addColumn('age', function ($all_data) {

                        $dob = $all_data->date_of_birth;
                        $diff = (date('Y') - date('Y', strtotime($dob)));
                        return $diff;
                    })
                    ->addColumn('gender', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('race', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('status', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('profile_completion', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('inactive_until', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('opeted_in', function ($all_data) {
                        return '-';
                    })
                    ->addColumn('action', function ($all_data) {
                        $edit_route = route("respondents.edit", $all_data->id);
                        $view_route = route("respondents.show", $all_data->id);

                        return'<div class="col-md-2">
                            <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                                title="Action" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-center">
                                <li class="list-group-item">
                                    <a href="'.$view_route.'" class="rounded waves-light waves-effect">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                        data-bs-original-title="Edit Respondent" class="rounded waves-light waves-effect">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#!" id="delete_respondents" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                        <i class="far fa-trash-alt"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>';
                    })
                    ->rawColumns(['action', 'name', 'surname', 'mobile', 'whatsapp', 'email', 'age', 'gender', 'race', 'status', 'profile_completion', 'inactive_until', 'opeted_in'])
                    ->make(true);
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function get_branch_code(Request $request){
        $bank_id = $request->bank_id;
        $branch_code=Banks::where('id',$bank_id)->first();
        $repsonse=$branch_code->branch_code;

        return response()->json(['repsonse' => $repsonse], 200);
    }
    
}
