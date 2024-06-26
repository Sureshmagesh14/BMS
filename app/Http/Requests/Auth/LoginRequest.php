<?php

namespace App\Http\Requests\Auth;

use App\Models\Respondents;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {

            $credentials = $this->only('email', 'password');

            // $get_resp_mobile = Respondents::select('active_status_id')->where('mobile', $credentials['email'])->first();
            // if($get_resp_mobile != null){
            //     $get_resp_email = Respondents::select('active_status_id')->where('email', $credentials['email'])->first();
            //     $active_status_id = $get_resp_email->active_status_id;
            // }
            // else{
            //     $active_status_id = $get_resp_mobile;
            // }

            // if($active_status_id != 1){
            //     $mess = strip_tags("<strong>Your Account was Unsubscribed.</strong>");
            //     throw ValidationException::withMessages([
            //         'email' => $mess,
            //     ]);
            // }

            if (Auth::attempt(['mobile' => $credentials['email'], 'password' => $credentials['password']]))
            {     
                RateLimiter::clear($this->throttleKey());
            }

            if (Respondents::where('email', $credentials['email'])->first() || Respondents::where('mobile', $credentials['email'])->first()) {
                $mess = strip_tags("<strong>Incorrect Password.</strong>");
            }
            else{
                if(filter_var($credentials['email'], FILTER_VALIDATE_INT) === false){
                    $mess = strip_tags("<strong>Incorrect Email.</strong>");
                }
                else{
                    $mess = strip_tags("<strong>Incorrect Phone No.</strong>");
                }
            }

            throw ValidationException::withMessages([
                'email' => $mess,
            ]);
            
            // RateLimiter::hit($this->throttleKey());

            // throw ValidationException::withMessages([
            //     'email' => trans('auth.failed'),
            // ]);

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
