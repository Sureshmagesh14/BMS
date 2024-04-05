<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Folder;
use App\Models\Survey;
use App\Models\Questions;
use App\Models\Users;
use App\Models\Respondents;
use App\Models\SurveyTemplate;
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
        $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','photo_capture'=>'Photo Capture','email'=>'Email','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
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
            $questionTypes=['single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','photo_capture'=>'Photo Capture','email'=>'Email','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page'];
        }else{
            $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','photo_capture'=>'Photo Capture','email'=>'Email','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
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
        $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','multi_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','rankorder'=>'Rank Order','rating'=>'Rating','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','photo_capture'=>'Photo Capture','email'=>'Email','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
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
                    'likert_range'=>$request->likert_range,
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
            case 'photo_capture':
                $json=[
                    'choices_type'=>'photo_capture',
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
        if (Auth::check()) {
            $response_user_id =  Auth::user()->id;
            $checkresponse = SurveyResponse::where(['response_user_id'=>$response_user_id ,'survey_id'=>$survey->id,'answer'=>'thankyou_submitted'])->first();
            if($checkresponse){
                return view('admin.survey.responseerror', compact('survey'));
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
    
                $question1=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->first();
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
            return view('admin.survey.autherror', compact('survey'));

        }
      
        
    }
    public function startsurvey(Request $request, $id,$qus){
        // Check User already taken the survey 
        $response_user_id =  Auth::user()->id;
       
        $survey=Survey::with('questions')->where(['id'=>$id])->first();
        $checkresponse = SurveyResponse::where(['response_user_id'=>$response_user_id ,'survey_id'=>$survey->id,'answer'=>'thankyou_submitted'])->first();
      
        if($checkresponse){
            return view('admin.survey.responseerror', compact('survey'));

        }else{
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
                return view('admin.survey.thankyoudefault', compact('survey'));
            }else{
                return view('admin.survey.response', compact('survey','question','question1','questionsset'));
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
            case 'photo_capture':
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

        $qus_check=Questions::where('id', '=', $question_id)->where('survey_id', $survey_id)->orderBy('id')->first();
        // if($qus_check->qus_type == 'photo_capture'){
        //     // echo $request->user_ans;
        //     // exit;
        //     $upload_dir = 'uploads/survey/photo_capture'; 
        //     $img = $request->user_ans;
        //     $img = str_replace('data:image/png;base64,', '', $img);
        //     $img = str_replace(' ', '+', $img);
        //     $data = base64_decode($img);
        //     $imgname=date('Ymd_His', time()).'-user'.$response_user_id;
        //     $file = $upload_dir.$imgname.'.png';
        //     move_uploaded_file($temp_name,$_SERVER['DOCUMENT_ROOT']."/"."gripOffers/Store_Brand/store_admin/images/".$image);

        //     echo $file;
        //     $success = file_put_contents($file, $data);
        //     echo $success;
        //     exit;
        //     $user_ans=$request->user_ans;
        // }else{
        //     $user_ans=$request->user_ans;
        // }
        $next_qus = $request->next_qus;
        $user_ans=$request->user_ans;
        $skip_ans =$request->skip_ans;
        $surveyres = new SurveyResponse();
        $surveyres->survey_id = $survey_id;
        $surveyres->response_user_id=$response_user_id;
        $surveyres->question_id=$request->question_id;
        $surveyres->answer=$request->user_ans;
        $surveyres->skip=$skip_ans;
        $surveyres->deleted_at=0;
        $surveyres->save();
        if($qus_check){
            $next_qus_loop = '';
            $skip_logic = json_decode($qus_check->skip_logic);
            if($skip_logic!=null){
                if($skip_logic->jump_type!=''){
                    $skip_logic_DB1=json_decode($skip_logic->display_qus_choice_skip); 
                    $logic_type_value_skip=json_decode($skip_logic->skiplogic_type_value_skip); 
                    $logic_type_value_option_skip=json_decode($skip_logic->logic_type_value_option_skip); 
                    $skip_qus_choice_andor_skip=json_decode($skip_logic->display_qus_choice_andor_skip); 
                    $jump_type=$skip_logic->jump_type;
                    $jump_to=0;
                    $qusvalue_skip = json_decode($qus_check->qus_ans); 
                    $push_jump = [];
                    foreach ($skip_logic_DB1 as $k=>$skip){
                        $logic=$logic_type_value_skip[$k];
                        $logicv=$logic_type_value_option_skip[$k];
                        $cond=$skip_qus_choice_andor_skip[$k];
                        $resp_logic_type_skip_value=[];
                        switch ($qus_check->qus_type) {
                            case 'single_choice':
                                $resp_logic_type_skip_value=explode(",",$qusvalue_skip->choices_list);
                                break;
                            case 'multi_choice':
                                $user_ans = explode(",",$user_ans);
                                $resp_logic_type_skip_value=explode(",",$qusvalue_skip->choices_list);
                                break;
                            case 'dropdown':
                                $resp_logic_type_skip_value=explode(",",$qusvalue_skip->choices_list);
                                break;
                            case 'picturechoice':
                                $resp_logic_type_skip_value=json_decode($qusvalue_skip->choices_list);
                                break;
                            case 'likert':
                                $resp_logic_type_skip_value=["1"=>1,"2"=>3,"3"=>3,"4"=>4,"5"=>5,"6"=>6,"7"=>7,"8"=>8,"9"=>9];
                                break;
                            case 'rating':
                                $resp_logic_type_skip_value=["1"=>1,"2"=>3,"3"=>3,"4"=>4,"5"=>5];
                                break;
                            case 'matrix_qus':
                                $resp_logic_type_skip_value=explode(",",$qusvalue_skip->matrix_choice);
                                break;
                        }
                        if(count($resp_logic_type_skip_value)>0){
                            $ans = $resp_logic_type_skip_value[$logicv];
                        }else{
                            $ans = $logicv;
                        }
                        $qus_type="";
                        $get_ans_usr = SurveyResponse::with('questions')->where(['question_id' => $skip ])->first();
                        if($get_ans_usr){
                            $qus_type = $get_ans_usr->questions[0]->qus_type;
                            $user_ans =  $get_ans_usr->answer;
                            $skip_ans =  $get_ans_usr->skip;
                        }
                        
                        switch($logic){
                            case 'isSelected':
                                if($qus_type == 'multi_choice'){
                                    $user_ans =  explode(",",$user_ans);
                                    if (in_array($ans, $user_ans)) { 
                                        $jump_to++;
                                        array_push($push_jump,"and");
                                    }else{
                                        $jump_to--;
                                        array_push($push_jump,"or");
                                    }
                                }else{
                                    if ($user_ans == $ans) { 
                                        $jump_to++;
                                        array_push($push_jump,"and");
                                    }else{
                                        $jump_to--;
                                        array_push($push_jump,"or");
                                    }
                                }
                                break;
                            case 'isNotSelected':
                                if($qus_type == 'multi_choice'){
                                    $user_ans =  explode(",",$user_ans);
                                    if (!in_array($ans, $user_ans)) { 
                                        $jump_to++;
                                        array_push($push_jump,"and");
                                    }else{
                                        $jump_to--;
                                        array_push($push_jump,"or");
                                    }
                                }else{
                                    if ($user_ans != $ans) { 
                                        $jump_to++;
                                        array_push($push_jump,"and");
                                    }else{
                                        $jump_to--;
                                        array_push($push_jump,"or");
                                    }
                                }
                                break;
                            case 'isAnswered':
                                if($user_ans !=''){
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'isNotAnswered':
                                if($skip_ans == 'yes'){
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'contains':
                                if (str_contains($user_ans, $ans)) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'doesNotContain':
                                if (!str_contains($user_ans, $ans)) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'startsWith':
                                if (str_starts_with($user_ans, $ans)) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'endsWith':
                                if (str_ends_with($user_ans, $ans)) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'equalsString':
                                if ($user_ans== $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'notEqualTo':
                                if ($user_ans != $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'lessThanForScale':
                                if ($user_ans < $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'greaterThanForScale':
                                if ($user_ans > $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'equalToForScale':
                                if ($user_ans == $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'notEqualToForScale':
                                if ($user_ans != $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                        }
                    }
                    if(count($skip_qus_choice_andor_skip)>0){
                        if(count($push_jump)>0)
                        {
                            $skip_qus_choice_andor_skip[0]=$push_jump[0];
                        }else{
                            $skip_qus_choice_andor_skip[0]='and';
                        }
                    }
                    $arr1 =serialize($skip_qus_choice_andor_skip);
                    $arr2 =serialize($push_jump);
                    if($arr1 == $arr2){
                        if($skip_ans == 'yes'){
                            return redirect()->route('survey.startsurvey',[$survey_id,$jump_type]);
                        }else{
                            // Check next qus display settings 
                            $next_qus_loop ='yes';
                           
                        }
                    }else{
                        // Check next qus display settings 
                        $next_qus_loop ='yes';
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
            $surveyController = new SurveyController;
           return $surveyController->displaynextQus($question_id,$survey_id);
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
                $surveyres->save();
                return redirect()->route('survey.endsurvey',[$survey_id,$next_qus->id]);
            }else{
                return redirect()->route('survey.endsurvey',[$survey_id,0]);
            }
           
        }
    }

   public static  function displaynextQus($question_id,$survey_id){
        $response_user_id =  Auth::user()->id;
        $next_qus=Questions::where('id', '>', $question_id)->where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['welcome_page','thank_you'])->first();
        if($next_qus){
            $display_logic = json_decode($next_qus->display_logic);
            if($display_logic!=null){
                $display_qus_choice_display=json_decode($display_logic->display_qus_choice_display); 
                $logic_type_value_display=json_decode($display_logic->logic_type_value_display); 
                $logic_type_value_option_display=json_decode($display_logic->logic_type_value_option_display); 
                $display_qus_choice_andor_display=json_decode($display_logic->display_qus_choice_andor_display); 
                $jump_to=0;
                $push_jump = [];

                if(count($display_qus_choice_display)>0 && count($logic_type_value_display)>0){
                    foreach ($display_qus_choice_display as $k=>$display){
                        $logic=$logic_type_value_display[$k];
                        $logicv=$logic_type_value_option_display[$k];
                        $cond=$display_qus_choice_andor_display[$k];
                        $resp_logic_type_display_value=[];
                        $qusID=explode("_",$display);
                        $qus_typeData = Questions::where(['id'=>$qusID[0]])->first();
                        $qusvalue_display = json_decode($qus_typeData->qus_ans); 
                        switch ($qus_typeData->qus_type) {
                            case 'single_choice':
                                $resp_logic_type_display_value=explode(",",$qusvalue_display->choices_list);
                                break;
                            case 'multi_choice':
                                $resp_logic_type_display_value=explode(",",$qusvalue_display->choices_list);
                                break;
                            case 'dropdown':
                                $resp_logic_type_display_value=explode(",",$qusvalue_display->choices_list);
                                break;
                            case 'picturechoice':
                                $resp_logic_type_display_value=json_decode($qusvalue_display->choices_list);
                                break;
                            case 'likert':
                                $resp_logic_type_display_value=["1"=>1,"2"=>3,"3"=>3,"4"=>4,"5"=>5,"6"=>6,"7"=>7,"8"=>8,"9"=>9];
                                break;
                            case 'rating':
                                $resp_logic_type_display_value=["1"=>1,"2"=>3,"3"=>3,"4"=>4,"5"=>5];
                                break;
                            case 'matrix_qus':
                                $resp_logic_type_display_value=explode(",",$qusvalue_display->matrix_choice);
                                break;
                        }
                        if($logicv!=''){
                            if(count($resp_logic_type_display_value)>0){
                                if(isset($resp_logic_type_display_value[$logicv])){
                                    $ans = $resp_logic_type_display_value[$logicv];
                                }else{
                                    $ans = $logicv;
                                }
                            }else{
                                $ans = $logicv;
                            }
                        }
                        $get_ans_usr = SurveyResponse::with('questions')->where(['question_id' => $qusID[0] ])->first();
                        $user_answered = '';
                        $user_skipped = '';
                        $qus_type = "";
                        if($get_ans_usr){
                            $qus_type = $get_ans_usr->questions[0]->qus_type;
                            $user_answered =  $get_ans_usr->answer;
                            $user_skipped =  $get_ans_usr->skip;
                        }
                        switch($logic){
                            case 'isSelected':
                                if($qus_type == 'matrix_qus'){
                                    $user_answered=json_decode($user_answered);
                                    if($user_answered[$qusID[1]]->key == $qusID[1]){
                                        if($ans == $user_answered[$qusID[1]]->ans){
                                            $jump_to++;
                                                array_push($push_jump,"and");
                                        }else{
                                            $jump_to--;
                                            array_push($push_jump,"or");
                                        }
                                    }
                                 
                                }
                                else if($qus_type == 'multi_choice'){
                                    $user_answered =  explode(",",$user_answered);
                                    if (in_array($ans, $user_answered)) { 
                                        $jump_to++;
                                        array_push($push_jump,"and");
                                    }else{
                                        $jump_to--;
                                        array_push($push_jump,"or");
                                    }
                                }else if($qus_type != 'matrix_qus' && $qus_type != 'multi_choice'){
                                    if ($user_answered == $ans) { 
                                        $jump_to++;
                                        array_push($push_jump,"and");
                                    }else{
                                        $jump_to--;
                                        array_push($push_jump,"or");
                                    }
                                }
                                break;
                            case 'isNotSelected':
                                if($qus_type == 'matrix_qus'){
                                    $user_answered=json_decode($user_answered);
                                    if($user_answered[$qusID[1]]->key == $qusID[1]){
                                        if($ans != $user_answered[$qusID[1]]->ans){
                                            $jump_to++;
                                            array_push($push_jump,"and");
                                        }else{
                                            $jump_to--;
                                            array_push($push_jump,"or");
                                        }
                                    }
                                }
                                else if($qus_type == 'multi_choice'){
                                    $user_answered =  explode(",",$user_answered);
                                    if (!in_array($ans, $user_answered)) { 
                                        $jump_to++;
                                        array_push($push_jump,"and");
                                    }else{
                                        $jump_to--;
                                        array_push($push_jump,"or");
                                    }
                                }else if($qus_type != 'matrix_qus' && $qus_type != 'multi_choice'){
                                    if ($user_answered != $ans) { 
                                        $jump_to++;
                                        array_push($push_jump,"and");
                                    }else{
                                        $jump_to--;
                                        array_push($push_jump,"or");
                                    }
                                }
                                break;
                            case 'isAnswered':
                                if($user_answered !=''){
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'isNotAnswered':
                                if($user_skipped == 'yes'){
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'contains':
                                if (str_contains($user_answered, $ans)) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'doesNotContain':
                                if (!str_contains($user_answered, $ans)) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'startsWith':
                                if (str_starts_with($user_answered, $ans)) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'endsWith':
                                if (str_ends_with($user_answered, $ans)) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'equalsString':
                                if ($user_answered== $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'notEqualTo':
                                if ($user_answered != $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'lessThanForScale':
                                $ans = (int)$ans;
                                $user_answered = (int)$user_answered;
                                if ($user_answered < $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'greaterThanForScale':
                                $ans = (int)$ans;
                                $user_answered = (int)$user_answered;
                                if ($user_answered > $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                               
                                break;
                            case 'equalToForScale':
                                $ans = (int)$ans;
                                $user_answered = (int)$user_answered;
                                if ($user_answered == $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                            case 'notEqualToForScale':
                                $ans = (int)$ans;
                                $user_answered = (int)$user_answered;
                                if ($user_answered != $ans) { 
                                    $jump_to++;
                                    array_push($push_jump,"and");
                                }else{
                                    $jump_to--;
                                    array_push($push_jump,"or");
                                }
                                break;
                        }
                    }
                    if(count($display_qus_choice_andor_display)>0){
                        if(count($push_jump)>0)
                        {
                            $display_qus_choice_andor_display[0]=$push_jump[0];
                        }else{
                            $display_qus_choice_andor_display[0]='and';
                        }
                    }
                    // Update array based on and
                    foreach($display_qus_choice_andor_display as $k1=>$c1){
                        if($c1 == $push_jump[$k1]){
                        }else if ($c1 == 'or' && $push_jump[$k1] =='and'){
                            $push_jump[$k1]='or';
                        }else{
                            $loopagain = 1;
                        }
                    } 
                    // echo "<pre>"; print_r($display_qus_choice_andor_display);
                    // echo "<pre>"; print_r($push_jump);
                    $arr1 =serialize($display_qus_choice_andor_display);
                    $arr2 =serialize($push_jump);
                    // exit;
                    if($arr1 == $arr2){
                        return redirect()->route('survey.startsurvey',[$survey_id,$next_qus->id]);
                    }else{
                        $loopagain = 1;
                        $surveyController = new SurveyController;
                        $next_question=Questions::where('id', '>', $next_qus->id)->where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['welcome_page','thank_you'])->first();
                        if($next_question){
                            $surveyController->displaynextQus($next_question->id,$survey_id);
                        }else{
                            $next_question=Questions::where(['survey_id'=>$survey_id,'qus_type'=>'thank_you'])->first();
                            if($next_question){
                                $surveyres = new SurveyResponse();
                                $surveyres->survey_id = $survey_id;
                                $surveyres->response_user_id = $response_user_id;
                                $surveyres->question_id = $next_question->id;
                                $surveyres->answer = 'thankyou_submitted';
                                $surveyres->skip = '';
                                $surveyres->deleted_at = 0;
                                $surveyres->save();
                                return redirect()->route('survey.endsurvey',[$survey_id,$next_question->id]);
                            }else{
                                
                                    return redirect()->route('survey.endsurvey',[$survey_id,0]);
                                
                            }
                            
                        }

                    }
                }else{
                    return redirect()->route('survey.startsurvey',[$survey_id,$next_qus->id]);
                }
               
            }else{
                // if no display logic avail
                return redirect()->route('survey.startsurvey',[$survey_id,$next_qus->id]);
            }
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
                $surveyres->save();
                return redirect()->route('survey.endsurvey',[$survey_id,$next_qus->id]);
            }else{
                return redirect()->route('survey.endsurvey',[$survey_id,0]);
            }
         
        }
   }
   public function responses(Request $request,$survey_id)
    {
        try {
            $survey = Survey::with('folder')->where(['id'=>$survey_id])->first();
            $question=Questions::where(['survey_id'=>$survey_id])->whereNotIn('qus_type',['welcome_page','thank_you','matrix_qus'])->get();
            $matrix_qus=Questions::where(['qus_type'=>'matrix_qus','survey_id'=>$survey_id])->get();

            $responses = SurveyResponse::where(['survey_id'=>$survey_id])->get();
            $cols = [ ["data"=>"#","name"=>"#","orderable"=> false,"searchable"=> false], ["data"=>"name","name"=>"Name","orderable"=> true,"searchable"=> true],["data"=>"responseinfo","name"=>"Response Info","orderable"=> true,"searchable"=> true]];
            
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
                        $respone = SurveyResponse::where(['survey_id'=>$survey_id,'question_id'=>$qus->id,'response_user_id'=>$userID])->first();
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
                            $output = json_decode($output);
                            foreach($output as $op){
                                $tempresult = [$op->qus =>$op->ans];
                                $result[$op->qus]=$op->ans; 
                            }
                        }else if($qus->qus_type == 'rankorder'){
                            $output = json_decode($output,true);
                            $ordering = [];
                            foreach($output as $op){
                                array_push($ordering,$op['id']);
                            }
                            $tempresult = [$qus->question_name =>implode(',',$ordering)];
                            $result[$qus->question_name]=implode(',',$ordering);
                        }else if($qus->qus_type == 'photo_capture'){
                            $img = "<a target='_blank' href='$output'><img class='photo_capture' src='$output'/></a>";
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
        $survey->title = $request->title;
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
        $survey->save();
        return redirect()->back()->with('success', __('Template Created Successfully.'));

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

                    $result =['title'=>$template->title,'sub_title'=>$template->sub_title,'description'=>$template->description,'button_label'=>$template->button_label,'image'=>$img];
                    array_push($finalResult,$result);


                }
                return Datatables::of($finalResult)->escapeColumns([])->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}


