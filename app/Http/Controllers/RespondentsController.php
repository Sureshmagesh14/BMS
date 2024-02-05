<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Respondents;
use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
class RespondentsController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.respondents.index');
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
           
            $returnHTML = view('admin.respondents.create')->render();

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
               'email'=> 'required',
               'active_status_id'=> 'required',
               'password'=> 'required',
               'accept_terms'=> 'required',

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
                return response()->json([
                    'status'=>200,
                    'last_insert_id' => $respondents->id,
                    'message'=>'Respondents Added Successfully.'
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
            $data = Respondents::find($id);
            $returnHTML = view('admin.respondents.view',compact('data'))->render();

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
           
            $respondents = Respondents::find($id);
            if($respondents)
            {
                $returnHTML = view('admin.respondents.edit',compact('respondents'))->render();
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
                    'message'=>'No Respondents Found.'
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
               
                $respondents = Respondents::find($request->id);
                if($respondents)
                {
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
                    $respondents->update();
                    $respondents->id;
                    return response()->json([
                        'status'=>200,
                        'last_insert_id' => $respondents->id,
                        'message' => 'Respondents Updated.',
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Respondents Found.'
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
            $contents = Respondents::find($id);
            if($contents)
            {
                $contents->delete();
                return response()->json([
                    'status'=>200,
                    'success' => true,
                    'message'=>'Respondents Deleted Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'success' => false,
                    'message'=>'No Respondents Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }

    public function get_all_respondents(Request $request) {
		
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

                    $dob=$all_data->date_of_birth;
                    $diff = (date('Y') - date('Y',strtotime($dob)));
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
                    $edit_route = route("respondents.edit",$all_data->id);
                    $view_route = route("respondents.show",$all_data->id);

                    return '<div class="">
                        <div class="btn-group mr-2 mb-2 mb-sm-0">
                            <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                data-bs-original-title="View Network" class="btn btn-primary waves-light waves-effect">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                data-bs-original-title="Edit Network" class="btn btn-primary waves-light waves-effect">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" id="delete_respondents" data-id="'.$all_data->id.'" class="btn btn-primary waves-light waves-effect">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>';
                })
                ->rawColumns(['action','name','surname','mobile','whatsapp','email','age','gender','race','status','profile_completion','inactive_until','opeted_in'])      
                ->make(true);
                }
                return DataTables::queryBuilder($all_datas)->toJson();
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function respondent_export($arg) {
        
        $type='xlsx';

        if($arg=='deact'){
            $active = 2;
        }else{
            $active = 1;
        }

        $all_datas = DB::table('respondents')
            ->where("active_status_id",$active)
            ->orderby("id","desc")
            ->limit(10)
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'Surname');
        $sheet->setCellValue('C1', 'Phone');
        $sheet->setCellValue('D1', 'Phone 2');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Age');
        $sheet->setCellValue('G1', 'Gender');
        
        $rows = 2;
        $i=1;
        foreach($all_datas as $all_data){

            $dob=$all_data->date_of_birth;
            $diff = (date('Y') - date('Y',strtotime($dob)));
            
            $sheet->setCellValue('A' . $rows, $i);
            $sheet->setCellValue('B' . $rows, $all_data->name);
            $sheet->setCellValue('C' . $rows, $all_data->surname);
            $sheet->setCellValue('D' . $rows, $all_data->mobile);
            $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
            $sheet->setCellValue('F' . $rows, $all_data->email);
            $sheet->setCellValue('G' . $rows, $diff);

            
            $rows++;
            $i++;
        }

        $fileName = "deactivated_respondents_".date('ymd').".".$type;
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
