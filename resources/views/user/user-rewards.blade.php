@include('user.layout.header-2')
<style>
.pos-bottom{
   bottom: 0px;
    left: 25px;
}
.w-75{
   width: 75%;
}
.vi-background-index.position-relative{
   border:1px solid #90b8d0; 
}
</style>

<section class="vi-background-index  position-relative">
       <div class="w-50 my-auto position-absolute pos-bottom mob-hide">
                   <img class="w-75" src="{{ asset('assets/images/ima_3.webp') }}" class="img-fluid" alt="">
                </div>
    <div class="container">
       <div class="row justify-content-center mb-10vh">
          <div class="col-md-10 m-auto h-100vh" style="">
             <!-- margin-top: 5% !important; -->
             <div class="w-100 ">
               
                <div class="m-auto text-center bg-white py-2 my-2 px-3 vi-full-rounded">
                   <div class=" text-center w-25 vi-gift-box m-auto">
                      <img src="{{ asset('assets/images/gift box.png') }}" class="img-fluid w-100" alt="">
                   </div>
                   <div class="w-75 ml-auto d-flex d-sm-flex">
                      <div class="w-50">
                         @if($get_cashout == null)
                         <h2 class=" h1 fw-bolder mt-2">Your available rewards</h2>
                         <h2 class="yelow-clr h1 fw-bolder mt-2">{{ $get_reward }} <span>Points</span> </h2>
                         <p>10 points = R1</p>
                         @if($get_reward >= 40)
                         <button type="button" class="btn btn-yellow width-fit-content d-flex" id="request_press"
                            data-url="{{ route('cashout_form') }}" data-size="xl" data-ajax-popup="true"
                            data-bs-original-title="{{ __('Cashout Process') }}" data-bs-toggle="tooltip" data-value="{{ $get_reward }}">
                         Request Cash Out
                         </button>
                         @endif
                         <!-- <p class="very-sm-text mt-3" style="text-align: left;">* Points value automatically change to Monetary value</p> -->
                         <!-- <p class="very-sm-text mt-3" style="text-align: left;">* Cash Outs not made expire at the end of the year and will not be re-rewarded!</p> -->
                         @else
                         <h2 class="yelow-clr h1 fw-bolder mt-5"> @if($get_cashout->type_id == 1) Pending @elseif($get_cashout->type_id == 2)Processing @endif</h2>
                         <h5>@if($get_cashout->amount != 0){{$get_cashout->amount / 10}} ZAR @endif</h5>
                         @endif
                      </div>
                      <div class="w-50">
                         @if($get_cashout == null)
                         <h2 class=" h1 fw-bolder mt-2">Your reward history</h2>
                         <div class="d-flex w-100">
                            <div class="col-5 col-xs-6 rounded m-1">
                               <div class="bg-grey-6 p-2 m-2 w-100 h-100p rounded">
                                  <div class="bg-yellow text-white p-2 w-100 rounded mt-2 text-center m-auto">{{$get_overrall_rewards}}</div>
                                  <div class="down-triangle-yellow triangle"></div>
                                  <div class="my-2">Total Rewards since {{ \Carbon\Carbon::now()->year }}</div>
                               </div>
                            </div>
                            <div class="col-5 col-xs-6 rounded m-1">
                               <div class="bg-grey-6 p-2 m-2 w-100 h-100p rounded">
                                  <div class="bg-blue text-white p-2 w-100 rounded mt-2 text-center m-auto">{{$get_current_rewards}}</div>
                                  <div class="down-triangle-blue triangle"></div>
                                  <div class="my-2">Total Rewards this year</div>
                               </div>
                            </div>
                         </div>
                         @endif
                      </div>
                   </div>
                   <div class="w-50 ml-auto">
                      <div class="w-100">
                      </div>
                      <h2 class="text-left mt-3">T's and C's</h2>
                      <ul>
                         <li class=" mt-3" style="text-align: left;">
                            We have to use points because we are not a bank - these will change to rands
                            when you get paid (10 points = R1)
                         </li>
                         <li class=" mt-3" style="text-align: left;">
                            You can only cash out when you have 400 points (R40) or more
                         </li>
                         <li class=" mt-3" style="text-align: left;">
                            Points expire 1 year after being rewarded (please see Ts and Cs)
                         </li>
                         <li class=" mt-3" style="text-align: left;">
                            We pay for your banking details to be encrypted and securely stored additional safety
                         </li>
                      </ul>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>

<!-- <form name="form" id="x1" method="POST" action="https://paynow.netcash.co.za/site/paynow.aspx" target="_top">
<input type="hidden" name="M1" value="600d1709-9d70-493f-89fa-559b5720ff46">
<input type="hidden" name="M2" value="24ade73c-98cf-47b3-99be-cc7b867b3080">
<input type="hidden" name="p2" value="ID:1234">
<input type="hidden" name="p3" value="Test / Demo goods">
<input type="hidden" name="p4" value="5.00">
<input type="hidden" name="Budget" value="Y">
<input name="submit" type="submit" value="PAY">
</form>  -->

<!-- <form name="form" id="x1" method="POST" action="https://paynow.netcash.co.za/site/paynow.aspx" target="_top">
<input type="hidden" name="M1" value="d5b32568-2a7e-4a5d-9de4-5d27ca8b39c8"> YOUR PAY NOW SERVICE KEY GOES IN HERE
<input type="hidden" name="M2" value="24ade73c-98cf-47b3-99be-cc7b867b3080"> SOFTWARE VENDOR KEY GOES IN HERE
<input type="hidden" name="p2" value="ID:123"> Unique ID for this / each transaction
<input type="hidden" name="p3" value="Test / Demo goods"> Description of goods being purchased
<input type="hidden" name="p4" value="5.00"> Amount to be settled / paid
<input type="hidden" name="Budget" value="Y"> Compulsory should be Y
<input name="submit" type="submit" value="PAY"> Submit button
</form> -->

@include('user.layout.footer')
<script>
    $(document).ready(function() {

        $('#nav_rewards').addClass('active');
    });

    $("#request_press").click(function() {
        $(this).hide();
    });
</script>
