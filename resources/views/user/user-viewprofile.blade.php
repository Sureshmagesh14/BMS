@include('user.layout.header-2')

<section class="bg-greybg vh-100">
     

     <div class="container">
         <div class="row justify-content-center py-5">
            <div class="col-md-6 yelow-bg text-center d-none-mobile">
             <img class="img-fluid m-auto w-75" src="{{ asset('assets/images/img44.png') }}" alt="">
            </div>
            <div class="col-md-6 bg-white p-5">
             <div class="text-center">
               
            <form id="reg_form" class="validation">
            @csrf
                 <div class="first-row d-md-flex">
                     <div class="fname text-start w-48 m-auto">
                         <label for="fname" >First Name <span class="text-danger">*</span></label>
                         <input type="text" name="name" id="name" placeholder="John" value="{{$data->name}}" class="form-control vi-border-clr border-radius-0" required> 
                     
                     </div>
                     <div class="lname text-start w-48 m-auto">
                         <label for="fname" >Last Name <span class="text-danger">*</span></label>
                         <input type="text" name="surname" id="surname" placeholder="Doe" value="{{$data->surname}}" class="form-control vi-border-clr border-radius-0" required>
                     </div>
                     
                 </div>
                 <div class="first-row d-md-flex">
                     <div class="mobile text-start w-48 m-auto my-3">
                         <label for="mobile" >Mobile <span class="text-danger">*</span></label>
                         <input type="text" name="mobile" id="mobile" placeholder="Mobile" value="{{$data->mobile}}"  class="form-control vi-border-clr border-radius-0" required> 
                     
                     </div>
                     <div class="lname text-start w-48 m-auto my-3">
                         <label for="whatsapp" >Whatsapp <span class="text-danger">*</span></label>
                         <input type="text" name="whatsapp" id="whatsapp" placeholder="081 966 0786" value="{{$data->whatsapp}}"  class="form-control vi-border-clr border-radius-0" required>
                     </div>
                     
                 </div>
                 <div class="first-row d-md-flex">
                     <div class="email text-start w-100 m-auto my-3">
                         <label for="email" >Email <span class="text-danger">*</span></label>
                         <input type="text" name="email" id="email" placeholder="john@example.com" value="{{$data->email}}"  class="form-control vi-border-clr border-radius-0" readonly="" style="background:#E5E5E5;">
                     
                     </div>
                    
                     
                 </div>
                 <div class="first-row d-md-flex">
                     <div class="email text-start w-100 m-auto my-3">
                         <label for="email" >ID Number \ passport Number (Optional)<span class="text-danger"></span></label>
                         <input type="text" name="id_passport" id="id_passport" placeholder="ID Number"  value="{{$data->id_passport}}"  class="form-control vi-border-clr border-radius-0" >
                     </div>
                 </div>
                 <div class="first-row d-md-flex">
                     <div class="dob text-start w-100 m-auto my-3">
                         <label for="dob" >Date of Birth<span class="text-danger">*</span></label>
                         <input type="date" name="date_of_birth" id="date_of_birth" placeholder="Date of Birth"  value="{{$data->date_of_birth}}" class="form-control vi-border-clr border-radius-0" required>
                     </div>
                 </div>
                 <div class="submit-btn text-start">
                 <button type="button" class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 w-100" id="respondents_create">Save</button>
                 </div>

                 </form>
             </div>
            
                
         </div>
         </div>
     </div>
 </section>



@include('user.layout.footer')

<!--  jquery script  -->
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
<!--  validation script  -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {

    $('#nav_profile').addClass('active');
});


    $("#respondents_create").click(function () {
    
        if (!$("#reg_form").valid()) { // Not Valid
            return false;
        } else {
            
            var data = $('#reg_form').serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('user_update') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#respondents_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    // toastr.success(response.message);
                    // $("#commonModal").modal('hide');
                    // datatable();
                },
                complete: function(response) {
                    //$('#respondents_create').html('Create New');
                }
            });
        }
    });



</script>
