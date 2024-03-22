<!DOCTYPE html>
<html lang="en" class="h-full font-sans antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="Yx4KN6U8X0neKeU78F0fc4PSsLsq4idJem0uZafK">
    <title>The Brand Surgeon</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('assets/css/app.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    <!-- Custom Meta Data -->
    <!-- Theme Styles -->
    <style>
        .error{
            color:red;
        }
        </style>
</head>
<body class="bg-40 text-black h-full">
    <div class="h-full">
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

                <div class="mb-6 ">
                    <label class="block font-bold mb-2" for="email">Email Address</label>
                    <input class="form-control form-input form-input-bordered w-full" id="email" type="email"
                        name="email" value="" required autofocus>
                </div>

                <div class="mb-6 ">
                    <label class="block font-bold mb-2" for="password">Password</label>
                    <input class="form-control form-input form-input-bordered w-full" id="password" type="password"
                        name="password" required>
                </div>

                <div class="flex mb-6">
                    <label class="flex items-center text-xl font-bold">
                        <input class="" type="checkbox" name="remember">
                        <span class="text-base ml-2">Remember Me</span>
                    </label>


                    <div class="ml-auto">
                        <a class="text-primary dim font-bold no-underline"
                            href="https://bms.thebrandsurgeon.co.za/bms/password/reset">
                            Forgot Your Password?
                        </a>
                    </div>
                </div>

                <button id="users_create" class="w-full btn btn-default btn-primary hover:bg-primary-dark" type="submit">
                    Login
                </button>
            </form>

        </div>
        <div class="mt-5 text-center">
            <p>© {{ date('Y') }} {{ Config::get('constants.app_title') }}.</p>
        </div>
    </div>

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
                    minlength: 8
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
</body>
</html>
