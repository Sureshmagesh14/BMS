<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Respondents;
use App\Models\Respondent_referrals;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
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
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'whatsapp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Respondents::class],
            'date_of_birth' => ['required', 'string', 'max:255'],
            'id_passport' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $ref_code = substr(md5(time()), 0, 8); 
        $ref_code = ('r'.$ref_code);

        $user = Respondents::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'date_of_birth' => $request->date_of_birth,
            'id_passport' => $request->id_passport,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'referral_code' => $ref_code,
        ]);
 
        if (session()->has('refer_id')) {

            $referred_respondent_id=session()->get('refer_id');

            $userInfo = Respondent_referrals::create([
                'respondent_id' => $user->id,
                'referred_respondent_id' => $referred_respondent_id,
            ]);
        }


        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
