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
                   

<form name="form" id="x1" method="POST" action="https://paynow.netcash.co.za/site/paynow.aspx" target="_top"> <!---Form POST **--->
<input type="text" name="M1" value="7XXX34c4-XXX-40X8-9f1d-7fbXXXX830d3"> <!--- YOUR PAY NOW SERVICE KEY GOES IN HERE --->
<input type="text" name="M2" value="24ade73c-98cf-47b3-99be-cc7b867b3080"> <!--- SOFTWARE VENDOR KEY GOES IN HERE --->
<input type="text" name="p2" value="ID:123"> <!---Unique ID for this / each transaction--->
<input type="text" name="p3" value="Test / Demo goods"> <!---Description of goods being purchased--->
<input type="text" name="p4" value="5.00"> <!---Amount to be settled / paid--->
<input type="text" name="Budget" value="Y"> <!---Compulsory should be Y--->
<input name="submit" type="submit" value="PAY"> <!---Submit button--->
</form>

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
