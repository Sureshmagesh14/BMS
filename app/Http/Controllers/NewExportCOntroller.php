<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Respondents;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Exception;
use DateTime;
use App\Models\IndustryCompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class NewExportController extends Controller
{
    private $cached_data = [];
    private $batch_size = 2000; // Increased batch size
    
    // Cache frequently accessed data
    private function initializeCache()
    {
        // Cache income data
        $this->cached_data['income'] = Cache::remember('income_data', 3600, function () {
            return DB::table('income_per_month')->pluck('income', 'id')->toArray();
        });

        // Cache state data
        $this->cached_data['state'] = Cache::remember('state_data', 3600, function () {
            return DB::table('state')->pluck('state', 'id')->toArray();
        });

        // Cache district data
        $this->cached_data['district'] = Cache::remember('district_data', 3600, function () {
            return DB::table('district')->pluck('district', 'id')->toArray();
        });

        // Cache industry companies
        $this->cached_data['companies'] = Cache::remember('company_data', 3600, function () {
            return IndustryCompany::pluck('company', 'id')->toArray();
        });
    }

    private function formatPhoneNumber($number) {
        if (empty($number) || $number === '-') return '-';
        $number = preg_replace('/\s+/', '', $number);
        $length = strlen($number);
        return match(true) {
            $length === 9 => '27' . $number,
            $length === 10 && $number[0] === '0' => '27' . substr($number, 1),
            $length === 11 && str_starts_with($number, '27') => $number,
            $length === 12 && str_starts_with($number, '+27') => $number,
            default => '-'
        };
    }

    private function calculateAge($dob) {
        if (empty($dob) || $dob === '0000-00-00') return '';
        try {
            $dobDate = DateTime::createFromFormat('Y-m-d', $dob) ?: DateTime::createFromFormat('Y/m/d', $dob);
            return $dobDate ? (new DateTime())->diff($dobDate)->y : '';
        } catch (Exception $e) {
            return '';
        }
    }

    private static $employmentStatuses = [
        'emp_full_time' => 'Employed Full-Time',
        'emp_part_time' => 'Employed Part-Time',
        'self' => 'Self-Employed',
        'study' => 'Studying Full-Time (Not Working)',
        'working_and_studying' => 'Working & Studying',
        'home_person' => 'Stay at Home Person',
        'retired' => 'Retired',
        'unemployed' => 'Unemployed',
        'other' => 'Other'
    ];

    private static $educationLevels = [
        'matric' => 'Matric',
        'post_matric_courses' => 'Post Matric Courses / Higher Certificate',
        'post_matric_diploma' => 'Post Matric Diploma',
        'ug' => 'Undergrad University Degree',
        'pg' => 'Post Grad Degree - Honours, Masters, PhD, MBA',
        'school_no_metric' => 'School But No Matric'
    ];

    private function getEmploymentStatus($status) {
        return self::$employmentStatuses[$status] ?? '';
    }

    private function getIndustryCompany($company_id) {
        return $this->cached_data['companies'][$company_id] ?? '';
    }

    private function getEducationLevel($level) {
        return self::$educationLevels[$level] ?? '';
    }

    private function getIncome($income_id) {
        return $this->cached_data['income'][$income_id] ?? '-';
    }

    private function getState($state_id) {
        return $this->cached_data['state'][$state_id] ?? '-';
    }

    private function getDistrict($district_id) {
        return $this->cached_data['district'][$district_id] ?? '-';
    }

    private function setupExtendedHeaders($sheet, $headerStyle)
    {
        // Auto-size columns Y through BD
        foreach (range('Y', 'BD') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $headers = [
            'PID', 'First Name', 'Last Name', 'Mobile Number', 'WA Number', 'Email', 'Age',
            'Relationship Status', 'Ethnic Group / Race', 'Gender', 'Highest Education Level',
            'Employment Status', 'Industry my company is in', 'Job Title', 'Personal Income per month',
            'Personal LSM', 'HHI per Month', 'Household LSM', 'Province', 'Metropolitan Area',
            'Suburb', 'No. of people living in your household', 'Number of children',
            'Number of vehicles', 'Which best describes the role in your business / organization?',
            'What is the number of people in your organisation / company?',
            'Which bank do you bank with (which is your bank main)', 'Which is your secondary bank?',
            'Home Language', 'Secondary Language',
            // Children
            'Child 1 - Birth Year', 'Child 1 - Gender',
            'Child 2 - Birth Year', 'Child 2 - Gender',
            'Child 3 - Birth Year', 'Child 3 - Gender',
            'Child 4 - Birth Year', 'Child 4 - Gender',
            // Cars
            'Car 1 - Brand', 'Car 1 - Type of Vehicle', 'Car 1 - Model', 'Car 1 - Year',
            'Car 2 - Brand', 'Car 2 - Type of Vehicle', 'Car 2 - Model', 'Car 2 - Year',
            'Car 3 - Brand', 'Car 3 - Type of Vehicle', 'Car 3 - Model', 'Car 3 - Year',
            'Car 4 - Brand', 'Car 4 - Type of Vehicle', 'Car 4 - Model', 'Car 4 - Year',
            'Opted in', 'Last Updated'
        ];

        $sheet->fromArray([$headers], null, 'A1');
        $sheet->getStyle('A1:BF1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);
    }

    private static $businessOrgTypes = [
        'owner_director' => 'Owner / director (CEO, COO, CFO)',
        'senior_manager' => 'Senior Manager',
        'mid_level_manager' => 'Mid-Level Manager',
        'team_leader' => 'Team leader / Supervisor',
        'general_worker' => 'General Worker (e.g., Admin, Call Centre Agent, Nurse, Teacher, Carer, etc.)',
        'worker_etc' => 'Worker (e.g., Security Guard, Cleaner, Helper, etc.)',
        'other' => 'Other'
    ];

    private static $orgCompanyTypes = [
        'just_me' => 'Just Me (Sole Proprietor)',
        '2_5' => '2-5 people',
        '6_10' => '6-10 people',
        '11_20' => '11-20 people',
        '21_30' => '21-30 people',
        '31_50' => '31-50 people',
        '51_100' => '51-100 people',
        '101_250' => '101-250 people',
        '251_500' => '251-500 people',
        '500_1000' => '500-1000 people',
        'more_than_1000' => 'More than 1000 people'
    ];

    private function processExtendedData($data)
    {
        // First get the basic respondent data
        $basicData = $this->processEssentialRespondentData($data);
        
        // Decode extended details safely
        $extended = json_decode($data->extended_details ?? '{}');
        
        // Process business organization role - following first code's logic exactly
        $business_org = null;
        $business_org_code = '';
        
        if (isset($extended) && is_object($extended)) {
            if (isset($extended->business_org)) {
                if ($extended->business_org === 'other') {
                    $business_org_code = isset($extended->business_org_other) ? $extended->business_org_other : 'Other';
                } else {
                    $business_org_code = $extended->business_org;
                }
            }
        }

        $businessOrgTypes = [
            'owner_director'  => 'Owner / director (CEO, COO, CFO)',
            'senior_manager'  => 'Senior Manager',
            'mid_level_manager'=> 'Mid-Level Manager',
            'team_leader'     => 'Team leader / Supervisor',
            'general_worker'  => 'General Worker (e.g., Admin, Call Centre Agent, Nurse, Teacher, Carer, etc.)',
            'worker_etc'      => 'Worker (e.g., Security Guard, Cleaner, Helper, etc.)',
            'other'           => 'Other',
        ];

        $business_org = isset($businessOrgTypes[$business_org_code]) ? $businessOrgTypes[$business_org_code] : ucfirst($business_org_code);

        // Process organization size - following first code's logic exactly
        $org_company = null;
        $org_company_code = '';

        if (isset($extended) && is_object($extended)) {
            if (isset($extended->org_company)) {
                $org_company_code = $extended->org_company;
            }
        }

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

        $org_company = isset($orgCompanyTypes[$org_company_code]) ? $orgCompanyTypes[$org_company_code] : '';

        // Process home language
        $home_lang = null;
        if ($extended && isset($extended->home_lang)) {
            $home_lang = $extended->home_lang == 'other' ? $extended->home_lang_other : $extended->home_lang;
        }

        // Process secondary language
        $secondary_home_lang = null;
        if ($extended && isset($extended->secondary_home_lang)) {
            $secondary_home_lang = $extended->secondary_home_lang == 'other' ? $extended->secondary_home_lang_other : $extended->secondary_home_lang;
        }

        // Process main bank
        $bank_main = null;
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

        // Process secondary bank
        $secondary_bank_main = null;
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

        // Process children data
        $children_data = json_decode($data->children_data, true) ?? [];
        $childrenInfo = [];
        if (!empty($children_data) && is_array($children_data)) {
            foreach ($children_data as $children) {
                $childrenInfo[] = $children['date'] ?? '';
                $childrenInfo[] = ucfirst($children['gender'] ?? '');
            }
        }

        // Pad children data to ensure consistent length
        while (count($childrenInfo) < 8) { // Space for 4 children (birth year and gender)
            $childrenInfo[] = '';
        }

        // Process vehicle data
        $vehicle_data = json_decode($data->vehicle_data, true) ?? [];
        $vehicleInfo = [];
        
        for ($i = 0; $i < 4; $i++) { // Space for 4 vehicles
            if (isset($vehicle_data[$i])) {
                $brand_id = $vehicle_data[$i]['brand'] ?? null;
                $get_vehicle = null;
                if ($brand_id) {
                    $get_vehicle = DB::table('vehicle_master')->where('id', $brand_id)->first();
                }
                $vehicle_name = $get_vehicle ? $get_vehicle->vehicle_name : '-';
                
                $vehicleInfo[] = $vehicle_name;
                $vehicleInfo[] = $vehicle_data[$i]['type'] ?? '';
                $vehicleInfo[] = isset($vehicle_data[$i]['model']) ? ucfirst($vehicle_data[$i]['model']) : '';
                $vehicleInfo[] = $vehicle_data[$i]['year'] ?? '';
            } else {
                $vehicleInfo[] = '';
                $vehicleInfo[] = '';
                $vehicleInfo[] = '';
                $vehicleInfo[] = '';
            }
        }

        // Process dates
        $opted_in = ($data->opted_in != null) ? date("d-m-Y", strtotime($data->opted_in)) : '';
        $updated_at = ($data->updated_at != null) ? date("d-m-Y", strtotime($data->updated_at)) : '';

        unset($basicData[24]);
        unset($basicData[25]);

        // Return all data in the correct order to match the columns
        return array_merge(
            $basicData,
            [
                $business_org ?? '', // Column Y
                $org_company ?? '', // Column Z
                $bank_main ?? '', // Column AA
                $secondary_bank_main ?? '', // Column AB
                ucfirst($home_lang ?? ''), // Column AC
                ucfirst($secondary_home_lang ?? ''), // Column AD
            ],
            $childrenInfo, // Columns AE through AL
            $vehicleInfo, // Columns AM through BB
            [
                $opted_in, // Column BC
                $updated_at // Column BD
            ]
        );
    }

    private function getBusinessOrg($extended)
    {
        if (empty($extended) || !isset($extended->business_org)) return '';
        
        if ($extended->business_org === 'other') {
            return $extended->business_org_other ?? 'Other';
        }
        
        return self::$businessOrgTypes[$extended->business_org] ?? '';
    }

    private function getOrgCompany($extended)
    {
        if (empty($extended) || !isset($extended->org_company)) return '';
        return self::$orgCompanyTypes[$extended->org_company] ?? '';
    }

    private function getBankInfo($bankId, $otherBank)
    {
        if (empty($bankId)) return '';
        if ($bankId === 'other') return $otherBank ?? '';
        
        return Cache::remember("bank_$bankId", 3600, function () use ($bankId) {
            $bank = DB::table('banks')
                ->where('id', $bankId)
                ->where('active', 1)
                ->first();
            return $bank ? $bank->bank_name : '';
        });
    }

    private function getLanguage($lang, $otherLang)
    {
        if (empty($lang)) return '';
        return $lang === 'other' ? ($otherLang ?? '') : $lang;
    }

    private function processChildrenData($children_data)
    {
        $result = array_fill(0, 8, ''); // Space for 4 children (birth year and gender)
        
        if (!empty($children_data) && is_array($children_data)) {
            foreach ($children_data as $index => $child) {
                if ($index >= 4) break; // Maximum 4 children
                $baseIndex = $index * 2;
                $result[$baseIndex] = $child['date'] ?? '';
                $result[$baseIndex + 1] = ucfirst($child['gender'] ?? '');
            }
        }
        
        return $result;
    }

    private function processVehicleData($vehicle_data)
    {
        $result = array_fill(0, 16, ''); // Space for 4 vehicles (brand, type, model, year)
        
        if (!empty($vehicle_data) && is_array($vehicle_data)) {
            foreach ($vehicle_data as $index => $vehicle) {
                if ($index >= 4) break; // Maximum 4 vehicles
                $baseIndex = $index * 4;
                
                $brand = '-';
                if (!empty($vehicle['brand'])) {
                    $brand = Cache::remember("vehicle_{$vehicle['brand']}", 3600, function () use ($vehicle) {
                        $vehicle_master = DB::table('vehicle_master')->where('id', $vehicle['brand'])->first();
                        return $vehicle_master ? $vehicle_master->vehicle_name : '-';
                    });
                }
                
                $result[$baseIndex] = $brand;
                $result[$baseIndex + 1] = $vehicle['type'] ?? '';
                $result[$baseIndex + 2] = ucfirst($vehicle['model'] ?? '');
                $result[$baseIndex + 3] = $vehicle['year'] ?? '';
            }
        }
        
        return $result;
    }

    public function export_all(Request $request)
    {
        $module             = $request->module;
        $methods            = $request->methods;
        $start              = $request->start;
        $end                = $request->end;
        $show_resp_type     = $request->show_resp_type;
        $show_cashout_val   = $request->show_cashout_val;
        $resp_status        = $request->resp_status;
        $type_method        = $request->type_method;
        $all                = $request->all;
        $projects           = $request->projects;
        $respondents        = $request->respondents;
        $users              = $request->users;
        $respondents_survey = $request->respondents_survey;
        $action             = $request->action;

        try {
            ini_set('memory_limit', '1024M');
            // Increase execution time to 15 minutes
            set_time_limit(900);
            $this->initializeCache();
    
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            $headerStyle = $this->getHeaderStyle();
            $rowStyle = $this->getRowStyle();
            $indentedStyle = $this->getIndentedStyle();
    
            if ($module === 'Respondents info') {
                if ($show_resp_type === 'simple') {
                    $this->setupBasicHeaders($sheet, $headerStyle);
                    $processMethod = 'processBasicRespondentData';
                }
                elseif ($show_resp_type === 'essential') {
                    $this->setupEssentialHeaders($sheet, $headerStyle);
                    $processMethod = 'processEssentialRespondentData';
                }
                elseif ($show_resp_type === 'extended') {
                    $this->setupExtendedHeaders($sheet, $headerStyle);
                    $processMethod = 'processExtendedData';
                }
    
                $query = $this->buildRespondentsQuery($request);
                
                $rows = 2;
                $query->chunk($this->batch_size, function ($all_datas) use (&$rows, $sheet, $rowStyle, $indentedStyle, $processMethod) {
                    $rowData = [];
                    foreach ($all_datas as $data) {
                        $rowData[] = $this->$processMethod($data);
                        $rows++;
                    }
                    
                    $sheet->fromArray($rowData, null, 'A' . ($rows - count($rowData)));

                    $setRange1 = 'A' . ($rows - count($rowData)) . ':';
                    $setRange2 = '';

                    if($processMethod == 'processBasicRespondentData'){
                        $setRange2 = 'H' . ($rows - 1);
                    }
                    else if($processMethod == 'processEssentialRespondentData'){
                        $setRange2 = 'Z' . ($rows - 1);
                    }
                    else if($processMethod == 'processExtendedData'){
                        $setRange2 = 'BF' . ($rows - 1);
                    }
                    
                    $rangeMerge = $setRange1 . $setRange2;
                    $sheet->getStyle($rangeMerge)->applyFromArray($rowStyle);
                });
            }
    
            $writer = new Xlsx($spreadsheet);
            $writer->setPreCalculateFormulas(false);
            
            $fileName = sprintf('%s_%s_%s.xlsx', 
                $request->module,
                $request->show_resp_type,
                date('ymd')
            );
            
            $writer->save($fileName);
            
            return response()->download($fileName)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            \Log::error(sprintf(
                "Export error: %s in %s on line %d\nStack trace: %s",
                $e->getMessage(),
                $e->getFile(),
                $e->getLine(),
                $e->getTraceAsString()
            ));
            
            // Return an informative error message to help with debugging
            return response()->json([
                'error' => 'An error occurred while processing your request.',
                'message' => $e->getMessage(),
                'location' => sprintf('%s line %d', $e->getFile(), $e->getLine())
            ], 500);
        }
    }

    private function buildRespondentsQuery(Request $request)
    {
       
        $projects           = $request->projects;
        $respondents        = $request->respondents;
        $users              = $request->users;
        $respondents_survey = $request->respondents_survey;

        $data = Respondents::join("respondent_profile", "respondent_profile.respondent_id", "=", "respondents.id")
            ->when($request->type_method == 'Individual', function ($query) use ($respondents) {
                $query->whereIn('respondents.id', [$respondents]);
            })
            ->select([
                'respondents.id',
                'respondents.opted_in',
                DB::raw('COALESCE(respondent_profile.basic_details, "") AS basic_details'),
                DB::raw('COALESCE(respondent_profile.essential_details, "") AS essential_details'),
                DB::raw('COALESCE(respondent_profile.extended_details, "") AS extended_details'),
                DB::raw('COALESCE(respondent_profile.children_data, "[]") AS children_data'),
                DB::raw('COALESCE(respondent_profile.vehicle_data, "[]") AS vehicle_data'),
                'respondent_profile.updated_at'
            ])
            ->where('respondents.active_status_id', 1)
            // ->whereNotExists(function ($query) {
            //     $query->select(DB::raw(1))
            //         ->from('respondent_tag')
            //         ->whereColumn('respondent_tag.respondent_id', '=', 'respondents.id')
            //         ->where('respondent_tag.tag_id', 1);
            // })
            ->orderBy('respondents.id');

        return $data;
    }

    private function processEssentialRespondentData($data)
    {
        $basic = json_decode($data->basic_details);
        $essential = json_decode($data->essential_details);

        return [
            $data->id,
            $basic->first_name ?? '',
            $basic->last_name ?? '',
            $this->formatPhoneNumber($basic->mobile_number ?? '-'),
            $this->formatPhoneNumber($basic->whatsapp_number ?? '-'),
            $basic->email ?? '',
            $this->calculateAge($basic->date_of_birth ?? ''),
            ucfirst($essential->relationship_status ?? ''),
            ucfirst($essential->ethnic_group ?? ''),
            ucfirst($essential->gender ?? ''),
            $this->getEducationLevel($essential->education_level ?? ''),
            $this->getEmploymentStatus($essential->employment_status ?? ''),
            $this->getIndustryCompany($essential->industry_my_company ?? ''),
            $essential->job_title ?? '',
            $this->getIncome($essential->personal_income_per_month ?? ''),
            $essential->personal_income_per_month ?? '',
            $this->getIncome($essential->household_income_per_month ?? ''),
            $essential->household_income_per_month ?? '',
            $this->getState($essential->province ?? ''),
            $this->getDistrict($essential->suburb ?? ''),
            $essential->metropolitan_area ?? '',
            $essential->no_houehold ?? '',
            $essential->no_children ?? '',
            $essential->no_vehicle ?? '',
            $data->opted_in ? date("d-m-Y", strtotime($data->opted_in)) : '',
            $data->updated_at ? date("d-m-Y", strtotime($data->updated_at)) : ''
        ];
    }

    public function processBasicRespondentData($data){
        $basic = json_decode($data->basic_details);

        return [
            $data->id,
            $basic->first_name ?? '',
            $basic->last_name ?? '',
            $this->formatPhoneNumber($basic->mobile_number ?? '-'),
            $this->formatPhoneNumber($basic->whatsapp_number ?? '-'),
            $basic->email ?? '',
            $this->calculateAge($basic->date_of_birth ?? ''),
            $basic->date_of_birth ?? ''
        ];
    }

    private function setupBasicHeaders($sheet, $headerStyle) {
        $headers = ['PID', 'First Name', 'Last Name', 'Mobile Number', 'WA Number', 'Email', 'Age','Date of Birth'];

        $sheet->fromArray([$headers], null, 'A1');
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);
    }

    private function setupEssentialHeaders($sheet, $headerStyle)
    {
        $headers = [
            'PID', 'First Name', 'Last Name', 'Mobile Number', 'WA Number', 'Email', 'Age',
            'Relationship Status', 'Ethnic Group / Race', 'Gender', 'Highest Education Level',
            'Employment Status', 'Industry my company is in', 'Job Title', 'Personal Income per month',
            'Personal LSM', 'HHI per month', 'Household LSM', 'Province', 'Metropolitan Area',
            'Suburb', 'No. of people living in your household', 'Number of children',
            'Number of vehicles', 'Opted in', 'Last Updated'
        ];

        $sheet->fromArray([$headers], null, 'A1');
        $sheet->getStyle('A1:Z1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);
    }

    private function getHeaderStyle()
    {
        return [
            'font' => [
                'size' => 13,
                'name' => 'Arial',
                'bold' => true,
                'color' => ['rgb' => 'ffffff'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0f609b'],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
    }

    private function getRowStyle()
    {
        return [
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
                'indent' => 1
            ],
        ];
    }

    private function getIndentedStyle()
    {
        return [
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
    }
}