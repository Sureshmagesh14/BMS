@include('user.layout.header-2')


<section class="bg-greybg vh-100">
    <div class="container">
        <div class="row justify-content-center py-5 m-auto">
            <div class="col-md-4 text-center" style="background-size: cover;background-repeat:no-repeat;background-image: url('{{ asset('assets/images/young-afro-woman-watches-live-stream-.jpg') }}');">
            
            </div>
            <div class="col-md-4 bg-white p-5">
            <div class="qr-code text-center">
                <h4 class="text-center">GET PAID FOR YOUR OPINION</h4>
                <img src="{{ asset('assets/images/qr-code.png') }}" class="img-fluid" alt="">
                <div class="social-icons-color d-flex justify-content-center my-3">
                    <img src="{{ asset('assets/images/SM icons-01.png') }}" class="img-fluid w-10" alt="">
                    <img src="{{ asset('assets/images/SM icons-02.png') }}" class="img-fluid w-10" alt="">
                    <img src="{{ asset('assets/images/SM icons-03.png') }}" class="img-fluid w-10" alt="">
                    <img src="{{ asset('assets/images/SM icons-04.png') }}" class="img-fluid w-10" alt="">
                </div>
            </div>
            <div class="bg-light text-center">
                <span> https://brandsurgeon-app.test-preview.co/?r=r65cb6efd</span>
                <p class="text-secondary">Tap to copy link</p>
            </div>
        </div>
        </div>
    </div>
</section>




@include('user.layout.footer')
<script>
$(document).ready(function() {

    $('#nav_share').addClass('active');
});
</script>
