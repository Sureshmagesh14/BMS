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
$azRange = range('A', 'Z'); ?>

<body>
<p>{{$question->qus_type}}</p>
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
                                    <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">Question 4</p>
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
                                <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                Question 5</p>
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
                                    <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                        Question 1
                                    </p>
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
                                <p
                                    class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                    Question 2</p>
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

    @endif
</body>

</html>