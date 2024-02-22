@include('front.layout.header')

<div class="container-fluid vh-100">
      <div class="row">
        <div class="col-md-6 d-none-mobile" >
          <img src="{{ asset('public/inc/images/group-afro-americans-working-together.jpg') }}" class="img-fluid vh-100" alt="" />
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="rightside text-center"  >
            <img src="{{ asset('public/inc/images/small-logo.png') }}" class="img-fluid w-50 m-auto mb-4" alt="" />
            <h2 class="vi-common-clr vi-welcome-size fw-bolder">Welcome!</h2>
            <p>Login with email or Mobile</p>
            <form action="" method="post">
              <div class="my-3  w-75 m-auto">
                <label class="email-start vi-common-clr" for="email">Email ID/Mobile</label>
                <input type="text" class="form-control vi-border-clr vi-cs-textbox" name="email" id="" />
              </div>
              <div  class="my-3 w-75 m-auto">
                <label class="pass-start vi-common-clr" for="email text-start">Password</label>
                <input type="email" class="form-control vi-border-clr vi-cs-textbox" name="" id="" />
              </div>
              <div class="forgetpass me-5">
                <a href="" class="nav-link text-end me-5">Forgot your Password?</a>
              </div>
              <div class="mobile-space">
                <input type="submit" value="Login" class="btn vi-nav-bg text-white py-3 px-5" />
              </div>

             
             
            </form>
            <div class="vi-horizo-line my-5 w-25 m-auto">
              <span class="vi-bdr-set-or position-relative px-3">OR</span>
            </div>
            <div class="regaccount ">
              <p class="d-flex align-items-center justify-content-center">Don't have account ? <a class="ps-2 nav-link fw-500" href="{{route('userregister')}}">Register</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>

@include('front.layout.footer')