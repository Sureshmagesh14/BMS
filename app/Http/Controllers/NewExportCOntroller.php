<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cashout;
use App\Models\Projects;
use App\Models\Respondents;
use App\Models\UserEvents;
use App\Models\SurveyResponse;
use App\Models\Survey;
use App\Models\Questions;
use DB;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DateTime;
use App\Models\Tag;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\RespondentProfile;
use App\Models\RespondentTags;
use App\Models\IndustryCompany;
use App\Models\Users;
class NewExportCOntroller extends Controller
{
    function formatPhoneNumber($number) {
        $number = preg_replace('/\s+/', '', $number);
        $length = strlen($number);
        if ($length == 9) return '27' . $number;
        if ($length == 10 && $number[0] == '0') return '27' . substr($number, 1);
        if ($length == 11 && strpos($number, '27') === 0) return $number;
        if ($length == 12 && strpos($number, '+27') === 0) return $number;
        return '-';
    }
    
    function calculateAge($dob) {
        if (empty($dob) || $dob === '0000-00-00') return '';
        $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
        if (!$dobDate) $dobDate = DateTime::createFromFormat('Y/m/d', $dob);
        if (!$dobDate) return '';
        $now = new DateTime();
        return $now->diff($dobDate)->y;
    }
    
    function getEmploymentStatus($status) {
        $statuses = [
            'emp_full_time' => 'Employed Full-Time', 'emp_part_time' => 'Employed Part-Time',
            'self' => 'Self-Employed', 'study' => 'Studying Full-Time (Not Working)',
            'working_and_studying' => 'Working & Studying', 'home_person' => 'Stay at Home Person',
            'retired' => 'Retired', 'unemployed' => 'Unemployed', 'other' => 'Other'
        ];
        return $statuses[$status] ?? '';
    }
    
    function getIndustryCompany($company_id) {
        $industry = IndustryCompany::find($company_id);
        return $industry ? $industry->company : '';
    }
    
    function getEducationLevel($level) {
        $levels = [
            'matric' => 'Matric', 'post_matric_courses' => 'Post Matric Courses / Higher Certificate',
            'post_matric_diploma' => 'Post Matric Diploma', 'ug' => 'Undergrad University Degree',
            'pg' => 'Post Grad Degree - Honours, Masters, PhD, MBA', 'school_no_metric' => 'School But No Matric'
        ];
        return $levels[$level] ?? '';
    }
    
    function getIncome($income_id) {
        $income = DB::table('income_per_month')->where('id', $income_id)->first();
        return $income ? $income->income : '-';
    }
    
    function getState($state_id) {
        $state = DB::table('state')->where('id', $state_id)->first();
        return $state ? $state->state : '-';
    }
    
    function getDistrict($district_id) {
        $district = DB::table('district')->where('id', $district_id)->first();
        return $district ? $district->district : '-';
    }
    
    function formatDate($date) {
        return $date ? date("d-m-Y", strtotime($date)) : '';
    }

    public function export_all(Request $request)
    {
       
        try {

            $module       = $request->module;
            $resp_status  = $request->resp_status;
            $resp_type    = $request->show_resp_type;
            $from         = ($request->start != null) ? date('Y-m-d', strtotime($request->start)) : null;
            $to           = ($request->end != null) ? date('Y-m-d', strtotime($request->end)) : null;
            $type_method  = $request->type_method;
            $type_resp    = $request->type_resp;
            $cashout_type = $request->show_cashout_val;
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
                    'vertical' => Alignment::VERTICAL_CENTER, // Center vertically
                    'horizontal' => Alignment::HORIZONTAL_LEFT, // Align left horizontally
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
                    'vertical' => Alignment::VERTICAL_CENTER,
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
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ];

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->getRowDimension('1')->setRowHeight(30);
            $respondents = ($request->respondents != null) ? implode(',', array_filter($request->respondents)) : null;

            $all_datas = Respondents::join("respondent_profile", "respondent_profile.respondent_id", "=", "respondents.id")
            ->when($type_method == 'Individual', function ($query) use ($respondents) {
                $query->whereIn('respondents.id', [$respondents]);
            })
            ->when($type_method != 'Individual', function ($query) {
                $query->where('respondents.active_status_id', 1);
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
                \DB::raw('JSON_EXTRACT(respondent_profile.essential_details, "$.personal_income_per_month") AS personal_income_per_month'),
                \DB::raw('JSON_EXTRACT(respondent_profile.essential_details, "$.household_income_per_month") AS household_income_per_month'),
            ])
            ->where('respondents.active_status_id', 1)
            ->whereNotExists(function ($query) {
                $query->select(\DB::raw(1))
                    ->from('respondent_tag')
                    ->whereColumn('respondent_tag.respondent_id', '=', 'respondents.id')
                    ->where('respondent_tag.tag_id', 1);
            }) // Exclude respondents with tag_id = 1
            ->orderBy('respondents.id', 'ASC')
            ->orderByRaw('CASE WHEN CAST(JSON_EXTRACT(respondent_profile.essential_details, "$.personal_income_per_month") AS UNSIGNED) IS NULL OR CAST(JSON_EXTRACT(respondent_profile.essential_details, "$.personal_income_per_month") AS UNSIGNED) = 0 THEN 1 ELSE 0 END ASC')
            ->orderByRaw('CAST(JSON_EXTRACT(respondent_profile.essential_details, "$.personal_income_per_month") AS UNSIGNED) ASC')
            ->orderByRaw('CAST(JSON_EXTRACT(respondent_profile.essential_details, "$.household_income_per_month") AS UNSIGNED) ASC')
            ->get()
            ->unique('id');
            
            if ($module == 'Respondents info') {
                if ($resp_type == 'essential') {
                    $headers = [
                        'A1' => 'PID', 'B1' => 'First Name', 'C1' => 'Last Name', 'D1' => 'Mobile Number',
                        'E1' => 'WA Number', 'F1' => 'Email', 'G1' => 'Age', 'H1' => 'Relationship Status',
                        'I1' => 'Ethnic Group / Race', 'J1' => 'Gender', 'K1' => 'Highest Education Level',
                        'L1' => 'Employment Status', 'M1' => 'Industry my company is in', 'N1' => 'Job Title',
                        'O1' => 'Personal Income per month', 'P1' => 'Personal LSM', 'Q1' => 'HHI per month',
                        'R1' => 'Household LSM', 'S1' => 'Province', 'T1' => 'Metropolitan Area', 'U1' => 'Suburb',
                        'V1' => 'No. of people living in your household', 'W1' => 'Number of children',
                        'X1' => 'Number of vehicles', 'Y1' => 'Opted in', 'Z1' => 'Last Updated'
                    ];
            
                    foreach ($headers as $cell => $value) {
                        $sheet->setCellValue($cell, $value);
                    }
            
                    $sheet->getStyle('A1:Z1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b');
                    $sheet->getStyle('A1:Z1')->applyFromArray($styleArray);
            
                    $rows = 2;
            
                    foreach ($all_datas as $all_data) {
                        $basic = json_decode($all_data->basic_details);
                        $essential = json_decode($all_data->essential_details);
            
                        $mobile_number = $this->formatPhoneNumber($basic->mobile_number ?? '-');
                        $whatsapp_number = $this->formatPhoneNumber($basic->whatsapp_number ?? '-');
            
                        $dob = $basic->date_of_birth ?? '';
                        $age = $this->calculateAge($dob);
            
                        $employment_status = $this->getEmploymentStatus($essential->employment_status ?? '');
                        $industry_my_company = $this->getIndustryCompany($essential->industry_my_company ?? '');
            
                        $relationshipStatus = ucfirst($essential->relationship_status ?? '');
                        $ethnic_group = ucfirst($essential->ethnic_group ?? '');
                        $gender = ucfirst($essential->gender ?? '');
                        $education_level = $this->getEducationLevel($essential->education_level ?? '');
            
                        $personal_income = $this->getIncome($essential->personal_income_per_month ?? '');
                        $household_income = $this->getIncome($essential->household_income_per_month ?? '');
            
                        $state = $this->getState($essential->province ?? '');
                        $district = $this->getDistrict($essential->suburb ?? '');
            
                        $opted_in = $this->formatDate($all_data->opted_in);
                        $updated_at = $this->formatDate($all_data->updated_at);
            
                        $sheet->fromArray([
                            $all_data->id, $basic->first_name ?? '', $basic->last_name ?? '', $mobile_number, $whatsapp_number,
                            $basic->email ?? '', $age, $relationshipStatus, $ethnic_group, $gender, $education_level,
                            $employment_status, $industry_my_company, $essential->job_title ?? '', $personal_income,
                            $essential->personal_income_per_month ?? '', $household_income, $essential->household_income_per_month ?? '',
                            $state, $district, $essential->metropolitan_area ?? '', $essential->no_houehold ?? '',
                            $essential->no_children ?? '', $essential->no_vehicle ?? '', $opted_in, $updated_at
                        ], null, 'A' . $rows);
            
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':Z' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':Z' . $rows)->getAlignment()->setIndent(1);
                        $rows++;
                    }
                } elseif ($resp_type == 'extended') {
                    $columns = range('Y', 'BD');
                    foreach ($columns as $column) {
                        $sheet->getColumnDimension($column)->setAutoSize(true);
                    }
            
                    $headers = [
                        'A1' => 'PID', 'B1' => 'First Name', 'C1' => 'Last Name', 'D1' => 'Mobile Number',
                        'E1' => 'WA Number', 'F1' => 'Email', 'G1' => 'Age', 'H1' => 'Relationship status',
                        'I1' => 'Ethnic Group / Race', 'J1' => 'Gender', 'K1' => 'Highest Education Level',
                        'L1' => 'Employment Status', 'M1' => 'Industry my company is in', 'N1' => 'Job Title',
                        'O1' => 'Personal Income per month', 'P1' => 'Personal LSM', 'Q1' => 'HHI per Month',
                        'R1' => 'Household LSM', 'S1' => 'Province', 'T1' => 'Metropolitan Area', 'U1' => 'Suburb',
                        'V1' => 'No. of people living in your household', 'W1' => 'Number of children',
                        'X1' => 'Number of vehicles', 'Y1' => 'Which best describes the role in your business / organization?',
                        'Z1' => 'What is the number of people in your organisation / company?', 'AA1' => 'Which bank do you bank with (which is your bank main)',
                        'AB1' => 'Which is your secondary bank?', 'AC1' => 'Home Language', 'AD1' => 'Secondary Language',
                        'AE1' => 'Child 1 - Birth Year', 'AF1' => 'Child 1 - Gender', 'AG1' => 'Child 2 - Birth Year',
                        'AH1' => 'Child 2 - Gender', 'AI1' => 'Child 3 - Birth Year', 'AJ1' => 'Child 3 - Gender',
                        'AK1' => 'Child 4 - Birth Year', 'AL1' => 'Child 4 - Gender', 'AM1' => 'Car 1 - Brand',
                        'AN1' => 'Car 1 - Type of Vehicle', 'AO1' => 'Car 1 - Model', 'AP1' => 'Car 1 - Year',
                        'AQ1' => 'Car 2 - Brand', 'AR1' => 'Car 2 - Type of Vehicle', 'AS1' => 'Car 2 - Model',
                        'AT1' => 'Car 2 - Year', 'AU1' => 'Car 3 - Brand', 'AV1' => 'Car 3 - Type of Vehicle',
                        'AW1' => 'Car 3 - Model', 'AX1' => 'Car 3 - Year', 'AY1' => 'Car 4 - Brand',
                        'AZ1' => 'Car 4 - Type of Vehicle', 'BA1' => 'Car 4 - Model', 'BB1' => 'Car 4 - Year',
                        'BC1' => 'Opted in', 'BD1' => 'Last Updated'
                    ];
            
                    foreach ($headers as $cell => $value) {
                        $sheet->setCellValue($cell, $value);
                    }
            
                    $sheet->getStyle('A1:BD1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b');
                    $sheet->getStyle('A1:BD1')->applyFromArray($styleArray);
            
                    $rows = 2;
            
                    foreach ($all_datas as $all_data) {
                        $basic = json_decode($all_data->basic_details);
                        $essential = json_decode($all_data->essential_details);
                        $extended = json_decode($all_data->extended_details);
            
                        $mobile_number = $this->formatPhoneNumber($basic->mobile_number ?? '-');
                        $whatsapp_number = $this->formatPhoneNumber($basic->whatsapp_number ?? '-');
            
                        $dob = $basic->date_of_birth ?? '';
                        $age = $this->calculateAge($dob);
            
                        $employment_status = $this->getEmploymentStatus($essential->employment_status ?? '');
                        $industry_my_company =$this->getIndustryCompany($essential->industry_my_company ?? '');
            
                        $relationshipStatus = ucfirst($essential->relationship_status ?? '');
                        $ethnic_group = ucfirst($essential->ethnic_group ?? '');
                        $gender = ucfirst($essential->gender ?? '');
                        $education_level = $this->getEducationLevel($essential->education_level ?? '');
            
                        $personal_income = $this->getIncome($essential->personal_income_per_month ?? '');
                        $household_income = $this->getIncome($essential->household_income_per_month ?? '');
            
                        $state = $this->getState($essential->province ?? '');
                        $district = $this->getDistrict($essential->suburb ?? '');
            
                        $opted_in = $this->formatDate($all_data->opted_in);
                        $updated_at = $this->formatDate($all_data->updated_at);
            
                        $business_org_code = $extended->business_org ?? '';
                        if ($business_org_code === 'other') {
                            $business_org_code = $extended->business_org_other ?? 'Other';
                        }
            
                        $businessOrgTypes = [
                            'owner_director' => 'Owner / director (CEO, COO, CFO)', 'senior_manager' => 'Senior Manager',
                            'mid_level_manager' => 'Mid-Level Manager', 'team_leader' => 'Team leader / Supervisor',
                            'general_worker' => 'General Worker', 'worker_etc' => 'Worker', 'other' => 'Other'
                        ];
                        $business_org = $businessOrgTypes[$business_org_code] ?? ucfirst($business_org_code);
            
                        $org_company_code = $extended->org_company ?? '';
                        $orgCompanyTypes = [
                            'just_me' => 'Just Me', '2_5' => '2-5 people', '6_10' => '6-10 people',
                            '11_20' => '11-20 people', '21_30' => '21-30 people', '31_50' => '31-50 people',
                            '51_100' => '51-100 people', '101_250' => '101-250 people', '251_500' => '251-500 people',
                            '500_1000' => '500-1000 people', 'more_than_1000' => 'More than 1000 people'
                        ];
                        $org_company = $orgCompanyTypes[$org_company_code] ?? '';
            
                        $home_lang = $extended->home_lang ?? '';
                        if ($home_lang === 'other') {
                            $home_lang = $extended->home_lang_other ?? '';
                        }
            
                        $secondary_home_lang = $extended->secondary_home_lang ?? '';
                        if ($secondary_home_lang === 'other') {
                            $secondary_home_lang = $extended->secondary_home_lang_other ?? '';
                        }
            
                        $bank_main = $extended->bank_main ?? '';
                        if ($bank_main === 'other') {
                            $bank_main = $extended->bank_main_other ?? '';
                        } else {
                            $bank = DB::table('banks')->where('id', $bank_main)->where('active', 1)->first();
                            $bank_main = $bank->bank_name ?? '';
                        }
            
                        $secondary_bank_main = $extended->bank_secondary ?? '';
                        if ($secondary_bank_main === 'other') {
                            $secondary_bank_main = $extended->bank_secondary_other ?? '';
                        } else {
                            $bank = DB::table('banks')->where('id', $secondary_bank_main)->where('active', 1)->first();
                            $secondary_bank_main = $bank->bank_name ?? '';
                        }
            
                        $sheet->fromArray([
                            $all_data->id, $basic->first_name ?? '', $basic->last_name ?? '', $mobile_number, $whatsapp_number,
                            $basic->email ?? '', $age, $relationshipStatus, $ethnic_group, $gender, $education_level,
                            $employment_status, $industry_my_company, $essential->job_title ?? '', $personal_income,
                            $essential->personal_income_per_month ?? '', $household_income, $essential->household_income_per_month ?? '',
                            $state, $district, $essential->metropolitan_area ?? '', $essential->no_houehold ?? '',
                            $essential->no_children ?? '', $essential->no_vehicle ?? '', $business_org, $org_company,
                            $bank_main, $secondary_bank_main, ucfirst($home_lang), ucfirst($secondary_home_lang)
                        ], null, 'A' . $rows);
            
                        $children_data = json_decode($all_data->children_data, true) ?? [];
                        if (!empty($children_data) && is_array($children_data)) {
                            $child_columns = range('AE', 'AL');
                            foreach ($children_data as $index => $child) {
                                if (isset($child_columns[$index * 2])) {
                                    $sheet->setCellValue($child_columns[$index * 2] . $rows, $child['date'] ?? '');
                                    $sheet->setCellValue($child_columns[$index * 2 + 1] . $rows, ucfirst($child['gender'] ?? ''));
                                }
                            }
                        }
            
                        $vehicle_data = json_decode($all_data->vehicle_data, true) ?? [];
                        $vehicle_columns = range('AM', 'BD');
                        foreach ($vehicle_data as $index => $vehicle) {
                            if (isset($vehicle_columns[$index * 4])) {
                                $brand_id = $vehicle['brand'];
                                $get_vehicle = DB::table('vehicle_master')->where('id', $brand_id)->first();
                                $vehicle_name = $get_vehicle->vehicle_name ?? '-';
                                $sheet->setCellValue($vehicle_columns[$index * 4] . $rows, $vehicle_name);
                                $sheet->setCellValue($vehicle_columns[$index * 4 + 1] . $rows, $vehicle['type'] ?? '');
                                $sheet->setCellValue($vehicle_columns[$index * 4 + 2] . $rows, ucfirst($vehicle['model'] ?? ''));
                                $sheet->setCellValue($vehicle_columns[$index * 4 + 3] . $rows, $vehicle['year'] ?? '');
                            }
                        }
            
                        $sheet->setCellValue('BC' . $rows, $opted_in);
                        $sheet->setCellValue('BD' . $rows, $updated_at);
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':BD' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':BD' . $rows)->getAlignment()->setIndent(1);
                        $rows++;
                    }
                }
            
                $fileName = $module . "_" . $resp_type . "_" . date('ymd') . "." . $type;
            }

        } catch (Exception $e) {
            $errorMessage = sprintf(
                "Error: %s in %s on line %d",
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
        
            // Throw a new exception with the formatted message
            throw new \Exception($errorMessage);
        }
}
}