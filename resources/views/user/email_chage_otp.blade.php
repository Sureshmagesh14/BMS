@include('user.layout.header')
<style>
    .error {
        color: red;
    }

    button#check_otp:hover, button#change_email {
        background-color: #6396b1;
        color: #fff;
    }
    .input-group-text {
        line-height: 2.3;
    }
    label#phone-error{
        width: 100% !important;
    }
    h2, .h2{
        font-size: 3rem !important;
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
    button#check_otp, button#change_email {
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
                <div class="otp_class">
                    <form id="forgot_table">
                        @csrf
                        <div class="text-start m-auto my-3">
                            <h2 class="mb-0 pb-2 text-white">Change your email address</h2>
                            <p class="mb-4 fw-bold h4 text-white">OTP send your registered mobile number.</p>
                            <label for="otp" class="fw-bolder fs-20">Enter your OTP</label>
                            <div class="input-group mb-2">
                                <input type="number" name="otp" id="otp" placeholder="000000" class="form-control vi-border-clr border-radius-0 w-50" minlength="6">
                            </div>
                            <div class="row my-2">
                                <div class="col-md-6 col-sm-12">
                                    <button type="button"
                                    class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 m-auto w-100 my-2 me-1"
                                    id="check_otp">Check</button>
                                </div>
                                <div class="col-md-6 col-sm-12 m-auto">
                                    <a href="{{ route('updateprofile_wizard') }}"
                                        class="ml-1 btn vi-white-bg border-radius-0 px-5 py-3 m-auto w-100">Go Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="email_address_class" style="display: none;">
                    <form action="{{ route('emailChange') }}" method="POST" id="email_id_change_form">
                        @csrf
                        <div class="text-start m-auto my-3">
                            <label for="email_id" class="fw-bolder fs-20">Enter your new email address</label>
                            <div class="input-group mb-2">
                                <input type="text" name="email_id" id="email_id" class="form-control vi-border-clr border-radius-0 w-50">
                            </div>
                            <div class="row my-2">
                                <div class="col-md-6 col-sm-12">
                                    <button type="submit" class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 m-auto w-100 my-2 me-1" id="change_email">Change</button>
                                </div>
                                <div class="col-md-6 col-sm-12 m-auto">
                                    <a href="{{ route('updateprofile_wizard') }}" class="ml-1 btn vi-white-bg border-radius-0 px-5 py-3 m-auto w-100">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="text-center m-auto d-flex flex-column"></div>
            </div>
            <div class="col-md-5 yelow-bg2 mob-hide br-35">
            <img class="w-75 m-auto d-flex" src="{{ asset('assets/images/img_1.webp') }}" alt="Forgot image" /> 

            </div>
        </div>
    </div>
</main>
<!-- main ends -->

@include('user.layout.forgot-footer')
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    $(function() {
        $('#phone').inputmask("999999");
        

        $('#email_id_change_form').validate({
            rules: {
                email_id: {
                    required: true,
                }
            },
            messages: {
                email_id: {
                    required: "Please enter an email."
                }
            }
        });
    });

    $("#check_otp").click(function(){
        $('#forgot_table').validate({
            rules: {
                otp: {
                    required: true,
                    maxlength: 6,
                    minlength: 6
                }
            },
            messages: {
                otp: {
                    required: "Please enter an OTP.",
                    minlength: "OTP must be 6 digits."
                }
            }
        });

        $.ajax({
            url : '{{ route("emailChangeOtpCheck") }}',
            type : 'GET',
            data : {
                'otp' : $("#otp").val()
            },
            success : function(data) {              
                if(data == 1){
                    toastr.success("Success! Please change your email");
                    $(".otp_class").hide();
                    $(".email_address_class").show();
                }
                else{
                    toastr.error("OOPS! OTP is wrong.");
                }
            },
            error : function(request,error)
            {
                alert("Request: "+JSON.stringify(request));
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