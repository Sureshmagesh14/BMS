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
    <div calss = "container">

        <span class="more">
            {{ $data->data }}
        </span>


    </div>
</section>

@include('user.layout.footer')
<script>
    $(document).ready(function() {
        // Configure/customize these variables.
        var showChar = 5500; // How many characters are shown by default
        var ellipsestext = "...";
        var moretext = "Show more >";
        var lesstext = "Show less";


        $('.more').each(function() {
            var content = $(this).html();

            if (content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);

                var html = c + '<span class="moreellipses">' + ellipsestext +
                    '&nbsp;</span><span class="morecontent"><span>' + h +
                    '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $(".morelink").click(function() {
            if ($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });
</script>
                                                               