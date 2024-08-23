<style>
   .h-90vh{
      height:90vh !important;
   }
   .w-40{
      width: 40%;
   }
   .text-left{
      text-align:left;
   }
   .width-fitcontet{
      width: fit-content;
   }
   .vi-background-index{
      height:90vh !important;
   }
   .bg-greybg{
      overflow:hidden;
   }
   </style>
@if(Session::get('resp_id')!='')
   @include('user.layout.header-2')
@else
   @include('user.layout.header')
@endif

<section class=" ">
    <div class="container m-auto d-flex h-90vh">
       <div class="row justify-content-center mb-10vh w-100">
          <div class="col-md-10 m-auto h-100vh" style="">
             <!-- margin-top: 5% !important; -->
             <div class="w-100 position-relative">
                <div class="w-40 my-auto position-absolute pos-bottom mob-hide">
                   <img src="{{ asset('assets/images/img_4.webp') }}" class="img-fluid" alt="">
                </div>
                <div class="m-auto text-center bg-white py-2 my-2 px-3 vi-full-rounded">
                   <div class=" text-center w-75 vi-gift-box ml-auto">
                   <h2 class=" h1 fw-bolder mt-2">
                   @if($res->project_name_resp!='')
                    {{ $res->project_name_resp }}
                    @else 
                    {{ $res->name }}
                    @endif 
                   </h2>
                   <h3  class=" h1 fw-bolder mt-2">
                    @php 
                    $arr = ['1'=> 'Pre-Screener', "2" => 'Pre-Task', "3" => 'Paid survey', "4" => 'Unpaid survey']
                    @endphp 
                    {{$arr[$res->type_id]}} - {{ $res->number }}
                   </h3>
                   <h4 class="text-center">Share Survey</h4>
                   <div class="row w-75 m-auto">
                   <div class="col-md-6 col-sm-12">
                   <div class="visible-print text-right my-2 ml-auto width-fitcontet">
                       
                        {!! QrCode::size(150)->generate(url('share_project', $res->project_link)) !!}

                    </div>
                    </div>
                    <div class="col-md-6 col-sm-12 mr-auto my-auto">
                <div class="social-icons text-left">
                        <img id="whatsap" src="{{ asset('assets/images/SM icons-01.png') }}" class="img-fluid w-20" alt=""/>
                        <img  src="{{ asset('assets/images/SM icons-02.png') }}" id="facebook" class="img-fluid w-20" alt=""/>
                        <img id="twitter" src="{{ asset('assets/images/SM icons-03.png') }}" class="img-fluid w-20" alt="" />
                        <img id="mail" src="{{ asset('assets/images/SM icons-04.png') }}" class="img-fluid w-20" onclick="fbs_click(this);" alt=""/>
                </div>

                
            </div>
                  </div>
                  @if(Session::get('resp_id')!='')
                  <div class="text-center">
                  <a class="btn btn-yellow width-fit-content ml-auto" href="{{ url('survey/view', $res->builderID) }}"> Start Survey</a>
                  </div>
                  @endif

                   <div class="text-center">
                   <span id="demo"> {{ url('share_project', $res->project_link) }}</span><br>
                   <p class="text-secondary btn" onclick="copy('#demo')">Tap to copy link</p>
                </div>
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
            var whatsapurl ='https://wa.me/?text=I think you should join The Brand Surgeon and get paid for your opinion - {{ url('share_project', $res->project_link) }}';
            window.location.href = whatsapurl;
        });

        $("#facebook").click(function() {
            var facebook ='https://www.facebook.com/sharer/sharer.php?u={{ url('share_project', $res->project_link) }}';
            window.location.href = facebook;
        });
     
        $("#twitter").click(function() {
            var twitter ='https://twitter.com/intent/tweet?url={{ url('share_project', $res->project_link) }}&amp;text=I think you should join The Brand Surgeon and get paid for your opinion';
            window.location.href = twitter;
        });
        
        $("#mail").click(function() {
            var whatsapurl ='mailto:info@example.com?&subject=I think you should join The Brand Surgeon and get paid for your opinion - {{ url('share_project', $res->project_link) }}';
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
