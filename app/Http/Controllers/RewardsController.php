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
    public function index()
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
                $inside_form = $request->inside_form;
                
                $all_datas = Rewards::select('rewards.*','respondents.name as rname','respondents.email as remail','respondents.mobile as rmobile','users.name as uname','projects.name as pname')
                    ->leftjoin('respondents', function ($joins) {
                        $joins->on('respondents.id','=','rewards.respondent_id');
                    })
                    ->leftjoin('users', function ($joins) {
                        $joins->on('users.id','=','rewards.user_id');
                    })
                    ->leftjoin('projects', function ($joins) {
                        $joins->on('projects.id','=','rewards.project_id');
                    });

                    if(isset($request->id)){
                        if($inside_form == 'users'){
                            $all_datas->where('rewards.user_id',$request->id);
                        }
                        elseif($inside_form == 'projects'){
                            $all_datas->where('rewards.project_id',$request->id);
                        }
                        elseif($inside_form == 'respondents'){
                            $all_datas->where('rewards.respondent_id',$request->id);
                        }
                    }
                
                $all_datas = $all_datas->orderby("rewards.id","desc")->withoutTrashed()->get();
                
                return Datatables::of($all_datas)
                    ->addColumn('select_all', function ($all_data) {
                        return '<input class="tabel_checkbox" name="rewards[]" type="checkbox" onchange="table_checkbox(this,\'rewards_table\')" id="'.$all_data->id.'">';
                    })
                    ->addColumn('id_show', function ($all_data) {
                        $view_route = route("view_rewards",$all_data->id);
                        return '<a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                            data-bs-original-title="View Rewards" class="waves-light waves-effect">
                            '.$all_data->id.'
                        </a>';
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
                    ->addColumn('points', function ($all_data) {
                        return $all_data->points / 10;
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
                        $view_route = route("view_rewards",$all_data->id);
                        return '<div class="">
                            <div class="btn-group mr-2 mb-2 mb-sm-0">
                                <a href="#!" data-url="'.$view_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                    data-bs-original-title="View Rewards" class="btn btn-primary waves-light waves-effect">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                        </div>';
                        
                    })
                    ->rawColumns(['id_show','select_all','action','status_id','respondent_id','user_id','project_id'])      
                    ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function view_rewards(string $id){
        try {
            
            $data= Rewards::select('rewards.*','respondents.name as rname','respondents.email as remail','respondents.mobile as rmobile','users.name as uname','projects.name as pname')
            ->leftjoin('respondents', function ($joins) {
                $joins->on('respondents.id','=','rewards.respondent_id');
            })
            ->leftjoin('users', function ($joins) {
                $joins->on('users.id','=','rewards.user_id');
            })
            ->leftjoin('projects', function ($joins) {
                $joins->on('projects.id','=','rewards.project_id');
            });

            $data = $data->where('rewards.id',$id)->first();

                $returnHTML = view('admin.rewards.view',compact('data'))->render();

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

    public function change_rewards_status(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $data=array('status_id'=>2);

                $reward_data = Rewards::where('id',$id)->first();
                $project_id = $reward_data->project_id;
                $respondents = $reward_data->respondent_id;

                //email starts
                $proj = Projects::where('id',$project_id)->first();
                $resp = Respondents::where('id',$respondents)->first();
                
                if($proj->name!='')
                {
                    $to_address = $resp->email;
                    //$to_address = 'hemanathans1@gmail.com';
                    $resp_name = $resp->name.' '.$resp->surname;
                    $proj_name = $proj->name;
                    $data = ['subject' => 'Rewards Approved','name' => $resp_name,'project' => $proj_name,'type' => 'reward_approve'];
                
                    Mail::to($to_address)->send(new WelcomeEmail($data));
                }
                //email ends

                $rewards = Rewards::whereIn('id', [$id])->update($data);
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Rewards Status Changed'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function rewards_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            
            // foreach($all_id as $id){
            //     $rewards = Rewards::find($id);
            //     $rewards->delete();
            // }

            Rewards::whereIn('id', $all_id)->whereNull('cashout_id')->delete();

            // $get_cashout = DB::table('respondents as resp')->select('resp.account_number', 'resp.account_holder', 'cashouts.*')
            // ->join('cashouts', 'resp.id', 'cashouts.respondent_id')
            // ->where('cashouts.type_id', '!=', 3)
            // ->where('resp.id', $id)->orderBy('cashouts.id', 'DESC')->first();

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