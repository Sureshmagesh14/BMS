@include('user.layout.header-2')

<section class="bg-greybg vh-100">
     

     <div class="container">
         <div class="row justify-content-center py-5">
            <div class="col-md-6 yelow-bg text-center d-none-mobile">
             <img class="img-fluid m-auto w-75" src="./assets/images/img44.png" alt="">
            </div>
            <div class="col-md-6 bg-white p-5">
             <div class="text-center">
               
             <form id="bank_form" class="validation" action="{{ route('bank_save') }}" method="post">
                @csrf

                <div class="first-row d-md-flex text-center">
                <div><img class="w-5 me-2 ms-3 my-3" src="http://localhost/bms_new/public/user/images/icons/1c-07.png" alt=""> <span class="small-font-sm">Update Bank Info</span> </div>
                </div>
                 <div class="first-row d-md-flex">
                     <div class="email text-start w-100 m-auto my-3">
                         <label for="email" >Account Type <span class="text-danger">*</span></label>
                         
                         <select name="account_type" id="account_type" class="form-control" required>
                            <option value="">Select Type</option>                            
                            <option value="1" @if ($bank_data->account_type == 1) selected @endif >EFT</option>  
                            <option value="2" @if ($bank_data->account_type == 2) selected @endif >Data</option>  
                            <option value="3" @if ($bank_data->account_type == 3) selected @endif >Airtime</option>  
                            <option value="4" @if ($bank_data->account_type == 4) selected @endif >Donation</option>                            
                        </select>

                     </div>   
                 </div>

                 <div class="first-row d-md-flex">
                     <div class="email text-start w-100 m-auto my-3">
                         <label for="email" >Branch <span class="text-danger">*</span></label>
                         
                        <select name="bank_name" id="bank_name" class="form-control" required>
                            <option value="">Select Bank</option>
                            @foreach($bank_list as $bank)
                            <option value="{{$bank->id}}" @if ($bank->id ==$bank_data->bank_name) selected @endif >{{$bank->bank_name}} ({{$bank->branch_code}}) </option>
                            @endforeach
                        </select>
                     </div>   
                 </div>

                 <div class="first-row d-md-flex">
                     <div class="account_holder text-start w-100 m-auto my-3">
                         <label for="account_holder" >Account Name<span class="text-danger">*</span></label>
                         <input type="text" name="account_holder" id="account_holder" placeholder="Holder Name" class="form-control vi-border-clr border-radius-0" value="{{$bank_data->account_holder}}" required>
                     </div>
                 </div>

                 <div class="first-row d-md-flex">
                     <div class="email text-start w-100 m-auto my-3">
                         <label for="email" >Account Number<span class="text-danger">*</span></label>
                         <input type="text" name="account_number" id="account_number" placeholder="Account Number" class="form-control vi-border-clr border-radius-0" value="{{$bank_data->account_number}}" required>
                     </div>
                 </div>

                
                 <div class="submit-btn text-start">
                     <button type="submit" class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 w-100">Save</button>
                 </div>

                 </form>
             </div>
                
         </div>
         </div>
     </div>
 </section>



@include('user.layout.footer')
<script>
$(document).ready(function() {

    $('#nav_profile').addClass('active');
});
</script>
