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
use App\Models\Actions;
use App\Models\Cashouts;
use DB;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class CashoutsController extends Controller
{   
    public function cashouts()
    {   
        try {
            return view('admin.cashouts.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
       
    }
    public function get_all_cashouts(Request $request) {
		
        try {
            if ($request->ajax()) {

                $token = csrf_token();
            
                
                $all_datas = DB::table('cashouts')
                ->select('cashouts.*','respondents.name','respondents.email','respondents.mobile')
                ->join('respondents', 'respondents.id', '=', 'cashouts.respondent_id') 
                ->orderby("id","desc")
                ->get();
        
                
                return Datatables::of($all_datas)
                 ->addColumn('id', function ($all_data){
                    return '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="contacusercheck3"><label class="custom-control-label" for="contacusercheck3"></label></div>';
                 })
                ->addColumn('type_id', function ($all_data) {
                    if($all_data->type_id==1){
                        return 'EFT';
                    }else if($all_data->type_id==2){
                        return 'Data';
                    }else if($all_data->type_id==3){
                        return 'Airtime';
                    }else{  
                        return '-';
                    }
                })  
                ->addColumn('status_id', function ($all_data) {
                    
                    if($all_data->status_id==0){
                        return 'Failed';
                    }else if($all_data->status_id==1){
                        return '';
                    }else if($all_data->status_id==2){
                        return '';
                    }else if($all_data->status_id==3){
                        return 'Complete';
                    }else if($all_data->status_id==4){
                        return 'Declined';
                    }else{  
                        return '-';
                    }
                    
                })  
                ->addColumn('amount', function ($all_data) {
                    
                    $amount=$all_data->amount/10;
                    return $amount;
                    
                    
                })  
                ->addColumn('respondent_id', function ($all_data) {
                    
                    return $all_data->name.' - '.$all_data->email.' - '.$all_data->mobile;
                    
                    
                })  
                ->addColumn('action', function ($all_data) use($token) {
        
                    return '<div class="">
                    <div class="btn-group mr-2 mb-2 mb-sm-0">
                        <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></button>
                    </div>              
                </div>';
                    
                })
                ->rawColumns(['id','action','type_id','status_id','amount','respondent_id'])      
                ->make(true);
            }
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

        $type='xlsx';
        
        if($module_name=='cash_summary_export'){

        $all_datas = DB::table('cashouts')
                ->select('cashouts.*','respondents.name','respondents.email','respondents.mobile')
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


            $all_datas = DB::table('cashouts')
                ->select('cashouts.*','respondents.name','respondents.email','respondents.mobile')
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
}