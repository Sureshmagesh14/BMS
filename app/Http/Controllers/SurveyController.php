<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Folder;
use App\Models\Survey;
use App\Models\Questions;
use App\Models\SurveyResponse;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;
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
    public function templateList(Request $request,$id){
        $survey=Survey::where(['folder_id'=>$id,'is_deleted'=>0])->first();
        $folders=Folder::withCount('surveycount')->get();
        return view('admin.survey.template.index', compact('survey','folders'));
    }
    public function builder(Request $request,$survey,$qusID=0){
        // Generatre builder ID
        $survey=Survey::where(['builderID'=>$survey])->first();
        $questions=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
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
        $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','email'=>'Email','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
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
            $questionTypes=['single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','email'=>'Email','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
        }else{
            $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','email'=>'Email','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
        }
        return view('admin.survey.builder.create', compact('questionTypes','survey'));

    }
   public function questiontypesurvey(Request $request,$survey,$qustype){
    // Create New Question
    // Create New Qus 
    $user = Auth::guard('admin')->user();
    $newqus=new Questions();
    $newqus->survey_id=$survey;
    $newqus->qus_type=$qustype;
    $newqus->created_by=$user->id;
    $newqus->save();
    // Update Qus Count 
    $survey=Survey::where(['id'=>$survey])->first();
    if($qustype!='welcome_page' && $qustype!='thank_you'){
        $survey->qus_count=$survey->qus_count+1;
    }
    $survey->save();
    $questions=Questions::where(['survey_id'=>$survey])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
    
    return redirect()->route('survey.builder',[$survey->builderID,$newqus->id])->with('success', __('Question Created Successfully.'));


   }
   public function deletequs(Request $request,$id){
        $survey=Questions::where(['id'=>$id])->first();
        $survey->delete();
        return json_encode(['success'=>'Question deleted Successfully',"error"=>""]);
        
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
            $newqus=new Questions();
            $newqus->survey_id=$clonesurvey->id;
            $newqus->question_name=$qus->question_name;
            $newqus->qus_template=$qus->qus_template;
            $newqus->qus_type=$qus->qus_type;
            $newqus->qus_ans=$qus->qus_ans;
            $newqus->skip_logic=$qus->skip_logic;
            $newqus->display_logic=$qus->display_logic;
            $newqus->created_by=$user->id;
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
        $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','email'=>'Email','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
        $qus_type=$questionTypes[$currentQus->qus_type];
        $pagetype=$request->pagetype;

        return view('admin.survey.builder.index',compact('survey','questions','welcomQus','thankQus','currentQus','qus_type','pagetype'));
    }
    public function updateQus(Request $request,$id){
        $currentQus=Questions::where(['id'=>$id])->first();
        // Update Qus Count 
        $survey=Survey::where(['id'=>$currentQus->survey_id])->first();
        if($request->qus_type!='welcome_page' && $request->qus_type!='thank_you'){
            $survey->qus_count=$survey->qus_count+1;
        }
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
                    $filename=$request->existing_image_uploaded;
                }
                $json=[
                    'welcome_imagesubtitle'=>$request->welcome_imagesubtitle,'welcome_btn'=>$request->welcome_btn,
                    'welcome_imagetitle'=>$request->welcome_imagetitle,
                    'welcome_title'=>$request->welcome_title,
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
                    $filename=$request->existing_image_uploaded_thankyou;
                }
                $json=[
                    'thankyou_title'=>$request->thankyou_title,
                    'thankyou_imagetitle'=>$request->thankyou_imagetitle,
                    'thankyou_image'=>$filename,
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_name'=>$request->thankyou_title,'qus_ans'=>json_encode($json)]);
              break;
            case 'open_qus':
                $json=[
                    'open_qus_choice'=>$request->open_qus_choice,
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
              break;
            case 'single_choice':
                $json=[
                    'choices_list'=>implode(",",$request->choices_list) ,
                    'choices_type'=>'single',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
              break;
            case 'multi_choice':
                $json=[
                    'choices_list'=>implode(",",$request->choices_list) ,
                    'choices_type'=>'mulitple',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
              break;
            case 'likert':
                $json=[
                    'left_label'=>$request->left_label,
                    'middle_label'=>$request->middle_label,
                    'right_label'=>$request->right_label,
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            case 'rankorder':
                $json=[
                    'choices_list'=>implode(",",$request->choices_list) ,
                    'choices_type'=>'rankorder',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            case 'rating':
                $json=[
                    'icon_type'=>$request->icon_type,
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            case 'dropdown':
                $json=[
                    'choices_list'=>implode(",",$request->choices_list) ,
                    'choices_type'=>'dropdown',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            case 'picturechoice':
                $json=[
                    'choices_list'=>$request->choices_list_pic,
                    'choices_type'=>'picturechoice',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            case 'email':
                $updateQus=Questions::where(['id'=>$id])->update(['question_name'=>$request->question_name,'qus_ans'=>'email']);
                break;
            case 'matrix_qus':
                $json=[
                    'matrix_choice'=>implode(",",$request->choices_list_matrix),
                    'matrix_qus'=>implode(",",$request->question_list_matrix),
                    'qus_type'=>'matrix',
                    'choices_type'=>'radio',
                    'question_name'=>$request->question_name
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['question_name'=>$request->question_name,'qus_ans'=>json_encode($json)]);
                break;
            default:
              //code block
          }
          return redirect()->back()->with('success', __('Question Updated Successfully.'));

    }
    public function viewsurvey(Request $request, $id){
        $survey=Survey::with('questions')->where(['builderID'=>$id])->first();
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

        $question1=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->first();
        if($question1){
            $question1=$question1;
        }else{
            $question1=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'thank_you'])->first();
        }
        return view('admin.survey.response', compact('survey','question','question1','questionsset'));
    }
    public function startsurvey(Request $request, $id,$qus){
        $survey=Survey::with('questions')->where(['id'=>$id])->first();
        // Update started Count 
        
        // $started_count=Survey::where(['id'=>$id])->update(['started_count'=>$survey->started_count+1]);
        $question=Questions::where(['id'=>$qus])->first();

        $questionsset=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
       
        $question1=Questions::where('id', '>', $qus)->where('survey_id', $survey->id)->orderBy('id')->first();

        return view('admin.survey.response', compact('survey','question','question1','questionsset'));
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
            echo "no file";
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
            // echo $ori; exit;
            $bg=json_encode(['hex1'=>$hex1,'hex2'=>$hex2,'ori'=>$ori]);

        }
        $bgval=["type"=>$request->bg_type, "color"=>$bg];
        $survey->background=json_encode($bgval);
        $survey->save();
        return redirect()->back()->with('success', __('Survey Background Updated Successfully.'));

    }

    public function skipqus(Request $request){
        $survey_id = $request->survey_id;
        $question_id = $request->question_id;
        $next_qus = $request->next_qus;
        // $user_ans=$request->user_ans;
        $user_ans ='SSLC';
        $skip_ans ='yes';
        $response_user_id =  Auth::guard('admin')->user()->id;
        $surveyres = new SurveyResponse();
        $surveyres->response_user_id=$response_user_id;
        $surveyres->question_id=$request->question_id;
        $surveyres->answer='';
        $surveyres->skip='yes';
        $surveyres->deleted_at=0;
        // $surveyres->save();

        // Check Skip Logic 

        // Check Display Logic 
        $question1=Questions::where('id', '>', $question_id)->where('survey_id', $survey_id)->orderBy('id')->first();

        $display_logic = json_decode($question1->display_logic);
        // if($display_logic!=null){
        //     $display_qus_choice_display=json_decode($display_logic->display_qus_choice_display); 
        //     $logic_type_value_display=json_decode($display_logic->logic_type_value_display); 
        //     $logic_type_value_option_display=json_decode($display_logic->logic_type_value_option_display); 
        //     $display_qus_choice_andor_display=json_decode($display_logic->display_qus_choice_andor_display); 
    
    
        //     echo "<pre>"; print_r($display_qus_choice_display);
        //     echo "<pre>"; print_r($logic_type_value_display);
        //     echo "<pre>"; print_r($logic_type_value_option_display);
        //     echo "<pre>"; print_r($display_qus_choice_andor_display);
            
        //     foreach($display_qus_choice_display as $k=>$v){
        //         $qusresp =  SurveyResponse::where(['question_id'=>$k,'response_user_id'=>$response_user_id])->first();
        //         $qusv =  Question::where(['id'=>$k])->first();
        //         if($qusresp){
        //             $logic_types = ['isSelected','isNotSelected','isAnswered','isNotAnswered','contains','doesNotContain','startsWith','endsWith','equalsString','notEqualTo','lessThanForScale','greaterThanForScale','equalToForScale','notEqualToForScale'];
    
                                   
        //             if($qusresp->skip == 'yes' && ($logic=='isAnswered' || $logic=='isNotAnswered')){
        //                 echo "test";
        //             }
                    
        //         }else{
    
        //         }
               
    
        //         echo "<pre>"; print_r($qusresp);
        //         $logic=$logic_type_value_display[$k];
        //         $logicv=$logic_type_value_option_display[$k];
        //         $cond=$display_qus_choice_andor_display[$k];
        //         if($logic=='isAnswered' || $logic=='isNotAnswered'){
    
        //         }
    
        //         echo $v.'-'.$logic.'-'.$logicv.'-'.$cond .'<br>';
               
        //     }
        // }

        // Check Skip Logic 
        $skip_logic = json_decode($question1->skip_logic);
        if($skip_logic!=null){
            $skip_logic_DB1=json_decode($skip_logic->display_qus_choice_skip); 
            $logic_type_value_skip=json_decode($skip_logic->skiplogic_type_value_skip); 
            $logic_type_value_option_skip=json_decode($skip_logic->logic_type_value_option_skip); 
            $skip_qus_choice_andor_skip=json_decode($skip_logic->display_qus_choice_andor_skip); 
            $jump_type=$skip_logic->jump_type;
            foreach ($skip_logic_DB1 as $k=>$skip){
                $logic=$logic_type_value_skip[$k];
                $logicv=$logic_type_value_option_skip[$k];
                $cond=$skip_qus_choice_andor_skip[$k];
                if(count($skip_logic_DB1) == 1){
                   switch($logic){
                    case 'isSelected':
                        if($user_ans == $logicv)
                            $jump_to = 'yes';
                        break;
                    case 'isNotSelected':
                        if($user_ans == $logicv)
                            $jump_to = 'yes';
                        break;
                    case 'isAnswered':
                        if($user_ans !='')
                            $jump_to = 'yes';
                        break;
                    case 'isNotAnswered':
                        if($skip_ans == 'yes')
                            $jump_to = 'yes';
                        break;
                    case 'contains':
                        break;
                    case 'doesNotContain':
                        break;
                    case 'startsWith':
                        break;
                    case 'endsWith':
                        break;
                    case 'equalsString':
                        break;
                    case 'notEqualTo':
                        break;
                    case 'lessThanForScale':
                        break;
                    case 'greaterThanForScale':
                        break;
                    case 'equalToForScale':
                        break;
                    case 'notEqualToForScale':
                        break;
                   
                   }

                    echo $logic.'-';
                    echo $logicv;
                    echo $cond;

                }else{

                }
            }
            echo $jump_type; 
            // echo "<pre>"; 
            // print_r($skip_logic_DB1);
            // print_r($logic_type_value_skip);
            // print_r($logic_type_value_option_skip);
            // print_r($skip_qus_choice_andor_skip);

        }
       

        exit;


        // return redirect()->to($next_qus);
    }

   
}


