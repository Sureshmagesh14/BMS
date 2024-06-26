@include('user.layout.header')

<div class="container-fluid p-md-5 text-white text-center vi-full-height vi-background-index"
    style="background-size: cover; height:auto;">

    @if(isset($data->name) && ($data->name!=''))
    <div class="alert alert-info bs-alert-old-docs text-center">
      <strong>Referred</strong> by <span style="text-transform: capitalize;">{{$data->name}}</span>
    </div>
    @endif
    
    <div class="row">
        <div class="col-md-6 col-sm-12 m-auto mob-hide">
        <img src="{{ asset('assets/images/img_2.png') }}" class="img-fluid w-75 m-auto hide-mobile"
                        alt="">
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="d-flex align-items-center flex-column justify-content-between">
                <!-- <div class="logo">
                    <img src="{{ asset('user/images/small-logo.png') }}" class="img-fluid w-50 m-auto hide-mobile"
                        alt="">
                </div> -->
                <div class="heading">
                    <h1 class="fw-boler vi-get-paid-head text-shadow fw-bolder">Get PAID for your opinion!</h1>
                </div>
                <div class="description">
                    <p class="vi-bnr-para-text text-shadow">Join 40 000 South Africans and 
make extra money.</p>
                </div>
                <div class="btn-class-bnr">
                    <div class="d-flex align-items-center flex-column">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="w-100">
                                <button
                                    class="w-100 btn vi-nav-bg text-white w-md-25 m-auto my-2 text-uppercase vi-main-btn-db">Join
                                    our Database </button>
                            </a>
                        @endif

                        <a href="{{ route('login') }}"  class="w-100">
                            <button
                                class="w-100 btn w-md-25 m-auto bg-white vi-common-clr text-uppercase vi-main-bnr-login">Login
                            </button>
                        </a>
                    </div>
                </div>
                <div class="logo show-mobile">
                    <img src="{{ asset('user/images/small-logo.png') }}" class="img-fluid w-50 m-auto show-mobile"
                        alt="">
                </div>
            </div>
        </div>
    </div>
</div>

@include('user.layout.footer')
