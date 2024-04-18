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
                        <img  src="{{ asset('assets/images/SM icons-02.png') }}" onclick="fbs_click(this);" class="img-fluid w-10" alt=""/>
                        <img id="twitter" src="{{ asset('assets/images/SM icons-03.png') }}" class="img-fluid w-10" alt="" >
                        <img id="mail" src="{{ asset('assets/images/SM icons-04.png') }}" class="img-fluid w-10" onclick="fbs_click(this);" alt=""/>
                    </div>
                </div>
                <div class="bg-light text-center">
                    <span id="demo"> {{ URL::to('/') }}?r={{ $ref_code }}</span><br>
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
            var whatsapurl ='whatsapp://send?abid={{ $get_res_phone->whatsapp }}&text={{ URL::to('/') }}?r={{ $ref_code }}';
            window.location.href = whatsapurl;
        });

        $("#twitter").click(function() {
            var twitter ='  http://twitter.com/share?text=text goes here&url={{ URL::to('/') }}?r={{ $ref_code }} goes here&hashtags=hashtag1,hashtag2,hashtag3';
            window.location.href = twitter;
        });

        $("#mail").click(function() {
            var whatsapurl ='mailto:address@dmail.com?subject=Hello there&body={{ URL::to('/') }}?r={{ $ref_code }}';
            window.location.href = whatsapurl;
        });

      
       
    });

    function fbs_click(TheImg) {
     u=TheImg.src;
     // t=document.title;
    t=TheImg.getAttribute('alt');
    window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;
}
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
