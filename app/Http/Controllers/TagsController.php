<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Tags;
use App\Models\Respondents;
use App\Models\RespondentTags;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class TagsController extends Controller
{   
    public function index(Request $request)
    {
        try {
            $request->session()->forget('tag_id');
            return view('admin.tags.index');
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
        try {
           
            $returnHTML = view('admin.tags.create')->render();

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
               'name'=> 'required',
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                $tags = new Tags;
                $tags->name = $request->input('name');
                $tags->colour = $request->input('colour');
                $tags->save();
                $tags->id;
                return response()->json([
                    'status'=>200,
                    'last_insert_id' => $tags->id,
                    'message'=>'Tags Added Successfully.'
                ]);
            }

        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        try {
            Session::put('tag_id', $id);
            $data = Tags::find($id);
            return view('admin.tags.view',compact('data'));

          
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
           
            $tags = Tags::find($id);
            if($tags)
            {
                $returnHTML = view('admin.tags.edit',compact('tags'))->render();
                return response()->json(
                    [
                        'success' => true,
                        'html_page' => $returnHTML,
                    ]
                );
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Tags Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'=> 'required',
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
               
                $tags = Tags::find($request->id);
                if($tags)
                {
                    $tags->name = $request->input('name');
                    $tags->colour = $request->input('colour');
                    $tags->update();
                    $tags->id;
                    return response()->json([
                        'status'=>200,
                        'last_insert_id' => $tags->id,
                        'message' => 'Tags Updated.',
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Tags Found.'
                    ]);
                }
    
            }
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tags = Tags::find($id);
            if($tags)
            {
                $tags->delete();
                return response()->json([
                    'status'=>200,
                    'success' => true,
                    'message'=>'Tags Deleted Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'success' => false,
                    'message'=>'No Tags Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }

   
    public function get_all_tags(Request $request) {
		
        try {
            if ($request->ajax()) {
                $token = csrf_token();
                $all_datas = Tags::select('tags.*');

                if ($request->filled('id') && $request->input('inside_form') == 'respondents') {
                    $respondentId = $request->input('id');
                    $all_datas->join('respondent_tag', function ($join) use ($respondentId) {
                        $join->on('respondent_tag.tag_id', '=', 'tags.id')
                             ->where('respondent_tag.respondent_id', '=', $respondentId);
                    });
                }
                
                $all_datas = $all_datas->orderBy('tags.id', 'desc')->get();
                
                return Datatables::of($all_datas)
                    ->addColumn('select_all', function ($all_data) {
                        return '<input class="tabel_checkbox" name="rewards[]" type="checkbox" onchange="table_checkbox(this,\'tags_table\')" id="'.$all_data->id.'">';
                    })
                    ->addColumn('id_show', function ($all_data) {
                        $view_route = route("tags.show",$all_data->id);
                        return '<a href="'.$view_route.'" data-bs-original-title="View Panel" class="rounded waves-light waves-effect">
                            '.$all_data->id.'
                        </a>';
                    })
                    ->addColumn('colour', function ($all_data) {
                        return '<div class=""><button type="button" class="btn waves-effect waves-light"  onClick="myFunction(\''.$all_data->colour.'\')" style="background-color:'.$all_data->colour.'"><i class="uil uil-user"></i></button></div>';
                    })
                    ->addColumn('action', function ($all_data) {
                        $edit_route = route("tags.edit",$all_data->id);
                        $view_route = route("tags.show",$all_data->id);

                        $design = '<div class="col-md-2">
                                <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                                    title="Action" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-tasks" aria-hidden="true"></i>
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-center">
                                    <li class="list-group-item">
                                        <a href="'.$view_route.'" data-bs-original-title="View Panel" class="rounded waves-light waves-effect">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </li>';
                                    if(Auth::guard('admin')->user()->role_id == 1){
                                        if(str_contains(url()->current(), '/admin/respondents')){
                                            $design .= '
                                            <li class="list-group-item">
                                                <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                                    data-bs-original-title="Edit Panel" class="rounded waves-light waves-effect">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="#!" id="delete_tags" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </li>';
                                        }
                                        else{
                                            $design .= '<li class="list-group-item">
                                                <a href="#!" id="deattach_tags" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                                    <i class="far fa-trash-alt"></i> Detach
                                                </a>
                                            </li>';
                                        }
                                    }
                                $design .='</ul>
                            </div>';

                        return $design;
                    })
                    ->rawColumns(['id_show','select_all','action','name','colour'])      
                    ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function tags_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $tags = Tags::find($id);
                $tags->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Tags Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deattach_tags(Request $request,$id)
    {
        try {
         
            // Check if $id is an array or a string and handle accordingly
            if (is_string($id)) {
                $idArray = explode(',', $id);
            } elseif (is_array($id)) {
                $idArray = $id; // Assuming $id is already an array
            } else {
                // Return an error if $id is neither an array nor a string
                return response()->json([
                    'status'  => 400,
                    'success' => false,
                    'message' => 'Invalid input format for $id.'
                ]);
            }
   
            // Trim whitespace from each ID in the array
            $idArray = array_map('trim', $idArray);

            // Ensure the array is not empty
            if (empty($idArray)) {
                return response()->json([
                    'status'  => 400,
                    'success' => false,
                    'message' => 'No valid tags provided to detach.'
                ]);
            }
    
            // Use transaction for bulk deletion
            DB::beginTransaction();
    
            // Delete records where tag_id is in the $idArray
            RespondentTags::where('tag_id',Session::get('tag_id'))->whereIn('respondent_id', $idArray)->delete();
    
            // Commit transaction
            DB::commit();
    
            // Return JSON response
            return response()->json([
                'status'  => 200,
                'success' => true,
                'message' => 'Tags de-attached successfully.'
            ]);
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
    
            // Return error response
            return response()->json([
                'status'  => 500,
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
   
    
    
    
    public function deattach_multi_panel(Request $request)
    {
        try {
            $ids = $request->input('id');

            // Check if $ids is not null and is iterable (array or object)
            if (!is_array($ids)) {
                // If 'id' is not an array, treat it as a single ID
                $ids = [$ids]; // Convert single ID to an array for uniform processing
            }

            // Validate input
            if (empty($ids)) {
                return response()->json([
                    'status' => 400,
                    'success' => false,
                    'message' => 'No IDs provided or invalid data format.'
                ]);
            }

            // Delete records based on each 'id' in the array
            $deletedCount = 0;
            foreach ($ids as $id) {
                $deletedCount += RespondentTags::where('respondent_id', $id)->delete();
            }

            if ($deletedCount > 0) {
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => 'Tags Detached successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'success' => false,
                    'message' => 'No matching records found to delete.'
                ]);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            // You might also want to handle or report the exception in a production environment
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage()
            ]);
        }
    }

    
    

    public function tags_export(Request $request){
        try {
            $id_value = $request->id_value;
            $form     = $request->form;
            $checkbox_value = $request->checkbox_value;

            return view('admin.report.tags')->with('form',$form)->with('id_value',$id_value)->with('checkbox_value',$checkbox_value);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function attach_tags(Request $request){
        try {
            $respondent_id = $request->respondent_id;

            $respondents = Respondents::select('respondents.id','respondents.name','respondents.surname')->where('respondents.id',$respondent_id)->first();
           
            $returnHTML = view('admin.tags.attach', compact('respondents'))->render();

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

    public function attach_resp_tags(Request $request){
        try {
            $tags_id = $request->tags_id;
           

            $tags = Tags::where('id',$tags_id)->first();
           
            $returnHTML = view('admin.tags.attach_tags', compact('tags_id','tags'))->render();

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

    public function tags_seach_result(Request $request){
        try {
            $searchValue = $request['q'];
            
            if($request->filled('q')){
                $tags_data = Tags::search($searchValue)
                ->query(function ($query) {
                    $query->where('deleted_at', '=', NULL);
                })
                ->orderBy('id','ASC')
                ->get();
            }

            $tags = array();
            if(count($tags_data) > 0){
                foreach($tags_data as $resp){
                    $setUser = [
                        'id' => $resp->id,
                        'name' => $resp->name,
                        'colour' => $resp->colour,
                    ];
                    $tags[] = $setUser;
                }
            }

            echo json_encode($tags);
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // public function tags_attach_store(Request $request){
    //     try {
    //         $tag_id  = $request->tag_id;
    //         $respondents = $request->respondents;

    //         if(RespondentTags::where('tag_id', $tag_id)->where('respondent_id', $respondents)->exists()){

    //             RespondentTags::update(['updated_at' => date("Y-m-d h:i:s")]);

    //             return response()->json([
    //                 'text_status' => false,
    //                 'status' => 200,
    //                 'message' => 'Panel Already Attached.',
    //             ]);
    //         }
    //         else{
    //             RespondentTags::insert(['tag_id' => $tag_id, 'respondent_id' => $respondents, 'created_at' => date("Y-m-d h:i:s")]);

    //             // $proj = Projects::where('id',$project_id)->first();
    //             // $resp = Respondents::where('id',$respondents)->first();

    //             //email starts
    //             // if($proj->name!='')
    //             // {
    //             //     $to_address = $resp->email;
    //             //     //$to_address = 'hemanathans1@gmail.com';
    //             //     $resp_name = $resp->name.' '.$resp->surname;
    //             //     $proj_name = $proj->name;

    //             //     $data = ['subject' => 'New Survey Assigned','name' => $resp_name,'project' => $proj_name,'type' => 'new_project'];
                
    //             //     Mail::to($to_address)->send(new WelcomeEmail($data));
    //             // }
    //             //email ends

    //             return response()->json([
    //                 'text_status' => true,
    //                 'status' => 200,
    //                 'message' => 'Project Attached Successfully.',
    //             ]);
    //         }
    //     }
    //     catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }

    public function tags_attach_store(Request $request) {
        try {
            $tag_id = $request->tag_id;
            $respondent_id = $request->respondents; // Renamed for clarity
    
            // Check if the respondent is already tagged
            if (RespondentTags::where('tag_id', $tag_id)->where('respondent_id', $respondent_id)->exists()) {
                // If exists, update the timestamp
                RespondentTags::where('tag_id', $tag_id)->where('respondent_id', $respondent_id)
                    ->update(['updated_at' => now()]);
    
                return response()->json([
                    'text_status' => false,
                    'status' => 200,
                    'message' => 'Respondent Already Attached.',
                ]);
            } else {
                // If not, create a new entry
                RespondentTags::create([
                    'tag_id' => $tag_id,
                    'respondent_id' => $respondent_id,
                    'created_at' => now(),
                    'updated_at' => now(), // Adding updated_at for consistency
                ]);
    
                // Optional email logic could go here
    
                return response()->json([
                    'text_status' => true,
                    'status' => 200,
                    'message' => 'Panel Attached Successfully.',
                ]);
            }
        } catch (Exception $e) {
            // Improved error handling
            return response()->json([
                'text_status' => false,
                'status' => 500,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }
    }
    


    public function respondendtopanel_attach_import(Request $request){
        $project_id = $request->project_id;
        $file = $request->file('file');

        // File Details 
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("csv");
        if(in_array(strtolower($extension),$valid_extension)){
            // File upload location
            $location = 'uploads/csv/'.$project_id;
            // Upload file
            $file->move($location,$filename);
            // Import CSV to Database
            $filepath = public_path($location."/".$filename);

            $file = fopen($filepath,"r");

            $importData_arr = array();
            $i = 0;
            $col=1;
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                // Skip first row (Remove below comment if you want to skip the first row)
                if($i == 0){
                    $i++;
                    continue;
                }

                if($num == $col){
                    for ($c=0; $c < $num; $c++) {
                        $set_array = array('respondent_id' => $filedata [$c],'project_id' => $project_id);
                        array_push($importData_arr,$set_array);
                    }
                    $i++;
                }
                else{
                    return redirect()->back()->with('error','Column mismatched!');
                    break;
                }
            }
            fclose($file);
            
            Project_respondent::insert($importData_arr);

            return redirect()->back()->with('success','Attached Successfully');
            
        }
        else{
            return redirect()->back()->with('error','Invalid File Extension, Please Upload CSV File Format');
        }
        
    }

    public function import_tags(Request $request){
        try {
         
            $respondent_id = $request->respondent_id;
            $respondent = DB::table('respondents')
            ->select(DB::raw("CONCAT(respondents.name, ' ', respondents.surname) AS full_name"))
            ->where('id', $respondent_id)
            ->first();
        
            // Accessing the concatenated name
            if ($respondent) {
                $fullName = $respondent->full_name; // This will give you the concatenated name
            } else {
                // Handle if no record found for the given $respondent_id
                $fullName = 'No respondent found'; // Example error handling
            }

            $returnHTML = view('admin.tags.import', compact('fullName','respondent_id'))->render();

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

    public function import_resp_tags(Request $request){
        try {
         
            $tag_id = $request->panel_id;
            $tags =Tags::select('id','name')
            ->where('id', $tag_id)
            ->first();
        
       

            $returnHTML = view('admin.tags.import_respondent', compact('tags','tag_id'))->render();

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
    public function tags_attach_import(Request $request)
    {
        $respondent_id = $request->respondent_id;
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
        $location = 'uploads/csv/' . $respondent_id;
        if (!file_exists($location)) {
            mkdir($location, 0777, true);
        }
    
        // Upload file
        $file->move($location, $filename);
    
        // Import CSV to Database
        $filepath = public_path($location . "/" . $filename);
        $file = fopen($filepath, "r");
    
        $importData_arr = [];
        $duplicateTags = [];
        $i = 0;
        $col = 1;
    
        // Collect existing tags for this respondent
        $existingTags = RespondentTags::where('respondent_id', $respondent_id)
                                      ->pluck('tag_id')
                                      ->toArray();
    
        while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
            $num = count($filedata);
    
            // Skip first row (headers)
            if ($i == 0) {
                $i++;
                continue;
            }
    
            if ($num == $col) {
                $tag_id = $filedata[0]; // Assuming the CSV has only one column for tag IDs
    
                if (in_array($tag_id, $existingTags)) {
                    // Collect duplicate tags for reporting
                    $duplicateTags[] = $tag_id;
                } else {
                    // Add to import data array
                    $importData_arr[] = [
                        'respondent_id' => $respondent_id,
                        'tag_id' => $tag_id
                    ];
                    $existingTags[] = $tag_id; // Add to existing tags to avoid re-checking
                }
    
                $i++;
            } else {
                fclose($file);
                return redirect()->back()->with('error', 'Column mismatched!');
            }
        }
    
        fclose($file);
    
        if (!empty($duplicateTags)) {
            // Redirect back with error message if duplicates are found
            $duplicateTagsMessage = 'Duplicate Tag IDs found:<br>' . implode('<br>', $duplicateTags);
            return redirect()->back()->with('error', $duplicateTagsMessage);
        }
    
        // Using DB transaction to ensure atomicity
        DB::beginTransaction();
    
        try {
            // Insert all non-duplicate records
            if (!empty($importData_arr)) {
                RespondentTags::insert($importData_arr);
            }
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Tags Attached Successfully');
    
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }
    

    public function tags_resp_attach_import(Request $request)
    {
        $tag_id = $request->tag_id;
        $file = $request->file('file');
    
        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'Please upload a file');
        }
    
        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
    
        // Valid File Extensions
        $valid_extension = ['csv'];
        if (!in_array(strtolower($extension), $valid_extension)) {
            return redirect()->back()->with('error', 'Invalid File Extension, Please Upload CSV File Format');
        }
    
        // File upload location
        $location = 'uploads/csv/' . $tag_id;
        if (!file_exists($location)) {
            mkdir($location, 0777, true);
        }
    
        // Upload file
        $file->move($location, $filename);
    
        // Import CSV to Database
        $filepath = public_path($location . "/" . $filename);
        $file = fopen($filepath, "r");
    
        $importData_arr = [];
        $duplicateErrors = [];
        $i = 0;
        $col = 1;
    
        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);
    
            // Skip first row (headers)
            if ($i == 0) {
                $i++;
                continue;
            }
    
            if ($num == $col) {
                foreach ($filedata as $respondent_id) {
                    // Check if respondent_id and tag_id combination already exists
                    $existingRecord = RespondentTags::where('respondent_id', $respondent_id)
                                                    ->where('tag_id', $tag_id)
                                                    ->exists();
    
                    if ($existingRecord) {
                        // Collect duplicate errors
                        $duplicateErrors[] = "Respondent ID $respondent_id already exists for this tag.";
                    } else {
                        // Add to import data array
                        $importData_arr[] = [
                            'respondent_id' => $respondent_id,
                            'tag_id' => $tag_id
                        ];
                    }
                }
                $i++;
            } else {
                fclose($file);
                return redirect()->back()->with('error', 'Column mismatched!');
            }
        }
        fclose($file);
    
        // Check for duplicate errors and handle appropriately
        if (!empty($duplicateErrors)) {
            $errorMessage = 'Duplicates found:<br>' . implode('<br>', $duplicateErrors);
            return redirect()->back()->with('error', $errorMessage);
        }
    
        // Using DB transaction to ensure atomicity
        DB::beginTransaction();
    
        try {
            // Insert all non-duplicate records
            if (!empty($importData_arr)) {
                RespondentTags::insert($importData_arr);
            }
    
            DB::commit();
            return redirect()->back()->with('success', 'Tags Attached Successfully');
    
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }
    

    public function tags_search_result(Request $request){
        try {
            $searchValue = $request['q'];
            
            if($request->filled('q')){
                $panel_data = Tags::search($searchValue)
                ->query(function ($query) {
                    $query->where('deleted_at', '=', NULL);
                })
                ->orderBy('id','ASC')
                ->get();
            }

            $panel = array();
            if(count($panel_data) > 0){
                foreach($panel_data as $resp){
                    $setUser = [
                        'id' => $resp->id,
                        'name' => $resp->name,
                    ];
                    $panel[] = $setUser;
                }
            }

            echo json_encode($panel);
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function downloadSampleCSV()
    {
        try {
            $filePath = public_path('public/import/panel/panel import csv.csv');
    
            // Check if the file exists
            if (!file_exists($filePath)) {
                return response()->json([
                    'error' => 'File not found.'
                ], 404);
            }
    
            // Proceed with file download
            return response()->download($filePath);
        } catch (\Exception $e) {
            // Log the exception message
            \Log::error('File download error: ' . $e->getMessage());
    
            // Return a custom error response
            return response()->json([
                'error' => 'An error occurred while trying to download the file.'
            ], 500);
        }
    }

}