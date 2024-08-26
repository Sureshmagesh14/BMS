@if(Session::get('resp_id')!='')
@include('user.layout.header-2')
@else 
@include('user.layout.header')
@endif 
<style>
    /* Basic Reset */
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        color: #333;
    }

    /* Custom Scrollbar Design */
    ::-webkit-scrollbar {
        width: 12px; /* Width of the scrollbar */
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1; /* Background of the scrollbar track */
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #888; /* Color of the scrollbar thumb */
        border-radius: 10px;
        border: 3px solid #f1f1f1; /* Border around the thumb */
        transition: background 0.3s ease; /* Smooth transition on hover */
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555; /* Darker color when hovering */
    }

    /* Container and Content Styling */
    .container {
        max-width: 900px;
        margin: auto;
        padding: 20px;
    }

    section {
        background: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
        height: 300px; /* Set a height to demonstrate scrolling */
        overflow-y: scroll; /* Enable vertical scrolling */
        border: 1px solid #ddd; /* Light border for better visibility */
    }

    h1 {
        color: #333;
    }

    p {
        line-height: 1.6;
    }
</style>
<div class="container">
    <h5>Terms & Conditions</h5>
    <section>
        <p> {{ $data->data }}</p>
    </section>
</div>


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
                                                               