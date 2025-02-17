<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Respondents;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Exception;
use DateTime;
use App\Models\IndustryCompany;
use DB;

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
            // Increase the maximum execution time to 300 seconds (5 minutes)
            set_time_limit(300);

            $module = $request->module;
            $resp_type = $request->show_resp_type;
            $type_method = $request->type_method;
            $type = 'xlsx';
            $batchSize = 1000;

            $styleArray = [
                'font' => [
                    'size' => 13,
                    'name' => 'Arial',
                    'bold' => true,
                    'color' => ['rgb' => 'ffffff'],
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
                ],
            ];

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

                    Respondents::join("respondent_profile", "respondent_profile.respondent_id", "=", "respondents.id")
                        ->when($type_method == 'Individual', function ($query) use ($request) {
                            $query->whereIn('respondents.id', $request->respondents);
                        })
                        ->when($type_method != 'Individual', function ($query) {
                            $query->where('respondents.active_status_id', 1);
                        })
                        ->select([
                            'respondents.id',
                            'respondents.opted_in',
                            \DB::raw('COALESCE(respondent_profile.basic_details, "") AS basic_details'),
                            \DB::raw('COALESCE(respondent_profile.essential_details, "") AS essential_details'),
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
                        })
                        ->orderBy('respondents.id', 'ASC')
                        ->orderByRaw('CASE WHEN CAST(JSON_EXTRACT(respondent_profile.essential_details, "$.personal_income_per_month") AS UNSIGNED) IS NULL OR CAST(JSON_EXTRACT(respondent_profile.essential_details, "$.personal_income_per_month") AS UNSIGNED) = 0 THEN 1 ELSE 0 END ASC')
                        ->orderByRaw('CAST(JSON_EXTRACT(respondent_profile.essential_details, "$.personal_income_per_month") AS UNSIGNED) ASC')
                        ->orderByRaw('CAST(JSON_EXTRACT(respondent_profile.essential_details, "$.household_income_per_month") AS UNSIGNED) ASC')
                        ->chunk($batchSize, function ($all_datas) use (&$rows, $sheet, $styleArray2, $styleArray3) {
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
                        });
                }
            }

            $fileName = $module . "_" . $resp_type . "_" . date('ymd') . "." . $type;
            $writer = new Xlsx($spreadsheet);
            $writer->save($fileName);

            return response()->download($fileName)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            $errorMessage = sprintf("Error: %s in %s on line %d", $e->getMessage(), $e->getFile(), $e->getLine());
            throw new \Exception($errorMessage);
        }
    }
}