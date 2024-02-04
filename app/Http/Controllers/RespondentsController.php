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
use DB;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class RespondentsController extends Controller
{   
    public function respondents()
    {   
        try {
            if (!Auth::check()) {
                return redirect("/")->withSuccess('You are not allowed to access');
            }
            
            return view('admin.respondents.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }
    public function get_all_respondents(Request $request) {
		
        try {
                if ($request->ajax()) {

                $token = csrf_token();

                $all_datas = DB::table('respondents')
                ->orderby("id","desc")
                ->get();
             

                return Datatables::of($all_datas)
                ->addColumn('name', function ($all_data) {
                    return $all_data->name;
                })  
                ->addColumn('surname', function ($all_data) {
                    return $all_data->surname;
                })  
                ->addColumn('mobile', function ($all_data) {
                    return $all_data->mobile;
                })  
                ->addColumn('whatsapp', function ($all_data) {
                    return $all_data->whatsapp;
                })  
                ->addColumn('email', function ($all_data) {
                    return $all_data->email;
                }) 
                ->addColumn('age', function ($all_data) {

                    $dob=$all_data->date_of_birth;
                    $diff = (date('Y') - date('Y',strtotime($dob)));
                    return $diff;
                })
                ->addColumn('gender', function ($all_data) {
                    return '-';
                })
                ->addColumn('race', function ($all_data) {
                    return '-';
                })
                ->addColumn('status', function ($all_data) {
                    return '-';
                })
                ->addColumn('profile_completion', function ($all_data) {
                    return '-';
                })
                ->addColumn('inactive_until', function ($all_data) {
                    return '-';
                })
                ->addColumn('opeted_in', function ($all_data) {
                    return '-';
                })
                ->rawColumns(['name','surname','mobile','whatsapp','email','age','gender','race','status','profile_completion','inactive_until','opeted_in'])      
                ->make(true);
                }
                return DataTables::queryBuilder($all_datas)->toJson();
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function respondent_export($arg) {
        
        $type='xlsx';

        if($arg=='deact'){
            $active = 2;
        }else{
            $active = 1;
        }

        $all_datas = DB::table('respondents')
            ->where("active_status_id",$active)
            ->orderby("id","desc")
            ->limit(10)
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'Surname');
        $sheet->setCellValue('C1', 'Phone');
        $sheet->setCellValue('D1', 'Phone 2');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Age');
        $sheet->setCellValue('G1', 'Gender');
        
        $rows = 2;
        $i=1;
        foreach($all_datas as $all_data){

            $dob=$all_data->date_of_birth;
            $diff = (date('Y') - date('Y',strtotime($dob)));
            
            $sheet->setCellValue('A' . $rows, $i);
            $sheet->setCellValue('B' . $rows, $all_data->name);
            $sheet->setCellValue('C' . $rows, $all_data->surname);
            $sheet->setCellValue('D' . $rows, $all_data->mobile);
            $sheet->setCellValue('E' . $rows, $all_data->whatsapp);
            $sheet->setCellValue('F' . $rows, $all_data->email);
            $sheet->setCellValue('G' . $rows, $diff);

            
            $rows++;
            $i++;
        }

        $fileName = "deactivated_respondents_".date('ymd').".".$type;
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