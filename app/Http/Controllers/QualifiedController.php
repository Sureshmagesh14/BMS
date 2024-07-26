<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\WelcomeEmail;
use App\Models\Banks;
use App\Models\Contents;
use App\Models\Groups;
use App\Models\Respondents;
use App\Models\RespondentProfile;
use App\Models\Rewards;
use App\Models\Users;
use App\Models\PasswordResetsViaPhone;
use App\Models\Projects;
use App\Models\Cashout;
use App\Models\Networks;
use App\Models\Charities;
use App\Models\QualifiedRespondent;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Mail;
use Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use Config;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;

class QualifiedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.qualified.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function get_all_qualified(Request $request){
        try {
            if ($request->ajax()) {
                $all_datas = QualifiedRespondent::select('qualified_respondent.*','respondents.name','respondents.surname')
                    ->join('respondents','respondents.id', 'qualified_respondent.respondent_id');
                    if(isset($request->id)){
                        if($request->inside_form == 'projects'){
                            $all_datas->where('qualified_respondent.project_id',$request->id);
                        }
                    }
                $all_datas = $all_datas->where('status',1)->orderby("qualified_respondent.id","desc")->get();

                return Datatables::of($all_datas)
                    ->addColumn('select_all', function ($all_data) {
                        return '<input class="tabel_checkbox" name="projects[]" type="checkbox" onchange="table_checkbox(this,\'projects_table\')" id="'.$all_data->id.'">';
                    })
                    ->addColumn('respondent_id', function ($all_data) {
                        return $all_data->respondent_id;
                    })
                    ->addColumn('name', function ($all_data) {
                        return $all_data->name;
                    })
                    ->addColumn('surname', function ($all_data) {
                        return $all_data->surname;
                    })
                    ->addColumn('points', function ($all_data) {
                        return ($all_data->points != 0) ? $all_data->points/ 10 : 0;
                    })
                    ->addColumn('status', function ($all_data) {
                        return ($all_data->status == 1) ? 'Qualified' : 'Not-Qualified';
                    })
                    ->addColumn('created_at', function ($all_data) {
                        if(isset($all_data->created_at)){
                            $created_at=date("Y-m-d, g:i A", strtotime($all_data->created_at));
                        }else{
                            $created_at='-';
                        }
                        return $created_at;
                    })
                    ->addColumn('action', function ($all_data) {
                        $edit_route = route("projects.edit",$all_data->id);
                        $view_route = route("projects.show",$all_data->id);
                        $copy_route = route("projects_copy",$all_data->id);
                        $design = '<div class="col-md-2">
                            <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                                title="Action" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-center">
                                <li class="list-group-item">
                                    <a href="'.$view_route.'" data-bs-original-title="View Project" class="rounded waves-light waves-effect">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                </li>';
                                if (str_contains(url()->previous(), '/admin/projects')){
                                    $design .= '<li class="list-group-item">
                                        <a href="#!" id="deattach_projects" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                            <i class="far fa-trash-alt"></i> Deattach
                                        </a>
                                    </li>';
                                }
                                else{
                                    $design .= '<li class="list-group-item">
                                        <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                            data-bs-original-title="Edit Project" class="rounded waves-light waves-effect">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#!" id="delete_projects" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                            <i class="far fa-trash-alt"></i> Delete
                                        </a>
                                    </li>';
                                }
                            $design .= '</ul>
                        </div>';

                        return $design;
                        
                    })
                    ->rawColumns(['select_all','respondent_id','name','points','status','created_at','action'])      
                    ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function attach_qualified_respondents(Request $request){
        try {
            
            $project_id = $request->project_id;
            
            if($project_id == 0){
                $project_all = Projects::select('projects.id','projects.name')->orderBy('name','ASC')->get();
                $returnHTML = view('admin.qualified.attach', compact('project_all'))->render();
            }
            else{
                $projects = Projects::select('projects.id','projects.name')->where('projects.id',$project_id)->first();
                $get_resp = DB::table('project_respondent as pro_resp')->select('resp.*')
                    ->join('respondents as resp', 'pro_resp.respondent_id', 'resp.id')
                    ->where('pro_resp.project_id',$project_id)->get();
                $returnHTML = view('admin.qualified.attach_inside', compact('projects','project_id', 'get_resp'))->render();
            }

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

    public function get_resp_details(Request $request){
        $select = '<option value="" disabled>Select Respondent</option>';
        $project_id = $request->project_id;

        $get_resp = DB::table('project_respondent as pro_resp')->select('resp.*')
            ->join('respondents as resp', 'pro_resp.respondent_id', 'resp.id')
            ->where('pro_resp.project_id',$project_id)->get();

        if(count($get_resp) > 0){
            foreach($get_resp as $resp){
                $select .= '<option value="'.$resp->id.'">'.$resp->name.' '.$resp->surname.'</option>';
            }
        }
        else{
            $select .= '<option value="">OPPS! No Respondent</option>';
        }

        return $select;
    }

    public function qualified_respondent_attach_store(Request $request){
        try {
            $project_id = $request->project_id;
            $respondents = $request->respondents;

            $projects = Projects::where('id',$project_id)->first();

            if($projects != null){
                foreach($respondents as $resp){
                    if (DB::table('qualified_respondent')->where('project_id', $projects->id)->where('respondent_id', $resp)->doesntExist()) {
                        $insert = array(
                            'respondent_id' => $resp,
                            'project_id' => $projects->id,
                            'points' => $projects->reward,
                            'status' => 1
                        );

                        QualifiedRespondent::insert($insert);
                    }
                }
            }

            return array('text_status' => true, 'message' => 'Selected Respondent is Qualified');
        }
        catch (Exception $e) {
            return array('text_status' => false, 'message' => 'Something Went Wrong');
            throw new Exception($e->getMessage());
        }
    }


    public function import_qualified_respondents(Request $request){
        try {
            $project_id = $request->project_id;
            $projects = Projects::select('projects.id','projects.name')->where('projects.id',$project_id)->first();
            $project_all = Projects::select('projects.id','projects.name')->orderBy('name','ASC')->get();

            $returnHTML = view('admin.projects.import_qualified_respondent', compact('projects','project_id','project_all'))->render();

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

    public function store_qualified_respondents(Request $request)
    {
        $project_id = $request->project_id;
        $file = $request->file('file');
        
        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'Please upload a file');
        }
    
        // File Details 
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
    
        // Validate File Extension
        if (strtolower($extension) !== 'csv') {
            return redirect()->back()->with('error', 'Invalid File Extension, Please Upload CSV File Format');
        }
    
        // File upload location
        $location = 'uploads/csv/'.$project_id;
        // Ensure directory exists
        if (!file_exists($location)) {
            mkdir($location, 0777, true);
        }
    
        // Upload file
        $file->move($location, $filename);
        // Import CSV to Database
        $filepath = public_path($location . "/" . $filename);
    
        $file = fopen($filepath, "r");
    
        $importData_arr = [];
        $i = 0;
        $col = 1;
    
        try {
            DB::beginTransaction();
    
            while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                $num = count($filedata);
    
                // Skip first row
                if ($i == 0) {
                    $i++;
                    continue;
                }
    
                if ($num == $col) {
                    foreach ($filedata as $respondent_id) {
                        // Check if the project_id exists in the projects table
                        $project_exists = DB::table('projects')
                            ->where('id', $project_id)
                            ->exists();
    
                        if (!$project_exists) {
                            DB::rollback();
                            fclose($file);
                            return redirect()->back()->with('error', "Project ID {$project_id} does not exist.");
                        }
    
                        // Check if the project_id and respondent_id exist in the project_respondent table
                        $exists = DB::table('project_respondent')
                            ->where('project_id', $project_id)
                            ->where('respondent_id', $respondent_id)
                            ->exists();
    
                        if (!$exists) {
                            // Get the project name for the error message
                            $project_name = DB::table('projects')
                                ->where('id', $project_id)
                                ->value('name');
    
                            $error_message = $project_name
                                ? "Project '{$project_name}' or Respondent ID {$respondent_id} does not exist in project_respondent table."
                                : "Project ID {$project_id} or Respondent ID {$respondent_id} does not exist in project_respondent table.";
    
                            DB::rollback();
                            fclose($file);
                            return redirect()->back()->with('error', $error_message);
                        }
    
                        // Check if respondent already exists in QualifiedRespondent table
                        if (QualifiedRespondent::where('project_id', $project_id)->where('respondent_id', $respondent_id)->exists()) {
                            continue; // Skip if respondent already exists
                        }
    
                        // Insert into QualifiedRespondent table
                        $get_rewards = Projects::where('id', $project_id)->first();
                        QualifiedRespondent::create([
                            'project_id' => $project_id,
                            'respondent_id' => $respondent_id,
                            'status' => 1,
                            'points' => $get_rewards->reward,
                            'created_at' => now(),
                        ]);
                    }
                } else {
                    DB::rollback();
                    fclose($file);
                    return redirect()->back()->with('error', 'Column mismatched!');
                }
    
                $i++;
            }
    
            DB::commit();
            fclose($file);
    
            return redirect()->back()->with('success', 'Attached Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }
    


    public function project_store_qualified_respondents(Request $request)
    {
        $project_id = $request->project_id;
        $file = $request->file('file');
        
        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'Please upload a file');
        }
    
        // File Details 
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
    
        // Validate File Extension
        if (strtolower($extension) !== 'csv') {
            return redirect()->back()->with('error', 'Invalid File Extension, Please Upload CSV File Format');
        }
    
        // File upload location
        $location = 'uploads/csv/'.$project_id;
        // Ensure directory exists
        if (!file_exists($location)) {
            mkdir($location, 0777, true);
        }
    
        // Upload file
        $file->move($location, $filename);
        // Import CSV to Database
        $filepath = public_path($location . "/" . $filename);
    
        $file = fopen($filepath, "r");
    
        $importData_arr = [];
        $i = 0;
        $col = 1;
    
        try {
            DB::beginTransaction();
    
            while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                $num = count($filedata);
    
                // Skip first row
                if ($i == 0) {
                    $i++;
                    continue;
                }
    
                if ($num == $col) {
                    foreach ($filedata as $respondent_id) {
                        // Check if project_id and respondent_id exist in project_respondent table
                        $exists = DB::table('project_respondent')
                            ->join('projects', 'project_respondent.project_id', '=', 'projects.id')
                            ->where('project_respondent.project_id', $project_id)
                            ->where('project_respondent.respondent_id', $respondent_id)
                            ->exists();
    
                        if (!$exists) {
                            // Get the project name
                            $project_name = DB::table('projects')
                                ->where('id', $project_id)
                                ->value('name');
    
                            $error_message = $project_name
                                ? "Project '{$project_name}' or Respondent ID {$respondent_id} does not exist in project_respondent table."
                                : "Project ID {$project_id} or Respondent ID {$respondent_id} does not exist in project_respondent table.";
    
                            DB::rollback();
                            fclose($file);
                            return redirect()->back()->with('error', $error_message);
                        }
    
                        // Check if respondent already exists in QualifiedRespondent table
                        if (QualifiedRespondent::where('project_id', $project_id)->where('respondent_id', $respondent_id)->exists()) {
                            continue; // Skip if respondent already exists
                        }
    
                        // Insert into QualifiedRespondent table
                        $get_rewards = Projects::where('id', $project_id)->first();
                        QualifiedRespondent::create([
                            'project_id' => $project_id,
                            'respondent_id' => $respondent_id,
                            'status' => 1,
                            'points' => $get_rewards->reward,
                            'created_at' => now(),
                        ]);
                    }
                } else {
                    DB::rollback();
                    fclose($file);
                    return redirect()->back()->with('error', 'Column mismatched!');
                }
    
                $i++;
            }
    
            DB::commit();
            fclose($file);
    
            return redirect()->back()->with('success', 'Attached Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }
    
    
    
    public function change_all_rewards_status(Request $request) {
        try {
            // Fetch QualifiedRespondent records where status is 1
            $get_status_records = QualifiedRespondent::where('status', 1)->get();
    
            foreach ($get_status_records as $rewards) {
                // Retrieve points from Projects table based on project_id
                $get_points = Projects::where('id', $rewards->project_id)->first();
    
                // Check if $get_points is null
                if ($get_points) {
                    // Prepare data to insert into Rewards table
                    $all_record = [
                        'respondent_id' => $rewards->respondent_id,
                        'user_id' => $rewards->respondent_id, // Assuming user_id is same as respondent_id
                        'project_id' => $rewards->project_id,
                        'points' => $get_points->reward,
                        'status_id' => 2,
                        'created_at' => now(), // Assuming now() returns current timestamp
                    ];
    
                    // Insert into Rewards table
                    Rewards::insert($all_record);
                } else {
                    // Log or handle the case where $get_points is null
                    // For example:
                    Log::warning("No project found with id {$rewards->project_id}");
                }
            }
    
            // Update QualifiedRespondent table status from 1 to 2
            QualifiedRespondent::where('status', 1)->update(['status' => 2]);
    
        } catch (Exception $e) {
            // Handle exceptions
            throw new Exception($e->getMessage());
        }
    }
    
    

}
