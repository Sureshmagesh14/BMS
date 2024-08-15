<?php
namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Hash;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Folder;
use App\Models\Survey;
use App\Models\Questions;
use App\Models\Users;
use App\Models\Respondents;
use App\Models\Project_respondent;
use App\Models\Projects;
use App\Models\SurveyTemplate;
use App\Models\SurveyResponse;
use App\Models\SurveyQuotas;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Storage;
use App\Models\SurveyHistory;
use Exception;

// Word Cloud 
use Artesaos\SEOTools\Facades\SEOTools;
// PDF Report
use Dompdf\Dompdf;
use Dompdf\Options;
class SurveyController extends Controller
{
    public function folder()
    {
        $foldersList=Folder::get();
       
        return view('admin.survey.folder.index', compact('foldersList'));

    }

    public function getFolderList(){
        $foldersList=Folder::orderBy("id", "desc")->get();

        return Datatables::of($foldersList)
            ->addColumn('id', function ($list) {
                return "#".$list->id;
            })
            ->addColumn('folder_name', function ($list) {
                return $list->folder_name;
            })
            ->addColumn('folder_type', function ($list) {
                return ucfirst($list->folder_type);
            })
            ->addColumn('survery_count', function ($list) {
                return $list->survery_count;
            })
            ->addColumn('created_at', function ($list) {
                return date_format($list->created_at, "M j, Y h:i:s");
            })
            ->addColumn('actions', function ($list) {
                $editLink=route('folder.edit',$list->id);
                $deletedLink=route('folder.delete',$list->id);
               return '<div class="actionsBtn"><a href="#" class="btn btn-primary waves-effect waves-light editFolder" data-url="'.$editLink.'" data-ajax-popup="true" data-bs-toggle="tooltip" title="Edit Folder" data-title="Edit Folder">Edit</a>
               <button type="button" class="btn btn-danger sa-warning waves-effect waves-light" id="sa-warning" data-url="'.$deletedLink.'" onclick="folderdelete(`'.$deletedLink.'`,'.$list->id.')">Delete</button>';
            })
            ->rawColumns(['id','folder_name','folder_type','survery_count','created_at','actions'])
            ->make(true);

        return response()->json(['data' => $foldersList], 200);
    }
   
    public function createFolder(Request $request){
        $user = Auth::guard('admin')->user();
        $users=User::where('id', '!=' , $user->id)->pluck('name', 'id')->toArray();

        try {
            $returnHTML = view('admin.survey.folder.create', compact('users'))->render();

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

        // return view('admin.survey.folder.create', compact('users'));
    }

    public function storeFolder(Request $request){
        $user = Auth::guard('admin')->user();
        $folder=new Folder();
        $folder->folder_name=$request->folder_name;
        $folder->folder_type=$request->folder_type;
        $folder->survery_count=0;
        $folder->created_by=$user->id;
        if($request->folder_type=='private'){
            $folder->user_ids=implode(',', $request->privateusers);
        }
        $folder->save();
        return redirect()->route('survey.template',$folder->id)->with('success', __('Folder Created Successfully.'));

    }

    public function editFolder($id){

        $folder=Folder::where(['id'=>$id])->first();
        $user = Auth::guard('admin')->user();
        $users=User::where('id', '!=' , $user->id)->pluck('name', 'id')->toArray();
        return view('admin.survey.folder.edit', compact('folder','users'));


    }

    public function updateFolder(Request $request,$id){
        $user = Auth::guard('admin')->user();
        $folder=Folder::where(['id'=>$id])->first();
        $folder->folder_name=$request->folder_name;
        $folder->folder_type=$request->folder_type;
        if($request->folder_type=='private'){
            $folder->user_ids=implode(',', $request->privateusers);
        }else{
            $folder->user_ids='';
        }
        $folder->save();
        return redirect()->back()->with('success', __('Folder Updated Successfully.'));

    }

    public function deleteFolder(Request $request,$id){
        $folder=Folder::where(['id'=>$id])->first();
        if($folder->survery_count==0){
            $folder->delete();
            // return redirect()->back()->with('success', __('Folder deleted Successfully.'));
            return json_encode(['success'=>'Folder deleted Successfully',"error"=>""]);

        }else{
            return json_encode(['error'=>"Folder mapped with Survey. Can't able to delete it.","success"=>""]);
        }
        
    }

    public function survey()
    {
        $surveyList=Survey::where(['is_deleted'=>0])->orderBy("id", "desc")->get();
       
        return view('admin.survey.survey.index', compact('surveyList'));

    }

    public function getSurveyList(){
        $surveyList=Survey::where(['is_deleted'=>0])->orderBy("id", "desc")->get();

        return Datatables::of($surveyList)
            ->addColumn('id', function ($list) {
                return "#".$list->id;
            })
            ->addColumn('folder_id', function ($list) {
                $folder=Folder::where('id',$list->folder_id)->first();
                return $folder->folder_name;
            })
            ->addColumn('survey_name', function ($list) {
                return ucfirst($list->title);
            })
            ->addColumn('add_template', function ($list) {
                $qusLink=route('survey.template',$list->id);
                return '<a href="'.$qusLink.'" class="btn btn-primary waves-effect waves-light" title="Questions" data-title="Questions">View</a>';
            })
            ->addColumn('created_at', function ($list) {
                return date_format($list->created_at, "M j, Y h:i:s");
            })
            ->addColumn('actions', function ($list) {
                $editLink=route('survey.edit',$list->id);
                $deletedLink=route('survey.delete',$list->id);
               return '<div class="actionsBtn"><a href="#" class="btn btn-primary waves-effect waves-light editSurvey" data-url="'.$editLink.'" data-ajax-popup="true" data-bs-toggle="tooltip" title="Edit Survey" data-title="Edit Survey">Edit</a>
               <button type="button" class="btn btn-danger sa-warning waves-effect waves-light" id="sa-warning" data-url="'.$deletedLink.'" onclick="surveydelete(`'.$deletedLink.'`,'.$list->id.')">Delete</button>';
            })
            ->rawColumns(['id','folder_id','survey_name','add_template','created_at','actions'])
            ->make(true);

        return response()->json(['data' => $surveyList], 200);
    }

    public function createSurvey(Request $request){
        $user = Auth::guard('admin')->user();
        $folders=Folder::pluck('folder_name', 'id')->toArray();
        return view('admin.survey.survey.create', compact('folders'));
    }

    public function storeSurvey(Request $request){
        $uuid = Str::uuid()->toString();
        $user = Auth::guard('admin')->user();
        $survey=new Survey();
        $survey->folder_id=$request->folder_id;
        $survey->title=$request->title;
        $survey->created_by=$user->id;
        $survey->builderID=$uuid;
        $survey->survey_type=$request->survey_type;
        $survey->shareable_type = $request->shareable_type;
        $survey->save();
        return redirect()->route('survey.template',$request->folder_id)->with('success', __('Survey Created Successfully.'));

        return redirect()->back()->with('success', __('Survey Created Successfully.'));

    }

    public function editSurvey($id){

        $survey=Survey::where(['id'=>$id])->first();
        $user = Auth::guard('admin')->user();
        $folders=Folder::pluck('folder_name', 'id')->toArray();
        return view('admin.survey.survey.edit', compact('survey','folders'));


    }
    public function updateSurvey(Request $request,$id){
        $user = Auth::guard('admin')->user();
        $survey=Survey::where(['id'=>$id])->first();
        $survey->title=$request->title;
        $survey->folder_id=$request->folder_id;
        $survey->survey_type=$request->survey_type;
        $survey->shareable_type = $request->shareable_type;
        $survey->save();
        return redirect()->back()->with('success', __('Survey Updated Successfully.'));

    }

    public function deleteSurvey(Request $request,$id){
        $survey=Survey::where(['id'=>$id])->first();
        
        // if($survey->qus_count==0){
            $survey->is_deleted=1;
            $survey->save();
            return redirect()->back()->with('success', __('Survey deleted Successfully.'));
            return json_encode(['success'=>'Survey deleted Successfully',"error"=>""]);
        // }else{
        //     return json_encode(['error'=>"Survey mapped with Questions. Can't able to delete it.","success"=>""]);
        // }
        
    }
    public function restoreSurvey(Request $request,$id){
        $survey=Survey::where(['id'=>$id])->first();
        
            $survey->is_deleted=0;
            $survey->save();
            return redirect()->back()->with('success', __('Survey restored Successfully.'));
        
    }

    
    public function templateList(Request $request,$id){
       
        $user = Auth::guard('admin')->user();

        // public folders 
        $folderspublic=Folder::where(['folder_type'=>'public'])->withCount('surveycount')->pluck('id')->toArray();
        $foldersprivate=Folder::where(['folder_type'=>'private'])->withCount('surveycount')->get();
        $privateFoldres =[];
        foreach($foldersprivate as $private){
            $user_ids = explode(',',$private->user_ids);
            if (in_array($user->id, $user_ids)){
                array_push($privateFoldres,$private->id);
            }else if($private->created_by == $user->id){
                array_push($privateFoldres,$private->id);
            }
        }
        $folders1=Folder::whereIn('id',$privateFoldres)->withCount('surveycount')->pluck('id')->toArray();
        $folder = array_merge($folderspublic,$folders1);
        $folders=Folder::whereIn('id',$folder)->withCount('surveycount')->get();
        // if(count($folder)>0){
        //     $survey=Survey::where(['folder_id'=>$folder[0],'is_deleted'=>0])->first();
        // }else{
            $survey=Survey::where(['folder_id'=>$id,'is_deleted'=>0])->first();
        // }
        // Private folders 
        $folderActive = Folder::where(['id'=>$id])->first();
        return view('admin.survey.template.index', compact('survey','folders','folderActive'));
    }
    public function builder(Request $request,$survey,$qusID=0){
        // Generatre builder ID
        $survey=Survey::where(['builderID'=>$survey])->first();
        $questions=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->orderBy('qus_order_no')->get();
        $welcomQus=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'welcome_page'])->first();
        $thankQus=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'thank_you'])->get();
        if($qusID==0){
            if($welcomQus){
                $currentQus=$welcomQus;
            }else{
                $currentQus=Questions::where(['survey_id'=>$survey->id])->first();
            }
        }else{
            $currentQus=Questions::where(['id'=>$qusID])->first();
        }
        $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','photo_capture'=>'Photo Capture','email'=>'Email','upload'=>'Upload','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
        $qus_type='';
        if($currentQus){
            $qus_type=$questionTypes[$currentQus->qus_type];
            $display_logic=Questions::where('id', '<', $currentQus->id)->where(['survey_id'=>$survey->id])->whereNotIn('id',[$currentQus->id])->whereNotIn('qus_type',['matrix_qus','welcome_page','thank_you'])->pluck('question_name', 'id')->toArray();
            $display_logic_matrix=Questions::where('id', '<', $currentQus->id)->where(['qus_type'=>'matrix_qus','survey_id'=>$survey->id])->whereNotIn('id',[$currentQus->id])->get();
            $skip_logic=Questions::where('id', '<=', $currentQus->id)->where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you','matrix_qus'])->pluck('question_name', 'id')->toArray();
            $skip_logic_matrix=Questions::where('id', '<=', $currentQus->id)->where(['qus_type'=>'matrix_qus','survey_id'=>$survey->id])->whereNotIn('id',[$currentQus->id])->get();
            $jump_to=Questions::where('id', '>', $currentQus->id)->where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->pluck('question_name', 'id')->toArray();
            $jump_to_tq=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'thank_you'])->pluck('question_name', 'id')->toArray();

        }else{
            $skip_logic=[];
            $display_logic_matrix=[];
            $display_logic=[];
            $skip_logic_matrix=[];
            $jump_to_tq=[];
            $jump_to=[];
        }

        
        $pagetype=$request->pagetype;
        if($pagetype=='preview'){
            $question1=Questions::where('id', '>', $currentQus->id)->where('survey_id', $survey->id)->orderBy('id')->first();

            return view('admin.survey.builder.preview',compact('survey','questions','welcomQus','thankQus','currentQus','qus_type','pagetype','question1'));
        }else{
            return view('admin.survey.builder.index',compact('survey','questions','welcomQus','thankQus','currentQus','qus_type','pagetype','skip_logic','skip_logic_matrix','display_logic','display_logic_matrix','jump_to','jump_to_tq'));
        }

    }
    public function surveysettings(Request $request,$survey){
        $survey=Survey::where(['id'=>$survey])->first();
        return view('admin.survey.builder.settings', compact('survey'));

    }
    public function updatesettings(Request $request,$survey){
        $survey=Survey::where(['id'=>$survey])->first();
        $survey->avg_completion_time=$request->avg_completion_time;
        $survey->save();
        return redirect()->back()->with('success', __('Survey Settings Saved Successfully.'));



    }
    public function questiontype(Request $request,$survey){
        $checkSurvey= Questions::where(['survey_id'=>$survey,'qus_type'=>'welcome_page'])->first();
        if($checkSurvey){
            $questionTypes=['single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','photo_capture'=>'Photo Capture','email'=>'Email','upload'=>'Upload','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page'];
        }else{
            $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','photo_capture'=>'Photo Capture','email'=>'Email','upload'=>'Upload','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
        }
        return view('admin.survey.builder.create', compact('questionTypes','survey'));

    }
   public function questiontypesurvey(Request $request,$survey,$qustype){
    // Create New Question
    // Create New Qus 
    $user = Auth::guard('admin')->user();
    // Get Last Order No 
    $last_order_no=Questions::where(['survey_id'=>$survey])->whereNotIn('qus_type',['welcome_page','thank_you'])->orderBy('qus_order_no', "desc")->first();
    $newqus = new Questions();
    $newqus->survey_id = $survey;
    $newqus->qus_type = $qustype;
    $newqus->created_by = $user->id;
    if($last_order_no){
        $newqus->qus_order_no = $last_order_no->qus_order_no + 1;
    }else{
        $newqus->qus_order_no = 1;
    }
    $newqus->save();
    // Update Qus Count 
    $survey=Survey::where(['id'=>$survey])->first();
    if($qustype!='welcome_page' && $qustype!='thank_you'){
        $survey->qus_count = $survey->qus_count+1;
    }
    $survey->save();
    $questions=Questions::where(['survey_id'=>$survey])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
    
    return redirect()->route('survey.builder',[$survey->builderID,$newqus->id])->with('success', __('Question Created Successfully.'));


   }
   public function deletequs(Request $request,$id){
        $question=Questions::where(['id'=>$id])->first();
        $survey = Survey::where(['id'=>$question->survey_id])->first();
        $survey->qus_count = $survey->qus_count - 1;
        $survey->save();
        $question->delete();
        return json_encode(['success'=>'Question deleted Successfully',"error"=>""]);
    }
     public function copyqus(Request $request,$id){
        $question=Questions::where(['id'=>$id])->first();
        $survey = Survey::where(['id'=>$question->survey_id])->first();
        $survey->qus_count = $survey->qus_count + 1;
        $survey->save();
        $last_order_no=Questions::where(['survey_id'=>$question->survey_id])->whereNotIn('qus_type',['welcome_page','thank_you'])->orderBy('qus_order_no', "desc")->first();
        $newqus = new Questions();
        $newqus->survey_id=$question->survey_id;
        $newqus->question_name=$question->question_name;
        $newqus->question_description=$question->question_description;
        $newqus->qus_required=$question->qus_required;
        $newqus->qus_template=$question->qus_template;
        $newqus->qus_type=$question->qus_type;
        $newqus->qus_ans=$question->qus_ans;
        $newqus->skip_logic=$question->skip_logic;
        $newqus->display_logic=$question->display_logic;
        $newqus->survey_thankyou_page=$question->survey_thankyou_page;
        $newqus->created_by=$question->created_by;
        
        // Reorder Other Qus
        $currentqus_no = (int)$question->qus_order_no;

        // Get next qus 
        $upcoming_qus = Questions::where(['survey_id' => $question->survey_id])->where('qus_order_no', '>', $currentqus_no)->get();
        if($upcoming_qus){
            if($currentqus_no){
                $newqus->qus_order_no = $currentqus_no + 1;
            }else{
                $newqus->qus_order_no = 1;
            }
            $newqus->save();
            foreach($upcoming_qus as $upqus){
                $upqus->qus_order_no = $upqus->qus_order_no+1;
                $upqus->save();
            }
        }else{
            if($currentqus_no){
                $newqus->qus_order_no = $qus_order_no + 1;
            }else{
                $newqus->qus_order_no = 1;
            }
            $newqus->save();
        }
       

        
        return json_encode(['success'=>'Question copied Successfully',"error"=>""]);
    }
    
    public function surveyduplication(Request $request,$id){

        $survey=Survey::where(['id'=>$id])->first();
        $questions=Questions::where(['survey_id'=>$id])->get();
        $uuid = Str::uuid()->toString();
        $user = Auth::guard('admin')->user();
        
        // Clone Survey 
        $clonesurvey=new Survey();
        $clonesurvey->folder_id=$survey->folder_id;
        $clonesurvey->title=$survey->title.' Copy';
        $clonesurvey->created_by=$user->id;
        $clonesurvey->builderID=$uuid;
        $clonesurvey->save();

        // Clone Question 
        foreach($questions as $qus){
            $last_order_no=Questions::where(['survey_id'=>$clonesurvey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->orderBy('qus_order_no', "desc")->first();
            $newqus=new Questions();
            $newqus->survey_id=$clonesurvey->id;
            $newqus->question_name=$qus->question_name;
            $newqus->qus_template=$qus->qus_template;
            $newqus->qus_type=$qus->qus_type;
            $newqus->qus_ans=$qus->qus_ans;
            $newqus->skip_logic=$qus->skip_logic;
            $newqus->display_logic=$qus->display_logic;
            $newqus->created_by=$user->id;
            
            if($last_order_no){
                $newqus->qus_order_no = $last_order_no->qus_order_no + 1;
            }else{
                $newqus->qus_order_no = 1;
            }

           

            $newqus->save();
        }
        return redirect()->back()->with('success', __('Survey Duplicated Successfully.'));

    }
   public function sharesurvey(Request $request,$id){
        $survey=Survey::where(['id'=>$id])->first();
        $surveylink= route('survey.view',$survey->builderID);
        return view('admin.survey.template.share', compact('surveylink','survey'));
   }
    public function movesurvey(Request $request,$id){
        $survey=Survey::where(['id'=>$id])->first();
        $surveylink= route('survey.movesurveyupdate',$survey->builderID);
        $folders=Folder::pluck('folder_name', 'id')->toArray();
        return view('admin.survey.template.move', compact('surveylink','survey','folders'));
    }
    public function movesurveyupdate(Request $request,$id){
        $folder_id=$request->folder_id;
        $survey_id=$request->survey_id;
        Survey::where(['id'=>$request->survey_id])->update(['folder_id'=>$request->folder_id]);
        return redirect()->back()->with('success', __('Folder Moved Successfully.'));
    }
    public function questionList(Request $request,$id){
        // Generatre builder ID
        $currentQus=Questions::where(['id'=>$id])->first();
        $survey=Survey::where(['id'=>$currentQus->survey_id])->first();
        $questions=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
        $welcomQus=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'welcome_page'])->first();
        $thankQus=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'thank_you'])->get();
        $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','photo_capture'=>'Photo Capture','email'=>'Email','upload'=>'Upload','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
        $qus_type=$questionTypes[$currentQus->qus_type];
        $pagetype=$request->pagetype;

        return view('admin.survey.builder.index',compact('survey','questions','welcomQus','thankQus','currentQus','qus_type','pagetype'));
    }
    public function updateQus(Request $request,$id){
        $currentQus=Questions::where(['id'=>$id])->first();
        // // Update Qus Count 
        $survey=Survey::where(['id'=>$currentQus->survey_id])->first();
        // if($request->qus_type!='welcome_page' && $request->qus_type!='thank_you'){
        //     $survey->qus_count=$survey->qus_count+1;
        // }
        $survey->save();
        // Update Display Logic 
        $display_logic=json_encode(['logic_type_value_display'=>$request->display_logic_type_value_display,'logic_type_value_option_display'=>$request->logic_type_value_option_display,'display_qus_choice_andor_display'=>$request->display_qus_choice_andor_display,'display_qus_choice_display'=>$request->display_qus_choice_display]);
        // Update Skip Logic 
        $skip_logic=json_encode(['skiplogic_type_value_skip'=>$request->skiplogic_type_value_skip,'logic_type_value_option_skip'=>$request->logic_type_value_option_skip,'display_qus_choice_andor_skip'=>$request->display_qus_choice_andor_skip,'display_qus_choice_skip'=>$request->display_qus_choice_skip,'jump_type'=>$request->jump_type]);
        Questions::where(['id'=>$id])->update(['display_logic'=>$display_logic,'skip_logic'=>$skip_logic]);
        switch ($request->qus_type) {
            case 'welcome_page':
                $filename='';
                if($request->hasfile('welcome_image'))
                {
                    $file = $request->file('welcome_image');
                    $extenstion = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extenstion;
                    $file->move('uploads/survey/', $filename);
                }else{
                    if(isset($request->existing_image_uploaded)){
                        $filename=$request->existing_image_uploaded;
                    }else{
                        $surveyTemplate = SurveyTemplate::where(['id'=>$request->welcome_template])->first();
                        $filename=$surveyTemplate->image;
                    }
                    
                }
                $TBSfilename='small-logo.png';
                $surveyTemplate = SurveyTemplate::where(['id'=>$request->welcome_template])->first();
                if(isset($surveyTemplate)){
                    $TBSfilename = $surveyTemplate->logo_url;
                }
                if($TBSfilename==''){
                    if($request->tbs_logo==1){
                        $TBSfilename='small-logo.png';
                    }
                }
                
              
                $json=[
                    'welcome_imagesubtitle'=>$request->welcome_imagesubtitle,'welcome_btn'=>$request->welcome_btn,
                    'welcome_imagetitle'=>$request->welcome_imagetitle,
                    'welcome_title'=>$request->welcome_title,
                    'welcome_template'=>$request->welcome_template,
                    'tbs_logo'=>$request->tbs_logo,
                    'tbs_logo_url'=>$TBSfilename,
                    'welcome_image'=>$filename
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['qus_ans'=>json_encode($json)]);

              break;
            case 'thank_you':
                $filename='';
                if($request->hasfile('thankyou_image'))
                {
                    $file = $request->file('thankyou_image');
                    $extenstion = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extenstion;
                    $file->move('uploads/survey/', $filename);
                }else{
                    if(isset($request->existing_image_uploaded_thankyou)){
                        $filename=$request->existing_image_uploaded_thankyou;
                    }else{
                        $surveyTemplate = SurveyTemplate::where(['id'=>$request->thankyou_template])->first();
                        $filename=$surveyTemplate->image;
                    }
                }
                $TBSfilename='small-logo.png';
                $surveyTemplate = SurveyTemplate::where(['id'=>$request->welcome_template])->first();
                if(isset($surveyTemplate)){
                    $TBSfilename = $surveyTemplate->logo_url;
                }
                if($TBSfilename==''){
                    if($request->tbs_logo==1){
                        $TBSfilename='small-logo.png';
                    }
                }
              
                $json=[
                    'thankyou_title'=>$request->thankyou_title,
                    'thankyou_imagetitle'=>$request->thankyou_imagetitle,
                    'thankyou_image'=>$filename,
                    'thankyou_template'=>$request->thankyou_template,
                    'tbs_logo'=>$request->tbs_logo,
                    'tbs_logo_url'=>$TBSfilename
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'question_name'=>$request->thankyou_title,'qus_ans'=>json_encode($json),'survey_thankyou_page'=>$request->survey_thankyou_page]);
              break;
            case 'upload':
                $json=[
                    'upload_image'=>$request->upload_image,
                    'upload_video'=>$request->upload_video,
                    'upload_audio'=>$request->upload_audio,
                    'upload_doc'=>$request->upload_doc,
                    'question_name'=>$request->question_name,
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
              break;
            case 'open_qus':
                $json=[
                    'open_qus_choice'=>$request->open_qus_choice,
                    'question_name'=>$request->question_name,
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
              break;
            case 'single_choice':
                $json=[
                    'choices_list'=>implode(",",$request->choices_list) ,
                    'choices_type'=>'single',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
              break;
            case 'multi_choice':
                $json=[
                    'choices_list'=>implode(",",$request->choices_list) ,
                    'choices_type'=>'mulitple',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
              break;
            case 'likert':
                $json=[
                    'left_label'=>$request->left_label,
                    'middle_label'=>$request->middle_label,
                    'right_label'=>$request->right_label,
                    'likert_range'=>$request->likert_range,
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            case 'rankorder':
                $json=[
                    'choices_list'=>implode(",",$request->choices_list) ,
                    'choices_type'=>'rankorder',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            case 'rating':
                $json=[
                    'icon_type'=>$request->icon_type,
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            case 'dropdown':
                $json=[
                    'choices_list'=>implode(",",$request->choices_list) ,
                    'choices_type'=>'dropdown',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            case 'picturechoice':
                $json=[
                    'choices_list'=>$request->choices_list_pic,
                    'choices_type'=>'picturechoice',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            case 'photo_capture':
                $json=[
                    'choices_type'=>'photo_capture',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            case 'email':
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>'email']);
                break;
            case 'matrix_qus':
                $json=[
                    'matrix_choice'=>implode(",",$request->choices_list_matrix),
                    'matrix_qus'=>implode(",",$request->question_list_matrix),
                    'qus_type'=>'matrix',
                    'choices_type'=>'radio',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_description'=>$request->question_description,'qus_required'=>$request->qus_required,'question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            default:
              //code block
          }
          return redirect()->back()->with('success', __('Question Updated Successfully.'));

    }
    public function viewsurvey(Request $request, $id){
        $survey = Survey::with('questions')->where(['builderID'=>$id])->first();
         // Create Survey History 
         if (Auth::check()) {
         $survey_history = SurveyHistory::where(['survey_id'=>$survey->id,'respondent_id'=> Auth::user()->id])->first();
         if($survey_history){
             // Survey already attended
             return view('admin.survey.alreadyattempted', compact('survey'));
         }else{
             $history = new SurveyHistory();
             $history->respondent_id= Auth::user()->id;
             $history->survey_id=$survey->id;
             $history->status=0;
             $history->save();
         }
        }
        if($survey->is_deleted == 0){
            // Check Shareable Type 
            if($survey->shareable_type == 'share'){
                if (Auth::check()) {
                    $response_user_id =  Auth::user()->id;
                    $checkresponse = SurveyResponse::where(['response_user_id'=>$response_user_id ,'survey_id'=>$survey->id,'answer'=>'thankyou_submitted'])->first();
                    if($checkresponse){
                        $status = 'alreadycompleted';
                        return view('admin.survey.responsecompleted', compact('survey','status'));
        
                        if($survey->survey_type =='survey'){
                            return view('admin.survey.responseerror', compact('survey','status'));
                        }else{
                            return view('admin.survey.responsecompleted', compact('survey','status'));
                        }
                    }else{
                        // Update Visited Count 
                        $visited_count=Survey::where(['builderID'=>$id])->update(['visited_count'=>$survey->visited_count+1]);
            
                        $questions=Questions::where(['survey_id'=>$survey->id])->whereIn('qus_type',['welcome_page','thank_you'])->get();
                        $welcomQus=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'welcome_page'])->first();
                        if($welcomQus){
                            $question=$welcomQus;
                        }else{
                            $question=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->first();
                        }
                        $questionsset=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
            
                        $question1=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->orderBy('qus_order_no')->first();
                        if($question1){
                            $question1=$question1;
                        }else{
                            $question1=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'thank_you'])->first();
                        }
                        // Check Survey has question or not 
                        $surveyQus = Questions::where(['survey_id'=>$survey->id])->get();
                        if(count($surveyQus)<=0){
                            return view('admin.survey.noquserror', compact('survey'));
                        }else{
                            return view('admin.survey.response', compact('survey','question','question1','questionsset'));
                        }
                    }
                }else{
                    // Create Temp User 
                    return view('admin.survey.tempuser',compact('survey'));
                }
            }else{
                if (Auth::check()) {
                    // Check Survey assigned for user or not
                    $response_user_id =  Auth::user()->id;
                    $project = Projects::where(['survey_link'=> $survey->id])->first();
                   
                    if($project){
                        $res = DB::table('projects')->select('projects.id', 'survey.builderID','projects.access_id')->join('survey', 'survey.id', 'projects.survey_link')
                        ->where('projects.id',$project->id)->first();
                        if($res->access_id == 2){
                            //access_id =2 = assigned
                            if(Project_respondent::where('project_id', $project->id)->where('respondent_id', $response_user_id)->exists()){
                                $checkresponse = SurveyResponse::where(['response_user_id'=>$response_user_id ,'survey_id'=>$survey->id,'answer'=>'thankyou_submitted'])->first();
                                if($checkresponse){
                                    $status = 'alreadycompleted';
                                    return view('admin.survey.responsecompleted', compact('survey','status'));
                    
                                    if($survey->survey_type =='survey'){
                                        return view('admin.survey.responseerror', compact('survey','status'));
                                    }else{
                                        return view('admin.survey.responsecompleted', compact('survey','status'));
                                    }
                                }else{
                                    // Update Visited Count 
                                    $visited_count=Survey::where(['builderID'=>$id])->update(['visited_count'=>$survey->visited_count+1]);
                        
                                    $questions=Questions::where(['survey_id'=>$survey->id])->whereIn('qus_type',['welcome_page','thank_you'])->get();
                                    $welcomQus=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'welcome_page'])->first();
                                    if($welcomQus){
                                        $question=$welcomQus;
                                    }else{
                                        $question=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->first();
                                    }
                                    $questionsset=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
                        
                                    $question1=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->orderBy('qus_order_no')->first();
                                    if($question1){
                                        $question1=$question1;
                                    }else{
                                        $question1=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'thank_you'])->first();
                                    }
                                    // Check Survey has question or not 
                                    $surveyQus = Questions::where(['survey_id'=>$survey->id])->get();
                                    if(count($surveyQus)<=0){
                                        return view('admin.survey.noquserror', compact('survey'));
                                    }else{
                                        return view('admin.survey.response', compact('survey','question','question1','questionsset'));
                                    }
                                }
                            }else{
                                return view('admin.survey.unassigned', compact('survey'));
                            }
                        }else{
                            return view('admin.survey.unassigned', compact('survey'));

                        }
                    }else{
                        return view('admin.survey.unassigned', compact('survey'));
                    }
                   
                }else{
                    return redirect()->route('login');
                }
            }
            
        }else{
            return view('admin.survey.unavailable', compact('survey'));

        }
        
    }
   
    public function startsurvey(Request $request, $id,$qus){
      
        // Check User already taken the survey 
        $response_user_id =  Auth::user()->id;
       
        $survey=Survey::with('questions')->where(['id'=>$id])->first();
        $checkresponse = SurveyResponse::where(['response_user_id'=>$response_user_id ,'survey_id'=>$survey->id,'answer'=>'thankyou_submitted'])->first();
       
        if($checkresponse){
            $status = 'alreadycompleted';
            return view('admin.survey.responsecompleted', compact('survey','status'));

            if($survey->survey_type =='survey'){
                return view('admin.survey.responseerror', compact('survey','status'));
            }else{
                return view('admin.survey.responsecompleted', compact('survey','status'));
            }

        }else{
            if($request->type == 'welcome'){
              
                // Update started Count 
                $started_count=Survey::where(['id'=>$id])->update(['started_count'=>$survey->started_count+1]);
            }
            
            $question=Questions::where(['id'=>$qus])->first();
    
            $questionsset=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->orderBy('qus_order_no')->get();
           
            $question1=Questions::where('qus_order_no', '>', $question->qus_order_no)->where('survey_id', $survey->id)->orderBy('qus_order_no')->first();
    
         
            // Check Survey has question or not 
            $surveyQus = Questions::where(['survey_id'=>$survey->id])->orderBy('qus_order_no')->get();
            if(count($surveyQus)<=0){
                return view('admin.survey.noquserror', compact('survey'));

            }else{
                return view('admin.survey.response', compact('survey','question','question1','questionsset'));
            }
        }
        
    }
    public function endsurvey(Request $request, $id,$qus){
        // Check User already taken the survey 
        $response_user_id =  Auth::user()->id;
        $survey=Survey::with('questions')->where(['id'=>$id])->first();
        $checkresponse = SurveyResponse::where(['response_user_id'=>$response_user_id ,'survey_id'=>$survey->id,'answer'=>'thankyou_submitted'])->first();
       
        if($request->type == 'welcome'){
            // Update started Count 
            $started_count=Survey::where(['id'=>$id])->update(['started_count'=>$survey->started_count+1]);
        }
        
        $question=Questions::where(['id'=>$qus])->first();

        $questionsset=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
        
        $question1=Questions::where('id', '>', $qus)->where('survey_id', $survey->id)->orderBy('id')->first();
        // Check Survey has question or not 
        $surveyQus = Questions::where(['survey_id'=>$survey->id])->get();
        
        if(count($surveyQus)<=0){
            
            return view('admin.survey.noquserror', compact('survey'));
        }else{
            if($qus == 0){
                //  update Survey History
                $survey_history = SurveyHistory::where(['survey_id'=>$survey->id,'respondent_id'=>$response_user_id])->first();
                if($survey_history){
                    $survey_history->status=1;
                    $survey_history->save();
                }
                return view('admin.survey.thankyoudefault', compact('survey'));
            }else{
                if($question){
                    if($question->qus_type =='thank_you'){
                        //  update Survey History
                        $survey_history = SurveyHistory::where(['survey_id'=>$survey->id,'respondent_id'=>$response_user_id])->first();
                        if($survey_history){
                            $survey_history->status=1;
                            $survey_history->save();
                        }
                    }
                    if($question->qus_type =='thank_you' && $question->question_name ==''){
                        return view('admin.survey.thankyoudefault', compact('survey'));
                    }else{
                        return view('admin.survey.response', compact('survey','question','question1','questionsset'));
                    }

                }else{
                    //  update Survey History
                    $survey_history = SurveyHistory::where(['survey_id'=>$survey->id,'respondent_id'=>$response_user_id])->first();
                    if($survey_history){
                        $survey_history->status=1;
                        $survey_history->save();
                    }
                    return view('admin.survey.thankyoudefault', compact('survey'));
                }
            }
        }

        
    }

    public function uploadimage(Request $request){
        $filename='';
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/survey/', $filename);
            echo $filename;

        }else{
            echo "size issue";
        }
    }
    public function getqus(Request $request){
        $qus=Questions::where(['id'=>$request->qus_id])->first();
        $resp_logic_type=[];
        $qusvalue = json_decode($qus->qus_ans); 
        switch ($qus->qus_type) {
            case 'single_choice':
                $resp_logic_type=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                break;
            case 'multi_choice':
                $resp_logic_type=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                break;
            case 'open_qus':
                $resp_logic_type=['contains'=>'Contains','doesNotContain'=>'Does not Contain','startsWith'=>'Starts With','endsWith'=>'Ends With','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered','equalsString'=>'Equals','notEqualTo'=>'Not Equal To'];
                break; 
            case 'likert':
                $resp_logic_type=['lessThanForScale'=>'Less than','greaterThanForScale'=>'Greater than','equalToForScale'=>'Equal To','notEqualToForScale'=>'Not Equal To','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                break;
            case 'rankorder':
                $resp_logic_type=['isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                break;
            case 'rating':
                $resp_logic_type=['lessThanForScale'=>'Less than','greaterThanForScale'=>'Greater than','equalToForScale'=>'Equal To','notEqualToForScale'=>'Not Equal To','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                break;
            case 'dropdown':
                $resp_logic_type=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                break;
            case 'picturechoice':
                $resp_logic_type=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                break;
            case 'photo_capture':
                $resp_logic_type=['isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                break;
            case 'upload':
                $resp_logic_type=['isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                break;
            case 'email':
                $resp_logic_type=['contains'=>'Contains','doesNotContain'=>'Does not Contain','startsWith'=>'Starts With','endsWith'=>'Ends With','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered','equalsString'=>'Equals','notEqualTo'=>'Not Equal To'];
                break;
            case 'matrix_qus':
                $resp_logic_type=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                break;

        }
        return ['qus'=>$qus,'resp_logic_type'=>$resp_logic_type,'qus_type'=>$qus->qus_type];

        echo "<pre>"; print_r($qus);
    }
    public function background(Request $request,$id){
      
        $survey=Survey::where(['id'=>$id])->first();
        return view('admin.survey.background', compact('survey'));
    }
    private function getRealIp(Request $request)
    {
        if ($request->hasHeader('X-Forwarded-For')) {
            $ips = explode(',', $request->header('X-Forwarded-For'));
            return trim($ips[0]);
        }
        return $request->ip();
    }
    public function setbackground(Request $request,$id){
        $survey=Survey::where(['id'=>$id])->first();
        if($request->bg_type=='image'){
            if($request->hasfile('welcome_image'))
            {
                $file = $request->file('welcome_image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $file->move('uploads/survey/background/', $filename);
                $bg=$filename;
            }
        }else if($request->bg_type=='single'){
            $bg=$request->hex;
        }else{
            
            $hex1=$request->gradienthex;
            $hex2=$request->gradienthex1;
            $ori=$request->gradientori;
            $bg=json_encode(['hex1'=>$hex1,'hex2'=>$hex2,'ori'=>$ori]);

        }
        $bgval=["type"=>$request->bg_type, "color"=>$bg];
        $survey->background=json_encode($bgval);
        $survey->save();
        return redirect()->back()->with('success', __('Survey Background Updated Successfully.'));

    }

    public function submitans(Request $request){
        $survey_id = $request->survey_id;
        $question_id = $request->question_id;
        $response_user_id =  Auth::user()->id;
         // Create Survey History 
         $survey_history = SurveyHistory::where(['survey_id'=>$survey_id,'respondent_id'=>$response_user_id])->first();
         if($survey_history){
             // Survey already attended
         }else{
             $history = new SurveyHistory();
             $history->respondent_id=$response_user_id;
             $history->survey_id=$survey_id;
             $history->status=0;
             $history->save();
         }
        $ipAddress = $this->getRealIp($request);
        // Other details 
        $other_details = ["device_id"=>$request->device_id,"device_name"=>$request->device_name,"browser"=>$request->browser,"os"=>$request->os,"device_type"=>$request->device_type,"long"=>$request->long,"lat"=>$request->lat,"location"=>$request->location,"ip_address"=>$ipAddress,"lang_code"=>$request->lang_code,"lang_name"=>$request->lang_name];
        
        $qus_check=Questions::where('id', '=', $question_id)->where('survey_id', $survey_id)->orderBy('qus_order_no')->first();
        $user_ans =$request->user_ans;
        if($request->hasfile('uploadfile'))
        {
            $file = $request->file('uploadfile');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/survey/', $filename);
            $user_ans = $filename;

        }
        $next_qus = $request->next_qus;
        $skip_ans =$request->skip_ans;
        $surveyres = new SurveyResponse();
        $surveyres->other_details = json_encode($other_details);
        $surveyres->survey_id = $survey_id;
        $surveyres->response_user_id=$response_user_id;
        $surveyres->question_id=$request->question_id;
        $surveyres->answer=$user_ans;
        $surveyres->skip=$skip_ans;
        $surveyres->deleted_at=0;
        $surveyController = new SurveyController;
        $quotacheck = $surveyController->checkquota($survey_id,$question_id,$user_ans);
       
        if($quotacheck == 'limitavailable'){
            $surveyres->save();
        }else{
            $survey = Survey::where(['id'=>$survey_id])->first();
            $redirection_qus = SurveyTemplate::find($quotacheck);
            return view('admin.survey.limitexceed', compact('survey', 'redirection_qus'));
        }
       
        if($qus_check){
            $next_qus_loop = '';
            $skip_logic = json_decode($qus_check->skip_logic);
            
           
            if($skip_logic!=null){
                if($skip_logic->jump_type!=''){
                    $skip_logic = json_decode($qus_check->skip_logic);
                    if ($skip_logic !== null) {
                        $display_qus_choice_display = json_decode($skip_logic->display_qus_choice_skip); 
                        $logic_type_value_display = json_decode($skip_logic->skiplogic_type_value_skip); 
                        if(count($display_qus_choice_display) > 0 && count($logic_type_value_display) > 0) {
                            if (self::processSkipLogic($skip_logic, $response_user_id,$survey_id,$qus_check)) {
                                return redirect()->route('survey.startsurvey', [$survey_id, $skip_logic->jump_type]);
                            } else {
                                return $surveyController->displaynextQus($question_id,$survey_id,$other_details);
                            }
                        }else{
                            return $surveyController->displaynextQus($question_id,$survey_id,$other_details);
                        }
                      
                    } else {
                        return redirect()->route('survey.startsurvey', [$survey_id, $next_qus->id]);
                    }
                }else{
                     // Check next qus display settings 
                     $next_qus_loop ='yes';
                }
            }
            else{
                // Check next qus display settings 
                $next_qus_loop ='yes';
            }
        }
       
       
        if($next_qus_loop == 'yes'){
            return $surveyController->displaynextQus($question_id,$survey_id,$other_details);
        }else{
            // Update Survey Completion 
            $surveyRec=Survey::where(['id'=>$survey_id])->first();
            $completed_count=Survey::where(['id'=>$survey_id])->update(['completed_count'=>$surveyRec->completed_count+1]);
            // Redirect to thank you page
            $next_qus=Questions::where(['survey_id'=>$survey_id,'qus_type'=>'thank_you'])->first();
            if($next_qus){
                $surveyres = new SurveyResponse();
                $surveyres->survey_id = $survey_id;
                $surveyres->response_user_id = $response_user_id;
                $surveyres->question_id = $next_qus->id;
                $surveyres->answer = 'thankyou_submitted';
                $surveyres->skip = '';
                $surveyres->deleted_at = 0;
                $surveyres->other_details = json_encode($other_details);
                $surveyres->save();
                // Update Profile Completed or Survey Complete

                // if($surveyRec->survey_type == 'profile'){
                //     Respondents::where('id', '=' , $response_user_id)->update(['profile_completion_id'=>1]);
                // }
                if($surveyRec->survey_type == 'survey'){
                    // Get Project ID 
                    $project = Projects::where(['survey_link'=> $surveyRec->id])->first();
                    if($project){
                        Project_respondent::where('project_id', $project->id)->where('respondent_id', $response_user_id)->update(['is_frontend_complete'=>1]);
                    }
                }
                return redirect()->route('survey.endsurvey',[$survey_id,$next_qus->id]);
            }else{
                if($surveyRec->survey_type == 'survey'){
                    // Get Project ID 
                    $project = Projects::where(['survey_link'=> $surveyRec->id])->first();
                    if($project){
                        Project_respondent::where('project_id', $project->id)->where('respondent_id', $response_user_id)->update(['is_frontend_complete'=>1]);
                    }
                }
                return redirect()->route('survey.endsurvey',[$survey_id,0]);
            }
           
        }
    }
    public static function displayNextQus($question_id, $survey_id, $other_details)
    {
        $response_user_id = Auth::user()->id;
        $currentQusSet = Questions::where('id', '=', $question_id)->first();
        $next_qus = Questions::where('qus_order_no', '>', $currentQusSet->qus_order_no)
            ->where(['survey_id' => $survey_id])
            ->whereNotIn('qus_type', ['welcome_page', 'thank_you'])
            ->orderBy('qus_order_no')
            ->first();
        if (!$next_qus) {
            return self::handleSurveyCompletion($survey_id, $other_details);
        }


        $display_logic = json_decode($next_qus->display_logic);
        if ($display_logic !== null) {
            if (self::processDisplayLogic($display_logic, $response_user_id,$survey_id,$next_qus)) {        
                return redirect()->route('survey.startsurvey', [$survey_id, $next_qus->id]);
            } else {
                $surveyController = new SurveyController;
                return $surveyController->displaynextQus($next_qus->id,$survey_id,$other_details);
                return self::loopNextQuestion($next_qus->id, $survey_id, $other_details);
            }
        } else {
            return redirect()->route('survey.startsurvey', [$survey_id, $next_qus->id]);
        }
    }
    private static function processSkipLogic($display_logic, $response_user_id, $survey_id, $next_qus)
    {
        $push_jump = [];
        $display_qus_choice_display = json_decode($display_logic->display_qus_choice_skip); 
        $logic_type_value_display = json_decode($display_logic->skiplogic_type_value_skip); 
        $logic_type_value_option_display = json_decode($display_logic->logic_type_value_option_skip); 
        $display_qus_choice_andor_display = json_decode($display_logic->display_qus_choice_andor_skip); 
    
        if (count($display_qus_choice_display) > 0 && count($logic_type_value_display) > 0) {
            foreach ($display_qus_choice_display as $k => $display) {
                $logic = $logic_type_value_display[$k];
                $logicv = $logic_type_value_option_display[$k];
                $cond = $display_qus_choice_andor_display[$k];
                
                $qusID = explode("_", $display);
                if ($qusID[0] != '') {
                    $qus_typeData = Questions::find($qusID[0]);
                    $qusvalue_display = json_decode($qus_typeData->qus_ans);
    
                    $resp_logic_type_display_value = self::getResponseLogicTypeDisplayValue($qus_typeData, $qusvalue_display);
    
                    $ans = self::getAnswerValue($resp_logic_type_display_value, $logicv);
                    $get_ans_usr = SurveyResponse::with('questions')->where(['question_id' => $qusID[0], 'response_user_id' => $response_user_id])->orderBy("id", "desc")->first();
                    list($user_answered, $user_skipped, $qus_type) = self::getUserAnsweredData($get_ans_usr);
    
                    // Adjust the result based on the logic type
                    $isConditionMet = self::evaluateLogicCondition($logic, $qus_type, $ans, $user_answered, $user_skipped, $qusID);
                    
                    // Check if the logic type is a "negative" type
                    $negative_logics = ['isNotSelected', 'isNotAnswered', 'doesNotContain', 'notEqualTo', 'notEqualToForScale'];
                    if (in_array($logic, $negative_logics)) {
                        // Invert the result for negative logic types
                        $result = $isConditionMet ? "fail" : "pass";
                    } else {
                        $result = $isConditionMet ? "pass" : "fail";
                    }
    
                    array_push($push_jump, ["result" => $result, "logic" => $logic]);
                } else {
                    return redirect()->route('survey.startsurvey', [$survey_id, $next_qus->id]);
                }
            }
        } else {
            return redirect()->route('survey.startsurvey', [$survey_id, $next_qus->id]);
        }
       
    
       return self::checkSkipLogicConditions($display_logic, $push_jump);
    }
    
    private static function checkSkipLogicConditions($display_logic, $push_jump)
    {
        $display_qus_choice_andor_display = json_decode($display_logic->display_qus_choice_andor_skip);
    
        // Check if display_qus_choice_andor_display only contains 'or'
        $only_or = true;
        foreach ($display_qus_choice_andor_display as $condition) {
            if ($condition == '') {
                $condition = 'or';
            }
            if ($condition !== 'or') {
                $only_or = false;
                break;
            }
        }
    
        // If it only contains 'or', check if push_jump has at least one 'pass' for 'or' conditions
        if ($only_or) {
            $has_pass_or = '';
            $has_fail_or = 'nextqus';
            foreach ($push_jump as $result) {
                if ($result['result'] === 'pass' && (in_array($result['logic'], ['isSelected', 'isAnswered', 'contains', 'startsWith', 'endsWith', 'equalsString', 'equalToForScale']) || strpos($result['logic'], 'Not') === false)) {
                    $has_pass_or = "true";
                } elseif ($result['result'] === 'fail' && in_array($result['logic'], ['isNotSelected', 'isNotAnswered', 'doesNotContain', 'notEqualTo', 'notEqualToForScale'])) {
                    $has_fail_or = '';
                } elseif($result['result'] === 'pass' && in_array($result['logic'], ['isNotSelected', 'isNotAnswered', 'doesNotContain', 'notEqualTo', 'notEqualToForScale'])) {
                    return false;
                }
            }
            if($has_fail_or == 'nextqus'){
                return false;
            }else if($has_pass_or == 'true'){
                return true;
            }else{
                return true;
            }
        }
        // Implement logic for mixed 'and' and 'or' conditions
        $and_condition_met = true;
        $or_condition_met = false;
        $length = min(count($display_qus_choice_andor_display), count($push_jump));
    
        for ($i = 0; $i < $length; $i++) {
            $display_condition = $display_qus_choice_andor_display[$i];
            $push_condition = $push_jump[$i]['result'];
            $logic_type = $push_jump[$i]['logic'];
    
            if ($display_condition == 'or' && $push_condition == 'pass' && (in_array($logic_type, ['isSelected', 'isAnswered', 'contains', 'startsWith', 'endsWith', 'equalsString', 'equalToForScale']) || strpos($logic_type, 'Not') === false)) {
                $or_condition_met = true;
            } elseif ($display_condition == 'and' && $push_condition == 'fail' && (in_array($logic_type, ['isSelected', 'isAnswered', 'contains', 'startsWith', 'endsWith', 'equalsString', 'equalToForScale']) || strpos($logic_type, 'Not') === false)) {
                $and_condition_met = false;
            }
        }
    
        // Evaluate final condition based on 'or' and 'and' results
        if ($or_condition_met) {
            return true; // At least one 'or' condition passed
        }
    
        return $and_condition_met; // All 'and' conditions passed
    }
    
   

   
    private static function processDisplayLogic($display_logic, $response_user_id, $survey_id, $next_qus)
    {
        $jump_to = 0;
        $push_jump = [];

        $display_qus_choice_display = json_decode($display_logic->display_qus_choice_display); 
        $logic_type_value_display = json_decode($display_logic->logic_type_value_display); 
        $logic_type_value_option_display = json_decode($display_logic->logic_type_value_option_display); 
        $display_qus_choice_andor_display = json_decode($display_logic->display_qus_choice_andor_display); 

        if(count($display_qus_choice_display) > 0 && count($logic_type_value_display) > 0) {
            foreach ($display_qus_choice_display as $k => $display) {
                $logic = $logic_type_value_display[$k];
                $logicv = $logic_type_value_option_display[$k];
                $cond = $display_qus_choice_andor_display[$k];
                $qusID = explode("_", $display);
                if($qusID[0] != ''){
                    $qus_typeData = Questions::find($qusID[0]);
                    $qusvalue_display = json_decode($qus_typeData->qus_ans);
    
                    $resp_logic_type_display_value = self::getResponseLogicTypeDisplayValue($qus_typeData, $qusvalue_display);
    
                    $ans = self::getAnswerValue($resp_logic_type_display_value, $logicv);
                    $get_ans_usr = SurveyResponse::with('questions')->where(['question_id' => $qusID[0]])->orderBy("id", "desc")->first();
                    list($user_answered, $user_skipped, $qus_type) = self::getUserAnsweredData($get_ans_usr);
    
                    if (self::evaluateLogicCondition($logic, $qus_type, $ans, $user_answered, $user_skipped,$qusID)) {
                        // if ($cond == 'or') {
                        //     array_push($push_jump, "or");
                        // }else{
                        //     array_push($push_jump, "and");
                        // }
                        array_push($push_jump, "pass");
                    } else {
                        // if ($cond == 'or') {
                        //     array_push($push_jump, "and");
                        // } else {
                        //     array_push($push_jump, "or");
                        // }
                        array_push($push_jump, "fail");
                    }
                }else{
                    return redirect()->route('survey.startsurvey', [$survey_id, $next_qus->id]);
                }
            }
        } else {
            return redirect()->route('survey.startsurvey', [$survey_id, $next_qus->id]);
        }

        return self::checkDisplayLogicConditions($display_logic, $push_jump);
    }

    private static function checkDisplayLogicConditions($display_logic, $push_jump)
    {
        $display_qus_choice_andor_display = json_decode($display_logic->display_qus_choice_andor_display);
    
        // Check if display_qus_choice_andor_display only contains 'or'
        $only_or = true;
        foreach ($display_qus_choice_andor_display as $condition) {
            if($condition ==''){
                $condition = 'or';
            }
            if ($condition !== 'or') {
                $only_or = false;
                break;
            }
        }
    
        // If it only contains 'or', check if push_jump has at least one 'pass'
        if ($only_or) {
            foreach ($push_jump as $result) {
                if ($result === 'pass') {
                    return true;
                }
            }
            return false;
        }
    
        // If it doesn't only contain 'or', implement the original logic
        $and_condition_met = true;
        $or_condition_met = false;
        $length = min(count($display_qus_choice_andor_display), count($push_jump));
    
        for ($i = 0; $i < $length; $i++) {
            $display_condition = $display_qus_choice_andor_display[$i];
            $push_condition = $push_jump[$i];
    
            if ($display_condition == 'or' && $push_condition == 'fail') {
                $or_condition_met = true;
            } elseif ($display_condition == 'and' && $push_condition == 'fail') {
                $and_condition_met = false;
            }
        }
    
        if ($or_condition_met) {
            return true;
        }
    
        return $and_condition_met;
    }
    

   

    private static function getResponseLogicTypeDisplayValue($qus_typeData, $qusvalue_display)
    {
        switch ($qus_typeData->qus_type) {
            case 'single_choice':
            case 'multi_choice':
            case 'dropdown':
                return explode(",", $qusvalue_display->choices_list);
            case 'picturechoice':
                return json_decode($qusvalue_display->choices_list);
            case 'likert':
                return ["1" => 1, "2" => 3, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9];
            case 'rating':
                return ["1" => 1, "2" => 3, "3" => 3, "4" => 4, "5" => 5];
            case 'matrix_qus':
                return explode(",", $qusvalue_display->matrix_choice);
            default:
                return [];
        }
    }
    
    private static function getAnswerValue($resp_logic_type_display_value, $logicv)
    {
        if ($logicv !== '') {
            return isset($resp_logic_type_display_value[$logicv]) ? $resp_logic_type_display_value[$logicv] : $logicv;
        }
        return '';
    }
    
    private static function getUserAnsweredData($get_ans_usr)
    {
        if ($get_ans_usr) {
            return [
                $get_ans_usr->answer,
                $get_ans_usr->skip,
                $get_ans_usr->questions[0]->qus_type
            ];
        }
        return ['', '', ''];
    }
    
    private static function evaluateLogicCondition($logic, $qus_type, $ans, $user_answered, $user_skipped,$qusID)
    {
        switch ($logic) {
            case 'isSelected':
                return self::evaluateIsSelected($qus_type, $ans, $user_answered,$qusID);
            case 'isNotSelected':
                return self::evaluateIsNotSelected($qus_type, $ans, $user_answered,$qusID);
            case 'isAnswered':
                return $user_answered !== '';
            case 'isNotAnswered':
                return $user_skipped == 'yes';
            case 'contains':
                return str_contains($user_answered, $ans);
            case 'doesNotContain':
                return !str_contains($user_answered, $ans);
            case 'startsWith':
                return str_starts_with($user_answered, $ans);
            case 'endsWith':
                return str_ends_with($user_answered, $ans);
            case 'equalsString':
                return $user_answered == $ans;
            case 'notEqualTo':
                return $user_answered != $ans;
            case 'lessThanForScale':
                return (int)$user_answered < (int)$ans;
            case 'greaterThanForScale':
                return (int)$user_answered > (int)$ans;
            case 'equalToForScale':
                return (int)$user_answered == (int)$ans;
            case 'notEqualToForScale':
                return (int)$user_answered != (int)$ans;
            default:
                return false;
        }
    }
    
    private static function evaluateIsSelected($qus_type, $ans, $user_answered,$qusID)
    {
        if ($qus_type == 'matrix_qus') {
            $user_answered = json_decode($user_answered);
            return $user_answered[$qusID[1]]->key == $qusID[1] && $ans == $user_answered[$qusID[1]]->ans;
        } elseif ($qus_type == 'multi_choice') {
            return in_array($ans, explode(",", $user_answered));
        } else {
            return $user_answered == $ans;
        }
    }
    
    private static function evaluateIsNotSelected($qus_type, $ans, $user_answered,$qusID)
    {
        if ($qus_type == 'matrix_qus') {
            $user_answered = json_decode($user_answered);
            return $user_answered[$qusID[1]]->key == $qusID[1] && $ans != $user_answered[$qusID[1]]->ans;
        } elseif ($qus_type == 'multi_choice') {
            return !in_array($ans, explode(",", $user_answered));
        } else {
            return $user_answered != $ans;
        }
    }
    
    private static function loopNextQuestion($current_question_id, $survey_id, $other_details)
    {
        $next_question = Questions::where('id', '>', $current_question_id)
            ->where(['survey_id' => $survey_id])
            ->whereNotIn('qus_type', ['welcome_page', 'thank_you'])
            ->first();
    
        if ($next_question) {
            $surveyController = new SurveyController;
            return $surveyController->displayNextQus($next_question->id, $survey_id, $other_details);
        } else {
            return self::handleSurveyCompletion($survey_id, $other_details);
        }
    }
    
    private static function handleSurveyCompletion($survey_id, $other_details)
    {
        $surveyRec = Survey::find($survey_id);
        Survey::where(['id' => $survey_id])->increment('completed_count');
    
        $next_qus = Questions::where(['survey_id' => $survey_id, 'qus_type' => 'thank_you','survey_thankyou_page'=>1])->first();
        if ($next_qus) {
            self::saveSurveyResponse($survey_id, $next_qus->id, $other_details, 'thankyou_submitted');
            self::updateProjectCompletion($surveyRec, Auth::user()->id);
            return redirect()->route('survey.endsurvey', [$survey_id, $next_qus->id]);
        } else {
            self::updateProjectCompletion($surveyRec, Auth::user()->id);
            return redirect()->route('survey.endsurvey', [$survey_id, 0]);
        }
    }
    
    private static function saveSurveyResponse($survey_id, $question_id, $other_details, $answer)
    {
        $surveyres = new SurveyResponse();
        $surveyres->other_details = json_encode($other_details);
        $surveyres->survey_id = $survey_id;
        $surveyres->response_user_id = Auth::user()->id;
        $surveyres->question_id = $question_id;
        $surveyres->answer = $answer;
        $surveyres->skip = '';
        $surveyres->deleted_at = 0;
        $surveyres->save();
    }
    
    private static function updateProjectCompletion($surveyRec, $response_user_id)
    {
        if ($surveyRec->survey_type == 'survey') {
            $project = Projects::where(['survey_link' => $surveyRec->id])->first();
            if ($project) {
                Project_respondent::where('project_id', $project->id)
                    ->where('respondent_id', $response_user_id)
                    ->update(['is_frontend_complete' => 1]);
            }
        }
    }
    
   public function responses(Request $request,$survey_id)
    {
        try {
            $survey = Survey::with('folder')->where(['id'=>$survey_id])->first();
            $question=Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
            $matrix_qus=Questions::where(['qus_type'=>'matrix_qus','survey_id'=>$survey_id])->get();

            $responses = SurveyResponse::where(['survey_id'=>$survey_id])->get();
            $cols = [ ["data"=>"#","name"=>"#","orderable"=> false,"searchable"=> false], ["data"=>"name","name"=>"Name","orderable"=> true,"searchable"=> true],["data"=>"responseinfo","name"=>"Date","orderable"=> true,"searchable"=> true]];
            
            foreach($question as $qus){
                $data = ["data"=>$qus->question_name,"name"=>$qus->question_name,"orderable"=> true,"searchable"=> true];
                array_push($cols,$data);
            }
            foreach($matrix_qus as $qus){
                $qus = json_decode($qus->qus_ans); 
                $exiting_qus_matrix= $qus!=null ? explode(",",$qus->matrix_qus): []; $i=0;
                foreach($exiting_qus_matrix as $qus1){
                    $data = ["data"=>$qus1,"name"=>$qus1,"orderable"=> true,"searchable"=> true];
                    array_push($cols,$data);
                }
            }
            return view('admin.survey.survey.overview',compact('survey','question','responses','survey_id','cols'));

            return view('admin.survey.survey.responses',compact('survey','question','responses','survey_id','cols'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function get_all_response(Request $request,$survey_id) {
		
        try {
            if ($request->ajax()) {

                $token = csrf_token();
                $question=Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
                
                $surveyResponseUsers =  SurveyResponse::where(['survey_id'=>$survey_id])->groupBy('response_user_id')->pluck('response_user_id')->toArray();
                $finalResult =[];

                foreach($surveyResponseUsers as $userID){
                    $user = Respondents::where('id', '=' , $userID)->first();
                    $starttime = SurveyResponse::where(['survey_id'=>$survey_id,'response_user_id'=>$userID])->orderBy("id", "asc")->first();
                    $endtime = SurveyResponse::where(['survey_id'=>$survey_id,'response_user_id'=>$userID])->orderBy("id", "desc")->first();
                    $startedAt = $starttime->created_at;
                    $endedAt = $endtime->created_at;
                    $time = $endedAt->diffInSeconds($startedAt); 
                    $responseinfo = $startedAt->toDayDateTimeString().' | '.$time.' seconds';
                    $result =['#'=>'','name'=>$user->name,'responseinfo'=>$responseinfo];
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
                            $left_label='Least Likely';
                            $middle_label='Netural';
                            $right_label='Most Likely';
                            $likert_range = 10;
                            if(isset($qusvalue->right_label)){
                                $right_label=$qusvalue->right_label;
                            }
                            if(isset($qusvalue->middle_label)){
                                $middle_label=$qusvalue->middle_label;
                            }
                            if(isset($qusvalue->likert_range)){
                                $likert_range=$qusvalue->likert_range;
                            }
                            if(isset($qusvalue->left_label)){
                                $left_label=$qusvalue->left_label;
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
                            $output = json_decode($output,true);
                            $ordering = [];
                            if($output!=null)
                            foreach($output as $op){
                                array_push($ordering,$op['id']);
                            }
                            $tempresult = [$qus->question_name =>implode(',',$ordering)];
                            $result[$qus->question_name]=implode(',',$ordering);
                        }else if($qus->qus_type == 'photo_capture'){
                            $img = "<a target='_blank' href='$output'><img class='photo_capture' src='$output'/></a>";
                            $tempresult = [$qus->question_name =>$img];
                            $result[$qus->question_name]=$img;
                        }else if($qus->qus_type=='upload'){
                            $output1=asset('uploads/survey/'.$output);
                            $img = "<a target='_blank' href='$output1'>".$output."</a>";
                            $tempresult = [$qus->question_name =>$img];
                            $result[$qus->question_name]=$img;
                        }else{
                            $tempresult = [$qus->question_name =>$output];
                            $result[$qus->question_name]=$output;
                        }
                        
                    }
                    array_push($finalResult,$result);
                }

      
            return Datatables::of($finalResult)->escapeColumns([])
            ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function surveytemplate(Request $request,$id,$type){
        $survey = Survey::where(['id'=>$id])->first();
        $surveyTemplate = SurveyTemplate::where(['type'=>$type])->get();
        return view('admin.survey.survey.surveytemplate',compact('survey','surveyTemplate','type'));

    }
    public function createSurveyTemplate(Request $request,$type){
        $user = Auth::guard('admin')->user();
        return view('admin.survey.survey.createtemplate',compact('type'));
    }

    public function storeSurveyTemplate(Request $request){
        $user = Auth::guard('admin')->user();
        $survey = new SurveyTemplate();
        $survey->template_name = $request->template_name;
        $survey->title = $request->title;
        $survey->type = $request->template_type;
        $survey->sub_title = $request->sub_title;
        if($request->template_type == 'welcome'){
            $survey->description = $request->description;
            $survey->button_label = $request->button_label;
            $survey->created_by = $user->id;
        }
        if($request->tbs_logo == 'on'){
            $survey->tbs_logo = 1;
        }else{
            $survey->tbs_logo = 0;
        }
        $filename='';
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/survey/', $filename);
            $survey->image = $filename;

        }
        // TBS Logo 
        $filename='small-logo.png';
        if($request->hasfile('image_TBS'))
        {
            $file = $request->file('image_TBS');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/survey/', $filename);
            $survey->logo_url = $filename;

        }else{
            $survey->logo_url = $filename;
        }
        $survey->save();
        return redirect()->back()->with('success', __('Template Created Successfully.'));

    }

    public function editSurveyTemplate($id){
        $surveytemplate=SurveyTemplate::where(['id'=>$id])->first();
        $user = Auth::guard('admin')->user();
        return view('admin.survey.survey.edittemplate', compact('surveytemplate'));

    }

    public function updateSurveyTemplate(Request $request,$id){
        $user = Auth::guard('admin')->user();
        $survey=SurveyTemplate::where(['id'=>$id])->first();
        $survey->title = $request->title;        
        $survey->template_name = $request->template_name;

        $survey->type = $request->template_type;
        $survey->sub_title = $request->sub_title;
        if($request->template_type == 'welcome'){
            $survey->description = $request->description;
            $survey->button_label = $request->button_label;
            $survey->created_by = $user->id;
        }
        $filename='';
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/survey/', $filename);
            $survey->image = $filename;
        }
       
        if($request->tbs_logo == 'on'){
            $survey->tbs_logo = 1;
        }else{
            $survey->tbs_logo = 0;
        }
         // TBS Logo 
         $filename='';
         if($request->hasfile('image_TBS'))
         {
             $file = $request->file('image_TBS');
             $extenstion = $file->getClientOriginalExtension();
             $filename = time().'.'.$extenstion;
             $file->move('uploads/survey/', $filename);
             $survey->logo_url = $filename;
 
         }
        $survey->save();
        return redirect()->back()->with('success', __('Template Updated Successfully.'));
        
    }

    public function deleteSurveyTemplate($id){
        $surveytemplate=SurveyTemplate::where(['id'=>$id])->first();
        $surveytemplate->delete();
        return redirect()->back()->with('success', __('Survey template deleted Successfully.'));
    }
    
    public function templatedetails(Request $request){
        $surveytemplate=SurveyTemplate::where(['id'=>$request->id])->first();
        return $surveytemplate;
    }
    public function get_all_templates(Request $request,$survey_id,$type) {
		
        try {
            if ($request->ajax()) {
                $token = csrf_token();
                $surveytemplate=SurveyTemplate::where(['type'=>$type])->get();
                $finalResult=[];
                foreach($surveytemplate as $template){
                    $output=asset('uploads/survey/'.$template->image);
                    if($template->image!=null && $template->image!='')
                    {
                        $img = "<a target='_blank' href='$output'><img class='photo_capture' src='$output'/></a>";
                    }else{
                        $img='';
                    }
                    $editLink=route('survey.edittemplate',$template->id);
                    $deletedLink=route('survey.deletetemplate',$template->id);
                    $action = '<div class="actionsBtn"><a href="#" class="btn btn-primary waves-effect waves-light editFolder" data-url="'.$editLink.'" data-ajax-popup="true" data-bs-toggle="tooltip" title="Edit Template" data-title="Edit Template">Edit</a>
                    <a href="'.$deletedLink.'" class="btn btn-danger  waves-effect waves-light">Delete</a>';
               

                    $result =['template_name'=>$template->template_name,'title'=>$template->title,'sub_title'=>$template->sub_title,'description'=>$template->description,'button_label'=>$template->button_label,'image'=>$img,'action'=>$action];
                    array_push($finalResult,$result);


                }
                return Datatables::of($finalResult)->escapeColumns([])->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
     // Generate Word Cloud
     public function generateWordCloud()
     {
         // Given text
         $text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";
 
         // Generate word cloud HTML
         $wordCloud = '';
         $words = explode(' ', $text);
         foreach ($words as $word) {
             $wordCloud .= '<span style="font-size: ' . rand(10, 30) . 'px;color:'.$this->generateRandomColor().'">' . $word . '</span> ';
         }
 
         // Set the HTML content
         SEOTools::setTitle('Word Cloud');
         SEOTools::setDescription('Word cloud generated from given text.');
 
         // Generate the HTML with SEO metadata
         $html = SEOTools::generate();
 
         // Append the word cloud HTML
         $html .= '<div style="display: flex; flex-wrap: wrap; width:500px">' . $wordCloud . '</div>';
 
         // Return the HTML
         return $html;
     }
     // Generate PDF Report
     public function generatePDF()
     {
         // HTML content to be converted to PDF
         $html = $this->generateWordCloud();
 
         // Create an instance of Dompdf
         $dompdf = new Dompdf();
 
         // Load HTML content
         $dompdf->loadHtml($html);
 
         // (Optional) Set options (e.g., paper size, orientation)
         $options = new Options();
         $options->set('defaultFont', 'Arial');
         $dompdf->setOptions($options);
 
         // Render PDF (parse HTML and convert to PDF)
         $dompdf->render();
         
 
         // Output PDF (force download or display in browser)
         return $dompdf->stream('document.pdf');
     }
     public function generateRandomColor()
     {
         // Generate random RGB values
         $red = mt_rand(0, 255);
         $green = mt_rand(0, 255);
         $blue = mt_rand(0, 255);
 
         // Convert RGB values to hexadecimal color code
         $hexColor = sprintf("#%02x%02x%02x", $red, $green, $blue);
         return $hexColor;
     }

    //  Set Quota
    public function setquota(Request $request,$survey_id){
        $questions=Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
        $redirection=SurveyTemplate::where(['type'=>'thankyou'])->pluck('title', 'id')->toArray();

        // $redirection=Questions::where(['survey_id'=>$survey_id])->whereIn('qus_type',['thank_you'])->get();
        $quotas = SurveyQuotas::where(['survey_id'=>$survey_id])->get();
        $survey = Survey::where(['id'=>$survey_id])->first();
        return view('admin.survey.quota.index', compact('questions','redirection','quotas','survey'));
    }

    public function createquota(Request $request,$survey_id){
        $user = Auth::guard('admin')->user();
        
        $questions=Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['welcome_page','thank_you'])->pluck('question_name', 'id')->toArray();
        $redirection=SurveyTemplate::where(['type'=>'thankyou'])->pluck('title', 'id')->toArray();
        // Questions::where(['survey_id'=>$survey_id])->whereIn('qus_type',['thank_you'])->pluck('question_name', 'id')->toArray();
        $quotas = SurveyQuotas::where(['survey_id'=>$survey_id])->get();
        $survey = Survey::where(['id'=>$survey_id])->first();

        $display_logic=Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['matrix_qus','welcome_page','thank_you'])->pluck('question_name', 'id')->toArray();
        $display_logic_matrix=Questions::where(['qus_type'=>'matrix_qus','survey_id'=>$survey_id])->get();

        return view('admin.survey.quota.create', compact('quotas','survey','questions','display_logic_matrix','display_logic','redirection'));
    }
    public function storequota(Request $request){
        $user = Auth::guard('admin')->user();
        $surveyquota = new SurveyQuotas();
        $surveyquota->survey_id = $request->survey_id;
        $surveyquota->quota_name = $request->quota_name;
        $surveyquota->quota_limit = $request->quota_limit;
        $surveyquota->question_id = $request->question_id;
        $surveyquota->option_type = $request->option_type;
        if(is_array($request->option_value)){
            $surveyquota->option_value = implode(',', $request->option_value);
        }
        else {
            $surveyquota->option_value = $request->option_value;
        }
        $surveyquota->redirection_qus = $request->redirection_qus;
        $surveyquota->created_by = $user->id;
        $surveyquota->save();
        return redirect()->back()->with('success', __('Quota Created Successfully.'));
    }

    public function editquota($id){

        $quota=SurveyQuotas::where(['id'=>$id])->first();
        $user = Auth::guard('admin')->user();
        $survey_id = $quota->survey_id;
        $questions=Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['welcome_page','thank_you'])->pluck('question_name', 'id')->toArray();
        // $redirection=Questions::where(['survey_id'=>$survey_id])->whereIn('qus_type',['thank_you'])->pluck('question_name', 'id')->toArray();
        $redirection=SurveyTemplate::where(['type'=>'thankyou'])->pluck('title', 'id')->toArray();

        $quotas = SurveyQuotas::where(['survey_id'=>$survey_id])->get();
        $survey = Survey::where(['id'=>$survey_id])->first();
        $display_logic=Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['matrix_qus','welcome_page','thank_you'])->pluck('question_name', 'id')->toArray();
        $display_logic_matrix=Questions::where(['qus_type'=>'matrix_qus','survey_id'=>$survey_id])->get();
        return view('admin.survey.quota.edit', compact('quota','survey','questions','display_logic_matrix','display_logic','redirection'));
    }

    public function updatequota(Request $request,$id){
        $user = Auth::guard('admin')->user();
        $surveyquota=SurveyQuotas::where(['id'=>$id])->first();
        $surveyquota->survey_id = $request->survey_id;
        $surveyquota->quota_name = $request->quota_name;
        $surveyquota->quota_limit = $request->quota_limit;
        $surveyquota->question_id = $request->question_id;
        $surveyquota->option_type = $request->option_type;
        if(is_array($request->option_value)){
            $surveyquota->option_value = implode(',', $request->option_value);
        }
        else {
            $surveyquota->option_value = $request->option_value;
        }
        $surveyquota->redirection_qus = $request->redirection_qus;
        $surveyquota->created_by = $user->id;
        $surveyquota->save();
        return redirect()->back()->with('success', __('Quota Updated Successfully.'));
    }

    public function deletequota(Request $request,$id){
        $surveyquota=SurveyQuotas::where(['id'=>$id])->first();
        $surveyquota->delete();
        return json_encode(['success'=>'Quota deleted Successfully',"error"=>""]);
    }
    public function checkquota($survey_id, $current_question_id, $current_user_ans)
    {
        $survey = Survey::find($survey_id);
        if (!$survey) {  
            return "Survey not found.";
        }
    
        $surveyquotas = SurveyQuotas::where(['survey_id' => $survey_id, 'question_id' => $current_question_id])->get();
   
        if ($surveyquotas->isEmpty()) {
            return "limitavailable";
        }
     
        foreach ($surveyquotas as $quota) {
            $question_id_parts = explode('_', $quota->question_id);
            if (is_array($question_id_parts) && count($question_id_parts) > 0) {
                $checkresponses = SurveyResponse::with('questions')
                    ->where(['survey_id' => $survey->id, 'question_id' => $question_id_parts[0]])
                    ->get();
    
                $limit = 0;
                $quota_match = false;
    
                // Check if the current user's answer matches the quota criteria
                switch ($quota->option_type) {
                    case 'isSelected':
                        if (is_array($current_user_ans)) {
                            if (in_array($quota->option_value, $current_user_ans)) {
                                $quota_match = true;
                            }
                        } else {
                            if ($current_user_ans == $quota->option_value) {
                                $quota_match = true;
                            }
                        }
                        break;
                    case 'isNotSelected':
                        if (is_array($current_user_ans)) {
                            if (!in_array($quota->option_value, $current_user_ans)) {
                                $quota_match = true;
                            }
                        } else {
                            if ($current_user_ans != $quota->option_value) {
                                $quota_match = true;
                            }
                        }
                        break;
                    case 'isAnswered':
                        if ($current_user_ans != '') {
                            $quota_match = true;
                        }
                        break;
                    case 'isNotAnswered':
                        if ($current_user_ans == '') {
                            $quota_match = true;
                        }
                        break;
                    case 'contains':
                        if (str_contains($current_user_ans, $quota->option_value)) {
                            $quota_match = true;
                        }
                        break;
                    case 'doesNotContain':
                        if (!str_contains($current_user_ans, $quota->option_value)) {
                            $quota_match = true;
                        }
                        break;
                    case 'startsWith':
                        if (str_starts_with($current_user_ans, $quota->option_value)) {
                            $quota_match = true;
                        }
                        break;
                    case 'endsWith':
                        if (str_ends_with($current_user_ans, $quota->option_value)) {
                            $quota_match = true;
                        }
                        break;
                    case 'equalsString':
                        if ($current_user_ans == $quota->option_value) {
                            $quota_match = true;
                        }
                        break;
                    case 'notEqualTo':
                        if ($current_user_ans != $quota->option_value) {
                            $quota_match = true;
                        }
                        break;
                    case 'lessThanForScale':
                        if ((int)$current_user_ans < (int)$quota->option_value) {
                            $quota_match = true;
                        }
                        break;
                    case 'greaterThanForScale':
                        if ((int)$current_user_ans > (int)$quota->option_value) {
                            $quota_match = true;
                        }
                        break;
                    case 'equalToForScale':
                        if ((int)$current_user_ans == (int)$quota->option_value) {
                            $quota_match = true;
                        }
                        break;
                    case 'notEqualToForScale':
                        if ((int)$current_user_ans != (int)$quota->option_value) {
                            $quota_match = true;
                        }
                        break;
                }
             
                // If the current user's answer matches the quota criteria
                if ($quota_match) {
                    foreach ($checkresponses as $userResp) {
                        $ques = Questions::find($userResp->question_id);
                        if (!$ques) continue;
    
                        $user_answered = $userResp->answer ?? '';
                        $user_skipped = $userResp->skip ?? '';
                        $qus_type = $userResp->questions[0]->qus_type ?? '';
    
                        switch ($quota->option_type) {
                            case 'isSelected':
                                if ($qus_type == 'matrix_qus') {
                                    $user_answered = json_decode($user_answered, true);
                                    if (isset($user_answered[$question_id_parts[1]]) &&
                                        $user_answered[$question_id_parts[1]]['key'] == $question_id_parts[1] &&
                                        $quota->option_value == $user_answered[$question_id_parts[1]]['ans']) {
                                        $limit++;
                                    }
                                } elseif ($qus_type == 'multi_choice') {
                                    $user_answered = explode(",", $user_answered);
                                    if (in_array($quota->option_value, $user_answered)) {
                                        $limit++;
                                    }
                                } else {
                                    if ($user_answered == $quota->option_value) {
                                        $limit++;
                                    }
                                }
                                break;
                            case 'isNotSelected':
                                if ($qus_type == 'matrix_qus') {
                                    $user_answered = json_decode($user_answered, true);
                                    if (isset($user_answered[$question_id_parts[1]]) &&
                                        $user_answered[$question_id_parts[1]]['key'] == $question_id_parts[1] &&
                                        $quota->option_value != $user_answered[$question_id_parts[1]]['ans']) {
                                        $limit++;
                                    }
                                } elseif ($qus_type == 'multi_choice') {
                                    $user_answered = explode(",", $user_answered);
                                    if (!in_array($quota->option_value, $user_answered)) {
                                        $limit++;
                                    }
                                } else {
                                    if ($user_answered != $quota->option_value) {
                                        $limit++;
                                    }
                                }
                                break;
                            case 'isAnswered':
                                if ($user_answered != '') {
                                    $limit++;
                                }
                                break;
                            case 'isNotAnswered':
                                if ($user_skipped == 'yes') {
                                    $limit++;
                                }
                                break;
                            case 'contains':
                                if (str_contains($user_answered, $quota->option_value)) {
                                    $limit++;
                                }
                                break;
                            case 'doesNotContain':
                                if (!str_contains($user_answered, $quota->option_value)) {
                                    $limit++;
                                }
                                break;
                            case 'startsWith':
                                if (str_starts_with($user_answered, $quota->option_value)) {
                                    $limit++;
                                }
                                break;
                            case 'endsWith':
                                if (str_ends_with($user_answered, $quota->option_value)) {
                                    $limit++;
                                }
                                break;
                            case 'equalsString':
                                if ($user_answered == $quota->option_value) {
                                    $limit++;
                                }
                                break;
                            case 'notEqualTo':
                                if ($user_answered != $quota->option_value) {
                                    $limit++;
                                }
                                break;
                            case 'lessThanForScale':
                                if ((int)$user_answered < (int)$quota->option_value) {
                                    $limit++;
                                }
                                break;
                            case 'greaterThanForScale':
                                if ((int)$user_answered > (int)$quota->option_value) {
                                    $limit++;
                                }
                                break;
                            case 'equalToForScale':
                                if ((int)$user_answered == (int)$quota->option_value) {
                                    $limit++;
                                }
                                break;
                            case 'notEqualToForScale':
                                if ((int)$user_answered != (int)$quota->option_value) {
                                    $limit++;
                                }
                                break;
                        }
                    }
                    // If the quota limit is reached, return the redirection question
                    if ($limit >= (int)$quota->quota_limit) {
       
                        return $quota->redirection_qus;
                    }
                }else{

                    return "limitavailable";
                }
            }
        }
        // If no quotas are reached, proceed to the next question
        return "limitavailable";
    }
    
        // Get qus type
    function Qustype($type){
        $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','photo_capture'=>'Photo Capture','email'=>'Email','upload'=>'Upload','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
        return $questionTypes[$type];
    }

    // Human readable time 
    function humanReadableTime($datetime){
        // Create DateTime objects for the given datetime and the current datetime
        $currentDateTime = new \DateTime();
        $givenDateTime = new \DateTime($datetime);
        // Calculate the difference between the given datetime and the current datetime
        $interval = $currentDateTime->diff($givenDateTime);
        // Convert the difference to a human-readable format
        if ($interval->y > 0) {
            $output = $interval->y . " year" . ($interval->y > 1 ? "s" : "") . " ago";
        } elseif ($interval->m > 0) {
            $output = $interval->m . " month" . ($interval->m > 1 ? "s" : "") . " ago";
        } elseif ($interval->d > 0) {
            $output = $interval->d . " day" . ($interval->d > 1 ? "s" : "") . " ago";
        } elseif ($interval->h > 0) {
            $output = $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
        } elseif ($interval->i > 0) {
            $output = $interval->i . " min" . ($interval->i > 1 ? "s" : "") . " ago";
        } else {
            $output = "Just now";
        }

        return $output;
    }
    public function generateReport(Excel $excel, $survey_id, $type)
    {
        // Custom array data to export
        $survey = Survey::where(['id'=>$survey_id])->first();
        $question=Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['matrix_qus','welcome_page','thank_you','rankorder','multi_choice'])->get();
        $matrix_qus=Questions::where(['qus_type'=>'matrix_qus','survey_id'=>$survey_id])->get();
        $multi_choice_qus=Questions::where(['qus_type'=>'multi_choice','survey_id'=>$survey_id])->get();
        $rankorder_qus=Questions::where(['qus_type'=>'rankorder','survey_id'=>$survey_id])->get();

        $cols = ["Respondent Name", "Date","Device ID","Device Name","Completion Status","Browser","OS","Device Type","Long","Lat","Location","IP Address","Language Code","Language Name"];
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

        function getValues($data) {
            // echo "<pre>";
            // print_r($data);
            // Extract the header row
            $header = $data[0];

            // Create a mapping of header keys to their positions
            $headerMapping = array_flip($header);

            // Initialize an array to store the rearranged rows
            $values = [];

            // Add the header row to the values array
            $values[] = array_values($header);

            // Loop through each row starting from the second element (skip header row)
            for ($i = 1; $i < count($data); $i++) {
                $row = $data[$i];
                $rearrangedRow = [];

                // Loop through the header keys and arrange the row values accordingly
                foreach ($header as $key) {
                    if (isset($row[$key])) {
                        $rearrangedRow[] = $row[$key];
                    } else {
                        $rearrangedRow[] = ''; // Handle missing keys by adding an empty string
                    }
                }

                $values[] = $rearrangedRow;
            }

            return $values;
        }

        // Get Survey Data 
        $question = Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
                
        $surveyResponseUsers =  SurveyResponse::where(['survey_id'=>$survey_id])->groupBy('response_user_id')->pluck('response_user_id')->toArray();
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

            $result =['Respondent Name'=>$name,'Date'=>$responseinfo,'Device ID'=>$deviceID,'Device Name'=>$device_name,'Completion Status'=>$completion_status,'Browser'=>$browser,'OS'=>$os,'Device Type'=>$device_type,'Long'=>$long,'Lat'=>$lat,'Location'=>$location,'IP Address'=>$ip_address,'Language Code'=>$lang_code,'Language Name'=>$lang_name];
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
            array_push($finalResult,$result);
        }
        //     echo "<pre>";
        //   print_r($finalResult);
        //   exit;
        $data = getValues($finalResult);
        // echo "<pre>";
        // print_r($data);
        // exit;
        if($type == 'csv'){
            // Generate a dynamic filename based on the current timestamp
            $filename = $survey->title.'_Report' . now()->format('YmdHis') . '.csv';

            // Export data to Excel with the dynamic filename
            $callback = function () use ($data) {
                $file = fopen('php://output', 'w');
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }
                fclose($file);
            };

            // Generate the Excel file and return a download response
            return response()->streamDownload($callback, $filename, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }else{
            // // Generate a dynamic filename based on the current timestamp
            // $filename = $survey->title.'_Report' . now()->format('YmdHis') . '.xlsx';

            // // Generate the Excel content
            // $excelContent = $this->generateExcelContent($data);

            // // Store the Excel file
            // Storage::put($filename, $excelContent);

            // // Return a download response
            // return response()->download(storage_path('app/' . $filename), $filename);
             // Generate the Excel content and store the file directly
            $filename = $survey->title.'_Report_' . now()->format('YmdHis') . '.xlsx';
            $filePath = storage_path('app/' . $filename);
            $this->generateAndStoreExcelContent($data, $filePath);

            // Return a download response
            return response()->download($filePath, $filename);
        }
       
    }

    public function generateReportbyRespondent(Excel $excel, $user_id)
    {
        // Get Surveys by User Id
        $survey_IDs = SurveyResponse::where(['response_user_id' => $user_id])->groupBy('survey_id')->pluck('survey_id')->toArray();
      
    
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
                    $rearrangedRow[] = $row[$key] ?? '';
                }
                $values[] = $rearrangedRow;
            }

            return $values;
        }
        foreach ($survey_IDs as $survey_id) {
            // Custom array data to export
            $survey = Survey::where(['id' => $survey_id])->first();
          
            $question = Questions::where(['survey_id' => $survey_id])->whereNotIn('qus_type', ['matrix_qus', 'welcome_page', 'thank_you', 'rankorder', 'multi_choice'])->get();
            $matrix_qus = Questions::where(['qus_type' => 'matrix_qus', 'survey_id' => $survey_id])->get();
            $multi_choice_qus = Questions::where(['qus_type' => 'multi_choice', 'survey_id' => $survey_id])->get();
            $rankorder_qus = Questions::where(['qus_type' => 'rankorder', 'survey_id' => $survey_id])->get();
    
            $cols = ["Respondent Name", "Date", "Device ID", "Device Name", "Completion Status", "Browser", "OS", "Device Type", "Long", "Lat", "Location", "IP Address", "Language Code", "Language Name"];
            foreach ($question as $qus) {
                array_push($cols, $qus->question_name);
            }
            foreach ($multi_choice_qus as $qus) {
                $qus_ans = json_decode($qus->qus_ans);
                $choices = $qus_ans != null ? explode(",", $qus_ans->choices_list) : [];
                foreach ($choices as $qus1) {
                    array_push($cols, $qus->question_name . '_' . $qus1);
                }
            }
            foreach ($rankorder_qus as $qus) {
                $qus_ans = json_decode($qus->qus_ans);
                $choices = $qus_ans != null ? explode(",", $qus_ans->choices_list) : [];
                foreach ($choices as $qus1) {
                    array_push($cols, $qus->question_name . '_' . $qus1);
                }
            }
            foreach ($matrix_qus as $qus) {
                $qus = json_decode($qus->qus_ans);
                array_push($cols, $qus->question_name);
                $exiting_qus_matrix = $qus != null ? explode(",", $qus->matrix_qus) : [];
                foreach ($exiting_qus_matrix as $qus1) {
                    array_push($cols, $qus1);
                }
            }
    
           
    
            // Get Survey Data
            $question = Questions::where(['survey_id' => $survey_id])->whereNotIn('qus_type', ['welcome_page', 'thank_you'])->get();
    
            $surveyResponseUsers = SurveyResponse::where(['survey_id' => $survey_id,'response_user_id'=>$user_id])->groupBy('response_user_id')->pluck('response_user_id')->toArray();
            $finalResult = [$cols];
            foreach ($surveyResponseUsers as $userID) {
                $user = Respondents::where('id', $userID)->first();
                $starttime = SurveyResponse::where(['survey_id' => $survey_id, 'response_user_id' => $userID])->orderBy("id", "asc")->first();
                $endtime = SurveyResponse::where(['survey_id' => $survey_id, 'response_user_id' => $userID])->orderBy("id", "desc")->first();
                $startedAt = $starttime->created_at;
                $endedAt = $endtime->created_at;
                $time = $endedAt->diffInSeconds($startedAt);
                $responseinfo = $startedAt->toDayDateTimeString() . ' | ' . $time . ' seconds';
                $other_details = json_decode($endtime->other_details);
                $deviceID = $other_details->device_id ?? '';
                $device_name = $other_details->device_name ?? '';
                $browser = $other_details->browser ?? '';
                $os = $other_details->os ?? '';
                $device_type = '';
                $lang_name = $other_details->lang_name ?? '';
                $long = $other_details->long ?? '';
                $lat = $other_details->lat ?? '';
                $location = $other_details->location ?? '';
                $ip_address = $other_details->ip_address ?? '';
                $lang_code = $other_details->lang_code ?? '';
                $name = $user->name ?? 'Anonymous';
    
                $completedRes = SurveyResponse::where(['response_user_id' => $userID, 'survey_id' => $survey_id, 'answer' => 'thankyou_submitted'])->first();
                $completion_status = $completedRes ? 'Completed' : 'Partially Completed';
    
                $result = ['Respondent Name' => $name, 'Date' => $responseinfo, 'Device ID' => $deviceID, 'Device Name' => $device_name, 'Completion Status' => $completion_status, 'Browser' => $browser, 'OS' => $os, 'Device Type' => $device_type, 'Long' => $long, 'Lat' => $lat, 'Location' => $location, 'IP Address' => $ip_address, 'Language Code' => $lang_code, 'Language Name' => $lang_name];
    
                foreach ($question as $qus) {
                    $respone = SurveyResponse::where(['survey_id' => $survey_id, 'question_id' => $qus->id, 'response_user_id' => $userID])->orderBy("id", "desc")->first();
                    $output = $respone ? ($respone->skip == 'yes' ? 'Skip' : $respone->answer) : '-';
    
                    if ($qus->qus_type == 'likert') {
                        $qusvalue = json_decode($qus->qus_ans);
                        $left_label = $qusvalue->left_label ?? 'Least Likely';
                        $middle_label = $qusvalue->middle_label ?? 'Neutral';
                        $right_label = $qusvalue->right_label ?? 'Most Likely';
                        $likert_range = $qusvalue->likert_range ?? 10;
                        $output = intval($output);
                        $likert_label = $output;
    
                        if ($likert_range <= 4 && $output <= 4) {
                            $likert_label = $output <= 2 ? $left_label : $right_label;
                        } else if ($likert_range >= 5 && $output >= 5) {
                            if ($likert_range == 5) {
                                if ($output <= 2) {
                                    $likert_label = $left_label;
                                } else if ($output == 3) {
                                    $likert_label = $middle_label;
                                } else {
                                    $likert_label = $right_label;
                                }
                            } else if ($likert_range == 6) {
                                if ($output <= 2) {
                                    $likert_label = $left_label;
                                } else if ($output <= 4) {
                                    $likert_label = $middle_label;
                                } else {
                                    $likert_label = $right_label;
                                }
                            } else if ($likert_range == 7) {
                                if ($output <= 2) {
                                    $likert_label = $left_label;
                                } else if ($output <= 5) {
                                    $likert_label = $middle_label;
                                } else {
                                    $likert_label = $right_label;
                                }
                            } else if ($likert_range == 8) {
                                if ($output <= 3) {
                                    $likert_label = $left_label;
                                } else if ($output <= 5) {
                                    $likert_label = $middle_label;
                                } else {
                                    $likert_label = $right_label;
                                }
                            } else if ($likert_range == 9) {
                                if ($output <= 3) {
                                    $likert_label = $left_label;
                                } else if ($output <= 6) {
                                    $likert_label = $middle_label;
                                } else {
                                    $likert_label = $right_label;
                                }
                            } else if ($likert_range == 10) {
                                if ($output <= 3) {
                                    $likert_label = $left_label;
                                } else if ($output <= 7) {
                                    $likert_label = $middle_label;
                                } else {
                                    $likert_label = $right_label;
                                }
                            }
                        }
    
                        $result[$qus->question_name] = $likert_label;
                    } else if ($qus->qus_type == 'matrix_qus') {
                        $result[$qus->question_name] = '';
                        if ($output == 'Skip') {
                            foreach (json_decode($qus->qus_ans) as $matrix_qus) {
                                $result[$matrix_qus] = 'Skip';
                            }
                        } else {
                            foreach (json_decode($qus->qus_ans) as $matrix_qus) {
                                $matrixQus = SurveyResponse::where(['survey_id' => $survey_id, 'matrix_qus' => $matrix_qus, 'response_user_id' => $userID])->orderBy("id", "desc")->first();
                                $output_matrix_qus = $matrixQus ? $matrixQus->answer : '-';
                                $result[$matrix_qus] = $output_matrix_qus;
                            }
                        }
                    } else {
                        $result[$qus->question_name] = $output;
                    }
                }
    
                foreach ($multi_choice_qus as $qus) {
                    $qus_ans = json_decode($qus->qus_ans);
                    $choices = $qus_ans != null ? explode(",", $qus_ans->choices_list) : [];
                    $multichoicesResult = [];
                    foreach ($choices as $choice) {
                        $answer = SurveyResponse::where(['survey_id' => $survey_id, 'question_id' => $qus->id, 'response_user_id' => $userID, 'answer' => $choice])->orderBy("id", "desc")->first();
                        $multichoicesResult[$qus->question_name . '_' . $choice] = $answer ? 'Yes' : 'No';
                    }
                    $result = array_merge($result, $multichoicesResult);
                }
    
                foreach ($rankorder_qus as $qus) {
                    $qus_ans = json_decode($qus->qus_ans);
                    $choices = $qus_ans != null ? explode(",", $qus_ans->choices_list) : [];
                    $rankorderResult = [];
                    foreach ($choices as $choice) {
                        $answer = SurveyResponse::where(['survey_id' => $survey_id, 'question_id' => $qus->id, 'response_user_id' => $userID, 'answer' => $choice])->orderBy("id", "desc")->first();
                        $rankorderResult[$qus->question_name . '_' . $choice] = $answer ? $answer->rank_ans : 'No';
                    }
                    $result = array_merge($result, $rankorderResult);
                }
    
                $finalResult[] = $result;
            }
    
            $finalResult = getValuesUser($finalResult);
            if($survey){
                $survey_name = $survey->title;
            }else{
                $survey_name = "Survey-".$survey_id;
            }
    
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
    
        $fileName = 'Survey_Report_' . $user_id . '_' . date('Y-m-d') . '.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
    
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filePath);
    
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
    
    private function generateAndStoreExcelContent($data, $filePath)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();

        // Set data into the spreadsheet
        foreach ($data as $rowIndex => $row) {
            foreach ($row as $columnIndex => $value) {
                // Convert column index to alphabetic column name (e.g., 1 -> A, 2 -> B, ...)
                $columnName = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex + 1);
                $cellReference = $columnName . ($rowIndex + 1);
                $worksheet->setCellValue($cellReference, $value);
            }
        }

        // Create a writer object and save the file directly to the specified path
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    private function generateExcelContent($data)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();

        // Set data into the spreadsheet
        foreach ($data as $rowIndex => $row) {
            foreach ($row as $columnIndex => $value) {
                // Convert column index to alphabetic column name (e.g., 1 -> A, 2 -> B, ...)
                $columnName = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex + 1);
                $cellReference = $columnName . ($rowIndex + 1);
                $worksheet->setCellValue($cellReference, $value);
            }
        }

        // Create a writer object
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Write the spreadsheet data to a string
        ob_start();
        $writer->save('php://output');
        $excelContent = ob_get_contents();
        ob_end_clean();

        return $excelContent;
    }

    public function templogin(Request $request){
        $respondents = new Respondents;
        $respondents->name = $request->input('name');
        // Check Email already exist or not 
        $emailCheck = Respondents::where(['email' => $request->input('email')])->first();
        if($emailCheck){
            // return redirect()->route('login');
            $user = Respondents::find($emailCheck->id);
            if ($user) {
                Auth::login($user);
                if (Auth::check()) {
                    return redirect()->route('survey.view',$request->survey_id);
                } else {
                    return redirect()->route('survey.view',$request->survey_id);
                }
            } else {
                return redirect()->route('survey.view',$request->survey_id);
            }
        }else{
            $respondents->email = $request->input('email');
            $respondents->password = "SurveyBMS@2024";
            $respondents->type = "temporary";
            $respondents->save();
            $user = Respondents::find($respondents->id);
            if ($user) {
                Auth::login($user);
                if (Auth::check()) {
                    return redirect()->route('survey.view',$request->survey_id);
                } else {
                    return redirect()->route('survey.view',$request->survey_id);
                }
            } else {
                return redirect()->route('survey.view',$request->survey_id);
            }
        }
    }
    public function moveQus(Request $request){
        foreach($request->order as $updateOrder){
             
            $getQus = Questions::where(['id'=>$updateOrder['qusId']])->first();
            // Update Qus 
            $upqus =  Questions::where(['id'=>$updateOrder['qusId']])->update(['qus_order_no'=>$updateOrder['update_index']]);

        }
        return response()->json(['data' => "Reordered"], 200);

    }
}


