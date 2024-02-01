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
use DB;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Exception;

class ProjectsController extends Controller
{   
    public function projects()
    {   
        try {
            return view('admin.projects.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    
    }

    public function get_all_projects(Request $request) {
		
        try {
                    if ($request->ajax()) {


                        $token = csrf_token();
                    
                        $all_datas = Projects::select('projects.*','projects.name as uname')
                        ->join('users', 'users.id', '=', 'projects.user_id') 
                        ->orderby("id","desc")
                        ->get();
                
                        
                        return Datatables::of($all_datas)
                        
                        ->addColumn('numbers', function ($all_data) {
                            return $all_data->number;
                        })  
                        ->addColumn('client', function ($all_data) {
                            return $all_data->client;
                        })  
                        ->addColumn('name', function ($all_data) {
                            return $all_data->description;
                        }) 
                        ->addColumn('creator', function ($all_data) {
                            return $all_data->uname;
                        })
                        ->addColumn('type', function ($all_data) {
                            if($all_data->type_id==1){
                                return 'Pre-Screener';
                            }else if($all_data->type_id==2){
                                return 'Pre-Task';
                            }else if($all_data->type_id==3){
                                return 'Paid  survey';
                            }else if($all_data->type_id==4){
                                return 'Unpaid  survey';
                            }else{  
                                return '-';
                            }
                        })
                        ->addColumn('reward_amount', function ($all_data) {
                            return $all_data->reward;
                        })
                        ->addColumn('project_link', function ($all_data) {
                            return $all_data->project_link;
                        })
                        ->addColumn('created', function ($all_data) {
                            return date("M j, Y, g:i A", strtotime($all_data->created_at));
                        })
                        ->addColumn('status', function ($all_data) {
                            if($all_data->status_id==1){
                                return 'Pending';
                            }else if($all_data->status_id==2){
                                return 'Active';
                            }else if($all_data->status_id==3){
                                return 'Completed';
                            }else if($all_data->status_id==4){
                                return 'Cancelled';
                            }else{  
                                return '-';
                            }
                        })
                        ->addColumn('action', function ($all_data) use($token) {
                
                            return '<div class="">
                            <div class="btn-group mr-2 mb-2 mb-sm-0">
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></button>
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class="far fa-trash-alt"></i></button>
                            </div>              
                        </div>';
                            
                        })
                        ->rawColumns(['action','numbers','client','name','creator','type','reward_amount','project_link','created','status'])      
                        ->make(true);
                            
                      
                    }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function projects_export($type) {

        $type='xlsx';

        $all_datas = Projects::select('projects.*','projects.name as uname')
        ->join('users', 'users.id', '=', 'projects.user_id') 
        ->orderby("id","desc")
        ->limit(10)
        ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Number/Code');
        $sheet->setCellValue('B1', 'Client');
        $sheet->setCellValue('C1', 'Name');
        $sheet->setCellValue('D1', 'Creator');
        $sheet->setCellValue('E1', 'Type');
        $sheet->setCellValue('F1', 'Reward Amount');
        $sheet->setCellValue('G1', 'Project Link');
        
        $rows = 2;
        $i=1;
        foreach($all_datas as $all_data){

            if($all_data->type_id==1){
                $type_val = 'Pre-Screener';
            }else if($all_data->type_id==2){
                $type_val =  'Pre-Task';
            }else if($all_data->type_id==3){
                $type_val =  'Paid  survey';
            }else if($all_data->type_id==4){
                $type_val =  'Unpaid  survey';
            }else{  
                $type_val =  '-';
            }
            
            $sheet->setCellValue('A' . $rows, $i);
            $sheet->setCellValue('B' . $rows, $all_data->number);
            $sheet->setCellValue('C' . $rows, $all_data->client);
            $sheet->setCellValue('D' . $rows, $all_data->description);
            $sheet->setCellValue('E' . $rows, $type_val);
            $sheet->setCellValue('F' . $rows, $all_data->reward);
            $sheet->setCellValue('G' . $rows, $all_data->project_link);

            
            $rows++;
            $i++;
        }

        $fileName = "project_".date('ymd').".".$type;
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