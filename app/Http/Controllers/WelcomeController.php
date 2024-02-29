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
            return view('front.home');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function userlogin()
    {   
        try {
            return view('front.user-login');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function userregister()
    {   
        try {
            return view('front.user-register');
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
            return view('front.user-terms', compact('data'));
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

    public function userdashboard()
    {   
        try {
            return view('front.user-dashboard');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}