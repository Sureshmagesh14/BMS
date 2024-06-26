@include('admin.auth.admin-header')
<div class="h-full">
    <div class="px-view py-view mx-auto">
        <div class="mx-auto py-8 max-w-sm text-center text-90">
            <img class="fill-current" width="200" height="39" src="{{ asset('assets/images/brand_surgen.png') }}" />
        </div>
        <form id="forgot_form" class="bg-white shadow rounded-lg p-8 max-w-login mx-auto" method="POST"
            action="{{ route('password.email') }}">
            @csrf
            <h2 class="text-2xl text-center font-normal mb-6 text-90">Forgot your password?</h2>
            <svg class="block mx-auto mb-6" xmlns="http://www.w3.org/2000/svg" width="100" height="2"
                viewBox="0 0 100 2">
                <path fill="#D8E3EC" d="M0 0h100v2H0z" />
            </svg>

            <div class="mb-6 ">
                <label class="block font-bold mb-2" for="email">Email Address</label>
                <input class="form-control form-input form-input-bordered w-full" id="email" type="email"
                    name="email" required>
            </div>
        
            <button class="w-full btn btn-default btn-primary hover:bg-primary-dark" type="submit">
                Send Password Reset Link
            </button>
        </form>
    </div>
    @include('admin.auth.admin-footer')
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }

        $(function() {
            $('#forgot_form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        validate_email: true
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
