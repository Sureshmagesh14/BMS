@include('admin.layout.header')
    @yield('adminside-favicon')
    @yield('adminside-css')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
<!-- ========== Left Sidebar Start ========== -->
<link href="{{ asset('assets/css/builder.css') }}" rel="stylesheet" type="text/css" />

<style>
    span#qus_type {
        font-weight: bold;
    }
    #update_qus_final{
        display:none;
    }
    .addchoice {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 10px;
    }
    .input-group.choicequs {
        margin-top: 5px;
        margin-bottom: 5px;
    }
    #multi_choice_qus,#single_choice_qus{
        display:none;
    }
    .modal-body{
        color:black;
    }
    .allqus{
        width:80%;
    }
    .ss-builder-features__button {
        color: #4A9CA6;
    }
    .ss-builder-add-new .icon-wrapper{
        color:white;
    }
    a.quesset.active {
        background: unset !important;
    }
    a.quesset.active p {
        color: #2a4fd7!important;
    }
    .surveyques {
        color: #4A9CA6 !important;
    }
    a.waves-effect.active span.menu-item {
        color: #495057 !important;
    }
    a.waves-effect.active {
        background: white !important;
    }
    li.mm-active {
        background: white;
    }
    .surveyrow {
        border-bottom: 1px solid #EAEAEA;
    }
    .ss-text__size--h3 {
        font-size: 16px;
    }
    .ss-text__weight--semibold {
        font-weight: 600;
    }
    .ss-text__color--dark, .ss-text__color--black {
        color: #25292D;
    }
</style>
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{route('survey')}}"  class="logo  surveytitle">
            {{$survey->title}}
        </a>
        <a href="{{route('survey')}}" ><i data-feather="home"></i></a>

       
    </div>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
       
            <!-- Left Menu Start -->
               <?php $i=1;?>
               @if($welcomQus)
                <div class="fx-jc--between ss-builder-add-new ss-builder-add-new--sm-sidebar-card surveyques">
                    <div class="d-flex fx-ai--center">
                        <a href="{{route('survey.builder',[$survey->builderID,$welcomQus->id])}}" class="quesset">
                            @if($welcomQus->name=='')
                                <p>Welcome Page</p>
                            @else
                            <p>{{$welcomQus->name}}</p>
                            @endif
                        </a>
                    </div>
                    <div class="ss-builder-features__button">
                        <?php $url =route("survey.deletequs",$welcomQus->id);?>
                        <i data-feather="trash-2" onclick="qusdelete('{{$url}}')"></i>
                    </div>
                </div>
              
               @endif
               <?php $i=1;?>
                @foreach($questions as $qus)
                    <div class="fx-jc--between ss-builder-add-new ss-builder-add-new--sm-sidebar-card surveyques" >
                        <a href="{{route('survey.builder',[$survey->builderID,$qus->id])}}" class="quesset allqus">
                            <div class="d-flex fx-ai--center" onclick="sectactivequs({{$qus->id}},'{{$qus->qus_type}}')">
                                <p><?php echo $i.'.'.substr($qus->question_name, 0, 15); if(strlen($qus->question_name)>16) echo ".."; ?></p>
                            </div>
                        </a>
                        <div class="ss-builder-features__button">
                        <?php $url =route("survey.deletequs",$qus->id);?>
                            <i data-feather="trash-2" onclick="qusdelete('{{$url}}')"></i>
                        </div>
                    </div>
                    <?php $i++;?>
                @endforeach
                
                <a href="#" data-url="{{route('survey.questiontype',$survey->id)}}" data-ajax-popup="true" data-bs-toggle="tooltip" title="Choose Question Type" data-title="Choose Question Type">
                    <div class="fx-jc--between ss-builder-add-new ss-builder-add-new--sm-sidebar-card ">
                        <div class="d-flex fx-ai--center">
                            <div class="icon-wrapper"> <i data-feather="plus"></i></div>
                            <p class="addqus">Add a question</p>
                        </div>
                    </div>
                </a>
                @if($thankQus)
               
                    <div class="fx-jc--between ss-builder-add-new ss-builder-add-new--sm-sidebar-card surveyques">
                        <div class="d-flex fx-ai--center">
                        <a href="{{route('survey.builder',[$survey->builderID,$thankQus->id])}}" class="quesset">
                            @if($thankQus->name=='')
                                <p>Thank You Page</p>
                            @else
                             <p>{{$thankQus->name}}</p>
                            @endif
                            </a>
                        </div>
                        <div class="ss-builder-features__button">
                        <?php $url =route("survey.deletequs",$thankQus->id);?>
                            <i data-feather="trash-2" onclick="qusdelete('{{$url}}')"></i>
                        </div>
                    </div>
               
                @endif

        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">My Surveys</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Survey</a></li>
                                <li class="breadcrumb-item active">Survey</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}" />
           
            <!-- end page title -->
            <div class="card card-body">
                @if(isset($currentQus))
                    <?php  $qusvalue = json_decode($currentQus->qus_ans); 
                    $qus_name='';
                    if(isset($qusvalue->question_name)){
                        $qus_name=$qusvalue->question_name; 
                    } else if(isset($currentQus->question_name)){
                        $qus_name=$currentQus->question_name; 
                    } 
                    ?>
                    {{ Form::open(array('url' => route('survey.qus.update',$currentQus->id),'id'=>'updatequs','class'=>'needs-validation')) }}
                    <h4>Question Type : <span id="qus_type">{{$qus_type}}</span></h4>
                    @if($currentQus->qus_type=='welcome_page')
                        <div class="modal-body">
                            <div>
                                {{ Form::label('welcome_title', __('Title'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->welcome_title))
                                    {{ Form::text('welcome_title', $qusvalue->welcome_title , array('class' => 'form-control',
                                'placeholder'=>'Enter Welcome Page title')) }}
                                @else 
                                    {{ Form::text('welcome_title', null , array('class' => 'form-control',
                                'placeholder'=>'Enter Welcome Page title')) }}
                                @endif
                            </div>
                            <br>
                            <div>
                                {{ Form::label('welcome_imagetitle', __('Sub Title'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->welcome_imagetitle))
                                    {{ Form::text('welcome_imagetitle', $qusvalue->welcome_imagetitle , array('class' => 'form-control',
                                'placeholder'=>'Sub title')) }}
                                @else 
                                    {{ Form::text('welcome_imagetitle', null , array('class' => 'form-control',
                                'placeholder'=>'Sub title')) }}
                                @endif
                            </div>
                            <br>
                            <div>
                                {{ Form::label('welcome_imagesubtitle', __('Description'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->welcome_imagetitle))
                                    {{ Form::text('welcome_imagesubtitle', $qusvalue->welcome_imagesubtitle , array('class' => 'form-control',
                                'placeholder'=>'Description')) }}
                                @else 
                                    {{ Form::text('welcome_imagesubtitle', null , array('class' => 'form-control',
                                'placeholder'=>'Description')) }}
                                @endif
                            
                            </div>
                            <br>
                            <div>
                                {{ Form::label('welcome_btn', __('Button Label'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->welcome_imagetitle))
                                    {{ Form::text('welcome_btn', $qusvalue->welcome_btn , array('class' => 'form-control',
                                'placeholder'=>'Enter Button Label')) }}
                                @else 
                                    {{ Form::text('welcome_btn', null , array('class' => 'form-control',
                                'placeholder'=>'Enter Button Label')) }}
                                @endif
                            </div>
                            <br>
                            <!-- 
                            <input type="file" style="visibility:hidden;" name="welcome_image" id="welcome_image">
                            <div class="gallery">
                                <a target="_blank" href="https://www.w3schools.com/css/img_5terre.jpg">
                                    <img src="https://www.w3schools.com/css/img_5terre.jpg" alt="Cinque Terre" width="600" height="400">
                                </a>
                            </div> -->
                        </div>
                    @endif
                    @if($currentQus->qus_type=='thank_you')
                        <div class="modal-body">
                            <div>
                                {{ Form::label('thankyou_title', __('Title'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->thankyou_title))
                                    {{ Form::text('thankyou_title', $qusvalue->thankyou_title , array('class' => 'form-control',
                                'placeholder'=>'Enter thank you page title')) }}
                                @else 
                                    {{ Form::text('thankyou_title', null , array('class' => 'form-control',
                                'placeholder'=>'Enter thank you page title')) }}
                                @endif
                            </div>
                            <br>
                            <div>
                                {{ Form::label('thankyou_imagetitle', __('Sub Title'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->thankyou_imagetitle))
                                    {{ Form::text('thankyou_imagetitle', $qusvalue->thankyou_imagetitle , array('class' => 'form-control',
                                'placeholder'=>'Sub title')) }}
                                @else 
                                    {{ Form::text('thankyou_imagetitle', null , array('class' => 'form-control',
                                'placeholder'=>'Sub title')) }}
                                @endif
                            </div>
                            <br>
                        </div>
                    @endif
                    @if($currentQus->qus_type!='welcome_page' && $currentQus->qus_type!='thank_you')
                        <div class="modal-body">
                                <div>
                                    {{ Form::label('question_name', __('Add description to your question'),['class'=>'form-label']) }}
                                        {{ Form::text('question_name', $qus_name , array('class' => 'form-control',
                                    'placeholder'=>'Enter Question Description')) }}
                                </div>
                                <br>
                                @if($currentQus->qus_type=='open_qus')
                                        <div class="open_qus">
                                            {{ Form::label('open_qus_choice', __('Type'),['class'=>'form-label']) }}<br>
                                            <div>
                                                @if($qusvalue!=null && $qusvalue->open_qus_choice == 'single')
                                                    <input type="radio" id="single" name="open_qus_choice" value="single" checked>
                                                @else 
                                                    <input type="radio" id="single" name="open_qus_choice" value="single">
                                                @endif
                                                <label for="single">Single Line</label>
                                            </div>
                                            <div>
                                                @if($qusvalue!=null && $qusvalue->open_qus_choice == 'multi')
                                                    <input type="radio" id="multi" name="open_qus_choice" value="multi" checked>
                                                @else 
                                                    <input type="radio" id="multi" name="open_qus_choice" value="multi">
                                                @endif
                                                <label for="multi">Multi Lines</label>
                                            </div>
                                        </div>
                                        <br>
                                        <div>
                                        {{ Form::text('single_choice_qus', null , array('id'=>'single_choice_qus','class' => 'form-control','placeholder'=>'Single Line','readonly'=>true)) }}
                                        {{ Form::textarea('multi_choice_qus', null , array('id'=>'multi_choice_qus','class' => 'form-control','placeholder'=>'Multi Lines','readonly'=>true)) }}
                                        </div>
                                @endif
                                
                                @if($currentQus->qus_type=='single_choice' || $currentQus->qus_type=='mutli_choice' || $currentQus->qus_type=='dropdown')
                                    <div class="addchoice">
                                        <input type="button" id="add_choice" onclick="addchoice();" value="Add Choice" class="btn btn-primary">
                                    </div>
                                    <?php $exiting_choices=$qusvalue!=null ? explode(",",$qusvalue->choices_list): []; ?>
                                    <?php //echo "<pre>"; print_r($qusvalue); ?>

                                    <div id="choices_section" class="row">
                                        @foreach($exiting_choices as $choice)
                                            <div id="row" class="col-md-3">
                                                <div class="input-group choicequs">
                                                    <input type="text" name="choice" value="{{$choice}}" class="form-control m-input">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-danger" id="DeleteRow" type="button">X</button> 
                                                    </div>
                                                </div> 
                                            </div>
                                        @endforeach
                                    </div> 
                                    <input type="hidden" id="choices_list" name="choices_list[]">                           
                                @endif
                                @if($currentQus->qus_type=='email')
                                {{ Form::label('email', __('Email Box Sample'),['class'=>'form-label']) }}
                                {{ Form::text('email', 'info@bms.com' , array('class' => 'form-control',
                                    'readonly'=>'true')) }}
                                @endif
                                <?php //echo $currentQus->qus_type; ?>
                        </div>
                    @endif
                    <input type="hidden" name="qus_id" id="qus_id" value="{{$currentQus->id}}">
                    <input type="hidden" name="qus_type" id="qus_type" value="{{$currentQus->qus_type}}">
                    <input type="button" id="update_qus" onclick="triggersubmit('{{$currentQus->qus_type}}')" value="Submit" class="btn  btn-primary">
                    <input type="submit" id="update_qus_final" value="Submit" class="btn  btn-primary">
                    {{Form::close()}}
                @endif
            </div>

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>

<style>
div#survey-table_wrapper .row {
    width: 100%;
}

</style>
<script>
function addchoice(){
        newRowAdd ='<div id="row" class="col-md-3"><div class="input-group choicequs"><input type="text" name="choice" class="form-control m-input"><div class="input-group-prepend"><button class="btn btn-danger" id="DeleteRow" type="button">X</button> </div></div> </div>';
 
        $('#choices_section').append(newRowAdd);
}
$("body").on("click", "#DeleteRow", function () {
    $(this).parents("#row").remove();
});
function triggersubmit(qus_type){
    console.log(qus_type,"dd")
    if(qus_type=='single_choice' || qus_type=='mutli_choice' || qus_type=='dropdown'){
        let choices=[];
        $("input[name=choice]").each(function(idx, elem) {
            choices.push($(elem).val());
        });
        $('#choices_list').val(choices);
        console.log(choices,"choices");
        if(choices.length>0){
            $('#update_qus_final').click();
        }
    }else{
        $('#update_qus_final').click();
    }
}
function qusdelete(url){
    Swal.fire({ 
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning", showCancelButton: !0, 
        confirmButtonColor: "#34c38f", 
        cancelButtonColor: "#f46a6a", 
        confirmButtonText: "Yes, delete it!" 
    }).then(function (t) { 
        if(t.isConfirmed){
            $.ajax({url: url, success: function(result){
                result = JSON.parse(result);
                if(result.error!=''){
                    t.value && Swal.fire("Warning!", result.error, "warning") ;
                }else{
                    t.value && Swal.fire("Deleted!", result.success, "success") ;
                }
                window.location.reload();
            }});
        }
        
    })
}

function sectactivequs(id,type){
    console.log(id,type);
    qustype(type)
}
function qustype(type){
    console.log(type,"type")
    let qusset={'welcome_page':'Welcome Page','single_choice':'Single Choice','mutli_choice':'Multi Choice','open_qus':'Open Questions','likert':'Likert scale','ranking':'Ranking','dropdown':'Dropdown','picturechoice':'Picture Choice','email':'Email','matrix_qus':'Matrix Question','thank_you':'Thank You Page'};
    console.log(qusset[type],"qusset")
}
$('input[type=radio][name=open_qus_choice]').change(function() {
    console.log(this.value)
    if(this.value=='single'){
        $('#single_choice_qus').css('display','block');
        $('#multi_choice_qus').css('display','none');
    }else{
        $('#multi_choice_qus').css('display','block');
        $('#single_choice_qus').css('display','none');
    }
});

</script>
    @yield('adminside-script')
@include('admin.layout.footer')
