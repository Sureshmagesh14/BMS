@include('user.layout.header-2')


<section class="bg-greybg vh-100">
        <div class="container">
            <div class="row justify-content-center">
               
                <div class="col-md-3 " style="margin-top: 5% !important;">
                   
                    <div class="position-relative text-center vi-gift-box">
                        <img src="{{ asset('assets/images/gift box.png') }}" class="img-fluid" alt="">
                    </div>

                    <div class="m-auto text-center bg-white py-5 px-3 vi-full-rounded">
                        <h2 class="yelow-clr h1 fw-bolder mt-5">3000<sup>*</sup></h2>
                        <h5>Points Rewards</h5>
                        <p>10 points = 1 ZAR*</p>
                        <button class="btn vi-border-clr text-white vi-dark-blue-bg vi-full-rounded">Request Cash Out</button>
                        <p class="very-sm-text mt-3">* Point value subject to change without notice</p>
                    </div>
                   
                </div>
            </div>
        </div>
    </section>



@include('user.layout.footer')
<script>
$(document).ready(function() {

    $('#nav_rewards').addClass('active');
});
</script>