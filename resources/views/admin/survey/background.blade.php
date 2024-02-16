<!DOCTYPE html>
<html>

<head>
    <style>
        .fade {
            opacity: 0;
            transition: all 0.5s;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;
            color: #fff;
            font-size: 0.875em;
            letter-spacing: 0.063em;
        }

        ::-moz-selection {
            background: #00c9b7;
            padding: 10px;
        }

        ::selection {
            background: #00c9b7;
            padding: 10px;
        }

        ::-moz-selection {
            background: #00c9b7;
            padding: 10px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        h1 {
            font-weight: 900;
            font-size: 3.25em;
            margin-bottom: 30px;
            text-shadow: 2px 3px 0px #898999;
            line-height: 1.2;
        }

        h2 {
            font-size: 1.4em;
            letter-spacing: 0.2px;
            color: #1e1e1e;
            margin-bottom: 30px;
            font-weight: 900;
        }

        h3 {
            text-shadow: 2px 3px 0px rgba(150, 150, 150, 1);
            line-height: 1.2;
            font-weight: 900;
            font-size: 3.25em;
        }

        .bg {
            width: 100vw;
            height: 100vh;
            position: fixed;
            max-height: 100vh;
        }

        .wrap,
        .wrap-outer {
            width: calc(100vw-20px);
            height: 100vh;
            position: relative;
            max-height: 100vh;
            -webkit-transition: all 1s;
            -o-transition: all 1s;
            transition: all 1s;
        }

        .rotate {
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .gradient .rotate {
            -webkit-transform: rotate(95deg);
            -ms-transform: rotate(95deg);
            transform: rotate(95deg);
        }

        .bgnew {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            background-image: -webkit-gradient(linear, left bottom, right top, from(#6d327c), color-stop(#485DA6), color-stop(#00a1ba), color-stop(#00BF98), to(#36C486));
            background-image: -webkit-linear-gradient(left bottom, #6d327c, #485DA6, #00a1ba, #00BF98, #36C486);
            background-image: -o-linear-gradient(left bottom, #6d327c, #485DA6, #00a1ba, #00BF98, #36C486);
            background-image: linear-gradient(to right top, #6d327c, #485DA6, #00a1ba, #00BF98, #36C486);
        }

        .bgnew2 {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -2;
            background-image: -webkit-gradient(linear, left bottom, right top, from(#38438b), color-stop(#944b94), color-stop(#d75a88), color-stop(#ff7e71), color-stop(#ffb25f), to(#ffeb68));
            background-image: -webkit-linear-gradient(left bottom, #38438b, #944b94, #d75a88, #ff7e71, #ffb25f, #ffeb68);
            background-image: -o-linear-gradient(left bottom, #38438b, #944b94, #d75a88, #ff7e71, #ffb25f, #ffeb68);
            background-image: linear-gradient(to right top, #38438b, #944b94, #d75a88, #ff7e71, #ffb25f, #ffeb68);
        }

        .bg-bottom {}

        .wrap {
            width: 100%;
            height: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: start;
            -ms-flex-pack: start;
            justify-content: flex-start;
        }

        .header {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            padding: 30px 8.33%;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            margin-bottom: 5%;
            margin-bottom: 50px;
            height: 130px;
        }

        .logo {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .left-foot .logo {
            padding: 0px 10px 0px 0px;
        }

        .logo img {
            width: 100%;
            max-width: 70px;
            display: inline-block;
            margin-right: 20px;
        }

        .logo-text {
            display: inline-block;
            font-size: 1em;
            font-weight: 900;
            position: relative;
        }

        .logo-text:after {
            content: "Beta";
            position: absolute;
            top: -20px;
            right: -20px;
            padding: 3px 5px;
            border-radius: 3px;
            background-color: #FF7BDA;
            font-size: 0.8em;
        }

        li.gc3 {
            display: block;
            position: relative;
        }

        .gc3::after {
            content: "New";
            position: absolute;
            top: -20px;
            right: 0px;
            padding: 3px 5px;
            border-radius: 3px;
            background-color: #FF08E2;
            font-size: 0.8em;
            font-weight: bold;
        }

        .gc3-link a {
            border-bottom: 1px solid #fff;
            opacity: 0.7;
        }

        .gc3-link a:hover {
            opacity: 1;
        }

        nav {
            text-transform: uppercase;
            letter-spacing: 0.063em;
            font-size: 0.75em;
        }

        .header nav ul li {
            display: inline-block;
            margin-left: 20px;
        }

        nav ul li a {
            letter-spacing: 2px;
            color: #fff;
            -webkit-transition: color .2s ease;
            -o-transition: color .2s ease;
            transition: color .2s ease;
            padding: 3px 0;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .effect ul li a:hover {
            color: #FBFAFC;
        }

        .effect ul li a:hover::after,
        .effect ul li a:hover::before {
            width: 100%;
            left: 0;
        }

        .effect ul li a::after,
        .effect ul li a::before {
            content: '';
            position: absolute;
            top: calc(100% + 5px);
            width: 0;
            right: 0;
            height: 3px;
        }

        .effect ul li a::before {
            -webkit-transition: width .25s cubic-bezier(0.51, 0.18, 0, 0.88) .1s;
            -o-transition: width .25s cubic-bezier(0.51, 0.18, 0, 0.88) .1s;
            transition: width .25s cubic-bezier(0.51, 0.18, 0, 0.88) .1s;
            background: #845EC2;
        }

        .effect ul li a::after {
            -webkit-transition: width .2s cubic-bezier(0.29, 0.18, 0.26, 0.83);
            -o-transition: width .2s cubic-bezier(0.29, 0.18, 0.26, 0.83);
            transition: width .2s cubic-bezier(0.29, 0.18, 0.26, 0.83);
            background: #2FFFAD;
        }

        .effect ul li a.active:after {
            background: #2FFFAD;
            width: 100%;
            left: 0;
        }

        .effect ul li a.active:before {
            z-index: 2;
        }

        .box {
            display: inline-block;
            width: 33%;
        }

        .sign {
            font-weight: 900;
            font-size: 3em;
            text-align: center;
            width: 50%;
            margin: 0 auto 50px;
            text-shadow: 2px 3px 0px rgba(150, 150, 150, 1);
            line-height: 1.2;
        }

        .main {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            width: 100%;
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap;
        }

        .main .color-input h2 {
            color: #fff;
            font-weight: 900;
            font-size: 2.925em;
            margin-bottom: 3%;
            letter-spacing: 0.093em;
            text-shadow: 2px 3px 0px #898999;
            text-transform: uppercase;
        }

        .astro.left {
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .astro.right {
            position: absolute;
            bottom: 0;
            right: 0;
            right: 3%;
        }

        .astro img {
            width: 100%;
        }

        .astro.left img {
            width: 90%;
        }

        .color-input {
            -ms-flex-item-align: start;
            align-self: flex-start;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .color-input p {
            margin-bottom: 50px;
            font-size: 1.3em;
        }

        .color-input input {
            background-color: #693a7d;
            height: 50px;
            text-align: center;
            width: 180px;
            margin-bottom: 10%;
            border-radius: 50px;
            -webkit-box-shadow: 10px 10px 14px 1px rgba(00, 00, 00, 0.2);
            box-shadow: 10px 10px 14px 1px rgba(00, 00, 00, 0.2);
            letter-spacing: 0.094em;
        }

        .color-input form {
            width: 285px;
            margin: 0 auto;
            position: relative;
            -webkit-transition: all 1s;
            -o-transition: all 1s;
            transition: all 1s;
        }

        .color-input form label {
            margin-right: -50px;
            z-index: 90;
            position: relative;
            padding-left: 30px;
            color: #fff;
        }

        .color-input button,
        a.back-btn,
        a.help-btn {
            display: inline-block;
            position: relative;
            border-radius: 50px;
            background: #00c9b7;
            width: 180px;
            height: 50px;
            position: relative;
            color: #fff;
            font-size: 0.97em;
            letter-spacing: 0.094em;
            cursor: pointer;
            -webkit-box-shadow: 10px 10px 14px 1px rgba(00, 00, 00, 0.2);
            box-shadow: 10px 10px 14px 1px rgba(00, 00, 00, 0.2);
            /*display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;*/
            text-align: center;
            margin: 0 auto;
            -webkit-transition: all 0.5s;
            -o-transition: all 0.5s;
            transition: all 0.5s;
            text-transform: uppercase;
        }

        .color-input button i {
            margin-right: 5%;
            font-size: 1.2em;
        }

        .color-input button:hover {
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .cp-color-picker {
            position: relative;
        }

        .cp-color-picker:before {
            bottom: -9px;
            border-color: transparent transparent #999;
        }

        .cp-color-picker:after {
            content: "";
            display: block;
            position: absolute;
            bottom: -8px;
            left: 8px;
            border: 8px solid #323E3E;
            border-width: 8px 8px 0px;
            border-color: #323E3E transparent transparent;
            z-index: 999;
            width: 12px;
        }

        .cp-color-picker.cp2:after {
            top: 16px;
            right: -12px;
            left: auto;
            width: 16px;
            -webkit-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            transform: rotate(-90deg);
            bottom: auto;
        }

        .gradient .bgnew {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            background-image: -webkit-gradient(linear, left bottom, right top, from(#ff2f55), color-stop(#d61c6e), color-stop(#a22579), color-stop(#6a2b74), color-stop(#342961), to(#021f44));
            background-image: -webkit-linear-gradient(left bottom, #ff2f55, #d61c6e, #a22579, #6a2b74, #342961, #021f44);
            background-image: -o-linear-gradient(left bottom, #ff2f55, #d61c6e, #a22579, #6a2b74, #342961, #021f44);
            background-image: linear-gradient(to right top, #ff2f55, #d61c6e, #a22579, #6a2b74, #342961, #021f44);
        }

        .gradient h1 {
            margin: 0 auto 35px;
            font-size: 2.2em;
            text-align: center;
        }

        .gradient .color-input {
            width: 100%;
            margin: 0 auto;
        }

        .gradient .color-input form {
            width: 25%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .gradient .color-input button {
            margin: 0 auto 30px;
        }

        .gradient .color-input form .choose input {
            width: auto;
        }

        .gradient .color-input form input {
            margin-bottom: 0;
        }

        .gradient .code-box {
            width: 25%;
            background-blend-mode: overlay;
            border-left: 0px solid #696969;
            margin: 0 auto 20px;
            padding-bottom: 20px
        }

        .gradient .code-box p,
        .gradient .color-input p {
            font-weight: 900;
            border-bottom: 1 px solid #00a1ba;
            margin-bottom: 20px;
            paddin-bottom: 5px;
            display: block;
            font-size: 1em;
            text-shadow: none;
        }

        .gradient .code-box p {
            margin-bottom: 5px;
            text-align: left;
        }

        .gradient .code-box code {
            font-family: 'Space Mono', monospace;
            width: 100%;
            margin: 0 auto;
            display: block;
            line-height: 1.4;
            letter-spacing: 0.2px;
            border-left: 3px solid #fff;
            background-color: rgba(189, 189, 189, 0.1);
            padding: 15px 8px 15px 17px;
            border-radius: 5px;
        }

        .gradient .code-box code::-moz-selection {
            background: #00c9b7;
        }

        .gradient .code-box code::selection {
            background: #00c9b7;
        }

        .gradient .code-box code::-moz-selection {
            background: #00c9b7;
        }

        .gradient .color-input .labels {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: distribute;
            justify-content: space-around;
            margin-bottom: 30px;
        }

        .gradient .choose {
            margin-bottom: 10px;
        }
    </style>
</head>

<body class="gradient">
    <div class="bgnew" id="gradient" style="background-image: linear-gradient(to right top,
				#9164b7, #3d94de, #00b7d7, #6dd1bd, #c2e3b1);"></div>
    <div class="bg">
        <div class="wrap">
            <div class="outer">
                <div class=" box color-input">
                    <form method="get" id="form1">
                        <div class="choose">
                            <p>Choose orientation</p>
                            <input type="radio" name="ori" value="to right top" id="radio1" checked>
                            <label class="rLab" for="radio1"><i class="fa fa-arrow-right degtop"
                                    aria-hidden="true"></i></label>

                            <input type="radio" name="ori" value="to right" id="radio2">
                            <label class="rLab" for="radio2"><i class="fa fa-arrow-right"
                                    aria-hidden="true"></i></label>

                            <input type="radio" name="ori" value="to right bottom" id="radio3">
                            <label class="rLab" for="radio3"><i class="fa fa-arrow-right degbot"
                                    aria-hidden="true"></i></label>

                            <input type="radio" name="ori" value="to bottom" id="radio4">
                            <label class="rLab" for="radio4"><i class="fa fa-arrow-down" aria-hidden="true"></i></label>

                            <input type="radio" name="ori" value="to left bottom" id="radio5">
                            <label class="rLab" for="radio5"><i class="fa fa-arrow-left degtop"
                                    aria-hidden="true"></i></label>

                            <input type="radio" name="ori" value="to left" id="radio6">
                            <label class="rLab" for="radio6"><i class="fa fa-arrow-left" aria-hidden="true"></i></label>

                            <input type="radio" name="ori" value="to left top" id="radio7">
                            <label class="rLab" for="radio7"><i class="fa fa-arrow-left degbot"
                                    aria-hidden="true"></i></label>

                            <input type="radio" name="ori" value="to top" id="radio8">
                            <label class="rLab" for="radio8"><i class="fa fa-arrow-up" aria-hidden="true"></i></label>

                        </div>
                        <p>Enter colors</p>
                        <div class="fade labels">
                            <div class="label">
                                <input onchange="validateInput(this)" class="color-picker js-color-input selectable"
                                    type="text" name='hex' id='hex' value="#9164B7">
                            </div>
                            <div class="label">
                                <input onchange="validateInput(this)" class="color-picker js-color-input selectable"
                                    type="text" name='hex2' id='hex1' value="#C2E3B1">
                            </div>
                        </div>
                        <button class="fade" type="button" onclick="setgradient()" name="sub" value="1">
                            <i class="fa fa-rocket" aria-hidden="true"></i>Generate
                        </button>
                    </form>
                    <p id='return'>
                    </p>
                </div>
                <div class="code-box">

                    <p>CSS Code:</p>
                    <code id="selectable">
				    background-image: linear-gradient(to right top,#9164b7, #3d94de, #00b7d7, #6dd1bd, #c2e3b1);</code>
                </div>
            </div>
        </div>

    </div> 
    <script type="text/javascript">
        function setgradient() {
            let v1 = $('#hex').val();
            let v2 = $('#hex1').val();
            let ori = $('input[name="ori"]:checked').val();
            var body = document.getElementById("gradient");
            body.style.background = "linear-gradient(" + ori + ", " + v1 + ", "
                + v2 + ")";
            console.log(ori, "ori")
            $('#selectable').html(body.style.background + ";");
        }

        function validateInput(ele) {

            var hexInput = ele;
            hexInput.value = hexInput.value.replace(/^#/, '');

            var regExpHex = new RegExp(/^[0-9A-F]{1,6}$/i);

            if (!regExpHex.test(hexInput.value)) {

                hexInput.value = '000000';
            }
        }

    </script>
    <script src="{{ asset('/assets/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/jqColorPicker.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/scrollreveal.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/colorpicker-main.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/colopicker.css')}}">
    <link rel="stylesheet" href="{{ asset('/assets/css/fontawesome.min.css')}}">
</body>

</html>