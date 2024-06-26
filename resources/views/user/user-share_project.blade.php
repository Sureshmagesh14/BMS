@include('user.layout.header-2')


<section class="bg-greybg vh-100">
    <div class="container">
        <div class="row justify-content-center py-5 m-auto">
            <div class="col-md-4 text-center"
                style="background-size: cover;background-repeat:no-repeat;background-image: url('{{ asset('assets/images/young-afro-woman-watches-live-stream-.jpg') }}');">

            </div>
            <div class="col-md-4 bg-white p-5">
                <div class="qr-code text-center">
                    <h4 class="text-center">GET PAID FOR YOUR OPINION</h4>
                    <div class="visible-print text-center">
                        {!! QrCode::size(250)->generate(URL::to('/') . $ref_code) !!}
                    </div>
                    
                    <div class="social-icons-color d-flex justify-content-center my-3">
                        <img id="whatsap" src="{{ asset('assets/images/SM icons-01.png') }}" class="img-fluid w-10"
                            alt=""/>
                        <img  src="{{ asset('assets/images/SM icons-02.png') }}" id="facebook" class="img-fluid w-10" alt=""/>
                        <img id="twitter" src="{{ asset('assets/images/SM icons-03.png') }}" class="img-fluid w-10" alt="" />
                        <img id="mail" src="{{ asset('assets/images/SM icons-04.png') }}" class="img-fluid w-10" onclick="fbs_click(this);" alt=""/>
                    </div>
                </div>
                <div class="bg-light text-center">
                    <span id="demo"> {{ url('survey/view', $res->builderID) }}</span><br>
                    <p class="text-secondary btn" onclick="copy('#demo')">Tap to copy link</p>
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
            var whatsapurl ='https://wa.me/?text=I think you should join The Brand Surgeon and get paid for your opinion - {{ URL::to('/') }}?r={{ $ref_code }}';
            window.location.href = whatsapurl;
        });

        $("#facebook").click(function() {
            var facebook ='https://www.facebook.com/sharer/sharer.php?u=https://app.thebrandsurgeon.co.za/?r={{ URL::to('/') }}?r={{ $ref_code }}';
            window.location.href = facebook;
        });
     
        $("#twitter").click(function() {
            var twitter ='https://twitter.com/intent/tweet?url=https://app.thebrandsurgeon.co.za/?r={{ URL::to('/') }}?r={{ $ref_code }}&amp;text=I think you should join The Brand Surgeon and get paid for your opinion';
            window.location.href = twitter;
        });
        
        $("#mail").click(function() {
            var whatsapurl ='mailto:info@example.com?&subject=I think you should join The Brand Surgeon and get paid for your opinion - {{ URL::to('/') }}?r={{ $ref_code }}';
            window.location.href = whatsapurl;
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
