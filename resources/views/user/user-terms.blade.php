@include('front.layout.header')

<section class="vh-md-100 bg-white">
      <div class="container">
        <div class="row justify-content-center py-5 m-auto">
        <p>
            {{$data->data}}
        </p>
        </div>
      </div>
</section>

@include('front.layout.footer')