@include('front.layout.header')


<div class="container-fluid vh-100">
      <div class="row justify-content-center align-items-center d-flex">
        <div class="col-md-6 vi-nav-bg vh-100 text-center hide-mobile" >
            <img src="{{ asset('public/inc/images/logo white.png') }}" class="img-fluid mt-5 pt-5 text-center w-50 m-auto" alt="" />
            <h1 class="text-white py-5">Welcome!</h1>
            <form action="" method="post">
                <div class="my-3  w-50 m-auto text-start">
                  <label class="text-white" for="email">Email or Mobile</label>
                  <input type="text" class="form-control vi-border-clr vi-reg-textbox" name="email" id="" />
                </div>
                <div  class="my-3 w-50 m-auto text-start">
                  <label class="text-white" for="email">Password</label>
                  <input type="email" class="form-control vi-border-clr vi-reg-textbox" name="" id="" />
                </div>
                <div class="text-center w-50 m-auto">
                    <input type="submit" value="Login" class="btn vi-light-bg text-white py-3 px-5 w-100" />
                  </div>
                <div class="forgetpass text-center my-3 d-flex align-items-center justify-content-center">
                   <p class="p-0 m-0">Forgot your Password?</p> 
                  <a href="" class="nav-link p-0 m-0 ps-1">Click here</a>
                </div>
              
  
               
               
              </form>
        </div>
        <div class="col-md-6">
            <div class="text-center">
               
                <form method="POST" name="Frm_sign" id="Frm_sign" class="validation" action="{{route('user_create')}}">
                @csrf
                    <p>Let's get you started</p>
                    <h3>Join our Database</h3>
                    <div class="first-row d-md-flex mt-5">
                        <div class="name text-start w-48 m-auto">
                            <label for="fname" >First Name <span class="text-danger">*</span></label>
                            <input type="text" name="fname" id="fname" placeholder="Enter First Name" class="form-control vi-border-clr border-radius-0" required>
                        
                        </div>
                        <div class="surname text-start w-48 m-auto">
                            <label for="surname" >Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="surname" id="surname" placeholder="Enter Last Name" class="form-control vi-border-clr border-radius-0" required>
                        </div>
                        
                    </div>
                    <div class="first-row d-md-flex">
                        <div class="mobile text-start w-48 m-auto my-3">
                            <label for="mobile" >Mobile <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" id="mobile" placeholder="Enter Mobile" class="form-control vi-border-clr border-radius-0" required>
                        
                        </div>
                        <div class="lname text-start w-48 m-auto my-3">
                            <label for="whatsapp" >Whatsapp <span class="text-danger">*</span></label>
                            <input type="text" name="whatsapp" id="whatsapp" placeholder="Enter Whatsapp" class="form-control vi-border-clr border-radius-0" required>
                        </div>
                        
                    </div>
                    <div class="first-row d-md-flex">
                        <div class="email text-start w-48 m-auto my-3">
                            <label for="email" >Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" placeholder="Enter Valid Email" class="form-control vi-border-clr border-radius-0" required>
                        
                        </div>
                        <div class="lname text-start w-48 m-auto my-3">
                            <label for="id_passport" >ID \ Passport Number <span class="text-danger"></span></label>
                            <input type="text" name="id_passport" id="id_passport" placeholder="Enter ID Number" class="form-control vi-border-clr border-radius-0" required>
                        </div>
                        
                    </div>
                    <div class="first-row d-md-flex">
                        <div class="date text-start w-48 my-3">
                            <label for="date_of_birth" >Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" name="date_of_birth" id="date_of_birth"  class="form-control vi-border-clr border-radius-0" required>
                        </div>                   
                    </div>
                    <div class="first-row">
                        <div class="date text-start w-48 my-3">
                            <label for="date" >Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" placeholder="Create Password" class="form-control vi-border-clr border-radius-0" required>
                            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm/Retype Password" class="form-control vi-border-clr border-radius-0 my-2" required>
                        </div>                   
                    </div>
                    <div class="submit-btn text-start">

                        <button type="submit" class="btn vi-nav-bg border-radius-0 text-white px-5 py-3" id="respondents_create">Continue</button>
                        
                    </div>

                </form>


            </div>
               
        </div>
      </div>
    </div>

@include('front.layout.footer')
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script  src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js"></script>
<script  src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/additional-methods.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
// - validation
        if ($('#Frm_sign').length > 0) {
            $('#Frm_sign').validate({
                rules: {
                    email: {
                        remote: {
                            url: "{{url("varifyemail")}}",
                            type: "GET",
                            data: {
                                action: function () {
                                    return "1";
                                },
                            }
                        }
                    },
                    password: {
                        equalTo: "#repass"
                    }
                },
                messages: {
                    email: {
                        remote: "Email id already registred"
                    },
                    contact: {
                        remote: "Mobile number already registred",
                        maxlength: "Please enter valid mobile number",
                        minlength: "Please enter valid mobile number"
                    },
                    password: {
                        equalTo: "Password is not equal"
                    }
                },

                submitHandler: function (form) {

                    form.submit();
                },
                errorPlacement: function (error, element) {
                    error.appendTo(element.parent());
                }
            });
        }
    });
</script>
</script>