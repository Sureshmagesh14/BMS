@if(Session::get('resp_id')!='')
@include('user.layout.header-2')
@else 
@include('user.layout.header')
@endif 
<style>
    .container {
        font-size: 20px;
    }

    section {
        padding: 20px;
        margin: 10px;
    }

    .morecontent span {
        display: none;
    }

    .morelink {
        display: block;
    }

    button {
        margin: 10px;
        padding: 5px;
        background-color: cadetblue;
        border: none;
        font-size: 18px;
        outline: none;
        display: block;
        cursor: pointer;
        color: wheat;
    }
</style>
<section class="vh-md-100 bg-white">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 my-sm-5-mob">
                <div class="bg-white text-center">
                    <iframe class="w-100 px-5 my-3 h-400 h-sm-100"
                            src="https://www.youtube.com/embed/vGq8cT1qF60?si=7D_j6L0CbrIj-wBw"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                            style="max-width: 100%; height: 400px; /* Adjust height as needed */">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    
</section>

@include('user.layout.footer')

