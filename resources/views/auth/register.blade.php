@include('user.layout.header-2')

<div class="container-fluid vh-100">
      <div class="row justify-content-center align-items-center d-flex">
        <div class="col-md-6 vi-nav-bg vh-100 text-center hide-mobile" >
            <img src="./assets/images/logo white.png" class="img-fluid mt-5 pt-5 text-center w-50 m-auto" alt="" />
            <h1 class="text-white py-5">Welcome!</h1>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="my-3  w-50 m-auto text-start">
                    <label class="text-white" for="email">Email or Mobile</label>
                    
                    <input type="email" class="form-control vi-border-clr vi-cs-textbox" name="email" id="email" required/>
                    </div>
                    <div  class="my-3 w-50 m-auto text-start">
                    <label class="text-white" for="email">Password</label>

                    <input type="password" placeholder="" class="form-control vi-border-clr vi-cs-textbox" name="password" required/>
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
                <form method="POST" action="{{ route('register') }}">
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
                        <div class="mobile text-start w-48 m-auto my-3">
                            <label for="mobile" >Mobile <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" id="mobile" placeholder="081 966 0786" class="form-control vi-border-clr border-radius-0" required>
                        
                        </div>
                        <div class="lname text-start w-48 m-auto my-3">
                            <label for="whatsapp" >Whatsapp <span class="text-danger">*</span></label>
                            <input type="text" name="whatsapp" id="whatsapp" placeholder="081 966 0786" class="form-control vi-border-clr border-radius-0" required>
                        </div>
                        
                    </div>
                    <div class="first-row d-md-flex">
                        <div class="email text-start w-48 m-auto my-3">
                            <label for="email" >Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" id="email" placeholder="john@example.com" class="form-control vi-border-clr border-radius-0" required>
                        
                        </div>
                        <div class="lname text-start w-48 m-auto my-3">
                            <label for="id_passport" >ID Number\ Passport <span class="text-danger">*</span></label>
                            <input type="text" name="id_passport" id="id_passport" placeholder="Valid RSA ID number or Passport number" class="form-control vi-border-clr border-radius-0" id="">
                        </div>
                        
                    </div>
                    <div class="first-row d-md-flex">
                        <div class="date text-start w-48 my-3">
                            <label for="date_of_birth" >Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" name="date_of_birth" id="date_of_birth" placeholder="dd/mm/yyyy" class="form-control vi-border-clr border-radius-0" required>
                        </div>                   
                    </div>
                    <div class="first-row">
                        <div class="date text-start w-48 my-3">
                            <label for="date" >Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" placeholder="Create Password" class="form-control vi-border-clr border-radius-0" required>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm/Retype Password" class="form-control vi-border-clr border-radius-0 my-2" required>
                        </div>                   
                    </div>
                    <div class="submit-btn text-start">
                        <button class="btn vi-nav-bg border-radius-0 text-white px-5 py-3">Continue</button>
                    </div>
                </form>
            </div>
               
        </div>
      </div>
    </div>


@include('user.layout.footer')

@if(count($errors) > 0)
    @foreach( $errors->all() as $message )
        <script>
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.error("{{ $message }}");
        </script>
    @endforeach
@endif