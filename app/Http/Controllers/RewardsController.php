<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Banks;
use App\Contents;
use App\Networks;
use App\Charities;
use App\Groups;
use App\Models\Rewards;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class RewardsController extends Controller
{   
    public function rewards()
    {   
        try {
            return view('admin.rewards.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
       
    }
    public function get_all_rewards(Request $request) {
		
        try {
            if ($request->ajax()) {

                $token = csrf_token();
                
                $all_datas = Rewards::select('rewards.*','respondents.name as rname','respondents.email as remail','respondents.mobile as rmobile','users.name as uname','projects.name as pname')
                ->join('respondents', 'respondents.id', '=', 'rewards.user_id') 
                ->join('users', 'users.id', '=', 'rewards.user_id') 
                ->join('projects', 'projects.id', '=', 'rewards.project_id');

                if(isset($request->id)){
                    $all_datas->where('rewards.user_id',$request->id);
                }
                $all_datas = $all_datas->orderby("rewards.id","desc")
                ->withoutTrashed()
                ->get();

                
                return Datatables::of($all_datas)
                ->addColumn('select_all', function ($all_data) {
                    return '<input class="tabel_checkbox" name="rewards[]" type="checkbox" onchange="table_checkbox(this)" id="'.$all_data->id.'">';
                })
                ->addColumn('points', function ($all_data) {
                    return $all_data->points;
                })            
                ->addColumn('status_id', function ($all_data) {
                    
                    if($all_data->status_id==1){
                        return 'Pending';
                    }else if($all_data->status_id==2){
                        return 'Approved';
                    }else if($all_data->status_id==3){
                        return '-';
                    }else if($all_data->status_id==4){
                        return 'Processed';
                    }else{  
                        return '-';
                    }

                }) 
                ->addColumn('respondent_id', function ($all_data) {
                    
                    return $all_data->rname.' - '.$all_data->remail.' - '.$all_data->rmobile;
                })    
                ->addColumn('user_id', function ($all_data) {
                    return $all_data->uname;
                }) 
                ->addColumn('project_id', function ($all_data) {
                    
                    return $all_data->pname;
                }) 
                ->addColumn('action', function ($all_data) use($token) {
        
                    return '<div class="">
                    <div class="btn-group mr-2 mb-2 mb-sm-0">
                        <button type="button" onclick="view_details(' . $all_data->id . ');" class="btn btn-primary waves-light waves-effect"><i class="fa fa-eye"></i></button>
                    </div>              
                </div>';
                    
                }) 
                ->rawColumns(['select_all','action','active','points','status_id','respondent_id','user_id','project_id'])      
                ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function view_rewards(Request $request){
        try {
            
            $data = Rewards::select('rewards.*','respondents.name as rname','respondents.email as remail','respondents.mobile as rmobile','users.name as uname','projects.name as pname')
                ->join('respondents', 'respondents.id', '=', 'rewards.user_id') 
                ->join('users', 'users.id', '=', 'rewards.user_id') 
                ->join('projects', 'projects.id', '=', 'rewards.project_id') 
                ->where('rewards.id',$request->id)
                ->first();

            return view('admin.rewards.view',compact('data'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }
     /**
     * Show the form for creating a new resource.
     */
    public function export_rewards()
    {
        try {
           
            $returnHTML = view('admin.rewards.export')->render();

            return response()->json(
                [
                    'success' => true,
                    'html_page' => $returnHTML,
                ]
            );
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }   
    }

    public function rewards_export(Request $request) {

        $module_name = $request->module_name;
        $from = date('Y-m-d',strtotime($request->start));
        $to = date('Y-m-d',strtotime($request->end));

        $type='xlsx';
     
        if($module_name=='rewards_summary_export'){

        $all_datas = DB::table('rewards')
                ->select('rewards.*')
                ->whereBetween('rewards.created_at', [$from, $to])
                ->orderby("id","desc")
                ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Month');
        $sheet->setCellValue('B1', 'Year');
        $sheet->setCellValue('C1', 'Reward Status Breakdown');
        $sheet->setCellValue('D1', 'Total Approved Rewards Amount');
        $sheet->setCellValue('E1', 'Total Processed Rewards Amount');
        $sheet->setCellValue('F1', 'Total Approved Rewards Not Yet Cashed Out Amount');
        
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

        $fileName = "rewards_month_summary_".date('ymd').".".$type;

        }else if($module_name=='rewards_summary_resp_export'){


            $all_datas = DB::table('rewards')
                ->select('rewards.*')
                ->whereBetween('rewards.created_at', [$from, $to])
                ->orderby("id","desc")
                ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Respondent Profile ID');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('C1', 'Surname');
            $sheet->setCellValue('D1', 'Phone Number');
            $sheet->setCellValue('E1', 'WhatsApp Number');
            $sheet->setCellValue('F1', 'Email');
            $sheet->setCellValue('G1', 'Reward Status Breakdown');
            $sheet->setCellValue('H1', 'Total Approved Rewards Amount');
            $sheet->setCellValue('I1', 'Total Processed Rewards Amount');
            $sheet->setCellValue('J1', 'Total Approved Rewards Not Yet Cashed Out Amount');
               
            $fileName = "rewards_resp_summary_".date('ymd').".".$type;
        }else{

        }
        
        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
            $writer->save("export/".$fileName);
            
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/export/".$fileName);
    }
    public function rewards_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $rewards = Rewards::find($id);
                $rewards->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Rewards Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}