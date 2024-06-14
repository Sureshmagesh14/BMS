<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Models\UserEvents;
use DB;
use Session;
use Exception;
use Hash;
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

            if(isset($request->remember) && !empty($request->remember)){
                setcookie("email",$request->email,time()+3600);
                setcookie("password",$request->password,time()+3600);
            }
            else{
                setcookie("email","");
                setcookie("password","");
            }

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
               
                
                $from = date("2023-m-01");
                $to = date("2023-12-d");
                
                $all_datas = DB::select("select u.id,u.name,u.surname, (select count(*) from user_events e where e.user_id = u.id AND e.action='created' AND e.type='respondent' ) as createCount, (select count(*) from user_events e where e.user_id = u.id AND e.action='updated' AND e.type='respondent' ) as updateCount, (select count(*) from user_events e where e.user_id = u.id AND e.action='deactivated' AND e.type='respondent' ) as deactCount from users u;");
                
                // $all_datas = DUsers::select('users.id','users.name', 'users.surname', 'user_events.*')
                // ->join('user_events', 'user_events.user_id', 'users.id')
                // ->orderby("user_events.id", "desc")
                // ->where('type', '=', 'respondent');
                // if($from != null && $to != null){
                //     $all_datas = $all_datas->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                // }
                // $all_datas = $all_datas->groupBy('user_events.user_id');
                // $all_datas = $all_datas->get();

                // $total_created = Users::select('users.name', 'users.surname', 'user_events.*')
                //     ->join('user_events', 'user_events.user_id', 'users.id')
                //     ->orderby("user_events.id", "desc")
                //     ->where("user_events.action", "created")
                //     ->where('type', '=', 'respondent');

                // if($from != null && $to != null){
                //     $total_created = $total_created->whereDate('user_events.created_at', '>=', $from)->whereDate('user_events.created_at', '<=', $to);
                // }
                //$total_created = $total_created->groupBy('user_events.user_id');
                //$total_created = $total_created->get()->count();
                
                $dashboard_data = array();
                foreach ($all_datas as $all_data) {

                    $newdata =  array (
                        'id' => $all_data->id,
                        'name' => $all_data->name . " " . $all_data->surname,
                        'createCount' => $all_data->createCount,
                        'updateCount' => $all_data->updateCount,
                        'deactCount' => $all_data->deactCount,
                    );

                    array_push($dashboard_data, $newdata);
                }

                //dd($dashboard_data);

                return view('admin.dashboard',compact('active_val','deactive_val','unsub_val','black_val','pending_val','complete','incomplete','tot','comp_per','incomp_per','act_per','dec_per','unsub_pre','pen_per','bla_per','share_link','dashboard_data'));
                
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
