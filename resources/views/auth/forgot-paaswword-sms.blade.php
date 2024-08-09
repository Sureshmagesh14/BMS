@include('user.layout.header')
<style>
    .error {
        color: red;
    }

    button#reset:hover {
        background-color: #6396b1;
        color: #fff;
    }
    .input-group-text {
        line-height: 2.3;
    }
    label#phone-error{
        width: 100% !important;
    }
</style>
<!-- main starts -->
<main class="forgot-pass py-5  vi-background-index ">
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-auto">
                <form id="forgot_table" method="POST" action="{{ route('forgot_password_check') }}">
                    @csrf
                    <div class="text-start m-auto my-3">
                        <h2 class="mb-0 pb-2">Forgotten your password</h2>
                        <p class="mb-4 fw-bold h4">Please use your phone number to receive the code and link</p>
                        <h2 class="mb-4 fw-bold h4">Account Information</h2>
                        <label for="phone" class="fw-bolder">Mobile</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">+27 (0)</div>
                            </div>
                            <input type="text" name="phone" id="phone" placeholder="000 000 000"
                                class="form-control vi-border-clr border-radius-0 w-50" maxlength="11">
                               
                        </div>
                        <span>Please do not begin with a zero.</span>
                        <div class="row">
                        <div class="col-md-6 col-sm-12">
                        <button type="submit"
                            class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 m-auto w-100 my-2 me-1"
                            id="reset">REQUEST PASSWORD
                            RESET</button>
                    </div>
                    <div class="col-md-6 col-sm-12 m-auto">
                    <a href="{{ route('login') }}"
                            class="ml-1 btn vi-white-bg border-radius-0 px-5 py-3 m-auto w-100">BACK TO
                            LOGIN</a>
                    </div>
                        
                        </div>
                    </div>
                </form>
                <div class="text-center m-auto d-flex flex-column">
                </div>
            </div>
            <div class="col-md-6 mob-hide">
                <img class="w-50 m-auto d-flex" src="{{ asset('assets/images/img_1.png') }}" alt="Forgot image" />

            </div>
        </div>
    </div>
</main>
<!-- main ends -->

@include('user.layout.forgot-footer')
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    $(function() {
        $('#phone').inputmask("999 999 999");
        $('#forgot_table').validate({
            rules: {
                phone: {
                    required: true,
                    phone: true,
                   
                },

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
j