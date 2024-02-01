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

    public function cash_export($type) {

        $type='xlsx';
        $all_datas = DB::table('cashouts')
                ->select('cashouts.*','respondents.name','respondents.email','respondents.mobile')
                ->join('respondents', 'respondents.id', '=', 'cashouts.respondent_id') 
                ->orderby("id","desc")
                ->limit(10)
                ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Type');
        $sheet->setCellValue('C1', 'Status');
        $sheet->setCellValue('D1', 'Amount');
        $sheet->setCellValue('E1', 'Respondent');
        
        $rows = 2;
        $i=1;
        foreach($all_datas as $all_data){

            if($all_data->type_id==1){
                $type_val ='EFT';
            }else if($all_data->type_id==2){
                $type_val ='Data';
            }else if($all_data->type_id==3){
                $type_val ='Airtime';
            }else{  
                $type_val ='-';
            }
            
            if($all_data->status_id==0){
                $status_val ='Failed';
            }else if($all_data->status_id==1){
                $status_val ='';
            }else if($all_data->status_id==2){
                $status_val ='';
            }else if($all_data->status_id==3){
                $status_val ='Complete';
            }else if($all_data->status_id==4){
                $status_val ='Declined';
            }else{  
                $status_val ='-';
            }

            $amount = $all_data->amount/10;
            $respondent = $all_data->name.' - '.$all_data->email.' - '.$all_data->mobile;
            
            $sheet->setCellValue('A' . $rows, $i);
            $sheet->setCellValue('B' . $rows, $type_val);
            $sheet->setCellValue('C' . $rows, $status_val);
            $sheet->setCellValue('D' . $rows, $amount);
            $sheet->setCellValue('E' . $rows, $respondent);
            $rows++;
            $i++;
        }

        $fileName = "cash.".$type;
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