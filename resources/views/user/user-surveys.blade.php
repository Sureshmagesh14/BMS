@include('user.layout.header-2')
@php 
$cat = '';
$catname = array(1=>'Basic',2=>'Essential',3=>'Extended');
@endphp

 <section class="bg-greybg vh-100">
      <div class="container">
        <div class="row align-items-center justify-content-center pt-5">
          <div class="col-md-2 hide-mobile">
            <img class="img-fluid" src="{{ asset('assets/images/Characters-01.png') }}" alt=""/>
          </div>
          <div class="col-md-8">
            <h3 class="text-center">{{ $catname[$data->type_id] }} </h3>
            <div class="bg-white text-center py-5  d-flex flex-column">
              <!-- <div class="completed-items"><span>4/10</span></div> -->
                <div class="w-100">
                  <div class="c100 p20 blue">
                    <span>2/10</span>
                    <div class="slice">
                      <div class="bar"></div>
                      <div class="fill"></div>
                    </div>
                </div>
                </div>
                <div class="columns">
                  <p class="fw-bolder">{{$data->name}}</p>
                 
                  
                  <form>
                    <input type="hidden" name="cat" id="cat" value="questions{{ request()->up }}">
                  <div class="question-container"></div>
                  </form>

                  <div class="button">

                  <a id="backBtn" href="#" class="btn vi-bg-drk text-white px-5 w-75">Back</a>
                  <br><br>
                  <a id="nextBtn" href="#" class="btn vi-bg-drk text-white px-5 w-75">Next</a>

                  </div>  
                </div>
                

       
            </div>
          </div>
          <div class="col-md-2 hide-mobile">
            <img class="img-fluid" src="{{ asset('assets/images/Characters-02.png') }}" alt="" />
          </div>
        </div>
      </div>
    </section>


@include('user.layout.footer')

<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {

    $('#nav_surveys').addClass('active');
    

});
    var questions2 = [
        {   
        text: 'How much wood could a woodchuck chuck if a woodchuck could chuck wood?', 
        id: '1', 
        type: 'multi-select', 
        options: ["37", "112", "42", "100", "112", "42", "100", "112", "42", "100"]},

        {   
        text: 'What has a face and two hands but no arms or legs?', 
        id: '2', 
        type: 'single-select', 
        options: ["a clock", "a dog", "a couch", "a giraffe"]},
        {     
        text: 'hat gets wetter and wetter the more it dries?', 
        id: '3', 
        type: 'single-select', 
        options: ["a car", "a towel", "a plane", "a television"]}
  ];

  var questions1 = [
        {   
       
        text: 'In addition to the less frequent, higher paying research, you can now also do lots of short online surveys, and all that money adds up quickly.', 

        id: '1', 
        type: 'no-option', 
        options: [""]},

        {   

        text: 'Would you like to do 1-2hr online or face-to-face research paying up to R1200 (max 2 per year)?<br>- Focus Group Discussions- Interviews<br>- Mystery Shops<br>- Multiday online communities', 
        id: '2', 
        type: 'single-select', 
        options: ["Yes", "No"]}
  ];

var portionOfWindowSizeForQuestions = 0.2;
var firstQuestionDisplayed = 0;
var lastQuestionDisplayed = 0;

$(document).ready(function(){
  var curr_questions = $('#cat').val();


    questions<?php echo request()->up; ?>.forEach(function(question) {
      generateQuestionElement( question );
    });


  
  $('#backBtn').click(function() {
    if ( !$('#backBtn').hasClass('disabled') ) {
      showPreviousQuestionSet(curr_questions);
    }
  });
  
  $('#nextBtn').click(function() {
    if ( $('#nextBtn').text() === 'Next' ) {
      showNextQuestionSet(curr_questions);
    } else {
      // call submitting stuff here.  
      alert("done");
    }
    
  });
  
  showNextQuestionSet(curr_questions);
     
});



function generateQuestionElement(question) {
  
  var questionId = "q_" + question.id;
  var questionElement = $('<div id="' + questionId + '" class="question"></div>');
  var questionTextElement = $('<legend class="question-text"></legend>');
  var questionAnswerElement = $('<div class="answer"></div>');
  questionElement.appendTo($('.question-container'));
  questionElement.append(questionTextElement);
  questionElement.append(questionAnswerElement);
  questionTextElement.text(question.text);
  if ( question.type === 'single-select' ) {
    questionElement.addClass('single-select');
    question.options.forEach(function(option) {
      questionAnswerElement.append(
        '<label class="radio"><input type="radio" value="' + option + '" name="' + questionId + '"/>' + option + '</label>');
    });
  }
  if ( question.type === 'multi-select' ) {
    questionElement.addClass('multi-select');
    question.options.forEach(function(option) {
      questionAnswerElement.append(
        '<label class="checkobx"><input type="checkbox" value="' + option + '" name="' + questionId + '"/>' + option + '</label>');
    });
  }
  questionElement.hide();
}


function hideAllQuestions() {
  $('.question:visible').each(function(index, element){
    $(element).hide();
  });
}


function showNextQuestionSet(org1) {
  hideAllQuestions();
  var finished = false;
  firstQuestionDisplayed = ++lastQuestionDisplayed;
  
  do {
    $('.question-container > div.question:nth-child(' + lastQuestionDisplayed + ')').show();
    var nextElement = $('.question-container > div.question:nth-child(' + (lastQuestionDisplayed + 1) + ')');
    nextElement.show();

    if ( lastQuestionDisplayed >= org1.length || $('.question-container').height() > $(window).height() * portionOfWindowSizeForQuestions ) {
      nextElement.hide();
      finished = true;
    } else {
      lastQuestionDisplayed++;
    }
  } while( !finished );
  
  doButtonStates(org1);
}


function showPreviousQuestionSet(org1) {
  hideAllQuestions();
  var finished = false;
  lastQuestionDisplayed = --firstQuestionDisplayed;
  
  do {
    $('.question-container > div.question:nth-child(' + firstQuestionDisplayed + ')').show();
    var previousElement = $('.question-container > div.question:nth-child(' + (firstQuestionDisplayed - 1) + ')');
    previousElement.show();
    
    if ( firstQuestionDisplayed <= 1 || $('.question-container').height() > $(window).height() * portionOfWindowSizeForQuestions ) {
      previousElement.hide();
      finished = true;
    } else {
      firstQuestionDisplayed--;
    }
    
  } while( !finished );
  
  doButtonStates(org1);
  
}


function doButtonStates(org1) {
  
  if ( firstQuestionDisplayed == 1 ) {
    $('#backBtn').addClass('disabled');  
  } else if ( $('#backBtn' ).hasClass('disabled') ) {
    $('#backBtn').removeClass('disabled');
  }
    
  if ( lastQuestionDisplayed == org1.length ) {
    $('#nextBtn').text('Finish');    
  } else if ( $('#nextBtn').text() === 'Finish' ) {
    $('#nextBtn').text('Next');  
  }
}


</script>
