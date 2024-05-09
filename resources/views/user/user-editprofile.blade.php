@include('user.layout.header-2')
<style>
  a {
  text-decoration: none;
}
</style>

<section class="bg-greybg">

  <!-- code pen customized starts -->
  <!-- <div class="container-fluid px-1 py-5 mx-auto">
    <div class="row d-flex justify-content-center">
      <div class="col-12 col-md-11 col-lg-10 col-xl-9">
        <div class="card card0 border-0">
          <div class="row">
            <div class="col-12">
              <div class="card card00 border-0">
                <div class="row text-center justify-content-center px-3">
                  <p class="prev text-start common-yellow"><span class="fa fa-long-arrow-left"> Go Back</span></p id="back">
                  <h3 class="mt-4">Update Profile</h3>
                </div>
                <div class="d-flex flex-md-row px-3 mt-4 flex-column-reverse">
                  <div class="col-md-3">
                    <div class="card1">
                      <ul id="progressbar" class="text-center">
                        <li class="active step0"></li>
                        <li class="step0"></li>
                        <li class="step0"></li>
                        <li class="step0"></li>
                      </ul>
                      <h6 class="mb-5">Basic</h6>
                      <h6 class="mb-5">Set password</h6>
                      <h6 class="mb-5">Select your country</h6>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="card2 first-screen show ml-2">
                      <div class="row">
                      <div class="col-md-3 text-center box-border-grey box-border-yellow">
                        <img src="./assets/images/icons-01.png" class="img-fluid w-25" alt="">
                        <p>what type of research do you want to do?</p>
                    </div>
                    <div class="col-md-3 text-center box-border-grey">
                        <img src="./assets/images/icons-05.png" class="img-fluid w-25" alt="">
                        <p>About me</p>
                    </div>
                    <div class="col-md-3 text-center box-border-grey">
                        <img src="./assets/images/icons-06.png" class="img-fluid w-25" alt="">
                        <p>Employment</p>
                    </div>
                      </div>
                      
                      <div class="row px-3 mt-4">
                        <div class="next-button text-center mt-1 ml-2 mb-5"> <span class="fa fa-arrow-right"></span> </div>
                      </div>
                      
                    </div>
                    <div class="card2 ml-2">
                      <div class="row px-3 mt-3"> 

                        <div class="col-md-3 text-center box-border-grey box-border-yellow">
                          <img src="./assets/images/icons-01.png" class="img-fluid w-25" alt="">
                          <p>what type of research do you want to do?</p>
                      </div>
                      <div class="col-md-3 text-center box-border-grey">
                          <img src="./assets/images/icons-05.png" class="img-fluid w-25" alt="">
                          <p>About me</p>
                      </div>
                      <div class="col-md-3 text-center box-border-grey">
                          <img src="./assets/images/icons-06.png" class="img-fluid w-25" alt="">
                          <p>Employment</p>
                      </div>
                      <div class="next-button text-center mt-1 ml-2 mb-5"> <span class="fa fa-arrow-right"></span> </div>
                      </div>
                      
                    </div>
                    <div class="card2 ml-2">
                      <div class="row px-3 mt-3">
                        
                        <div class="col-md-3 text-center box-border-grey box-border-yellow">
                          <img src="./assets/images/icons-01.png" class="img-fluid w-25" alt="">
                          <p>what type of research do you want to do?</p>
                      </div>
                      <div class="col-md-3 text-center box-border-grey">
                          <img src="./assets/images/icons-05.png" class="img-fluid w-25" alt="">
                          <p>About me</p>
                      </div>
                      <div class="col-md-3 text-center box-border-grey">
                          <img src="./assets/images/icons-06.png" class="img-fluid w-25" alt="">
                          <p>Employment</p>
                      </div>
                        <div class="next-button text-center mt-3 ml-2 mb-5"> <span class="fa fa-arrow-right"></span> </div>
                      </div>
                    </div>
                    <div class="card2 ml-2">
                      <div class="row px-3 mt-2 mb-4 text-center">
                        <h2 class="col-12 text-danger"><strong>Success !</strong></h2>
                        <div class="col-12 text-center"><img class="tick" src="https://i.imgur.com/WDI0da4.gif"></div>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row px-3">
                  <h2 class="text-muted get-bonus mt-4 mb-5">Get Bonus <span class="text-danger">666</span> cookies</h2> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <!-- code pend customized ends -->
  

  <br>
<main class="my-5">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section">
              <h3 class="fw-bold mb-4">Profile</h3>
              <p>Account</p>
              <div class="accordion" id="accordionExample">
              <a href="{{ route('user.viewprofile') }}">
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
              </a>

            </div>
            <div class="section my-3 py-3">
          @php 
          $cat = '';
          $catname = array(1=>'Basic',2=>'Essential',3=>'Extended');

          //dd($prof_response);
          @endphp
          
          @foreach ($profil as $pro)
            

           
            <!-- starts -->
            @if($pro->builderID!='')

              @if($cat!=$pro->type_id)
              <p>{{ $catname[$pro->type_id] }}</p>
              @endif
              
          
              <div class="accordion accordion-flush" id="accordionFlushExample">
              @if($pro->totq==$pro->tota)
              <a>
              @else 
              <a href="{{ url('survey/view',$pro->builderID) }}">
              @endif
                
                <div class="accordion-item">
                 
                    <h2 class="accordion-header" id="flush-headingTwo">
                    
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        <div class="d-flex flex-column">
                          <p class="fs-16 fw-bold">{{$pro->name}}  - {{$pro->totq}} = {{$pro->tota}}</p>
                          @if($pro->totq==$pro->tota)
                              <span class="fs-12 text-success">
                                Completed
                              </span>
                          @else 

                              @if($pro->updated_at!='')
                              <span class="fs-12">
                                Last update {{ date('M d,Y', strtotime($pro->updated_at)) }}  
                              </span>
                              @else
                              <span class="fs-12 text-danger">
                                Incomplete
                              </span>
                              @endif 

                        @endif    
                        </div>
                      </button>
                      
                    </h2>
                 
                  <!-- <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Place the content you want</div>
                  </div> -->
                </div>
                </a>
            </div>

            @php 
            $cat = $pro->type_id;
            @endphp
            
            @endif
            
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

    $(document).ready(function(){
          // alert()
          $(".box-border-grey").click(function(){
            // box-border-grey 
            $(".box-border-grey").removeClass('box-border-yellow');
            $(this).addClass("box-border-yellow");
          });

          // $(".desktop-two").click(function(){
          //   $(this).addClass("timeline-active");  
          //   $(".firstline").css("border-right", "1px solid #edbf1b");
          // });
          // $(".desktop-three").click(function(){
          //   $(this).addClass("timeline-active");  
          //   $(".secondline").css("border-right", "1px solid #edbf1b");
          // });


                  var current_fs, next_fs, previous_fs;

                  // No BACK button on first screen
                  if($(".show").hasClass("first-screen")) {
                  $(".prev").css({ 'display' : 'none' });
                  }

                  // Next button
                  $(".next-button").click(function(){

                  current_fs = $(this).parent().parent();
                  next_fs = $(this).parent().parent().next();

                  $(".prev").css({ 'display' : 'block' });

                  $(current_fs).removeClass("show");
                  $(next_fs).addClass("show");

                  $("#progressbar li").eq($(".card2").index(next_fs)).addClass("active");

                  current_fs.animate({}, {
                  step: function() {

                  current_fs.css({
                  'display': 'none',
                  'position': 'relative'
                  });

                  next_fs.css({
                  'display': 'block'
                  });
                  }
                  });
                  });

                  // Previous button
                  $(".prev").click(function(){

                  current_fs = $(".show");
                  previous_fs = $(".show").prev();

                  $(current_fs).removeClass("show");
                  $(previous_fs).addClass("show");

                  $(".prev").css({ 'display' : 'block' });

                  if($(".show").hasClass("first-screen")) {
                  $(".prev").css({ 'display' : 'none' });
                  }

                  $("#progressbar li").eq($(".card2").index(current_fs)).removeClass("active");

                  current_fs.animate({}, {
                  step: function() {

                  current_fs.css({
                  'display': 'none',
                  'position': 'relative'
                  });

                  previous_fs.css({
                  'display': 'block'
                  });
                  }
                  });
                  });

               

          
        });
});
</script>
