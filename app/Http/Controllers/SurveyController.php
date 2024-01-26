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
                <a href="#" class="btn btn-danger waves-effect waves-light" data-url="'.$deletedLink.'" data-ajax-popup="true" data-bs-toggle="tooltip" title="Delete Folder" data-title="Delete Folder">Delete</a></div>';
            })
            ->rawColumns(['id','folder_name','folder_type','survery_count','created_at','actions'])
            ->make(true);

        return response()->json(['data' => $foldersList], 200);
    }
    public function editFolder($id){

        $folder=Folder::where(['id'=>$id])->first();
        return view('admin.survey.create', compact('folder'));


    }

    public function createFolder(Request $request){
        return view('admin.survey.create');
    }
   
}