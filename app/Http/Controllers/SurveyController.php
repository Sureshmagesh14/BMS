<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Folder;
use App\Models\Survey;
use App\Models\Questions;
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
        $user = \Auth::user();
        $users=User::where('id', '!=' , $user->id)->pluck('name', 'id')->toArray();

        return view('admin.survey.folder.create', compact('users'));
    }

    public function storeFolder(Request $request){
        $user = \Auth::user();
        $folder=new Folder();
        $folder->folder_name=$request->folder_name;
        $folder->folder_type=$request->folder_type;
        $folder->survery_count=0;
        $folder->created_by=$user->id;
        if($request->folder_type=='private'){
            $folder->user_ids=implode(',', $request->privateusers);
        }
        $folder->save();
        return redirect()->back()->with('success', __('Folder Created Successfully.'));

    }

    public function editFolder($id){

        $folder=Folder::where(['id'=>$id])->first();
        $user = \Auth::user();
        $users=User::where('id', '!=' , $user->id)->pluck('name', 'id')->toArray();
        return view('admin.survey.folder.edit', compact('folder','users'));


    }

    public function updateFolder(Request $request,$id){
        $user = \Auth::user();
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
        $surveyList=Survey::orderBy("id", "desc")->get();
       
        return view('admin.survey.survey.index', compact('surveyList'));

    }

    public function getSurveyList(){
        $surveyList=Survey::orderBy("id", "desc")->get();

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
        $user = \Auth::user();
        $folders=Folder::pluck('folder_name', 'id')->toArray();
        return view('admin.survey.survey.create', compact('folders'));
    }

    public function storeSurvey(Request $request){
        $uuid = Str::uuid()->toString();
        $user = \Auth::user();
        $survey=new Survey();
        $survey->folder_id=$request->folder_id;
        $survey->title=$request->title;
        $survey->created_by=$user->id;
        $survey->builderID=$uuid;
        $survey->save();
        return redirect()->back()->with('success', __('Survey Created Successfully.'));

    }

    public function editSurvey($id){

        $survey=Survey::where(['id'=>$id])->first();
        $user = \Auth::user();
        $folders=Folder::pluck('folder_name', 'id')->toArray();
        return view('admin.survey.survey.edit', compact('survey','folders'));


    }
    public function updateSurvey(Request $request,$id){
        $user = \Auth::user();
        $survey=Survey::where(['id'=>$id])->first();
        $survey->title=$request->title;
        $survey->folder_id=$request->folder_id;
        $survey->save();
        return redirect()->back()->with('success', __('Survey Updated Successfully.'));

    }

    public function deleteSurvey(Request $request,$id){
        $survey=Survey::where(['id'=>$id])->first();
        if($survey->qus_count==0){
            $survey->delete();
            return json_encode(['success'=>'Survey deleted Successfully',"error"=>""]);
        }else{
            return json_encode(['error'=>"Survey mapped with Questions. Can't able to delete it.","success"=>""]);
        }
        
    }
    public function templateList(Request $request,$id){
        $survey=Survey::where(['id'=>$id])->first();
        $folders=Folder::withCount('surveycount')->get();
        return view('admin.survey.template.index', compact('survey','folders'));
    }
    public function builder(Request $request,$survey){
        // Generatre builder ID
        $survey=Survey::where(['builderID'=>$survey])->first();
        $questions=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
        $welcomQus=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'welcome_page'])->first();
        $thankQus=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'thank_you'])->first();
        $currentQus=Questions::where(['survey_id'=>$survey->id])->first();
        return view('admin.survey.builder.index',compact('survey','questions','welcomQus','thankQus','currentQus'));

    }
    public function questiontype(Request $request,$survey){
        $questionTypes=['welcome_page'=>'Welcome Page','single_choice'=>'Single Choice','mutli_choice'=>'Multi Choice','open_qus'=>'Open Questions','likert'=>'Likert scale','ranking'=>'Ranking','dropdown'=>'Dropdown','picturechoice'=>'Picture Choice','email'=>'Email','matrix_qus'=>'Matrix Question','thank_you'=>'Thank You Page',];
        return view('admin.survey.builder.create', compact('questionTypes','survey'));

    }
   public function questiontypesurvey(Request $request,$survey,$qustype){
    // Create New Question
    // Create New Qus 
    $user = \Auth::user();
    $newqus=new Questions();
    $newqus->survey_id=$survey;
    $newqus->qus_type=$qustype;
    $newqus->created_by=$user->id;
    $newqus->save();
    $questions=Questions::where(['survey_id'=>$survey])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
    $survey=Survey::where(['id'=>$survey])->first();
    return redirect()->back()->with('success', __('Question Created Successfully.'));


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
        $user = \Auth::user();
        
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
    public function questionList(Request $request,$id){
        // Generatre builder ID
        $currentQus=Questions::where(['id'=>$id])->first();
        $survey=Survey::where(['id'=>$currentQus->survey_id])->first();
        $questions=Questions::where(['survey_id'=>$survey->id])->whereNotIn('qus_type',['welcome_page','thank_you'])->get();
        $welcomQus=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'welcome_page'])->first();
        $thankQus=Questions::where(['survey_id'=>$survey->id,'qus_type'=>'thank_you'])->first();
        return view('admin.survey.builder.index',compact('survey','questions','welcomQus','thankQus','currentQus'));
    }
    public function updateQus(Request $request,$id){
        $currentQus=Questions::where(['id'=>$id])->first();

        echo $id;
        echo $request->qus_type;
        switch ($request->qus_type) {
            case 'welcome_page':
                $json=[
                    'welcome_imagesubtitle'=>$request->welcome_imagesubtitle,'welcome_btn'=>$request->welcome_btn,
                    'welcome_imagetitle'=>$request->welcome_imagetitle,
                    'welcome_title'=>$request->welcome_title,
                    'welcome_image'=>$request->welcome_image
                ];
                $updateQus=Questions::where(['id'=>$id])->update(['qus_ans'=>json_encode($json)]);

              break;
            case 'label2':
              //code block;
              break;
            case 'label3':
              //code block
              break;
            default:
              //code block
          }
          return redirect()->back()->with('success', __('Question Updated Successfully.'));

    }

   
}