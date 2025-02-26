<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('assets/css/preview.css') }}" rel="stylesheet" type="text/css" />
    <style>
  
div#uploaded_file img {
    width: 100px !important;
    height: 100px !important;
    object-fit: contain;
}
        body{
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        img.imagesurvey {
            width: 100%;
            height: 100px !important;
            object-fit: contain;
        }
        img#tbs_logo {
            width: 200px;
        }
        .likert_scale_label {
            display: flex;
            width: 100%;
            justify-content: space-between;
        }
        .likert_scale_container{
            display: flex;
            flex-direction: column !important;
        }
        .capture-photo {
            display: flex;
            gap: 10px;
        }
        ul#sortable {
            list-style: none;
        }
        .disabled.ss-primary-action-btn {
            opacity: 0.3 !important;
        }
        .rankorderkey_option.ss-option--rank-order__select-wrap .ss-option--rank-order-react-select__control{
            color:rgb(63, 63, 63);
            background-color:rgb(255, 255, 255)
        }
        /* button#click-photo {
            color: white;
            background: #4A9CA6;
            border: 0px;
            padding: 10px;
            border-radius: 6px;
        } */
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
        .surveysparrow-survey-container--classic-form{
            background:unset !important;
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
        /* Pagination Css */
.pagination {
    justify-content: center;
    display: flex;
    align-items: center;
    gap: 5px;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
}

.pagination a.active {
  background-color: #4CAF50;
  color: white;
}

.pagination a.current {
  background-color: #ddd;
  color: white;
}

.pagination a.red {
  background-color: red;
  color: white;
}

</style>
</head>
<?php 
if(isset($question))
$qusvalue = json_decode($question->qus_ans);
else $qusvalue;
$azRange = range('A', 'Z');
$qusNo=1;
$icon_type='';
$left_label='Least Likely';
$middle_label='Neutral';
$right_label='Most Likely';
$likert_range = 10;

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

if(isset($qusvalue->likert_range)){
    $likert_range=$qusvalue->likert_range;
}
// Survey Background 
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
}
?>
<body style="{{$stylebackground}}">
    <div class="surveybackground">
        <?php  $qus_url=route('survey.builder',[$survey->builderID,$question->id]); ?>
        <input type="hidden" value="{{$question->qus_type}}" id="question_type"/>
        <input type="hidden" value="" id="answered"/>
        <?php if($survey->survey_type == 'profile'){
            $urlRedirect = route('updateprofile');
        }else{
            $urlRedirect = route('user.dashboard');
        } ?>
        @if($survey->survey_type == 'profile')
        <a class="back_to_profile" href="{{ $urlRedirect }} ">
            <button id="back_to_profile">
                <span class="ss-primary-action-btn__copy">Back to Profile</span>
            </button>
        </a>
        @endif
        <?php //echo "<pre>";  print_r($survey); ?>
@if($survey->survey_type == 'profile')
<div class="pagination">
    <p>Go to Question &raquo;</p>
    @foreach($questionsset as $key=>$value)
    <?php $surveyResponse = \App\Models\SurveyResponse::where(['survey_id'=>$survey->id,'response_user_id'=>\Auth::user()->id,'question_id'=>$value->id])->first();
    $classname = '';
    if($surveyResponse){
        if($surveyResponse->skip == 'yes'){
            $classname = '';
        }else{
            $classname ='active';
        }
    }
    
    ?>
    <a class="@if($surveyResponse) {{$classname}} @elseif($question->id == $value->id) current @else red @endif" href="{{route('survey.startsurvey',[$survey->id,$value->id])}}">{{$key+1}}</a>
    @endforeach
</div>
@endif
        @if($question->qus_type=='welcome_page')
        <div class="surveysparrow-survey-container--classic-form welcome-page">
            <div class="ss-fp-section surveysparrow-survey-form-wrapper--centered ss-survey-background d-flex fx-column fx-jc--center fx-ai--center">
                <div class="ss-fp-section__frame ss_classic_survey_intro_contents">
                    <div class="ss-fp-section__inner-frame">
                            @if(isset($qusvalue->tbs_logo))
                                @if($qusvalue->tbs_logo== 1 && isset($qusvalue->tbs_logo_url))
                                    <figure>
                                        <span>
                                            <div class="ss_image_wrapper">
                                                <img class="imagesurvey"  id="tbs_logo" src="{{ asset('uploads/survey/'.$qusvalue->tbs_logo_url) }}" alt="TBS Logo">
                                            </div>
                                        </span>
                                    </figure>
                                @endif
                            @endif
                            <h3 class="ss-header-text--fluid ss-survey-heading--text ss-survey-font-family ss-survey-line-height--normal ss-survey-text-weight--semibold ss-survey-text-color--primary ss-survey-text-align--center ss-survey-text-question-text main-header-font-size--md">
                                @if(isset($qusvalue->welcome_title))
                                    <p>{{$qusvalue->welcome_title}}</p>
                                @endif
                                @if(isset($qusvalue->welcome_image))
                                <figure>
                                    <span>
                                        <div class="ss_image_wrapper">
                                            <img class="imagesurvey" src="{{ asset('uploads/survey/'.$qusvalue->welcome_image) }}" alt="welcome image">
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
                                <?php 
                                if($question1) 
                                    $urlwelcome = route('survey.startsurvey',[$survey->id,$question1->id])."?type=welcome"; 
                                else $urlwelcome="";
                                ?>
                                <a href="{{$urlwelcome}}">
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
                                        <!-- <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">Question {{$qusNo}}</p> -->
                                    </div>
                                    <div class="ss_cl_survey_qstn_right">
                                        <div class="ss_cl_survey_qstn">
                                            <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                                <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                            </h1>
                                            <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$question->question_description}}</p>

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
                                                                <?php foreach($exiting_qus_matrix as $key=>$qus){
                                                                    ?>
                                                                        <tr class="matrix_head">
                                                                            <td class="matrix_sec">{{$qus}}</td>
                                                                            @foreach($exiting_choices_matrix as $ans)
                                                                            <td><input type="radio" data-val="{{$ans}}" name="matrix_anstype_{{$key}}"></td>
                                                                            @endforeach
                                                                        </tr>
                                                                    <?php  
                                                                    $i++;
                                                                } ?>
                                                            </tbody>
                                                        </table>
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
                                                    @if($question->qus_required!=1)
                                                        <div class="ss-skip-container">
                                                            <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                                        </div>
                                                    @endif
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
                                <!-- <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">Question {{$qusNo}}</p> -->
                                </div>
                                <div class="ss_cl_survey_qstn_right">
                                    <div class="ss_cl_survey_qstn">
                                    <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text" id="question-title-8966626">
                                        <span class="d-block ss-survey-heading--text__span">{{$question->question_name}}</span></h1>
                                        <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$question->question_description}}</p>

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
                                    @if($question->qus_required!=1)
                                        <div class="ss-skip-container">
                                            <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                        </div>
                                    @endif
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
                                    <!-- <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">Question {{$qusNo}}</p> -->
                                    </div>
                                    <div class="ss_cl_survey_qstn_right">
                                        <div class="ss_cl_survey_qstn">
                                            <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                                <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                            </h1>
                                            <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$question->question_description}}</p>

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
                                        @if($question->qus_required!=1)
                                            <div class="ss-skip-container">
                                                <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                            </div>
                                        @endif
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($question->qus_type=='photo_capture')
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
                                    <!-- <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">Question {{$qusNo}}</p> -->
                                    </div>
                                    <div class="ss_cl_survey_qstn_right">
                                        <div class="ss_cl_survey_qstn">
                                            <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                                <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                            </h1>
                                            <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$question->question_description}}</p>

                                        </div>
                                    </div>
                                </div>
                                    <div class="capture-photo">
                                        <div class="ss-camera-input upload_wrapper"  id="start-camera">
                                            <button class="answer-option--file-input ss-answer-option--bg-only ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--primary ss-survey-border-width--thin ss-survey-border-style--dashed ss-survey-border-color--primary-02" type="button" id="camera_btn">
                                                <input type="file" accept="image/*" capture="camera" style="display: none;">
                                                <svg stroke="#0D1B1E" class="" width="84" height="84" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.0858 4.58579L16.2071 5.70711C16.3946 5.89464 16.649 6 16.9142 6H19.5C20.0304 6 20.5391 6.21071 20.9142 6.58579C21.2893 6.96086 21.5 7.46957 21.5 8V17C21.5 17.5304 21.2893 18.0391 20.9142 18.4142C20.5391 18.7893 20.0304 19 19.5 19H5.5C4.96957 19 4.46086 18.7893 4.08579 18.4142C3.71071 18.0391 3.5 17.5304 3.5 17V8C3.5 7.46957 3.71071 6.96086 4.08579 6.58579C4.46086 6.21071 4.96957 6 5.5 6H8.08579C8.351 6 8.60535 5.89464 8.79289 5.70711L9.91421 4.58579C10.0999 4.40007 10.3204 4.25275 10.5631 4.15224C10.8057 4.05173 11.0658 4 11.3284 4H13.6716C13.9342 4 14.1943 4.05173 14.4369 4.15224C14.6796 4.25275 14.9001 4.40007 15.0858 4.58579Z" stroke="#63686F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M12.5 16C14.7091 16 16.5 14.2091 16.5 12C16.5 9.79086 14.7091 8 12.5 8C10.2909 8 8.5 9.79086 8.5 12C8.5 14.2091 10.2909 16 12.5 16Z" stroke="#63686F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M18.5501 9.00008C18.5501 9.00997 18.5471 9.01962 18.5416 9.02784C18.5361 9.03605 18.5283 9.04245 18.5192 9.04622C18.51 9.05 18.5 9.05098 18.4903 9.04905C18.4806 9.04712 18.4717 9.04235 18.4647 9.03536C18.4577 9.02837 18.453 9.01947 18.451 9.00978C18.4491 9.00008 18.4501 8.99004 18.4539 8.9809C18.4576 8.97177 18.464 8.96396 18.4723 8.95846C18.4805 8.95297 18.4901 8.95002 18.5 8.95001C18.5066 8.95 18.5131 8.95129 18.5192 8.95381C18.5253 8.95632 18.5308 8.96001 18.5354 8.96466C18.5401 8.96931 18.5438 8.97483 18.5463 8.98091C18.5488 8.98699 18.5501 8.99351 18.5501 9.00008" stroke="#63686F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                                <p>Camera</p>
                                            </button>
                                        </div>
                                       
                                        <video id="video" width="320" height="240" autoplay></video>
                                        <div id="dataurl-container">
                                            <canvas id="canvas" width="320" height="240"></canvas>
                                        </div>
                                        <input type="hidden" name="photo_capture_value" id="dataurl" />

                                    </div>
                                </div>



                                <div class="ss_cl_qstn_action disabled {{$question->qus_type}}_action">
                                    <button onclick="click_button_camera()"  id="click-photo" class="ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Click Photo</span>
                                        
                                        </button>
                                    <div class="">
                                       
                                        <button data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif"  id="next_button"  class="disabled ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                            <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @if($question->qus_required!=1)
                                        <div class="ss-skip-container">
                                            <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                        </div>
                                    @endif
                                </div>
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
                                    <!-- <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">Question {{$qusNo}}</p> -->
                                    </div>
                                    <div class="ss_cl_survey_qstn_right">
                                        <div class="ss_cl_survey_qstn">
                                                <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                                    <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                                </h1>
                                                <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$question->question_description}}</p>

                                        </div>
                                    </div>
                                </div><span class="ss_span_wrapper">
                                    <div class="ss_options_container">
                                        <div class="ss_rating_container ss_component_animated likert_scale_container">
                                            <div class="ss_rating_input--classic">
                                                <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic">1</button>
                                                <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >2</button>
                                                <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >3</button>
                                                <button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic">4</button>
                                                @if($likert_range>=5)<button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >5</button>@endif
                                                @if($likert_range>=6)<button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic">6</button>@endif
                                                @if($likert_range>=7)<button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic">7</button>@endif
                                                @if($likert_range>=8)<button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic">8</button>@endif
                                                @if($likert_range>=9)<button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >9</button>@endif
                                                @if($likert_range>=10)<button class="likert_choice ss-answer-option--rating ss-answer-option--bg ss-answer-option--border ss-answer-option--text-light  ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--secondary ss-answer-option--classic" >10</button>@endif

                                            </div>
                                            <div class="likert_scale_label">
                                                @if($likert_range<=4)
                                                <div><label class="ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-option__label ss-answer-option__label--middle-label">{{$middle_label}}</label></div>

                                                <div><label class="ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-option__label ss-answer-option__label--max-label">{{$right_label}}</label></div>
                                                    
                                                @elseif($likert_range>=5)
                                                
                                                <div><label class="ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-option__label ss-answer-option__label--min-label">{{$left_label}}</label></div>
                                                
                                                <div><label class="ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-option__label ss-answer-option__label--middle-label">{{$middle_label}}</label></div>
                                     
                                                <div><label class="ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-answer-option__label ss-answer-option__label--max-label">{{$right_label}}</label></div>
                                                    
                                                @endif
                                            </div>
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
                                        @if($question->qus_required!=1)
                                            <div class="ss-skip-container">
                                                <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                            </div>
                                        @endif
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
                                        <!-- <p
                                            class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                            Question {{$qusNo}}</p> -->
                                    </div>
                                    <div class="ss_cl_survey_qstn_right">
                                        <div class="ss_cl_survey_qstn">
                                            <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text"
                                                id="question-title-8966750"><span
                                                    class="d-block ss-survey-heading--text__span">{{$question->question_name}}</span></h1>
                                                    <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$question->question_description}}</p>

                                        </div>
                                    </div>
                                </div><span class="ss_span_wrapper">
                                    <div class="ss_options_container ss_options_container--rank-order">
                                    <?php $exiting_choices=$qusvalue!=null ? explode(",",$qusvalue->choices_list): []; $dropdowncount=count($exiting_choices); ?>
                                        <input type="hidden" id="rank_order_value" value="{{implode(',',$exiting_choices)}}"/>
                                        <input type="hidden" id="dropdowncount" value="{{$dropdowncount}}"/>
                                        <div class="rank-order-container rank_option_container" id="rank_order_container">
                                            <!-- <ul id="sortable"> -->
                                                @foreach($exiting_choices as $key=>$choice)
                                                    <!-- <li draggable="true"> -->
                                                        <div  draggable="true" data-id="{{$key+1}}" id="rank_option_{{$key+1}}" class="rank_option ss-option--rank-order ss-answer-option--bg-only ss-answer-option--border ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-option--rank-order--ios" style="opacity: 1;">
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
                                                                <p class="choice_text">{{$choice}}</p>
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
                                                    <!-- </li> -->
                                                @endforeach
                                            <!-- </ul> -->
                                        </div>
                                    </div>
                                    <div class="ss_cl_qstn_action disabled {{$question->qus_type}}_action">
                                        <div class="">
                                            <button data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif"  id="next_button"  class="ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        @if($question->qus_required!=1)
                                            <div class="ss-skip-container">
                                                <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                            </div>
                                        @endif
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
                                        <!-- <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text"> Question {{$qusNo}} </p> -->
                                    </div>
                                    <div class="ss_cl_survey_qstn_right">
                                        <div class="ss_cl_survey_qstn">
                                            <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                                <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                            </h1>
                                            <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$question->question_description}}</p>

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
                                    <div class="ss_cl_qstn_action disabled {{$question->qus_type}}_action">
                                        <div class="">
                                            <button data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif"  id="next_button"  class="disabled ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        @if($question->qus_required!=1)
                                            <div class="ss-skip-container">
                                                <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                            </div>
                                        @endif
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
                                        <!-- <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                            Question {{$qusNo}}
                                        </p> -->
                                    </div>
                                    <div class="ss_cl_survey_qstn_right">
                                        <div class="ss_cl_survey_qstn">
                                            <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                                <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                            </h1>
                                            <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$question->question_description}}</p>

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
                                    <div class="ss_cl_qstn_action disabled {{$question->qus_type}}_action">
                                        <div class="">
                                            <button data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif"  id="next_button"  class="disabled ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        @if($question->qus_required!=1)
                                            <div class="ss-skip-container">
                                                <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                            </div>
                                        @endif
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
                                        <!-- <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                            Question {{$qusNo}}
                                        </p> -->
                                    </div>
                                    <div class="ss_cl_survey_qstn_right">
                                        <div class="ss_cl_survey_qstn">
                                            <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                                <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                            </h1>
                                            <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$question->question_description}}</p>

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
                                                            @if(optional($choice)->img)
                                                                <div class="ss-img-container ss-img-container--default">
                                                                    <img alt="{{$choice->text}}" class="ss-img-container__img ss-img-container__cover" src="{{$choice->img}}" style="object-fit: contain; height: 100%; width: 100%;">
                                                                </div>
                                                                <div class="ss-img-container ss-img-container--fallback" style="background-image: url(&quot;{{$choice->img}}&quot;); background-size: cover;">
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ss-choice-content">
                                                            @if($choice->text!='')
                                                            <p title="{{$choice->text}}">{{$choice->text}}</p>
                                                            @else
                                                            <p title="{{$azRange[$key]}}">{{$azRange[$key]}}</p>
                                                            @endif
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
                                    <div class="ss_cl_qstn_action disabled {{$question->qus_type}}_action">
                                        <div class="">
                                            <button data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif"  id="next_button"  class="disabled ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        @if($question->qus_required!=1)
                                            <div class="ss-skip-container">
                                                <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                            </div>
                                        @endif
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
                                        <!-- <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                            Question {{$qusNo}}
                                        </p> -->
                                    </div>
                                    <div class="ss_cl_survey_qstn_right">
                                        <div class="ss_cl_survey_qstn">
                                            <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                                <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                            </h1>
                                            <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$question->question_description}}</p>

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
                                        @if($question->qus_required!=1)
                                            <div class="ss-skip-container">
                                                <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                            </div>
                                        @endif
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($question->qus_type=='upload')
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
                                        <!-- <p class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--sm ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                            Question {{$qusNo}}
                                        </p> -->
                                    </div>
                                    <div class="ss_cl_survey_qstn_right">
                                        <div class="ss_cl_survey_qstn">
                                            <h1 class="ss-survey-heading--text ss-survey-font-family ss-survey-text-size--3xl sm_ss-survey-text-size--2xl ss-survey-line-height--heading ss-survey-text-weight--regular ss-survey-text-color--primary ss-survey-text-question-text">
                                                <span class="d-block ss-survey-heading--text__span">{{$question->question_name}} </span>
                                            </h1>
                                            <p class="ss-survey-heading--text ss-survey-question-description ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--normal ss-survey-text-weight--regular ss-survey-text-question-text ss-survey-text-color--primary-07">{{$question->question_description}}</p>

                                        </div>
                                    </div>
                                </div>
                                <span class="ss_span_wrapper">
                                <div class="ss_options_container">
                                

                                   <div class="ss_inline_input_container ss_component_animated">
                                        <div class="ss-camera-input upload_wrapper" id="dragdropfile" ondrop="handleDrop(event)" ondragover="handleDragOver(event)" >
                                            <button class="answer-option--file-input ss-answer-option--bg-only ss-survey-font-family ss-survey-text-size--lg sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--semibold ss-survey-text-color--primary ss-survey-border-width--thin ss-survey-border-style--dashed ss-survey-border-color--primary-02" type="button" id="upload_file">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="85" height="74" viewBox="0 0 85 74"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M58.723 52.091h9.054S84 49.987 84 34.155a17.847 17.847 0 0 0-5.515-12.904 18.068 18.068 0 0 0-13.179-4.995C60.391 5.887 49.026.152 37.704 2.328c-11.322 2.175-19.718 11.707-20.39 23.15a13.59 13.59 0 0 0-11.306 2.714A13.417 13.417 0 0 0 1 38.625C1 52.294 15.434 52.08 15.434 52.08h10.802M42.5 31.466v41.25"></path><path d="M53.818 42.716L42.5 31.466l-11.318 11.25"></path></g></svg>
                                                <p id="file-upload-description">Drag and drop to upload<span class="answer-option--file-input-text ss-survey-font-family ss-survey-text-size--xs sm_ss-survey-text-size--xs ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--primary">or <a href="#!" tabindex="-1">browse</a> to choose a file </span></p>
                                            </button>
                                        </div>
                                    </div>
                                <span id="helper" class="answer-option--file-input-text ss-survey-font-family ss-survey-text-size--xs sm_ss-survey-text-size--xs ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--primary-06">Maximum number of files is 1. Maximum upload size per file is 10 MB.</span>
                                </div>
                                    <div id="uploaded_file">

                                    </div>
                                    <div class="ss_cl_qstn_action disabled {{$question->qus_type}}_action">
                                        <div class="">
                                            <button data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif"  id="next_button"  class="disabled ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Next</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        @if($question->qus_required!=1)
                                            <div class="ss-skip-container">
                                                <button id="skip_button" data-url="@if($question1) {{route('survey.startsurvey',[$survey->id,$question1->id])}} @endif" class="ss-skip-action-btn ss-survey-font-family ss-survey-text-size--sm ss-survey-line-height--none ss-survey-text-weight--bold ss-survey-text-color--primary-04">Skip</button>
                                            </div>
                                        @endif
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
                            @if(isset($qusvalue->tbs_logo))
                                @if($qusvalue->tbs_logo== 1 && isset($qusvalue->tbs_logo_url))
                                    <figure>
                                        <span>
                                            <div class="ss_image_wrapper">
                                                <img id="tbs_logo" src="{{ asset('uploads/survey/'.$qusvalue->tbs_logo_url) }}" alt="TBS Logo">
                                            </div>
                                        </span>
                                    </figure>
                                @endif
                            @endif
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
        

        <form id="skip_qus" style="display:none;" enctype="multipart/form-data" action="{{route('survey.submitans')}}" method="POST">
            @csrf
            @if($question->qus_type=='upload')
            <?php $qus_ans= json_decode($question->qus_ans);
                $upload_video=0;$upload_image=0;$upload_doc=0;$upload_audio=0;
                if(isset($qus_ans)){
                    $upload_video = $qus_ans->upload_video;
                    $upload_image = $qus_ans->upload_image;
                    $upload_doc = $qus_ans->upload_doc;
                    $upload_audio = $qus_ans->upload_audio;
                }
                $accept=[];
                if($upload_audio==1){
                    array_push($accept,".mp3","audio/*");
                }
                if($upload_video==1){
                    array_push($accept,"video/*");
                }
                if($upload_doc==1){
                    array_push($accept,"application/msword", "application/vnd.ms-excel", "application/vnd.ms-powerpoint",
                    "text/plain", "application/pdf");
                }
                if($upload_image==1){
                    array_push($accept,"image/*");
                }
                $string_version = implode(',', $accept); 
                    ?>
            <input id="uploadfile" accept="{{$string_version}}" name="uploadfile" type="file" style="display: none;">

            @endif
            <input type="text" id="question_id" value="{{$question->id}}" name="question_id"/>
            <input type="text" id="survey_id" value="{{$survey->id}}" name="survey_id"/>
            <input type="text" id="next_qus" name="next_qus"/>
            <input type="text" id="user_ans" name="user_ans"/>
            <input type="text" id="uploadurl" name="uploadurl"/>
            <input type="text" id="skip_ans" name="skip_ans"/>
            <input type="text" id="device_id" name="device_id"/>
            <input type="text" id="device_name" name="device_name"/>
            <input type="text" id="browser" name="browser"/>
            <input type="text" id="os" name="os"/>
            <input type="text" id="ip_address" name="ip_address"/>
            <input type="text" id="location" name="location"/>
            <input type="text" id="lat" name="lat"/>
            <input type="text" id="long" name="long"/>
            <input type="text" id="device_type" name="device_type"/>
            <input type="text" id="lang_code" name="lang_code"/>
            <input type="text" id="lang_name" name="lang_name"/>
        </form>
    </div>
</body>
<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>

<script>
//Get browser details 
document.addEventListener('DOMContentLoaded', function() {
    $('#device_name').val(navigator.platform);
    $('#browser').val(`${navigator.appName} ${navigator.appVersion}`);
    $('#os').val(`${navigator.userAgent}`);
    fetch('https://api.ipify.org?format=json')
    .then(response => response.json())
    .then(data => {
        $('#ip_address').val(data.ip);
    })
    .catch(error => console.error('Error fetching IP address:', error));
    const deviceLanguage = navigator.language || navigator.userLanguage; 
    let languageName = getLanguageName(deviceLanguage);
    $('#lang_code').val(deviceLanguage);
    $('#lang_name').val(languageName);
    $('#device_name').val(navigator.platform);
    if(isMobileDevice()){
        $('#device_type').val('Mobile');
    }else{
        $('#device_type').val('Desktop');
    }
    fetch('https://ipinfo.io/json')
    .then(response => response.json())
    .then(data => {
        $('#location').val(data?.city+", "+data?.country);
        const loc = data?.loc.split(",", 2); 
        $('#lat').val(loc[0]);
        $('#long').val(loc[1]);
    })
    .catch(error => console.error('Error fetching IP address:', error));

});

function isMobileDevice() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

function isDesktopBrowser() {
  return !isMobileDevice();
}

function getLanguageName(languageCode) {
  try {
    return new Intl.DisplayNames([navigator.language], { type: 'language' }).of(languageCode);
  } catch (error) {
    console.error('Error:', error);
    return null;
  }
}

           
$('.text-ans-input').change(function(){
    if($(this).val()!=''){
        $('#next_button').removeClass('disabled');
        $('#answered').val('yes');
    }else{
        $('#next_button').addClass('disabled');
        $('#answered').val('no');
    }
});
$('.text-ans-input').keyup(function(){
    if($(this).val()!=''){
        $('#next_button').removeClass('disabled');
        $('#answered').val('yes');
    }else{
        $('#next_button').addClass('disabled');
        $('#answered').val('no');
    }
});
$('#dropdownlist').change(function(){
    if($(this).val()!=''){
        $('#next_button').removeClass('disabled');
        $('#next_button').click();
    }else{
        $('#next_button').addClass('disabled');
    }
})
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
        if(classname!='.multi_choice_choice'){
            $('#next_button').click();
        }
    }else{
        $(btnname).toggleClass('disabled');
        $('#next_button').addClass('disabled');
        $('#answered').val('no');
    }
}
$('.likert_choice').click(function(){
    $(this).toggleClass("active");
    $('.likert_choice').not(this).removeClass("active");
    var enable=0;
    $('.likert_choice').each(function(){
        if($(this).hasClass('active')){
            enable=1;
        }
    });
    if(enable == 1){
        $('#answered').val('yes');
        $('#next_button').removeClass('disabled');
        $('#next_button').click();

    }else{
        $('#answered').val('no');
        $('#next_button').addClass('disabled');

    }
});
$('.multi_choice_choice').click(function(){
    $(this).toggleClass("active");
    enableNextButton('.multi_choice_choice','.multi_choice_action')

});
$('.answer-option-rating--icons').click(function(){
    $(this).toggleClass("active");
    $('.answer-option-rating--icons').not(this).removeClass("active");
    var enable=0;
    $('.answer-option-rating--icons').each(function(){
        if($(this).hasClass('active')){
            enable=1;
            
        }
    });
    if(enable == 1){
        $('#next_button').removeClass('disabled');
        $('#answered').val('yes');
    }else{
        $('#answered').val('no');
        $('#next_button').addClass('disabled');
    }
});
$('#back_editor').click(function(){
    let url=$('#back_editor').data('url');
    window.location.href=url+"?pagetype=editor";
});
$('.ss-answer-option--picture-choice').click(function(){
    $(this).toggleClass("active");
    $('.ss-answer-option--picture-choice').not(this).removeClass("active");
    if($('.ss-answer-option--picture-choice.active .ss-choice-content p').text() !=''){
        $('#next_button').removeClass('disabled');
        $('#next_button').click();
    }else{
        $('#next_button').addClass('disabled');

    }
});
var array = $('#rank_order_value').val();
document.addEventListener("DOMContentLoaded", (event) => {
    if(array!=undefined && array!=''){
        array=array.split(",");
    }else{
        array=[];
    }
    // var elem='<ul id="sortable">';
    var elem='';
    array.forEach((value,key)=>{
        let val1=key+1;
        let option=$('#dropdowncount').val();
        let optionval='';
        for(let v=1; v<=option; v++){
            if(v==val1){
                $('#answered').val('yes');
                optionval+='<option selected value='+v+'>'+v+'</option>';
            }else{
                optionval+='<option value='+v+'>'+v+'</option>';
            } 
        }
        elem+='<div  draggable="true" class="rank_option ss-option--rank-order ss-answer-option--bg-only ss-answer-option--border ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-option--rank-order--ios" style="opacity: 1;"><div class="ss-option--rank-order__data"><span class="ss-option--rank-order__drag-handle-icon"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" fill="none" viewBox="0 0 10 16"><circle cx="2" cy="2" r="2" fill="currentColor"></circle><circle cx="2" cy="8" r="2" fill="currentColor"></circle><circle cx="2" cy="14" r="2" fill="currentColor"></circle><circle cx="8" cy="2" r="2" fill="currentColor"></circle><circle cx="8" cy="8" r="2" fill="currentColor"></circle><circle cx="8" cy="14" r="2" fill="currentColor"></circle></svg></span><p class="choice_text">'+value+'</p></div><span class="rankorderkey_option ss-option--rank-order__select-wrap"><div class="css-1pcexqc-container"><div class="css-bg1rzq-control ss-option--rank-order-react-select__control"><div class="css-1hwfws3 ss-option--rank-order-react-select__value-container ss-option--rank-order-react-select__value-container--has-value"><select onchange="changepos(`'+value+'`,event)"  class="rankorderkey" name="rankorderkey">'+optionval+'</select></div></div></div></span></div>';
    });
    elem+='';
    if(elem!='')
    document.getElementById('rank_order_container').innerHTML = elem;
});
function changepos(val,event){
    const index = array.indexOf(val);
    if (index > -1) { 
        array.splice(index, 1); 
    }
    let eventValue;
    if(event.target!=undefined){
        eventValue = event.target.value;
    }else{
       eventValue = event;
    }
    array.splice(eventValue-1, 0, val);
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
        elem+='<div  draggable="true" class="rank_option ss-option--rank-order ss-answer-option--bg-only ss-answer-option--border ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--regular ss-survey-text-color--secondary ss-option--rank-order--ios" style="opacity: 1;"><div class="ss-option--rank-order__data"><span class="ss-option--rank-order__drag-handle-icon"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" fill="none" viewBox="0 0 10 16"><circle cx="2" cy="2" r="2" fill="currentColor"></circle><circle cx="2" cy="8" r="2" fill="currentColor"></circle><circle cx="2" cy="14" r="2" fill="currentColor"></circle><circle cx="8" cy="2" r="2" fill="currentColor"></circle><circle cx="8" cy="8" r="2" fill="currentColor"></circle><circle cx="8" cy="14" r="2" fill="currentColor"></circle></svg></span><p class="choice_text">'+value+'</p></div><span class="rankorderkey_option ss-option--rank-order__select-wrap"><div class="css-1pcexqc-container"><div class="css-bg1rzq-control ss-option--rank-order-react-select__control"><div class="css-1hwfws3 ss-option--rank-order-react-select__value-container ss-option--rank-order-react-select__value-container--has-value"><select onchange="changepos(`'+value+'`,event)"  class="rankorderkey" name="rankorderkey">'+optionval+'</select></div></div></div></span></div>';
    });
    elem+='';
    document.getElementById('rank_order_container').innerHTML = elem;
}

$('#next_button').click(function(){
    let submit = 0;
    let qusVal=$('#question_type').val();
    let answeredVal=$('#answered').val();
    console.log($('#question_type').val(),"next_button");
    if(qusVal =='single_choice'){
        if(answeredVal == 'yes'){
           $('#user_ans').val($('.single_choice_choice.active .ans_val').text());
           submit = 1;
        }
    }else if(qusVal =='open_qus'){
        if(answeredVal == 'yes'){
           $('#user_ans').val($('.text-ans-input').val());
           submit = 1;
        }
    }else if (qusVal == 'multi_choice'){
        if(answeredVal == 'yes'){
            let arr = [];
            $('.multi_choice_choice.active .ans_val').each(function(){ 
                arr.push($(this).text());
            });
           $('#user_ans').val(arr.toString());
           submit = 1;
        }
    }else if (qusVal =='likert'){
        if(answeredVal == 'yes'){
            $('#user_ans').val($('.likert_choice.active').text());
            submit =1;
        }
    }else if (qusVal == 'rankorder'){
        if(answeredVal == 'yes'){
            let choice_text = [];
            let choice_val = [];
            $('.choice_text').each(function(){
               choice_text.push($(this).text());
            });
            $('.rankorderkey').each(function(key){
                let keyn = choice_text[key];
                let keyv ={"id" : keyn , "val" : $(this).val()};
                choice_val.push(keyv);
            });
            $('#user_ans').val(JSON.stringify(choice_val));
            if( $('#user_ans').val()!='')
                submit =1;
        }
    }else if(qusVal == 'rating'){
        if(answeredVal == 'yes'){
            $('#user_ans').val($('button.answer-option-rating--icons.active').attr('aria-label'));
            submit =1;
        }
    }else if(qusVal == 'dropdown'){
        $('#user_ans').val($('#dropdownlist').val());
        if($('#user_ans').val()!=''){
            submit =1;
        }
    }else if(qusVal == 'picturechoice'){
        $('#user_ans').val($('.ss-answer-option--picture-choice.active .ss-choice-content p').text());
        if($('#user_ans').val()!=''){
            submit =1;
        }
    }else if(qusVal =='email'){
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if ($('.text-ans-input').val().match(validRegex)) {
            if(answeredVal == 'yes'){
                $('#user_ans').val($('.text-ans-input').val());
                submit = 1;
            }
        }else{
            alert('Invalid Email Address'); return false;
        }
    }else if(qusVal == 'matrix_qus'){
        let resp = [];
        $('.matrix_head .matrix_sec').each(function(key){
            if($('input[name=matrix_anstype_'+key+']:checked').data('val') !=undefined){
                let res = {"key" : key, "ans" : $('input[name=matrix_anstype_'+key+']:checked').data('val'), "qus": $(this).text() };
                resp.push(res);
                submit =1;
            }else{
                submit = 0;
                alert('Please select an answer');
                return false;
            }
        });
        $('#user_ans').val(JSON.stringify(resp));
    }else if(qusVal == 'photo_capture'){
        if($('#dataurl').val()!=''){
            $('#user_ans').val($('#dataurl').val());
            submit=1;
        }
    }else if(qusVal == 'upload'){
        if($('#uploadurl').val()!=''){
            $('#user_ans').val($('#uploadurl').val());
            submit=1;
        }
    }
    // console.log(submit,qusVal);
    // return false;
    if(submit == 1){
        $('#next_qus').val($(this).data('url'));
        $('#skip_qus').submit();
    }else{
        alert('Please select an answer');
        return false;
    }
});

$('#skip_button').click(function(){
    $('#next_qus').val($(this).data('url'));
    $('#skip_ans').val('yes');
    $('#skip_qus').submit();
});
</script>
<script>
    // Script.js
    const sortableList = document.getElementById("rank_order_container");
    console.log(sortableList,'sortableListsortableList')
    let draggedItem = null;
    if(sortableList!=null && sortableList!=undefined)
    {
        sortableList.addEventListener(
        "dragstart",
        (e) => {
            draggedItem = e.target;
            setTimeout(() => {
                e.target.style.display =
                    "none";
            }, 0);
        });

    sortableList.addEventListener(
        "dragend",
        (e) => {
            setTimeout(() => {
                let text = draggedItem.querySelectorAll('.choice_text');
                changepos(text[0].innerHTML,$(draggedItem).index()+1);
                console.log($(draggedItem).index(),'draggedItem')
                e.target.style.display = "";
                draggedItem = null;
            }, 0);
        });

    sortableList.addEventListener(
        "dragover",
        (e) => {
            e.preventDefault();
            const afterElement = getDragAfterElement(sortableList, e.clientY);
            const currentElement = document.querySelector(".dragging");
            if (afterElement == null) {
                sortableList.appendChild(draggedItem);
            }
            else {
                sortableList.insertBefore(draggedItem,afterElement);
            }
        });
        
    const getDragAfterElement = (container, y) => {
        const draggableElements = [...container.querySelectorAll("div:not(.dragging)"),];
        return draggableElements.reduce(
            (closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if ( offset < 0 && offset > closest.offset) {
                    return {
                        offset: offset,
                        element: child,
                    };
                }
                else {
                    return closest;
                }
            },
            {
                offset: Number.NEGATIVE_INFINITY,
            }
        ).element;
    };
    }

</script>
<!-- Capture Photo -->
<script>
let dragdropfile= document.querySelector("#dragdropfile");
if(dragdropfile!=undefined)
dragdropfile.addEventListener('click', async function() {
    $('#uploadfile').click();
});

$('#uploadfile').change((e)=>{
    if(e.target.files.length>0){
        $('#uploadurl').val(e.target.files[0].name);
        $('#next_button').removeClass('disabled');
    }else{
        $('#uploadurl').val('');
        $('#next_button').addClass('disabled');
    }
    let file = e.target.files[0]; 
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('uploaded_file');
        preview.innerHTML = ''; // Clear previous content

        // Create a container for the file name and preview element
        const fileContainer = document.createElement('div');
        fileContainer.style.display = 'flex';
        fileContainer.style.alignItems = 'center';
        fileContainer.style.marginBottom = '10px';

        // Create and append the file name element
        const fileName = document.createElement('span');
        fileName.textContent = `File Name: ${file.name}`;
        fileName.style.marginRight = '10px';
        fileContainer.appendChild(fileName);

        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100px';
            fileContainer.appendChild(img);
        } else if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.src = e.target.result;
            video.controls = true;
            video.style.maxWidth = '300px';
            video.style.maxHeight = '200px';
            video.load(); // Ensure the video is loaded correctly
            fileContainer.appendChild(video);
        } else if (file.type.startsWith('audio/')) {
            const audio = document.createElement('audio');
            audio.src = e.target.result;
            audio.controls = true;
            fileContainer.appendChild(audio);
        } else {
            const link = document.createElement('a');
            link.href = e.target.result;
            link.download = file.name;
            link.textContent = `Download ${file.name}`;
            fileContainer.appendChild(link);
        }

        // Append the fileContainer to the preview element
        preview.appendChild(fileContainer);
    };
    reader.readAsDataURL(file);

  
});
function handleDrop(event) {
    event.preventDefault();
    const files = event.dataTransfer.files;
    if (files) {
        $('#uploadurl').val(files[0].name);
        let file = files[0]; 
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('uploaded_file');
            preview.innerHTML = ''; // Clear previous content

            // Create a container for the file name and preview element
            const fileContainer = document.createElement('div');
            fileContainer.style.display = 'flex';
            fileContainer.style.alignItems = 'center';
            fileContainer.style.marginBottom = '10px';

            // Create and append the file name element
            const fileName = document.createElement('span');
            fileName.textContent = `File Name: ${file.name}`;
            fileName.style.marginRight = '10px';
            fileContainer.appendChild(fileName);

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100px';
                fileContainer.appendChild(img);
            } else if (file.type.startsWith('video/')) {
                const video = document.createElement('video');
                video.src = e.target.result;
                video.controls = true;
                video.style.maxWidth = '300px';
                video.style.maxHeight = '200px';
                video.load(); // Ensure the video is loaded correctly
                fileContainer.appendChild(video);
            } else if (file.type.startsWith('audio/')) {
                const audio = document.createElement('audio');
                audio.src = e.target.result;
                audio.controls = true;
                fileContainer.appendChild(audio);
            } else {
                const link = document.createElement('a');
                link.href = e.target.result;
                link.download = file.name;
                link.textContent = `Download ${file.name}`;
                fileContainer.appendChild(link);
            }

            // Append the fileContainer to the preview element
            preview.appendChild(fileContainer);
        };
        reader.readAsDataURL(file);

      const validFiles = Array.from(files).filter(file => {
        const allowedFormats = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","text/csv",'application/vnd.openxmlformats-officedocument.presentationml.presentation','application/pdf',"audio/mpeg","audio/mp3","audio/wav","audio/aac", 'image/png', 'image/jpeg','image/jpg','audio/mp3','audio/*'];
        return allowedFormats.includes(file.type);
      });
    }
    if($('#uploadurl').val() != ''){
        $('#next_button').removeClass('disabled');
    }else{
        $('#next_button').addClass('disabled');
    }
}

function handleDragOver(event) {
event.preventDefault();
}
let camera_button = document.querySelector("#start-camera");
let video = document.querySelector("#video");
let click_button = document.querySelector("#click-photo");
let canvas = document.querySelector("#canvas");
let dataurl = document.querySelector("#dataurl");
let dataurl_container = document.querySelector("#dataurl-container");
if(camera_button!=null){
    camera_button.addEventListener('click', async function() {
   	let stream = null;

    try {
    	stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
    }
    catch(error) {
    	alert(error.message);
    	return;
    }

    video.srcObject = stream;

    video.style.display = 'block';
    camera_button.style.display = 'none';
    click_button.style.display = 'block';
});
}

if(click_button!=null)
{
    click_button.addEventListener('click', function() {
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
   	let image_data_url = canvas.toDataURL('image/jpeg');
    
    dataurl.value = image_data_url;
    dataurl_container.style.display = 'block';
});

}
function click_button_camera(){
    console.log('click_button_camera')
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
   	let image_data_url = canvas.toDataURL('image/jpeg');
    
    dataurl.value = image_data_url;
    dataurl_container.style.display = 'block';
    if(image_data_url!=''){
        $('#next_button').removeClass('disabled');
    }else{
        $('#next_button').addClass('disabled');

    }
}
// Get the value of #question_type
let qusVal = $('#question_type').val();

// Check if the value is 'thank_you'
if (qusVal === 'thank_you') {
    // Redirect to user.surveys
    setTimeout(function() {
     window.location.href = "{{ route('user.surveys') }}";
    }, 2000); // Redirect after 2 seconds
}

</script>
    
</html>