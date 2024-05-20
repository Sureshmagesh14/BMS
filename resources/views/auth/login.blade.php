@include('user.layout.nomenu-header')
<style>
    .error {
        color: red;
    }

    .field-icon {
        float: right;
        margin-right: 12px;
        margin-top: -37px;
        position: relative;
        z-index: 2;
    }

    .rightside.text-center {
        /* margin-top: 85px !important; */
        padding: 20px !important;
    }

    .container {
        padding-top: 50px;
        margin: auto;
    }
</style>
<div class="container-fluid vh-90">
    <div class="row">
        <div class="col-md-6 d-none-mobile">
            <img src="{{ asset('user/images/group-afro-americans-working-together.jpg') }}" class="img-fluid vh-90 w-100"
                alt="" />
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="rightside text-center">
                <img src="{{ asset('user/images/small-logo.png') }}" class="img-fluid w-50 m-auto mb-4" alt="" />
                <h2 class="vi-common-clr vi-welcome-size fw-bolder">Welcome!</h2>

                <p>Login with Username or Mobile</p>
                <form method="POST" id="login_table" action="{{ route('login') }}">
                    @csrf
                    <div class="my-3  w-75 m-auto">
                        <label class="email-start vi-common-clr" for="email">Username</label>
                        <input type="text" class="form-control vi-border-clr vi-cs-textbox" name="email"
                            id="email" />
                    </div>
                    <div class="my-3 w-75 m-auto">
                        <label class="pass-start vi-common-clr" for="email text-start">Password</label>
                        <input id="password-field" type="password" placeholder=""
                            class="form-control vi-border-clr vi-cs-textbox" name="password" required />

                        <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="forgetpass me-5">
                            <a href="{{ route('password.request') }}" class="nav-link text-end me-5 my-2">Forgot your
                                Username/Password?</a>
                        </div>
                    @endif
                    <div class="mobile-space">
                        <input type="submit" value="Login" class="rounded vi-nav-bg text-white w-md-25 m-auto my-2 text-uppercase vi-main-btn-db" />
                    </div>
                </form>

                <div class="vi-horizo-line my-3 w-25 m-auto">
                    <span class="vi-bdr-set-or position-relative px-3">OR</span>
                </div>
                <div class="regaccount ">
                    <p class="d-flex align-items-center justify-content-center"><a class="ps-2 nav-link fw-500"
                            href="{{ route('register') }}">Don't have an account? Register now</a></p>
                </div>
                @if (count($errors) > 0)
                    @if (
                        !str_contains($errors->all()[0], 'Incorrect Email') &&
                            !str_contains($errors->all()[0], 'Incorrect Phone No') &&
                            !str_contains($errors->all()[0], 'Unsubscribed'))
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $message)
                                <strong>{{ $message }}</strong> Please try again or you can <a
                                    href="{{ url('forgot-password') }}">reset your password.</a>
                            @endforeach
                        </div>
                    @endif
                @endif
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
