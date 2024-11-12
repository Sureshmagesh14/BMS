<?php

namespace App\Http\Controllers;

use App\Models\Cashout;
use App\Models\Projects;
use App\Models\Respondents;
use App\Models\UserEvents;
use App\Models\SurveyResponse;
use App\Models\Survey;
use App\Models\Questions;
use DB;
use Exception;
use Illuminate\Http\Request;
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

            $module       = $request->module;
            $resp_status  = $request->resp_status;
            $resp_type    = $request->show_resp_type;
            $from         = ($request->start != null) ? date('Y-m-d', strtotime($request->start)) : null;
            $to           = ($request->end != null) ? date('Y-m-d', strtotime($request->end)) : null;
            $type_method  = $request->type_method;
            $type_resp    = $request->type_resp;
            $cashout_type = $request->show_cashout_val;

            //dd($module);

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
                        $basic = json_decode($all_data->basic_details, true);
                        $essential = json_decode($all_data->essential_details, true);
                    
                        // Check if $basic is null, if so, set default values

                        $mobile_number = '-';
                        if (!empty($basic['mobile_number'])) {
                            $m_number =  preg_replace('/\s+/', '',$basic['mobile_number']);
                           
                            $length = strlen($m_number);
                            if (strlen($m_number) == 9) {
                                $mobile_number = '27' . $m_number;
                            }else if ($length == 10 && $m_number[0] == '0'){
                                $mobile_number = '27' . substr($m_number, 1);
                            } 
                            elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                                $mobile_number = $m_number;
                            } elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                                $mobile_number = $m_number;
                            }
                        }

                       

                        $whatsapp_number = '-';
                        if (!empty($basic['whatsapp_number'])) {
                            
                            $w_number =  preg_replace('/\s+/', '',$basic['whatsapp_number']);
                            $length = strlen($w_number);
                            if (strlen($w_number) == 9) {
                                $whatsapp_number = '27' . $w_number;
                            } else if ($length == 10 && $w_number[0] == '0'){
                                $whatsapp_number = '27' . substr($w_number, 1);
                            }
                            elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                                $whatsapp_number = $w_number;
                            } elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                                $whatsapp_number = $w_number;
                            }
                        }

                       

                        $id = $all_data->id ?? '-';
                        $first_name = $basic['first_name'] ?? '-';
                        $last_name = $basic['last_name'] ?? '-';
                        $email = $basic['email'] ?? '-';
                        $dob = $basic['date_of_birth'] ?? '-';
                        $age = ''; // Set initial age to empty
                        
                        $get_resp = Respondents::select('date_of_birth')->where('id', $all_data->id)->first();
                        if ($get_resp != null) {
                            if (!empty($get_resp->date_of_birth)) {
                                $dob = $get_resp->date_of_birth;
                        
                                $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
                                if ($dobDate) {
                                    $now = new DateTime();
                                    $age = $now->diff($dobDate)->y; // Get the difference in years
                                }
                            } else {
                                $dob = ''; // Handle the case where there's no date of birth found
                            }
                        } else {
                            if (empty($dob) || $dob === '0000-00-00') {
                                $dobDate = DateTime::createFromFormat('Y/m/d', $dob);
                                if ($dobDate) {
                                    $now = new DateTime();
                                    $age = $now->diff($dobDate)->y; // Get the difference in years
                                } else {
                                    $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
                                    if ($dobDate) {
                                        $now = new DateTime();
                                        $age = $now->diff($dobDate)->y; // Get the difference in years
                                    }
                                }
                            }
                        }
                        
                        // Ensure age is empty if dob is not set or invalid
                        if (empty($dob) || $dob === '0000-00-00') {
                            $age = ''; // Set age to empty if date of birth is empty or invalid
                        }
                    
                        // Set cell values
                        $sheet->setCellValue('A' . $rows, $id);
                        $sheet->setCellValue('B' . $rows, $first_name);
                        $sheet->setCellValue('C' . $rows, $last_name);
                        $sheet->setCellValue('D' . $rows, $mobile_number);
                        $sheet->setCellValue('E' . $rows, $whatsapp_number);
                        $sheet->setCellValue('F' . $rows, $email);
                        $sheet->setCellValue('G' . $rows, $age);
                        $sheet->setCellValue('H' . $rows, $dob ?: '-');
                    
                        // Set row height
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                    
                        // Apply styles
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
                    $sheet->setCellValue('H1', 'Relationship Status'); // Fixed spacing
                    $sheet->setCellValue('I1', 'Ethnic Group / Race');
                    $sheet->setCellValue('J1', 'Gender');
                    $sheet->setCellValue('K1', 'Highest Education Level');
                    $sheet->setCellValue('L1', 'Employment Status');
                    $sheet->setCellValue('M1', 'Industry my company is in');
                    $sheet->setCellValue('N1', 'Job Title');
                    $sheet->setCellValue('O1', 'Personal Income per month');
                    $sheet->setCellValue('P1', 'Personal LSM'); // Corrected to unique column
                    $sheet->setCellValue('Q1', 'HHI per month'); // Corrected to unique column
                    $sheet->setCellValue('R1', 'Household LSM'); // Corrected to unique column
                    $sheet->setCellValue('S1', 'Province');
                    $sheet->setCellValue('T1', 'Area');
                    $sheet->setCellValue('U1', 'No. of people living in your household');
                    $sheet->setCellValue('V1', 'Number of children');
                    $sheet->setCellValue('W1', 'Number of vehicles');
                    $sheet->setCellValue('X1', 'Opted in'); // Moved Opted in to column X
                    $sheet->setCellValue('Y1', 'Last Updated'); // Moved Last Updated to column Y


                    $sheet->getStyle('A1:Y1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:Y1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i = 1;

                    foreach ($all_datas as $all_data) {
                  
                        $basic = json_decode($all_data->basic_details);
                        $essential = json_decode($all_data->essential_details);

                        $mobile_number = '-';
                        if (!empty($basic->mobile_number)) {
                            
                            $m_number = preg_replace('/\s+/', '',$basic->mobile_number);
                            $length = strlen($m_number);
                            if (strlen($m_number) == 9) {
                                $mobile_number = '27' . $m_number;
                            } else if ($length == 10 && $m_number[0] == '0'){
                                $mobile_number = '27' . substr($m_number, 1);
                            }elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                                $mobile_number = $m_number;
                            } elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                                $mobile_number = $m_number;
                            }
                        }

                       

                        $whatsapp_number = '-';
                        if (!empty($basic->whatsapp_number)) {
                            
                            $w_number = preg_replace('/\s+/', '',$basic->whatsapp_number);
                            $length = strlen($w_number);
                            if (strlen($w_number) == 9) {
                                $whatsapp_number = '27' . $w_number;
                            } else if ($length == 10 && $w_number[0] == '0'){
                                $whatsapp_number = '27' . substr($w_number, 1);
                            }
                            elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                                $whatsapp_number = $w_number;
                            } elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                                $whatsapp_number = $w_number;
                            }
                        }

                      

                        $sheet->setCellValue('A' . $rows, $all_data->id);
                        $sheet->setCellValue('B' . $rows, $basic->first_name ?? '');
                        $sheet->setCellValue('C' . $rows, $basic->last_name ?? '');
                        $sheet->setCellValue('D' . $rows, $mobile_number ?? '');
                        $sheet->setCellValue('E' . $rows, $whatsapp_number ?? '');
                        $sheet->setCellValue('F' . $rows, $basic->email ?? '');
                        $dob = $basic->date_of_birth ?? '';
                        $age = ''; // Set initial age to empty
                        
                        $get_resp = Respondents::select('date_of_birth')->where('id', $all_data->id)->first();
                        if ($get_resp != null) {
                            if (!empty($get_resp->date_of_birth)) {
                                $dob = $get_resp->date_of_birth;
                        
                                $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
                                if ($dobDate) {
                                    $now = new DateTime();
                                    $age = $now->diff($dobDate)->y; // Get the difference in years
                                }
                            } else {
                                $dob = ''; // Handle the case where there's no date of birth found
                            }
                        } else {
                            if (empty($dob) || $dob === '0000-00-00') {
                                $dobDate = DateTime::createFromFormat('Y/m/d', $dob);
                                if ($dobDate) {
                                    $now = new DateTime();
                                    $age = $now->diff($dobDate)->y; // Get the difference in years
                                } else {
                                    $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
                                    if ($dobDate) {
                                        $now = new DateTime();
                                        $age = $now->diff($dobDate)->y; // Get the difference in years
                                    }
                                }
                            }
                        }
                        
                        // Ensure age is empty if dob is not set or invalid
                        if (empty($dob) || $dob === '0000-00-00') {
                            $age = ''; // Set age to empty if date of birth is empty or invalid
                        }
                        
                      

                        $employment_status = null; // Initialize $employment_status to null

                        if ($essential && isset($essential->employment_status)) {
                            $employment_status = ($essential->employment_status == 'other') ? $essential->employment_status_other : $essential->employment_status;
                        }
                        
                        $industry_my_company = null; // Initialize $industry_my_company to null

                        if ($essential && isset($essential->industry_my_company)) {
                            $industry_my_company = ($essential->industry_my_company == 'other') ? $essential->industry_my_company_other : $essential->industry_my_company;
                        }

                       
                        $sheet->setCellValue('G' . $rows, $age);
                        $relationshipStatus = $essential->relationship_status ?? '';
                        $sheet->setCellValue('H' . $rows, ucfirst($relationshipStatus));
                        // Define the mapping of ethnic group codes to names
                       // Define the mapping of ethnic group codes to names
                        $ethnicGroups = [
                            'asian'   => 'Asian',
                            'black'   => 'Black',
                            'coloured'=> 'Coloured',
                            'indian'  => 'Indian',
                            'white'   => 'White'
                        ];

                        // Default to an empty string if $essential is null or ethnic group is not found
                        $ethnic_group = '';
                        if ($essential && isset($essential->ethnic_group)) {
                            $ethnic_group = ucfirst($essential->ethnic_group) ?? '';
                        }

                        // Set the value in the spreadsheet
                        $sheet->setCellValue('I' . $rows, $ethnic_group);

                        $education_level = '';

                        // Check if $essential is not null and has the education_level property
                        if ($essential && isset($essential->education_level)) {
                            switch ($essential->education_level) {
                                case 'matric':
                                    $education_level = 'Matric';
                                    break;
                                case 'post_matric_courses':
                                    $education_level = 'Post Matric Courses / Higher Certificate';
                                    break;
                                case 'post_matric_diploma':
                                    $education_level = 'Post Matric Diploma';
                                    break;
                                case 'ug':
                                    $education_level = 'Undergrad University Degree';
                                    break;
                                case 'pg':
                                    $education_level = 'Post Grad Degree - Honours, Masters, PhD, MBA';
                                    break;
                                case 'school_no_metric':
                                    $education_level = 'School But No Matric';
                                    break;
                                default:
                                    $education_level = ''; // Handle unexpected values
                                    break;
                            }
                        }
                        // Initialize the gender variable with a default value
                        $gender = '';

                        // Check if $essential is not null and has the gender property
                        if ($essential && isset($essential->gender)) {
                            // Set the gender value, ensuring it's properly capitalized
                            $gender = ucfirst($essential->gender);
                        }
                        $sheet->setCellValue('J' . $rows, $gender);
                        $sheet->setCellValue('K' . $rows, $education_level);
                        $employment_status = '';

                        // Check if $essential is not null and has the employment_status property
                        if ($essential && isset($essential->employment_status)) {
                            switch ($essential->employment_status) {
                                case 'emp_full_time':
                                    $employment_status = 'Employed Full-Time';
                                    break;
                                case 'emp_part_time':
                                    $employment_status = 'Employed Part-Time';
                                    break;
                                case 'self':
                                    $employment_status = 'Self-Employed';
                                    break;
                                case 'study':
                                    $employment_status = 'Studying Full-Time (Not Working)';
                                    break;
                                case 'working_and_studying':
                                    $employment_status = 'Working & Studying';
                                    break;
                                case 'home_person':
                                    $employment_status = 'Stay at Home Person';
                                    break;
                                case 'retired':
                                    $employment_status = 'Retired';
                                    break;
                                case 'unemployed':
                                    $employment_status = 'Unemployed';
                                    break;
                                case 'other':
                                    $employment_status = 'Other';
                                    break;
                                default:
                                    $employment_status = ''; // Handle unexpected values
                                    break;
                            }
                        }
                        $sheet->setCellValue('L' . $rows, $employment_status);
                        $industry = IndustryCompany::find($industry_my_company);
                        $companyName = $industry ? $industry->company : '';
                        $sheet->setCellValue('M' . $rows, $companyName);
                        $sheet->setCellValue('N' . $rows, $essential->job_title ?? '');
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
                        $sheet->setCellValue('O' . $rows, $personal_income);


                        $personalIncome = '';
                        if ($essential !== null && isset($essential->personal_income_per_month)) {
                            $personalIncome = $essential->personal_income_per_month;
                        }
                        $sheet->setCellValue('P' . $rows, $personalIncome);
                        
                    
                        $sheet->setCellValue('Q' . $rows, $household_income);
                        $householdIncome = '';
                        if ($essential !== null && isset($essential->household_income_per_month)) {
                            $householdIncome = $essential->household_income_per_month;
                        }
                        $sheet->setCellValue('R' . $rows, $householdIncome);


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
                      
                        $sheet->setCellValue('S' . $rows, $get_state ?? '');
                        $sheet->setCellValue('T' . $rows, $get_district ?? '');
                        $sheet->setCellValue('U' . $rows, $essential->no_houehold ?? '');
                        $sheet->setCellValue('V' . $rows, $essential->no_children ?? '');
                        $sheet->setCellValue('W' . $rows, $essential->no_vehicle ?? '');

                        $opted_in = ($all_data->opted_in != null) ? date("d-m-Y", strtotime($all_data->opted_in)) : '';
                        $updated_at = ($all_data->updated_at != null) ? date("d-m-Y", strtotime($all_data->updated_at)) : '';

                        $sheet->setCellValue('X' . $rows, $opted_in);
                        $sheet->setCellValue('Y' . $rows, $updated_at);
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':Y' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':Y' . $rows)->getAlignment()->setIndent(1);
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
                    $sheet->getColumnDimension('AQ')->setAutoSize(true);
                    $sheet->getColumnDimension('AR')->setAutoSize(true);
                    $sheet->getColumnDimension('AS')->setAutoSize(true);
                    $sheet->getColumnDimension('AT')->setAutoSize(true);
                    $sheet->getColumnDimension('AU')->setAutoSize(true);
                    $sheet->getColumnDimension('AV')->setAutoSize(true);
                    $sheet->getColumnDimension('AW')->setAutoSize(true);
                    $sheet->getColumnDimension('AX')->setAutoSize(true);
                    $sheet->getColumnDimension('AY')->setAutoSize(true);
                    $sheet->getColumnDimension('AZ')->setAutoSize(true);
                    $sheet->getColumnDimension('AX')->setAutoSize(true);
                    $sheet->getColumnDimension('BA')->setAutoSize(true);
                    $sheet->getColumnDimension('BB')->setAutoSize(true);
                    $sheet->getColumnDimension('BC')->setAutoSize(true);
                    $sheet->getColumnDimension('BD')->setAutoSize(true);
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
                    $sheet->setCellValue('P1', 'Personal LSM');
                    $sheet->setCellValue('Q1', 'HHI per Month');
                    $sheet->setCellValue('R1', 'Household LSM');
                    $sheet->setCellValue('S1', 'Province');
                    $sheet->setCellValue('T1', 'Suburb');
                    $sheet->setCellValue('U1', 'Metropolitan Area');
                    $sheet->setCellValue('V1', 'No. of people living in your household');
                    $sheet->setCellValue('W1', 'Number of children');
                    $sheet->setCellValue('X1', 'Number of vehicles');
                    $sheet->setCellValue('Y1', 'Which best describes the role in your business / organization?');
                    $sheet->setCellValue('Z1', 'What is the number of people in your organisation / company?');
                    $sheet->setCellValue('AA1', 'Which bank do you bank with (which is your bank main)');
                    $sheet->setCellValue('AB1', 'Which is your secondary bank?');
                    $sheet->setCellValue('AC1', 'Home Language');
                    $sheet->setCellValue('AD1', 'Secondary Language');
                    
                    // Child 1
                    $sheet->setCellValue('AE1', 'Child 1 - Birth Year');
                    $sheet->setCellValue('AF1', 'Child 1 - Gender');
                    
                    // Child 2
                    $sheet->setCellValue('AG1', 'Child 2 - Birth Year');
                    $sheet->setCellValue('AH1', 'Child 2 - Gender');
                    
                    // Child 3
                    $sheet->setCellValue('AI1', 'Child 3 - Birth Year');
                    $sheet->setCellValue('AJ1', 'Child 3 - Gender');
                    
                    // Child 4
                    $sheet->setCellValue('AK1', 'Child 4 - Birth Year');
                    $sheet->setCellValue('AL1', 'Child 4 - Gender');
                    
                    // Car 1
                    $sheet->setCellValue('AM1', 'Car 1 - Brand');
                    $sheet->setCellValue('AN1', 'Car 1 - Type of Vehicle');
                    $sheet->setCellValue('AO1', 'Car 1 - Model');
                    $sheet->setCellValue('AP1', 'Car 1 - Year');
                    
                    // Car 2
                    $sheet->setCellValue('AQ1', 'Car 2 - Brand');
                    $sheet->setCellValue('AR1', 'Car 2 - Type of Vehicle');
                    $sheet->setCellValue('AS1', 'Car 2 - Model');
                    $sheet->setCellValue('AT1', 'Car 2 - Year');
                    
                    // Car 3
                    $sheet->setCellValue('AU1', 'Car 3 - Brand');
                    $sheet->setCellValue('AV1', 'Car 3 - Type of Vehicle');
                    $sheet->setCellValue('AW1', 'Car 3 - Model');
                    $sheet->setCellValue('AX1', 'Car 3 - Year');
                    
                    // Car 4
                    $sheet->setCellValue('AY1', 'Car 4 - Brand');
                    $sheet->setCellValue('AZ1', 'Car 4 - Type of Vehicle');
                    $sheet->setCellValue('BA1', 'Car 4 - Model');
                    $sheet->setCellValue('BB1', 'Car 4 - Year');
                    
                    // Additional columns
                    $sheet->setCellValue('BC1', 'Opted in');
                    $sheet->setCellValue('BD1', 'Last Updated');
                    
                    

                    $sheet->getStyle('A1:BD1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:BD1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i = 1;
                    
                    foreach ($all_datas as $all_data) {
                        $basic = json_decode($all_data->basic_details);
                        $essential = json_decode($all_data->essential_details);
                        $extended = json_decode($all_data->extended_details);

                        $mobile_number = '-';
                        if (!empty($basic->mobile_number)) {
                           
                            $m_number = preg_replace('/\s+/', '',$basic->mobile_number);
                            $length = strlen($m_number);
                            if (strlen($m_number) == 9) {
                                $mobile_number = '27' . $m_number;
                            } else if ($length == 10 && $m_number[0] == '0'){
                                $mobile_number = '27' . substr($m_number, 1);
                            }elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                                $mobile_number = $m_number;
                            } elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                                $mobile_number = $m_number;
                            }
                        }

                       

                        $whatsapp_number = '-';
                        if (!empty($basic->whatsapp_number)) {
                           
                            $w_number = preg_replace('/\s+/', '',$basic->whatsapp_number);
                            $length = strlen($w_number);
                            if (strlen($w_number) == 9) {
                                $whatsapp_number = '27' . $w_number;
                            } else if ($length == 10 && $w_number[0] == '0'){
                                $whatsapp_number = '27' . substr($w_number, 1);
                            }
                            elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                                $whatsapp_number = $w_number;
                            } elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                                $whatsapp_number = $w_number;
                            }
                        }

                        

                        $sheet->setCellValue('A' . $rows, $all_data->id);
                        $sheet->setCellValue('B' . $rows, $basic->first_name ?? '');
                        $sheet->setCellValue('C' . $rows, $basic->last_name ?? '');
                        $sheet->setCellValue('D' . $rows, $mobile_number ?? '');
                        $sheet->setCellValue('E' . $rows, $whatsapp_number ?? '');
                        $sheet->setCellValue('F' . $rows, $basic->email ?? '');
                    
                        $dob = $basic->date_of_birth ?? '';
                        $age = ''; // Set initial age to empty
                        
                        $get_resp = Respondents::select('date_of_birth')->where('id', $all_data->id)->first();
                        if ($get_resp != null) {
                            if (!empty($get_resp->date_of_birth)) {
                                $dob = $get_resp->date_of_birth;
                        
                                $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
                                if ($dobDate) {
                                    $now = new DateTime();
                                    $age = $now->diff($dobDate)->y; // Get the difference in years
                                }
                            } else {
                                $dob = ''; // Handle the case where there's no date of birth found
                            }
                        } else {
                            if (empty($dob) || $dob === '0000-00-00') {
                                $dobDate = DateTime::createFromFormat('Y/m/d', $dob);
                                if ($dobDate) {
                                    $now = new DateTime();
                                    $age = $now->diff($dobDate)->y; // Get the difference in years
                                } else {
                                    $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
                                    if ($dobDate) {
                                        $now = new DateTime();
                                        $age = $now->diff($dobDate)->y; // Get the difference in years
                                    }
                                }
                            }
                        }
                        
                        // Ensure age is empty if dob is not set or invalid
                        if (empty($dob) || $dob === '0000-00-00') {
                            $age = ''; // Set age to empty if date of birth is empty or invalid
                        }
                        
                   
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
                    
                        $sheet->setCellValue('G' . $rows, $age);
                        $relationship_status = ucfirst($essential->relationship_status ?? '');
                        $sheet->setCellValue('H' . $rows, $relationship_status);
                       // Define the mapping of ethnic group codes to names
                        $ethnicGroups = [
                            'asian'   => 'Asian',
                            'black'   => 'Black',
                            'coloured'=> 'Coloured',
                            'indian'  => 'Indian',
                            'white'   => 'White'
                        ];

                        // Initialize the ethnic_group variable with a default value
                        $ethnic_group = '';

                        // Check if $essential is not null and has the ethnic_group property
                        if ($essential && isset($essential->ethnic_group)) {
                            
                            $ethnic_group = ucfirst($essential->ethnic_group) ?? '';
                        }

                        // Set the cell value
                        $sheet->setCellValue('I' . $rows, $ethnic_group); // Adjust the cell reference as needed

                         // Initialize the gender variable with a default value
                         $gender = '';

                         // Check if $essential is not null and has the gender property
                         if ($essential && isset($essential->gender)) {
                             // Set the gender value, ensuring it's properly capitalized
                             $gender = ucfirst($essential->gender);
                         }

                        $sheet->setCellValue('J' . $rows, $gender);

                        $education_level = '';

                        // Check if $essential is not null and has the education_level property
                        if ($essential && isset($essential->education_level)) {
                            switch ($essential->education_level) {
                                case 'matric':
                                    $education_level = 'Matric';
                                    break;
                                case 'post_matric_courses':
                                    $education_level = 'Post Matric Courses / Higher Certificate';
                                    break;
                                case 'post_matric_diploma':
                                    $education_level = 'Post Matric Diploma';
                                    break;
                                case 'ug':
                                    $education_level = 'Undergrad University Degree';
                                    break;
                                case 'pg':
                                    $education_level = 'Post Grad Degree - Honours, Masters, PhD, MBA';
                                    break;
                                case 'school_no_metric':
                                    $education_level = 'School But No Matric';
                                    break;
                                default:
                                    $education_level = ''; // Handle unexpected values
                                    break;
                            }
                        }
                        $sheet->setCellValue('K' . $rows, $education_level);
                        $employment_status = '';

                        // Check if $essential is not null and has the employment_status property
                        if ($essential && isset($essential->employment_status)) {
                            switch ($essential->employment_status) {
                                case 'emp_full_time':
                                    $employment_status = 'Employed Full-Time';
                                    break;
                                case 'emp_part_time':
                                    $employment_status = 'Employed Part-Time';
                                    break;
                                case 'self':
                                    $employment_status = 'Self-Employed';
                                    break;
                                case 'study':
                                    $employment_status = 'Studying Full-Time (Not Working)';
                                    break;
                                case 'working_and_studying':
                                    $employment_status = 'Working & Studying';
                                    break;
                                case 'home_person':
                                    $employment_status = 'Stay at Home Person';
                                    break;
                                case 'retired':
                                    $employment_status = 'Retired';
                                    break;
                                case 'unemployed':
                                    $employment_status = 'Unemployed';
                                    break;
                                case 'other':
                                    $employment_status = 'Other';
                                    break;
                                default:
                                    $employment_status = ''; // Handle unexpected values
                                    break;
                            }
                        }
                        $sheet->setCellValue('L' . $rows, $employment_status);
                        $industry = IndustryCompany::find($industry_my_company);
                        $companyName = $industry ? $industry->company : '';
                        $sheet->setCellValue('M' . $rows, $companyName);
                        $sheet->setCellValue('N' . $rows, $essential->job_title ?? '');
                        $sheet->setCellValue('O' . $rows, $personal_income ?? '');
                        $personalIncome = '';
                        if ($essential !== null && isset($essential->personal_income_per_month)) {
                            $personalIncome = $essential->personal_income_per_month;
                        }
                        $sheet->setCellValue('P' . $rows, $personalIncome);
                        
                        $sheet->setCellValue('Q' . $rows, $household_income ?? '');
                        $householdIncome = '';
                        if ($essential !== null && isset($essential->household_income_per_month)) {
                            $householdIncome = $essential->household_income_per_month;
                        }
                        $sheet->setCellValue('R' . $rows, $householdIncome);

                    
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
                    
                        $sheet->setCellValue('S' . $rows, $get_state ?? '');
                        $sheet->setCellValue('T' . $rows, $get_district ?? '');
                        $sheet->setCellValue('U' . $rows, $essential->metropolitan_area ?? '');
                        $sheet->setCellValue('V' . $rows, $essential->no_houehold ?? '');
                        $sheet->setCellValue('W' . $rows, $essential->no_children ?? '');
                        $sheet->setCellValue('X' . $rows, $essential->no_vehicle ?? '');
                    
                                            
                        // Initialize $business_org to null
                        $business_org = null;

                        // Ensure $extended is defined and has the property
                        if (isset($extended) && is_object($extended)) {
                            if (isset($extended->business_org)) {
                                // Check if the business_org is 'other' and use the additional information if available
                                if ($extended->business_org === 'other') {
                                    // Use the business_org_other value if it exists
                                    $business_org_code = isset($extended->business_org_other) ? $extended->business_org_other : 'Other';
                                } else {
                                    $business_org_code = $extended->business_org;
                                }
                            } else {
                                // Default to an empty string if business_org is not set
                                $business_org_code = '';
                            }
                        } else {
                            // Default to an empty string if $extended is not an object or is null
                            $business_org_code = '';
                        }

                        // Define the mapping of business organization codes to names
                        $businessOrgTypes = [
                            'owner_director'  => 'Owner / director (CEO, COO, CFO)',
                            'senior_manager'  => 'Senior Manager',
                            'mid_level_manager'=> 'Mid-Level Manager',
                            'team_leader'     => 'Team leader / Supervisor',
                            'general_worker'  => 'General Worker (e.g., Admin, Call Centre Agent, Nurse, Teacher, Carer, etc.)',
                            'worker_etc'      => 'Worker (e.g., Security Guard, Cleaner, Helper, etc.)',
                            'other'           => 'Other', // Default 'Other' mapping
                        ];

                        // Retrieve the business organization name based on the code
                        $business_org = isset($businessOrgTypes[$business_org_code]) ? $businessOrgTypes[$business_org_code] : ucfirst($business_org_code);

                                                // Initialize $org_company to null
                       // Initialize $org_company to null
          
                        // Initialize $org_company to null
                        $org_company = null;

                        // Ensure $extended is defined and is an object
                        if (isset($extended) && is_object($extended)) {
                            // Check if 'org_company' is set and assign its value
                            if (isset($extended->org_company)) {
                                $org_company_code = $extended->org_company;
                            } else {
                                // Default to an empty string if 'org_company' is not set
                                $org_company_code = '';
                            }
                        } else {
                            // Default to an empty string if $extended is not set or not an object
                            $org_company_code = '';
                        }

                        // Define the mapping of organization sizes to names
                        $orgCompanyTypes = [
                            'just_me'        => 'Just Me (Sole Proprietor)',
                            '2_5'            => '2-5 people',
                            '6_10'           => '6-10 people',
                            '11_20'          => '11-20 people',
                            '21_30'          => '21-30 people',
                            '31_50'          => '31-50 people',
                            '51_100'         => '51-100 people',
                            '101_250'        => '101-250 people',
                            '251_500'        => '251-500 people',
                            '500_1000'       => '500-1000 people',
                            'more_than_1000' => 'More than 1000 people',
                        ];

                        // Debug: Check the value of $org_company_code
                        // dd($org_company_code);

                        // Retrieve the organization size name based on the code
                        $org_company = isset($orgCompanyTypes[$org_company_code]) ? $orgCompanyTypes[$org_company_code] : '';
                        
                    
                        $home_lang = null; // Initialize $home_lang to null
                    
                        if ($extended && isset($extended->home_lang)) {
                            $home_lang = $extended->home_lang == 'other' ? $extended->home_lang_other : $extended->home_lang;
                        }

                        $secondary_home_lang = null; // Initialize $home_lang to null
                    
                        if ($extended && isset($extended->secondary_home_lang)) {
                            $secondary_home_lang = $extended->secondary_home_lang == 'other' ? $extended->secondary_home_lang_other : $extended->secondary_home_lang;
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

                        $secondary_bank_main = null; // Initialize $bank_main to null
                    
                        if ($extended && isset($extended->bank_secondary)) {
                            if ($extended->bank_secondary == 'other') {
                                $secondary_bank_main = $extended->bank_secondary_other;
                            } else {
                                $banks = DB::table('banks')
                                            ->where('id', $extended->bank_secondary)
                                            ->where('active', 1)
                                            ->first();
                                if ($banks) {
                                    $secondary_bank_main = $banks->bank_name;
                                }
                            }
                        }
                    
                        $sheet->setCellValue('Y' . $rows, $business_org ?? '');
                        $sheet->setCellValue('Z' . $rows, $org_company ?? '');
                        $sheet->setCellValue('AA' . $rows, $bank_main ?? '');
                        $sheet->setCellValue('AB' . $rows, $secondary_bank_main ?? '');
                        $sheet->setCellValue('AC' . $rows, ucfirst($home_lang?? ''));
                        $sheet->setCellValue('AD' . $rows, ucfirst($secondary_home_lang?? ''));
                        // Handle $children_data
                        $new_alpha = 'AE';
                        if (!empty($children_data) && is_array($children_data)) {
                            foreach ($children_data as $children) {
                                $sheet->setCellValue($new_alpha . $rows, $children['date'] ?? '');
                                $new_alpha++;
                                $sheet->setCellValue($new_alpha . $rows, ucfirst($children['gender']) ?? '');
                                $new_alpha++;
                            }
                        }
                    
                        $children_data = json_decode($all_data->children_data, true) ?? [];
                        $vehicle_data = json_decode($all_data->vehicle_data, true) ?? [];
                        $vehicle_alpha = 'AM';
                        
                        foreach ($vehicle_data as $vehicle) {
                            $brand_id = $vehicle['brand'];
                        
                            // Debugging line to check $brand_id
               
                        
                            $get_vehicle = DB::table('vehicle_master')->where('id', $brand_id)->first();
                      
                        
                            $vehicle_name = $get_vehicle ? $get_vehicle->vehicle_name : '-';
                            
                            // Debugging line to check $vehicle_name
                         
                        
                            $sheet->setCellValue($vehicle_alpha . $rows, $vehicle_name);
                            $vehicle_alpha++;
                            $sheet->setCellValue($vehicle_alpha . $rows, $vehicle['type'] ?? '');
                            $vehicle_alpha++;
                            $brand = '';
                            if (isset($vehicle) && is_array($vehicle) && isset($vehicle['brand'])) {
                                $brand = ucfirst($vehicle['brand']);
                            }
                            $sheet->setCellValue($vehicle_alpha . $rows, $brand);
                            $vehicle_alpha++;
                            $sheet->setCellValue($vehicle_alpha . $rows, $vehicle['year'] ?? '');
                            $vehicle_alpha++;
                        }
                        
                        
                        
                    
                        $opted_in = ($all_data->opted_in != null) ? date("d-m-Y", strtotime($all_data->opted_in)) : '';
                        $updated_at = ($all_data->updated_at != null) ? date("d-m-Y", strtotime($all_data->updated_at)) : '';
                    
                        $sheet->setCellValue('BC' . $rows, $opted_in);
                        $sheet->setCellValue('BD' . $rows, $updated_at);
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':BD' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':BD' . $rows)->getAlignment()->setIndent(1);
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

                    $all_datas = Respondents::where('respondents.active_status_id','=',2);
                    
                    if($respondents != ""){
                        $all_datas = $all_datas->whereIn('respondents.id', [$respondents]);
                    }

                  
                        
                    $all_datas = $all_datas->orderBy('respondents.id', 'ASC')->get();

                    foreach ($all_datas as $all_data) {
                        $mobile_number = '-';
                        if (!empty($all_data->mobile)) {
                            $m_number = preg_replace('/\s+/', '',$all_data->mobile);
                            $length = strlen($m_number);
                            if (strlen($m_number) == 9) {
                                $mobile_number = '27' . $m_number;
                            } else if ($length == 10 && $m_number[0] == '0'){
                                $mobile_number = '27' . substr($m_number, 1);
                            }elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                                $mobile_number =$m_number;
                            } elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                                $mobile_number = $m_number;
                            }
                        }

                       

                        $whatsapp_number = '-';
                        if (!empty($all_data->whatsapp)) {
                            $w_number = preg_replace('/\s+/', '',$all_data->whatsapp);
                            $length = strlen($w_number);
                            if (strlen($w_number) == 9) {
                                $whatsapp_number = '27' . $w_number;
                            }else if ($length == 10 && $w_number[0] == '0'){
                                $whatsapp_number = '27' . substr($w_number, 1);
                            } elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                                $whatsapp_number = $w_number;
                            } elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                                $whatsapp_number = $w_number;
                            }
                        }

                       

                        $sheet->setCellValue('A' . $rows, value: $all_data->id);
                        $sheet->setCellValue('B' . $rows, $all_data->name);
                        $sheet->setCellValue('C' . $rows, $all_data->surname);
                        $sheet->setCellValue('D' . $rows, $mobile_number);
                        $sheet->setCellValue('E' . $rows, $whatsapp_number);
                        $sheet->setCellValue('F' . $rows, $all_data->email);
                        $sheet->setCellValue('G' . $rows, $all_data->updated_at);
                        $user_name = Users::where('id', $all_data->created_by)->first();
                        if ($user_name) {
                            $sheet->setCellValue('H' . $rows, $user_name->name . ' ' . $user_name->surname);
                        } else {
                            $sheet->setCellValue('H' . $rows, ''); // or some default value if user is not found
                        }
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':H' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':H' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':H' . $rows)->getAlignment()->setIndent(1);
                        $rows++;
                        $i++;
                    }
                }else if ($resp_status == 'Unsubscribed') {
                    $sheet->setCellValue('A1', 'PID');
                    $sheet->setCellValue('B1', 'First Name');
                    $sheet->setCellValue('C1', 'Last Name');
                    $sheet->setCellValue('D1', 'Mobile Number');
                    $sheet->setCellValue('E1', 'WA Number');
                    $sheet->setCellValue('F1', 'Email');
                    $sheet->setCellValue('G1', 'Date Unsubscribed');
                    $sheet->setCellValue('H1', 'Unsubscribed By');

                    $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:H1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i    = 1;

                    $all_datas = Respondents::where('respondents.active_status_id','=',3);
                    
                    if($respondents != ""){
                        $all_datas = $all_datas->whereIn('respondents.id', [$respondents]);
                    }
                        
                    $all_datas = $all_datas->orderBy('respondents.id', 'ASC')->get();

                    foreach ($all_datas as $all_data) {
                        $mobile_number = '-';
                        if (!empty($all_data->mobile)) {
                         
                            $m_number = preg_replace('/\s+/', '',$all_data->mobile);
                            $length = strlen($m_number);
                            if (strlen($m_number) == 9) {
                                $mobile_number = '27' . $m_number;
                            } else if ($length == 10 && $m_number[0] == '0'){
                                $mobile_number = '27' . substr($m_number, 1);
                            }elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                                $mobile_number = $m_number;
                            } elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                                $mobile_number = $m_number;
                            }
                        }


                        $whatsapp_number = '-';
                        if (!empty($all_data->whatsapp)) {
                            $w_number = $all_data->whatsapp;
                            $length = strlen($w_number);
                            if (strlen($w_number) == 9) {
                                $whatsapp_number = '27' . $w_number;
                            } else if ($length == 10 && $w_number[0] == '0'){
                                $whatsapp_number = '27' . substr($w_number, 1);
                            }elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                                $whatsapp_number = $w_number;
                            } elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                                $whatsapp_number = $w_number;
                            }
                        }



                        $sheet->setCellValue('A' . $rows, $all_data->id);
                        $sheet->setCellValue('B' . $rows, $all_data->name);
                        $sheet->setCellValue('C' . $rows, $all_data->surname);
                        $sheet->setCellValue('D' . $rows, $mobile_number);
                        $sheet->setCellValue('E' . $rows, $whatsapp_number);
                        $sheet->setCellValue('F' . $rows, $all_data->email);
                        $sheet->setCellValue('G' . $rows, $all_data->updated_at);
                        $user_name = Users::where('id', $all_data->created_by)->first();
                        if ($user_name) {
                            $sheet->setCellValue('H' . $rows, $user_name->name . ' ' . $user_name->surname);
                        } else {
                            $sheet->setCellValue('H' . $rows, ''); // or some default value if user is not found
                        }
                        
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':H' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':H' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':H' . $rows)->getAlignment()->setIndent(1);
                        $rows++;
                        $i++;
                    }
                }else if ($resp_status == 'Active') {
                    $sheet->setCellValue('A1', 'PID');
                    $sheet->setCellValue('B1', 'First Name');
                    $sheet->setCellValue('C1', 'Last Name');
                    $sheet->setCellValue('D1', 'Mobile Number');
                    $sheet->setCellValue('E1', 'WA Number');
                    $sheet->setCellValue('F1', 'Email');
                    $sheet->setCellValue('G1', 'Created At');
                   

                    $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:G1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i    = 1;

                    $all_datas = Respondents::where('respondents.active_status_id','=',1);
                    
                    if($respondents != ""){
                        $all_datas = $all_datas->whereIn('respondents.id', [$respondents]);
                    }

                    if($from != null && $to != null){
                        $all_datas = $all_datas->where('respondents.created_at', '>=', $from)->where('respondents.created_at', '<=', $to);
                    }
                    $all_datas = $all_datas->whereNotExists(function ($query) {
                        $query->select(\DB::raw(1))
                            ->from('respondent_tag')
                            ->whereColumn('respondent_tag.respondent_id', '=', 'respondents.id')
                            ->where('respondent_tag.tag_id', 1);
                    }); // Exclude respondents with tag_id = 1
                    $all_datas = $all_datas->orderBy('respondents.id', 'ASC')->get();

                    foreach ($all_datas as $all_data) {
                        $mobile_number = '-';
                        if (!empty($all_data->mobile)) {
                            $m_number = preg_replace('/\s+/', '',$all_data->mobile);
                            $length = strlen($m_number);
                            if (strlen($m_number) == 9) {
                                $mobile_number = '27' . $m_number;
                            }else if ($length == 10 && $m_number[0] == '0'){
                                $mobile_number = '27' . substr($m_number, 1);
                            } elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                                $mobile_number = $m_number;
                            } elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                                $mobile_number = $m_number;
                            }
                        }

                      

                        $whatsapp_number = '-';
                        if (!empty($all_data->whatsapp)) {
                            $w_number = preg_replace('/\s+/', '',$all_data->whatsapp);
                            $length = strlen($w_number);
                            if (strlen($w_number) == 9) {
                                $whatsapp_number = '27' . $w_number;
                            } else if ($length == 10 && $w_number[0] == '0'){
                                $whatsapp_number = '27' . substr($w_number, 1);
                            }elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                                $whatsapp_number = $w_number;
                            } elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                                $whatsapp_number = $w_number;
                            }
                        }



                        $sheet->setCellValue('A' . $rows, $all_data->id);
                        $sheet->setCellValue('B' . $rows, $all_data->name);
                        $sheet->setCellValue('C' . $rows, $all_data->surname);
                        $sheet->setCellValue('D' . $rows, $mobile_number);
                        $sheet->setCellValue('E' . $rows, $whatsapp_number);
                        $sheet->setCellValue('F' . $rows, $all_data->email);
                        $sheet->setCellValue('G' . $rows, $all_data->created_at);
                    
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':G' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':G' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':G' . $rows)->getAlignment()->setIndent(1);
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

                    $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:H1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i = 1;

                    $all_datas = Respondents::where('respondents.active_status_id','=',5);
                        if($respondents != ""){
                            $all_datas = $all_datas->whereIn('respondents.id', [$respondents]);
                        }
                       
                    $all_datas = $all_datas->orderBy('respondents.id', 'ASC')->get();

                    foreach ($all_datas as $all_data) {
                        $mobile_number = '-';
                        if (!empty($all_data->mobile)) {
                            $m_number = preg_replace('/\s+/', '',$all_data->mobile);
                            $length = strlen($m_number);
                            
                            if (strlen($m_number) == 9) {
                                $mobile_number = '27' . $m_number;
                            } else if ($length == 10 && $m_number[0] == '0'){
                                $mobile_number = '27' . substr($m_number, 1);
                            }elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                                $mobile_number = $m_number;
                            } elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                                $mobile_number = $m_number;
                            }
                        }

                        $whatsapp_number = '-';
                        if (!empty($all_data->whatsapp)) {
                            $w_number = preg_replace('/\s+/', '',$all_data->whatsapp);
                            $length = strlen($w_number);
                            if (strlen($w_number) == 9) {
                                $whatsapp_number = '27' . $w_number;
                            } else if ($length == 10 && $w_number[0] == '0'){
                                $whatsapp_number = '27' . substr($w_number, 1);
                            }elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                                $whatsapp_number = $w_number;
                            } elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                                $whatsapp_number = $w_number;
                            }
                        }

                
                        $sheet->setCellValue('A' . $rows, $all_data->id);
                        $sheet->setCellValue('B' . $rows, $all_data->name);
                        $sheet->setCellValue('C' . $rows, $all_data->surname);
                        $sheet->setCellValue('D' . $rows, $mobile_number);
                        $sheet->setCellValue('E' . $rows, $whatsapp_number);
                        $sheet->setCellValue('F' . $rows, $all_data->email);
                        $sheet->setCellValue('G' . $rows, $all_data->created_at);
                        $user_name = Users::where('id', $all_data->created_by)->first();
                        if ($user_name) {
                            $sheet->setCellValue('H' . $rows, $user_name->name . ' ' . $user_name->surname);
                        } else {
                            $sheet->setCellValue('H' . $rows, ''); // or some default value if user is not found
                        }
                        // $sheet->setCellValue('I' . $rows, $all_data->created_by);
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':H' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':H' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':H' . $rows)->getAlignment()->setIndent(1);
                        $rows++;
                        $i++;
                    }
                }

                $fileName = $module . "_" . $resp_status . "_" . date('ymd') . "." . $type;

            }
            else if ($module == 'Cashout') {
                
                // $all_datas = Cashout::select('cashouts.*','respondents.id as resp_id','respondents.name','respondents.surname','respondents.email','respondents.mobile','respondents.whatsapp',
                //     DB::raw('COUNT(cashouts.amount) as total_cashout'),
                //     DB::raw('COUNT(CASE WHEN cashouts.status_id = 1 THEN 1 END) as pending'),
                //     DB::raw('COUNT(CASE WHEN cashouts.status_id = 4 THEN 1 END) as declined'),
                //     DB::raw('COUNT(CASE WHEN cashouts.status_id = 3 THEN 1 END) as complete'),
                //     DB::raw('COUNT(CASE WHEN cashouts.status_id = 0 THEN 1 END) as failed')
                // )
                // ->join('respondents', 'respondents.id', '=', 'cashouts.respondent_id');

                $all_datas123 = Respondents::select(
                    'respondents.id as resp_id',
                    'respondents.name',
                    'respondents.surname',
                    'respondents.email',
                    'respondents.mobile',
                    'respondents.whatsapp',
                    DB::raw('SUM(cashouts.amount) as total_cashout'), 
                    DB::raw('COUNT(CASE WHEN cashouts.status_id = 1 THEN 1 END) as pending'),
                    DB::raw('COUNT(CASE WHEN cashouts.status_id = 4 THEN 1 END) as declined'),
                    DB::raw('COUNT(CASE WHEN cashouts.status_id = 3 THEN 1 END) as complete'),
                    DB::raw('COUNT(CASE WHEN cashouts.status_id = 0 THEN 1 END) as failed')
                )
                ->leftJoin('cashouts', 'respondents.id', '=', 'cashouts.respondent_id');

                $all_datas = Respondents::select(
                    'respondents.id as resp_id',
                    'respondents.name',
                    'respondents.surname',
                    'respondents.email',
                    'respondents.mobile',
                    'respondents.whatsapp',
                    'cashouts.type_id',
                    'cashouts.created_at',
                    DB::raw('COUNT(CASE WHEN cashouts.status_id = 3 THEN 1 END) as total_complete_count'),
                    DB::raw('COUNT(CASE WHEN cashouts.status_id = 1 THEN 1 END) as total_pending_count'),
                    DB::raw('SUM(CASE WHEN cashouts.status_id = 3 THEN cashouts.amount ELSE 0 END) as total_complete_cashout'), 
                    DB::raw('SUM(CASE WHEN cashouts.status_id = 1 THEN cashouts.amount ELSE 0 END) as pending'),
                    DB::raw('SUM(CASE WHEN cashouts.status_id = 4 THEN cashouts.amount ELSE 0 END) as declined'),
                    DB::raw('SUM(CASE WHEN cashouts.status_id = 0 THEN cashouts.amount ELSE 0 END) as failed')
                )
                ->leftJoin('cashouts', 'respondents.id', '=', 'cashouts.respondent_id')
                ->whereNull('cashouts.deleted_at') 
                ->groupBy('respondents.id'); // Don't forget to group by respondent ID
                    
                
                if ($from != null && $to != null) {
                    $all_datas = $all_datas->whereBetween('cashouts.created_at', [$from, $to]);
                }

                if ($respondents != "") {
                    $all_datas = $all_datas->whereIn('respondents.id', [$respondents]);
                }

                if ($cashout_type != "") {
                    $all_datas = $all_datas->where('cashouts.type_id', $cashout_type);
                }

                $all_datas = $all_datas
                    ->groupBy('respondents.id')
                    ->orderBy("respondents.id", "ASC")  // Use respondents.id for consistent ordering
                    ->get();
                
                //dd($all_datas);
            
                $sheet->setCellValue('A1', 'PID');
                $sheet->setCellValue('B1', 'First Name');
                $sheet->setCellValue('C1', 'Last Name');
                $sheet->setCellValue('D1', 'Mobile Number');
                $sheet->setCellValue('E1', 'WA Number');
                $sheet->setCellValue('F1', 'Email');
                $sheet->setCellValue('G1', 'Cashout Type');
                $sheet->setCellValue('H1', 'Total Cashouts paid');
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

                    $respondent_id = $all_data->respondent_id;

                    $get_incentive = Cashout::where('respondent_id',$respondent_id)->where('status_id',3);
                    $get_incentive_owed = Cashout::where('respondent_id',$respondent_id)->where('status_id',1);

                    if ($all_data->type_id == 1) {
                        $type_val = 'EFT';
                        $get_incentive->where('type_id',$all_data->type_id);
                        $get_incentive_owed->where('type_id',$all_data->type_id);
                    }
                    else if ($all_data->type_id == 2) {
                        $type_val = 'Data';
                        $get_incentive->where('type_id',$all_data->type_id);
                        $get_incentive_owed->where('type_id',$all_data->type_id);
                    }
                    else if ($all_data->type_id == 3) {
                        $type_val = 'Airtime';
                        $get_incentive->where('type_id',$all_data->type_id);
                        $get_incentive_owed->where('type_id',$all_data->type_id);
                    }
                    else if ($all_data->type_id == 4) {
                        $type_val = 'Donation';
                        $get_incentive->where('type_id',$all_data->type_id);
                        $get_incentive_owed->where('type_id',$all_data->type_id);
                    }
                    else {
                        $type_val = '-';
                    }

                    $get_incentive = $get_incentive->groupBy('respondent_id')->sum('amount');
                    $get_incentive_owed = $get_incentive_owed->groupBy('respondent_id')->sum('amount');

                    $amount = $all_data->amount / 10;
                    $respondent = $all_data->name . ' - ' . $all_data->email . ' - ' . $all_data->mobile;

                    $mobile_number = '-';
                    if (!empty($all_data->mobile)) {
                        $m_number =  preg_replace('/\s+/', '',$all_data->mobile);
                        $length = strlen($m_number);
                        if (strlen($m_number) == 9) {
                            $mobile_number = '27' . $m_number;
                        } elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                            $mobile_number = $m_number;
                        } else if ($length == 10 && $m_number[0] == '0'){
                            $mobile_number = '27' . substr($m_number, 1);
                        }elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                            $mobile_number = $m_number;
                        }
                    }

                    $whatsapp_number = '-';
                    if (!empty($all_data->whatsapp)) {
                        $w_number = preg_replace('/\s+/', '',$all_data->whatsapp);
                        $length = strlen($w_number);
                        if (strlen($w_number) == 9) {
                            $whatsapp_number = '27' . $w_number;
                        } else if ($length == 10 && $w_number[0] == '0'){
                            $whatsapp_number = '27' . substr($w_number, 1);
                        }elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                            $whatsapp_number = $w_number;
                        } elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                            $whatsapp_number = $w_number;
                        }
                    }

                

                    $sheet->setCellValue('A' . $rows, $all_data->resp_id);
                    $sheet->setCellValue('B' . $rows, $all_data->name);
                    $sheet->setCellValue('C' . $rows, $all_data->surname);
                    $sheet->setCellValue('D' . $rows, $mobile_number);
                    $sheet->setCellValue('E' . $rows, $whatsapp_number);
                    $sheet->setCellValue('F' . $rows, $all_data->email);
                    $sheet->setCellValue('G' . $rows, $type_val);
                    $sheet->setCellValue('H' . $rows, $all_data->total_complete_count);
                    $sheet->setCellValue('I' . $rows, $all_data->total_complete_cashout/10);
                    $sheet->setCellValue('J' . $rows, $all_data->total_pending_count);
                    $sheet->setCellValue('K' . $rows, $all_data->pending/10);
                    $sheet->setCellValue('L' . $rows, $all_data->declined/10);
                    $sheet->setCellValue('M' . $rows, $all_data->total_complete_cashout/10);
                    $sheet->setCellValue('N' . $rows, $all_data->pending/10);
                    $get_project = Projects::select('projects.id','projects.name')->join('project_respondent as resp','projects.id','resp.project_id')
                        ->where('resp.respondent_id',$all_data->resp_id)
                        ->groupBy('projects.id')
                        ->get();
                    $project_total = '';
                    foreach($get_project as $pro){
                        $project_total .= $pro->id.' - '.$pro->name.PHP_EOL;
                    }

                    $sheet->setCellValue('O' . $rows, $project_total);
                    $sheet->getStyle('O' . $rows)->getAlignment()->setWrapText(true);
                    $sheet->setCellValue('P' . $rows, ($all_data->created_at != null) ? date("d-m-Y", strtotime($all_data->created_at)) : '');
                    $sheet->getRowDimension($rows)->setRowHeight(20);
                    $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                    $sheet->getStyle('C' . $rows . ':P' . $rows)->applyFromArray($styleArray2);
                    $sheet->getStyle('C' . $rows . ':P' . $rows)->getAlignment()->setIndent(1);
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
                    $all_datas = $all_datas->where('respondents.active_status_id',1)->get([
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
                    ->where('respondents.active_status_id',1)
                    ->orderBy('respondents.id', 'ASC')
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
                    $all_datas = $all_datas->where('respondents.active_status_id',1)
                    ->orderBy('respondents.id', 'ASC')
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

                    $mobile_number = '-';
                    if (!empty($all_data->mobile)) {
                        $m_number =  preg_replace('/\s+/', '',$all_data->mobile);
                        $length = strlen($m_number);
                        if (strlen($m_number) == 9) {
                            $mobile_number = '27' . $m_number;
                        } elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                            $mobile_number = $m_number;
                        } else if ($length == 10 && $m_number[0] == '0'){
                            $mobile_number = '27' . substr($m_number, 1);
                        }elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                            $mobile_number = $m_number;
                        }
                    }

                    $whatsapp_number = '-';
                    if (!empty($all_data->whatsapp)) {
                        $w_number = preg_replace('/\s+/', '',$all_data->whatsapp);
                        $length = strlen($w_number);
                        if (strlen($w_number) == 9) {
                            $whatsapp_number = '27' . $w_number;
                        } else if ($length == 10 && $w_number[0] == '0'){
                            $whatsapp_number = '27' . substr($w_number, 1);
                        }elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                            $whatsapp_number = $w_number;
                        } elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                            $whatsapp_number = $w_number;
                        }
                    }

                    

                    $sheet->setCellValue('A' . $rows, $all_data->id);
                    $sheet->setCellValue('B' . $rows, $all_data->name);
                    $sheet->setCellValue('C' . $rows, $all_data->surname);
                    $sheet->setCellValue('D' . $rows, $mobile_number);
                    $sheet->setCellValue('E' . $rows, $whatsapp_number);
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
                    $sheet->getRowDimension($rows)->setRowHeight(20);
                    $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                    $sheet->getStyle('C' . $rows . ':G' . $rows)->applyFromArray($styleArray2);
                    $sheet->getStyle('C' . $rows . ':G' . $rows)->getAlignment()->setIndent(1);
                    $rows++;
                    $i++;
                }

                $fileName = $module . "_" . date('ymd') . "." . $type;

            }
            else if ($module == 'Survey123') {
                
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
                    dd($all_datas);
                    $basic = json_decode($all_data->basic_details);
                    $essential = json_decode($all_data->essential_details);
                    $extended  = json_decode($all_data->extended_details);

                    $mobile_number = '-';
                    if (!empty($basic->mobile_number)) {
                        $m_number = preg_replace('/\s+/', '',$all_data->mobile);
                        $length = strlen($m_number);
                        if (strlen($m_number) == 9) {
                            $mobile_number = '27' . $m_number;
                        } elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                            $mobile_number = $m_number;
                        } else if ($length == 10 && $m_number[0] == '0'){
                            $mobile_number = '27' . substr($m_number, 1);
                        }elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                            $mobile_number = $m_number;
                        }
                    }
                   

                    $whatsapp_number = '-';
                    if (!empty($basic->whatsapp_number)) {
                   
                        $w_number = preg_replace('/\s+/', '',$all_data->whatsapp);
                        if (strlen($w_number) == 9) {
                            $whatsapp_number = '27' . $w_number;
                        } elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                            $whatsapp_number = $w_number;
                        }else if ($length == 10 && $m_number[0] == '0'){
                            $whatsapp_number = '27' . substr($w_number, 1);
                        } elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                            $whatsapp_number = $w_number;
                        }
                    }
                    $sheet->setCellValue('A' . $rows, $all_data->id);
                    $sheet->setCellValue('B' . $rows, $basic->first_name ?? '');
                    $sheet->setCellValue('C' . $rows, $basic->last_name ?? '');
                    $sheet->setCellValue('D' . $rows, $mobile_number);
                    $sheet->setCellValue('E' . $rows, $whatsapp_number);
                    $sheet->setCellValue('F' . $rows, $basic->email ?? '');
                    $dob = $basic->date_of_birth ?? '';
                    $age = ''; // Set initial age to empty
                    
                    $get_resp = Respondents::select('date_of_birth')->where('id', $all_data->id)->first();
                    if ($get_resp != null) {
                        if (!empty($get_resp->date_of_birth)) {
                            $dob = $get_resp->date_of_birth;
                    
                            $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
                            if ($dobDate) {
                                $now = new DateTime();
                                $age = $now->diff($dobDate)->y; // Get the difference in years
                            }
                        } else {
                            $dob = ''; // Handle the case where there's no date of birth found
                        }
                    } else {
                        if (empty($dob) || $dob === '0000-00-00') {
                            $dobDate = DateTime::createFromFormat('Y/m/d', $dob);
                            if ($dobDate) {
                                $now = new DateTime();
                                $age = $now->diff($dobDate)->y; // Get the difference in years
                            } else {
                                $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
                                if ($dobDate) {
                                    $now = new DateTime();
                                    $age = $now->diff($dobDate)->y; // Get the difference in years
                                }
                            }
                        }
                    }
                    
                    // Ensure age is empty if dob is not set or invalid
                    if (empty($dob) || $dob === '0000-00-00') {
                        $age = ''; // Set age to empty if date of birth is empty or invalid
                    }
                  

                    $employment_status = ($essential->employment_status == 'other') ? $essential->employment_status_other : $essential->employment_status;
                    $industry_my_company = ($essential->industry_my_company == 'other') ? $essential->industry_my_company_other : $essential->industry_my_company;
                   
                    $p_income = DB::table('income_per_month')->where('id',$essential->personal_income_per_month)->first();
                    $h_income = DB::table('income_per_month')->where('id',$essential->household_income_per_month)->first();
                    $personal_income = ($p_income != null) ? $p_income->income : '-';
                    $household_income = ($h_income != null) ? $h_income->income : '-';

                    $sheet->setCellValue('G' . $rows, $age);
                    $relationship_status = ucfirst($essential->relationship_status ?? '');
                    $sheet->setCellValue('H' . $rows, $relationship_status);
                    // Define the mapping of ethnic group codes to names
                    $ethnicGroups = [
                        'asian'   => 'Asian',
                        'black'   => 'Black',
                        'coloured'=> 'Coloured',
                        'indian'  => 'Indian',
                        'white'   => 'White'
                    ];

                    // Default to an empty string if the ethnic group is not in the array
                    $ethnic_group = '';
                    if ($essential && isset($essential->ethnic_group)) {
                        $ethnic_group = $ethnic_group = ucfirst($essential->ethnic_group) ?? '';
                    }

                    $sheet->setCellValue('I' . $rows, $ethnic_group);
                    $sheet->setCellValue('J' . $rows, $essential->gender ?? '');
                    $education_level = '';

                    // Check if $essential is not null and has the education_level property
                    if ($essential && isset($essential->education_level)) {
                        switch ($essential->education_level) {
                            case 'matric':
                                $education_level = 'Matric';
                                break;
                            case 'post_matric_courses':
                                $education_level = 'Post Matric Courses / Higher Certificate';
                                break;
                            case 'post_matric_diploma':
                                $education_level = 'Post Matric Diploma';
                                break;
                            case 'ug':
                                $education_level = 'Undergrad University Degree';
                                break;
                            case 'pg':
                                $education_level = 'Post Grad Degree - Honours, Masters, PhD, MBA';
                                break;
                            case 'school_no_metric':
                                $education_level = 'School But No Matric';
                                break;
                            default:
                                $education_level = ''; // Handle unexpected values
                                break;
                        }
                    }
                    $sheet->setCellValue('K' . $rows, $education_level);
                    $sheet->setCellValue('L' . $rows, $employment_status ?? '');
                    $industry = IndustryCompany::find($industry_my_company);
                    $companyName = $industry ? $industry->company : '';
                    $sheet->setCellValue('M' . $rows, $companyName);
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

                    if(isset($banks->bank_name) && ($banks->bank_name!='')){
                        $bank_names = $banks->bank_name;
                    }else{
                        $bank_names = '';
                    }

                    $bank_main = ($extended->bank_main == 'other') ? $extended->bank_main_other : $bank_names;
                        
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
                // $all_datas = Projects::leftJoin('users', function ($join) {
                //         $join->on('users.id', '=', 'projects.user_id');
                //     });

                //     if($from != null && $to != null){
                //         $all_datas = $all_datas->whereDate('projects.created_at', '>=', $from)->whereDate('projects.created_at', '<=', $to);
                //     }

                // $all_datas = $all_datas->get([
                //     'users.name as uname',
                //     'users.surname',
                //     'projects.number',
                //     'projects.name',
                //     'projects.published_date',
                //     'projects.closing_date',
                //     'projects.total_responnded_attended',
                //     'projects.total_responded_recruited',
                // ]);

                // use Illuminate\Support\Facades\DB;

                $all_datas = Projects::leftJoin('users', function ($join) {
                        $join->on('users.id', '=', 'projects.user_id');
                    })
                    ->leftJoin('project_respondent', 'project_respondent.project_id', '=', 'projects.id')
                    ->leftJoin('qualified_respondent', 'qualified_respondent.project_id', '=', 'projects.id');

                // Apply date filters if provided
                if ($from != null && $to != null) {
                    $all_datas = $all_datas->whereDate('projects.created_at', '>=', $from)
                                        ->whereDate('projects.created_at', '<=', $to);
                }

                // Select fields with COUNT aggregation
                $all_datas = $all_datas->select(
                    'users.name as uname',
                    'users.surname',
                    'projects.number',
                    'projects.name',
                    'projects.published_date',
                    'projects.closing_date',
                    DB::raw('COUNT(DISTINCT project_respondent.respondent_id) as total_responnded_attended'),
                    DB::raw('COUNT(DISTINCT qualified_respondent.respondent_id) as total_responded_recruited')
                )
                ->groupBy(
                    'projects.id',  // Group by necessary fields to avoid incorrect aggregation
                    'users.name',
                    'users.surname',
                    'projects.number',
                    'projects.name',
                    'projects.published_date',
                    'projects.closing_date'
                )
                ->get();



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
                    $sheet->setCellValue('A' . $rows, $all_data->number.' '.$all_data->name.' '.$all_data->id);
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
            else if ($module == 'Panel') {


                $respondents = ($request->respondents != null) ? array_filter($request->respondents) : null;
                $panel = ($request->panel != null) ? array_filter($request->panel) : null;

                $query = DB::table('respondent_tag')
                ->select([
                     'respondents.id',
                     'respondents.opted_in',
                  'respondent_tag.id as tag_id',
                   'respondents.name', 
                    'respondents.surname',
                      'tags.name as tag_name',
                      'respondents.mobile',
                     'respondents.whatsapp',
                     'respondents.email',
                      'respondents.date_of_birth',
                   \DB::raw('COALESCE(respondent_profile.basic_details, "") AS basic_details'),
                  \DB::raw('COALESCE(respondent_profile.essential_details, "") AS essential_details'),
                      'respondent_profile.updated_at',
               ])
                  ->join('tags', 'respondent_tag.tag_id', '=', 'tags.id')
              ->join('respondents', 'respondents.id', '=', 'respondent_tag.respondent_id') // Join with respondents table
                 ->join("respondent_profile", "respondent_profile.respondent_id", "=", "respondents.id")
               ->when($panel !== null, function ($query) use ($panel) {
                  $query->whereIn('respondent_tag.tag_id', $panel);
                  })
                  ->when($type_method == 'Individual', function ($query) use ($respondents) {
                      $query->whereIn('respondent_tag.respondent_id', $respondents);
                  })
                  ->where('respondents.active_status_id', 1)
                  ->orderBy('respondents.id', 'asc')
                  ->get();
          
                // $query = DB::table('respondent_tag')
                //         ->select([
                //             'respondents.id as respondent_id',
                //             'respondents.opted_in',
                //             'respondent_tag.id as tag_id',
                //             'respondents.name', 
                //             'respondents.surname',
                //             'tags.name as tag_name',
                //             'respondents.mobile',
                //             'respondents.whatsapp',
                //             'respondents.email',
                //             'respondents.date_of_birth',
                //             \DB::raw('COALESCE(respondent_profile.basic_details, "") AS basic_details'),
                //             \DB::raw('COALESCE(respondent_profile.essential_details, "") AS essential_details'),
                //             'respondent_profile.updated_at',
                //         ])
                //         ->join('tags', 'respondent_tag.tag_id', '=', 'tags.id')
                //         ->join('respondents', 'respondents.id', '=', 'respondent_tag.respondent_id') // Join with respondents table
                //         ->join("respondent_profile", "respondent_profile.respondent_id", "=", "respondents.id")
                //         ->when($panel !== null, function ($query) use ($panel) {
                //             $query->whereIn('respondent_tag.tag_id', $panel);
                //         })
                //         ->when($type_method == 'Individual', function ($query) use ($respondents) {
                //             $query->whereIn('respondent_tag.respondent_id', $respondents);
                //         })
                //         ->where('respondents.active_status_id', 1)
                //         ->orderBy('respondent_tag.id', 'desc')
                //         ->get();
 
                      
                    $sheet->setCellValue('A1', 'PID');
                    $sheet->setCellValue('B1', 'First Name');
                    $sheet->setCellValue('C1', 'Last Name');
                    $sheet->setCellValue('D1', 'Panel Name');
                    $sheet->setCellValue('E1', 'Mobile Number');
                    $sheet->setCellValue('F1', 'WA Number');
                    $sheet->setCellValue('G1', 'Email');
                    $sheet->setCellValue('H1', 'Age');
                    $sheet->setCellValue('I1', 'Relationship Status');
                    $sheet->setCellValue('J1', 'Ethnic Group / Race');
                    $sheet->setCellValue('K1', 'Gender');
                    $sheet->setCellValue('L1', 'Highest Education Level');
                    $sheet->setCellValue('M1', 'Employment Status');
                    $sheet->setCellValue('N1', 'Industry my Company is In');
                    $sheet->setCellValue('O1', 'Job Title');
                    $sheet->setCellValue('P1', 'Personal Income per Month');
                    $sheet->setCellValue('Q1', 'Personal LSM');
                    $sheet->setCellValue('R1', 'HHI per Month');
                    $sheet->setCellValue('S1', 'Household LSM');
                    $sheet->setCellValue('T1', 'Province');
                    $sheet->setCellValue('U1', 'Area');
                    $sheet->setCellValue('V1', 'No. of People Living in Your Household');
                    $sheet->setCellValue('W1', 'Number of Children');
                    $sheet->setCellValue('X1', 'Number of Vehicles');
                    $sheet->setCellValue('Y1', 'Opted In');
                    $sheet->setCellValue('Z1', 'Last Updated');
                

                    $sheet->getStyle('A1:Z1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                    $sheet->getStyle('A1:Z1')->applyFromArray($styleArray);

                    $rows = 2;
                    $i = 1;
                  
                    foreach ($query as $all_data) {
                 
                        $basic = json_decode($all_data->basic_details);
                     
                        $essential = json_decode($all_data->essential_details);
                        $mobile_number = '-';
                        if (!empty($basic->mobile_number)) {
                            $m_number = preg_replace('/\s+/', '',$all_data->mobile);
                            $length = strlen($m_number);
                            if (strlen($m_number) == 9) {
                                $mobile_number = '27' . $m_number;
                            } elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                                $mobile_number = $m_number;
                            } else if ($length == 10 && $m_number[0] == '0'){
                                $mobile_number = '27' . substr($m_number, 1);
                            }elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                                $mobile_number = $m_number;
                            }
                        }
                       

                        $whatsapp_number = '-';
                        if (!empty($basic->whatsapp_number)) {
                       
                            $w_number = preg_replace('/\s+/', '',$all_data->whatsapp);
                            if (strlen($w_number) == 9) {
                                $whatsapp_number = '27' . $w_number;
                            } elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                                $whatsapp_number = $w_number;
                            }else if ($length == 10 && $m_number[0] == '0'){
                                $whatsapp_number = '27' . substr($w_number, 1);
                            } elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                                $whatsapp_number = $w_number;
                            }
                        }

                        $sheet->setCellValue('A' . $rows, $all_data->id);
                        $sheet->setCellValue('B' . $rows, $basic->first_name ?? '');
                        $sheet->setCellValue('C' . $rows, $basic->last_name ?? '');
                        $sheet->setCellValue('D' . $rows, $all_data->tag_name);
                        $sheet->setCellValue('E' . $rows, $mobile_number ?? '');
                        $sheet->setCellValue('F' . $rows, $whatsapp_number ?? '');
                        $sheet->setCellValue('G' . $rows, $basic->email ?? '');

                        $dob = $basic->date_of_birth ?? '';
                        $year = (isset($basic->date_of_birth) && $dob !== '0000-00-00') 
                            ? (date('Y') - date('Y', strtotime($dob))) 
                            : '-';

                        $employment_status = null; // Initialize $employment_status to null

                        if ($essential && isset($essential->employment_status)) {
                            $employment_status = ($essential->employment_status == 'other') ? $essential->employment_status_other : $essential->employment_status;
                        }
                        
                        $industry_my_company = null; // Initialize $industry_my_company to null

                        if ($essential && isset($essential->industry_my_company)) {
                            $industry_my_company = ($essential->industry_my_company == 'other') ? $essential->industry_my_company_other : $essential->industry_my_company;
                        }

                       
                        $sheet->setCellValue('H' . $rows, $year);
                        $relationship_status = ucfirst($essential->relationship_status ?? '');
                        $sheet->setCellValue('I' . $rows, $relationship_status);
                        // Define the mapping of ethnic group codes to names
                        $ethnicGroups = [
                            'asian'   => 'Asian',
                            'black'   => 'Black',
                            'coloured'=> 'Coloured',
                            'indian'  => 'Indian',
                            'white'   => 'White'
                        ];

                        // Default to an empty string if the ethnic group is not in the array
                        $ethnic_group = '';
                        if ($essential && isset($essential->ethnic_group)) {
                            $ethnic_group = $ethnic_group = ucfirst($essential->ethnic_group) ?? '';
                        }

                        $sheet->setCellValue('J' . $rows, $ethnic_group);
                        $sheet->setCellValue('K' . $rows, ucfirst($essential->gender) ?? '');
                        $education_level = '';

                        // Check if $essential is not null and has the education_level property
                        if ($essential && isset($essential->education_level)) {
                            switch ($essential->education_level) {
                                case 'matric':
                                    $education_level = 'Matric';
                                    break;
                                case 'post_matric_courses':
                                    $education_level = 'Post Matric Courses / Higher Certificate';
                                    break;
                                case 'post_matric_diploma':
                                    $education_level = 'Post Matric Diploma';
                                    break;
                                case 'ug':
                                    $education_level = 'Undergrad University Degree';
                                    break;
                                case 'pg':
                                    $education_level = 'Post Grad Degree - Honours, Masters, PhD, MBA';
                                    break;
                                case 'school_no_metric':
                                    $education_level = 'School But No Matric';
                                    break;
                                default:
                                    $education_level = ''; // Handle unexpected values
                                    break;
                            }
                        }
                        
                        $sheet->setCellValue('L' . $rows, $education_level);
                        $employment_status = '';

                        // Check if $essential is not null and has the employment_status property
                        if ($essential && isset($essential->employment_status)) {
                            switch ($essential->employment_status) {
                                case 'emp_full_time':
                                    $employment_status = 'Employed Full-Time';
                                    break;
                                case 'emp_part_time':
                                    $employment_status = 'Employed Part-Time';
                                    break;
                                case 'self':
                                    $employment_status = 'Self-Employed';
                                    break;
                                case 'study':
                                    $employment_status = 'Studying Full-Time (Not Working)';
                                    break;
                                case 'working_and_studying':
                                    $employment_status = 'Working & Studying';
                                    break;
                                case 'home_person':
                                    $employment_status = 'Stay at Home Person';
                                    break;
                                case 'retired':
                                    $employment_status = 'Retired';
                                    break;
                                case 'unemployed':
                                    $employment_status = 'Unemployed';
                                    break;
                                case 'other':
                                    $employment_status = 'Other';
                                    break;
                                default:
                                    $employment_status = ''; // Handle unexpected values
                                    break;
                            }
                        }
                       
                        $sheet->setCellValue('M' . $rows, $employment_status);
                        $industry = IndustryCompany::find($industry_my_company);
                        $companyName = $industry ? $industry->company : '';
                        $sheet->setCellValue('N' . $rows, $companyName ?? '');
                        $sheet->setCellValue('O' . $rows, $essential->job_title ?? '');
                        $p_income = null; // Initialize $p_income to null

                        if ($essential && isset($essential->personal_income_per_month)) {
                            $p_income_record = DB::table('income_per_month')
                                                 ->where('id', $essential->personal_income_per_month)
                                                 ->first();
                            $p_income = $p_income_record ? $p_income_record->income : ''; // Extract the specific value or set a default
                        }
                        
                        $h_income = null; // Initialize $h_income to null
                        
                        if ($essential && isset($essential->household_income_per_month)) {
                            $h_income_record = DB::table('income_per_month')
                                                 ->where('id', $essential->household_income_per_month)
                                                 ->first();
                            $h_income = $h_income_record ? $h_income_record->income : ''; // Extract the specific value or set a default
                        }
                        
                        $sheet->setCellValue('P' . $rows, $p_income);
                        $personalIncome = '';
                        if ($essential !== null && isset($essential->personal_income_per_month)) {
                            $personalIncome = $essential->personal_income_per_month;
                        }
                        $sheet->setCellValue('Q' . $rows, $personalIncome);
                       
                       
                        $sheet->setCellValue('R' . $rows, $h_income);
                        $householdIncome = '';
                        if ($essential !== null && isset($essential->household_income_per_month)) {
                            $householdIncome = $essential->household_income_per_month;
                        }
                        $sheet->setCellValue('S' . $rows, $householdIncome);

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
                      
                        $sheet->setCellValue('T' . $rows, $get_state ?? '');
                        $sheet->setCellValue('U' . $rows, $get_district ?? '');
                        $sheet->setCellValue('V' . $rows, $essential->no_houehold ?? '');
                        $sheet->setCellValue('W' . $rows, $essential->no_children ?? '');
                        $sheet->setCellValue('X' . $rows, $essential->no_vehicle ?? '');

                        $opted_in = ($all_data->opted_in != null) ? date("d-m-Y", strtotime($all_data->opted_in)) : '';
                        $updated_at = ($all_data->updated_at != null) ? date("d-m-Y", strtotime($all_data->updated_at)) : '';

                        $sheet->setCellValue('Y' . $rows, $opted_in);
                        $sheet->setCellValue('X' . $rows, $updated_at);
                        $sheet->getRowDimension($rows)->setRowHeight(20);
                        $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                        $sheet->getStyle('C' . $rows . ':Z' . $rows)->applyFromArray($styleArray2);
                        $sheet->getStyle('C' . $rows . ':Z' . $rows)->getAlignment()->setIndent(1);
                        $rows++;
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
                    $sheet->setCellValue('C' . $rows, ucfirst($all_data->action));
                    $sheet->setCellValue('D' . $rows, ucfirst($all_data->type));
                    $sheet->setCellValue('E' . $rows, ucfirst($all_data->month));
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

                 // Base query
                 $query = DB::table('users as u')
                 ->select('u.id',
                     DB::raw('CONCAT(u.name, " ", u.surname) AS full_name'),
                     DB::raw('SUM(CASE WHEN user_events.action = "created" THEN user_events.count ELSE 0 END) AS createCount'),
                     DB::raw('SUM(CASE WHEN user_events.action = "updated" THEN user_events.count ELSE 0 END) AS updateCount'),
                     DB::raw('SUM(CASE WHEN user_events.action = "deactivated" THEN user_events.count ELSE 0 END) AS deactCount')
                 )
                 ->leftJoin('user_events', 'u.id', '=', 'user_events.user_id')
                 ->where('user_events.type', '=', 'respondent')
                 ->groupBy('u.id'); // Group by user_id
             
                // Filter by user_ids if provided
                $users = ($request->users != null) ? array_filter($request->users) : null;
                if (!empty($users)) {
                    $query->whereIn('user_events.user_id', $users);
                }
                
                // Initialize start and end variables
                $start = null;
                $end = null;
                
                // Check and convert start date if provided
                if (!empty($request->start)) {
                    $start = \Carbon\Carbon::createFromFormat('d-m-Y', $request->start)->startOfDay();
                }
                
                // Check and convert end date if provided
                if (!empty($request->end)) {
                    $end = \Carbon\Carbon::createFromFormat('d-m-Y', $request->end)->endOfDay();
                }
                
                // Apply the date filters only if they are set
                if ($start) {
                    $query->where('user_events.created_at', '>=', $start);
                }
                if ($end) {
                    $query->where('user_events.created_at', '<=', $end);
                }
                
                // Fetch all data
                $all_datas = $query->orderBy('u.id','asc')->get();
           
            
                $sheet->setCellValue('A1', 'Name of team member');
                $sheet->setCellValue('B1', 'Total recruited respondents');
                $sheet->setCellValue('C1', 'Total deactivated respondents');
                $sheet->setCellValue('D1', 'Total respondents updated');
            
                $sheet->getStyle('A1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b'); // cell color
                $sheet->getStyle('A1:D1')->applyFromArray($styleArray);
            
                $rows = 2;
                foreach ($all_datas as $data) {
                    // Count total recruited respondents for this specific user
                 
                  
                 
                  
            
                    // Set values for each row
                    $sheet->setCellValue('A' . $rows, $data->full_name);
                    $sheet->setCellValue('B' . $rows, $data->createCount);
                    $sheet->setCellValue('C' . $rows, $data->deactCount);
                    $sheet->setCellValue('D' . $rows, $data->updateCount);
                    $sheet->getRowDimension($rows)->setRowHeight(20);
                    $sheet->getStyle('A' . $rows . ':B' . $rows)->applyFromArray($styleArray3);
                    $sheet->getStyle('C' . $rows . ':D' . $rows)->applyFromArray($styleArray2);
                    $sheet->getStyle('C' . $rows . ':D' . $rows)->getAlignment()->setIndent(1);
                    $rows++;
                }
            
                $fileName = $module . "_" . date('ymd') . "." . $type;
            }
            else if ($module == 'Survey') {
                    
                    //dd($request);
                    $methods=$request->methods;

                    if($methods=='respondents_type'){
                    
                    //starts
                    //dd($request->respondents_survey);
                    $user_id =$request->respondents_survey[0];
                    
                    // Get Surveys by User Id
                    $survey_IDs = SurveyResponse::where(['response_user_id' => $user_id])->groupBy('survey_id')->pluck('survey_id')->toArray();

                    }else if($methods=='projects_type'){
                    
                        //starts
                        //dd($request->projects);
                        $project_id =$request->projects[0];
                        
                        // Get Surveys by User Id
                        $survey_IDs = Projects::where(['id' => $project_id])->pluck('survey_link')->toArray();
                    }

                    //dd($survey_IDs);
                
                    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                    function getValuesUser($data)
                    {
                        $header = $data[0];
                        $headerMapping = array_flip($header);
                        $values = [];
                        $values[] = array_values($header);

                        for ($i = 1; $i < count($data); $i++) {
                            $row = $data[$i];
                            $rearrangedRow = [];
                            foreach ($header as $key) {
                                if (isset($row[$key])) {
                                    $rearrangedRow[] = $row[$key];
                                } else {
                                    $rearrangedRow[] = '';
                                }
                            }
                            $values[] = $rearrangedRow;
                        }

                        return $values;
                    }
                    foreach ($survey_IDs as $survey_id) {
                        // Custom array data to export
                       $survey = Survey::where(['id'=>$survey_id])->first();
                       $question=Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['matrix_qus','welcome_page','thank_you','rankorder','multi_choice'])->get();
                       $matrix_qus=Questions::where(['qus_type'=>'matrix_qus','survey_id'=>$survey_id])->get();
                       $multi_choice_qus=Questions::where(['qus_type'=>'multi_choice','survey_id'=>$survey_id])->get();
                       $rankorder_qus=Questions::where(['qus_type'=>'rankorder','survey_id'=>$survey_id])->get();
           
                       $cols = [];
                       foreach($question as $qus){
                           array_push($cols,$qus->question_name);
                       }
                       foreach($multi_choice_qus as $qus){
                           $qus_ans = json_decode($qus->qus_ans); 
                           $choices= $qus_ans!=null ? explode(",",$qus_ans->choices_list): []; $i=0;
                           foreach($choices as $qus1){
                               array_push($cols,$qus->question_name.'_'.$qus1);
                           }
                       }
                       foreach($rankorder_qus as $qus){
                           $qus_ans = json_decode($qus->qus_ans); 
                           // array_push($cols,$qus->question_name);
                           $choices= $qus_ans!=null ? explode(",",$qus_ans->choices_list): []; $i=0;
                           foreach($choices as $qus1){
                               array_push($cols,$qus->question_name.'_'.$qus1);
                           }
                       }
                       foreach($matrix_qus as $qus){
                           $qus = json_decode($qus->qus_ans); 
                           array_push($cols,$qus->question_name);
                           $exiting_qus_matrix= $qus!=null ? explode(",",$qus->matrix_qus): []; $i=0;
                           foreach($exiting_qus_matrix as $qus1){
                               array_push($cols,$qus1);
                           }
                       }
           
                       // Get Survey Data 
                       $question = Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
                               
                       $surveyResponseUsers =  SurveyResponse::where(['survey_id'=>$survey_id])->groupBy('response_user_id')->pluck('response_user_id')->toArray();
                       array_push($cols,"Respondent Name","Mobile","Whatsapp","Email","Age","Gender","Highest Education Level","Employment Status","Industry my company","Personal Income","Personal LSM","Household Income","Household LSM","Relationship Status","Ethnic Group","Province","Metropolitan Area", "Date","Device ID","Device Name","Completion Status","Browser","OS","Device Type","Long","Lat","Location","IP Address","Language Code","Language Name");
                       $finalResult =[$cols];
                       foreach($surveyResponseUsers as $userID){
                           $user = Respondents::where('id', '=' , $userID)->first();
                           $starttime = SurveyResponse::where(['survey_id'=>$survey_id,'response_user_id'=>$userID])->orderBy("id", "asc")->first();
                           $endtime = SurveyResponse::where(['survey_id'=>$survey_id,'response_user_id'=>$userID])->orderBy("id", "desc")->first();
                           $startedAt = $starttime->created_at;
                           $endedAt = $endtime->created_at;
                           $time = $endedAt->diffInSeconds($startedAt); 
                           $responseinfo = $startedAt->toDayDateTimeString().' | '.$time.' seconds';
                           $other_details = json_decode($endtime->other_details);
                           $deviceID = '';
                           $device_name ='';
                           $browser =''; $os ='';$device_type='';
                           $lang_name =''; $long='';$lat =''; $location=''; $ip_address =''; $lang_code =''; $lang_name ='';
           
                           if(isset($other_details->device_id)){
                               $deviceID = $other_details->device_id;
                           }
                           if(isset($other_details->device_name)){
                               $device_name = $other_details->device_name;
                           }
                           if(isset($other_details->browser)){
                               $browser = $other_details->browser;
                           }
                           if(isset($other_details->os)){
                               $os = $other_details->os;
                           }
                           if(isset($other_details->lang_name)){
                               $lang_name = $other_details->lang_name;
                           }
                           if(isset($other_details->lang_code)){
                               $lang_code = $other_details->lang_code;
                           }
                           if(isset($other_details->ip_address)){
                               $ip_address = $other_details->ip_address;
                           }
                           if(isset($other_details->location)){
                               $location = $other_details->location;
                           }
                           if(isset($other_details->lat)){
                               $lat = $other_details->lat;
                           }
                           if(isset($other_details->long)){
                               $long = $other_details->long;
                           }
                           if(isset($other_details->lang_name)){
                               $lang_name = $other_details->lang_name;
                           }
                           $name = 'Anonymous';
                           if(isset($user->name)){
                               $name = $user->name;
                           }
           
                           $completedRes = SurveyResponse::where(['response_user_id'=>$userID ,'survey_id'=>$survey_id,'answer'=>'thankyou_submitted'])->first();
           
                           if($completedRes){
                               $completion_status = 'Completed';
                           }else{
                            
                                $completion_status = 'Partially Completed';                              
                           }
                            //    Essential Details
                            $mobile_number = '-';
                            if (!empty($mobile)) {
                                $m_number = preg_replace('/\s+/', '',$mobile);
                                $length = strlen($m_number);
                                if (strlen($m_number) == 9) {
                                    $mobile_number = '27' . $m_number;
                                }  else if ($length == 10 && $m_number[0] == '0'){
                                    $mobile_number = '27' . substr($m_number, 1);
                                }elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                                    $mobile_number =$m_number;
                                } elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                                    $mobile_number = $m_number;
                                }
                            }

                            $whatsapp_number = '-';
                            if (!empty($basic->whatsapp_number)) {
                            
                                $w_number = preg_replace('/\s+/', '',$basic->whatsapp_number);
                                $length = strlen($w_number);
                                if (strlen($w_number) == 9) {
                                    $whatsapp_number = '27' . $w_number;
                                } elseif (strlen($w_number) == 11 && strpos($w_number, '27') === 0) {
                                    $whatsapp_number = $w_number;
                                } else if ($length == 10 && $w_number[0] == '0'){
                                    $whatsapp_number = '27' . substr($w_number, 1);
                                }
                                elseif (strlen($w_number) == 12 && strpos($w_number, '+27') === 0) {
                                    $whatsapp_number = $w_number;
                                }
                            }
                        
                            
                            $email = $basic->email ?? '';
                            $dob = $basic->date_of_birth ?? '';
                            $age = ''; // Set initial age to empty
                            
                            $get_resp = Respondents::select('date_of_birth')->where('id', $userID)->first();
                            
                            if ($get_resp != null) {
                                if (!empty($get_resp->date_of_birth)) {
                                    $dob = $get_resp->date_of_birth;
                            
                                    $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
                                    if ($dobDate) {
                                        $now = new DateTime();
                                        $age = $now->diff($dobDate)->y; // Get the difference in years
                                    }
                                } else {
                                    $dob = ''; // Handle the case where there's no date of birth found
                                }
                            } else {
                                if (empty($dob) || $dob === '0000-00-00') {
                                    $dobDate = DateTime::createFromFormat('Y/m/d', $dob);
                                    if ($dobDate) {
                                        $now = new DateTime();
                                        $age = $now->diff($dobDate)->y; // Get the difference in years
                                    } else {
                                        $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
                                        if ($dobDate) {
                                            $now = new DateTime();
                                            $age = $now->diff($dobDate)->y; // Get the difference in years
                                        }
                                    }
                                }
                            }
                            
                            // Ensure age is empty if dob is not set or invalid
                            if (empty($dob) || $dob === '0000-00-00') {
                                $age = ''; // Set age to empty if date of birth is empty or invalid
                            }

                            $all_data = RespondentProfile::where('respondent_id', $userID)->first();
                            
                            //dd($all_data->basic_details);
                            if ($all_data) {
                                $basic = json_decode($all_data->basic_details);
                                $essential = json_decode($all_data->essential_details);
                            }

                            $dob = $basic->date_of_birth ?? '';
                            $year = (isset($basic->date_of_birth) && $dob !== '0000-00-00') 
                            ? (date('Y') - date('Y', strtotime($dob))) 
                            : '-';
                            
                           
                            //dd($essential);

                            $employment_status = null;

                            if (isset($essential) && is_array($essential) && !empty($essential)) {

                                $employment_status = isset($essential) && $essential->employment_status == 'other' ? $essential->employment_status_other : ($essential ? $essential->employment_status : null);

                            }

                            $industry_my_company = null;

                            if (isset($industry_my_company) && is_array($industry_my_company) && !empty($industry_my_company)) {
                                    
                                $industry_my_company = isset($essential) && $essential->industry_my_company == 'other' ? $essential->industry_my_company_other : ($essential ? $essential->industry_my_company : null);
                            }

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
                            
                            $household_income = ($h_income != null) ? $h_income->income : '-';
                            $personal_income = ($p_income != null) ? $p_income->income : '-';
                            
                            $personal_lsm = $essential->personal_income_per_month ?? '';
                            $household_lsm = $essential->household_income_per_month ?? '';

                            $relationship_status = ucfirst($essential->relationship_status ?? '');
                            
                            // Define the mapping of ethnic group codes to names
                            $ethnicGroups = [
                                'asian'   => 'Asian',
                                'black'   => 'Black',
                                'coloured'=> 'Coloured',
                                'indian'  => 'Indian',
                                'white'   => 'White'
                            ];

                            // Default to an empty string if the ethnic group is not in the array
                            $ethnic_group = '';
                            if ($essential && isset($essential->ethnic_group)) {
                                $ethnic_group = $ethnic_group = ucfirst($essential->ethnic_group) ?? '';
                            }else{
                                $ethnic_group = '';
                            }

                        
                            // Initialize the gender variable with a default value
                            $gender = '';

                            // Check if $essential is not null and has the gender property
                            if ($essential && isset($essential->gender)) {
                                // Set the gender value, ensuring it's properly capitalized
                                $gender = ucfirst($essential->gender);
                            }
                        
                            $education_level = '';

                            // Check if $essential is not null and has the education_level property
                            if ($essential && isset($essential->education_level)) {
                                switch ($essential->education_level) {
                                    case 'matric':
                                        $education_level = 'Matric';
                                        break;
                                    case 'post_matric_courses':
                                        $education_level = 'Post Matric Courses / Higher Certificate';
                                        break;
                                    case 'post_matric_diploma':
                                        $education_level = 'Post Matric Diploma';
                                        break;
                                    case 'ug':
                                        $education_level = 'Undergrad University Degree';
                                        break;
                                    case 'pg':
                                        $education_level = 'Post Grad Degree - Honours, Masters, PhD, MBA';
                                        break;
                                    case 'school_no_metric':
                                        $education_level = 'School But No Matric';
                                        break;
                                    default:
                                        $education_level = ''; // Handle unexpected values
                                        break;
                                }
                            }
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
                            //    Essential Details Ends
                           $result =[];
                           foreach($question as $qus){
                               $respone = SurveyResponse::where(['survey_id'=>$survey_id,'question_id'=>$qus->id,'response_user_id'=>$userID])->orderBy("id", "desc")->first();
                               if($respone){
                                   if($respone->skip == 'yes'){
                                       $output = 'Skip';
                                   }else{
                                       $output = $respone->answer;
                                   }
                               }else{
                                   $output = '-';
                               }
                               if($qus->qus_type == 'likert'){
                                   $qusvalue = json_decode($qus->qus_ans);
                                   $left_label = 'Least Likely';
                                   $middle_label = 'Netural';
                                   $right_label = 'Most Likely';
                                   $likert_range = 10;
                                   if(isset($qusvalue->right_label)){
                                       $right_label = $qusvalue->right_label;
                                   }
                                   if(isset($qusvalue->middle_label)){
                                       $middle_label = $qusvalue->middle_label;
                                   }
                                   if(isset($qusvalue->likert_range)){
                                       $likert_range = $qusvalue->likert_range;
                                   }
                                   if(isset($qusvalue->left_label)){
                                       $left_label = $qusvalue->left_label;
                                   }
                                   $output = intval($output);
                                   $likert_label = $output;
                                   if($likert_range <= 4 && $output <= 4){
                                       if($output == 1 || $output == 2){
                                           $likert_label = $left_label;
                                       }else{
                                           $likert_label = $right_label;
                                       }
                                   }else if($likert_range >= 5 && $output >=5){
                                       if($likert_range == 5){
                                           if($output == 1 || $output == 2){
                                               $likert_label = $left_label;
                                           }else if($output == 3){
                                               $likert_label = $middle_label;
                                           }else if($output == 4 || $output == 5){
                                               $likert_label = $right_label;
                                           }
                                       }else if($likert_range == 6){
                                           if($output == 1 || $output == 2){
                                               $likert_label = $left_label;
                                           }else if($output == 3 || $output == 4){
                                               $likert_label = $middle_label;
                                           }else if($output == 5 || $output == 6){
                                               $likert_label = $right_label;
                                           }
                                       }else if($likert_range == 7){
                                           if($output == 1 || $output == 2){
                                               $likert_label = $left_label;
                                           }else if($output == 3 || $output == 4 || $output == 5){
                                               $likert_label = $middle_label;
                                           }else if($output == 6 || $output == 7){
                                               $likert_label = $right_label;
                                           }
                                       }else if($likert_range == 8){
                                           if($output == 1 || $output == 2 || $output == 3){
                                               $likert_label = $left_label;
                                           }else if($output == 4 || $output == 5){
                                               $likert_label = $middle_label;
                                           }else if($output == 6 || $output == 7 || $output == 8){
                                               $likert_label = $right_label;
                                           }
                                       }else if($likert_range == 9){
                                           if($output == 1 || $output == 2 || $output == 3){
                                               $likert_label = $left_label;
                                           }else if($output == 4 || $output == 5 || $output == 6){
                                               $likert_label = $middle_label;
                                           }else if($output == 7 || $output == 8 || $output == 9){
                                               $likert_label = $right_label;
                                           }
                                       }else if($likert_range == 10){
                                           if($output == 1 || $output == 2 || $output == 3){
                                               $likert_label = $left_label;
                                           }else if($output == 4 || $output == 5 || $output == 6 || $output == 7){
                                               $likert_label = $middle_label;
                                           }else if($output == 8 || $output == 9 || $output == 10){
                                               $likert_label = $right_label;
                                           }
                                       }
                                   }
                                   $tempresult = [$qus->question_name => $likert_label];
                                   $result[$qus->question_name]= $likert_label;
           
                               }
                               else if($qus->qus_type == 'matrix_qus'){
                                   $result[$qus->question_name]=''; 
                                   if($output=='Skip'){
                                       $qusvalue = json_decode($qus->qus_ans); 
                                       $exiting_qus_matrix= $qus!=null ? explode(",",$qusvalue->matrix_qus): []; 
                                       foreach($exiting_qus_matrix as $op){
                                           $result[$op]='Skip'; 
                                       }
                                   }else{
                                       $output = json_decode($output);
                                       if($output!=null)
                                       foreach($output as $op){
                                           $tempresult = [$op->qus =>$op->ans];
                                           $result[$op->qus]=$op->ans; 
                                       }
                                   }
                                   
                               }else if($qus->qus_type == 'rankorder'){
                                   // $result[$qus->question_name]=''; 
                                   $qus_ans = json_decode($qus->qus_ans); 
                                   $output = json_decode($output,true);
                                   $choices= $qus_ans!=null ? explode(",",$qus_ans->choices_list): []; $i=0;
                                   foreach($choices as $qus1){
                                       // echo "<pre>";
                                       // print_r($qus1);
                                       if($output!=null){
                                           foreach($output as $op){
                                               if($qus1 == $op['id']){
                                                   $arrId= $qus->question_name.'_'.$qus1;
                                                   $result[$arrId]=$op['val'];
                                               }
                                           }
                                       }
                                   
                                   }
                               
                               }else if($qus->qus_type == 'multi_choice'){
                                   // $result[$qus->question_name]=''; 
                                   $qus_ans = json_decode($qus->qus_ans); 
                                   $output = explode(",", $output);
                                   $choices= $qus_ans!=null ? explode(",",$qus_ans->choices_list): []; $i=0;
                                   foreach($choices as $qus1){
                                       if($output!=null){
                                           foreach($output as $op){
                                               if($qus1 == $op){
                                                   $arrId= $qus->question_name.'_'.$qus1;
                                                   $result[$arrId]=$op;
                                               }
                                           }
                                       }
                                   }
                               
                               }else if($qus->qus_type == 'photo_capture'){
                                   $img = $output;
                                   $tempresult = [$qus->question_name =>$img];
                                   $result[$qus->question_name]=$img;
                               }else if($qus->qus_type=='upload'){
                                   $output1=asset('uploads/survey/'.$output);
                                   $img = $output1;
                                   $tempresult = [$qus->question_name =>$img];
                                   $result[$qus->question_name]=$img;
                               }else{
                                   $tempresult = [$qus->question_name =>$output];
                                   $result[$qus->question_name]=$output;
                               }
                           }
                           $result = array_merge($result,['Respondent Name'=>$name,'Mobile'=>$mobile_number, 'Whatsapp'=>$whatsapp_number, 'Email'=>$email, 'Age'=>$year,'Gender'=>$gender,'Highest Education Level'=>$education_level,'Employment Status'=>$employment_status,'Industry my company'=>$industry_my_company,'Personal Income'=>$personal_income,'Personal LSM'=>$personal_lsm,'Household Income'=>$household_income,'Household LSM'=>$household_lsm,'Relationship Status'=>$relationship_status,'Ethnic Group'=>$ethnic_group,'Province'=>$get_state,'Metropolitan Area'=>$get_district,'Date'=>$responseinfo,'Device ID'=>$deviceID,'Device Name'=>$device_name,'Completion Status'=>$completion_status,'Browser'=>$browser,'OS'=>$os,'Device Type'=>$device_type,'Long'=>$long,'Lat'=>$lat,'Location'=>$location,'IP Address'=>$ip_address,'Language Code'=>$lang_code,'Language Name'=>$lang_name]);
                           array_push($finalResult,$result);
                       }
                   
                       $data = getValuesUser($finalResult);
                       if($survey){
                           $survey_name = $survey->title;
                       }else{
                           $survey_name = "Survey-".$survey_id;
                       }
                       $survey_name = preg_replace('/[\\/*?:[\]]/', '', $survey_name);
                       $survey_name = substr($survey_name, 0, 31);
                       

                       $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $survey_name);
                       $spreadsheet->addSheet($sheet, 0);
                       $spreadsheet->setActiveSheetIndex(0);
                       $sheet = $spreadsheet->getActiveSheet();
               
                       // Export Data to Excel
                       $sheet->fromArray($finalResult, null, 'A1', false, false);
               
                       foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
                           $sheet->getColumnDimension($col)->setAutoSize(true);
                       }
                   }
                
                    $spreadsheet->removeSheetByIndex(count($spreadsheet->getSheetNames()) - 1);
                    
                    if($methods=='respondents_type'){
                        $fileName = 'Survey_Report_' . $user_id . '_' . date('Y-m-d') . '.xlsx';
                    }else{
                        $fileName = 'Survey_Report_' . $project_id . '_' . date('Y-m-d') . '.xlsx';
                    }
                    
                    $filePath = storage_path('app/public/' . $fileName);
                
                    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                    $writer->save($filePath);
                
                    return response()->download($filePath)->deleteFileAfterSend(true);
                    //ends
                  
                    

            }
            
            

            if ($type == 'xlsx') {
                $writer = new Xlsx($spreadsheet);
            }
            else if ($type == 'xls') {
                $writer = new Xls($spreadsheet);
            }
            
            $writer->save(public_path() . '/' . $fileName);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Content-Length: ' . filesize(public_path() . '/' . $fileName));
            
            readfile(public_path() . '/' . $fileName);
            exit;
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

    public function sanitizeSheetName($name) {
        // Remove invalid characters
        $invalidChars = ['\\', '/', '*', '?', ':', '[', ']'];
        $name = str_replace($invalidChars, '', $name);
        
        // Trim leading and trailing spaces
        $name = trim($name);
        
        // Ensure name is within the allowed length
        if (strlen($name) > 31) {
            $name = substr($name, 0, 31);
        }
    
        return $name;
    }
}
