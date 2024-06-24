@include('front.layout.nomenu-header')

<div class="container-fluid">
      <div class="row justify-content-center align-items-center d-flex">
        <div class="col-md-6 vi-nav-bg text-center hide-mobile p-0 m-0" >
          
            <img src="{{ asset('public/inc/images/group-afro-americans-working-together.jpg') }}" class="img-fluid vh-100" alt="" />
          
            <!-- <img src="./assets/images/logo white.png" class="img-fluid mt-5 pt-5 text-center w-50 m-auto" alt="" />
            <h1 class="text-white py-5">Welcome!</h1> -->
            <form action="" method="post" class="d-none">
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
                  <a href="{{route('userlogin')}}" class="nav-link p-0 m-0 ps-1">Click here</a>
                </div>
              
  
               
               
              </form>
        </div>
        <div class="col-md-6 ">
            <div class="text-center">
                <p>Let's get you started</p>
                <!-- <h3>Join our Database</h3> -->

                <form id="users_form" class="validation">
                @csrf
                    <div class="first-row d-md-flex mt-5">
                        <div class="fname text-start w-48 m-auto">
                            <label for="name" >First Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" placeholder="John" class="form-control vi-border-clr border-radius-0" required>
                        
                        </div>
                        <div class="lname text-start w-48 m-auto">
                            <label for="surname" >Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="surname" id="surname" placeholder="Doe" class="form-control vi-border-clr border-radius-0" required>
                        </div>
                        
                    </div>
                    <div class="first-row d-md-flex">
                        <div class="mobile text-start w-48 m-auto my-3 position-relative">
                            <label for="mobile" >Mobile <span class="text-danger">*</span></label>
                            <span class="bg-white vi-mobile-code position-absolute">+21</span>
                            <input type="text" name="mobile" id="mobile" placeholder="081 966 0786" class="form-control vi-border-clr border-radius-0 vi-mobile-input" required>
                        
                        </div>
                        <div class="lname text-start w-48 m-auto my-3 position-relative">
                            <label for="whatsapp" >Whatsapp <span class="text-danger">*</span></label>
                            <span class="bg-white vi-mobile-code position-absolute">+21</span>
                            <input type="text" name="whatsapp" id="whatsapp" placeholder="081 966 0786" class="form-control vi-border-clr border-radius-0 vi-mobile-input" required>
                        </div>
                        
                    </div>
                    <div class="first-row d-md-flex">
                        <div class="email text-start w-48 m-auto my-3">
                            <label for="email" >Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" id="email" placeholder="john@example.com" class="form-control vi-border-clr border-radius-0" required>
                        
                        </div>
                        <div class="lname text-start w-48 m-auto my-3">
                            <label for="id_passport" >ID Number \ Passport Number (Opt) <span class="text-danger"></span></label>
                            <input type="text" name="id_passport" id="id_passport" placeholder="Valid RSA ID number or Passport number" class="form-control vi-border-clr border-radius-0" >
                        </div>
                        
                    </div>
                    <div class="first-row d-md-flex">
                        <div class="date text-start w-48 my-3">
                            <label for="date_of_birth" >Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control vi-border-clr border-radius-0" required>
                        
                        </div>  
                        <div class="lname text-start w-48 m-auto my-3">
                        <label for="password" >Password<span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" placeholder="Create Password" class="form-control vi-border-clr border-radius-0" required>
                    </div>                 
                    </div>
                    <div class="first-row">
                        <div class="cpassword text-start w-48 my-3">
                        
                            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm/Retype Password" class="form-control vi-border-clr border-radius-0 my-2" required>
                        </div>                   
                    </div>
                    <div class="submit-btn text-center m-auto d-flex flex-column">
                        <button type="button" id="users_create" class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 m-auto" id="respondents_create">Continue</button>
                        <a class="nav-link mt-2" href="{{route('userlogin')}}" >Already have Account? Login Here</a>
                    </div>
                </form>
            </div>
               
        </div>
      </div>
    </div>

@include('front.layout.footer')
<script src="{{ asset('public/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/assets/js/admin/jquery.validate.js') }}"></script>
<script>

$("#respondents_create").click(function () {

    
    if (!$("#reg_form").valid()) { // Not Valid
        return false;
    } else {
        
        var data = $('#reg_form').serialize();
        $.ajax({
            type: 'POST',
            url: "{{ route('user_create') }}",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                //$('#respondents_create').html('....Please wait');
            },
            success: function(response) {
                alert("succsess");
                // toastr.success(response.message);
                // $("#commonModal").modal('hide');
                // datatable();
            },
            complete: function(response) {
                //$('#respondents_create').html('Create New');
            }
        });
    }
});
$(function() {
        $('#users_form').validate({
           
        });
    });
$("#users_create").click(function() {
        if (!$("#users_form").valid()) { // Not Valid
            return false;
        } 
    });
</script>