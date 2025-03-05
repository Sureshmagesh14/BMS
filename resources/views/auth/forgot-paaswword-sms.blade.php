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
    @media (max-width: 768px) {
        .custom-placeholder {
            left: 60px; /* Adjust this value as needed */
        }
    }

    @media (max-width: 480px) {
        .custom-placeholder {
            left: 30px; /* Adjust for very small screens */
        }
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
    button#reset {
    background-color: #6396b1;
    color: #fff;
}
.vi-white-bg:hover{
    background-color:#ccc;
    
}
.placeholder-container {
    position: relative;
    display: inline-block;
}

.custom-placeholder {
    position: absolute;
    left: 65px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    pointer-events: none;
    transition: opacity 0.2s;
}

.bold-zero {
    font-weight: bold;
    color: #000000;
}

.form-control {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 0;
    width: 100%;
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
                <form id="forgot_table" method="POST" action="{{ route('forgot_password_check') }}">
                    @csrf
                    <div class="text-start m-auto my-3">
                        <h2 class="mb-0 pb-2 text-white">Forgotten your password</h2>
                        <p class="mb-4 fw-bold h4 text-white">Please use your phone number to receive the code and link</p>
                        <h2 class="mb-4 fw-bold h4">Account Information</h2>
                        <label for="phone" class="fw-bolder fs-20">Mobile</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">+27</div>
                            </div>
                            <input type="text" name="phone" id="phone" 
                                class="form-control vi-border-clr border-radius-0 w-50" maxlength="11">
                            <div class="custom-placeholder mobile">(<span class="bold-zero">0</span>xx) xxx xxxx</div>
                        </div>
                        <span>Don't include 0 in starting</span>
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
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    $(function() {
        $('#phone').inputmask({
            mask: "99 999 9999",
            showMaskOnHover: false,
            showMaskOnFocus: false,
            placeholder: "",
            // Custom validation to prevent first digit from being '0'
            preValidation: function(buffer, pos, char) {
                if (pos === 0 && char === '0') {
                    return false;
                }
                return true;
            }
        });
        $('#forgot_table').validate({
            rules: {
                phone: {
                    minlength: 11, // Minimum length of 11 digits
                    maxlength: 11, // Maximum length of 11 digits
                    mobile_format: true, // Custom validation to allow digits, spaces, and optional underscore at the end
                    required: true,
                
                   
                },

            },
            messages: {
               
                phone: {
                    remote: "Mobile number already exists!",
                    minlength: "Mobile number must be exactly 11 digits.",
                    maxlength: "Mobile number must be exactly 11 digits.",
                    mobile_format: "Invalid Mobile Number Format."
                },
                
            },
        });

        $.validator.addMethod("mobile_format", function(value, element) {
            // Regex allows digits, spaces, and one underscore at the end
            return /^(\d{2} \d{3} \d{4})(_|)?$/.test(
            value); // This regex allows the underscore only at the end
        }, "Invalid Mobile Number Format");
    });

    document.addEventListener('DOMContentLoaded', function() {
        const mobile = document.getElementById('phone');
        const mobilePlaceholder = document.querySelector('.custom-placeholder.mobile');
        
        // Hide placeholder when input has content
        mobile.addEventListener('input', function() {
        if (mobile.value.length > 0) {
            mobilePlaceholder.style.display = 'none'; // Hide placeholder when there is content
        } else {
            mobilePlaceholder.style.display = 'block'; // Show placeholder again if input is empty
        }
    });

    mobile.addEventListener('focus', function() {
        if (mobile.value.length === 0) {
            mobilePlaceholder.style.opacity = '0.5'; // Faded when focused
        } else {
            mobilePlaceholder.style.display = 'none'; // Hide if there's text
        }
    });

    mobile.addEventListener('blur', function() {
        if (mobile.value.length === 0) {
            mobilePlaceholder.style.display = 'block';
            mobilePlaceholder.style.opacity = '1'; // Ensure full opacity when unfocused
        } else {
            mobilePlaceholder.style.display = 'none'; // Keep hidden if there's text
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