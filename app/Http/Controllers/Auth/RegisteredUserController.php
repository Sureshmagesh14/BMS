<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\Respondents;
use App\Models\Respondent_referrals;
use App\Models\RespondentProfile;
use App\Models\Project_respondent;
use App\Providers\RouteServiceProvider;
use DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Session;
use App\Models\Contents;
use Redirect;
use App\Services\SendGridService;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    
    {
        $content=Contents::where('type_id',2)->first();
        return view('auth.register',compact('content'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
            'whatsapp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . Respondents::class],
            'date_of_birth' => ['required', 'string', 'max:255'],
            'password_register' => ['required', Rules\Password::defaults()->min(6)],
        ]);
        $ref_code = substr(md5(time()), 0, 8);

        $ref_code = ('r' . $ref_code);
        $mobile = str_replace(' ', '', $request->mobile);
        if (!str_starts_with($mobile, '27')) {
            $mobile = '27' . ltrim($mobile, '0'); // Remove leading 0 if present
        }

        $whatsapp = str_replace(' ', '', $request->whatsapp);
        if (!str_starts_with($whatsapp, '27')) {
            $whatsapp = '27' . ltrim($whatsapp, '0'); // Remove leading 0 if present
        }
        $verificationToken = Str::random(60);
    
        $user = Respondents::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'date_of_birth' => $request->date_of_birth,
            'id_passport' => $request->id_passport,
            'email' => $request->email,
            'mobile' => $mobile,
            'whatsapp' => $whatsapp,
            'password' => Hash::make($request->password_register),
            'referral_code' => $ref_code,
            'active_status_id' => 6,
            'email_verification_token' => $verificationToken,
        ]);

        $id = DB::getPdo()->lastInsertId();

        $resp_save = array(
            'name'          => $request->name,
            'surname'       => $request->surname,
            'date_of_birth' => $request->date_of_birth,
            'email' => $request->email,
            'mobile' => str_replace(' ', '', $request->mobile),
            'whatsapp' => str_replace(' ', '', $request->whatsapp),
            'updated_at'=>now()
        );

        $basic_data = array(
            'respondent_id' => $id,
            'basic_details' => json_encode($resp_save),
        );

        if(RespondentProfile::where('respondent_id',$id)->doesntExist()){
            RespondentProfile::insert($basic_data);
        }
        //email starts
        
        if ($id != null) {

            $get_email = Respondents::where('id', $id)->first();
            $to_address = $get_email->email;
            $resp_name = $get_email->name;
            $verificationToken = $get_email->email_verification_token;
            $verify_link = route('verify.account', ['token' => $verificationToken]);

            $dynamicData = [
                'first_name' => $resp_name,
                'verify_link' => $verify_link,
            ];

            $subject = 'Welcome! Please Verify Your Account';
            $templateId = 'd-02d0ec6cb9c24367891ad12d0ec575ac';

            $sendgrid = new SendGridService();
            $sendgrid->setFrom();
            $sendgrid->setSubject($subject);
            $sendgrid->setTemplateId($templateId);
            $sendgrid->setDynamicData($dynamicData);
            $sendgrid->setToEmail($to_address, $resp_name);
            $sendgrid->send();

            // Mail::to($to_address)->send(new WelcomeEmail($data));
        }
        //email ends 
        if (session()->has('refer_id')) {

            $referred_respondent_id = session()->get('refer_id');
           

            $userInfo = Respondent_referrals::create([
                'respondent_id' => $user->id,
                'referred_respondent_id' => $referred_respondent_id,
            ]);
            Session::forget('refer_id');
        }
        if (session()->has('u_refer_id')) {

            $referred_respondent_id = session()->get('u_refer_id');
            $get_role = null; // Initialize $get_role to null

            if (!is_null($referred_respondent_id)) {
                $get_role = DB::table('users')
                                ->where('id', $referred_respondent_id)
                                ->first();
            }
            $userInfo = Respondent_referrals::create([
                'respondent_id' => $user->id,
                'user_id' => $referred_respondent_id,
            ]);
            app('App\Http\Controllers\InternalReportController')->call_activity($get_role->role_id,$referred_respondent_id,'created','respondent');
            Session::forget('u_refer_id');
        }
        if (session()->has('u_proj_refer_id')) {

            $referred_respondent_id = session()->get('u_proj_refer_id');
            $project_id = session()->get('u_proj_id');
            $resp_id = $id;
            
            if(Project_respondent::where('project_id', $project_id)->where('respondent_id', $resp_id)->exists()){

            }else{
          
                Project_respondent::insert(['project_id' => $project_id, 'respondent_id' => $resp_id]);                                
            }

            Session::forget('u_proj_refer_id');
            Session::forget('u_proj_id');
        }
        event(new Registered($user));
        return redirect('login')->with('success', __('Success! Your registration was completed successfully. A confirmation email has been sent to verify your account'));

       

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
    }

    public function verifyAccount($token)
    {
        // Find the respondent by the verification token (Assume email_verification_token is being used)
        $respondent = Respondents::where('email_verification_token', $token)->first();

        // Check if respondent exists
        if ($respondent) {
            // Update the active_status_id to 1 (active)
            $respondent->active_status_id = 1;
            $respondent->email_verified_at = now(); // Record the time of email verification
            $respondent->email_verification_token = null; // Clear the verification token after use
            $respondent->save();

            // Optionally, set a session message to indicate success
            Session::flash('verification_success', true);

            // Redirect to login page
            return Redirect::route('login');
        }

        // If respondent not found or token is invalid
        Session::flash('verification_success', false);

        return Redirect::route('login');
    }
}


