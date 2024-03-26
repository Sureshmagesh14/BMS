<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Yajra\DataTables\DataTables;
use App\Models\Respondents;
use App\Models\Contents;
use App\Models\Groups;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Facades\Hash;

class WelcomeController extends Controller
{   
    public function home(Request $request)
    {   
        try {
            if($request->r!=''){
                $referral_code = $request->r;
            
                $id =Session::get('resp_id');
                $data = Respondents::find($id);
    
                $data =Respondents::where('referral_code', $referral_code)->first();
                Session::put('refer_id',  $data->id);
                
            }else{
                $data='';
            }

            return view('welcome', compact('data'));
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

    public function user_update(Request $request)
    {
        try {

            $up_data = array(
                'name' => $request->name,
                'surname' => $request->surname,
                'date_of_birth' => $request->date_of_birth,
                'id_passport' => $request->id_passport,
                'mobile' => $request->mobile,
                'whatsapp' => $request->whatsapp,
            );

            Respondents::where('id', Session::get('resp_id'))
                        ->update($up_data);
             
            return response()->json([
                'status' => 200,
                'last_insert_id' => $request->name,
                'message' => 'Updated Successfully.',
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
            
            $id =Session::get('resp_id');
            $data = Respondents::find($id);
            

            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
                return view('user.user-dashboard', compact('data'));
            //}
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_share(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
            $data = Respondents::find($resp_id);
            $ref_code = $data->referral_code;
            
            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
                return view('user.user-share', compact('data','ref_code'));
            //}
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_rewards(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
                return view('user.user-rewards');
            //}
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_surveys(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
                return view('user.user-surveys');
           // }
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function user_editprofile(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
          
            $data = Respondents::find($resp_id);
            
            $profil = Groups::where('deleted_at', NULL)->orderBy('sort_order', 'ASC')->get();

            return view('user.user-editprofile', compact('data','profil'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_viewprofile(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
          
            $data = Respondents::find($resp_id);
            return view('user.user-viewprofile', compact('data'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function user_profile(Request $request){
        try {
            
            $resp_id =Session::get('resp_id');
            $resp_name =Session::get('resp_name');
            
            // if($request->user()->profile_completion_id==0){
            //     return view('user.update-profile');
            // }else{
                return view('user.user-profile');
            //}
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}