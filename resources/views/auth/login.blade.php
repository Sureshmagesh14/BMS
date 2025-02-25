@include('user.layout.header')
<!-- @include('user.layout.nomenu-header') -->
<style>
    .error {
        color: red;
    }

    .navbar.vi-nav-bg {
        background-color: #fff;
    }

    .field-icon {
        float: right;
        margin-right: 12px;
        margin-top: -37px;
        position: relative;
        z-index: 2;
    }

    .outside {
        width: 100%;
        height: 100%;
        margin: auto;
        display: flex;
    }

    .w-90 {
        width: 90%;
    }

    .login_img {

        border-radius: 30px;
        overflow: hidden;
    }

    .rightside.text-center {
        /* margin-top: 85px !important; */
        width: 100%;
        padding: 20px !important;
        height: fit-content;
        margin: auto;
    }

    .rounded-border {
        border-radius: 25px;
    }

    h1.vi-common-clr.vi-welcome-size.fw-bolder {
        color: #ffffff;
    }


    .container {
        /* padding-top: 50px; */
        margin: auto;
    }

    .login.w-50 {
        width: 25vh !important;
    }

    .anchor {
        text-decoration: none;
    }

    .image-cover {
        object-fit: cover;
    }

    .text-left {
        text-align: left;
    }

    .h-100 {
        height: 100vh !important;
    }
    @media only screen and (min-width: 768px) {
    h1 {
        font-size: 50px !important;
    }
}

    @media only screen and (max-width: 600px) {
        .login .w-75 {
            width: 100% !important;
        }
    }
</style>

<div class="container-fluid vi-background-index h-90">
    <div class="row vi-background-index">
        <div class="col-md-5 d-none-mobile d-flex mob-hide p-0 h-100">
            <div class="w-100 d-flex ">
                <img src="{{ asset('assets/images/login-page_b.webp') }}"
                    class="login_img img-fluid w-90 d-flex m-auto d-flex " alt="" />
            </div>
        </div>
        <div class="col-md-7 col-sm-12 h-100">
            <div class="w-100 outside">
                <div class="rightside text-center">
                    <img src="{{ asset('user/images/small-logo.png') }}" class="img-fluid w-50 login m-auto mb-4"
                        alt="" />
                    <h1 class="vi-common-clr vi-welcome-size fw-bolder">Welcome Back</h1>

                    <h2>Login with your email address</h2>
                    <form method="POST" id="login_table" action="{{ route('login') }}">
                        @csrf
                        <div class="my-1  w-75 m-auto">
                            <!-- <label class="email-start vi-common-clr" for="email">Email Address</label> -->
                            <label class="text-left w-100" for="email">Email Address</label>
                            <input type="text" class="form-control vi-border-clr vi-cs-textbox" name="email"
                                id="email" placeholder="Enter Your Email Address" />
                        </div>
                        <div class="my-1 w-75 m-auto">
                            <!-- <label class="pass-start vi-common-clr" for="email text-start">Password</label> -->
                            <label class="text-left w-100" for="email text-start">Password</label>
                            <input id="password-field" type="password" placeholder="Enter Your Password"
                                class="form-control vi-border-clr vi-cs-textbox" name="password" required />

                            <span toggle="#password-field"
                                class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                        </div>
                        @if (Route::has('password.request'))
                        @endif
                        <div class="mobile-space">
                            <input type="submit" value="Login"
                                class="rounded vi-nav-bg text-white w-md-25 m-auto  text-uppercase vi-main-btn-db" />
                        </div>
                    </form>

                    <div class="vi-horizo-line my-3 w-25 m-auto">
                        <span class="vi-bdr-set-or position-relative px-3">OR</span>
                    </div>
                    <div class="regaccount ">
                        <p class="d-flex align-items-center justify-content-center"><a class="ps-2 nav-link fw-500"
                                href="{{ route('register') }}">Don't have an account? Register now</a></p>
                    </div>
                    <div class="vi-horizo-line my-3 w-25 m-auto">
                        <span class="vi-bdr-set-or position-relative px-3">OR</span>
                    </div>
                    <div class="forgetpass">
                        <span>Forgot Password</span> via
                        <a class="anchor" href="{{ route('password.request') }}" class="link">Email</a>
                        or
                        <a class="anchor" href="{{ route('forgot_password_sms') }}" class="link">SMS</a>
                    </div>
                    @if (count($errors) > 0)
                        @if (isset($errors->get('verify')[0]))
                            <div class="alert alert-warning">
                                <strong>{!! $errors->get('verify')[0] !!}</strong>
                            </div>
                        @elseif (
                            !str_contains($errors->all()[0], 'Incorrect Email') &&
                            !str_contains($errors->all()[0], 'Incorrect Phone No') &&
                            !str_contains($errors->all()[0], 'Unsubscribed') &&
                            !str_contains($errors->all()[0], 'Your account is deactivated'))
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $message)
                                    <strong>{{ $message }}</strong> Please try again or you can <a href="{{ url('forgot-password') }}">reset your password.</a>
                                @endforeach
                            </div>
                        @endif
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif
                    @if (session('verification_success') === true)
                        <div class="alert alert-success">
                            Your account has been successfully verified. You can now log in.
                        </div>
                    @elseif (session('verification_success') === false)
                        <div class="alert alert-danger">
                            The verification link is invalid or expired.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



@include('user.layout.footer')

@if (count($errors) > 0)
    @foreach ($errors->all() as $message)
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ $message }}");
        </script>
    @endforeach
@endif

@if (Session::has('status'))
    <script>
        toastr.success("{{ session('status') }}");
    </script>
@endif

@if (Session::has('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

<script>
    $(function() {
        $('#login_table').validate({
            rules: {
                email: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 6
                },

            }
        });
    });

    $.validator.addMethod("validate_email", function(value, element) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {
            return true;
        } else {
            return false;
        }
    }, "Please enter a valid email address.");
    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
