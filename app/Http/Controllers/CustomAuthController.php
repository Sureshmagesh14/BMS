<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;
use Exception;
class CustomAuthController extends Controller
{
    public function index()
    {
        try {
            return view('login_register.login');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
    }
    public function customLogin(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect()->intended('dashboard')
                    ->withSuccess('Signed in');
            }
            return redirect()->route('login.custom')->withSuccess('Login details are not valid');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
    }
    public function registration()
    {
        try {
            return view('login_register.register');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }

    public function customRegistration(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
            $data = $request->all();
            $check = $this->create($data);
            return redirect("dashboard")->withSuccess('You have signed-in');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }
    public function create(array $data)
    {
        try {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }
    public function dashboard()
    {
        try {
            if (Auth::check()) {

                $active_val = DB::table('respondents')
                ->where("active_status_id",1)
                ->count();

                $deactive_val = DB::table('respondents')
                ->where("active_status_id",2)
                ->count();

                $unsub_val = DB::table('respondents')
                ->where("active_status_id",3)
                ->count();

                $pending_val = DB::table('respondents')
                ->where("active_status_id",5)
                ->count();

                $black_val = DB::table('respondents')
                ->where("active_status_id",5)
                ->count();

                return view('admin.dashboard',compact('active_val','deactive_val','unsub_val','black_val','pending_val'));
            }
            return redirect("/")->withSuccess('You are not allowed to access');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
       
    }
    public function signOut()
    {
        try {
            Session::flush();
            Auth::logout();
            return Redirect('/');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }
}