<html>

<head>
    <link href="{{ asset('assets/css/preview.css') }}" rel="stylesheet" type="text/css" />
    <style>
        #preview_content {
            display: block !important;
        }
    </style>
</head>
<?php $qusvalue = json_decode($question->qus_ans);
$azRange = range('A', 'Z');
$qusNo=1;
$icon_type='';
if(isset($qusvalue->icon_type)){
    $icon_type=$qusvalue->icon_type;
}
foreach($questionsset as $key=>$qus){
    if($question->id==$qus->id){
        $qusNo=$qusNo+$key;
    }
} ?>
<body>
<!-- <p>{{$question->qus_type}}</p> -->
    @if($question->qus_type=='welcome_page')
    <div class="surveysparrow-survey-container--classic-form welcome-page">
        <div class="ss-fp-section surveysparrow-survey-form-wrapper--centered ss-survey-background d-flex fx-column fx-jc--center fx-ai--center">
            <div class="ss-fp-section__frame ss_classic_survey_intro_contents">
                <div class="ss-fp-section__inner-frame">
                    
                        <h3 class="ss-header-text--fluid ss-survey-heading--text ss-survey-font-family ss-survey-line-height--normal ss-survey-text-weight--semibold ss-survey-text-color--primary ss-survey-text-align--center ss-survey-text-question-text main-header-font-size--md">
                            @if(isset($qusvalue->welcome_title))
                                <p>{{$qusvalue->welcome_title}}</p>
                            @endif
                            @if(isset($qusvalue->welcome_image))
                            <figure>
                                <span>
                                    <div class="ss_image_wrapper">
                                        <img src="{{ asset('uploads/survey/'.$qusvalue->welcome_image) }}" alt="welcome image">
                                    </div>
                                </span>
                            </figure>
                            @endif
                            @if(isset($qusvalue->welcome_imagetitle))
                                <p>{{$qusvalue->welcome_imagetitle}}</p>
                            @endif
                        </h3>
                        @if(isset($qusvalue->welcome_imagesubtitle))
                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$qusvalue->welcome_imagesubtitle}}</p>
                        @endif
                        @if(isset($qusvalue->welcome_btn))
                        <div class="ss_cl_qstn_action">
                            <a href="{{route('survey.startsurvey',[$survey->id,$question1->id])}}">
                                <button class="ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold ss-primary-action-btn--intro">
                                    <span class="ss-primary-action-btn__copy">{{$qusvalue->welcome_btn}}</span>
                                    <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z"
                                            stroke="#63686F" stroke-width="1"></path>
                                    </svg>
                                </button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='matrix_qus')
    <div class="surveysparrow-survey-container--classic-form">
        <div class="ss_classic_top_bar d-flex fx-row fx-jc--between fx-ai--center" role="banner">
            <div class="d-flex fx-column fx-jc--center fx-ai--start ss_classic_top_bar_section_details"></div>
        </div>
        <div class="surveysparrow-survey-form-wrapper ss-survey-background">
            <div id="fake-scroll-container" class="ss-fp-scroll ss-fake-scroll--center ">
                <div class="ss-fp-scroll__item d-flex fx-column fx-jc--center">
                    <div class="ss-fp-scroll__item-data-wrap" style="display: block;">
                        <div id="question_{{$question->id}}" class="ss_cl_survey_qstn_item active" style="width: 100%;">
                            <div class="ss_cl_survey_qstn_wrapper">
                                <div class="ss_cl_survey_qstn_left d-flex fx-row fx-ai--center">
                                    <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">Question {{$qusNo}}</p>
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                            <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                        </h1>
                                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">
                                            <p>
                                                <br>
                                            </p>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php $exiting_choices_matrix=$qusvalue!=null ? explode(",",$qusvalue->matrix_choice): [];
                                $exiting_qus_matrix=$qusvalue!=null ? explode(",",$qusvalue->matrix_qus): []; $i=0;
                                    ?>
                            <span class="ss_span_wrapper">
                                <div class="ss_options_container">
                                    <div class="ss_matrix_container ss_matrix_container--classic ss_component_animated ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-color--primary">
                                        <div class="ss_matrix_desk ss_matrix_container">
                                            <div class="ss_matrix" style="margin-left: 0px;">
                                                <div id="matrix_table1">
                                                    <table id="matrix_sec1" class="matrix_sec">
                                                    <?php $exiting_choices_matrix=$qusvalue!=null ? explode(",",$qusvalue->matrix_choice): [];
                                                    $exiting_qus_matrix=$qusvalue!=null ? explode(",",$qusvalue->matrix_qus): []; $i=0;
                                                        ?>
                                                        <tbody>
                                                            @if(count($exiting_qus_matrix)>0)
                                                                <tr>
                                                                    <td></td>
                                                                    @foreach($exiting_choices_matrix as $ans)
                                                                    <td>{{$ans}}</td>
                                                                    @endforeach
                                                                </tr>
                                                            @endif
                                                            <?php foreach($exiting_qus_matrix as $qus){
                                                                ?>
                                                                    <tr>
                                                                        <td>{{$qus}}</td>
                                                                        @foreach($exiting_choices_matrix as $ans)
                                                                        <td><input type="radio" name="matrix_anstype{{$qus}}"></td>
                                                                        @endforeach
                                                                    </tr>
                                                                <?php  
                                                                $i++;
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="ss_cl_qstn_action ">
                                                <a href="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif">
                                                    <div class="">
                                                        <button id="next_button" data-qa="next_button" data-hotkey-item="hotkey-cta-button" class="ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                            <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </a>
                                                <div class="ss-skip-container">
                                                    <button data-qa="skip_button" data-hotkey-item="hotkey-skip-button" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='single_choice' || $question->qus_type=='multi_choice')
    <div class="surveysparrow-survey-container--classic-form">
        <div class="ss_classic_top_bar d-flex fx-row fx-jc--between fx-ai--center" role="banner">
            <div class="d-flex fx-column fx-jc--center fx-ai--start ss_classic_top_bar_section_details"></div>
        </div>
        <div class="surveysparrow-survey-form-wrapper ss-survey-background" aria-live="polite">
            <div id="fake-scroll-container" class="ss-fp-scroll ss-fake-scroll--center ">
                <div class="ss-fp-scroll__item d-flex fx-column fx-jc--center">
                    <div class="ss-fp-scroll__item-data-wrap" style="display: block;">
                    <div id="question_8966626" class="ss_cl_survey_qstn_item active" style="width: 100%;">
                        <div class="ss_cl_survey_qstn_wrapper">
                            <div class="ss_cl_survey_qstn_left d-flex fx-row fx-ai--center">
                            <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">Question {{$qusNo}}</p>
                            </div>
                            <div class="ss_cl_survey_qstn_right">
                                <div class="ss_cl_survey_qstn">
                                <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text" id="question-title-8966626">
                                    <span class="d-block ss-survey-heading--text__span">{{$question->question_name}}</span></h1>
                                <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07"
                                    id="question-description-8966626">
                                <p><br></p>
                                </p>
                                </div>
                            </div>
                        </div>
                        <?php $exiting_choices=$qusvalue!=null ? explode(",",$qusvalue->choices_list): []; ?>
                        <span class="ss_span_wrapper">
                            <div class="ss_options_container">
                                <div class="ss_multiple_choice__helper-txt" aria-live="polite">
                                @if($question->qus_type!='single_choice')
                                <p class="ss-text ss-text__size--micro ss-text__weight--normal ss-text__color--grey ss-text__align--center fx--fw mb--lg ss-survey-text-color--secondary-09">
                                    Choose as many as you like
                                </p>
                                @endif
                                </div>
                                <div class="ss_multiple_choice ss_component_animated">
                                    @foreach($exiting_choices as $key=>$choice)
                                    <button class="ss-answer-option--choice ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-item--has-key-assist">
                                        <span class="ss-answer-option--choice__copy">{{$choice}}</span>
                                        <div class="ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--bold ss-option-no">
                                            <span class="ss-option-no__index">{{$azRange[$key]}}</span></div>
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="ss_cl_qstn_action ">
                                <a href="{{route('survey.startsurvey',[$survey->id,$question1->id])}}">
                                    <div class="">
                                        <button id="next_button" data-qa="next_button" data-hotkey-item="hotkey-cta-button" class="ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                            <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </a>
                                <div class="ss-skip-container">
                                    <button data-qa="skip_button" data-hotkey-item="hotkey-skip-button" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                </div>
                            </div>
                        </span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ss-classic-footer--old" role="contentinfo">
            <div class="ss_classic_footer_right_content_wrap">
                <div class="ss_classic_form_navigator d-flex fx-row fx-jc--center fx-ai--center">
                    <button class="d-flex fx-column fx-jc--center fx-ai--center" type="button" title="Previous"
                    aria-label="Previous">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                        <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                            d="M13.333 7.667L7.037 1.37.741 7.667"></path>
                    </svg>
                    </button>
                    <button class="d-flex fx-column fx-jc--center fx-ai--center" title="Next" aria-label="Next" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                        <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                            d="M.667 1.333L6.963 7.63l6.296-6.296"></path>
                    </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='open_qus')
    <div class="surveysparrow-survey-container--classic-form">
        <div class="ss_classic_top_bar d-flex fx-row fx-jc--between fx-ai--center">
            <div class="d-flex fx-column fx-jc--center fx-ai--start ss_classic_top_bar_section_details"></div>
        </div>
        <div class="surveysparrow-survey-form-wrapper ss-survey-background">
            <div id="fake-scroll-container" class="ss-fp-scroll ss-fake-scroll--center ">
                <div class="ss-fp-scroll__item d-flex fx-column fx-jc--center">
                    <div class="ss-fp-scroll__item-data-wrap" style="display: block;">
                        <div id="question_8982683" class="ss_cl_survey_qstn_item active" style="width: 100%;">
                            <div class="ss_cl_survey_qstn_wrapper">
                                <div class="ss_cl_survey_qstn_left d-flex fx-row fx-ai--center">
                                <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">Question {{$qusNo}}</p>
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text"
                                            id="question-title-8982683">
                                            <span class="d-block ss-survey-heading--text__span">open type qus</span>
                                        </h1>
                                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07"
                                            id="question-description-8982683">
                                        <p><br></p>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <span class="ss_span_wrapper">
                                @if($qusvalue->open_qus_choice == 'multi')
                                <div class="ss_options_container">
                                    <div class="ss_inline_input_container ss_component_animated ss-form-group ss-form-group--lg-col-6 ss_inline_input_voice-container">
                                        <textarea class="answer-option--input ss-survey-font-family ss-survey-text-size--2xl sm_ss-survey-text-size--lg ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-border-style--solid ss-survey-border-color--primary  ss-survey-text-color--secondary"
                                            placeholder="Please enter your response" maxlength="10000"
                                            style="resize: none; height: 37px;"></textarea><span
                                            class="ss-form-group__highlight"></span>
                                    </div>
                                </div>
                                <div class="ss_cl_qstn_action multiline_helper">
                                    <p class="ss-survey-font-family ss-survey-text-size--xs sm_ss-survey-text-size--xs ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--primary-06 ss-survey-text-align--left">
                                        Hit <b>Shift + Enter</b> for new line</p>
                                </div>
                                @elseif($qusvalue->open_qus_choice == 'single')
                                <div class="ss_options_container">
                                    <div class="ss_inline_input_container ss_component_animated ss-form-group ss-form-group--lg-col-6 ss_inline_input_voice-container">
                                        <input type="text" class="answer-option--input ss-survey-font-family ss-survey-text-size--2xl sm_ss-survey-text-size--lg ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-border-style--solid ss-survey-border-color--primary  ss-survey-text-color--secondary" placeholder="Please enter your response" maxlength="1000" style="max-height: 200px; height: 36.8px;"></textarea>
                                        <span class="ss-form-group__highlight"></span>
                                    </div>
                                </div>
                                @endif
                                <div class="ss_cl_qstn_action ">
                                <a href="{{route('survey.startsurvey',[$survey->id,$question1->id])}}">
                                    <div class="">
                                        <button id="next_button" data-qa="next_button" data-hotkey-item="hotkey-cta-button" class="ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                            <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </a>
                                <div class="ss-skip-container">
                                    <button data-qa="skip_button" data-hotkey-item="hotkey-skip-button" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                </div>
                            </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ss-classic-footer--old" role="contentinfo">
            <div class="ss_classic_footer_right_content_wrap">
                <div class="ss_classic_form_navigator d-flex fx-row fx-jc--center fx-ai--center">
                    <button class="inactive d-flex fx-column fx-jc--center fx-ai--center" type="button" title="Previous"
                        aria-label="Previous" disabled="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M13.333 7.667L7.037 1.37.741 7.667"></path>
                        </svg>
                    </button>
                    <button class="d-flex fx-column fx-jc--center fx-ai--center" title="Next" aria-label="Next"
                        type="button" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M.667 1.333L6.963 7.63l6.296-6.296"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='likert')
    <div class="surveysparrow-survey-container--classic-form">
        <div class="ss_classic_top_bar d-flex fx-row fx-jc--between fx-ai--center" role="banner">
            <div class="d-flex fx-column fx-jc--center fx-ai--start ss_classic_top_bar_section_details"></div>
        </div>
        <div class="surveysparrow-survey-form-wrapper ss-survey-background" aria-live="polite">
            <div id="fake-scroll-container" class="ss-fp-scroll ss-fake-scroll--center ">
                <div class="ss-fp-scroll__item d-flex fx-column fx-jc--center">
                    <div class="ss-fp-scroll__item-data-wrap" style="display: block;">
                        <div id="question_8962778" class="ss_cl_survey_qstn_item active" style="width: 100%;">
                            <div class="ss_cl_survey_qstn_wrapper">
                                <div class="ss_cl_survey_qstn_left d-flex fx-row fx-ai--center">
                                <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">Question {{$qusNo}}</p>
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                            <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                                <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                            </h1>
                                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07"
                                            id="question-description-8962778"> </p>
                                    </div>
                                </div>
                            </div><span class="ss_span_wrapper">
                                <div class="ss_options_container">
                                    <div class="ss_rating_container ss_component_animated">
                                        <div class="ss_rating_input--classic">
                                            <button class="ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic"> 1
                                                <label class="ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-option__label ss-answer-option__label--min-label">Least Likely</label>
                                            </button>
                                            <button class="ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary active ss-answer-option--classic" >2</button>
                                            <button class="ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >3</button>
                                            <button class="ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic"  name="op-8962778">4</button>
                                            <button class="ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >5
                                                <label class="ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-option__label ss-answer-option__label--middle-label">Neutral</label>
                                            </button>
                                            <button class="ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic"  name="op-8962778">6</button>
                                            <button class="ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic"  name="op-8962778">7</button>
                                            <button class="ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic"  name="op-8962778">8</button>
                                            <button class="ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >9
                                                <label class="ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-option__label ss-answer-option__label--max-label">Most Likely</label>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="ss_cl_qstn_action">
                                    <div class="ss-skip-container"><button
                                            class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ss-classic-footer--old" role="contentinfo">
            <div class="ss_classic_footer_right_content_wrap">
                <div class="ss_classic_form_navigator d-flex fx-row fx-jc--center fx-ai--center">
                    <button class="d-flex fx-column fx-jc--center fx-ai--center" type="button" title="Previous"
                        aria-label="Previous">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M13.333 7.667L7.037 1.37.741 7.667"></path>
                        </svg>
                    </button>
                    <button class="d-flex fx-column fx-jc--center fx-ai--center" title="Next" aria-label="Next"
                        type="button" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M.667 1.333L6.963 7.63l6.296-6.296"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='rankorder')
    <div class="surveysparrow-survey-container--classic-form">
        <div class="ss_classic_top_bar d-flex fx-row fx-jc--between fx-ai--center" role="banner">
            <div class="d-flex fx-column fx-jc--center fx-ai--start ss_classic_top_bar_section_details"></div>
        </div>
        <div class="surveysparrow-survey-form-wrapper ss-survey-background" aria-live="polite">
            <div id="fake-scroll-container" class="ss-fp-scroll ss-fake-scroll--center ">
                <div class="ss-fp-scroll__item d-flex fx-column fx-jc--center ss-fp-scroll__item--content-overflow">
                    <div class="ss-fp-scroll__item-data-wrap" style="display: block;">
                        <div id="question_8966750" class="ss_cl_survey_qstn_item active" style="width: 100%;">
                            <div class="ss_cl_survey_qstn_wrapper">
                                <div class="ss_cl_survey_qstn_left d-flex fx-row fx-ai--center">
                                    <p
                                        class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                        Question {{$qusNo}}</p>
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text"
                                            id="question-title-8966750"><span
                                                class="d-block ss-survey-heading--text__span">{{$question->question_name}}</span></h1>
                                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07"
                                            id="question-description-8966750">
                                        <p>
                                            <br>
                                        </p>
                                        </p>
                                    </div>
                                </div>
                            </div><span class="ss_span_wrapper">
                                <div class="ss_options_container ss_options_container--rank-order">
                                    <div class="rank-order-container" role="listbox">
                                    <?php $exiting_choices=$qusvalue!=null ? explode(",",$qusvalue->choices_list): []; ?>
                                        @foreach($exiting_choices as $key=>$choice)
                                            <div data-qa="option_1" class="ss-option--rank-order ss-answer-option--bg-only ss-answer-option--border ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-option--rank-order--ios" style="opacity: 1;">
                                                <div class="ss-option--rank-order__data">
                                                    <span class="ss-option--rank-order__drag-handle-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" fill="none" viewBox="0 0 10 16">
                                                            <circle cx="2" cy="2" r="2" fill="currentColor"></circle>
                                                            <circle cx="2" cy="8" r="2" fill="currentColor"></circle>
                                                            <circle cx="2" cy="14" r="2" fill="currentColor"></circle>
                                                            <circle cx="8" cy="2" r="2" fill="currentColor"></circle>
                                                            <circle cx="8" cy="8" r="2" fill="currentColor"></circle>
                                                            <circle cx="8" cy="14" r="2" fill="currentColor"></circle>
                                                        </svg>
                                                    </span>
                                                    <p id="lb-8966750-23016584">{{$choice}}</p>
                                                </div>
                                                <span class="ss-option--rank-order__select-wrap">
                                                    <div class="css-1pcexqc-container">
                                                        <div class="css-bg1rzq-control ss-option--rank-order-react-select__control">
                                                            <div class="css-1hwfws3 ss-option--rank-order-react-select__value-container ss-option--rank-order-react-select__value-container--has-value">
                                                                <div class="css-dvua67-singleValue ss-option--rank-order-react-select__single-value">
                                                                    {{$key+1}}
                                                                </div>
                                                                <div class="css-1g6gooi">
                                                                    <div class="ss-option--rank-order-react-select__input"
                                                                        style="display: inline-block;">
                                                                        <input type="number" value="" style="box-sizing: content-box; width: 2px; background: 0px center; border: 0px; font-size: inherit; opacity: 0; outline: 0px; padding: 0px; color: inherit;">
                                                                        <div style="position: absolute; top: 0px; left: 0px; visibility: hidden; height: 0px; overflow: scroll; white-space: pre; font-size: 14px; font-family: 'Source Sans Pro'; font-weight: 400; font-style: normal; letter-spacing: normal; text-transform: none;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="css-1wy0on6 ss-option--rank-order-react-select__indicators">
                                                                <span class="css-bgvzuu-indicatorSeparator ss-option--rank-order-react-select__indicator-separator"></span>
                                                                <div class="css-16pqwjk-indicatorContainer ss-option--rank-order-react-select__indicator ss-option--rank-order-react-select__dropdown-indicator">
                                                                    <svg height="20" width="20" viewBox="0 0 20 20" class="css-19bqh2r">
                                                                        <path d="M4.516 7.548c0.436-0.446 1.043-0.481 1.576 0l3.908 3.747 3.908-3.747c0.533-0.481 1.141-0.446 1.574 0 0.436 0.445 0.408 1.197 0 1.615-0.406 0.418-4.695 4.502-4.695 4.502-0.217 0.223-0.502 0.335-0.787 0.335s-0.57-0.112-0.789-0.335c0 0-4.287-4.084-4.695-4.502s-0.436-1.17 0-1.615z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="ss_cl_qstn_action">
                                    <div class="">
                                        <a href="{{route('survey.startsurvey',[$survey->id,$question1->id])}}">
                                            <div class="">
                                                <button id="next_button" data-qa="next_button" data-hotkey-item="hotkey-cta-button" class="ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                    <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="ss-skip-container">
                                        <button 
                                            class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ss-classic-footer--old" role="contentinfo">
            <div class="ss_classic_footer_right_content_wrap">
                <div class="ss_classic_form_navigator d-flex fx-row fx-jc--center fx-ai--center">
                    <button class="inactive d-flex fx-column fx-jc--center fx-ai--center" type="button" title="Previous"
                        aria-label="Previous" disabled="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M13.333 7.667L7.037 1.37.741 7.667"></path>
                        </svg>
                    </button>
                    <button class="d-flex fx-column fx-jc--center fx-ai--center" title="Next" aria-label="Next"
                        type="button" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M.667 1.333L6.963 7.63l6.296-6.296"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='rating')
    <div class="surveysparrow-survey-container--classic-form">
        <div class="ss_classic_top_bar d-flex fx-row fx-jc--between fx-ai--center" role="banner">
            <div class="d-flex fx-column fx-jc--center fx-ai--start ss_classic_top_bar_section_details"></div>
        </div>
        <div class="surveysparrow-survey-form-wrapper ss-survey-background" aria-live="polite">
            <div id="fake-scroll-container" class="ss-fp-scroll ss-fake-scroll--center ">
                <div class="ss-fp-scroll__item d-flex fx-column fx-jc--center">
                    <div class="ss-fp-scroll__item-data-wrap" style="display: block;">
                        <div class="ss_cl_survey_qstn_item active" style="width: 100%;">
                            <div class="ss_cl_survey_qstn_wrapper">
                                <div class="ss_cl_survey_qstn_left d-flex fx-row fx-ai--center">
                                    <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text"> Question {{$qusNo}} </p>
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text" id="question-title-8966749">
                                            <span class="d-block ss-survey-heading--text__span">Give your ratings</span>
                                        </h1>
                                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07" id="question-description-8966749">
                                        <p><br> </p>
                                        </p>
                                    </div>
                                </div>
                            </div> <span class="ss_span_wrapper">
                                <div class="ss_options_container">
                                    <div class="ss_rating_container ss_rating_container--classic ss_component_animated">
                                            @if($icon_type=='smiley_icon')
                                            <div role="radiogroup" class="ss_rating_input">
                                                <button class="answer-option-rating--icons" ss-tooltip--index="1">
                                                    <svg width="22" height="22"
                                                        class="ss-smiley-icon ss-smiley-icon--1 ss-ratingiconsmiley1-1"
                                                        viewBox="0 0 44 44">
                                                        <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            transform="translate(2 2)" class="ss-smiley-icon__g">
                                                            <circle cx="20.125" cy="20.125" r="20.125">
                                                            </circle>
                                                            <path transform="translate(-2 -1)" class="ss-smiley-icon__path"
                                                                d="M9.77783 17.1117C10.7434 15.9261 12.0634 15.2539 13.4445 15.2539C14.8256 15.2539 16.1089 15.9261 17.1112 17.1117M26.889 17.1117C27.8545 15.9261 29.1745 15.2539 30.5556 15.2539C31.9367 15.2539 33.2201 15.9261 34.2223 17.1117"
                                                                stroke="inherit" stroke-width="3" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path transform="translate(-1.7 -1)" class="ss-smiley-icon__path"
                                                                d="M13.4441 31.7765C13.4441 31.7765 16.6537 28.5693 21.9997 28.5693C27.3481 28.5693 30.5552 31.7765 30.5552 31.7765"
                                                                stroke="inherit" stroke-width="3" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </g>
                                                    </svg>
                                                </button>
                                                <button class="answer-option-rating--icons" ss-tooltip--index="2">
                                                    <svg width="22" height="22"
                                                        class="ss-smiley-icon ss-smiley-icon--2 ss-ratingiconsmiley2-2"
                                                        viewBox="0 0 44 44">
                                                        <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            transform="translate(1 1)" class="ss-smiley-icon__g">
                                                            <circle cx="21" cy="21" r="20.125"></circle>
                                                            <path class="ss-smiley-icon__path"
                                                                d="M11.375 17.063a.437.437 0 110 .874.437.437 0 010-.875m19.25.001a.437.437 0 100 .874.437.437 0 000-.875M18.375 34.32a11.9 11.9 0 0112.25-5.25">
                                                            </path>
                                                        </g>
                                                    </svg>
                                                </button>
                                                <button class="answer-option-rating--icons" ss-tooltip--index="3" tabindex="0"
                                                    data-hotkey-refkey="hotkey-item-2" data-hotkey-value="3" role="radio"
                                                    aria-label="3" aria-checked="false"><svg width="22" height="22"
                                                        class="ss-smiley-icon ss-smiley-icon--3 ss-ratingiconsmiley3-3"
                                                        viewBox="0 0 44 44">
                                                        <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            transform="translate(1 1)" class="ss-smiley-icon__g">
                                                            <circle cx="21" cy="21" r="20.125"></circle>
                                                            <path class="ss-smiley-icon__path"
                                                                d="M14.875 13.563a.437.437 0 110 .874.437.437 0 010-.874m12.25 0a.437.437 0 100 .874.437.437 0 000-.874m-17.5 13.562h22.75">
                                                            </path>
                                                        </g>
                                                    </svg>
                                                </button>
                                                <button class="answer-option-rating--icons" ss-tooltip--index="4" tabindex="0"
                                                    data-hotkey-refkey="hotkey-item-3" data-hotkey-value="4" role="radio"
                                                    aria-label="4" aria-checked="false"><svg width="22" height="22"
                                                        class="ss-smiley-icon ss-smiley-icon--4 ss-ratingiconsmiley4-4"
                                                        viewBox="0 0 44 44">
                                                        <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            transform="translate(2 2)" class="ss-smiley-icon__g">
                                                            <circle cx="20.125" cy="20.125" r="20.125"></circle>
                                                            <path class="ss-smiley-icon__path"
                                                                d="M15.75 15.939a4.128 4.128 0 00-7 0m15.75 0a4.128 4.128 0 017 0M9.625 26.25a11.375 11.375 0 0021 0">
                                                            </path>
                                                        </g>
                                                    </svg>
                                                </button>
                                                <button class="answer-option-rating--icons" ss-tooltip--index="5">
                                                    <svg width="22" height="22"
                                                        class="ss-smiley-icon ss-smiley-icon--5 ss-ratingiconsmiley5-5"
                                                        viewBox="0 0 44 44">
                                                        <g fill="none" fill-rule="evenodd" stroke="currentColor"
                                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            transform="translate(1 1)" class="ss-smiley-icon__g">
                                                            <circle cx="21" cy="21" r="20.125"></circle>
                                                            <path class="ss-smiley-icon__path"
                                                                d="M10.5 27.125a11.375 11.375 0 0021 0m-19-7l-4.688-4.89a2.775 2.775 0 01-.525-3.202 2.775 2.775 0 014.443-.72l.765.765.767-.764a2.774 2.774 0 014.441.719 2.774 2.774 0 01-.525 3.203L12.5 20.125zm17 0l4.688-4.891a2.776 2.776 0 00.525-3.203 2.775 2.775 0 00-4.443-.719l-.765.765-.767-.765a2.774 2.774 0 00-4.441.72 2.776 2.776 0 00.525 3.202l4.678 4.891z">
                                                            </path>
                                                        </g>
                                                    </svg>
                                                </button>
                                            </div>
                                            @elseif($icon_type=='star_icon')
                                            <div role="radiogroup" aria-labelledby="question-title-8966749" aria-describedby="question-title-8966749 question-description-8966749" class="ss_rating_input"><button class="answer-option-rating--icons" ss-tooltip--index="1" tabindex="0" data-hotkey-refkey="hotkey-item-0" data-hotkey-value="1" role="radio" aria-label="1" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconstar-1 ss-8966749 " viewBox="0 0 44 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconstar-1 ss-8966749 " d="M21.108 2.09a.955.955 0 011.787 0l4.832 13.7h13.646a.955.955 0 01.62 1.68l-11.402 9.454 4.773 14.337a.955.955 0 01-1.47 1.07L22 33.606l-11.9 8.727a.955.955 0 01-1.464-1.071l4.773-14.337L2.004 17.47a.955.955 0 01.62-1.68h13.649l4.835-13.7z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="2" tabindex="0" data-hotkey-refkey="hotkey-item-1" data-hotkey-value="2" role="radio" aria-label="2" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconstar-2 ss-8966749 " viewBox="0 0 44 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconstar-2 ss-8966749 " d="M21.108 2.09a.955.955 0 011.787 0l4.832 13.7h13.646a.955.955 0 01.62 1.68l-11.402 9.454 4.773 14.337a.955.955 0 01-1.47 1.07L22 33.606l-11.9 8.727a.955.955 0 01-1.464-1.071l4.773-14.337L2.004 17.47a.955.955 0 01.62-1.68h13.649l4.835-13.7z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="3" tabindex="0" data-hotkey-refkey="hotkey-item-2" data-hotkey-value="3" role="radio" aria-label="3" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconstar-3 ss-8966749 " viewBox="0 0 44 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconstar-3 ss-8966749 " d="M21.108 2.09a.955.955 0 011.787 0l4.832 13.7h13.646a.955.955 0 01.62 1.68l-11.402 9.454 4.773 14.337a.955.955 0 01-1.47 1.07L22 33.606l-11.9 8.727a.955.955 0 01-1.464-1.071l4.773-14.337L2.004 17.47a.955.955 0 01.62-1.68h13.649l4.835-13.7z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="4" tabindex="0" data-hotkey-refkey="hotkey-item-3" data-hotkey-value="4" role="radio" aria-label="4" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconstar-4 ss-8966749 " viewBox="0 0 44 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconstar-4 ss-8966749 " d="M21.108 2.09a.955.955 0 011.787 0l4.832 13.7h13.646a.955.955 0 01.62 1.68l-11.402 9.454 4.773 14.337a.955.955 0 01-1.47 1.07L22 33.606l-11.9 8.727a.955.955 0 01-1.464-1.071l4.773-14.337L2.004 17.47a.955.955 0 01.62-1.68h13.649l4.835-13.7z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="5" tabindex="0" data-hotkey-refkey="hotkey-item-4" data-hotkey-value="5" role="radio" aria-label="5" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconstar-5 ss-8966749 " viewBox="0 0 44 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconstar-5 ss-8966749 " d="M21.108 2.09a.955.955 0 011.787 0l4.832 13.7h13.646a.955.955 0 01.62 1.68l-11.402 9.454 4.773 14.337a.955.955 0 01-1.47 1.07L22 33.606l-11.9 8.727a.955.955 0 01-1.464-1.071l4.773-14.337L2.004 17.47a.955.955 0 01.62-1.68h13.649l4.835-13.7z"></path></svg></button></div>
                                            @elseif($icon_type=='thumb_icon')
                                            <div role="radiogroup" aria-labelledby="question-title-8966749" aria-describedby="question-title-8966749 question-description-8966749" class="ss_rating_input"><button class="answer-option-rating--icons" ss-tooltip--index="1" tabindex="0" data-hotkey-refkey="hotkey-item-0" data-hotkey-value="1" role="radio" aria-label="1" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconthumbsup-1 ss-8966749 " viewBox="0 0 44 41"><path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconthumbsup-1 ss-8966749 " d="M2 14.255h3.5c.966 0 1.75.783 1.75 1.75v21a1.75 1.75 0 01-1.75 1.75H2v-24.5zm5.25 19.25c12.843 6.52 12.217 5.661 23.214 5.661 4.606 0 6.926-3.001 8.28-7.399v-.028l3.338-11.2v-.02a3.5 3.5 0 00-3.332-4.514h-8.575a3.5 3.5 0 01-3.384-4.393l1.543-5.852a2.998 2.998 0 00-5.355-2.481l-8.554 12.119a3.5 3.5 0 01-2.86 1.482H7.25v16.625z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="2" tabindex="0" data-hotkey-refkey="hotkey-item-1" data-hotkey-value="2" role="radio" aria-label="2" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconthumbsup-2 ss-8966749 " viewBox="0 0 44 41"><path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconthumbsup-2 ss-8966749 " d="M2 14.255h3.5c.966 0 1.75.783 1.75 1.75v21a1.75 1.75 0 01-1.75 1.75H2v-24.5zm5.25 19.25c12.843 6.52 12.217 5.661 23.214 5.661 4.606 0 6.926-3.001 8.28-7.399v-.028l3.338-11.2v-.02a3.5 3.5 0 00-3.332-4.514h-8.575a3.5 3.5 0 01-3.384-4.393l1.543-5.852a2.998 2.998 0 00-5.355-2.481l-8.554 12.119a3.5 3.5 0 01-2.86 1.482H7.25v16.625z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="3" tabindex="0" data-hotkey-refkey="hotkey-item-2" data-hotkey-value="3" role="radio" aria-label="3" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconthumbsup-3 ss-8966749 " viewBox="0 0 44 41"><path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconthumbsup-3 ss-8966749 " d="M2 14.255h3.5c.966 0 1.75.783 1.75 1.75v21a1.75 1.75 0 01-1.75 1.75H2v-24.5zm5.25 19.25c12.843 6.52 12.217 5.661 23.214 5.661 4.606 0 6.926-3.001 8.28-7.399v-.028l3.338-11.2v-.02a3.5 3.5 0 00-3.332-4.514h-8.575a3.5 3.5 0 01-3.384-4.393l1.543-5.852a2.998 2.998 0 00-5.355-2.481l-8.554 12.119a3.5 3.5 0 01-2.86 1.482H7.25v16.625z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="4" tabindex="0" data-hotkey-refkey="hotkey-item-3" data-hotkey-value="4" role="radio" aria-label="4" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconthumbsup-4 ss-8966749 " viewBox="0 0 44 41"><path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconthumbsup-4 ss-8966749 " d="M2 14.255h3.5c.966 0 1.75.783 1.75 1.75v21a1.75 1.75 0 01-1.75 1.75H2v-24.5zm5.25 19.25c12.843 6.52 12.217 5.661 23.214 5.661 4.606 0 6.926-3.001 8.28-7.399v-.028l3.338-11.2v-.02a3.5 3.5 0 00-3.332-4.514h-8.575a3.5 3.5 0 01-3.384-4.393l1.543-5.852a2.998 2.998 0 00-5.355-2.481l-8.554 12.119a3.5 3.5 0 01-2.86 1.482H7.25v16.625z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="5" tabindex="0" data-hotkey-refkey="hotkey-item-4" data-hotkey-value="5" role="radio" aria-label="5" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconthumbsup-5 ss-8966749 " viewBox="0 0 44 41"><path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconthumbsup-5 ss-8966749 " d="M2 14.255h3.5c.966 0 1.75.783 1.75 1.75v21a1.75 1.75 0 01-1.75 1.75H2v-24.5zm5.25 19.25c12.843 6.52 12.217 5.661 23.214 5.661 4.606 0 6.926-3.001 8.28-7.399v-.028l3.338-11.2v-.02a3.5 3.5 0 00-3.332-4.514h-8.575a3.5 3.5 0 01-3.384-4.393l1.543-5.852a2.998 2.998 0 00-5.355-2.481l-8.554 12.119a3.5 3.5 0 01-2.86 1.482H7.25v16.625z"></path></svg></button></div>
                                            @elseif($icon_type=='crown_icon')
                                            <div class="ss_rating_container ss_rating_container--classic ss_component_animated"><div role="radiogroup" aria-labelledby="question-title-8966749" aria-describedby="question-title-8966749 question-description-8966749" class="ss_rating_input"><button class="answer-option-rating--icons" ss-tooltip--index="1" tabindex="0" data-hotkey-refkey="hotkey-item-0" data-hotkey-value="1" role="radio" aria-label="1" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconcrown-1 ss-8966749 " viewBox="0 0 44 39"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 2)" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconcrown-1 ss-8966749 "><circle cx="3.5" cy="7.583" r="2.625"></circle><circle cx="38.5" cy="7.73" r="2.625"></circle><path d="M7 35h28M7 29.75L3.418 10.199S5.25 19.25 12.25 19.25C19.25 19.25 21 7 21 7s1.75 12.25 8.75 12.25 8.832-8.913 8.832-8.913L35 29.75H7z"></path><circle cx="21" cy="3.5" r="3.5"></circle></g></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="2" tabindex="0" data-hotkey-refkey="hotkey-item-1" data-hotkey-value="2" role="radio" aria-label="2" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconcrown-2 ss-8966749 " viewBox="0 0 44 39"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 2)" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconcrown-2 ss-8966749 "><circle cx="3.5" cy="7.583" r="2.625"></circle><circle cx="38.5" cy="7.73" r="2.625"></circle><path d="M7 35h28M7 29.75L3.418 10.199S5.25 19.25 12.25 19.25C19.25 19.25 21 7 21 7s1.75 12.25 8.75 12.25 8.832-8.913 8.832-8.913L35 29.75H7z"></path><circle cx="21" cy="3.5" r="3.5"></circle></g></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="3" tabindex="0" data-hotkey-refkey="hotkey-item-2" data-hotkey-value="3" role="radio" aria-label="3" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconcrown-3 ss-8966749 " viewBox="0 0 44 39"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 2)" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconcrown-3 ss-8966749 "><circle cx="3.5" cy="7.583" r="2.625"></circle><circle cx="38.5" cy="7.73" r="2.625"></circle><path d="M7 35h28M7 29.75L3.418 10.199S5.25 19.25 12.25 19.25C19.25 19.25 21 7 21 7s1.75 12.25 8.75 12.25 8.832-8.913 8.832-8.913L35 29.75H7z"></path><circle cx="21" cy="3.5" r="3.5"></circle></g></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="4" tabindex="0" data-hotkey-refkey="hotkey-item-3" data-hotkey-value="4" role="radio" aria-label="4" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconcrown-4 ss-8966749 " viewBox="0 0 44 39"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 2)" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconcrown-4 ss-8966749 "><circle cx="3.5" cy="7.583" r="2.625"></circle><circle cx="38.5" cy="7.73" r="2.625"></circle><path d="M7 35h28M7 29.75L3.418 10.199S5.25 19.25 12.25 19.25C19.25 19.25 21 7 21 7s1.75 12.25 8.75 12.25 8.832-8.913 8.832-8.913L35 29.75H7z"></path><circle cx="21" cy="3.5" r="3.5"></circle></g></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="5" tabindex="0" data-hotkey-refkey="hotkey-item-4" data-hotkey-value="5" role="radio" aria-label="5" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconcrown-5 ss-8966749 " viewBox="0 0 44 39"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 2)" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconcrown-5 ss-8966749 "><circle cx="3.5" cy="7.583" r="2.625"></circle><circle cx="38.5" cy="7.73" r="2.625"></circle><path d="M7 35h28M7 29.75L3.418 10.199S5.25 19.25 12.25 19.25C19.25 19.25 21 7 21 7s1.75 12.25 8.75 12.25 8.832-8.913 8.832-8.913L35 29.75H7z"></path><circle cx="21" cy="3.5" r="3.5"></circle></g></svg></button></div></div>
                                            @elseif($icon_type=='user_icon')
                                            <div role="radiogroup" aria-labelledby="question-title-8966749" aria-describedby="question-title-8966749 question-description-8966749" class="ss_rating_input"><button class="answer-option-rating--icons" ss-tooltip--index="1" tabindex="0" data-hotkey-refkey="hotkey-item-0" data-hotkey-value="1" role="radio" aria-label="1" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconuser-1 ss-8966749 " viewBox="0 0 39 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 1)" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconuser-1 ss-8966749 "><circle cx="17.304" cy="12.261" r="11.375"></circle><path d="M35 41.136a18.624 18.624 0 00-35 0h35z"></path></g></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="2" tabindex="0" data-hotkey-refkey="hotkey-item-1" data-hotkey-value="2" role="radio" aria-label="2" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconuser-2 ss-8966749 " viewBox="0 0 39 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 1)" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconuser-2 ss-8966749 "><circle cx="17.304" cy="12.261" r="11.375"></circle><path d="M35 41.136a18.624 18.624 0 00-35 0h35z"></path></g></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="3" tabindex="0" data-hotkey-refkey="hotkey-item-2" data-hotkey-value="3" role="radio" aria-label="3" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconuser-3 ss-8966749 " viewBox="0 0 39 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 1)" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconuser-3 ss-8966749 "><circle cx="17.304" cy="12.261" r="11.375"></circle><path d="M35 41.136a18.624 18.624 0 00-35 0h35z"></path></g></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="4" tabindex="0" data-hotkey-refkey="hotkey-item-3" data-hotkey-value="4" role="radio" aria-label="4" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconuser-4 ss-8966749 " viewBox="0 0 39 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 1)" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconuser-4 ss-8966749 "><circle cx="17.304" cy="12.261" r="11.375"></circle><path d="M35 41.136a18.624 18.624 0 00-35 0h35z"></path></g></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="5" tabindex="0" data-hotkey-refkey="hotkey-item-4" data-hotkey-value="5" role="radio" aria-label="5" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconuser-5 ss-8966749 " viewBox="0 0 39 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 1)" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconuser-5 ss-8966749 "><circle cx="17.304" cy="12.261" r="11.375"></circle><path d="M35 41.136a18.624 18.624 0 00-35 0h35z"></path></g></svg></button></div>
                                            @elseif($icon_type=='thunder_icon')
                                            <div role="radiogroup" aria-labelledby="question-title-8966749" aria-describedby="question-title-8966749 question-description-8966749" class="ss_rating_input"><button class="answer-option-rating--icons" ss-tooltip--index="1" tabindex="0" data-hotkey-refkey="hotkey-item-0" data-hotkey-value="1" role="radio" aria-label="1" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconlightning-1 ss-8966749 " viewBox="0 0 21 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconlightning-1 ss-8966749 " d="M2.4 41.6L8 22H2.856a1.4 1.4 0 01-1.346-1.784l4.799-16.8A1.4 1.4 0 017.656 2.4h10.472a1.4 1.4 0 011.2 2.12L12.2 16.4h5.662a1.4 1.4 0 011.12 2.22L2.4 41.6z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="2" tabindex="0" data-hotkey-refkey="hotkey-item-1" data-hotkey-value="2" role="radio" aria-label="2" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconlightning-2 ss-8966749 " viewBox="0 0 21 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconlightning-2 ss-8966749 " d="M2.4 41.6L8 22H2.856a1.4 1.4 0 01-1.346-1.784l4.799-16.8A1.4 1.4 0 017.656 2.4h10.472a1.4 1.4 0 011.2 2.12L12.2 16.4h5.662a1.4 1.4 0 011.12 2.22L2.4 41.6z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="3" tabindex="0" data-hotkey-refkey="hotkey-item-2" data-hotkey-value="3" role="radio" aria-label="3" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconlightning-3 ss-8966749 " viewBox="0 0 21 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconlightning-3 ss-8966749 " d="M2.4 41.6L8 22H2.856a1.4 1.4 0 01-1.346-1.784l4.799-16.8A1.4 1.4 0 017.656 2.4h10.472a1.4 1.4 0 011.2 2.12L12.2 16.4h5.662a1.4 1.4 0 011.12 2.22L2.4 41.6z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="4" tabindex="0" data-hotkey-refkey="hotkey-item-3" data-hotkey-value="4" role="radio" aria-label="4" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconlightning-4 ss-8966749 " viewBox="0 0 21 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconlightning-4 ss-8966749 " d="M2.4 41.6L8 22H2.856a1.4 1.4 0 01-1.346-1.784l4.799-16.8A1.4 1.4 0 017.656 2.4h10.472a1.4 1.4 0 011.2 2.12L12.2 16.4h5.662a1.4 1.4 0 011.12 2.22L2.4 41.6z"></path></svg></button><button class="answer-option-rating--icons" ss-tooltip--index="5" tabindex="0" data-hotkey-refkey="hotkey-item-4" data-hotkey-value="5" role="radio" aria-label="5" aria-checked="false"><svg width="22" height="22" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconlightning-5 ss-8966749 " viewBox="0 0 21 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill ss-ratingiconlightning-5 ss-8966749 " d="M2.4 41.6L8 22H2.856a1.4 1.4 0 01-1.346-1.784l4.799-16.8A1.4 1.4 0 017.656 2.4h10.472a1.4 1.4 0 011.2 2.12L12.2 16.4h5.662a1.4 1.4 0 011.12 2.22L2.4 41.6z"></path></svg></button></div>
                                            @endif
                                    </div>
                                </div>
                                <div class="ss_cl_qstn_action">
                                    <div class="ss-skip-container"><button data-qa="skip_button"
                                            data-hotkey-item="hotkey-skip-button"
                                            class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                    </div>
                                </div>
                            </span> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ss-classic-footer--old" role="contentinfo">
            <div class="ss_classic_footer_right_content_wrap">
                <div class="ss_classic_form_navigator d-flex fx-row fx-jc--center fx-ai--center">
                    <button class="inactive d-flex fx-column fx-jc--center fx-ai--center" type="button" title="Previous" aria-label="Previous" disabled="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2" d="M13.333 7.667L7.037 1.37.741 7.667"></path>
                        </svg>
                    </button>
                    <button class="d-flex fx-column fx-jc--center fx-ai--center" title="Next" aria-label="Next" type="button" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2" d="M.667 1.333L6.963 7.63l6.296-6.296"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='dropdown')
    <div class="surveysparrow-survey-container--classic-form" data-current-item-id="8966664" data-section-id="4788566">
        <div class="ss_classic_top_bar d-flex fx-row fx-jc--between fx-ai--center" role="banner">
            <div class="d-flex fx-column fx-jc--center fx-ai--start ss_classic_top_bar_section_details"></div>
        </div>
        <div class="surveysparrow-survey-form-wrapper ss-survey-background" aria-live="polite">
            <div id="fake-scroll-container" class="ss-fp-scroll ss-fake-scroll--center ">
                <div class="ss-fp-scroll__item d-flex fx-column fx-jc--center ss-fp-scroll__item--content-overflow">
                    <div class="ss-fp-scroll__item-data-wrap" style="display: block;">
                        <div id="question_8966664" data-qa-question-id="8966664" data-qa-question-type="Dropdown"
                            data-qa="question_normal"
                            class="ss_cl_survey_qstn_item active ss_cl_survey_qstn_item--has-dropdown" style="width: 100%;">
                            <div class="ss_cl_survey_qstn_wrapper">
                                <div class="ss_cl_survey_qstn_left d-flex fx-row fx-ai--center">
                                    <p
                                        class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                        Question 1</p>
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text"
                                            id="question-title-8966664"><span
                                                class="d-block ss-survey-heading--text__span">Choose your ans</span></h1>
                                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07"
                                            id="question-description-8966664">
                                        <p>
                                            <br>
                                        </p>
                                        </p>
                                    </div>
                                </div>
                            </div><span class="ss_span_wrapper">
                                <div class="ss_options_container">
                                    <div
                                        class="dropdown-container ss_component_animated answer-option--input ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--primary">
                                        <div class="css-1pcexqc-container ss-eui-dropdown">
                                            <div class="css-bg1rzq-control ss-eui-dropdown__control">
                                                <div
                                                    class="css-1hwfws3 ss-eui-dropdown__value-container ss-eui-dropdown__value-container--has-value">
                                                    <div class="css-dvua67-singleValue ss-eui-dropdown__single-value">Option
                                                        B</div>
                                                    <div class="css-1g6gooi">
                                                        <div class="ss-eui-dropdown__input" style="display: inline-block;">
                                                            <input autocapitalize="none" autocomplete="off"
                                                                autocorrect="off" id="react-select-3-input"
                                                                spellcheck="false" tabindex="0" type="text"
                                                                aria-autocomplete="list"
                                                                aria-labelledby="question-title-8966664" value=""
                                                                aria-valuetext="Option B, selected"
                                                                style="box-sizing: content-box; width: 2px; background: 0px center; border: 0px; font-size: inherit; opacity: 1; outline: 0px; padding: 0px; color: inherit;">
                                                            <div
                                                                style="position: absolute; top: 0px; left: 0px; visibility: hidden; height: 0px; overflow: scroll; white-space: pre; font-size: 18px; font-family: 'Source Sans Pro'; font-weight: 400; font-style: normal; letter-spacing: normal; text-transform: none;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="css-1wy0on6 ss-eui-dropdown__indicators"><span
                                                        class="css-bgvzuu-indicatorSeparator ss-eui-dropdown__indicator-separator"></span>
                                                    <div aria-hidden="true"
                                                        class="css-16pqwjk-indicatorContainer ss-eui-dropdown__indicator ss-eui-dropdown__dropdown-indicator">
                                                        <svg height="20" width="20" viewBox="0 0 20 20" aria-hidden="true"
                                                            focusable="false" class="css-19bqh2r">
                                                            <path
                                                                d="M4.516 7.548c0.436-0.446 1.043-0.481 1.576 0l3.908 3.747 3.908-3.747c0.533-0.481 1.141-0.446 1.574 0 0.436 0.445 0.408 1.197 0 1.615-0.406 0.418-4.695 4.502-4.695 4.502-0.217 0.223-0.502 0.335-0.787 0.335s-0.57-0.112-0.789-0.335c0 0-4.287-4.084-4.695-4.502s-0.436-1.17 0-1.615z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <input name="timeZone" type="hidden" value="23016365"><span
                                                class="ss-form-group__highlight"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ss_cl_qstn_action">
                                    <div class="ss-skip-container">
                                        <button data-qa="skip_button" data-hotkey-item="hotkey-skip-button"
                                            class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ss-classic-footer--old" role="contentinfo">
            <div class="ss_classic_footer_right_content_wrap">
                <div class="ss_classic_form_navigator d-flex fx-row fx-jc--center fx-ai--center">
                    <button class="inactive d-flex fx-column fx-jc--center fx-ai--center" type="button" title="Previous"
                        aria-label="Previous" disabled="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M13.333 7.667L7.037 1.37.741 7.667"></path>
                        </svg>
                    </button>
                    <button class="d-flex fx-column fx-jc--center fx-ai--center" title="Next" aria-label="Next"
                        type="button" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M.667 1.333L6.963 7.63l6.296-6.296"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='picturechoice')
    <div class="surveysparrow-survey-container--classic-form" data-current-item-id="8972084" data-section-id="4791226">
        <div class="ss_classic_top_bar d-flex fx-row fx-jc--between fx-ai--center" role="banner">
            <div class="d-flex fx-column fx-jc--center fx-ai--start ss_classic_top_bar_section_details"></div>
        </div>
        <div class="surveysparrow-survey-form-wrapper ss-survey-background" aria-live="polite">
            <div id="fake-scroll-container" class="ss-fp-scroll ss-fake-scroll--center ">
                <div class="ss-fp-scroll__item d-flex fx-column fx-jc--center ss-fp-scroll__item--content-overflow">
                    <div class="ss-fp-scroll__item-data-wrap" style="display: block;">
                        <div id="question_8972084" data-qa-question-id="8972084" data-qa-question-type="MultiChoicePicture"
                            data-qa="question_normal" class="ss_cl_survey_qstn_item active" style="width: 100%;">
                            <div class="ss_cl_survey_qstn_wrapper">
                                <div class="ss_cl_survey_qstn_left d-flex fx-row fx-ai--center">
                                    <p
                                        class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                        Question 1</p>
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text"
                                            id="question-title-8972084"><span
                                                class="d-block ss-survey-heading--text__span">select picture</span></h1>
                                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07"
                                            id="question-description-8972084">
                                        <p>
                                            <br>
                                        </p>
                                        </p>
                                    </div>
                                </div>
                            </div><span class="ss_span_wrapper">
                                <div class="ss_options_container">
                                    <div class="ss_multiple_choice_visual ss_component_animated" role="radiogroup"
                                        aria-labelledby="question-title-8972084"
                                        aria-describedby="question-title-8972084 question-description-8972084">
                                        <div tabindex="0"
                                            class="ss-answer-option--picture-choice ss-answer-option--border ss-answer-option--bg ss-answer-option--text-light ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-item--has-key-assist"
                                            data-qa="option_0" name="8972084-23036772" role="radio"
                                            data-hotkey-refkey="hotkey-item-A" data-hotkey-value="23036772"
                                            aria-checked="false">
                                            <div class="ss-option-checked--picture"><svg width="24" height="24"
                                                    viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M12.7698 4.20939C13.0684 4.49648 13.0777 4.97127 12.7906 5.26984L6.54055 11.7699C6.39617 11.92 6.19584 12.0034 5.98755 11.9999C5.77927 11.9965 5.5818 11.9066 5.44245 11.7517L3.19248 9.25171C2.91539 8.94383 2.94035 8.46961 3.24823 8.19252C3.55612 7.91543 4.03034 7.94039 4.30743 8.24828L6.01809 10.1491L11.7093 4.23018C11.9964 3.9316 12.4712 3.92229 12.7698 4.20939Z"
                                                        fill="#FFFFFF"></path>
                                                </svg></div>
                                            <div
                                                class="ss-picturechoice-image-holder ss-picturechoice-image--holder--cover">
                                                <div class="ss-img-container ss-img-container--default"><img
                                                        alt="bird's eye view photograph of green mountains"
                                                        class="ss-img-container__img ss-img-container__cover"
                                                        src="https://images.unsplash.com/photo-1501854140801-50d01698950b?crop=entropy&amp;cs=tinysrgb&amp;fit=max&amp;fm=jpg&amp;ixid=M3w4MDMyOHwwfDF8c2VhcmNofDN8fG5hdHVyZXxlbnwwfHx8fDE3MDgzMzMyOTN8MA&amp;ixlib=rb-4.0.3&amp;q=80&amp;w=400"
                                                        style="object-fit: cover; height: 100%; width: 100%;"></div>
                                                <div class="ss-img-container ss-img-container--fallback"
                                                    style="background-image: url(&quot;https://images.unsplash.com/photo-1501854140801-50d01698950b?crop=entropy&amp;cs=tinysrgb&amp;fit=max&amp;fm=jpg&amp;ixid=M3w4MDMyOHwwfDF8c2VhcmNofDN8fG5hdHVyZXxlbnwwfHx8fDE3MDgzMzMyOTN8MA&amp;ixlib=rb-4.0.3&amp;q=80&amp;w=400&quot;); background-size: cover;">
                                                </div>
                                            </div>
                                            <div class="ss-choice-content">
                                                <p title="a">a</p>
                                                <div class="ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--bold ss-option-no"
                                                    aria-label="Press A to select">
                                                    <div class="ss-option-no__key-assist">KEY</div>
                                                    <div class="ss-option-no__index">A</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div tabindex="0"
                                            class="ss-answer-option--picture-choice ss-answer-option--border ss-answer-option--bg ss-answer-option--text-light ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-item--has-key-assist"
                                            data-qa="option_1" name="8972084-23036794" role="radio"
                                            data-hotkey-refkey="hotkey-item-B" data-hotkey-value="23036794"
                                            aria-checked="false">
                                            <div class="ss-option-checked--picture"><svg width="24" height="24"
                                                    viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M12.7698 4.20939C13.0684 4.49648 13.0777 4.97127 12.7906 5.26984L6.54055 11.7699C6.39617 11.92 6.19584 12.0034 5.98755 11.9999C5.77927 11.9965 5.5818 11.9066 5.44245 11.7517L3.19248 9.25171C2.91539 8.94383 2.94035 8.46961 3.24823 8.19252C3.55612 7.91543 4.03034 7.94039 4.30743 8.24828L6.01809 10.1491L11.7093 4.23018C11.9964 3.9316 12.4712 3.92229 12.7698 4.20939Z"
                                                        fill="#FFFFFF"></path>
                                                </svg></div>
                                            <div
                                                class="ss-picturechoice-image-holder ss-picturechoice-image--holder--cover">
                                                <div class="ss-img-container ss-img-container--default"><img
                                                        alt="foggy mountain summit"
                                                        class="ss-img-container__img ss-img-container__cover"
                                                        src="https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?crop=entropy&amp;cs=tinysrgb&amp;fit=max&amp;fm=jpg&amp;ixid=M3w4MDMyOHwwfDF8c2VhcmNofDV8fG5hdHVyZXxlbnwwfHx8fDE3MDgzMzMyOTN8MA&amp;ixlib=rb-4.0.3&amp;q=80&amp;w=400"
                                                        style="object-fit: cover; height: 100%; width: 100%;"></div>
                                                <div class="ss-img-container ss-img-container--fallback"
                                                    style="background-image: url(&quot;https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?crop=entropy&amp;cs=tinysrgb&amp;fit=max&amp;fm=jpg&amp;ixid=M3w4MDMyOHwwfDF8c2VhcmNofDV8fG5hdHVyZXxlbnwwfHx8fDE3MDgzMzMyOTN8MA&amp;ixlib=rb-4.0.3&amp;q=80&amp;w=400&quot;); background-size: cover;">
                                                </div>
                                            </div>
                                            <div class="ss-choice-content">
                                                <p title="b">b</p>
                                                <div class="ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--bold ss-option-no"
                                                    aria-label="Press B to select">
                                                    <div class="ss-option-no__key-assist">KEY</div>
                                                    <div class="ss-option-no__index">B</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ss_cl_qstn_action">
                                    <div class="ss-skip-container"><button data-qa="skip_button"
                                            data-hotkey-item="hotkey-skip-button"
                                            class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ss-classic-footer--old" role="contentinfo">
            <div class="ss_classic_footer_right_content_wrap">
                <div class="ss_classic_form_navigator d-flex fx-row fx-jc--center fx-ai--center">
                    <button class="inactive d-flex fx-column fx-jc--center fx-ai--center" type="button" title="Previous"
                        aria-label="Previous" disabled="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M13.333 7.667L7.037 1.37.741 7.667"></path>
                        </svg>
                    </button>
                    <button class="d-flex fx-column fx-jc--center fx-ai--center" title="Next" aria-label="Next"
                        type="button" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M.667 1.333L6.963 7.63l6.296-6.296"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='email')
    <div class="surveysparrow-survey-container--classic-form" data-current-item-id="8966644" data-section-id="4788547">
        <div class="ss_classic_top_bar d-flex fx-row fx-jc--between fx-ai--center" role="banner">
            <div class="d-flex fx-column fx-jc--center fx-ai--start ss_classic_top_bar_section_details"></div>
        </div>
        <div class="surveysparrow-survey-form-wrapper ss-survey-background" aria-live="polite">
            <div id="fake-scroll-container" class="ss-fp-scroll ss-fake-scroll--center ">
                <div class="ss-fp-scroll__item d-flex fx-column fx-jc--center">
                    <div class="ss-fp-scroll__item-data-wrap" style="display: block;">
                        <div id="question_8966644" data-qa-question-id="8966644" data-qa-question-type="EmailInput"
                            data-qa="question_normal" class="ss_cl_survey_qstn_item active" style="width: 100%;">
                            <div class="ss_cl_survey_qstn_wrapper">
                                <div class="ss_cl_survey_qstn_left d-flex fx-row fx-ai--center">
                                    <p
                                        class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                        Question 1</p>
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text"
                                            id="question-title-8966644"><span
                                                class="d-block ss-survey-heading--text__span">Enter you email</span></h1>
                                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07"
                                            id="question-description-8966644">
                                        <p>
                                            <br>
                                        </p>
                                        </p>
                                    </div>
                                </div>
                            </div><span class="ss_span_wrapper">
                                <div class="ss_options_container">
                                    <div
                                        class="ss_inline_input_container ss_component_animated ss-form-group ss-form-group--lg-col-6">
                                        <input type="email" inputmode="email"
                                            class="answer-option--input ss-survey-font-family ss-survey-text-size--2xl sm_ss-survey-text-size--lg ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-border-style--solid ss-survey-border-color--primary  ss-survey-text-color--secondary answer-option--input"
                                            placeholder="Please enter an email" autocomplete="new-password"
                                            aria-labelledby="question-title-8966644"
                                            aria-describedby="question-title-8966644 question-description-8966644"
                                            value=""><span class="ss-form-group__highlight"></span>
                                    </div>
                                </div>
                                <div class="ss_cl_qstn_action">
                                    <div class="action-btn--disabled">
                                        <button id="next_button" data-qa="next_button" data-hotkey-item="hotkey-cta-button"
                                            class="ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"
                                            disabled=""><span class="ss-primary-action-btn__copy">Next</span>
                                            <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z"
                                                    stroke-width="1"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="ss-skip-container">
                                        <button data-qa="skip_button" data-hotkey-item="hotkey-skip-button"
                                            class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ss-classic-footer--old" role="contentinfo">
            <div class="ss_classic_footer_right_content_wrap">
                <div class="ss_classic_form_navigator d-flex fx-row fx-jc--center fx-ai--center">
                    <button class="inactive d-flex fx-column fx-jc--center fx-ai--center" type="button" title="Previous"
                        aria-label="Previous" disabled="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M13.333 7.667L7.037 1.37.741 7.667"></path>
                        </svg>
                    </button>
                    <button class="d-flex fx-column fx-jc--center fx-ai--center" title="Next" aria-label="Next"
                        type="button" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="9" viewBox="0 0 14 9">
                            <path fill="none" stroke="#888589" class="svgColor" stroke-width="2"
                                d="M.667 1.333L6.963 7.63l6.296-6.296"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='thank_you')
    <div class="surveysparrow-survey-container--classic-form welcome-page">
        <div class="ss-fp-section surveysparrow-survey-form-wrapper--centered ss-survey-background d-flex fx-column fx-jc--center fx-ai--center">
            <div class="ss-fp-section__frame ss_classic_survey_intro_contents">
                <div class="ss-fp-section__inner-frame">
                    
                        <h3 class="ss-header-text--fluid ss-survey-heading--text ss-survey-font-family ss-survey-line-height--normal ss-survey-text-weight--semibold ss-survey-text-color--primary ss-survey-text-align--center ss-survey-text-question-text main-header-font-size--md">
                            @if(isset($qusvalue->thankyou_title))
                                <p>{{$qusvalue->thankyou_title}}</p>
                            @endif
                            @if(isset($qusvalue->thankyou_image))
                            <figure>
                                <span>
                                    <div class="ss_image_wrapper">
                                        <img src="{{ asset('uploads/survey/'.$qusvalue->thankyou_image) }}" alt="thank you image">
                                    </div>
                                </span>
                            </figure>
                            @endif
                        </h3>
                        @if(isset($qusvalue->thankyou_imagetitle))
                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$qusvalue->thankyou_imagetitle}}</p>
                        @endif
                </div>
            </div>
        </div>
    </div>

    @endif
</body>

</html>