@include('user.layout.header-2')

<section class="vh-md-100 bg-white">
    <div class="container">
        <div class="row justify-content-center py-5 m-auto">
            <div calss = "container">
              @if(strlen($data->data) > 300)
              <p>{{substr($data->data, 0, 33440) }}<span
                id="dots">...</span>
                @else
                <span
                        id="more">{{substr($data->data, 0, 33440) }}</span>
              </p>
              @endif
           
                <button onclick="myFunction()" id="myBtn">Read more</button>
            </div>
        </div>
    </div>
</section>

@include('user.layout.footer')
<script>
    function myFunction() {
        var dots = document.getElementById("dots");
        var moreText = document.getElementById("more");
        var btnText = document.getElementById("myBtn");

        if (dots.style.display === "none") {
            dots.style.display = "inline";
            btnText.innerHTML = "Read more";
            moreText.style.display = "none";
        } else {
            dots.style.display = "none";
            btnText.innerHTML = "Read less";
            moreText.style.display = "inline";
        }
    }
</script>
