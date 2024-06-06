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
            $from = date('Y-m-d', strtotime($request->start));
            $to = date('Y-m-d', strtotime($request->end));
            $type_method = $request->type_method;

            $type = 'xlsx';

            if ($module == 'Respondents info') {

                // dd($all_datas,'basic_details');

                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff',
                        ),
                    ),
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

                if ($resp_type == 'Basic and Essential Info') {

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

                    $sheet->setCellValue('G1', 'Age');

                    $sheet->getStyle('G1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('G1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('H1', 'Relationship status');

                    $sheet->getStyle('H1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('H1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('I1', 'Ethnic Group / Race');

                    $sheet->getStyle('I1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('I1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('J1', 'Gender');

                    $sheet->getStyle('J1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('J1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('K1', 'Highest Education Level');

                    $sheet->getStyle('K1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('K1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('L1', 'Employment Status');

                    $sheet->getStyle('L1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('L1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('M1', 'Industry my company is in');

                    $sheet->getStyle('M1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('M1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('N1', 'Job Title');

                    $sheet->getStyle('N1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('N1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('O1', 'Personal Income per month');

                    $sheet->getStyle('O1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('O1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('P1', 'HHI per month');

                    $sheet->getStyle('P1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('P1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('Q1', 'Province');

                    $sheet->getStyle('Q1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('Q1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('R1', 'Area');

                    $sheet->getStyle('R1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('R1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('S1', 'No. of people living in your household');

                    $sheet->getStyle('S1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('S1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('T1', 'Number of children');

                    $sheet->getStyle('T1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('T1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('U1', 'Number of vehicles');

                    $sheet->getStyle('U1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('U1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('V1', 'Opted in');

                    $sheet->getStyle('V1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('V1')
                        ->applyFromArray($styleArray);

                    $sheet->setCellValue('W1', 'Last Updated');

                    $sheet->getStyle('W1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('0f609b'); // cell color

                    $sheet->getStyle('W1')
                        ->applyFromArray($styleArray);

                    $rows = 2;
                    $i = 1;

                    $respondents = $request->respondents;

                    if ($request->respondents != null) {
                        $respondents = implode(',', array_filter($request->respondents));
                    } else {
                        $respondents = null;
                    }

                    if($type_method == 'Individual'){

                        $all_datas = Respondents::leftJoin('respondent_profile', function ($join) {
                            $join->on('respondent_profile.id', '=', 'respondent_profile.respondent_id');
                        })
                        ->whereIn('respondents.id', [$respondents])
                        ->where('respondents.created_at', '>=', $from)
                        ->where('respondents.created_at', '<=', $to)
                        ->get([
                            'respondents.opted_in',
                            'respondent_profile.basic_details',
                            'respondent_profile.essential_details',
                            'respondent_profile.extended_details',
                            'respondent_profile.updated_at',
                        ]);
                        
                    }else{

                        $all_datas = Respondents::leftJoin('respondent_profile', function ($join) {
                            $join->on('respondent_profile.id', '=', 'respondent_profile.respondent_id');
                        })
                        ->where('respondents.created_at', '>=', $from)
                        ->where('respondents.created_at', '<=', $to)
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
                        $year = (date('Y') - date('Y', strtotime($basic->date_of_birth)));
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
                        $get_state = DB::table('state')->where('id', $essential->province)->first();
                        $sheet->setCellValue('Q' . $rows, $get_state->state ?? '');
                        $get_district = DB::table('district')->where('id', $essential->suburb)->first();
                        $sheet->setCellValue('R' . $rows, $get_district->district ?? '');
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

                } else if ($resp_type == 'Extended Info') {

                    // starts

                    $sheet->getColumnDimension('A')->setAutoSize(true);
                    $sheet->getColumnDimension('B')->setAutoSize(true);
                    $sheet->getColumnDimension('C')->setAutoSize(true);
                    $sheet->getColumnDimension('D')->setAutoSize(true);
                    $sheet->getColumnDimension('E')->setAutoSize(true);
                    $sheet->getColumnDimension('F')->setAutoSize(true);

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
                    $i = 1;
                    foreach ($all_datas as $all_data) {

                        $sheet->setCellValue('A' . $rows, $i);
                        $sheet->setCellValue('B' . $rows, $all_data->name);
                        $sheet->setCellValue('C' . $rows, $all_data->surname);
                        $sheet->setCellValue('D' . $rows, $all_data->mobile);
                        $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
                        $sheet->setCellValue('F' . $rows, $all_data->email);
                        $sheet->setCellValue('G' . $rows, $all_data->updated_at);
                        $sheet->setCellValue('H' . $rows, $all_data->created_by);
                        // $rows++;
                        // $i++;
                    }

                }

                $fileName = $module . "_" . $resp_type . "_" . date('ymd') . "." . $type;

            } else if ($module == 'Respondents') {

                $respondents = $request->respondents;

                if ($request->respondents != null) {
                    $respondents = implode(',', array_filter($request->respondents));
                } else {
                    $respondents = null;
                }

                $all_datas = Respondents::whereIn('respondents.id', [$respondents])
                    ->where('respondents.created_at', '>=', $from)
                    ->where('respondents.created_at', '<=', $to)
                    ->get();

                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff',
                        ),
                    ),
                );

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->getRowDimension('1')->setRowHeight(30);

                if ($resp_status == 'Deactivated') {

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
                    $i = 1;
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

                        // $i++;
                    }

                    // ends
                } else if ($resp_status == 'Blacklisted') {

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
                    $i = 1;
                    foreach ($all_datas as $all_data) {

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

                $fileName = $module . "_" . $resp_status . "_" . date('ymd') . "." . $type;

            } else if ($module == 'Cashout') {
                $from = '2023-12-12';
                $to = '2024-02-02';

                $all_datas = Cashout::select('cashouts.*', 'respondents.name', 'respondents.email', 'respondents.mobile')
                    ->join('respondents', 'respondents.id', '=', 'cashouts.respondent_id')
                    ->where('cashouts.created_at', '>=', $from)
                    ->where('cashouts.created_at', '<=', $to)
                    ->orderby("id", "desc")
                    ->get();

                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff',
                        ),
                    ),
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
                $i = 1;
                foreach ($all_datas as $all_data) {

                    if ($all_data->type_id == 1) {
                        $type_val = 'EFT';
                    } else if ($all_data->type_id == 2) {
                        $type_val = 'Data';
                    } else if ($all_data->type_id == 3) {
                        $type_val = 'Airtime';
                    } else {
                        $type_val = '-';
                    }

                    if ($all_data->status_id == 0) {
                        $status_val = 'Failed';
                    } else if ($all_data->status_id == 1) {
                        $status_val = '';
                    } else if ($all_data->status_id == 2) {
                        $status_val = '';
                    } else if ($all_data->status_id == 3) {
                        $status_val = 'Complete';
                    } else if ($all_data->status_id == 4) {
                        $status_val = 'Declined';
                    } else {
                        $status_val = '-';
                    }

                    $amount = $all_data->amount / 10;
                    $respondent = $all_data->name . ' - ' . $all_data->email . ' - ' . $all_data->mobile;

                    $sheet->setCellValue('A' . $rows, $i);
                    $sheet->setCellValue('B' . $rows, $all_data->name);
                    $sheet->setCellValue('C' . $rows, $all_data->surname);
                    $sheet->setCellValue('D' . $rows, $all_data->mobile);
                    $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
                    $sheet->setCellValue('F' . $rows, $all_data->email);
                    $sheet->setCellValue('G' . $rows, $all_data->type_val);
                    $rows++;
                    $i++;
                }

                $fileName = $module . "_" . date('ymd') . "." . $type;

            } else if ($module == 'Rewards') {
                $from = '2023-12-12';
                $to = '2024-02-02';

                $all_datas = DB::table('rewards')
                    ->select('rewards.*')
                    ->where('rewards.created_at', '>=', $from)
                    ->where('rewards.created_at', '<=', $to)
                    ->orderby("id", "desc")
                    ->get();

                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff',
                        ),
                    ),
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
                $i = 1;
                foreach ($all_datas as $all_data) {

                    // $rows++;
                    // $i++;
                }

                $fileName = $module . "_" . date('ymd') . "." . $type;

            } else if ($module == 'Projects') {
                $from = '2023-12-12';
                $to = '2024-02-02';

                $all_datas = Projects::select('projects.*', 'projects.name as uname')
                    ->join('users', 'users.id', '=', 'projects.user_id')
                    ->orderby("id", "desc")
                    ->where('projects.created_at', '>=', $from)
                    ->where('projects.created_at', '<=', $to)
                    ->get();

                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff',
                        ),
                    ),
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
                $i = 1;
                foreach ($all_datas as $all_data) {

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

                $fileName = $module . "_" . date('ymd') . "." . $type;

            } else if ($module == 'Team Activity') {
                $from = '2023-12-12';
                $to = '2024-02-02';

                $all_datas = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                    ->join('users', 'user_events.user_id', 'users.id')
                    ->orderby("user_events.id", "desc")
                    ->where('type', '=', 'respondent')
                    ->where('user_events.created_at', '>=', $from)
                    ->where('user_events.created_at', '<=', $to)
                    ->get();

                $total_created = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                    ->join('users', 'user_events.user_id', 'users.id')
                    ->orderby("user_events.id", "desc")
                    ->where("user_events.action", "created")
                    ->where('type', '=', 'respondent')
                    ->where('user_events.created_at', '>=', $from)
                    ->where('user_events.created_at', '<=', $to)
                    ->get()
                    ->count();

                $total_deactivated = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                    ->join('users', 'user_events.user_id', 'users.id')
                    ->orderby("user_events.id", "desc")
                    ->where("user_events.action", "deleted")
                    ->where('type', '=', 'respondent')
                    ->where('user_events.created_at', '>=', $from)
                    ->where('user_events.created_at', '<=', $to)
                    ->get()
                    ->count();

                $total_blacklisted = UserEvents::select('users.name', 'users.surname', 'user_events.*')
                    ->join('users', 'user_events.user_id', 'users.id')
                    ->orderby("user_events.id", "desc")
                    ->where("user_events.action", "deactivated")
                    ->where('type', '=', 'respondent')
                    ->where('user_events.created_at', '>=', $from)
                    ->where('user_events.created_at', '<=', $to)
                    ->get()
                    ->count();

                $styleArray = array( // font color
                    'font' => array(
                        'bold' => true,
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => array(
                            'rgb' => 'ffffff',
                        ),
                    ),
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

                $rows = 2;
                $i = 1;
                foreach ($all_datas as $all_data) {

                    $sheet->setCellValue('A' . $rows, $all_data->name . " " . $all_data->surname);
                    $sheet->setCellValue('B' . $rows, $total_created);
                    $sheet->setCellValue('C' . $rows, $total_deactivated);
                    $sheet->setCellValue('D' . $rows, $total_blacklisted);

                    $rows++;

                    // $rows++;
                    // $i++;
                }

                $fileName = $module . "_" . date('ymd') . "." . $type;

            }

            if ($type == 'xlsx') {
                $writer = new Xlsx($spreadsheet);
            } else if ($type == 'xls') {
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
