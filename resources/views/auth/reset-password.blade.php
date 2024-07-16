@include('user.layout.header')
<style>
    
    button#pass:hover {
        background-color: #6396b1;
        color: #fff;
    }
    label#password-error{
        width: 100% !important;
    }
    label#password_confirmation-error {
        width: 100% !important;
    }
    .error {
    color: red;
    font-size: 0.875rem; /* Smaller size for error message */
    margin-top: 0.25rem; /* Space above the error message */
}


.input-group .input-group-text {
    display: flex; /* Flex to center the icon */
    align-items: center; /* Center the icon vertically */
}

@media (max-width: 768px) {
        .text-start {
            text-align: center; /* Center text on smaller screens */
        }

        .form-control {
            width: 100%; /* Full width on smaller screens */
        }

        .btn {
            width: 100%; /* Full width buttons */
            margin-bottom: 1rem; /* Space between buttons */
        }
    }

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- main starts -->
<main class="forgot-pass my-5 py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto">
                <form id="forgot_table" method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="text-start w-md-50 w-100 m-auto my-3">
                        <p class="mb-0">Forgot Password</p>
                        <h2 class="mb-4 fw-bold h4">Account Info</h2>
                        
                        <label for="email" class="fw-bolder">Email</label>
                        <input type="email"  disabled
                               class="form-control vi-border-clr border-radius-6px" value="{{ old('email', $request->email) }}">
                        <input type="hidden" name="email" id="email" placeholder="email@address.com"
                               class="form-control vi-border-clr border-radius-6px" value="{{ old('email', $request->email) }}">
                        <label id="email-error" class="error" for="email"></label>

                        <label for="password" class="fw-bolder">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" placeholder="Password" autocomplete="new-password"
                                   class="form-control vi-border-clr border-radius-6px">
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <label id="password-error" class="error" for="password"></label>

                        <label for="password_confirmation" class="fw-bolder">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" placeholder="Confirm Password"
                                   class="form-control vi-border-clr border-radius-6px">
                            <span class="input-group-text" id="togglePasswordConfirmation" style="cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <label id="password_confirmation-error" class="error" for="password_confirmation"></label>

                        <button type="submit"
                                class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 m-auto w-100 my-2" id="pass">REQUEST
                            {{ __('Reset Password') }}</button>
                        <a href="{{ route('login') }}"
                           class="btn vi-white-bg border-radius-0 text-white px-5 py-3 m-auto w-100">BACK TO Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- main ends -->
@include('user.layout.forgot-footer')
<script>
    $(function() {
        $('#forgot_table').validate({
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
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                }

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

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const passwordIcon = this.querySelector('i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    });

    document.getElementById('togglePasswordConfirmation').addEventListener('click', function () {
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const confirmationIcon = this.querySelector('i');
        if (passwordConfirmationInput.type === 'password') {
            passwordConfirmationInput.type = 'text';
            confirmationIcon.classList.remove('fa-eye');
            confirmationIcon.classList.add('fa-eye-slash');
        } else {
            passwordConfirmationInput.type = 'password';
            confirmationIcon.classList.remove('fa-eye-slash');
            confirmationIcon.classList.add('fa-eye');
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
