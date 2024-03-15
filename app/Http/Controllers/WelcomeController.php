<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Yajra\DataTables\DataTables;
use App\Models\Respondents;
use App\Models\Contents;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Facades\Hash;

class WelcomeController extends Controller
{   
    public function home()
    {   
        try {
            return redirect()->route('home');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function terms()
    {   
        try {
            $id=1;
            $data = Contents::find($id);
            return view('user.user-terms', compact('data'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
     /**
     * Store a newly created resource in storage.
     */
    public function user_create(Request $request)
    {
        try {
            $respondents = new Respondents;
            $respondents->name = $request->input('name');
            $respondents->surname = $request->input('surname');
            $respondents->date_of_birth = $request->input('date_of_birth');
            $respondents->id_passport = $request->input('id_passport');
            $respondents->mobile = $request->input('mobile');
            $respondents->whatsapp = $request->input('whatsapp');
            $respondents->email = $request->input('email');
            $respondents->password = Hash::make($request->input('password'));
            $respondents->save();
            $respondents->id;
            return response()->json([
                'status' => 200,
                'last_insert_id' => $respondents->id,
                'message' => 'Registered Successfully.',
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_dashboard(Request $request){
        try {
            Session::put('resp_id',  $request->user()->id);
            Session::put('resp_name', $request->user()->name);

            if($request->user()->profile_completion_id==0){
                return view('user.update-profile');
            }else{
                return view('user.user-dashboard');
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_share(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
            if($request->user()->profile_completion_id==0){
                return view('user.update-profile');
            }else{
                return view('user.user-share');
            }
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_rewards(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
            if($request->user()->profile_completion_id==0){
                return view('user.update-profile');
            }else{
                return view('user.user-rewards');
            }
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_surveys(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
            if($request->user()->profile_completion_id==0){
                return view('user.update-profile');
            }else{
                return view('user.user-surveys');
            }
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_viewprofile(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
            return view('user.user-viewprofile');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_profile(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
            if($request->user()->profile_completion_id==0){
                return view('user.update-profile');
            }else{
                return view('user.user-profile');
            }
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}