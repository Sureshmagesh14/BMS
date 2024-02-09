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
                $users->password = $request->input('password');
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
            
                
                $all_datas = Users::withoutTrashed()->latest()->get();
        
                
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
                                        data-bs-original-title="Edit Project" class="btn btn-primary waves-light waves-effect">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" id="delete_users" data-id="'.$all_data->id.'" class="btn btn-primary waves-light waves-effect">
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
}
