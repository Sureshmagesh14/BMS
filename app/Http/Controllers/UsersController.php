<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Models\Respondents;
use DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Facades\Hash;
use Config;
class UsersController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $users=Users::where('status_id',1)->get();
            return view('admin.users.index',compact('users'));
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
                $users->password = Hash::make($request->password);
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
            return view('admin.users.view',compact('data'));
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
                    $users->password = Hash::make($request->password);
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
                $role = $request->role;
                $status = $request->status;
                
                $all_datas = Users::withoutTrashed();
                if($role != null){
                    $all_datas->where('users.role_id',$role);
                }

                if($status != null){
                    $all_datas->where('users.status_id',$status);
                }
                $all_datas=$all_datas->latest()->get();
                
                return Datatables::of($all_datas)
                ->addColumn('select_all', function ($all_data) {
                    return '<input class="tabel_checkbox" name="rewards[]" type="checkbox" onchange="table_checkbox(this,\'user_table\')" id="'.$all_data->id.'">';
                })
                ->addColumn('id_show', function ($all_data) {
                    $view_route = route("users.show",$all_data->id);
                    return '<a href="'.$view_route.'" class="rounded waves-light waves-effect">'.$all_data->id.'
                    </a>';
                })
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
                        return 'Super User';
                    }else if($all_data->role_id==2){
                        return 'User';
                    }else if($all_data->role_id==3){
                        return 'Temp';
                    }else{  
                        return '-';
                    }
                   
                })
                ->addColumn('share_link', function ($all_data) {
                    $url= Config::get('constants.url').'/?r='.$all_data->share_link;
                    return '<a rel="noopener" target="_blank" href="'.$url.'">'.$url.'</a>';
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


                    $design = '<div class="col-md-2">
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
                                        data-bs-original-title="Edit User" class="rounded waves-light waves-effect">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#!" id="delete_users" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                        <i class="far fa-trash-alt"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>';

                    if(Auth::guard('admin')->user()->role_id == 1){
                        return $design;
                    }
                    else{
                        if(Auth::guard('admin')->user()->id == $all_data->id){
                            return $design;
                        }
                        else{
                            return '-';
                        }
                    }
                })
                ->rawColumns(['id_show','select_all','action','name','surname','id_passport','email','role_id','share_link','status_id'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function export_referrals(Request $request){
        
        //dd($request->user);

        $type='xlsx';
      
    

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(25);

        $sheet->setCellValue('A1', 'Referral ID');
        
        $sheet->setCellValue('B1', 'Respondent Profile ID');

        $sheet->setCellValue('C1', 'Name');    

        $sheet->setCellValue('D1', 'Surname');

        $sheet->setCellValue('E1', 'Phone Number');

        $sheet->setCellValue('F1', 'WhatsApp Number');
        
        $sheet->setCellValue('G1', 'Email');
        
        $sheet->setCellValue('H1', 'Age');
        
        $sheet->setCellValue('I1', 'Gender');
        
        $sheet->setCellValue('J1', 'Race');
        
        $sheet->setCellValue('K1', 'Profile Completion');

        $sheet->setCellValue('L1', 'Respondent Status');
        $sheet->setCellValue('M1', 'Date Opted In');
        $sheet->setCellValue('N1', 'Referral Source');
        $sheet->setCellValue('O1', 'Referred by Respondent Profile ID');
        $sheet->setCellValue('P1', 'Referred by Name');
        $sheet->setCellValue('Q1', 'Referred by Surname');
        $sheet->setCellValue('R1', 'Referred by Phone Number');
        $sheet->setCellValue('S1', 'Referred by WhatsApp Number');
        $sheet->setCellValue('T1', 'Referred by Email');        
        
        
        $all_datas = Respondents::select('respondents.*')
        ->orderby("respondents.id","desc")
        ->limit(10)
        ->get();

        $rows = 2;
        foreach($all_datas as $all_data){
            $sheet->setCellValue('C' . $rows, $all_data->name);
            $sheet->setCellValue('D' . $rows, $all_data->surname);
            $sheet->setCellValue('E' . $rows, $all_data->mobile);
            $sheet->setCellValue('F' . $rows, $all_data->whatsapp);
            $sheet->setCellValue('G' . $rows, $all_data->email);
            $sheet->setCellValue('M' . $rows, $all_data->opted_in);
            
            $rows++;
        }


        $fileName = "referrals_".date('ymd').".".$type;
        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
            $writer->save("export/".$fileName);
            
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/export/".$fileName);

    }
    
    public function export_user_activity(Request $request){
        
        //dd($request->user);

        $type='xlsx';
      
        $all_datas = Users::select('users.*')
        ->orderby("users.id","desc")
        ->get();

        

        foreach ($all_datas as $key => $val) {
           
            $get_data = DB::table('user_events')
                ->where("user_events.user_id",$val->id)
                ->orderby("id","desc")
                ->get();
            $resp_created =0;
            $resp_updated =0;
            $resp_deactivated =0;
    
            $proj_created =0;

            foreach ($get_data as $key => $adata) {
                
                $typeval= $adata->type;

                if($typeval=='respondent'){

                    if($adata->action=='created'){
                        $resp_created++;
                    }
                    if($adata->action=='updated'){
                        $resp_updated++;
                    }
                    if($adata->action=='deactivated'){
                        $resp_deactivated++;
                    } 
                }
                if($typeval=='project'){

                    if($adata->action=='created'){
                        $proj_created++;
                    }
                }
            }
            
        }
        

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(25);

        $sheet->setCellValue('A1', 'Name');
        

        $sheet->setCellValue('B1', 'Surname');

        $sheet->setCellValue('C1', 'Respondent Activity Report ID');    

        $sheet->setCellValue('D1', 'Created Respondents');

        $sheet->setCellValue('E1', 'Deactivated Respondents');

        $sheet->setCellValue('F1', 'Updated Respondents');
        
        $sheet->setCellValue('G1', 'Blacklisted Respondents');
        
        $sheet->setCellValue('H1', 'Project Activity Report ID');
        
        $sheet->setCellValue('I1', 'Created Projects');
        
        $sheet->setCellValue('J1', 'Projects Managed');
        
        $sheet->setCellValue('K1', 'Completed Projects');
        
        

        $rows = 2;
        $i=1;
        foreach($all_datas as $all_data){
            $sheet->setCellValue('A' . $rows, $all_data->name);
            $sheet->setCellValue('B' . $rows, $all_data->surname);
            $sheet->setCellValue('C' . $rows, '');
            $sheet->setCellValue('D' . $rows, $resp_created);
            $sheet->setCellValue('E' . $rows, $resp_deactivated);
            $sheet->setCellValue('F' . $rows, $resp_updated);
            $sheet->setCellValue('G' . $rows, '');
            $sheet->setCellValue('H' . $rows, '');
            $sheet->setCellValue('I' . $rows, $proj_created);
            $sheet->setCellValue('J' . $rows, '');
            $sheet->setCellValue('K' . $rows, '');

            
            $rows++;
            $i++;
        }

        $fileName = "user_activity_".date('ymd').".".$type;
        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
            $writer->save("export/".$fileName);
            
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/export/".$fileName);

    }

    public function users_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $tags = Users::find($id);
                $tags->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Users Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_email_id_check(Request $request){
        $form_name = $request->form_name;
        $email = $request->email;
        if($request->id==null){
            if($form_name == "usercreate"){
                $getCheckVal = DB::table('users')
                    ->whereRaw('TRIM(LOWER(`email`)) LIKE ? ', [trim(strtolower($email)) . '%'])
                    ->first();
            }
            else {
                $getCheckVal = "Not Empty";
            }
          
        }else{
            $getCheckVal = DB::table('users')
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

    public function users_action(Request $request){
        try {
            $all_id = $request->all_id;
            $status = ($request->value == "active") ? 1 : 2;
            $texts = ($request->value == "active") ? "Active" : "De-Active";
    
            foreach($all_id as $id){
                $tags = Users::where('id',$id)->update(['status_id' => $status]);
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Status '.$texts
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function users_search_result(Request $request) {
        try {
            $searchValue = $request->input('q'); // Use input method for clarity
            
            // Initialize an empty array for respondents
            $respondents = [];
    
            if ($request->filled('q')) {
                $respondents_data = Users::search($searchValue)
                    ->query(function ($query) {
                        $query->whereNull('deleted_at');
                    })
                    ->orderBy('id', 'ASC')
                    ->get();
    
                // Populate the respondents array if there are results
                foreach ($respondents_data as $resp) {
                    $respondents[] = [
                        'id' => $resp->id,
                        'name' => $resp->name . ' - ' . $resp->surname,
                    ];
                }
            }
    
            return response()->json($respondents); // Return JSON response properly
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); // Return JSON error response
        }
    }
}
