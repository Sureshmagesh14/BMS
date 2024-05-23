<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use App\Models\Cashout;
use App\Models\Respondents;
use App\Models\Projects;
use App\Models\UserEvents;

class ExportController extends Controller
{

    public function export_index(Request $request){
    
        try {
            
            $active_val   = DB::table('respondents')->where("active_status_id",1)->count();
                       
            
            return view('admin.export',compact('active_val'));
            
            return redirect("/")->withSuccess('You are not allowed to access');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function export_all(Request $request){
    
        try {

            //dd($request);
            
            $module = $request->module;
            $resp_status = $request->resp_status;
            $resp_type = $request->resp_type;
            $from = date('Y-m-d',strtotime($request->start));
            $to = date('Y-m-d',strtotime($request->end));
        
            $type='xlsx';

            if($module=='Respondents info'){


                $all_datas = Respondents::where('id',1)->get();
                
                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff'
                        )
                    )
                );
                
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
               
                $sheet->getRowDimension('1')->setRowHeight(30);

                if($resp_type=='Basic and Essential Info'){

                    // starts 

                    $sheet->getColumnDimension('A')->setAutoSize(true);
                    $sheet->getColumnDimension('B')->setAutoSize(true);
                    $sheet->getColumnDimension('C')->setAutoSize(true);
                    $sheet->getColumnDimension('D')->setAutoSize(true);
                    $sheet->getColumnDimension('E')->setAutoSize(true);
                    $sheet->getColumnDimension('F')->setAutoSize(true);
                    $sheet->getColumnDimension('G')->setAutoSize(true);
                    $sheet->getColumnDimension('H')->setAutoSize(true);
                    $sheet->getColumnDimension('I')->setAutoSize(true);
                    $sheet->getColumnDimension('J')->setAutoSize(true);
                    $sheet->getColumnDimension('K')->setAutoSize(true);
                    $sheet->getColumnDimension('L')->setAutoSize(true);
                    $sheet->getColumnDimension('M')->setAutoSize(true);
                    $sheet->getColumnDimension('N')->setAutoSize(true);
                    $sheet->getColumnDimension('O')->setAutoSize(true);
                    $sheet->getColumnDimension('P')->setAutoSize(true);
                    $sheet->getColumnDimension('Q')->setAutoSize(true);
                    $sheet->getColumnDimension('R')->setAutoSize(true);
                    $sheet->getColumnDimension('S')->setAutoSize(true);
                    $sheet->getColumnDimension('T')->setAutoSize(true);
                    $sheet->getColumnDimension('U')->setAutoSize(true);
                    $sheet->getColumnDimension('V')->setAutoSize(true);
                    $sheet->getColumnDimension('W')->setAutoSize(true);
                    $sheet->getColumnDimension('X')->setAutoSize(true);
                        
                    $sheet->setCellValue('A1', 'PID');
        
                    $sheet->setCellValue('A1', 'PID');
        
                    $sheet->getStyle('A1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('A1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('B1', 'First Name');

                    $sheet->getStyle('B1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('B1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('C1', 'Last Name');

                    $sheet->getStyle('C1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('C1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('D1', 'Mobile Number');

                    $sheet->getStyle('D1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('D1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('E1', 'WA Number');

                    $sheet->getStyle('E1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('E1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('F1', 'Email');

                    $sheet->getStyle('F1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color
                        
                        $sheet->getStyle('F1')
                        ->applyFromArray($styleArray);
                    $rows = 2;
                    $i=1;
                    foreach($all_datas as $all_data){

                    
                        // $rows++;
                        // $i++;
                    }


                }else if($resp_type=='Extended Info'){

                    // starts 

                    $sheet->getColumnDimension('A')->setAutoSize(true);
                    $sheet->getColumnDimension('B')->setAutoSize(true);
                    $sheet->getColumnDimension('C')->setAutoSize(true);
                    $sheet->getColumnDimension('D')->setAutoSize(true);
                    $sheet->getColumnDimension('E')->setAutoSize(true);
                    $sheet->getColumnDimension('F')->setAutoSize(true);
                    $sheet->getColumnDimension('G')->setAutoSize(true);
                    $sheet->getColumnDimension('H')->setAutoSize(true);
                    $sheet->getColumnDimension('I')->setAutoSize(true);
                    $sheet->getColumnDimension('J')->setAutoSize(true);
                    $sheet->getColumnDimension('K')->setAutoSize(true);
                    $sheet->getColumnDimension('L')->setAutoSize(true);
                    $sheet->getColumnDimension('M')->setAutoSize(true);
                    $sheet->getColumnDimension('N')->setAutoSize(true);
                    $sheet->getColumnDimension('O')->setAutoSize(true);
                    $sheet->getColumnDimension('P')->setAutoSize(true);
                    $sheet->getColumnDimension('Q')->setAutoSize(true);
                    $sheet->getColumnDimension('R')->setAutoSize(true);
                    $sheet->getColumnDimension('S')->setAutoSize(true);
                    $sheet->getColumnDimension('T')->setAutoSize(true);
                    $sheet->getColumnDimension('U')->setAutoSize(true);
                    $sheet->getColumnDimension('V')->setAutoSize(true);
                    $sheet->getColumnDimension('W')->setAutoSize(true);
                    $sheet->getColumnDimension('X')->setAutoSize(true);
                        
                    $sheet->setCellValue('A1', 'PID');
        
                    $sheet->setCellValue('A1', 'PID');
        
                    $sheet->getStyle('A1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('A1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('B1', 'First Name');

                    $sheet->getStyle('B1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('B1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('C1', 'Last Name');

                    $sheet->getStyle('C1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('C1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('D1', 'Mobile Number');

                    $sheet->getStyle('D1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('D1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('E1', 'WA Number');

                    $sheet->getStyle('E1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('E1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('F1', 'Email');

                    $sheet->getStyle('F1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                        $sheet->getStyle('F1')
                        ->applyFromArray($styleArray);

                    $rows = 2;
                    $i=1;
                    foreach($all_datas as $all_data){

                    
                        // $rows++;
                        // $i++;
                    }
                    
                }
            
            $fileName = $module."_".$resp_type."_".date('ymd').".".$type;

            }else if($module=='Respondents'){


                $all_datas = Respondents::where('id',1)->get();
                
                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff'
                        )
                    )
                );
                
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
               
                $sheet->getRowDimension('1')->setRowHeight(30);

                if($resp_status=='Deactivated'){

                    // starts 

                    $sheet->getColumnDimension('A')->setAutoSize(true);
                    $sheet->getColumnDimension('B')->setAutoSize(true);
                    $sheet->getColumnDimension('C')->setAutoSize(true);
                    $sheet->getColumnDimension('D')->setAutoSize(true);
                    $sheet->getColumnDimension('E')->setAutoSize(true);
                    $sheet->getColumnDimension('F')->setAutoSize(true);
                    $sheet->getColumnDimension('G')->setAutoSize(true);
                    $sheet->getColumnDimension('H')->setAutoSize(true);
                        
                    $sheet->setCellValue('A1', 'PID');
        
                    $sheet->getStyle('A1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('A1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('B1', 'First Name');

                    $sheet->getStyle('B1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('B1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('C1', 'Last Name');

                    $sheet->getStyle('C1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('C1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('D1', 'Mobile Number');

                    $sheet->getStyle('D1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('D1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('E1', 'WA Number');

                    $sheet->getStyle('E1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('E1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('F1', 'Email');

                    $sheet->getStyle('F1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color
                    
                    $sheet->getStyle('F1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('G1', 'Date Deactivate');

                    $sheet->getStyle('G1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('G1')
                        ->applyFromArray($styleArray);

                        $sheet->setCellValue('H1', 'Deactivate By');

                    $sheet->getStyle('H1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('H1')
                        ->applyFromArray($styleArray);
                    
                    $rows = 2;
                    $i=1;
                    foreach($all_datas as $all_data){

                    $sheet->setCellValue('A' . $rows, $i);
                    $sheet->setCellValue('B' . $rows, $all_data->name);
                    $sheet->setCellValue('C' . $rows, $all_data->surname);
                    $sheet->setCellValue('D' . $rows, $all_data->mobile);
                    $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
                    $sheet->setCellValue('F' . $rows, $all_data->email);
                    $sheet->setCellValue('G' . $rows, $all_data->updated_at);
                    $sheet->setCellValue('H' . $rows, $all_data->created_by);
                    $rows++;
                    
                       
                        // $i++;
                    }

                    // ends 
                }else if($resp_status=='Blacklisted'){

                    // starts 

                    $sheet->getColumnDimension('A')->setAutoSize(true);
                    $sheet->getColumnDimension('B')->setAutoSize(true);
                    $sheet->getColumnDimension('C')->setAutoSize(true);
                    $sheet->getColumnDimension('D')->setAutoSize(true);
                    $sheet->getColumnDimension('E')->setAutoSize(true);
                    $sheet->getColumnDimension('F')->setAutoSize(true);
                    $sheet->getColumnDimension('G')->setAutoSize(true);
                    $sheet->getColumnDimension('H')->setAutoSize(true);
                    $sheet->getColumnDimension('I')->setAutoSize(true);
                        
                    $sheet->setCellValue('A1', 'PID');
        
                    $sheet->getStyle('A1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('A1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('B1', 'First Name');

                    $sheet->getStyle('B1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('B1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('C1', 'Last Name');

                    $sheet->getStyle('C1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('C1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('D1', 'Mobile Number');

                    $sheet->getStyle('D1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('D1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('E1', 'WA Number');

                    $sheet->getStyle('E1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('E1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('F1', 'Email');

                    $sheet->getStyle('F1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color
                    
                    $sheet->getStyle('F1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('G1', 'Date Blacklisted');

                    $sheet->getStyle('G1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('G1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('H1', 'Blacklisted By');

                    $sheet->getStyle('H1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('H1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('I1', 'Reason');

                    $sheet->getStyle('I1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('I1')
                        ->applyFromArray($styleArray);
                    
                    $rows = 2;
                    $i=1;
                    foreach($all_datas as $all_data){

                        $sheet->setCellValue('A' . $rows, $i);
                        $sheet->setCellValue('B' . $rows, $all_data->name);
                        $sheet->setCellValue('C' . $rows, $all_data->surname);
                        $sheet->setCellValue('D' . $rows, $all_data->mobile);
                        $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
                        $sheet->setCellValue('F' . $rows, $all_data->email);
                        $sheet->setCellValue('G' . $rows, $all_data->updated_at);
                        $sheet->setCellValue('H' . $rows, $all_data->created_by);
                        $sheet->setCellValue('H' . $rows, $all_data->created_by);
                        $rows++;
                        // $rows++;
                        // $i++;
                    }

                    
                    // ends 
                }

                
                $fileName = $module."_".$resp_status."_".date('ymd').".".$type;
            
            }else if($module=='Cashout'){
                $from = '2023-12-12';
                $to = '2024-02-02';

                $all_datas = Cashout::select('cashouts.*','respondents.name','respondents.email','respondents.mobile')
                    ->join('respondents', 'respondents.id', '=', 'cashouts.respondent_id') 
                    ->whereBetween('cashouts.created_at', [$from, $to])
                    ->orderby("id","desc")
                    ->get();
                
                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff'
                        )
                    )
                );
                
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
               
                                  
                $sheet->getRowDimension('1')->setRowHeight(30);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('G')->setAutoSize(true);
                $sheet->getColumnDimension('H')->setAutoSize(true);
                $sheet->getColumnDimension('I')->setAutoSize(true);
                $sheet->getColumnDimension('J')->setAutoSize(true);
                $sheet->getColumnDimension('K')->setAutoSize(true);
                $sheet->getColumnDimension('L')->setAutoSize(true);
                $sheet->getColumnDimension('M')->setAutoSize(true);
                $sheet->getColumnDimension('N')->setAutoSize(true);
                $sheet->getColumnDimension('O')->setAutoSize(true);
                $sheet->getColumnDimension('P')->setAutoSize(true);

                $sheet->setCellValue('A1', 'PID');
    
                $sheet->getStyle('A1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('A1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('B1', 'First Name');

                $sheet->getStyle('B1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('B1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('C1', 'Last Name');

                $sheet->getStyle('C1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('C1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('D1', 'Mobile Number');

                $sheet->getStyle('D1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('D1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('E1', 'WA Number');

                $sheet->getStyle('E1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('E1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('F1', 'Email');

                $sheet->getStyle('F1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('F1')
                    ->applyFromArray($styleArray);

                    $sheet->setCellValue('g1', 'Cashout Type');

                    $sheet->getStyle('g1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color
    
                    $sheet->getStyle('g1')
                        ->applyFromArray($styleArray);

                        $sheet->setCellValue('h1', 'Total cash paid');

                        $sheet->getStyle('h1')
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('0f609b'); // cell color
        
                        $sheet->getStyle('h1')
                            ->applyFromArray($styleArray);


                            $sheet->setCellValue('i1', 'Value of incentives paid');

                            $sheet->getStyle('i1')
                                ->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()
                                ->setARGB('0f609b'); // cell color
            
                            $sheet->getStyle('i1')
                                ->applyFromArray($styleArray);


                                $sheet->setCellValue('j1', 'Total cashouts unpaid');

                                $sheet->getStyle('j1')
                                    ->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()
                                    ->setARGB('0f609b'); // cell color
                
                                $sheet->getStyle('j1')
                                    ->applyFromArray($styleArray);


                                    $sheet->setCellValue('k1', 'Pending cashout');

                                    $sheet->getStyle('k1')
                                        ->getFill()
                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                        ->getStartColor()
                                        ->setARGB('0f609b'); // cell color
                    
                                    $sheet->getStyle('k1')
                                        ->applyFromArray($styleArray);


                                        $sheet->setCellValue('l1', 'Declined cashout');

                                        $sheet->getStyle('l1')
                                            ->getFill()
                                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                            ->getStartColor()
                                            ->setARGB('0f609b'); // cell color
                        
                                        $sheet->getStyle('l1')
                                            ->applyFromArray($styleArray);


                                            $sheet->setCellValue('m1', 'Complete cashout');

                                            $sheet->getStyle('m1')
                                                ->getFill()
                                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                                ->getStartColor()
                                                ->setARGB('0f609b'); // cell color
                            
                                            $sheet->getStyle('m1')
                                                ->applyFromArray($styleArray);

                                                $sheet->setCellValue('n1', 'Value if incentives owed');

                                                $sheet->getStyle('n1')
                                                    ->getFill()
                                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                                    ->getStartColor()
                                                    ->setARGB('0f609b'); // cell color
                                
                                                $sheet->getStyle('n1')
                                                    ->applyFromArray($styleArray);


                                                    $sheet->setCellValue('o1', 'Projects participated');

                                                    $sheet->getStyle('o1')
                                                        ->getFill()
                                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                                        ->getStartColor()
                                                        ->setARGB('0f609b'); // cell color
                                    
                                                    $sheet->getStyle('o1')
                                                        ->applyFromArray($styleArray);


                                                        $sheet->setCellValue('p1', 'Cashout date');

                                                        $sheet->getStyle('p1')
                                                            ->getFill()
                                                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                                            ->getStartColor()
                                                            ->setARGB('0f609b'); // cell color
                                        
                                                        $sheet->getStyle('p1')
                                                            ->applyFromArray($styleArray);
                
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

                $fileName = $module."_".date('ymd').".".$type;
                
            }else if($module=='Rewards'){
                $from = '2023-12-12';
                $to = '2024-02-02';

                $all_datas = DB::table('rewards')
                ->select('rewards.*')
                ->whereBetween('rewards.created_at', [$from, $to])
                ->orderby("id","desc")
                ->get();

                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff'
                        )
                    )
                );
                
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
               
                                  
                $sheet->getRowDimension('1')->setRowHeight(30);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);
                $sheet->getColumnDimension('F')->setAutoSize(true);
                $sheet->getColumnDimension('G')->setAutoSize(true);

                $sheet->setCellValue('A1', 'PID');
    
                $sheet->getStyle('A1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('A1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('B1', 'First Name');

                $sheet->getStyle('B1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('B1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('C1', 'Last Name');

                $sheet->getStyle('C1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('C1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('D1', 'Mobile Number');

                $sheet->getStyle('D1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('D1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('E1', 'WA Number');

                $sheet->getStyle('E1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('E1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('F1', 'Email');

                $sheet->getStyle('F1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('F1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('G1', 'Reward Status');

                $sheet->getStyle('G1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('G1')
                    ->applyFromArray($styleArray);
                
                $rows = 2;
                $i=1;
                foreach($all_datas as $all_data){

                    // $rows++;
                    // $i++;
                }

                $fileName = $module."_".date('ymd').".".$type;
                
            }else if($module=='Projects'){
                $from = '2023-12-12';
                $to = '2024-02-02';

                $all_datas = Projects::select('projects.*','projects.name as uname')
                ->join('users', 'users.id', '=', 'projects.user_id') 
                ->orderby("id","desc")
                ->whereBetween('projects.created_at', [$from, $to])
                ->get();
   

                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff'
                        )
                    )
                );
                
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
               
                                  
                $sheet->getRowDimension('1')->setRowHeight(30);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);

                $sheet->setCellValue('A1', 'Project Number');
    
                $sheet->getStyle('A1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('A1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('B1', 'Project Name');

                $sheet->getStyle('B1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('B1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('C1', 'PM Name');

                $sheet->getStyle('C1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('C1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('D1', 'Dates of Project');

                $sheet->getStyle('D1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('D1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('E1', 'Total respondents recruited');

                $sheet->getStyle('E1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('E1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('F1', 'Total respondents actually attended');

                $sheet->getStyle('F1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('F1')
                    ->applyFromArray($styleArray);
                
                $rows = 2;
                $i=1;
                foreach($all_datas as $all_data){

                    $sheet->setCellValue('A' . $rows, $i);
                    $sheet->setCellValue('B' . $rows, $all_data->name);
                    $sheet->setCellValue('C' . $rows, $all_data->surname);
                    $sheet->setCellValue('D' . $rows, $all_data->mobile);
                    $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
                    $sheet->setCellValue('F' . $rows, $all_data->email);
                    $sheet->setCellValue('G' . $rows, $all_data->updated_at);
                    $sheet->setCellValue('H' . $rows, $all_data->created_by);
                    $sheet->setCellValue('H' . $rows, $all_data->created_by);

                    // $rows++;
                    // $i++;
                }

                $fileName = $module."_".date('ymd').".".$type;
                
            }else if($module=='Team Activity'){
                $from = '2023-12-12';
                $to = '2024-02-02';

                $all_datas = UserEvents::select('user_events.*')->orderby("id","desc")
                ->whereBetween('created_at', [$from, $to])
                ->get();
   

                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff'
                        )
                    )
                );
                
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
               
                                  
                $sheet->getRowDimension('1')->setRowHeight(30);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);

                $sheet->setCellValue('A1', 'Name of team member');
    
                $sheet->getStyle('A1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('A1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('B1', 'Total recruited respondents');

                $sheet->getStyle('B1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('B1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('C1', 'Total deactivated respondents');

                $sheet->getStyle('C1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('C1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('D1', 'Total blacklisted respondents');

                $sheet->getStyle('D1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('D1')
                    ->applyFromArray($styleArray);

                $sheet->setCellValue('E1', 'Total respondents recruited');

                $sheet->getStyle('E1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0f609b'); // cell color

                $sheet->getStyle('E1')
                    ->applyFromArray($styleArray);

                
                
                $rows = 2;
                $i=1;
                foreach($all_datas as $all_data){

                    // $rows++;
                    // $i++;
                }

                $fileName = $module."_".date('ymd').".".$type;
                
            }
            
            if($type == 'xlsx') {
                $writer = new Xlsx($spreadsheet);
            } else if($type == 'xls') {
                $writer = new Xls($spreadsheet);
            }
                $writer->save("../public/".$fileName);
                
            header("Content-Type: application/vnd.ms-excel");
            return redirect(url('/')."/".$fileName);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
