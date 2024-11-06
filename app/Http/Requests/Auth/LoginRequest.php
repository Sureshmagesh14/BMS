<?php

namespace App\Http\Requests\Auth;

use App\Models\Respondents;
use App\Models\Project_respondent;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Session;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $credentials = $this->only('email', 'password');
    
        // Check if the email or mobile is deactivated
        $respondent = Respondents::where('email', $credentials['email'])
            ->orWhere('mobile', $credentials['email'])
            ->first();

        if ($respondent) {



            if (session()->has('u_proj_refer_id')) {

                $referred_respondent_id = session()->get('u_proj_refer_id');
                $project_id = session()->get('u_proj_id');
                $resp_id = $respondent->id;
                
                if(Project_respondent::where('project_id', $project_id)->where('respondent_id', $resp_id)->exists()){
    
                }else{
              
                    Project_respondent::insert(['project_id' => $project_id, 'respondent_id' => $resp_id]);                                
                }
    
                Session::forget('u_proj_refer_id');
                Session::forget('u_proj_id');
            }

            // Check if the deactivated_date is set and if it's less than or equal the current date
            if ($respondent->deactivated_date && Carbon::parse($respondent->deactivated_date)->endOfDay()->lessThanOrEqualTo(Carbon::now()) || $respondent->active_status_id==5) {
                $message = strip_tags("<strong>Your account is deactivated.</strong>");
                throw ValidationException::withMessages([
                    'message' => $message,
                ]);
            }
        }
    
        // Authenticate the user
        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            // Handle unsuccessful authentication
            if (Auth::attempt(['mobile' => $credentials['email'], 'password' => $credentials['password']])) {
                RateLimiter::clear($this->throttleKey());
            }
    
            if (Respondents::where('email', $credentials['email'])->first() || Respondents::where('mobile', $credentials['email'])->first()) {
                $mess = strip_tags("<strong>Incorrect Password.</strong>");
            } else {
                if (filter_var($credentials['email'], FILTER_VALIDATE_INT) === false) {
                    $mess = strip_tags("<strong>Incorrect Email.</strong>");
                } else {
                    $mess = strip_tags("<strong>Incorrect Phone No.</strong>");
                }
            }
    
            throw ValidationException::withMessages([
                'email' => $mess,
            ]);
        }
    
        RateLimiter::clear($this->throttleKey());
    }
    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
