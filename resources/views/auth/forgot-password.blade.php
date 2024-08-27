@include('user.layout.header')
<style>
    .error {
        color: red;
    }

    button#reset:hover {
        background-color: #6396b1;
        color: #fff;
    }
    h2, .h2{
        font-size: 2.5rem !important;
    }
    
    .fs-20{
        font-size:20px !important;
    }
    .pos-abs{
        position: absolute;
        bottom:22px;
        right:100px;
    }
    .pos-rel{
        position:relative;
    }
    body{
        overflow: hidden;
    }
    .w-35{
        width:45% !important;
    }
    .vi-nav-bg{
        background-color:#fff;
    }
    button#reset {
    background-color: #6396b1;
    color: #fff;
}
.vi-white-bg:hover{
    background-color:#ccc;
    
}
</style>
<!-- main starts -->
<main class="forgot-pass py-5  vi-background-index pos-rel m-auto d-flex">
    <!-- <div class=" pos-abs mob-hide">
    <img class="w-35 ml-auto d-flex" src="{{ asset('assets/images/img_1.webp') }}" alt="Forgot image" />
    </div> -->
    <div class="container m-auto ">
    
        <div class="row m-auto ">
            <div class="col-md-6 m-auto">
                <form id="forgot_table" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="text-start m-auto my-3">
                        <h2 class="mb-0 pb-2 text-white">Forgotten your password</h2>
                        <p class="mb-4 fw-bold h4 text-white">Please use your email address to receive the code and link</p>
                        <h2 class="mb-4 fw-bold h4">Account Information</h2>
                        <label for="date" class="fw-bolder fs-20">Email</label>
                        <input type="email" name="email" id="email" placeholder="email@address.com"
                            class="form-control vi-border-clr border-radius-6px" id="">
                        <div class="row my-2">
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
            <div class="col-md-5 yelow-bg2 mob-hide br-35">
            <img class="w-75 m-auto d-flex" src="{{ asset('assets/images/img_1.webp') }}" alt="Forgot image" /> 

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
