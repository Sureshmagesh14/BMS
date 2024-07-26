@include('user.layout.header')
<style>
    /* Your existing styles */
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- main starts -->
<main class="forgot-pass my-5 py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto">
                <form id="forgot_table" method="POST" action="{{ route('password.store.sms') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="text-start w-md-50 w-100 m-auto my-3">
                        <p class="mb-0">Forgot Password</p>
                        <h2 class="mb-4 fw-bold h4">Account Info</h2>
                        
                        <label for="mobile" class="fw-bolder">Mobile Number</label>
                        <div class="input-group mb-3">
                            <input type="text"  placeholder="Enter your mobile number" 
                                   class="form-control vi-border-clr border-radius-6px" value="{{ old('mobile') }}" disabled>
                            <input type="hidden" name="mobile" id="mobile" placeholder="Enter your mobile number" 
                                   class="form-control vi-border-clr border-radius-6px" value="{{ old('mobile') }}">
                        </div>
                        <label id="mobile-error" class="error" for="mobile"></label>

                        <label for="password" class="fw-bolder">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" placeholder="Password" autocomplete="new-password"
                                   class="form-control vi-border-clr border-radius-6px">
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <label id="password-error" class="error" for="password"></label>

                        <label for="password_confirmation" class="fw-bolder">Confirm Password</label>
                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" placeholder="Confirm Password"
                                   class="form-control vi-border-clr border-radius-6px">
                            <span class="input-group-text" id="togglePasswordConfirmation" style="cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <label id="password_confirmation-error" class="error" for="password_confirmation"></label>

                        <button type="submit" class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 m-auto w-100 my-2" id="pass">REQUEST
                            {{ __('Reset Password') }}</button>
                        <a href="{{ route('login') }}" class="btn vi-white-bg border-radius-0 text-white px-5 py-3 m-auto w-100">BACK To Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@include('user.layout.forgot-footer')

<script>
    $(function() {
        $('#forgot_table').validate({
            rules: {
                mobile: {
                    required: true,
                    minlength: 9,
                    maxlength: 9,
                    digits: true
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

    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const passwordIcon = this.querySelector('i');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordIcon.classList.toggle('fa-eye');
        passwordIcon.classList.toggle('fa-eye-slash');
    });

    document.getElementById('togglePasswordConfirmation').addEventListener('click', function () {
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const confirmationIcon = this.querySelector('i');
        passwordConfirmationInput.type = passwordConfirmationInput.type === 'password' ? 'text' : 'password';
        confirmationIcon.classList.toggle('fa-eye');
        confirmationIcon.classList.toggle('fa-eye-slash');
    });

    // Display error messages
    @if (count($errors) > 0)
        @foreach ($errors->all() as $message)
            toastr.error("{{ $message }}");
        @endforeach
    @endif
    @if (Session::has('status'))
        toastr.success("{{ session('status') }}");
    @endif
    @if (Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
