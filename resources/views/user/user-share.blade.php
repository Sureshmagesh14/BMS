@include('user.layout.header-2')
<style>
.bg-greybg{
    background:#90b8d0;
}
.bg-yellow{
    background-color:#ffbb00;
    border:1px solid #ffbb00;
    border-radius:25px;
}
</style>

<section class="bg-greybg vh-75 m-auto d-flex">
    <div class="m-auto d-flex">
    <div class="container my-2">
        <div class="row justify-content-center mx-auto">
            <div class="col-md-6 text-center d-flex bg-yellow">
                <img class="w-100 object-fit" src="{{ asset('assets/images/share.webp') }}" />
            </div>
            <div class="col-md-6  p-2 d-flex m-auto">
                <div class="w-100">
                <div class="qr-code text-center">
                    <!-- <h4 class="text-center">GET PAID FOR YOUR OPINION</h4> -->
                    <h4 class="text-center text-white" style="font-size:35px;">Share with your friends and family</h4>
                    <h4 class="text-center text-white"  style="font-size:35px;">It's free to join</h4>
                    <div class="visible-print text-center">
                        {!! QrCode::size(150)->generate($ref_code) !!}
                    </div>
                    
                    <div class="social-icons-color d-flex justify-content-center my-3">
                        <img id="whatsap" src="{{ asset('assets/images/SM icons-01.png') }}" class="img-fluid w-10"
                            alt=""/>
                        <img  src="{{ asset('assets/images/SM icons-02.png') }}" id="facebook" class="img-fluid w-10" alt=""/>
                        <img id="twitter" src="{{ asset('assets/images/SM icons-03.png') }}" class="img-fluid w-10" alt="" />
                        <img id="mail" src="{{ asset('assets/images/SM icons-04.png') }}" class="img-fluid w-10" onclick="fbs_click(this);" alt=""/>
                    </div>
                </div>
                <div class="text-center text-white" style="font-size:25px;">
                    <span id="demo"> {{ $ref_code }}</span><br>
                    <p class="text-secondary btn text-white" onclick="copy('#demo')" style="font-size:20px;">Tap to copy link</p>
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>




@include('user.layout.footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        $('#nav_share').addClass('active');
   
        $("#whatsap").click(function() {
            var whatsapurl ='https://wa.me/?text=I think you should join The Brand Surgeon and get paid for your opinion - {{ $ref_code }}';
            window.location.href = whatsapurl;
        });

        $("#facebook").click(function() {
            var facebook ='https://www.facebook.com/sharer/sharer.php?u={{ $ref_code }}';
            window.location.href = facebook;
        });
     
        $("#twitter").click(function() {
            var twitter ='https://twitter.com/intent/tweet?url={{ $ref_code }}&amp;text=I think you should join The Brand Surgeon and get paid for your opinion';
            window.location.href = twitter;
        });
        
        $("#mail123").click(function() {
            var whatsapurl ='mailto:?&subject=I think you should join The Brand Surgeon and get paid for your opinion - {{ $ref_code }}';
            window.location.href = whatsapurl;
        });

        $("#mail").click(function() {
            var subject = "I think you should join The Brand Surgeon";
            var body = "I think you should join The Brand Surgeon and get paid for your opinion - {{ $ref_code }}";
            var mailtoUrl = 'mailto:?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
            window.location.href = mailtoUrl;
        });

      
       
    });

   
    function copy(selector) {

        var $temp = $("<div>");
        $("body").append($temp);
        $temp.attr("contenteditable", true).html($(selector).html()).select().on("focus", function() {
            document.execCommand('selectAll', false, null);
        }).focus();
        document.execCommand("copy");
        $temp.remove();
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("Link copied");
    }
</script>
