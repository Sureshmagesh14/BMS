<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\Folder;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\Auth;
class SurveyController extends Controller
{
    public function folder()
    {
        $foldersList=Folder::get();
       
        return view('admin.survey.index', compact('foldersList'));

    }
    public function getFolderList(){
        $foldersList=Folder::get();

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

        return view('admin.survey.create', compact('users'));
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
        return view('admin.survey.edit', compact('folder','users'));


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
   
}