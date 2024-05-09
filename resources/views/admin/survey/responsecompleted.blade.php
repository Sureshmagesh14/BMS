<html>
<head>
    <link href="{{ asset('assets/css/preview.css') }}" rel="stylesheet" type="text/css" />
    <style>
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
        .paginatedQus {
            display: flex;
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
        #next_button  a.back_to_profile {
            color:white;
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
.questionset{
    display:none;
}
#questionkey0{
    display :block ;
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
$middle_label='Netural';
$right_label='Most Likely';
$likert_range = 10;

if(isset($qusvalue->icon_type)){
    $icon_type=$qusvalue->icon_type;
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
        <a class="back_to_profile" href="{{ route('user.dashboard') }}">
            <button id="back_to_profile">
                <span class="ss-primary-action-btn__copy">Back to Profile</span>
            </button>
        </a>
        <?php //echo "<pre>";  print_r($survey); ?>

<?php $surveyCompleted =   \App\Models\SurveyResponse::where(['survey_id'=>$survey->id,'response_user_id'=>\Auth::user()->id])->where('answer','!=','thankyou_submitted')->get();  
//echo "<pre>"; print_r($surveyCompleted);  ?>
@foreach($surveyCompleted  as $key=>$csurvey)
<?php 
// echo count($surveyCompleted);
$nextKey = $key+1;
$prevKey = $key-1;
$question =  \App\Models\Questions::where(['id'=> $csurvey->question_id])->first(); 
if(isset($surveyCompleted[$key+1])){
    $questionNext = \App\Models\Questions::where(['id'=> $surveyCompleted[$key+1]->question_id])->first(); 
}
$respone = $csurvey;
$qus = $question;
$result = "";

if($respone){
    if($respone->skip == 'yes'){
        $output = 'Skip';
    }else{
        $output = $respone->answer;
    }
}else{
    $output = '-';
}
if($qus->qus_type == 'likert'){
    $qusvalue = json_decode($qus->qus_ans);
    $left_label='Least Likely';
    $middle_label='Netural';
    $right_label='Most Likely';
    $likert_range = 10;
    if(isset($qusvalue->right_label)){
        $right_label=$qusvalue->right_label;
    }
    if(isset($qusvalue->middle_label)){
        $middle_label=$qusvalue->middle_label;
    }
    if(isset($qusvalue->likert_range)){
        $likert_range=$qusvalue->likert_range;
    }
    if(isset($qusvalue->left_label)){
        $left_label=$qusvalue->left_label;
    }
    $output = intval($output);
    $likert_label = $output;
    if($likert_range <= 4 && $output <= 4){
        if($output == 1 || $output == 2){
            $likert_label = $left_label;
        }else{
            $likert_label = $right_label;
        }
    }else if($likert_range >= 5 && $output >=5){
        if($likert_range == 5){
            if($output == 1 || $output == 2){
                $likert_label = $left_label;
            }else if($output == 3){
                $likert_label = $middle_label;
            }else if($output == 4 || $output == 5){
                $likert_label = $right_label;
            }
        }else if($likert_range == 6){
            if($output == 1 || $output == 2){
                $likert_label = $left_label;
            }else if($output == 3 || $output == 4){
                $likert_label = $middle_label;
            }else if($output == 5 || $output == 6){
                $likert_label = $right_label;
            }
        }else if($likert_range == 7){
            if($output == 1 || $output == 2){
                $likert_label = $left_label;
            }else if($output == 3 || $output == 4 || $output == 5){
                $likert_label = $middle_label;
            }else if($output == 6 || $output == 7){
                $likert_label = $right_label;
            }
        }else if($likert_range == 8){
            if($output == 1 || $output == 2 || $output == 3){
                $likert_label = $left_label;
            }else if($output == 4 || $output == 5){
                $likert_label = $middle_label;
            }else if($output == 6 || $output == 7 || $output == 8){
                $likert_label = $right_label;
            }
        }else if($likert_range == 9){
            if($output == 1 || $output == 2 || $output == 3){
                $likert_label = $left_label;
            }else if($output == 4 || $output == 5 || $output == 6){
                $likert_label = $middle_label;
            }else if($output == 7 || $output == 8 || $output == 9){
                $likert_label = $right_label;
            }
        }else if($likert_range == 10){
            if($output == 1 || $output == 2 || $output == 3){
                $likert_label = $left_label;
            }else if($output == 4 || $output == 5 || $output == 6 || $output == 7){
                $likert_label = $middle_label;
            }else if($output == 8 || $output == 9 || $output == 10){
                $likert_label = $right_label;
            }
        }
    }
    $tempresult = [$qus->question_name => $likert_label];
    $result = $likert_label;

}
else if($qus->qus_type == 'matrix_qus'){
    if($output=='Skip'){
        $qusvalue = json_decode($qus->qus_ans); 
        $exiting_qus_matrix= $qus!=null ? explode(",",$qusvalue->matrix_qus): []; 
        foreach($exiting_qus_matrix as $op){
            $result ='Skip'; 
        }
    }else{
        $output = json_decode($output);
        foreach($output as $op){
            $tempresult = [$op->qus =>$op->ans];
            $result =$op->ans; 
        }
    }
    
}else if($qus->qus_type == 'rankorder'){
    $output = json_decode($output,true);
    $ordering = [];
    foreach($output as $op){
        array_push($ordering,$op['id']);
    }
    $tempresult = [$qus->question_name =>implode(',',$ordering)];
    $result=implode(',',$ordering);
}else if($qus->qus_type == 'photo_capture'){
    $img = "<a target='_blank' href='$output'><img class='photo_capture' src='$output'/></a>";
    $tempresult = [$qus->question_name =>$img];
    $result=$img;
}else if($qus->qus_type=='upload'){
    $output1=asset('uploads/survey/'.$output);
    $img = "<a target='_blank' href='$output1'>".$output."</a>";
    $tempresult = [$qus->question_name =>$img];
    $result=$img;
}else{
    $tempresult = [$qus->question_name =>$output];
    $result=$output;
}
?>
    @if(isset($question))
        <div class="surveysparrow-survey-container--classic-form questionset" id="questionkey{{$key}}">
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
                                        @if($csurvey->skip == 'yes')
                                            Answer : Skipped
                                        @else
                                            Answer : {!! $result !!}
                                        @endif
                                    </div>
                                  
                                    <div class="ss_cl_qstn_action disabled {{$question->qus_type}}_action">
                                        <div class="paginatedQus">
                                        @if($key!=0)
                                        <button onclick="nextqus({{$key}},{{$prevKey}})" id="next_button"  class=" ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Prev</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg>
                                            </button>
                                        @endif
                                        @if(count($surveyCompleted) == $nextKey) 
                                       <a class="back_to_profile" href="{{ route('user.dashboard') }}"><button id="next_button"  class=" ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">Done</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg> </button></a>
                                           
                                             @else  
                                            <button onclick="nextqus({{$key}},{{$nextKey}})" id="next_button"  class=" ss-primary-action-btn ss-survey-font-family ss-survey-text-size--base sm_ss-survey-text-size--base ss-survey-line-height--tight ss-survey-text-weight--bold"><span class="ss-primary-action-btn__copy">  Next</span>
                                                <svg width="18" height="18" class="mirror--rtl" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.66552 13.3716C5.46027 13.1869 5.44363 12.8708 5.62836 12.6655L9.82732 8L5.62836 3.33448C5.44363 3.12922 5.46027 2.81308 5.66552 2.62835C5.87078 2.44362 6.18692 2.46026 6.37165 2.66551L10.8717 7.66551C11.0428 7.85567 11.0428 8.14433 10.8717 8.33448L6.37165 13.3345C6.18692 13.5397 5.87078 13.5564 5.66552 13.3716Z" stroke-width="1"></path>
                                                </svg>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
        
    </div>
</body>
<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
<script>
    function nextqus(key,nextkey){
        $('#questionkey'+key).css('display','none');
        $('#questionkey'+nextkey).css('display','block');
        console.log(key,'dfsd');
    }
</script>
</html>