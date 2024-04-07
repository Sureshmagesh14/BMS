@include('user.layout.nomenu-header')
<style>
    .email_error {
        display: none;
    }

    #reg_table .error {
        color: red;
    }

    #login_table .error {
        color: white;
    }

    .main-password {
        position: relative;
    }

    .icon-view {
        position: absolute;
        right: 12px;
        top: 9px;
    }

    .icon-view-login {
        position: absolute;
        right: 12px;
        top: 25px;
    }

    i.fa.fa-eye {
        color: black;
    }
</style>
<div class="container-fluid vh-100">
    <div class="row justify-content-center align-items-center d-flex">
        <div class="col-md-6 vi-nav-bg vh-100 text-center hide-mobile">
            <img src="./assets/images/logo white.png" class="img-fluid mt-5 pt-5 text-center w-50 m-auto" alt="" />
            <h1 class="text-white py-5">Welcome!</h1>

            <form method="POST" id="login_table" action="{{ route('login') }}">
                @csrf
                <div class="my-3  w-50 m-auto text-start">
                    <label class="text-white" for="email">Email or Mobile</label>

                    <input type="email" class="form-control vi-border-clr vi-cs-textbox" name="email" id="email"
                        required />
                </div>
                <div class="my-3 w-50 m-auto text-start">
                    <label class="text-white" for="email">Password</label>

                    <div class="main-password">
                        <input type="password" name="password" id="password"
                            class="form-control vi-border-clr vi-cs-textbox input-password" aria-label="password"
                            required>
                        <a href="JavaScript:void(0);" class="icon-view-login">
                            <i class="fa fa-eye"></i>
                        </a>
                    </div>

                </div>
                <div class="text-center w-50 m-auto">
                    <input type="submit" value="Login" class="btn vi-light-bg text-white py-3 px-5 w-100" />
                </div>
                <div class="forgetpass text-center my-3 d-flex align-items-center justify-content-center">
                    <p class="p-0 m-0">Forgot your Password?</p>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="nav-link p-0 m-0 ps-1">Click here</a>
                    @endif
                </div>

            </form>
        </div>
        <div class="col-md-6">
            <div class="text-center">
                <p>Let's get you started</p>
                <h3>Join our Database</h3>
                <form method="POST" id="reg_table" action="{{ route('register') }}">
                    @csrf
                    <div class="first-row d-md-flex mt-5">
                        <div class="fname text-start w-48 m-auto">
                            <label for="name">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" placeholder="John"
                                oninput ="alphanum(this);" class="form-control vi-border-clr border-radius-0" required>

                        </div>
                        <div class="lname text-start w-48 m-auto">
                            <label for="surname">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="surname" id="surname" placeholder="Doe"
                                oninput ="alphanum(this);" class="form-control vi-border-clr border-radius-0" required>
                        </div>

                    </div>
                    <div class="first-row d-md-flex">
                        <div class="mobile text-start w-48 m-auto my-3">
                            <label for="mobile">Mobile <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" id="mobile" placeholder="081 966 0786"
                                class="form-control vi-border-clr border-radius-0" oninput ="numonly(this);"
                                maxlength="16" required>

                        </div>
                        <div class="lname text-start w-48 m-auto my-3">
                            <label for="whatsapp">Whatsapp <span class="text-danger">*</span></label>
                            <input type="text" name="whatsapp" id="whatsapp" placeholder="081 966 0786"
                                class="form-control vi-border-clr border-radius-0" oninput ="numonly(this);"
                                maxlength="16" required>
                        </div>

                    </div>
                    <div class="first-row d-md-flex">
                        <div class="email text-start w-48 m-auto my-3">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" id="email" placeholder="john@example.com"
                                class="form-control vi-border-clr border-radius-0 reg_email" required>
                            <span class="email_error">Invalid Email Address</span>
                        </div>
                        <div class="lname text-start w-48 m-auto my-3">
                            <label for="id_passport">ID Number\ Passport </label>
                            <input type="text" name="id_passport" id="id_passport"
                                placeholder="Valid RSA ID number or Passport number"
                                class="form-control vi-border-clr border-radius-0" id="">
                        </div>

                    </div>
                    <div class="first-row d-md-flex">
                        <div class="date text-start w-48 my-3">
                            <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" name="date_of_birth" id="date_of_birth" placeholder="dd/mm/yyyy"
                                class="form-control vi-border-clr border-radius-0" required>
                        </div>
                    </div>
                    <div class="first-row">
                        <div class="date text-start w-48 my-3">
                            <label for="date">Password<span class="text-danger">*</span></label>
                            <div class="main-password">
                                <input type="password" name="password" id="password"
                                    class="form-control vi-border-clr border-radius-0 input-password"
                                    aria-label="password" placeholder="Create Password" required>
                                <a href="JavaScript:void(0);" class="icon-view">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                            <br>
                            <div class="main-password">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control vi-border-clr border-radius-0 input-password"
                                    aria-label="password" placeholder="Confirm/Retype Password" required>
                                <a href="JavaScript:void(0);" class="icon-view">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>


                        </div>
                    </div>
                    <div class="lname text-start w-48 m-auto my-3">
                        <input type="checkbox" id="terms" name="terms" class="form-check-input" readonly>
                        <span class="form-check-label">Agree the <a href="https://dev.mustbuildapp.com/terms-of-service" tabindex="-1">terms and policy</a>.</span>
                    </div>
                  
                    <div class="submit-btn text-start">
                        <button class="btn vi-nav-bg border-radius-0 text-white px-5 py-3"
                            id="save_org">Continue</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


@include('user.layout.footer')
<script src="{{ asset('assets/js/inputmask.js') }}"></script>
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
@if (count($errors) > 0)
    @foreach ($errors->all() as $message)
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ $message }}");
        </script>
    @endforeach
@endif
<script>
    var tempcsrf = '{!! csrf_token() !!}';
    $('#mobile').inputmask("999 999-9999");
    $('#whatsapp').inputmask("999 999-9999");
    $('form#reg_table').on('blur', '.reg_email', function() {
        var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        var reg_email = $(this).val();
        var selector = $(this).next('span');
        if (this.value !== '') {
            if (testEmail.test(this.value)) {

                $('.email_error').hide();

                $('#save_org').prop('disabled', false);

            } else {
                $('.email_error').show();
                $('#save_org').prop('disabled', true);
            }


        } else {
            $('.email_error').hide();
        }
    });
    $(function() {
        var mess =
            'This email is already registered. Want to <a href="{{ route('login') }}">login</a> or <a href="{{ url('forgot-password') }}">recover your password?</a>';
        $('form#reg_table').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    validate_email: true,
                    remote: {
                        url: "{{ route('check_email_name') }}",
                        data: {
                            'form_name': "regsiter"
                        },
                        type: "GET"
                    }
                },
                
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },


            },
            messages: {
                email: {
                    remote: mess
                }
            },
        });
    });
    $(function() {
        $('#login_table').validate({
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

    function numonly(input) {
        let value = input.value;
        let numbers = value.replace(/[^0-9]/g, "");
        input.value = numbers;
    }

    function alphanum(input) {
        let value = input.value;
        let numbers = value.replace(/[^a-zA-Z0-9 ]/g, "");
        input.value = numbers;
    }
    $(document).ready(function() {
        $('.main-password').find('.input-password').each(function(index, input) {
            var $input = $(input);
            $input.parent().find('.icon-view').click(function() {
                var change = "";
                if ($(this).find('i').hasClass('fa-eye')) {
                    $(this).find('i').removeClass('fa-eye')
                    $(this).find('i').addClass('fa-eye-slash')
                    change = "text";
                } else {
                    $(this).find('i').removeClass('fa-eye-slash')
                    $(this).find('i').addClass('fa-eye')
                    change = "password";
                }
                var rep = $("<input type='" + change + "' />")
                    .attr('id', $input.attr('id'))
                    .attr('name', $input.attr('name'))
                    .attr('class', $input.attr('class'))
                    .val($input.val())
                    .insertBefore($input);
                $input.remove();
                $input = rep;
            }).insertAfter($input);
        });

        $('.main-password').find('.input-password').each(function(index, input) {
            var $input = $(input);
            $input.parent().find('.icon-view-login').click(function() {
                var change = "";
                if ($(this).find('i').hasClass('fa-eye')) {
                    $(this).find('i').removeClass('fa-eye')
                    $(this).find('i').addClass('fa-eye-slash')
                    change = "text";
                } else {
                    $(this).find('i').removeClass('fa-eye-slash')
                    $(this).find('i').addClass('fa-eye')
                    change = "password";
                }
                var rep = $("<input type='" + change + "' />")
                    .attr('id', $input.attr('id'))
                    .attr('name', $input.attr('name'))
                    .attr('class', $input.attr('class'))
                    .val($input.val())
                    .insertBefore($input);
                $input.remove();
                $input = rep;
            }).insertAfter($input);
        });
    });
</script>
