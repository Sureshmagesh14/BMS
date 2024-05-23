@include('user.layout.nomenu-header')
<style>
    .startsurveybtn{
        background:#6396b1;
    }
    .startsurveybtn input{
        color:white;
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

    input#terms{
        height: 1em !important;
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-center align-items-center d-flex">
        <div class="col-md-7 text-center">
            <img src="./assets/images/logo white.png" class="img-fluid mt-5 pt-5 text-center w-50 m-auto" alt="" />
            <h1 class="py-2">Provide your details</h1>
            <h3 class="py-1">Start Survey with us!</h3>
            <form method="POST" id="login_table" action="{{ route('templogin') }}">
                @csrf
                <input type="hidden" name="survey_id" id="survey_id" value="{{$survey->builderID}}"/>
                <div class="row">
                    <div class="col-md-6 m-auto text-start">
                        <label class="" for="email">Email</label>
                        <input type="email" class="form-control vi-border-clr vi-cs-textbox" name="email" id="email"
                            required />
                    </div>
                    <div class="col-md-6 m-auto text-start">
                        <label class="" for="name">Name</label>
                        <input type="text" class="form-control vi-border-clr vi-cs-textbox" name="name" id="name" required />
                    </div>
                </div>
                
                <div class="text-center mt-4 w-50 m-auto startsurveybtn">
                    <input type="submit" value="Start   " class="btn   py-3 px-5 w-100" />
                </div>
            </form>
        </div>
    </div>
</div>

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
    $(function() {
        $('#login_table').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    validate_email: true
                },
                name: {
                    required: true,
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
