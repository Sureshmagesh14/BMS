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
</style>
</head>

<body>
<a class="back_to_profile" href="{{ route('home') }}">
        <button id="back_to_profile">
            <span class="ss-primary-action-btn__copy">Back to Login</span>
        </button>
    </a>
    <div class="surveysparrow-survey-container--classic-form welcome-page">
        <div
            class="ss-fp-section surveysparrow-survey-form-wrapper--centered ss-survey-background d-flex fx-column fx-jc--center fx-ai--center">
            <div class="ss-fp-section__frame ss_classic_survey_intro_contents">
                <div class="ss-fp-section__inner-frame">

                    <h3 class="ss-header-text--fluid ss-survey-heading--text ss-survey-font-family ss-survey-line-height--normal ss-survey-text-weight--semibold ss-survey-text-color--primary ss-survey-text-align--center ss-survey-text-question-text main-header-font-size--md">
                        <p>Survey Unavailable!</p>
                        <figure>
                            <span>
                                <div class="ss_image_wrapper">
                                    <img src="{{ asset('assets/images/brand_surgen.png') }}" id="brandLogo">
                                </div>
                            </span>
                        </figure>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="http://127.0.0.1:8000/assets/js/jquery.min.js"></script>

</html>