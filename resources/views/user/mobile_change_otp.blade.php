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

<style>
    .error {
        color: red;
    }

    .input-group-text {
        line-height: 2.3;
    }


    ::-webkit-scrollbar {
        width: 14px;
    }

    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    ::-webkit-scrollbar-thumb {
        border-radius: 10px;
        border-radius: 10px;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
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
                            <h2 class="mb-0 pb-2 text-white">Change your mobile number</h2>
                            <p class="mb-4 fw-bold h4 text-white">OTP send your registered email.</p>
                            <label for="otp" class="fw-bolder fs-20">Enter your OTP</label>
                            <div class="input-group mb-2">
                                <input type="number" name="otp" id="otp" placeholder="000000" class="form-control vi-border-clr border-radius-0 w-50">
                            </div>
                            <div class="row my-2">
                                <div class="col-md-6 col-sm-12">
                                    <button type="submit"
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
                    <form action="{{ route('mobileChange') }}" method="POST" id="mobile_no_change_form">
                        @csrf

                        <div class="text-start m-auto my-3">
                            <div class="mobile text-start m-auto my-3">
                                <label for="mobile" class="fw-bolder fs-20">Mobile <span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend w-15">
                                        <div class="input-group-text">+27 (0)</div>
                                    </div>
                                    <input type="text" name="phone_no" id="phone_no" placeholder="819 966 078" class="form-control vi-border-clr border-radius-0 w-50"
                                    autocomplete="off">
                                </div>
                                <small class="text-muted">Don’t include 0 in starting.</small>
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
        $('form#mobile_no_change_form').validate({
            rules: {
                phone_no: {
                    required: true,
                    rangelength: [9, 9]
                }
            },
            messages: {
                phone_no: {
                    required: "Please enter an mobile.",
                    rangelength: "The length must be exactly 11 characters."
                }
            }
        });

        $('form#forgot_table').validate({
            rules: {
                otp: {
                    required: true,
                    rangelength: [6, 6]
                }
            },
            messages: {
                otp: {
                    required: "Please enter an OTP.",
                    rangelength: "OTP must be 6 digits."
                }
            }
        });
    });

    $("#check_otp").click(function(event){
        event.preventDefault();

        if ($('form#forgot_table').valid()) {
            $.ajax({
                url : '{{ route("emailChangeOtpCheck") }}',
                type : 'GET',
                data : {
                    'otp' : $("#otp").val()
                },
                success : function(data) {              
                    if(data == 1){
                        toastr.success("Success! Please change your mobile no");
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