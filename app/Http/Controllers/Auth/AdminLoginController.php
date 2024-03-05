<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use Session;

class AdminLoginController extends Controller
{

    protected $redirectTo = '/admin/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        //$this->middleware('guest:admin')->except('logout');
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function showLoginForm(){
        try {
            return view('admin.auth.login');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (\Auth::guard('admin')->attempt($request->only(['email','password']), $request->get('remember'))){
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error','Invalid Email Or Password');
    }

    public function admin_dashboard(Request $request){
        try {
            try {
                $active_val   = DB::table('respondents')->where("active_status_id",1)->count();
                $deactive_val = DB::table('respondents')->where("active_status_id",2)->count();
                $unsub_val    = DB::table('respondents')->where("active_status_id",3)->count();
                $pending_val  = DB::table('respondents')->where("active_status_id",5)->count();
                $black_val    = DB::table('respondents')->where("active_status_id",5)->count();

                return view('admin.dashboard',compact('active_val','deactive_val','unsub_val','black_val','pending_val'));
                
                return redirect("/")->withSuccess('You are not allowed to access');
            }
            catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function signOut(){
        try {
            Session::flush();
            Auth::guard('admin')->logout();
            return Redirect()->route('admin.showlogin');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
