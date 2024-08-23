<html>

<head>
<link href="{{ asset('assets/css/preview.css') }}" rel="stylesheet" type="text/css" />
<style>
img#brandLogo {
    width: 200px;
}
a.back_to_profile {
    display: flex;
    justify-content: end;
    text-decoration: none;
}
button#back_to_profile {
    color: white;
    background: #4A9CA6;
    border: 0px;
    padding: 10px;
    border-radius: 6px;
}
body{
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
}
.surveysparrow-survey-container--classic-form{
    background-color:unset;
}
</style>
</head>
<?php // Survey Background 
$bg=json_decode($survey->background); 
$stylebackground="";
if(isset($bg)){
    $type=$bg->type;
    if($bg->type=='image'){
        $styleimage= asset('uploads/survey/background/'.$bg->color);
        $stylebackground="background-image:url('".$styleimage."')";
    }else if($bg->type =='single'){
        if($bg->color!=''){
            $stylebackground="background-color:".$bg->color.";";
        }
    }else if($bg->type =='gradient'){
        if($bg->color!=''){
            $color=json_decode($bg->color);
            $ori=$color->ori;
            $c1=$color->hex1;
            $c2=$color->hex2;
            $colorset = $color->ori.",".$color->hex1.",".$color->hex2;
            $stylebackground="background-image:linear-gradient($colorset);";
        }
    }
} ?>
<body style="{{$stylebackground}}">
@if($survey->survey_type == 'profile')
<a class="back_to_profile" href="{{ route('user.dashboard') }}">
        <button id="back_to_profile">
            <span class="ss-primary-action-btn__copy">Back to Profile</span>
        </button>
    </a>
    @endif
    <div class="surveysparrow-survey-container--classic-form welcome-page">
        <div
            class="ss-fp-section surveysparrow-survey-form-wrapper--centered ss-survey-background d-flex fx-column fx-jc--center fx-ai--center">
            <div class="ss-fp-section__frame ss_classic_survey_intro_contents">
                <div class="ss-fp-section__inner-frame">

                    <h3 class="ss-header-text--fluid ss-survey-heading--text ss-survey-font-family ss-survey-line-height--normal ss-survey-text-weight--semibold ss-survey-text-color--primary ss-survey-text-align--center ss-survey-text-question-text main-header-font-size--md">
                    @if($survey->survey_type == 'profile')
                    <p>Profile Updated!</p>
                    @else    
                    <p>Survey Completed!</p>
                    
                    @endif
                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">Thanks for your time</p>
                        <figure>
                            <span>
                                <div class="ss_image_wrapper">
                                <a href="/"><img src="{{ asset('assets/images/brand_surgen.png') }}" id="brandLogo"> </a>
                                </div>

                            </span>
                        </figure>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script>
    setTimeout(function() {
        window.location.href = "{{ route('user.surveys') }}";
    }, 2000); // Redirect after 2 seconds
</script>
</html>