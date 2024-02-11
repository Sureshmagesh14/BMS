@include('admin.layout.header')
    @yield('adminside-favicon')
    @yield('adminside-css')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
<!-- ========== Left Sidebar Start ========== -->
<link href="{{ asset('assets/css/builder.css') }}" rel="stylesheet" type="text/css" />

<style>
    .iconssec svg {
        height: 24px;
    }
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
                    <div class="iconssec"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 36 36" class="ss-questions-wrapper__emoji-icon"><path fill="#E0AA94" d="M4.861 9.147c.94-.657 2.357-.531 3.201.166l-.968-1.407c-.779-1.111-.5-2.313.612-3.093 1.112-.777 4.263 1.312 4.263 1.312-.786-1.122-.639-2.544.483-3.331a2.483 2.483 0 013.456.611l10.42 14.72L25 31l-11.083-4.042L4.25 12.625a2.495 2.495 0 01.611-3.478z"></path><path fill="#F7DECE" d="M2.695 17.336s-1.132-1.65.519-2.781c1.649-1.131 2.78.518 2.78.518l5.251 7.658c.181-.302.379-.6.6-.894L4.557 11.21s-1.131-1.649.519-2.78c1.649-1.131 2.78.518 2.78.518l6.855 9.997c.255-.208.516-.417.785-.622L7.549 6.732s-1.131-1.649.519-2.78c1.649-1.131 2.78.518 2.78.518l7.947 11.589c.292-.179.581-.334.871-.498L12.238 4.729s-1.131-1.649.518-2.78c1.649-1.131 2.78.518 2.78.518l7.854 11.454 1.194 1.742c-4.948 3.394-5.419 9.779-2.592 13.902.565.825 1.39.26 1.39.26-3.393-4.949-2.357-10.51 2.592-13.903L24.515 8.62s-.545-1.924 1.378-2.47c1.924-.545 2.47 1.379 2.47 1.379l1.685 5.004c.668 1.984 1.379 3.961 2.32 5.831 2.657 5.28 1.07 11.842-3.94 15.279-5.465 3.747-12.936 2.354-16.684-3.11L2.695 17.336z"></path><path fill="#5DADEC" d="M12 32.042C8 32.042 3.958 28 3.958 24c0-.553-.405-1-.958-1-.553 0-1.042.447-1.042 1C1.958 30 6 34.042 12 34.042c.553 0 1-.489 1-1.042s-.447-.958-1-.958z"></path><path fill="#5DADEC" d="M7 34c-3 0-5-2-5-5a1 1 0 10-2 0c0 4 3 7 7 7a1 1 0 100-2zM24 2a1 1 0 000 2c4 0 8 3.589 8 8a1 1 0 002 0c0-5.514-4-10-10-10z"></path><path fill="#5DADEC" d="M29 .042c-.552 0-1 .406-1 .958 0 .552.448 1.042 1 1.042 3 0 4.958 2.225 4.958 4.958 0 .552.489 1 1.042 1s.958-.448.958-1C35.958 3.163 33 .042 29 .042z"></path></svg></div>
                
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
                @foreach($thankQus as $qus)
               
                    <div class="fx-jc--between ss-builder-add-new ss-builder-add-new--sm-sidebar-card surveyques">
                        <div class="iconssec"><svg xmlns="http://www.w3.org/2000/svg" width="37" height="36" fill="none" viewBox="0 0 37 36" class="ss-questions-wrapper__emoji-icon"><path fill="#DD2E44" d="M12.584 6.949a1.413 1.413 0 00-.268.395l-.008-.008L1.092 32.602l.011.011c-.208.403.14 1.223.853 1.937.713.713 1.533 1.061 1.936.853l.01.01 25.266-11.217-.008-.009c.147-.07.282-.155.395-.269 1.562-1.562-.971-6.627-5.656-11.313-4.687-4.686-9.752-7.218-11.315-5.656z"></path><path fill="#EA596E" d="M13.958 11.461L1.374 31.967l-.282.635.011.011c-.208.403.14 1.223.853 1.937.232.232.473.408.709.557l15.293-18.646-4-5z"></path><path fill="#A0041E" d="M23.97 12.527c4.67 4.672 7.263 9.652 5.789 11.124-1.473 1.474-6.453-1.118-11.126-5.788-4.671-4.672-7.263-9.654-5.79-11.127 1.474-1.473 6.454 1.119 11.127 5.791z"></path><path fill="#AA8DD8" d="M19.548 13.07a.99.99 0 01-.734.215c-.868-.094-1.598-.396-2.109-.873-.541-.505-.808-1.183-.735-1.862.128-1.192 1.324-2.286 3.363-2.066.793.085 1.147-.17 1.159-.292.014-.121-.277-.446-1.07-.532-.868-.094-1.598-.396-2.11-.873-.541-.505-.809-1.183-.735-1.862.13-1.192 1.325-2.286 3.362-2.065.578.062.883-.057 1.012-.134.103-.063.144-.123.148-.158.012-.121-.275-.446-1.07-.532a.998.998 0 01-.886-1.102.997.997 0 011.101-.886c2.037.219 2.973 1.542 2.844 2.735-.13 1.194-1.325 2.286-3.364 2.067-.578-.063-.88.057-1.01.134-.103.062-.145.123-.149.157-.013.122.276.446 1.071.532 2.037.22 2.973 1.542 2.844 2.735-.129 1.192-1.324 2.286-3.362 2.065-.578-.062-.882.058-1.012.134-.104.064-.144.124-.148.158-.013.121.276.446 1.07.532a1 1 0 01.52 1.773z"></path><path fill="#77B255" d="M31.619 22.318c1.973-.557 3.334.323 3.658 1.478.324 1.154-.378 2.615-2.35 3.17-.77.216-1.001.584-.97.701.034.118.425.312 1.193.095 1.972-.555 3.333.325 3.657 1.479.326 1.155-.378 2.614-2.351 3.17-.769.216-1.001.585-.967.702.033.117.423.311 1.192.095a1 1 0 11.54 1.925c-1.971.555-3.333-.323-3.659-1.479-.324-1.154.379-2.613 2.353-3.169.77-.217 1.001-.584.967-.702-.032-.117-.422-.312-1.19-.096-1.974.556-3.334-.322-3.659-1.479-.325-1.154.378-2.613 2.351-3.17.768-.215.999-.585.967-.701-.034-.118-.423-.312-1.192-.096a1 1 0 11-.54-1.923z"></path><path fill="#AA8DD8" d="M23.959 19.621a1.001 1.001 0 01-.626-1.781c.218-.175 5.418-4.259 12.767-3.208a1 1 0 11-.283 1.979c-6.493-.922-11.187 2.754-11.233 2.791a.999.999 0 01-.625.219z"></path><path fill="#77B255" d="M6.712 15.461a1 1 0 01-.958-1.287c1.133-3.773 2.16-9.794.898-11.364-.141-.178-.354-.353-.842-.316-.938.072-.849 2.051-.848 2.071a1 1 0 11-1.994.149C2.865 3.335 3.294.679 5.66.5 6.716.42 7.593.787 8.212 1.557c2.371 2.951-.036 11.506-.542 13.192a1 1 0 01-.958.712z"></path><path fill="#5C913B" d="M26.458 10.461a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path><path fill="#9266CC" d="M2.958 19.461a2 2 0 100-4 2 2 0 000 4z"></path><path fill="#5C913B" d="M33.458 20.461a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM24.458 32.461a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path><path fill="#FFCC4D" d="M28.958 5.461a2 2 0 100-4 2 2 0 000 4zM33.458 9.461a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM30.458 13.461a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM8.458 24.461a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path></svg></div>
                        <div class="d-flex fx-ai--center">
                        <a href="{{route('survey.builder',[$survey->builderID,$qus->id])}}" class="quesset">
                            @if($qus->question_name=='')
                                <p>Thank You Page</p>
                            @else
                            <p><?php echo substr($qus->question_name, 0, 15); if(strlen($qus->question_name)>16) echo ".."; ?></p>
                            @endif
                            </a>
                        </div>
                        <div class="ss-builder-features__button">
                        <?php $url =route("survey.deletequs",$qus->id);?>
                            <i data-feather="trash-2" onclick="qusdelete('{{$url}}')"></i>
                        </div>
                    </div>
                    @endforeach
               
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
