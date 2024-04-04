@include('user.layout.nomenu-header')
<style>
    .error {
        color: red;
    }
</style>
<div class="container-fluid vh-100">
    <div class="row">
        <div class="col-md-6 d-none-mobile">
            <img src="{{ asset('user/images/group-afro-americans-working-together.jpg') }}" class="img-fluid vh-100"
                alt="" />
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="rightside text-center">
                <img src="{{ asset('user/images/small-logo.png') }}" class="img-fluid w-50 m-auto mb-4" alt="" />
                <h2 class="vi-common-clr vi-welcome-size fw-bolder">Welcome!</h2>

                <p>Login with Username or Mobile</p>



                <form method="POST" id="login_table" action="{{ route('login') }}">
                    @csrf

                    {{-- <div class="my-3  w-75 m-auto">
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $message)
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button>
                                    <span>{{ $message }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div> --}}

                    <div class="my-3  w-75 m-auto">
                        <label class="email-start vi-common-clr" for="email">Username</label>
                        <input type="email" class="form-control vi-border-clr vi-cs-textbox" name="email"
                            id="email" required />
                    </div>
                    <div class="my-3 w-75 m-auto">
                        <label class="pass-start vi-common-clr" for="email text-start">Password</label>
                        <input type="password" placeholder="" class="form-control vi-border-clr vi-cs-textbox"
                            name="password" required />
                    </div>
                    @if (Route::has('password.request'))
                        <div class="forgetpass me-5">
                            <a href="{{ route('password.request') }}" class="nav-link text-end me-5 my-2">Forgot your
                                Username/Password?</a>
                        </div>
                    @endif
                    <div class="mobile-space">
                        <input type="submit" value="Login" class="btn vi-nav-bg text-white py-3 px-5" />
                    </div>
                </form>

                <div class="vi-horizo-line my-5 w-25 m-auto">
                    <span class="vi-bdr-set-or position-relative px-3">OR</span>
                </div>
                <div class="regaccount ">
                    <p class="d-flex align-items-center justify-content-center"><a class="ps-2 nav-link fw-500"
                            href="{{ route('register') }}">Don't have an account? Register now</a></p>
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

<script>
    $(function() {
        $('#login_table').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    validate_email: true
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
</script>
