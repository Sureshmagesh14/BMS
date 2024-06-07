@include('admin.auth.admin-header')
<style>
    .field-icon {
        float: right;
        margin-right: 12px;
        margin-top: -26px;
        position: relative;
        z-index: 2;
    }


    i.fa.fa-eye {
        color: black;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-dismissible {
        padding-right: 4rem;
    }

    .alert {
        position: relative;
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: .25rem;
    }

    /*Footer End*/
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="h-full">
    @if (Session::has('pass_error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <div class="text-center"><strong>{{ session('pass_error') }}</strong> Please try again or you can <a
                    href="{{ route('admin.forgot_password') }}">reset your password.</a></div>
        </div>
    @endif
    <div class="px-view py-view mx-auto">
        <div class="mx-auto py-8 max-w-sm text-center text-90">
            <img class="fill-current" width="200" height="39"
                src="{{ asset('assets/images/brand_surgen.png') }}" />
        </div>
        <form id="users_form" class="bg-white shadow rounded-lg p-8 max-w-login mx-auto" method="POST"
            action="{{ route('admin.login') }}">
            @csrf
            <h2 class="text-2xl text-center font-normal mb-6 text-90">Welcome Back!</h2>
            <svg class="block mx-auto mb-6" xmlns="http://www.w3.org/2000/svg" width="100" height="2"
                viewBox="0 0 100 2">
                <path fill="#D8E3EC" d="M0 0h100v2H0z" />
            </svg>

            <div class="mb-6">
                <label class="block font-bold mb-2" for="email">Email Address</label>
                <input class="form-control form-input form-input-bordered w-full" id="email" type="email"
                    name="email" placeholder="Enter Your Email"  value="{{ isset($_COOKIE['email']) ? $_COOKIE['email'] : '' }}" required autofocus>
            </div>

            <div class="mb-6">
                <label class="block font-bold mb-2" for="password">Password</label>
                <div class="my-3 w-75 m-auto">
                    <input class="form-control form-input form-input-bordered w-full input-password" id="password-field"
                        type="password" name="password" placeholder="Enter Your Password"
                        value="{{ isset($_COOKIE['password']) ? $_COOKIE['password'] : '' }}" required />
                    <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                </div>
            </div>

            <div class="flex mb-6">
                <label class="flex items-center text-xl font-bold">
                    <input class="" type="checkbox" name="remember" id="remember"
                        {{ isset($_COOKIE['email']) ? 'checked' : '' }}>
                    <span class="text-base ml-2">Remember Me</span>
                </label>


                <div class="ml-auto">
                    <a class="text-primary dim font-bold no-underline" href="{{ route('admin.forgot_password') }}">
                        Forgot Your Password?
                    </a>
                </div>
            </div>

            <button id="users_create" class="w-full btn btn-default btn-primary hover:bg-primary-dark" type="submit">
                Login
            </button>
        </form>

    </div>
    @include('admin.auth.admin-footer')

    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/toastr.init.js') }}"></script>

    <script src="{{ asset('assets/js/admin/jquery.validate.js') }}"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }

        $(function() {
            $('#users_form').validate({
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

    @if (count($errors) > 0)
        @foreach ($errors->all() as $message)
            <script>
                toastr.error("{{ $message }}");
            </script>
        @endforeach
    @endif

    @if (Session::has('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif
