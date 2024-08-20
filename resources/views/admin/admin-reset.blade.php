
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .field-icon {
            float: right;
            margin-right: 12px;
            margin-top: -26px;
            position: relative;
            z-index: 2;
            cursor: pointer;
        }

        i.fa.fa-eye {
            color: black;
        }
        #submitButton{
            background-color: red;
            color:white;
        }
    </style>
    @include('admin.auth.admin-header')
    <div class="h-full">
        <div class="px-view py-view mx-auto">
            <div class="mx-auto py-8 max-w-sm text-center text-90">
                <img class="fill-current" width="200" height="39"
                    src="{{ asset('assets/images/brand_surgen.png') }}" />
            </div>
            <form id="forgot_form" class="bg-white shadow rounded-lg p-8 max-w-login mx-auto" method="POST"
                action="{{ route('admin_password_reset_update') }}">
                @csrf
                <h2 class="text-2xl text-center font-normal mb-6 text-90">Forgot your password?</h2>
                <svg class="block mx-auto mb-6" xmlns="http://www.w3.org/2000/svg" width="100" height="2"
                    viewBox="0 0 100 2">
                    <path fill="#D8E3EC" d="M0 0h100v2H0z" />
                </svg>

                <div class="mb-6">
                    <label class="block font-bold mb-2" for="email">Email Address</label>
                    <input class="form-control form-input form-input-bordered w-full"
                        value="{{ old('email', $request->email) }}" readonly>
                    <input class="form-control form-input form-input-bordered w-full" id="email" type="hidden"
                        value="{{ old('email', $request->email) }}" name="email" readonly>
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2" for="password">Password</label>
                    <div class="my-3 w-75 m-auto position-relative">
                        <input class="form-control form-input form-input-bordered w-full input-password"
                            id="password-field" type="password" name="password" placeholder="Enter Your Password"
                            required />
                        <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2" for="password_confirmation">Confirm Password</label>
                    <div class="my-3 w-75 m-auto position-relative">
                        <input class="form-control form-input form-input-bordered w-full input-password"
                            id="password_confirmation-field" type="password" name="password_confirmation"
                            placeholder="Confirm Password" required />
                        <span toggle="#password_confirmation-field"
                            class="fa fa-fw fa-eye-slash field-icon toggle-password-confirm"></span>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button class="btn btn-default btn-primary hover:bg-primary-dark w-full sm:w-1/2 mr-2"
                        type="submit">
                        Submit
                    </button>
                    <button class="btn btn-default btn-primary hover:bg-primary-dark w-full sm:w-1/2 mr-2"
                        id="submitButton">
                        Back
                    </button>
                </div>


            </form>
        </div>
        @include('admin.auth.admin-footer')


        <script>
            const routeUrl = "{{ route('admin.forgot_password') }}";

            // Add click event listener to the button
            document.getElementById('submitButton').addEventListener('click', function() {
                window.location.href = routeUrl;
            });

            $(function() {
                $('#forgot_form').validate({
                    rules: {

                        password: {
                            required: true,
                            minlength: 6
                        },
                        password_confirmation: {
                            required: true,
                            minlength: 6,
                            equalTo: "#password-field"
                        }
                    },
                    messages: {
                        password: {
                            minlength: "Password must be at least 6 characters long"
                        },
                        password_confirmation: {
                            equalTo: "Passwords do not match"
                        }
                    }
                });

                $(".toggle-password").click(function() {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });

                $(".toggle-password-confirm").click(function() {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            });
        </script>

        @if (count($errors) > 0)
            @foreach ($errors->all() as $message)
                <script>
                    toastr.error("{{ $message }}");
                </script>
            @endforeach
        @endif

        @if (Session::has('status'))
            <script>
                toastr.success("{{ session('status') }}");
            </script>
        @endif

        @if (Session::has('error'))
            <script>
                toastr.error("{{ session('error') }}");
            </script>
        @endif
    </div>

