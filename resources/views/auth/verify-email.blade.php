@include('user.layout.header')


<div class="container-fluid vh-100">
    <div class="row">
        <div class="col-md-1 d-none-mobile">
            
        </div>
        <div class="col-md-10 col-sm-12">
            <div class="rightside text-center">
                
            
            <img src="{{ asset('user/images/small-logo.png') }}" class="img-fluid w-50 m-auto mb-4" alt="" />
                <h2 class="vi-common-clr vi-welcome-size fw-bolder">Verify Your Email</h2>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                
                <input type="submit" value="{{ __('Resend Verification Email') }}" class="btn vi-nav-bg text-white py-3 px-5" />
            </div>
        </form>
        <br>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <!-- <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button> -->

            <input type="submit" value="Back" class="btn w-md-25 m-auto bg-white vi-common-clr text-uppercase vi-main-bnr-login" />

        </form>
    </div>



            </div>
        </div>
        <div class="col-md-1 d-none-mobile">
            
        </div>
    </div>
</div>
@include('user.layout.footer')