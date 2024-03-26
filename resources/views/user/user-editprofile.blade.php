@include('user.layout.header-2')
<section class="bg-greybg">
<br>
<main class="my-5">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section">
              <h3 class="fw-bold mb-4">Profile</h3>
              <p>Account</p>
              <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <div class="d-flex flex-column">
                        <div><h2 style="text-transform: capitalize;"> {{$data->name}} {{$data->surname}}</h2> </div>
                        <div>
                          <span>{{$data->email}}</span> <span class="mx-2">|</span><span>{{$data->id_passport}}</span>
                        </div>
                        <div class="mt-2">
                          <span>+{{$data->mobile}}</span> <span class="mx-2">|</span><span>+{{$data->whatsapp}}</span>
                        </div>
                      </div>
                      
                    </button>
                  </h2>
                 
               
              </div>
             
            </div>
            <div class="section my-3 py-3">
          @foreach ($profil as $pro)
            
        
            <!-- starts -->
              <p>Basic</p>
              
            
              <div class="accordion accordion-flush" id="accordionFlushExample">
            
              
                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                      <div class="d-flex flex-column">
                        <p class="fs-16 fw-bold"></p>
                        <span class="fs-12">Last update March 26, 2024</span>
                       </div>
                    </button>
                  </h2>
                  <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Place the content you want</div>
                  </div>
                </div>
            </div>
            @endforeach
            <!-- ends -->
          </div>
        </div>
      </div>
    </main>
</section>

@include('user.layout.footer')
<script>
$(document).ready(function() {

    $('#nav_profile').addClass('active');
});
</script>
