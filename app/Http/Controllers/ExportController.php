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

            $module = $request->module;
            $resp_status = $request->resp_status;
            $resp_type = $request->show_resp_type;
            $from = ($request->start != null) ? date('Y-m-d', strtotime($request->start)) : null;
            $to = ($request->end != null) ? date('Y-m-d', strtotime($request->end)) : null;
            $type_method = $request->type_method;
            $type_resp = $request->type_resp;

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

            $all_datas = Respondents::leftJoin('respondent_profile', function ($join) {
                $join->on('respondent_profile.respondent_id', '=', 'respondents.id');
            })
            ->when($type_method == 'Individual', function ($query) use ($respondents) {
                $query->whereIn('respondents.id', [$respondents]);
            })
            ->when($type_method != 'Individual', function ($query) {
                $query->where('active_status_id', 1);
            })
            ->select([
                'respondents.id',
                'respondents.opted_in',
                \DB::raw('COALESCE(respondent_profile.basic_details, "") AS basic_details'),
                \DB::raw('COALESCE(respondent_profile.essential_details, "") AS essential_details'),
                \DB::raw('COALESCE(respondent_profile.extended_details, "") AS extended_details'),
                \DB::raw('COALESCE(respondent_profile.children_data, "") AS children_data'),
                \DB::raw('COALESCE(respondent_profile.vehicle_data, "") AS vehicle_data'),
                'respondent_profile.updated_at',
            ])
            ->get()
            ->unique('id'); // Ensure uniqueness based on respondents.id
        
        
           
            if ($module == 'Respondents info') {
                if($resp_type == 'simple'){
                    $sheet->setCellValue('A1', 'PID');
                    $sheet->setCellValue('B1', 'First Name');
                    $sheet->setCellValue('C1', 'Last Name');
                    $sheet->setCellValue('D1', 'Mobile Number');
                    $sheet->setCellValue('E1', 'WA Number');
                    $sheet->setCellValue('F1', 'Email');
                    $sheet->setCellValue('G1', 'Age');
                    $sheet->setCellValue('H1', 'Date of Birth');

                    $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:H1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i = 1;

                    foreach ($all_datas as $all_data) {
                  
                        $basic = json_decode($all_data->basic_details);
                        $essential = json_decode($all_data->essential_details);

                        $sheet->setCellValue('A' . $rows, $all_data->id);
                        $sheet->setCellValue('B' . $rows, $basic->first_name ?? '');
                        $sheet->setCellValue('C' . $rows, $basic->last_name ?? '');
                        $sheet->setCellValue('D' . $rows, $basic->mobile_number ?? '');
                        $sheet->setCellValue('E' . $rows, $basic->whatsapp_number ?? '');
                        $sheet->setCellValue('F' . $rows, $basic->email ?? '');

                        $year = (isset($basic->date_of_birth)) ? (date('Y') - date('Y', strtotime($basic->date_of_birth ?? ''))) : '-';
                        $sheet->setCellValue('G' . $rows, $year);
                        $sheet->setCellValue('H' . $rows, $basic->date_of_birth ?? '');
                       
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':H' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':H' . $rows)->getAlignment()->setIndent(1);
                        $rows++;
                    }
                }
                else if ($resp_type == 'essential') {
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

                    foreach ($all_datas as $all_data) {
                  
                        $basic = json_decode($all_data->basic_details);
                        $essential = json_decode($all_data->essential_details);

                        $sheet->setCellValue('A' . $rows, $all_data->id);
                        $sheet->setCellValue('B' . $rows, $basic->first_name ?? '');
                        $sheet->setCellValue('C' . $rows, $basic->last_name ?? '');
                        $sheet->setCellValue('D' . $rows, $basic->mobile_number ?? '');
                        $sheet->setCellValue('E' . $rows, $basic->whatsapp_number ?? '');
                        $sheet->setCellValue('F' . $rows, $basic->email ?? '');

                        $year = (isset($basic->date_of_birth)) ? (date('Y') - date('Y', strtotime($basic->date_of_birth ?? ''))) : '-';

                        $employment_status = null; // Initialize $employment_status to null

                        if ($essential && isset($essential->employment_status)) {
                            $employment_status = ($essential->employment_status == 'other') ? $essential->employment_status_other : $essential->employment_status;
                        }
                        
                        $industry_my_company = null; // Initialize $industry_my_company to null

                        if ($essential && isset($essential->industry_my_company)) {
                            $industry_my_company = ($essential->industry_my_company == 'other') ? $essential->industry_my_company_other : $essential->industry_my_company;
                        }

                       
                        $sheet->setCellValue('G' . $rows, $year);
                        $sheet->setCellValue('H' . $rows, $essential->relationship_statu ?? '');
                        $sheet->setCellValue('I' . $rows, $essential->ethnic_group ?? '');
                        $sheet->setCellValue('J' . $rows, $essential->gender ?? '');
                        $sheet->setCellValue('K' . $rows, $essential->education_level ?? '');
                        $sheet->setCellValue('L' . $rows, $employment_status ?? '');
                        $sheet->setCellValue('M' . $rows, $industry_my_company ?? '');
                        $sheet->setCellValue('N' . $rows, $essential->job_title ?? '');
                        $sheet->setCellValue('O' . $rows, $essential->personal_income_per_month ?? '');
                        $sheet->setCellValue('P' . $rows, $essential->job_title ?? '');

                        $state = null; // Initialize $state to null

                        if ($essential && isset($essential->province)) {
                            $state = DB::table('state')
                                        ->where('id', $essential->province)
                                        ->first();
                        }
                        
                        $district = null; // Initialize $district to null

                        if ($essential && isset($essential->suburb)) {
                            $district = DB::table('district')
                                          ->where('id', $essential->suburb)
                                          ->first();
                        }
                        

                        $get_state = ($state != null) ? $state->state : '-';
                        $get_district = ($district != null) ? $district->district : '-';
                      
                        $sheet->setCellValue('Q' . $rows, $get_state ?? '');
                        $sheet->setCellValue('R' . $rows, $get_district ?? '');
                        $sheet->setCellValue('S' . $rows, $essential->no_houehold ?? '');
                        $sheet->setCellValue('T' . $rows, $essential->no_children ?? '');
                        $sheet->setCellValue('U' . $rows, $essential->no_vehicle ?? '');

                        $opted_in = ($all_data->opted_in != null) ? date("d-m-Y", strtotime($all_data->opted_in)) : '';
                        $updated_at = ($all_data->updated_at != null) ? date("d-m-Y", strtotime($all_data->updated_at)) : '';

                        $sheet->setCellValue('V' . $rows, $opted_in);
                        $sheet->setCellValue('W' . $rows, $updated_at);
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':W' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':W' . $rows)->getAlignment()->setIndent(1);
                        $rows++;
                    }

                }
                else if ($resp_type == 'extended') {
                    $sheet->getColumnDimension('Y')->setAutoSize(true);
                    $sheet->getColumnDimension('Z')->setAutoSize(true);
                    $sheet->getColumnDimension('AA')->setAutoSize(true);
                    $sheet->getColumnDimension('AB')->setAutoSize(true);
                    $sheet->getColumnDimension('AC')->setAutoSize(true);
                    $sheet->getColumnDimension('AD')->setAutoSize(true);
                    $sheet->getColumnDimension('AE')->setAutoSize(true);
                    $sheet->getColumnDimension('AF')->setAutoSize(true);
                    $sheet->getColumnDimension('AG')->setAutoSize(true);
                    $sheet->getColumnDimension('AH')->setAutoSize(true);
                    $sheet->getColumnDimension('AI')->setAutoSize(true);
                    $sheet->getColumnDimension('AJ')->setAutoSize(true);
                    $sheet->getColumnDimension('AK')->setAutoSize(true);
                    $sheet->getColumnDimension('AL')->setAutoSize(true);
                    $sheet->getColumnDimension('AM')->setAutoSize(true);
                    $sheet->getColumnDimension('AN')->setAutoSize(true);
                    $sheet->getColumnDimension('AO')->setAutoSize(true);
                    $sheet->getColumnDimension('AP')->setAutoSize(true);
                    
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
                    $sheet->setCellValue('R1', 'Suburb');
                    $sheet->setCellValue('S1', 'Metropolitan Area');
                    $sheet->setCellValue('T1', 'No. of people living in your household');
                    $sheet->setCellValue('U1', 'Number of children');
                    $sheet->setCellValue('V1', 'Number of vehicles');
                    $sheet->setCellValue('W1', 'Which best describes the role in you business / organization?');
                    $sheet->setCellValue('X1', 'What is the number of people in your organisation / company?');
                    $sheet->setCellValue('Y1', 'Which bank do you bank with (which is your bank main)');
                    $sheet->setCellValue('Z1', 'Home Language');
                    $sheet->setCellValue('AA1', 'Child 1 - Birth Year');
                    $sheet->setCellValue('AB1', 'Child 1 - Gender');
                    $sheet->setCellValue('AC1', 'Child 2 - Birth Year');
                    $sheet->setCellValue('AD1', 'Child 2 - Gender');
                    $sheet->setCellValue('AE1', 'Child 3 - Birth Year');
                    $sheet->setCellValue('AF1', 'Child 3 - Gender');
                    $sheet->setCellValue('AE1', 'Child 4 - Birth Year');
                    $sheet->setCellValue('AF1', 'Child 4 - Gender');
                    $sheet->setCellValue('AG1', 'Car 1 - Brand');
                    $sheet->setCellValue('AH1', 'Car 1 - Model');
                    $sheet->setCellValue('AI1', 'Car 2 - Brand');
                    $sheet->setCellValue('AJ1', 'Car 2 - Model');
                    $sheet->setCellValue('AK1', 'Car 3 - Brand');
                    $sheet->setCellValue('AL1', 'Car 3 - Model');
                    $sheet->setCellValue('AM1', 'Car 4 - Brand');
                    $sheet->setCellValue('AN1', 'Car 4 - Model');
                    $sheet->setCellValue('AO1', 'Opted in');
                    $sheet->setCellValue('AP1', 'Last Updated');

                    $sheet->getStyle('A1:AP1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:AP1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i = 1;
                  
                    foreach ($all_datas as $all_data) {
                        $basic = json_decode($all_data->basic_details);
                        $essential = json_decode($all_data->essential_details);
                        $extended  = json_decode($all_data->extended_details);

                        $sheet->setCellValue('A' . $rows, $all_data->id);
                        $sheet->setCellValue('B' . $rows, $basic->first_name ?? '');
                        $sheet->setCellValue('C' . $rows, $basic->last_name ?? '');
                        $sheet->setCellValue('D' . $rows, $basic->mobile_number ?? '');
                        $sheet->setCellValue('E' . $rows, $basic->whatsapp_number ?? '');
                        $sheet->setCellValue('F' . $rows, $basic->email ?? '');

                        $year = (isset($basic->date_of_birth)) ? (date('Y') - date('Y', strtotime($basic->date_of_birth ?? ''))) : '-';

                        $employment_status = isset($essential) && $essential->employment_status == 'other' ? $essential->employment_status_other : ($essential ? $essential->employment_status : null);
                        $industry_my_company = isset($essential) && $essential->industry_my_company == 'other' ? $essential->industry_my_company_other : ($essential ? $essential->industry_my_company : null);
                        
                       
                        $p_income = null; // Initialize $p_income to null

                        if ($essential && isset($essential->personal_income_per_month)) {
                            $p_income = DB::table('income_per_month')
                                            ->where('id', $essential->personal_income_per_month)
                                            ->first();
                        }
                        $h_income = null; // Initialize $h_income to null

                        if ($essential && isset($essential->household_income_per_month)) {
                            $h_income = DB::table('income_per_month')
                                            ->where('id', $essential->household_income_per_month)
                                            ->first();
                        }
                        
                        $personal_income = ($p_income != null) ? $p_income->income : '-';
                        $household_income = ($h_income != null) ? $h_income->income : '-';

                        $sheet->setCellValue('G' . $rows, $year);
                        $sheet->setCellValue('H' . $rows, $essential->relationship_statu ?? '');
                        $sheet->setCellValue('I' . $rows, $essential->ethnic_group ?? '');
                        $sheet->setCellValue('J' . $rows, $essential->gender ?? '');
                        $sheet->setCellValue('K' . $rows, $essential->education_level ?? '');
                        $sheet->setCellValue('L' . $rows, $employment_status ?? '');
                        $sheet->setCellValue('M' . $rows, $industry_my_company ?? '');
                        $sheet->setCellValue('N' . $rows, $essential->job_title ?? '');
                        $sheet->setCellValue('O' . $rows, $personal_income ?? '');
                        $sheet->setCellValue('P' . $rows, $household_income ?? '');

                        $state = null; // Initialize $state to null

                        if ($essential && isset($essential->province)) {
                            $state = DB::table('state')
                                        ->where('id', $essential->province)
                                        ->first();
                        }
                        $district = null; // Initialize $district to null

                        if ($essential && isset($essential->suburb)) {
                            $district = DB::table('district')
                                        ->where('id', $essential->suburb)
                                        ->first();
                        }


                        $get_state = ($state != null) ? $state->state : '-';
                        $get_district = ($district != null) ? $district->district : '-';

                        $sheet->setCellValue('Q' . $rows, $get_state ?? '');
                        $sheet->setCellValue('R' . $rows, $get_district ?? '');
                        $sheet->setCellValue('S' . $rows, $essential->metropolitan_area ?? '');
                        $sheet->setCellValue('T' . $rows, $essential->no_houehold ?? '');
                        $sheet->setCellValue('U' . $rows, $essential->no_children ?? '');
                        $sheet->setCellValue('V' . $rows, $essential->no_vehicle ?? '');

                        $business_org = null; // Initialize $business_org to null

                        if ($extended && isset($extended->business_org)) {
                            $business_org = $extended->business_org == 'other' ? $extended->business_org_other : $extended->business_org;
                        }
                        
                        $home_lang = null; // Initialize $home_lang to null

                        if ($extended && isset($extended->home_lang)) {
                            $home_lang = $extended->home_lang == 'other' ? $extended->home_lang_other : $extended->home_lang;
                        }
                        

                        $bank_main = null; // Initialize $bank_main to null

                        if ($extended && isset($extended->bank_main)) {
                            if ($extended->bank_main == 'other') {
                                $bank_main = $extended->bank_main_other;
                            } else {
                                $banks = DB::table('banks')
                                            ->where('id', $extended->bank_main)
                                            ->where('active', 1)
                                            ->first();
                                if ($banks) {
                                    $bank_main = $banks->bank_name;
                                }
                            }
                        }
                        
                            
                        $sheet->setCellValue('W' . $rows, $business_org ?? '');
                        $sheet->setCellValue('X' . $rows, $extended->org_company ?? '');
                        $sheet->setCellValue('Y' . $rows, $bank_main ?? '');
                        $sheet->setCellValue('Z' . $rows, $home_lang ?? '');

                        $children_data = json_decode($all_data->children_data, true);
                        $vehicle_data = json_decode($all_data->vehicle_data, true);

                        $new_alpha = 'AA';
                        foreach($children_data as $children){
                            $sheet->setCellValue($new_alpha.$rows, $children->date ?? '');
                            $new_alpha++;
                            $sheet->setCellValue($new_alpha.$rows, $children->gender ?? '');
                            $new_alpha++;
                        }

                        $vehicle_alpha = 'AG';
                        foreach($vehicle_data as $vehicle){
                            $get_vehicle = DB::table('vehicle_master')->where('id',$vehicle->brand)->first();
                            $vehicle_name = ($get_vehicle != null) ? $get_vehicle->vehicle_name : '-';
                            $sheet->setCellValue($vehicle_alpha.$rows, $vehicle_name ?? '');
                            $vehicle_alpha++;
                            $sheet->setCellValue($vehicle_alpha.$rows, $vehicle->model ?? '');
                            $vehicle_alpha++;
                        }

                        $opted_in = ($all_data->opted_in != null) ? date("d-m-Y", strtotime($all_data->opted_in)) : '';
                        $updated_at = ($all_data->updated_at != null) ? date("d-m-Y", strtotime($all_data->updated_at)) : '';
                       
                        $sheet->setCellValue('AO' . $rows, $opted_in);
                        $sheet->setCellValue('AP' . $rows, $updated_at);
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':AP' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':AP' . $rows)->getAlignment()->setIndent(1);
                        $rows++;
                        $i++;
                    }
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
                        if($respondents != ""){
                            $all_datas = $all_datas->whereIn('cashouts.respondent_id', [$respondents]);
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
                $projects = $request->projects;
                
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
                }else if($type_method == 'All'){
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
                else{
                    $all_datas = Respondents::leftJoin('rewards', function ($join) {
                        $join->on('rewards.respondent_id', '=', 'respondents.id');
                    });
                    if($projects != ""){
                        $all_datas = $all_datas->whereIn('rewards.project_id', [$projects]);
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

            }else if ($module == 'Survey') {
                
                $sheet->getColumnDimension('Y')->setAutoSize(true);
                $sheet->getColumnDimension('Z')->setAutoSize(true);
                $sheet->getColumnDimension('AA')->setAutoSize(true);
                $sheet->getColumnDimension('AB')->setAutoSize(true);
                $sheet->getColumnDimension('AC')->setAutoSize(true);
                $sheet->getColumnDimension('AD')->setAutoSize(true);
                $sheet->getColumnDimension('AE')->setAutoSize(true);
                $sheet->getColumnDimension('AF')->setAutoSize(true);
                $sheet->getColumnDimension('AG')->setAutoSize(true);
                $sheet->getColumnDimension('AH')->setAutoSize(true);
                $sheet->getColumnDimension('AI')->setAutoSize(true);
                $sheet->getColumnDimension('AJ')->setAutoSize(true);
                $sheet->getColumnDimension('AK')->setAutoSize(true);
                $sheet->getColumnDimension('AL')->setAutoSize(true);
                $sheet->getColumnDimension('AM')->setAutoSize(true);
                $sheet->getColumnDimension('AN')->setAutoSize(true);
                $sheet->getColumnDimension('AO')->setAutoSize(true);
                $sheet->getColumnDimension('AP')->setAutoSize(true);
                
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
                $sheet->setCellValue('R1', 'Suburb');
                $sheet->setCellValue('S1', 'Metropolitan Area');
                $sheet->setCellValue('T1', 'No. of people living in your household');
                $sheet->setCellValue('U1', 'Number of children');
                $sheet->setCellValue('V1', 'Number of vehicles');
                $sheet->setCellValue('W1', 'Which best describes the role in you business / organization?');
                $sheet->setCellValue('X1', 'What is the number of people in your organisation / company?');
                $sheet->setCellValue('Y1', 'Which bank do you bank with (which is your bank main)');
                $sheet->setCellValue('Z1', 'Home Language');
                $sheet->setCellValue('AA1', 'Child 1 - Birth Year');
                $sheet->setCellValue('AB1', 'Child 1 - Gender');
                $sheet->setCellValue('AC1', 'Child 2 - Birth Year');
                $sheet->setCellValue('AD1', 'Child 2 - Gender');
                $sheet->setCellValue('AE1', 'Child 3 - Birth Year');
                $sheet->setCellValue('AF1', 'Child 3 - Gender');
                $sheet->setCellValue('AE1', 'Child 4 - Birth Year');
                $sheet->setCellValue('AF1', 'Child 4 - Gender');
                $sheet->setCellValue('AG1', 'Car 1 - Brand');
                $sheet->setCellValue('AH1', 'Car 1 - Model');
                $sheet->setCellValue('AI1', 'Car 2 - Brand');
                $sheet->setCellValue('AJ1', 'Car 2 - Model');
                $sheet->setCellValue('AK1', 'Car 3 - Brand');
                $sheet->setCellValue('AL1', 'Car 3 - Model');
                $sheet->setCellValue('AM1', 'Car 4 - Brand');
                $sheet->setCellValue('AN1', 'Car 4 - Model');
                $sheet->setCellValue('AO1', 'Opted in');
                $sheet->setCellValue('AP1', 'Last Updated');

                $sheet->getStyle('A1:AP1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                $sheet->getStyle('A1:AP1')->applyFromArray($styleArray);

                $rows = 2;
                $i = 1;
              
                foreach ($all_datas as $all_data) {
                    $basic = json_decode($all_data->basic_details);
                    $essential = json_decode($all_data->essential_details);
                    $extended  = json_decode($all_data->extended_details);

                    $sheet->setCellValue('A' . $rows, $all_data->id);
                    $sheet->setCellValue('B' . $rows, $basic->first_name ?? '');
                    $sheet->setCellValue('C' . $rows, $basic->last_name ?? '');
                    $sheet->setCellValue('D' . $rows, $basic->mobile_number ?? '');
                    $sheet->setCellValue('E' . $rows, $basic->whatsapp_number ?? '');
                    $sheet->setCellValue('F' . $rows, $basic->email ?? '');

                    $year = (isset($basic->date_of_birth)) ? (date('Y') - date('Y', strtotime($basic->date_of_birth ?? ''))) : '-';

                    $employment_status = ($essential->employment_status == 'other') ? $essential->employment_status_other : $essential->employment_status;
                    $industry_my_company = ($essential->industry_my_company == 'other') ? $essential->industry_my_company_other : $essential->industry_my_company;
                   
                    $p_income = DB::table('income_per_month')->where('id',$essential->personal_income_per_month)->first();
                    $h_income = DB::table('income_per_month')->where('id',$essential->household_income_per_month)->first();
                    $personal_income = ($p_income != null) ? $p_income->income : '-';
                    $household_income = ($h_income != null) ? $h_income->income : '-';

                    $sheet->setCellValue('G' . $rows, $year);
                    $sheet->setCellValue('H' . $rows, $essential->relationship_statu ?? '');
                    $sheet->setCellValue('I' . $rows, $essential->ethnic_group ?? '');
                    $sheet->setCellValue('J' . $rows, $essential->gender ?? '');
                    $sheet->setCellValue('K' . $rows, $essential->education_level ?? '');
                    $sheet->setCellValue('L' . $rows, $employment_status ?? '');
                    $sheet->setCellValue('M' . $rows, $industry_my_company ?? '');
                    $sheet->setCellValue('N' . $rows, $essential->job_title ?? '');
                    $sheet->setCellValue('O' . $rows, $personal_income ?? '');
                    $sheet->setCellValue('P' . $rows, $household_income ?? '');

                    $state = DB::table('state')->where('id', $essential->province)->first();
                    $district = DB::table('district')->where('id', $essential->suburb)->first();

                    $get_state = ($state != null) ? $state->state : '-';
                    $get_district = ($district != null) ? $district->district : '-';

                    $sheet->setCellValue('Q' . $rows, $get_state ?? '');
                    $sheet->setCellValue('R' . $rows, $get_district ?? '');
                    $sheet->setCellValue('S' . $rows, $essential->metropolitan_area ?? '');
                    $sheet->setCellValue('T' . $rows, $essential->no_houehold ?? '');
                    $sheet->setCellValue('U' . $rows, $essential->no_children ?? '');
                    $sheet->setCellValue('V' . $rows, $essential->no_vehicle ?? '');

                    $business_org = ($extended->business_org == 'other') ? $extended->business_org_other : $extended->business_org;
                    $home_lang    = ($extended->home_lang == 'other') ? $extended->home_lang_other : $extended->home_lang;

                    $banks = DB::table('banks')->where('id',$extended->bank_main)->where('active',1)->first();
                    $bank_main = ($extended->bank_main == 'other') ? $extended->bank_main_other : $banks->bank_name;
                        
                    $sheet->setCellValue('W' . $rows, $business_org ?? '');
                    $sheet->setCellValue('X' . $rows, $extended->org_company ?? '');
                    $sheet->setCellValue('Y' . $rows, $bank_main ?? '');
                    $sheet->setCellValue('Z' . $rows, $home_lang ?? '');

                    $children_data = json_decode($all_data->children_data);
                    $vehicle_data = json_decode($all_data->vehicle_data);

                    $new_alpha = 'AA';
                    foreach($children_data as $children){
                        $sheet->setCellValue($new_alpha.$rows, $children->date ?? '');
                        $new_alpha++;
                        $sheet->setCellValue($new_alpha.$rows, $children->gender ?? '');
                        $new_alpha++;
                    }

                    $vehicle_alpha = 'AG';
                    foreach($vehicle_data as $vehicle){
                        $get_vehicle = DB::table('vehicle_master')->where('id',$vehicle->brand)->first();
                        $vehicle_name = ($get_vehicle != null) ? $get_vehicle->vehicle_name : '-';
                        $sheet->setCellValue($vehicle_alpha.$rows, $vehicle_name ?? '');
                        $vehicle_alpha++;
                        $sheet->setCellValue($vehicle_alpha.$rows, $vehicle->model ?? '');
                        $vehicle_alpha++;
                    }

                    $opted_in = ($all_data->opted_in != null) ? date("d-m-Y", strtotime($all_data->opted_in)) : '';
                    $updated_at = ($all_data->updated_at != null) ? date("d-m-Y", strtotime($all_data->updated_at)) : '';
                   
                    $sheet->setCellValue('AO' . $rows, $opted_in);
                    $sheet->setCellValue('AP' . $rows, $updated_at);
                    $sheet->getRowDimension($rows)->setRowHeight(20);
                    $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                    $sheet->getStyle('C' . $rows . ':AP' . $rows)->applyFromArray($styleArray2);
                    $sheet->getStyle('C' . $rows . ':AP' . $rows)->getAlignment()->setIndent(1);
                }
                $rows++;
                $i++;
            

                $fileName = $module . "_" . $resp_type . "_" . date('ymd') . "." . $type;
            }
            else if ($module == 'Survey') {
                
                $sheet->getColumnDimension('Y')->setAutoSize(true);
                $sheet->getColumnDimension('Z')->setAutoSize(true);
                $sheet->getColumnDimension('AA')->setAutoSize(true);
                $sheet->getColumnDimension('AB')->setAutoSize(true);
                $sheet->getColumnDimension('AC')->setAutoSize(true);
                $sheet->getColumnDimension('AD')->setAutoSize(true);
                $sheet->getColumnDimension('AE')->setAutoSize(true);
                $sheet->getColumnDimension('AF')->setAutoSize(true);
                $sheet->getColumnDimension('AG')->setAutoSize(true);
                $sheet->getColumnDimension('AH')->setAutoSize(true);
                $sheet->getColumnDimension('AI')->setAutoSize(true);
                $sheet->getColumnDimension('AJ')->setAutoSize(true);
                $sheet->getColumnDimension('AK')->setAutoSize(true);
                $sheet->getColumnDimension('AL')->setAutoSize(true);
                $sheet->getColumnDimension('AM')->setAutoSize(true);
                $sheet->getColumnDimension('AN')->setAutoSize(true);
                $sheet->getColumnDimension('AO')->setAutoSize(true);
                $sheet->getColumnDimension('AP')->setAutoSize(true);
                
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
                $sheet->setCellValue('R1', 'Suburb');
                $sheet->setCellValue('S1', 'Metropolitan Area');
                $sheet->setCellValue('T1', 'No. of people living in your household');
                $sheet->setCellValue('U1', 'Number of children');
                $sheet->setCellValue('V1', 'Number of vehicles');
                $sheet->setCellValue('W1', 'Which best describes the role in you business / organization?');
                $sheet->setCellValue('X1', 'What is the number of people in your organisation / company?');
                $sheet->setCellValue('Y1', 'Which bank do you bank with (which is your bank main)');
                $sheet->setCellValue('Z1', 'Home Language');
                $sheet->setCellValue('AA1', 'Child 1 - Birth Year');
                $sheet->setCellValue('AB1', 'Child 1 - Gender');
                $sheet->setCellValue('AC1', 'Child 2 - Birth Year');
                $sheet->setCellValue('AD1', 'Child 2 - Gender');
                $sheet->setCellValue('AE1', 'Child 3 - Birth Year');
                $sheet->setCellValue('AF1', 'Child 3 - Gender');
                $sheet->setCellValue('AE1', 'Child 4 - Birth Year');
                $sheet->setCellValue('AF1', 'Child 4 - Gender');
                $sheet->setCellValue('AG1', 'Car 1 - Brand');
                $sheet->setCellValue('AH1', 'Car 1 - Model');
                $sheet->setCellValue('AI1', 'Car 2 - Brand');
                $sheet->setCellValue('AJ1', 'Car 2 - Model');
                $sheet->setCellValue('AK1', 'Car 3 - Brand');
                $sheet->setCellValue('AL1', 'Car 3 - Model');
                $sheet->setCellValue('AM1', 'Car 4 - Brand');
                $sheet->setCellValue('AN1', 'Car 4 - Model');
                $sheet->setCellValue('AO1', 'Opted in');
                $sheet->setCellValue('AP1', 'Last Updated');

                $sheet->getStyle('A1:AP1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                $sheet->getStyle('A1:AP1')->applyFromArray($styleArray);

                $rows = 2;
                $i = 1;
              
                foreach ($all_datas as $all_data) {
                    $basic = json_decode($all_data->basic_details);
                    $essential = json_decode($all_data->essential_details);
                    $extended  = json_decode($all_data->extended_details);

                    $sheet->setCellValue('A' . $rows, $all_data->id);
                    $sheet->setCellValue('B' . $rows, $basic->first_name ?? '');
                    $sheet->setCellValue('C' . $rows, $basic->last_name ?? '');
                    $sheet->setCellValue('D' . $rows, $basic->mobile_number ?? '');
                    $sheet->setCellValue('E' . $rows, $basic->whatsapp_number ?? '');
                    $sheet->setCellValue('F' . $rows, $basic->email ?? '');

                    $year = (isset($basic->date_of_birth)) ? (date('Y') - date('Y', strtotime($basic->date_of_birth ?? ''))) : '-';

                    $employment_status = ($essential->employment_status == 'other') ? $essential->employment_status_other : $essential->employment_status;
                    $industry_my_company = ($essential->industry_my_company == 'other') ? $essential->industry_my_company_other : $essential->industry_my_company;
                   
                    $p_income = DB::table('income_per_month')->where('id',$essential->personal_income_per_month)->first();
                    $h_income = DB::table('income_per_month')->where('id',$essential->household_income_per_month)->first();
                    $personal_income = ($p_income != null) ? $p_income->income : '-';
                    $household_income = ($h_income != null) ? $h_income->income : '-';

                    $sheet->setCellValue('G' . $rows, $year);
                    $sheet->setCellValue('H' . $rows, $essential->relationship_statu ?? '');
                    $sheet->setCellValue('I' . $rows, $essential->ethnic_group ?? '');
                    $sheet->setCellValue('J' . $rows, $essential->gender ?? '');
                    $sheet->setCellValue('K' . $rows, $essential->education_level ?? '');
                    $sheet->setCellValue('L' . $rows, $employment_status ?? '');
                    $sheet->setCellValue('M' . $rows, $industry_my_company ?? '');
                    $sheet->setCellValue('N' . $rows, $essential->job_title ?? '');
                    $sheet->setCellValue('O' . $rows, $personal_income ?? '');
                    $sheet->setCellValue('P' . $rows, $household_income ?? '');

                    $state = DB::table('state')->where('id', $essential->province)->first();
                    $district = DB::table('district')->where('id', $essential->suburb)->first();

                    $get_state = ($state != null) ? $state->state : '-';
                    $get_district = ($district != null) ? $district->district : '-';

                    $sheet->setCellValue('Q' . $rows, $get_state ?? '');
                    $sheet->setCellValue('R' . $rows, $get_district ?? '');
                    $sheet->setCellValue('S' . $rows, $essential->metropolitan_area ?? '');
                    $sheet->setCellValue('T' . $rows, $essential->no_houehold ?? '');
                    $sheet->setCellValue('U' . $rows, $essential->no_children ?? '');
                    $sheet->setCellValue('V' . $rows, $essential->no_vehicle ?? '');

                    $business_org = ($extended->business_org == 'other') ? $extended->business_org_other : $extended->business_org;
                    $home_lang    = ($extended->home_lang == 'other') ? $extended->home_lang_other : $extended->home_lang;

                    $banks = DB::table('banks')->where('id',$extended->bank_main)->where('active',1)->first();
                    $bank_main = ($extended->bank_main == 'other') ? $extended->bank_main_other : $banks->bank_name;
                        
                    $sheet->setCellValue('W' . $rows, $business_org ?? '');
                    $sheet->setCellValue('X' . $rows, $extended->org_company ?? '');
                    $sheet->setCellValue('Y' . $rows, $bank_main ?? '');
                    $sheet->setCellValue('Z' . $rows, $home_lang ?? '');

                    $children_data = json_decode($all_data->children_data, true);
                    $vehicle_data = json_decode($all_data->vehicle_data, true);

                    $new_alpha = 'AA';
                    foreach($children_data as $children){
                        $sheet->setCellValue($new_alpha.$rows, $children->date ?? '');
                        $new_alpha++;
                        $sheet->setCellValue($new_alpha.$rows, $children->gender ?? '');
                        $new_alpha++;
                    }

                    $vehicle_alpha = 'AG';
                    foreach($vehicle_data as $vehicle){
                        $get_vehicle = DB::table('vehicle_master')->where('id',$vehicle->brand)->first();
                        $vehicle_name = ($get_vehicle != null) ? $get_vehicle->vehicle_name : '-';
                        $sheet->setCellValue($vehicle_alpha.$rows, $vehicle_name ?? '');
                        $vehicle_alpha++;
                        $sheet->setCellValue($vehicle_alpha.$rows, $vehicle->model ?? '');
                        $vehicle_alpha++;
                    }

                    $opted_in = ($all_data->opted_in != null) ? date("d-m-Y", strtotime($all_data->opted_in)) : '';
                    $updated_at = ($all_data->updated_at != null) ? date("d-m-Y", strtotime($all_data->updated_at)) : '';
                   
                    $sheet->setCellValue('AO' . $rows, $opted_in);
                    $sheet->setCellValue('AP' . $rows, $updated_at);
                    $sheet->getRowDimension($rows)->setRowHeight(20);
                    $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                    $sheet->getStyle('C' . $rows . ':AP' . $rows)->applyFromArray($styleArray2);
                    $sheet->getStyle('C' . $rows . ':AP' . $rows)->getAlignment()->setIndent(1);
                    $rows++;
                    $i++;
                }
                
            

                $fileName = $module . "_" . $resp_type . "_" . date('ymd') . "." . $type;
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
                $action=$request->action;
                $role=$request->role;
                $year=$request->year;
                $month=strtolower($request->month);
                $pro_type=$request->pro_type;
              
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
                ->join('users', 'user_events.user_id', '=', 'users.id');
            
                if (!empty($action)) {
                    $all_datas->where('user_events.action', '=', $action);
                }
                if (!empty($role)) {
                    $all_datas->where('user_events.role', '=', $role);
                }
                if (!empty($year)) {
                    $all_datas->where('user_events.year', '=', $year);
                }
                if (!empty($month)) {
                    $all_datas->where('user_events.month', '=', $month);
                }
                if (!empty($pro_type)) {
                    $all_datas->where('user_events.type', '=', $pro_type);
                }
         
                $all_datas = $all_datas->orderBy("user_events.id", "desc")->get();

                foreach ($all_datas as $all_data) {
                    $sheet->setCellValue('A' . $rows, $i);
                    $sheet->setCellValue('B' . $rows, $all_data->name.$all_data->surname);
                    $sheet->setCellValue('C' . $rows, $all_data->action);
                    $sheet->setCellValue('D' . $rows, $all_data->type);
                    $sheet->setCellValue('E' . $rows, $all_data->month);
                    $sheet->setCellValue('F' . $rows, $all_data->year);
                    $sheet->setCellValue('G' . $rows, $all_data->count);
                    $sheet->getRowDimension($rows)->setRowHeight(20);
                    $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                    $sheet->getStyle('C' . $rows . ':G' . $rows)->applyFromArray($styleArray2);
                    $sheet->getStyle('C' . $rows . ':G' . $rows)->getAlignment()->setIndent(1);
                    $rows++;
                    $i++;

                   

                }

                $fileName = $module . "_" . date('ymd') . "." . $type;
            }
            else if ($module == 'Team Activity') {
                // Build the base query
                $query = UserEvents::select('users.name', 'users.surname', 'user_events.user_id')
                                ->join('users', 'user_events.user_id', 'users.id')
                                ->where('user_events.type', '=', 'respondent');
            
                // Apply filters if provided
                if ($respondents != "") {
                    $query->whereIn('user_events.user_id', [$respondents]);
                }
            
                if ($from != null && $to != null) {
                    $query->whereDate('user_events.created_at', '>=', $from)
                          ->whereDate('user_events.created_at', '<=', $to);
                }
            
                // Group by user_id to avoid duplication
                $query->groupBy('user_events.user_id', 'users.name', 'users.surname');
            
                // Fetch all data
                $all_datas = $query->orderBy("users.name")->get();
            
                $sheet->setCellValue('A1', 'Name of team member');
                $sheet->setCellValue('B1', 'Total recruited respondents');
                $sheet->setCellValue('C1', 'Total deactivated respondents');
                $sheet->setCellValue('D1', 'Total blacklisted respondents');
            
                $sheet->getStyle('A1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                $sheet->getStyle('A1:D1')->applyFromArray($styleArray);
            
                $rows = 2;
                foreach ($all_datas as $data) {
                    // Count total recruited respondents for this specific user
                    $total_created = UserEvents::where('user_id', $data->user_id)
                                                ->where('action', 'created')
                                                ->where('type', 'respondent');
                    if ($from != null && $to != null) {
                        $total_created->whereDate('created_at', '>=', $from)
                                      ->whereDate('created_at', '<=', $to);
                    }
                    $total_created = $total_created->count();
            
                    // Count total deactivated respondents for this specific user
                    $total_deactivated = UserEvents::where('user_id', $data->user_id)
                                                    ->where('action', 'deleted')
                                                    ->where('type', 'respondent');
                    if ($from != null && $to != null) {
                        $total_deactivated->whereDate('created_at', '>=', $from)
                                          ->whereDate('created_at', '<=', $to);
                    }
                    $total_deactivated = $total_deactivated->count();
            
                    // Count total blacklisted respondents for this specific user
                    $total_blacklisted = UserEvents::where('user_id', $data->user_id)
                                                    ->where('action', 'deactivated')
                                                    ->where('type', 'respondent');
                    if ($from != null && $to != null) {
                        $total_blacklisted->whereDate('created_at', '>=', $from)
                                          ->whereDate('created_at', '<=', $to);
                    }
                    $total_blacklisted = $total_blacklisted->count();
            
                    // Set values for each row
                    $sheet->setCellValue('A' . $rows, $data->name . " " . $data->surname);
                    $sheet->setCellValue('B' . $rows, $total_created);
                    $sheet->setCellValue('C' . $rows, $total_deactivated);
                    $sheet->setCellValue('D' . $rows, $total_blacklisted);
                    $sheet->getRowDimension($rows)->setRowHeight(20);
                    $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                    $sheet->getStyle('C' . $rows . ':D' . $rows)->applyFromArray($styleArray2);
                    $sheet->getStyle('C' . $rows . ':D' . $rows)->getAlignment()->setIndent(1);
                    $rows++;
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
