<?php

namespace App\Http\Controllers;

use App\Models\Cashout;
use App\Models\Projects;
use App\Models\Respondents;
use App\Models\UserEvents;
use DB;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{

    public function export_index(Request $request)
    {

        try {

            $active_val = DB::table('respondents')->where("active_status_id", 1)->count();
            $users_list = DB::table('users')->where("status_id", 1)->orderBy('id', 'ASC')->get();
            $res_users_list = DB::table('respondents')->where("active_status_id", 1)->orderBy('id', 'ASC')->get();
            return view('admin.export', compact('active_val', 'users_list'));

            return redirect("/")->withSuccess('You are not allowed to access');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function export_all(Request $request)
    {

        try {

            //dd($request);

            $module = $request->module;
            $resp_status = $request->resp_status;
            $resp_type = $request->resp_type;
            $from = ($request->start != null) ? date('Y-m-d', strtotime($request->start)) : null;
            $to = ($request->end != null) ? date('Y-m-d', strtotime($request->end)) : null;
            $type_method = $request->type_method;

            $type = 'xlsx';
            $styleArray = array( // font color
                'font' => array(
                    'size' => 13,
                    'name' => 'Arial',
                    'bold' => true,
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array(
                        'rgb' => 'ffffff',
                    ),
                ),
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    // 'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            );

            $styleArray2 = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
                'font' => [
                    'size' => 11,
                    'name' => 'Arial',
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    // 'wrapText' => true,
                ],
            ];

            // Datas
            $styleArray3 = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
                'font' => [
                    'size' => 11,
                    'name' => 'Arial',
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ];

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
            $sheet->getColumnDimension('Q')->setAutoSize(true);
            $sheet->getColumnDimension('R')->setAutoSize(true);
            $sheet->getColumnDimension('S')->setAutoSize(true);
            $sheet->getColumnDimension('T')->setAutoSize(true);
            $sheet->getColumnDimension('U')->setAutoSize(true);
            $sheet->getColumnDimension('V')->setAutoSize(true);
            $sheet->getColumnDimension('W')->setAutoSize(true);
            $sheet->getColumnDimension('X')->setAutoSize(true);

            $respondents = ($request->respondents != null) ? implode(',', array_filter($request->respondents)) : null;
           
            if ($module == 'Respondents info') {
        
                if ($resp_type == 'Basic and Essential Info') {
                    $sheet->setCellValue('A1', 'PID');
                    $sheet->setCellValue('B1', 'First Name');
                    $sheet->setCellValue('C1', 'Last Name');
                    $sheet->setCellValue('D1', 'Mobile Number');
                    $sheet->setCellValue('E1', 'WA Number');
                    $sheet->setCellValue('F1', 'Email');
                    $sheet->setCellValue('G1', 'Age');
                    $sheet->setCellValue('H1', 'Relationship status');
                    $sheet->setCellValue('I1', 'Ethnic Group / Race');
                    $sheet->setCellValue('J1', 'Gender');
                    $sheet->setCellValue('K1', 'Highest Education Level');
                    $sheet->setCellValue('L1', 'Employment Status');
                    $sheet->setCellValue('M1', 'Industry my company is in');
                    $sheet->setCellValue('N1', 'Job Title');
                    $sheet->setCellValue('O1', 'Personal Income per month');
                    $sheet->setCellValue('P1', 'HHI per month');
                    $sheet->setCellValue('Q1', 'Province');
                    $sheet->setCellValue('R1', 'Area');
                    $sheet->setCellValue('S1', 'No. of people living in your household');
                    $sheet->setCellValue('T1', 'Number of children');
                    $sheet->setCellValue('U1', 'Number of vehicles');
                    $sheet->setCellValue('V1', 'Opted in');
                    $sheet->setCellValue('W1', 'Last Updated');

                    $sheet->getStyle('A1:W1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:W1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i = 1;

                    if($type_method == 'Individual'){
                        $all_datas = Respondents::leftJoin('respondent_profile', function ($join) {
                                $join->on('respondent_profile.respondent_id', '=', 'respondents.id');
                            })
                            ->whereIn('respondents.id', [$respondents])
                            ->get([
                                'respondents.opted_in',
                                'respondent_profile.basic_details',
                                'respondent_profile.essential_details',
                                'respondent_profile.extended_details',
                                'respondent_profile.updated_at',
                            ]);
                    }
                    else{
                        $all_datas = Respondents::leftJoin('respondent_profile', function ($join) {
                                $join->on('respondent_profile.respondent_id', '=', 'respondents.id');
                            })
                            ->where('active_status_id',1)
                            ->get([
                                'respondents.opted_in',
                                'respondent_profile.basic_details',
                                'respondent_profile.essential_details',
                                'respondent_profile.extended_details',
                                'respondent_profile.updated_at',
                            ]);
                    }

                    foreach ($all_datas as $all_data) {
                  
                        $basic = json_decode($all_data->basic_details);
                        $essential = json_decode($all_data->essential_details);

                        $sheet->setCellValue('A' . $rows, $i);
                        $sheet->setCellValue('B' . $rows, $basic->first_name ?? '');
                        $sheet->setCellValue('C' . $rows, $basic->last_name ?? '');
                        $sheet->setCellValue('D' . $rows, $basic->mobile_number ?? '');
                        $sheet->setCellValue('E' . $rows, $basic->whatsapp_number ?? '');
                        $sheet->setCellValue('F' . $rows, $basic->email ?? '');
                        if(isset($basic->date_of_birth)){
                            $year = (date('Y') - date('Y', strtotime($basic->date_of_birth ?? '')));
                        }else{
                            $year = '-';
                        }
                       
                        $sheet->setCellValue('G' . $rows, $year);
                        $sheet->setCellValue('H' . $rows, $essential->relationship_statu ?? '');
                        $sheet->setCellValue('I' . $rows, $essential->ethnic_group ?? '');
                        $sheet->setCellValue('J' . $rows, $essential->gender ?? '');
                        $sheet->setCellValue('K' . $rows, $essential->education_level ?? '');
                        $sheet->setCellValue('L' . $rows, $essential->employment_status ?? '');
                        $sheet->setCellValue('M' . $rows, $essential->industry_my_company ?? '');
                        $sheet->setCellValue('N' . $rows, $essential->job_title ?? '');
                        $sheet->setCellValue('O' . $rows, $essential->personal_income_per_month ?? '');
                        $sheet->setCellValue('P' . $rows, $essential->job_title ?? '');
                        if(isset($basic->state)){
                            $state = DB::table('state')->where('id', $essential->province)->first();
                            $get_state=$get_state->state;
                        }else{
                            $get_state='';
                        }
                      
                        $sheet->setCellValue('Q' . $rows, $get_state ?? '');
                        if(isset($basic->suburb)){
                            $district = DB::table('district')->where('id', $essential->suburb)->first();
                            $get_district=$district->district;
                        }else{

                        }
                        $sheet->setCellValue('R' . $rows, $get_district ?? '');
                        $sheet->setCellValue('S' . $rows, $essential->no_houehold ?? '');
                        $sheet->setCellValue('T' . $rows, $essential->no_children ?? '');
                        $sheet->setCellValue('U' . $rows, $essential->no_vehicle ?? '');
                        if ($all_data->opted_in != null) {
                            $opted_in = date("d-m-Y", strtotime($all_data->opted_in));
                        } else {
                            $opted_in = '';
                        }
                        $sheet->setCellValue('V' . $rows, $opted_in);
                        if ($all_data->updated_at != null) {
                            $updated_at = date("d-m-Y", strtotime($all_data->updated_at));
                        } else {
                            $updated_at = '';
                        }
                        $sheet->setCellValue('W' . $rows, $updated_at);
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':W' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':W' . $rows)->getAlignment()->setIndent(1);
                    }

                }
                else if ($resp_type == 'Extended Info') {
                    $sheet->setCellValue('A1', 'PID');
                    $sheet->setCellValue('B1', 'First Name');
                    $sheet->setCellValue('C1', 'Last Name');
                    $sheet->setCellValue('D1', 'Mobile Number');
                    $sheet->setCellValue('E1', 'WA Number');
                    $sheet->setCellValue('F1', 'Email');
                    $sheet->setCellValue('G1', 'Age');
                    $sheet->setCellValue('H1', 'Relationship status');
                    $sheet->setCellValue('I1', 'Ethnic Group / Race');
                    $sheet->setCellValue('J1', 'Gender');
                    $sheet->setCellValue('K1', 'Highest Education Level');
                    $sheet->setCellValue('L1', 'Employment Status');
                    $sheet->setCellValue('M1', 'Industry my company is in');
                    $sheet->setCellValue('N1', 'Job Title');
                    $sheet->setCellValue('O1', 'Personal Income per month');
                    $sheet->setCellValue('P1', 'HHI per month');
                    $sheet->setCellValue('Q1', 'Province');
                    $sheet->setCellValue('R1', 'Area');
                    $sheet->setCellValue('S1', 'No. of people living in your household');
                    $sheet->setCellValue('T1', 'Number of children');
                    $sheet->setCellValue('U1', 'Number of vehicles');
                    $sheet->setCellValue('V1', 'Opted in');
                    $sheet->setCellValue('W1', 'Last Updated');

                    $sheet->getStyle('A1:W1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:W1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i = 1;

                    if($type_method == 'Individual'){

                        $all_datas = Respondents::leftJoin('respondent_profile', function ($join) {
                                $join->on('respondent_profile.respondent_id', '=', 'respondents.id');
                            })
                            ->whereIn('respondents.id', [$respondents])
                            ->get([
                                'respondents.opted_in',
                                'respondent_profile.basic_details',
                                'respondent_profile.essential_details',
                                'respondent_profile.extended_details',
                                'respondent_profile.updated_at',
                            ]);
                    }
                    else{
                        $all_datas = Respondents::leftJoin('respondent_profile', function ($join) {
                                $join->on('respondent_profile.respondent_id', '=', 'respondents.id');
                            })
                            ->where('active_status_id',1)
                            ->get([
                                'respondents.opted_in',
                                'respondent_profile.basic_details',
                                'respondent_profile.essential_details',
                                'respondent_profile.extended_details',
                                'respondent_profile.updated_at',
                            ]);
                    }
                  
                    foreach ($all_datas as $all_data) {
                        $basic = json_decode($all_data->basic_details);
                        $essential = json_decode($all_data->extended_details);

                        $sheet->setCellValue('A' . $rows, $i);
                        $sheet->setCellValue('B' . $rows, $basic->first_name ?? '');
                        $sheet->setCellValue('C' . $rows, $basic->last_name ?? '');
                        $sheet->setCellValue('D' . $rows, $basic->mobile_number ?? '');
                        $sheet->setCellValue('E' . $rows, $basic->whatsapp_number ?? '');
                        $sheet->setCellValue('F' . $rows, $basic->email ?? '');
                        if(isset($basic->date_of_birth)){
                            $year = (date('Y') - date('Y', strtotime($basic->date_of_birth ?? '')));
                        }else{
                            $year = '-';
                        }
                       
                        $sheet->setCellValue('G' . $rows, $year);
                        $sheet->setCellValue('H' . $rows, $essential->relationship_statu ?? '');
                        $sheet->setCellValue('I' . $rows, $essential->ethnic_group ?? '');
                        $sheet->setCellValue('J' . $rows, $essential->gender ?? '');
                        $sheet->setCellValue('K' . $rows, $essential->education_level ?? '');
                        $sheet->setCellValue('L' . $rows, $essential->employment_status ?? '');
                        $sheet->setCellValue('M' . $rows, $essential->industry_my_company ?? '');
                        $sheet->setCellValue('N' . $rows, $essential->job_title ?? '');
                        $sheet->setCellValue('O' . $rows, $essential->personal_income_per_month ?? '');
                        $sheet->setCellValue('P' . $rows, $essential->job_title ?? '');
                        if(isset($basic->state)){
                            $state = DB::table('state')->where('id', $essential->province)->first();
                            $get_state=$get_state->state;
                        }else{
                            $get_state='';
                        }
                      
                        $sheet->setCellValue('Q' . $rows, $get_state ?? '');
                        if(isset($basic->suburb)){
                            $district = DB::table('district')->where('id', $essential->suburb)->first();
                            $get_district=$district->district;
                        }else{

                        }
                        $sheet->setCellValue('R' . $rows, $get_district ?? '');
                        $sheet->setCellValue('S' . $rows, $essential->no_houehold ?? '');
                        $sheet->setCellValue('T' . $rows, $essential->no_children ?? '');
                        $sheet->setCellValue('U' . $rows, $essential->no_vehicle ?? '');
                        if ($all_data->opted_in != null) {
                            $opted_in = date("d-m-Y", strtotime($all_data->opted_in));
                        } else {
                            $opted_in = '';
                        }
                        $sheet->setCellValue('V' . $rows, $opted_in);
                        if ($all_data->updated_at != null) {
                            $updated_at = date("d-m-Y", strtotime($all_data->updated_at));
                        } else {
                            $updated_at = '';
                        }
                        $sheet->setCellValue('W' . $rows, $updated_at);
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':W' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':W' . $rows)->getAlignment()->setIndent(1);
                    }
                        $rows++;
                        $i++;
                    

                }

                $fileName = $module . "_" . $resp_type . "_" . date('ymd') . "." . $type;
            }
            else if ($module == 'Respondents') {

                if ($resp_status == 'Deactivated') {
                    $sheet->setCellValue('A1', 'PID');
                    $sheet->setCellValue('B1', 'First Name');
                    $sheet->setCellValue('C1', 'Last Name');
                    $sheet->setCellValue('D1', 'Mobile Number');
                    $sheet->setCellValue('E1', 'WA Number');
                    $sheet->setCellValue('F1', 'Email');
                    $sheet->setCellValue('G1', 'Date Deactivate');
                    $sheet->setCellValue('H1', 'Deactivate By');

                    $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:H1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i    = 1;

                    $all_datas = Respondents::where('respondents.active_status_id','=',3);
                    
                    if($respondents != ""){
                        $all_datas = $all_datas->whereIn('respondents.id', [$respondents]);
                    }

                    if($from != null && $to != null){
                        $all_datas = $all_datas->whereDate('respondents.created_at', '>=', $from)->whereDate('respondents.created_at', '<=', $to);
                    }
                        
                    $all_datas = $all_datas->get();

                    foreach ($all_datas as $all_data) {
                        $sheet->setCellValue('A' . $rows, $i);
                        $sheet->setCellValue('B' . $rows, $all_data->name);
                        $sheet->setCellValue('C' . $rows, $all_data->surname);
                        $sheet->setCellValue('D' . $rows, $all_data->mobile);
                        $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
                        $sheet->setCellValue('F' . $rows, $all_data->email);
                        $sheet->setCellValue('G' . $rows, $all_data->updated_at);
                        $sheet->setCellValue('H' . $rows, $all_data->created_by);
                        $rows++;
                        $i++;
                    }
                }
                else if ($resp_status == 'Blacklisted') {
                    $sheet->setCellValue('A1', 'PID');
                    $sheet->setCellValue('B1', 'First Name');
                    $sheet->setCellValue('C1', 'Last Name');
                    $sheet->setCellValue('D1', 'Mobile Number');
                    $sheet->setCellValue('E1', 'WA Number');
                    $sheet->setCellValue('F1', 'Email');
                    $sheet->setCellValue('G1', 'Date Blacklisted');
                    $sheet->setCellValue('H1', 'Blacklisted By');
                    // $sheet->setCellValue('I1', 'Reason');

                    $sheet->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:I1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i = 1;

                    $all_datas = Respondents::where('respondents.active_status_id','=',5);
                        if($respondents != ""){
                            $all_datas = $all_datas->whereIn('respondents.id', [$respondents]);
                        }
                        if($from != null && $to != null){
                            $all_datas = $all_datas->whereDate('respondents.created_at', '>=', $from)->whereDate('respondents.created_at', '<=', $to);
                        }
                    $all_datas = $all_datas->get();

                    foreach ($all_datas as $all_data) {
                        $sheet->setCellValue('A' . $rows, $i);
                        $sheet->setCellValue('B' . $rows, $all_data->name);
                        $sheet->setCellValue('C' . $rows, $all_data->surname);
                        $sheet->setCellValue('D' . $rows, $all_data->mobile);
                        $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
                        $sheet->setCellValue('F' . $rows, $all_data->email);
                        $sheet->setCellValue('G' . $rows, $all_data->updated_at);
                        $sheet->setCellValue('H' . $rows, $all_data->created_by);
                        // $sheet->setCellValue('I' . $rows, $all_data->created_by);
                        $rows++;
                        $i++;
                    }
                }

                $fileName = $module . "_" . $resp_status . "_" . date('ymd') . "." . $type;

            }
            else if ($module == 'Cashout') {
                
                $all_datas = Cashout::select('cashouts.*', 'respondents.name', 'respondents.email', 'respondents.mobile')
                    ->join('respondents', 'respondents.id', '=', 'cashouts.respondent_id');
                        if($from != null && $to != null){
                            $all_datas = $all_datas->where('cashouts.created_at', '>=', $from)->where('cashouts.created_at', '<=', $to);
                        }
                    $all_datas = $all_datas->orderby("id", "desc")->get();
               
                $sheet->setCellValue('A1', 'PID');
                $sheet->setCellValue('B1', 'First Name');
                $sheet->setCellValue('C1', 'Last Name');
                $sheet->setCellValue('D1', 'Mobile Number');
                $sheet->setCellValue('E1', 'WA Number');
                $sheet->setCellValue('F1', 'Email');
                $sheet->setCellValue('G1', 'Cashout Type');
                $sheet->setCellValue('H1', 'Total cash paid');
                $sheet->setCellValue('I1', 'Value of incentives paid');
                $sheet->setCellValue('J1', 'Total cashouts unpaid');
                $sheet->setCellValue('K1', 'Pending cashout');
                $sheet->setCellValue('L1', 'Declined cashout');
                $sheet->setCellValue('M1', 'Complete cashout');
                $sheet->setCellValue('N1', 'Value if incentives owed');
                $sheet->setCellValue('O1', 'Projects participated');
                $sheet->setCellValue('P1', 'Cashout date');

                $sheet->getStyle('A1:P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                $sheet->getStyle('A1:P1')->applyFromArray($styleArray);

                $rows = 2;
                $i = 1;
                foreach ($all_datas as $all_data) {

                    if ($all_data->type_id == 1) {
                        $type_val = 'EFT';
                    }
                    else if ($all_data->type_id == 2) {
                        $type_val = 'Data';
                    }
                    else if ($all_data->type_id == 3) {
                        $type_val = 'Airtime';
                    }
                    else {
                        $type_val = '-';
                    }

                    $amount = $all_data->amount / 10;
                    $respondent = $all_data->name . ' - ' . $all_data->email . ' - ' . $all_data->mobile;

                    $sheet->setCellValue('A' . $rows, $i);
                    $sheet->setCellValue('B' . $rows, $all_data->name);
                    $sheet->setCellValue('C' . $rows, $all_data->surname);
                    $sheet->setCellValue('D' . $rows, $all_data->mobile);
                    $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
                    $sheet->setCellValue('F' . $rows, $all_data->email);
                    $sheet->setCellValue('G' . $rows, $type_val);
                    $rows++;
                    $i++;
                }

                $fileName = $module . "_" . date('ymd') . "." . $type;
            }
            else if ($module == 'Rewards') {
                $respondents = $request->respondents;

                if($type_method == 'Individual'){

                    $all_datas = Respondents::leftJoin('rewards', function ($join) {
                        $join->on('rewards.respondent_id', '=', 'respondents.id');
                    });
                        if($respondents != ""){
                            $all_datas = $all_datas->whereIn('respondents.id', [$respondents]);
                        }
                    $all_datas = $all_datas->get([
                        'respondents.id',
                        'respondents.name',
                        'respondents.surname',
                        'respondents.mobile',
                        'respondents.whatsapp',
                        'respondents.email',
                        'rewards.status_id',
                    ]);
                }
                else{
                    $all_datas = Respondents::leftJoin('rewards', function ($join) {
                        $join->on('rewards.respondent_id', '=', 'respondents.id');
                    })
                    ->get([
                        'respondents.id',
                        'respondents.name',
                        'respondents.surname',
                        'respondents.mobile',
                        'respondents.whatsapp',
                        'respondents.email',
                        'rewards.status_id',
                    ]);
                }

                $sheet->setCellValue('A1', 'PID');
                $sheet->setCellValue('B1', 'First Name');
                $sheet->setCellValue('C1', 'Last Name');
                $sheet->setCellValue('D1', 'Mobile Number');
                $sheet->setCellValue('E1', 'WA Number');
                $sheet->setCellValue('F1', 'Email');
                $sheet->setCellValue('G1', 'Reward Status');

                $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                $sheet->getStyle('A1:G1')->applyFromArray($styleArray);

                $rows = 2;
                $i = 1;
                foreach ($all_datas as $all_data) {

                    $sheet->setCellValue('A' . $rows, $i);
                    $sheet->setCellValue('B' . $rows, $all_data->name);
                    $sheet->setCellValue('C' . $rows, $all_data->surname);
                    $sheet->setCellValue('D' . $rows, $all_data->mobile);
                    $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
                    $sheet->setCellValue('F' . $rows, $all_data->email);

                    if($all_data->status_id==1){
                        $status = 'Pending';
                    }
                    else if($all_data->status_id==2){
                        $status= 'Approved';
                    }
                    else if($all_data->status_id==4){
                        $status= 'Processed';
                    }
                    else{  
                        $status= '-';
                    }

                    $sheet->setCellValue('G' . $rows, $status);

                    $rows++;
                    $i++;
                }

                $fileName = $module . "_" . date('ymd') . "." . $type;

            }
            else if ($module == 'Projects') {
                $all_datas = Projects::leftJoin('users', function ($join) {
                        $join->on('users.id', '=', 'projects.user_id');
                    });

                    if($from != null && $to != null){
                        $all_datas = $all_datas->whereDate('projects.created_at', '>=', $from)->whereDate('projects.created_at', '<=', $to);
                    }

                $all_datas = $all_datas->get([
                    'users.name as uname',
                    'users.surname',
                    'projects.number',
                    'projects.name',
                    'projects.published_date',
                    'projects.closing_date',
                    'projects.total_responnded_attended',
                    'projects.total_responded_recruited',
                ]);

                $sheet->setCellValue('A1', 'Project Number & Project Name');
                $sheet->setCellValue('B1', 'PM Name');
                $sheet->setCellValue('C1', 'Dates of project( Live Date and Closing Date)');
                $sheet->setCellValue('D1', 'Total respondents recruited');
                $sheet->setCellValue('E1', 'Total respondents actually attended');

                $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                $sheet->getStyle('A1:E1')->applyFromArray($styleArray);

                $rows = 2;
                $i = 1;
                foreach ($all_datas as $all_data) {
                    $sheet->setCellValue('A' . $rows, $all_data->number.' '.$all_data->name);
                    $sheet->setCellValue('B' . $rows, $all_data->uname.$all_data->surname);
                    if(isset($all_data->published_date)){
                        $published_date=date("d-m-Y", strtotime($all_data->published_date));
                    }else{
                        $published_date='-';
                    }

                    if(isset($all_data->closing_date)){
                        $closing_date=date("d-m-Y", strtotime($all_data->closing_date));
                    }else{
                        $closing_date='-';
                    }

                    $sheet->setCellValue('C' . $rows, $published_date. '-' .$closing_date);
                  
                    $sheet->setCellValue('D' . $rows, $all_data->total_responnded_attended);
                    $sheet->setCellValue('E' . $rows, $all_data->total_responded_recruited);
                    $sheet->getRowDimension($rows)->setRowHeight(20);
                    $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                    $sheet->getStyle('C' . $rows . ':E' . $rows)->applyFromArray($styleArray2);
                    $sheet->getStyle('C' . $rows . ':E' . $rows)->getAlignment()->setIndent(1);

                    $rows++;
                    $i++;
                }

                $fileName = $module . "_" . date('ymd') . "." . $type;

            }
            else if ($module == 'Internal Reports') {
                $sheet->setCellValue('A1', 'ID');
                $sheet->setCellValue('B1', 'User');
                $sheet->setCellValue('C1', 'Action');
                $sheet->setCellValue('D1', 'Type');
                $sheet->setCellValue('E1', 'Month');
                $sheet->setCellValue('F1', 'Year');
                $sheet->setCellValue('G1', 'Count');
               

                $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                $sheet->getStyle('A1:G1')->applyFromArray($styleArray);

                $rows = 2;
                $i    = 1;

                $all_datas = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                        ->join('users', 'user_events.user_id', 'users.id')
                        ->orderby("user_events.id", "desc")->get();
                // if($respondents != ""){
                //     $all_datas = $all_datas->whereIn('user_events.user_id', [$respondents]);
                // }
                // if($from != null && $to != null){
                //     $all_datas = $all_datas->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                // }
                // $all_datas = $all_datas->get();

                foreach ($all_datas as $all_data) {
                    $sheet->setCellValue('A' . $rows, $i);
                    $sheet->setCellValue('B' . $rows, $all_data->name.$all_data->surname);
                    $sheet->setCellValue('C' . $rows, $all_data->action);
                    $sheet->setCellValue('D' . $rows, $all_data->type);
                    $sheet->setCellValue('E' . $rows, $all_data->month);
                    $sheet->setCellValue('F' . $rows, $all_data->year);
                    $sheet->setCellValue('G' . $rows, $all_data->count);
                    $rows++;
                    $i++;
                }
            }
            else if ($module == 'Team Activity') {
               
                if($type_method == 'Individual'){
                    $all_datas = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                        ->join('users', 'user_events.user_id', 'users.id')
                        ->orderby("user_events.id", "desc");
                        if($respondents != ""){
                            $all_datas = $all_datas->whereIn('user_events.user_id', [$respondents]);
                        }
                        if($from != null && $to != null){
                            $all_datas = $all_datas->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                        }
                        $all_datas = $all_datas->where('type', '=', 'respondent')->get();

                    $total_created = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                        ->join('users', 'user_events.user_id', 'users.id')
                        ->orderby("user_events.id", "desc");
                        if($respondents != ""){
                            $total_created = $total_created->whereIn('user_events.user_id', [$respondents]);
                        }
                        if($from != null && $to != null){
                            $total_created = $total_created->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                        }
                    $total_created = $total_created->where("user_events.action", "created")
                        ->where('type', '=', 'respondent')
                        ->get()
                        ->count();

                    $total_deactivated = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                        ->join('users', 'user_events.user_id', 'users.id')
                        ->orderby("user_events.id", "desc");
                        if($respondents != ""){
                            $total_deactivated = $total_deactivated->whereIn('user_events.user_id', [$respondents]);
                        }
                        if($from != null && $to != null){
                            $total_deactivated = $total_deactivated->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                        }
                    $total_deactivated = $total_deactivated->where("user_events.action", "deleted")->where('type', '=', 'respondent')->get()->count();

                    $total_blacklisted = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                        ->join('users', 'user_events.user_id', 'users.id')
                        ->orderby("user_events.id", "desc");
                        if($respondents != ""){
                            $total_blacklisted = $total_blacklisted->whereIn('user_events.user_id', [$respondents]);
                        }
                        if($from != null && $to != null){
                            $total_blacklisted = $total_blacklisted->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                        }
                        $total_blacklisted = $total_blacklisted->where("user_events.action", "deactivated")->where('type', '=', 'respondent')->get()->count();
                }
                else{
                    $all_datas = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                        ->join('users', 'user_events.user_id', 'users.id')
                        ->orderby("user_events.id", "desc")
                        ->where('type', '=', 'respondent');
                        if($from != null && $to != null){
                            $all_datas = $all_datas->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                        }
                        $all_datas = $all_datas->get();

                    $total_created = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                        ->join('users', 'user_events.user_id', 'users.id')
                        ->orderby("user_events.id", "desc")
                        ->where("user_events.action", "created")
                        ->where('type', '=', 'respondent');
                        if($from != null && $to != null){
                            $total_created = $total_created->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                        }
                        $total_created = $total_created->get()->count();

                    $total_deactivated = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                        ->join('users', 'user_events.user_id', 'users.id')
                        ->orderby("user_events.id", "desc")
                        ->where("user_events.action", "deleted")
                        ->where('type', '=', 'respondent');
                        if($from != null && $to != null){
                            $total_deactivated = $total_deactivated->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                        }
                        $total_deactivated = $total_deactivated->get()->count();

                    $total_blacklisted = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                        ->join('users', 'user_events.user_id', 'users.id')
                        ->orderby("user_events.id", "desc")
                        ->where("user_events.action", "deactivated")
                        ->where('type', '=', 'respondent');
                        if($from != null && $to != null){
                            $total_blacklisted = $total_blacklisted->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                        }
                        $total_blacklisted = $total_blacklisted->get()->count();
                }

                $sheet->setCellValue('A1', 'Name of team member');
                $sheet->setCellValue('B1', 'Total recruited respondents');
                $sheet->setCellValue('C1', 'Total deactivated respondents');
                $sheet->setCellValue('D1', 'Total blacklisted respondents');

                $sheet->getStyle('A1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                $sheet->getStyle('A1:D1')->applyFromArray($styleArray);

                $rows = 2;
                $i = 1;
                foreach ($all_datas as $all_data) {
                    $sheet->setCellValue('A' . $rows, $all_data->name . " " . $all_data->surname);
                    $sheet->setCellValue('B' . $rows, $total_created);
                    $sheet->setCellValue('C' . $rows, $total_deactivated);
                    $sheet->setCellValue('D' . $rows, $total_blacklisted);

                    $rows++;
                    $i++;
                }

                $fileName = $module . "_" . date('ymd') . "." . $type;
            }

            if ($type == 'xlsx') {
                $writer = new Xlsx($spreadsheet);
            }
            else if ($type == 'xls') {
                $writer = new Xls($spreadsheet);
            }
            
            $writer->save("../public/" . $fileName);

            header("Content-Type: application/vnd.ms-excel");
            return redirect(url('/') . "/" . $fileName);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
