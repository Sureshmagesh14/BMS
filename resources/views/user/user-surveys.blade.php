@include('user.layout.header-2')

 <section class="bg-greybg vh-100">
      <div class="container">
        <div class="row align-items-center justify-content-center pt-5">
          <div class="col-md-2 hide-mobile">
            <img class="img-fluid" src="{{ asset('assets/images/Characters-01.png') }}" alt=""/>
          </div>
          <div class="col-md-3">
            <h3 class="text-center">Basic</h3>
            <div class="bg-white text-center py-5  d-flex flex-column">
              <!-- <div class="completed-items"><span>4/10</span></div> -->
                <div class="w-100">
                  <div class="c100 p20 blue">
                    <span>2/10</span>
                    <div class="slice">
                      <div class="bar"></div>
                      <div class="fill"></div>
                    </div>
                </div>
                </div>
                <div class="columns">
                  <p class="fw-bolder">What would you like to update?</p>
                  <p class="fw-bolder" style="font-size: 12px">
                    CHOOSE EVERYTHING YOU WANT TO UPDATE
                  </p>
                  <div class="d-flex align-items-center flex-column">
                    <button class="btn w-75 mb-4 vi-survey-bl-clr vi-common-clr text-start" style="font-size: 12px;"><i class="fa fa-check-circle vi-common-clr me-3" aria-hidden="true"></i>  Research Studies</button>
                    <button class="btn w-75 border mb-4 text-start " style="font-size: 12px;"><i style="visibility: hidden;" class="fa fa-check-circle vi-common-clr me-3" aria-hidden="true"></i>Short Online Serveys</button>
                  </div>
                  <div class="button">
                    <button class="btn vi-bg-drk text-white px-5 w-75">Next</button>
                  </div>  
                </div>
                

       
            </div>
          </div>
          <div class="col-md-2 hide-mobile">
            <img class="img-fluid" src="{{ asset('assets/images/Characters-02.png') }}" alt="" />
          </div>
        </div>
      </div>
    </section>


@include('user.layout.footer')
<script>
$(document).ready(function() {

    $('#nav_surveys').addClass('active');
});
</script>
