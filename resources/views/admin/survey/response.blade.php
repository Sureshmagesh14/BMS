<html>
<head>
    <link href="{{ asset('assets/css/preview.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .disabled.ss-primary-action-btn {
            opacity: 0.3 !important;
        }
        .rankorderkey_option.ss-option--rank-order__select-wrap .ss-option--rank-order-react-select__control{
            color:rgb(63, 63, 63);
            background-color:rgb(255, 255, 255)
        }
       select.rankorderkey {
            outline: 0px;
            background: unset !important;
            border: white !important;
            width: 100%;
            text-align: center;
        }
        button#back_editor {
            position: fixed;
            right: 10%;
            top: 3%;
            z-index: 999;
        }
        input#update_qus, .matrixbtn, #preview_qus, #back_editor {
            color: white !important;
            background: #4A9CA6;
            border: 1px solid #4A9CA6;
            box-shadow: none !important;
            padding: 0.5rem 1rem;
        }
        .rank-order-container {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<?php $qusvalue = json_decode($question->qus_ans);
$azRange = range('A', 'Z');
$qusNo=1;
$icon_type='';
$left_label='Least Likely';
$middle_label='Netural';
$right_label='Most Likely';
if(isset($qusvalue->icon_type)){
    $icon_type=$qusvalue->icon_type;
}
foreach($questionsset as $key=>$qus){
    if($question->id==$qus->id){
        $qusNo=$qusNo+$key;
    }
}
if(isset($qusvalue->right_label)){
    $right_label=$qusvalue->right_label;
}
if(isset($qusvalue->middle_label)){
    $middle_label=$qusvalue->middle_label;
}
if(isset($qusvalue->left_label)){
    $left_label=$qusvalue->left_label;
}
 ?>
<body>
<?php  $qus_url=route('survey.builder',[$survey->builderID,$question->id]); ?>
<input type="hidden" value="{{$question->qus_type}}" id="question_type"/>
<input type="hidden" value="" id="answered"/>
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
                            <a href="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif">
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
                                                <div class="">
                                                    <a href="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif">
                                                        <button id="next_button" data-qa="next_button" data-hotkey-item="hotkey-cta-button" class="ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                            <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                            </svg>
                                                        </button>   
                                                    </a>
                                                </div>
                                                <div class="ss-skip-container">
                                                    <a href="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif">
                                                        <button class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                                    </a>
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
                                        <button class="{{$question->qus_type}}_choice ss-answer-option--choice ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-item--has-key-assist">
                                            <span class="ss-answer-option--choice__copy ans_val">{{$choice}}</span>
                                            <div class="ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--bold ss-option-no">
                                                <span class="ss-option-no__index">{{$azRange[$key]}}</span></div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="ss_cl_qstn_action disabled {{$question->qus_type}}_action">
                                    <div class="">
                                            <button data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif"  id="next_button"  class="disabled ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg>
                                            </button>
                                    </div>
                                    <div class="ss-skip-container">
                                        <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                    </div>
                            </div>
                        </span>
                    </div>
                    </div>
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
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                            <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
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
                                        <textarea class="text-ans-input answer-option--input ss-survey-font-family ss-survey-text-size--2xl sm_ss-survey-text-size--lg ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-border-style--solid ss-survey-border-color--primary  ss-survey-text-color--secondary"
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
                                        <input type="text" class="text-ans-input answer-option--input ss-survey-font-family ss-survey-text-size--2xl sm_ss-survey-text-size--lg ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-border-style--solid ss-survey-border-color--primary  ss-survey-text-color--secondary" placeholder="Please enter your response" maxlength="1000" style="max-height: 200px; height: 36.8px;"></textarea>
                                        <span class="ss-form-group__highlight"></span>
                                    </div>
                                </div>
                                @endif
                                <div class="ss_cl_qstn_action disabled {{$question->qus_type}}_action">
                                    <div class="">
                                            <button data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif"  id="next_button"  class="disabled ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg>
                                            </button>
                                    </div>
                                    <div class="ss-skip-container">
                                        <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                    </div>
                            </div>
                            </span>
                        </div>
                    </div>
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
                                            <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic">1
                                                <label class="ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-option__label ss-answer-option__label--min-label">{{$left_label}}</label>
                                            </button>
                                            <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >2</button>
                                            <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >3</button>
                                            <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic">4</button>
                                            <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >5
                                                <label class="ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-option__label ss-answer-option__label--middle-label">{{$middle_label}}</label>
                                            </button>
                                            <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic">6</button>
                                            <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic">7</button>
                                            <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic">8</button>
                                            <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >9
                                                <label class="ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-option__label ss-answer-option__label--max-label">{{$right_label}}</label>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="ss_cl_qstn_action">
                                    <div class="ss-skip-container">
                                        <a href="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif">
                                            <button class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                        </a>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
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
                                <?php $exiting_choices=$qusvalue!=null ? explode(",",$qusvalue->choices_list): []; $dropdowncount=count($exiting_choices); ?>
                                    <input type="hidden" id="rank_order_value" value="{{implode(',',$exiting_choices)}}"/>
                                    <input type="hidden" id="dropdowncount" value="{{$dropdowncount}}"/>
                                    <div class="rank-order-container rank_option_container" id="rank_order_container">
                                        @foreach($exiting_choices as $key=>$choice)
                                            <div data-id="{{$key+1}}" id="rank_option_{{$key+1}}" class="rank_option ss-option--rank-order ss-answer-option--bg-only ss-answer-option--border ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-option--rank-order--ios" style="opacity: 1;">
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
                                                    <p>{{$choice}}</p>
                                                </div>
                                                <span class="rankorderkey_option ss-option--rank-order__select-wrap">
                                                    <div class="css-1pcexqc-container">
                                                        <div class="css-bg1rzq-control ss-option--rank-order-react-select__control">
                                                            <div class="css-1hwfws3 ss-option--rank-order-react-select__value-container ss-option--rank-order-react-select__value-container--has-value">
                                                                <select class="rankorderkey" data-value="{{$key+1}}" name="rankorderkey" id="rankorderkey{{$key+1}}">
                                                                    @for($i=1; $i<=$dropdowncount; $i++)
                                                                        @if($key+1==$i)
                                                                        <option value="{{$i}}" selected>{{$i}}</option>
                                                                        @else
                                                                        <option value="{{$i}}">{{$i}}</option>
                                                                        @endif
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="ss_cl_qstn_action disabled {{$question->qus_type}}_action">
                                    <div class="">
                                            <button data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif"  id="next_button"  class="disabled ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg>
                                            </button>
                                    </div>
                                    <div class="ss-skip-container">
                                        <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                    </div>
                            </div>
                            </span>
                        </div>
                    </div>
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
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                            <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
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
                                    <div class="ss-skip-container">
                                        <a href="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif">
                                            <button class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                        </a>
                                    </div>
                                </div>
                            </span> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='dropdown')
    <div class="surveysparrow-survey-container--classic-form">
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
                                    <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                        Question {{$qusNo}}
                                    </p>
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                            <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                        </h1>
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
                                <?php $exiting_choices=$qusvalue!=null ? explode(",",$qusvalue->choices_list): []; ?>
                                    <div class="dropdown-container ss_component_animated answer-option--input ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--primary">
                                        <select class="select2 form-control select2-multiple" id="dropdownlist" name="dropdownlist" data-placeholder="Choose ...">
                                            <option value="">Choose your choice</option>
                                            @foreach($exiting_choices as $key=>$value)
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="ss_cl_qstn_action">
                                <div class="ss-skip-container">
                                        <a href="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif">
                                            <button class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                        </a>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='picturechoice')
    <div class="surveysparrow-survey-container--classic-form">
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
                                    <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                        Question {{$qusNo}}
                                    </p>
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                            <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                        </h1>
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
                                    <div class="ss_multiple_choice_visual ss_component_animated">
                                    <?php $exiting_choices=$qusvalue!=null ? json_decode($qusvalue->choices_list): []; ?>
                                        @if($exiting_choices!=null)
                                            @foreach($exiting_choices as $key=>$choice)
                                                <div class="ss-answer-option--picture-choice ss-answer-option--border ss-answer-option--bg ss-answer-option--text-light ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-item--has-key-assist">
                                                    <div class="ss-option-checked--picture">
                                                        <svg width="24" height="24" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7698 4.20939C13.0684 4.49648 13.0777 4.97127 12.7906 5.26984L6.54055 11.7699C6.39617 11.92 6.19584 12.0034 5.98755 11.9999C5.77927 11.9965 5.5818 11.9066 5.44245 11.7517L3.19248 9.25171C2.91539 8.94383 2.94035 8.46961 3.24823 8.19252C3.55612 7.91543 4.03034 7.94039 4.30743 8.24828L6.01809 10.1491L11.7093 4.23018C11.9964 3.9316 12.4712 3.92229 12.7698 4.20939Z" fill="#FFFFFF"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="ss-picturechoice-image-holder ss-picturechoice-image--holder--cover">
                                                        <div class="ss-img-container ss-img-container--default">
                                                            <img alt="{{$choice->text}}" class="ss-img-container__img ss-img-container__cover" src="{{$choice->img}}" style="object-fit: contain; height: 100%; width: 100%;">
                                                        </div>
                                                        <div class="ss-img-container ss-img-container--fallback" style="background-image: url(&quot;{{$choice->img}}&quot;); background-size: cover;">
                                                        </div>
                                                    </div>
                                                    <div class="ss-choice-content">
                                                        <p title="{{$choice->text}}">{{$choice->text}}</p>
                                                        <div class="ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--bold ss-option-no"
                                                            aria-label="Press {{$azRange[$key]}} to select">
                                                            <div class="ss-option-no__index">{{$azRange[$key]}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="ss_cl_qstn_action">
                                <div class="ss-skip-container">
                                        <a href="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif">
                                            <button class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                        </a>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif($question->qus_type=='email')
    <div class="surveysparrow-survey-container--classic-form">
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
                                    <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                        Question {{$qusNo}}
                                    </p>
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                        <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                            <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                        </h1>
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
                                            class="text-ans-input answer-option--input ss-survey-font-family ss-survey-text-size--2xl sm_ss-survey-text-size--lg ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-border-style--solid ss-survey-border-color--primary  ss-survey-text-color--secondary answer-option--input"
                                            placeholder="Please enter an email" autocomplete="new-password"
                                            aria-labelledby="question-title-8966644"
                                            aria-describedby="question-title-8966644 question-description-8966644"
                                            value=""><span class="ss-form-group__highlight"></span>
                                    </div>
                                </div>
                                
                                <div class="ss_cl_qstn_action disabled {{$question->qus_type}}_action">
                                    <div class="">
                                            <button data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif"  id="next_button"  class="disabled ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg>
                                            </button>
                                    </div>
                                    <div class="ss-skip-container">
                                        <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                    </div>
                            </div>
                            </span>
                        </div>
                    </div>
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
    <form id="skip_qus" style="display:none;" action="{{route('survey.submitans')}}" method="POST">
        @csrf
        <input type="text" id="question_id" value="{{$question->id}}" name="question_id"/>
        <input type="text" id="survey_id" value="{{$survey->id}}" name="survey_id"/>
        <input type="text" id="next_qus" name="next_qus"/>
        <input type="text" id="user_ans" name="user_ans"/>
        <input type="text" id="skip_ans" name="skip_ans"/>
    </form>
</body>
<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>

<script>
$('.text-ans-input').change(function(){
    if($(this).val()!=''){
        $('#next_button').removeClass('disabled');
        $('#answered').val('yes');
    }else{
        $('#next_button').addClass('disabled');
        $('#answered').val('no');
    }
});
$('.single_choice_choice').click(function(){
    $(this).toggleClass("active");
    $('.single_choice_choice').not(this).removeClass("active");
    // Enable Next Button 
    enableNextButton('.single_choice_choice','.single_choice_action')
});
function enableNextButton(classname,btnname){
    // Enable Next Button 
    var enable=0;
    $(classname).each(function(){
        if($(this).hasClass('active')){
            enable=1;
        }
    });
    if(enable==1){
        $(btnname).toggleClass('disabled');
        $('#next_button').removeClass('disabled');
        $('#answered').val('yes');
    }else{
        $(btnname).toggleClass('disabled');
        $('#next_button').addClass('disabled');
        $('#answered').val('no');
    }
}
$('.likert_choice').click(function(){
    $(this).toggleClass("active");
    $('.likert_choice').not(this).removeClass("active");
});
$('.multi_choice_choice').click(function(){
    $(this).toggleClass("active");
    enableNextButton('.multi_choice_choice','.multi_choice_action')

});
$('.answer-option-rating--icons').click(function(){
    $(this).toggleClass("active");
    $('.answer-option-rating--icons').not(this).removeClass("active");
});
$('#back_editor').click(function(){
    let url=$('#back_editor').data('url');
    window.location.href=url+"?pagetype=editor";
});
$('.ss-answer-option--picture-choice').click(function(){
    $(this).toggleClass("active");
    $('.ss-answer-option--picture-choice').not(this).removeClass("active");
});
var array = $('#rank_order_value').val();
document.addEventListener("DOMContentLoaded", (event) => {
    if(array!=undefined && array!=''){
        array=array.split(",");
    }else{
        array=[];
    }
    var elem='';
    array.forEach((value,key)=>{
        let val1=key+1;
        let option=$('#dropdowncount').val();
        let optionval='';
        for(let v=1; v<=option; v++){
            if(v==val1){
                optionval+='<option selected value='+v+'>'+v+'</option>';
            }else{
                optionval+='<option value='+v+'>'+v+'</option>';
            } 
        }
        elem+='<div class="rank_option ss-option--rank-order ss-answer-option--bg-only ss-answer-option--border ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-option--rank-order--ios" style="opacity: 1;"><div class="ss-option--rank-order__data"><span class="ss-option--rank-order__drag-handle-icon"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" fill="none" viewBox="0 0 10 16"><circle cx="2" cy="2" r="2" fill="currentColor"></circle><circle cx="2" cy="8" r="2" fill="currentColor"></circle><circle cx="2" cy="14" r="2" fill="currentColor"></circle><circle cx="8" cy="2" r="2" fill="currentColor"></circle><circle cx="8" cy="8" r="2" fill="currentColor"></circle><circle cx="8" cy="14" r="2" fill="currentColor"></circle></svg></span><p>'+value+'</p></div><span class="rankorderkey_option ss-option--rank-order__select-wrap"><div class="css-1pcexqc-container"><div class="css-bg1rzq-control ss-option--rank-order-react-select__control"><div class="css-1hwfws3 ss-option--rank-order-react-select__value-container ss-option--rank-order-react-select__value-container--has-value"><select onchange="changepos(`'+value+'`,event)"  class="rankorderkey" name="rankorderkey">'+optionval+'</select></div></div></div></span></div>';
    });
    if(elem!='')
    document.getElementById('rank_order_container').innerHTML = elem;
});
function changepos(val,event){
    const index = array.indexOf(val);
    if (index > -1) { 
    array.splice(index, 1); 
    }
    array.splice(event.target.value-1, 0, val);
    var elem='';
    array.forEach((value,key)=>{
        let val1=key+1;
        let option=$('#dropdowncount').val();
        let optionval='';
        for(let v=1; v<=option; v++){
            if(v==val1){
                optionval+='<option selected value='+v+'>'+v+'</option>';
            }else{
                optionval+='<option value='+v+'>'+v+'</option>';
            } 
        }
        elem+='<div class="rank_option ss-option--rank-order ss-answer-option--bg-only ss-answer-option--border ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-option--rank-order--ios" style="opacity: 1;"><div class="ss-option--rank-order__data"><span class="ss-option--rank-order__drag-handle-icon"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" fill="none" viewBox="0 0 10 16"><circle cx="2" cy="2" r="2" fill="currentColor"></circle><circle cx="2" cy="8" r="2" fill="currentColor"></circle><circle cx="2" cy="14" r="2" fill="currentColor"></circle><circle cx="8" cy="2" r="2" fill="currentColor"></circle><circle cx="8" cy="8" r="2" fill="currentColor"></circle><circle cx="8" cy="14" r="2" fill="currentColor"></circle></svg></span><p>'+value+'</p></div><span class="rankorderkey_option ss-option--rank-order__select-wrap"><div class="css-1pcexqc-container"><div class="css-bg1rzq-control ss-option--rank-order-react-select__control"><div class="css-1hwfws3 ss-option--rank-order-react-select__value-container ss-option--rank-order-react-select__value-container--has-value"><select onchange="changepos(`'+value+'`,event)"  class="rankorderkey" name="rankorderkey">'+optionval+'</select></div></div></div></span></div>';
    });
    document.getElementById('rank_order_container').innerHTML = elem;
}

$('#next_button').click(function(){
    let submit = 0;
    console.log($('#question_type').val(),"next_button");
    if($('#question_type').val() =='single_choice'){
        if($('#answered').val() == 'yes'){
           $('#user_ans').val($('.single_choice_choice.active .ans_val').text());
           submit = 1;
        }
    }else if($('#question_type').val() =='open_qus'){
        if($('#answered').val() == 'yes'){
           $('#user_ans').val($('.text-ans-input').val());
           submit = 1;
        }
        

    }else if ($('#question_type').val() == 'multi_choice'){
        if($('#answered').val() == 'yes'){
            let arr = [];
            $('.multi_choice_choice.active .ans_val').each(function(){ 
                arr.push($(this).text());
            });
           $('#user_ans').val(arr.toString());
           submit = 1;
        }
    }
    if(submit == 1){
        $('#next_qus').val($(this).data('url'));
        $('#skip_qus').submit();
    }else{
        alert('Pls choose answ');
    }
});

$('#skip_button').click(function(){
    $('#next_qus').val($(this).data('url'));
    $('#skip_ans').val('yes');
    $('#skip_qus').submit();
});
</script>
</html>