@include('user.layout.header-2')

<section class="bg-greybg">
  
    <div class="row">
        
            <div class="col-md-10 m-auto bg-white my-5">
    <br>
    <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 alert alert-danger">
      <strong>Alert</strong> Profile Incomplete!</a>
    </div>
    <div class="col-md-2"></div>
    </div>
    <br>
            <div class="row">
            <div class="col-md-2">
                <div class="timeline">
                        <div class="border-height">
                            <div class="d-flex vi-timeline-design align-items-center flex-md-column justify-content-between">
                            <!-- <div class="position-absolute"><div class="position-relative"></div></div> -->
                            <div class="desktop-one timeline-active">1</div>
                            <div class="desktop-two">2</div>
                            <div class="desktop-three">3</div>
                            </div>
                        </div>
                </div>
            </div>
                <div class="section p-md-5 col-md-10 vi-mob-add-p">
                    <h4>Basic</h4>
                    <p class="mb-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                    <div class="row">
                    <div class="col-md-3 text-center box-border-yellow">
                        <img src="{{ asset('assets/images/icons-01.png') }}" class="img-fluid w-25" alt="">
                        <p>what type of research do you want to do?</p>
                    </div>
                    <div class="col-md-3 text-center box-border-grey">
                        <img src="{{ asset('assets/images/icons-05.png') }}" class="img-fluid w-25" alt="">
                        <p>About me</p>
                    </div>
                    <div class="col-md-3 text-center box-border-grey">
                        <img src="{{ asset('assets/images/icons-06.png') }}" class="img-fluid w-25" alt="">
                        <p>Employment</p>
                    </div>
                    </div>
                    <div class="vi-mob-center">
                        <button class="btn vi-yellow-btn text-white my-2">Next</button>
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
