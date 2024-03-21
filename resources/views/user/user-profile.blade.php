@include('user.layout.header-2')

<section class="bg-greybg vh-100">
     

     <div class="container">
         <div class="row justify-content-center py-5">
            <div class="col-md-6 yelow-bg text-center d-none-mobile">
             <img class="img-fluid m-auto w-75" src="./assets/images/img44.png" alt="">
            </div>
            <div class="col-md-6 bg-white p-5">
             <div class="text-center">
               
                 <div class="first-row d-md-flex">
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
                     <div class="email text-start w-100 m-auto my-3">
                         <label for="email" >Email <span class="text-danger">*</span></label>
                         <input type="text" name="email" placeholder="john@example.com" class="form-control vi-border-clr border-radius-0" id="">
                     
                     </div>
                    
                     
                 </div>
                 <div class="first-row d-md-flex">
                     <div class="email text-start w-100 m-auto my-3">
                         <label for="email" >ID Number \ passport Number (Optional)<span class="text-danger">*</span></label>
                         <input type="text" name="email" placeholder="john@example.com" class="form-control vi-border-clr border-radius-0" id="">
                     </div>
                 </div>
                 <div class="first-row d-md-flex">
                     <div class="dob text-start w-100 m-auto my-3">
                         <label for="dob" >Date of Birth<span class="text-danger">*</span></label>
                         <input type="date" name="dob" placeholder="john@example.com" class="form-control vi-border-clr border-radius-0" id="">
                     </div>
                 </div>
                 <div class="submit-btn text-start">
                     <button class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 w-100">Save</button>
                 </div>
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
