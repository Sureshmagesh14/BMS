@include('user.layout.nomenu-header')
<style>
    .error {
        color: red;
    }

    .field-icon {
        float: right;
        margin-right: 12px;
        margin-top: -37px;
        position: relative;
        z-index: 2;
    }

    .rightside.text-center {
        /* margin-top: 85px !important; */
        padding: 20px !important;
    }

    .container {
        padding-top: 50px;
        margin: auto;
    }

    .image-cover {
        object-fit: cover;
    }

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
        top: 15px;
    }

    i.fa.fa-eye {
        color: black;
    }

    .input-group-text {
        line-height: 2.3;
    }

    input#terms {
        height: 1em !important;
    }

    label#mobile-error {
        width: 100% !important;
    }

    label#email-error {
        width: 100% !important;
    }


    label#whatsapp-error {
        width: 100% !important;
    }

    label#date_of_birth-error {
        width: 100% !important;
    }

    a#policy {
        color: blue;
    }

    .modal-body {
        width: 400px;
        height: 600px;
        margin: 10px auto;
        overflow-y: auto;

        padding: 10px;
        border-radius: 10px;
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
    .rounded-border{
        border-radius: 25px;
    }
    .bg-yellows{
        background:#ffce45;
        border: 1px solid #ffce45;
    }
    .h-100p{
        height:100%;
    }
</style>
<div class="container-fluid">
    <div class="row vi-background-index">
        <div class="col-md-7 col-sm-12">
            <div class="w-100 h-100p d-flex m-auto">
            <div class="rightside text-center m-auto w-100">
                <!-- <h3>Join our Database</h3> -->
                 
                

                
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
                            <div class="input-group mb-2">
                                <div class="input-group-prepend w-15">
                                    <div class="input-group-text">+27</div>
                                </div>
                                <input  type="text" name="mobile" id="mobile" placeholder="819 966 078"
                                    class="form-control vi-border-clr border-radius-0 w-50" maxlength="11" required>
                            </div>
                        </div>

                        <div class="mobile text-start w-48 m-auto my-3">
                            <label for="mobile">Whatsapp <span class="text-danger">*</span> <span
                                    class="text-xs text-brand underline pointer-events-auto cursor-pointer">(Use
                                    Mobile)</span></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend w-15">
                                    <div class="input-group-text">+27</div>
                                </div>
                                <input  type="text" name="whatsapp" id="whatsapp" placeholder="819 966 078"
                                    class="form-control vi-border-clr border-radius-0 w-50" maxlength="11" required>
                            </div>
                        </div>
                    </div>
                    <div class="first-row d-md-flex">
                        <div class="email text-start w-48 m-auto my-3">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text  px-3 py-3"><i class="fa fa-envelope" style="font-size:36px;"
                                            aria-hidden="true"></i></div>
                                </div>
                                <input type="text" name="email" id="email" placeholder="john@example.com"
                                    class="form-control vi-border-clr border-radius-0 reg_email" required>
                                <span class="email_error">Invalid Email Address</span>
                            </div>

                        </div>
                        <div class="date text-start w-48 my-3">
                            <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text px-3 py-3"><i class="fa fa-calendar" style="font-size:36px;"
                                            aria-hidden="true"></i></i></div>
                                </div>
                                <input type="text" name="date_of_birth" id="date_of_birth" placeholder="yyyy/mm/dd"
                                    class="form-control vi-border-clr border-radius-0" required>

                            </div>
                            <span id="agecal"></span>
                        </div>

                    </div>
                    <div class="first-row d-md-flex">
                        <div class="email text-start w-48 m-auto my-3">
                            <label for="date">Password<span class="text-danger">*</span> <span
                                    class="text-xs text-brand underline pointer-events-auto cursor-pointer">(At least 6
                                    characters)</span></label>
                            <div class="main-password">
                                <input type="password" name="password_register" id="password_register"
                                    class="form-control vi-border-clr border-radius-0 input-password"
                                    aria-label="password" placeholder="Create Password" required>
                                <a href="JavaScript:void(0);" class="icon-view">
                                    <i class="fa fa-eye-slash"></i>
                                </a>
                            </div>
                        </div>
                        <div class="date text-start w-48 my-3">
                            <label for="date">Confirm Password<span class="text-danger">*</span> <span
                                    class="text-xs text-brand underline pointer-events-auto cursor-pointer"></span></label>
                            <div class="main-password">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control vi-border-clr border-radius-0 input-password"
                                    aria-label="password" placeholder="Confirm/Retype Password" required>
                                <a href="JavaScript:void(0);" class="icon-view"><i class="fa fa-eye-slash"></i></a>
                            </div>
                        </div>

                    </div>

                    <div class="lname text-start w-48 me-auto my-3">
                        <input type="checkbox" id="terms" name="terms" class="form-check-input" required>
                        <span class="form-check-label">Agree to the <a style="cursor: pointer;" id="policy"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">Terms and Conditions</a>.</span>
                    </div>

                    <div class="submit-btn text-center">
                        <button type="submit" class="btn vi-nav-bg text-white w-md-25 m-auto my-2 text-uppercase vi-main-btn-db w-30"
                            id="save_org">Continue</button>
                    </div>
                </form>

                <div class="vi-horizo-line my-3 w-25 m-auto">
                    <span class="vi-bdr-set-or position-relative px-3">OR</span>
                </div>
                <div class="regaccount ">
                    <p class="d-flex align-items-center justify-content-center"><a class="ps-2 nav-link fw-500"
                            href="{{ route('login') }}">Do you have an account? Login</a></p>
                </div>
            </div>
            </div>
        </div>
        
        <div class="col-md-5 d-none-mobile p-0">
            <div class="w-75 m-auto h-100p d-flex">
            <!-- <div> -->
            <div class="w-100 reg-img m-auto">
            <h3 class="text-center mt-3 mb-2">Let's get you started</h3>
            <img src="{{ asset('assets/images/reg-page_b.png') }}"
                class="img-fluid w-100 image-cover bg-yellows m-auto rounded-border" alt="" />
            </div>
            <!-- </div> -->
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Terms & Condition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $content->data }}
            </div>
        </div>
    </div>
</div>

@include('user.layout.footer')

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
    $('#mobile').inputmask("999 999 999");
    $('#whatsapp').inputmask("999 999 999");
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

                password_register: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password_register"
                },
                terms: {
                    required: true,

                },

            },
            messages: {
                email: {
                    remote: mess
                },
                "terms": {
                    required: function() {
                        toastr.error('Please accept terms and policy field is required')
                    },
                },
            },
            //     submitHandler: function(form) { // for demo

            //     return false; // for demo
            // }
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
                if ($(this).find('i').hasClass('fa-eye-slash')) {
                    $(this).find('i').removeClass('fa-eye-slash')
                    $(this).find('i').addClass('fa-eye')
                    change = "text";
                } else {
                    $(this).find('i').removeClass('fa-eye')
                    $(this).find('i').addClass('fa-eye-slash')
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
                if ($(this).find('i').hasClass('fa-eye-slash')) {
                    $(this).find('i').removeClass('fa-eye-slash')
                    $(this).find('i').addClass('fa-eye')
                    change = "text";
                } else {
                    $(this).find('i').removeClass('fa-eye')
                    $(this).find('i').addClass('fa-eye-slash')
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

    $("#date_of_birth").change(function() {
        var date_of_birth = $(this).val();

        var today = new Date();

        var out;

        out = diffDate(new Date(date_of_birth), new Date(today));
        display(out);

        function diffDate(startDate, endDate) {
            var b = moment(startDate),
                a = moment(endDate),
                intervals1 = ['Years', 'Months', 'Days'],
                intervals = ['Years'],
                out = {};

            for (var i = 0; i < intervals.length; i++) {
                var diff = a.diff(b, intervals[i]);
                b.add(diff, intervals[i]);
                out[intervals[i]] = diff;
            }
            return out;
        }

        function display(obj) {
            var str = '';
            for (key in obj) {
                str = str + obj[key] + ' ' + key + ' '
            }
            console.log("str", str);
            document.getElementById('agecal').innerText = str;
        }
    });

    $(document).ready(function() {

        $('#date_of_birth').inputmask("yyyy/mm/dd", {
            "placeholder": "YYYY/MM/DD",
            onincomplete: function() {
                $(this).val('');
            }
        });
    });
</script>
