<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use DB;
use Session;
use Exception;
use Hash;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
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

    public function forgot_password(){
        try {
            return view('admin.auth.admin-forgot-password');
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

        if (!Users::where('email', $request->email)->first()) {
            return back()->with('error','Invalid Username or Password');
        }
        
        if (!Users::where('email', $request->email)->where('password', bcrypt($request->password))->first()) {
            $mess= strip_tags("<strong>Incorrect Password.</strong>");
            return back()->with('pass_error',$mess);
        }

       
    }

    public function admin_dashboard(Request $request){
        try {
            try {
                $active_val   = DB::table('respondents')->where("active_status_id",1)->count();
                $deactive_val = DB::table('respondents')->where("active_status_id",2)->count();
                $unsub_val    = DB::table('respondents')->where("active_status_id",3)->count();
                $pending_val  = DB::table('respondents')->where("active_status_id",5)->count();
                $black_val    = DB::table('respondents')->where("active_status_id",5)->count();
                $complete = DB::table('respondents')->where("profile_completion_id",1)->count();
                $incomplete = DB::table('respondents')->where("profile_completion_id",0)->count();
                $tot=$complete+$incomplete;
               
                $act_per= number_format( $active_val/$tot * 100, 2 ) . ' %';
              

                $dec_per=number_format( $deactive_val/$tot * 100, 2 ) . ' %';
            

                $unsub_pre=number_format( $unsub_val/$tot * 100, 2 ) . ' %';
          

                $pen_per=number_format( $pending_val/$tot * 100, 2 ) . ' %';
               

                $bla_per=number_format( $black_val/$tot * 100, 2 ) . ' %';
                

                $comp_per=number_format( $complete/$tot * 100, 2 ) . ' %';
              
                $incomp_per=number_format( $incomplete/$tot * 100, 2 ) . ' %';

                $share_link  = DB::table('users')->select('share_link')->where("id",Auth::guard('admin')->user()->id)->first();
               
              
                return view('admin.dashboard',compact('active_val','deactive_val','unsub_val',
                'black_val','pending_val','complete','incomplete','tot','comp_per','incomp_per','act_per',
                'dec_per','unsub_pre','pen_per','bla_per','share_link'));
                
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

    public function email(Request $request){
        try {
            $data = ['message' => 'This is a test!'];

            Mail::to('smartvijay018@gmail.com')->send(new WelcomeEmail($data));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
