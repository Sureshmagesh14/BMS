@include('user.layout.header-2')
<style>
    .input-group-text {
        line-height: 2.3;
    }

    .password-strength-group .password-strength-meter {
        width: 100%;
        transition: height 0.3s;
        display: flex;
        justify-content: stretch;
    }

    .password-strength-group .password-strength-meter .meter-block {
        height: 4px;
        background: #ccc;
        margin-right: 6px;
        flex-grow: 1;
    }

    .password-strength-group .password-strength-meter .meter-block:last-child {
        margin: 0;
    }

    .password-strength-group .password-strength-message {
        font-weight: 20px;
        height: 1em;
        text-align: right;
        transition: all 0.5s;
        margin-top: 3px;
        position: relative;
    }

    .password-strength-group .password-strength-message .message-item {
        font-size: 12px;
        position: absolute;
        right: 0;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .password-strength-group[data-strength="1"] .meter-block:nth-child(-n + 1) {
        background: #cc3d04;
    }

    .password-strength-group[data-strength="1"] .message-item:nth-child(1) {
        opacity: 1;
    }

    .password-strength-group[data-strength="2"] .meter-block:nth-child(-n + 2) {
        background: #ffc43b;
    }

    .password-strength-group[data-strength="2"] .message-item:nth-child(2) {
        opacity: 1;
    }

    .password-strength-group[data-strength="3"] .meter-block:nth-child(-n + 3) {
        background: #9ea60a;
    }

    .password-strength-group[data-strength="3"] .message-item:nth-child(3) {
        opacity: 1;
    }

    .password-strength-group[data-strength="4"] .meter-block:nth-child(-n + 4) {
        background: #289116;
    }

    .password-strength-group[data-strength="4"] .message-item:nth-child(4) {
        opacity: 1;
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
    button#change_password:hover{
        background-color: #6396b1;
        color: #fff;
    }
    .bg-img{
        background-image: url('../assets/images/Change_password_photo.jpg');
        height:100vh;
        background-repeat:no-repeat;
        background-size:cover;
        background-position: 50% 50%;
    }
    body{
        overflow:hidden;
    }
</style>
<section class="bg-greybg vh-100 bg-img m-auto d-flex">
    <div class="container m-auto d-flex">
        <div class="row w-100 justify-content-center py-5">
            <!-- <div class="col-md-6 yelow-bg text-center d-none-mobile">
                <img class="img-fluid m-auto w-75" src="{{ asset('assets/images/img44.png') }}" alt="">
            </div> -->
            <div class="col-md-6 bg-white p-5 ml-auto">
                <div class="text-center">
                    <h2 class="vi-common-clr vi-welcome-size fw-bolder">Change Password</h2>

                    <form id="reg_form" class="validation">
                        @csrf

                        <div class="first-row d-md-flex">
                            <div class="email text-start w-100 m-auto my-3">
                                <label for="email">Old Password <span class="text-danger">*</span></label>
                                <div class="main-password">
                                    <input type="password" id="password" name="current_password"
                                        placeholder="Old Password"
                                        class="form-control form-input form-input-bordered w-full input-password"
                                        aria-label="password">
                                        <a href="JavaScript:void(0);" class="icon-view">
                                            <i class="fa fa-eye-slash"></i>
                                        </a>
                                </div>


                            </div>


                        </div>
                        <div class="first-row d-md-flex">
                            <div class="email text-start w-100 m-auto my-3">
                                <label for="email">New Password <span class="text-danger">*</span><span
                                        class="text-danger"></span></label>
                                <div class="main-password">
                                    <input type="password" id="signupInputPassword" name="new_password"
                                        placeholder="New Password"
                                        class="form-control form-input form-input-bordered w-full input-password"
                                        aria-label="password">
                                        <a href="JavaScript:void(0);" class="icon-view">
                                            <i class="fa fa-eye-slash"></i>
                                        </a>
                                </div>

                            </div>
                        </div>

                        <div class="form-container">


                            <div class="password-strength-group" data-strength="">

                                <div id="password-strength-meter" class="password-strength-meter">
                                    <div class="meter-block"></div>
                                    <div class="meter-block"></div>
                                    <div class="meter-block"></div>
                                    <div class="meter-block"></div>
                                </div>

                                <div class="password-strength-message">
                                    <div class="message-item">
                                        Weak Password
                                    </div>

                                    <div class="message-item">
                                        Okay
                                    </div>

                                    <div class="message-item">
                                        Strong
                                    </div>

                                    <div class="message-item">
                                        Very Strong!
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="submit-btn text-start">
                            <button type="button" class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 w-100"
                                id="change_password">Update</button>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>
</section>



@include('user.layout.footer')

<!--  jquery script  -->
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
<!--  validation script  -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {

        $('#nav_profile').addClass('active');
    });



    $("#change_password").click(function() {

        if (!$("#reg_form").valid()) { // Not Valid
            return false;
        } else {

            var data = $('#reg_form').serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('user.update_password') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#change_password').html('....Please wait');
                },
                success: function(response) {

                    if (response.status == 0) {
                        toastr.error(response.message);
                    } else if (response.status == 1) {
                        toastr.error(response.message);
                    } else {
                        toastr.success(response.message);
                    }

                },
                complete: function(response) {
                    $('#change_password').html('Update');
                }
            });
        }
    });

    $(function() {
        $('#reg_form').validate({
            rules: {

                current_password: {
                    required: true,
                    minlength: 6
                },
                new_password: {
                    required: true,
                    minlength: 6,

                }
            },

        });
    });

    function passwordCheck(password) {
        if (password.length >= 8)
            strength += 1;
        if (password.match(/(?=.*[0-9])/))
            strength += 1;
        if (password.match(/(?=.*[!,%,&,@,#,$,^,*,?,_,~,<,>,])/))
            strength += 1;
        if (password.match(/(?=.*[a-z])/))
            strength += 1;

        displayBar(strength);
    }

    function displayBar(strength) {
        $(".password-strength-group").attr('data-strength', strength);
    }

    $("#signupInputPassword").keyup(function() {
        strength = 0;
        var password = $(this).val();
        passwordCheck(password);
    });

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
</script>
