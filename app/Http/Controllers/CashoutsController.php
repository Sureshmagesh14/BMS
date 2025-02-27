<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Cashout;
use DB;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use App\Models\Users;
use Exception;
use App\Services\SendGridService;
class CashoutsController extends Controller
{   
    public function cashouts()
    {   
        try {
            $users = Users::withoutTrashed()->get();
        
            return view('admin.cashouts.index',compact('users'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
       
    }
    public function get_all_cashouts(Request $request) {
		
        try {
            if ($request->ajax()) {

                $token = csrf_token();
                $inside_form = $request->inside_form;
                $type = $request->type;
                $status = $request->status;
                
                $all_datas = Cashout::select('cashouts.*','respondents.name','respondents.email','respondents.mobile')
                    ->join('respondents', 'respondents.id', '=', 'cashouts.respondent_id');
                    if(isset($request->id)){
                        if($inside_form == 'respondents'){
                            $all_datas->where('cashouts.respondent_id',$request->id);
                        }
                    }

                    if($type != null){
                        $all_datas->where('cashouts.type_id',$type);
                    }

                    if($status != null){
                        $all_datas->where('cashouts.status_id',$status);
                    }

                $all_datas = $all_datas->orderby("id","desc")->withoutTrashed()->get();
        
                return Datatables::of($all_datas)
                ->addColumn('select_all', function ($all_data) {
                    return '<input class="tabel_checkbox" name="cash_out[]" type="checkbox" onchange="table_checkbox(this,\'cashout_table\')" id="'.$all_data->id.'">';
                })
                ->addColumn('id_show', function ($all_data) {
                    $view_route = route("cashouts-view",$all_data->id);
                    return ' <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                        data-bs-original-title="View Cashouts" class="waves-light waves-effect">
                        '.$all_data->id.'
                    </a>';
                })
                ->addColumn('type_id', function ($all_data) {
                    if($all_data->type_id==1){
                        return 'EFT';
                    }else if($all_data->type_id==2){
                        return 'Data';
                    }else if($all_data->type_id==3){
                        return 'Airtime';
                    }
                    else if($all_data->type_id==4){
                        return 'Donation';
                    }
                    else{  
                        return '-';
                    }
                })  
                ->addColumn('status_id', function ($all_data) {
                    if($all_data->status_id == 0){
                        return 'Failed';
                    }else if($all_data->status_id == 1){
                        return 'Pending';
                    }else if($all_data->status_id == 2){
                        return 'Processing';
                    }else if($all_data->status_id == 3){
                        return 'Complete';
                    }else if($all_data->status_id == 4){
                        return 'Declined';
                    }else{  
                        return 'Approved For Processing';
                    }
                })
                ->addColumn('amount', function ($all_data) {
                    $amount = $all_data->amount/10;
                    return $amount;
                })
                ->addColumn('points', function ($all_data) {
                    $points = floor($all_data->amount / 10) * 10;
                    return $points;
                })
                ->addColumn('respondent_id', function ($all_data) {
                    return $all_data->name.' - '.$all_data->email.' - '.$all_data->mobile;
                })
                ->addColumn('action', function ($all_data) use($token) {
                    $view_route = route("cashouts-view",$all_data->id);
                    return '<div class="">
                        <div class="btn-group mr-2 mb-2 mb-sm-0">
                            <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                data-bs-original-title="View Cashouts" class="btn btn-primary waves-light waves-effect">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>';
                })
                ->rawColumns(['id_show','select_all','id','action','type_id','status_id','amount','respondent_id'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function view(string $id)
    {
        
        try {
            $data = Cashout::select('cashouts.*','respondents.name','respondents.email','respondents.mobile')
            ->join('respondents', 'respondents.id', '=', 'cashouts.respondent_id')
            ->where('cashouts.id',$id)
            ->first();
            $returnHTML = view('admin.cashouts.view',compact('data'))->render();

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
     * Show the form for creating a new resource.
     */
    public function export_cash()
    {
        try {
           
            $returnHTML = view('admin.cashouts.export')->render();

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

    public function cash_export(Request $request) {

        $module_name = $request->module_name;
        $from = date('Y-m-d',strtotime($request->start));
        $to = date('Y-m-d',strtotime($request->end));
        
        dd($request);

        $type='xlsx';
        
        if($module_name=='cash_summary_export'){

        $all_datas = Cashout::select('cashouts.*','respondents.name','respondents.email','respondents.mobile')
                ->join('respondents', 'respondents.id', '=', 'cashouts.respondent_id') 
                ->whereBetween('cashouts.created_at', [$from, $to])
                ->orderby("id","desc")
                ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Month');
        $sheet->setCellValue('B1', 'Year');
        $sheet->setCellValue('C1', 'Cash Out Status Breakdown');
        $sheet->setCellValue('D1', 'Total Pending Cash Outs Amount');
        $sheet->setCellValue('E1', 'Total Completed Cash Outs Amount');
        $sheet->setCellValue('F1', 'Most & Least Used Cash Out Method');
        
        $rows = 2;
        $i=1;
        foreach($all_datas as $all_data){

            // if($all_data->type_id==1){
            //     $type_val ='EFT';
            // }else if($all_data->type_id==2){
            //     $type_val ='Data';
            // }else if($all_data->type_id==3){
            //     $type_val ='Airtime';
            // }else{  
            //     $type_val ='-';
            // }
            
            // if($all_data->status_id==0){
            //     $status_val ='Failed';
            // }else if($all_data->status_id==1){
            //     $status_val ='';
            // }else if($all_data->status_id==2){
            //     $status_val ='';
            // }else if($all_data->status_id==3){
            //     $status_val ='Complete';
            // }else if($all_data->status_id==4){
            //     $status_val ='Declined';
            // }else{  
            //     $status_val ='-';
            // }

            // $amount = $all_data->amount/10;
            // $respondent = $all_data->name.' - '.$all_data->email.' - '.$all_data->mobile;
            
            // $sheet->setCellValue('A' . $rows, $i);
            // $sheet->setCellValue('B' . $rows, $type_val);
            // $sheet->setCellValue('C' . $rows, $status_val);
            // $sheet->setCellValue('D' . $rows, $amount);
            // $sheet->setCellValue('E' . $rows, $respondent);
            // $rows++;
            // $i++;
        }

        $fileName = "cashout_month_summary_".date('ymd').".".$type;

        }else if($module_name=='cash_summary_resp_export'){


            $all_datas =Cashout::select('cashouts.*','respondents.name','respondents.email','respondents.mobile')
                ->join('respondents', 'respondents.id', '=', 'cashouts.respondent_id') 
                ->whereBetween('cashouts.created_at', [$from, $to])
                ->orderby("id","desc")
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Respondent Profile ID');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('C1', 'Surname');
            $sheet->setCellValue('D1', 'Phone Number');
            $sheet->setCellValue('E1', 'WhatsApp Number');
            $sheet->setCellValue('F1', 'Email');
            $sheet->setCellValue('G1', 'Cash Out Status Breakdown');
            $sheet->setCellValue('H1', 'Total Pending Cash Outs Amount');
            $sheet->setCellValue('I1', 'Total Completed Cash Outs Amount');
            $sheet->setCellValue('J1', 'Most & Least Used Cash Out Method');
            
            $fileName = "cashout_resp_summary_".date('ymd').".".$type;
        }else{

        }
        
        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
            $writer->save("export/".$fileName);
            
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/export/".$fileName);
    }

    public function cash_multi_update(Request $request){
        try {
            $all_id = $request->all_id;
            dd($request->all());
            foreach($all_id as $id){
                $arr=array('status_id',);
                $cashout = Cashout::where('id',$id)->update($id);
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Tags Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    

    public function cash_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $tags = Cashout::find($id);
                $tags->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Cashout Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function cashout_export(Request $request){
        try {
            $id_value = $request->id_value;
            $form     = $request->form;

            return view('admin.report.cashout')->with('form',$form)->with('id_value',$id_value);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function cashout_action(Request $request) {
        try {
            $all_id = $request->all_id;
            $value  = $request->value;
    
            if (empty($all_id) || !isset($value)) {
                return response()->json([
                    'status' => 400,
                    'success' => false,
                    'message' => 'Missing required parameters'
                ]);
            }
    
            foreach ($all_id as $id) {
                $cash = DB::table('cashouts as c')
                    ->leftJoin('respondents as r', 'c.respondent_id', '=', 'r.id')
                    ->leftJoin('banks as b', 'c.bank_id', '=', 'b.id')
                    ->select('c.*', 'r.name', 'r.surname', 'r.email', 'b.bank_name', 'b.branch_code')
                    ->where('c.id', $id)
                    ->first();
    
                // Check if the $cash object is null
                if (!$cash) {
                    continue;  // Skip if no data is found for the current id
                }
    
                $to_address = $cash->email;
                $resp_name = $cash->name ?? 'Customer'; // Fallback if name is null
                $points = $cash->amount;
    
                // Determine request type based on type_id
                $req_type = '';
                switch ($cash->type_id) {
                    case 1:
                        $req_type = 'EFT';
                        break;
                    case 2:
                        $req_type = 'Data';
                        break;
                    case 3:
                        $req_type = 'Airtime';
                        break;
                    case 4:
                        $req_type = 'Donation';
                        break;
                    default:
                        $req_type = 'Unknown';
                        break;
                }
    
                // Update the status in the cashouts table
                Cashout::where('id', $id)->update(['status_id' => $value]);
    
                $dynamicData = [
                    'points' => $points,
                    'date_requested' => date('d-m-Y'),
                    'first_name' => $resp_name,
                    'rand_value' => 'R ' . number_format($points / 10, 2),
                    'payment_method' => strtoupper($req_type)
                ];
    
                if (in_array($value, [1, 3, 4, 5])) {
                    $subject = '';
                    $templateId = '';
                    
                    // Fixed email template selection based on value
                    switch ($value) {
                        case 1:
                            $subject = 'Cashout Request';
                            $templateId = 'd-fadcfcb9f22a4e3d873fcb0459dc1b58';
                            break;
                        case 3:
                            $subject = 'Cash Out Approved';
                            $templateId = 'd-5d2729f3674c4b0085c8b105ca258094';
                            break;
                        case 4:
                            $subject = 'Cash Out Failed';
                            $templateId = 'd-5040b5ea8f864ff9886bed8d06e44888';
                            break;
                        case 5:
                            $subject = 'Cash Out Approved';
                            $templateId = 'd-5d2729f3674c4b0085c8b105ca258094';
                            break;
                        default:
                            // This shouldn't be reached due to the in_array check
                            continue;
                    }
    
                    // Only try to send email if we have a valid recipient
                    if (!empty($to_address)) {
                        try {
                            // Send the email using SendGrid
                            $sendgrid = new SendGridService();
                            $sendgrid->setFrom();
                            $sendgrid->setSubject($subject);
                            $sendgrid->setTemplateId($templateId);
                            $sendgrid->setDynamicData($dynamicData);
                            $sendgrid->setToEmail($to_address, $resp_name);
                            $sendgrid->send();
                            
                            // Log successful email sending for debugging
                            \Log::info("Email sent for cashout ID $id: Status $value, Template: $templateId");
                        } catch (\Exception $emailException) {
                            // Log the email error but continue processing other IDs
                            \Log::error("Failed to send email for cashout ID $id: " . $emailException->getMessage());
                        }
                    } else {
                        \Log::warning("Cannot send email for cashout ID $id: Email address missing");
                    }
                }
            }
    
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Status Changed'
            ]);
        } catch (\Exception $e) {
            \Log::error('Cashout action error: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }
    
}