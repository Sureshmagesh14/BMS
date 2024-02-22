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
                <p>Let's get you started</p>
                <h3>Join our Database</h3>
                <div class="first-row d-md-flex mt-5">
                    <div class="fname text-start w-48 m-auto">
                        <label for="fname" >First Name <span class="text-danger">*</span></label>
                        <input type="text" name="fname" placeholder="John" class="form-control vi-border-clr border-radius-0" id="">
                    
                    </div>
                    <div class="lname text-start w-48 m-auto">
                        <label for="fname" >Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="lname" placeholder="Doe" class="form-control vi-border-clr border-radius-0" id="">
                    </div>
                    
                </div>
                <div class="first-row d-md-flex">
                    <div class="mobile text-start w-48 m-auto my-3">
                        <label for="mobile" >Mobile <span class="text-danger">*</span></label>
                        <input type="text" name="mobile" placeholder="John" class="form-control vi-border-clr border-radius-0" id="">
                    
                    </div>
                    <div class="lname text-start w-48 m-auto my-3">
                        <label for="whatsapp" >Whatsapp <span class="text-danger">*</span></label>
                        <input type="text" name="whatsapp" placeholder="081 966 0786" class="form-control vi-border-clr border-radius-0" id="">
                    </div>
                    
                </div>
                <div class="first-row d-md-flex">
                    <div class="email text-start w-48 m-auto my-3">
                        <label for="email" >Email <span class="text-danger">*</span></label>
                        <input type="text" name="email" placeholder="john@example.com" class="form-control vi-border-clr border-radius-0" id="">
                    
                    </div>
                    <div class="lname text-start w-48 m-auto my-3">
                        <label for="whatsapp" >Whatsapp <span class="text-danger">*</span></label>
                        <input type="text" name="whatsapp" placeholder="081 966 0786" class="form-control vi-border-clr border-radius-0" id="">
                    </div>
                    
                </div>
                <div class="first-row d-md-flex">
                    <div class="date text-start w-48 my-3">
                        <label for="date" >Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" name="date"  class="form-control vi-border-clr border-radius-0" id="">
                    </div>                   
                </div>
                <div class="first-row">
                    <div class="date text-start w-48 my-3">
                        <label for="date" >Password<span class="text-danger">*</span></label>
                        <input type="password" name="date" placeholder="Create Password" class="form-control vi-border-clr border-radius-0" id="">
                        <input type="password" name="date" placeholder="Confirm/Retype Password" class="form-control vi-border-clr border-radius-0 my-2" id="">
                    </div>                   
                </div>
                <div class="submit-btn text-start">
                    <button class="btn vi-nav-bg border-radius-0 text-white px-5 py-3">Continue</button>
                </div>
            </div>
               
        </div>
      </div>
    </div>

@include('front.layout.footer')