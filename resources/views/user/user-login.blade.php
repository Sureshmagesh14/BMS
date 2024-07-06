@include('front.layout.nomenu-header')


<div class="container-fluid vh-100">
      <div class="row">
        <div class="col-md-6 d-none-mobile" >
          <img src="{{ asset('public/inc/images/group-afro-americans-working-together.jpg') }}" class="img-fluid vh-100" alt="" />
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="rightside text-center"  >
            <img src="{{ asset('public/inc/images/small-logo.png') }}" class="img-fluid w-50 m-auto mb-4" alt="" />
            <h2 class="vi-common-clr vi-welcome-size fw-bolder">Welcome Back</h2>
            <p>Login with your email address</p>
            <form action="" method="post">
              <div class="my-3  w-75 m-auto">
                <label class="email-start vi-common-clr" for="email">Email Address</label>
                <input type="text" class="form-control vi-border-clr vi-cs-textbox" name="email" id="" placeholder="Enter your Email Address" />
              </div>
              <div  class="my-3 w-75 m-auto">
                <label class="pass-start vi-common-clr" for="email text-start">Password</label>
                <input type="email" placeholder="" class="form-control vi-border-clr vi-cs-textbox" name="" id="" />
              </div>
              <div class="forgetpass me-5">
                <a href="" class="nav-link text-end me-5 my-2">Forgot Password?</a>
              </div>
              <div class="mobile-space">
                <input type="submit" value="Login" class="btn vi-nav-bg text-white py-3 px-5" />
              </div>

             
             
            </form>
            <div class="vi-horizo-line my-5 w-25 m-auto">
              <span class="vi-bdr-set-or position-relative px-3">OR</span>
            </div>
            <div class="regaccount ">
              <p class="d-flex align-items-center justify-content-center"><a class="ps-2 nav-link fw-500" href="{{route('userregister')}}">Don't have an account? Register now</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>


@include('front.layout.footer')