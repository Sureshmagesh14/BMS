@include('front.layout.header')

<div class="container-fluid p-md-5 text-white text-center vi-full-height" style="background-size: cover; height:auto;">
  <div class="row">
    <div class="col-md-7 col-sm-12">
      <img src="{{ asset('public/inc/images/small-logo.png') }}" class="img-fluid w-50 m-auto hide-mobile" alt="">
      <h1 class="fw-boler vi-get-paid-head text-shadow fw-bolder">Get  PAID for your opinion!</h1>
      <p class="vi-bnr-para-text text-shadow">join our growing south african community and earn rewards for your feedback</p>
      <div class="d-flex align-items-center flex-column">
       <a href="{{route('userregister')}}"> 
        <button class="btn vi-nav-bg text-white w-md-25 m-auto my-2 text-uppercase vi-main-btn-db">Join our Database </button>
       </a> 
       <a href="{{route('userlogin')}}">
       <button class="btn w-md-25 m-auto bg-white vi-common-clr text-uppercase vi-main-bnr-login">Login </button>
       </a>
      </div>
      <img src="{{ asset('public/inc/images/small-logo.png') }}" class="img-fluid w-50 m-auto show-mobile" alt="">
      
    </div>
  </div>

</div>
  
@include('front.layout.footer')