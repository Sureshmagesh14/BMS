@include('user.layout.header')
<style>
    .error {
        color: red;
    }

    button#reset:hover {
        background-color: #6396b1;
        color: #fff;
    }
</style>
<!-- main starts -->
<main class="forgot-pass my-5 py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto">
                <form id="forgot_table" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="text-start w-md-50 w-100 m-auto my-3">
                        <p class="mb-0">Forgot Password</p>
                        <h2 class="mb-4 fw-bold h4">Account Info</h2>
                        <label for="date" class="fw-bolder">Email</label>
                        <input type="email" name="email" id="email" placeholder="email@address.com"
                            class="form-control vi-border-clr border-radius-6px" id="">
                        <button type="submit"
                            class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 m-auto w-100 my-2"
                            id="reset">REQUEST
                            RESET</button>
                        <a href="{{ route('login') }}"
                            class="btn vi-white-bg border-radius-0 text-white px-5 py-3 m-auto w-100">BACK TO
                            LOGIN</a>
                    </div>
                </form>
                <div class="text-center m-auto d-flex flex-column">
                </div>
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
