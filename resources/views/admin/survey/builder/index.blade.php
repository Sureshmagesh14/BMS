@include('admin.layout.header')
    @yield('adminside-favicon')
    @yield('adminside-css')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
<!-- ========== Left Sidebar Start ========== -->
<link href="{{ asset('assets/css/builder.css') }}" rel="stylesheet" type="text/css" />

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
                    <div class="d-flex qus_set">
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
                            @if($qus->qus_type=='open_qus')
                            <svg height="32" width="32" fill="none" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><rect height="32" width="32" fill="transparent" rx="3"></rect><path d="M6 12H26V20H6V12Z" stroke="#63686F"></path><line stroke="#63686F" x1="19.5" x2="19.5" y1="8" y2="24"></line><line stroke="#63686F" x1="17" x2="22" y1="8.5" y2="8.5"></line><line stroke="#63686F" x1="17" x2="22" y1="23.5" y2="23.5"></line></svg>
                            @elseif($qus->qus_type=='single_choice' || $qus->qus_type=='multi_choice')
                            <svg height="32" width="32" fill="none" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><rect height="32" width="32" fill="transparent" rx="3"></rect><path d="M10.5981 8.49989C9.1632 7.67147 7.32843 8.16309 6.5 9.59797C5.67157 11.0328 6.1632 12.8676 7.59808 13.696C9.03295 14.5245 10.8677 14.0328 11.6962 12.598" stroke="#63686F"></path><path d="M10.5981 19.4999C9.1632 18.6715 7.32843 19.1631 6.5 20.598C5.67157 22.0328 6.1632 23.8676 7.59808 24.696C9.03295 25.5245 10.8677 25.0328 11.6962 23.598" stroke="#63686F"></path><line stroke="#63686F" x1="13.915" x2="25.915" y1="9.63379" y2="9.63379"></line><line stroke="#63686F" x1="13.915" x2="21.915" y1="11.6338" y2="11.6338"></line><line stroke="#63686F" x1="13.915" x2="25.915" y1="20.6338" y2="20.6338"></line><line stroke="#63686F" x1="13.915" x2="21.915" y1="22.6338" y2="22.6338"></line></svg>
                            @elseif($qus->qus_type=='likert')
                            <svg height="32" width="32" fill="none" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><rect height="32" width="32" fill="transparent" rx="3"></rect><rect height="8" width="20" stroke="#63686F" x="6" y="10"></rect><path d="M18.5 19.5L15 22.5355H22.0711L18.5 19.5Z" fill="#63686F"></path></svg>
                            @elseif($qus->qus_type=='rankorder')
                            <svg height="32" width="32" fill="none" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><rect height="32" width="32" fill="transparent" rx="3"></rect><rect height="4" width="5" stroke="#63686F" x="6" y="21"></rect><rect height="7" width="5" stroke="#63686F" x="20" y="18"></rect><rect height="10" width="5" stroke="#63686F" x="13" y="15"></rect><circle cx="15.5" cy="10.5" r="2.5" stroke="#63686F"></circle><circle cx="22.5" cy="13.5" r="2.5" stroke="#63686F"></circle><circle cx="8.5" cy="16.5" r="2.5" stroke="#63686F"></circle></svg>
                            @elseif($qus->qus_type=='rating')
                            <svg height="32" width="32" fill="none" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><rect height="32" width="32" fill="transparent" rx="3"></rect><path d="M15.5975 8.2488L13.479 12.4428C13.4068 12.585 13.2865 12.6798 13.118 12.7034L8.39967 13.3669C8.01451 13.4143 7.87007 13.8882 8.13487 14.1488L11.5773 17.4424C11.6977 17.5372 11.7458 17.7031 11.7217 17.8452L10.9033 22.4658C10.831 22.8449 11.2403 23.1292 11.5773 22.9397L15.79 20.7597C15.9345 20.6886 16.0789 20.6886 16.2234 20.7597L20.4361 22.9397C20.7731 23.1055 21.1824 22.8212 21.1101 22.4658L20.3157 17.8452C20.2917 17.7031 20.3398 17.5372 20.4602 17.4424L23.8544 14.1725C24.1433 13.9119 23.9748 13.438 23.5896 13.3906L18.8954 12.7034C18.751 12.6798 18.6066 12.585 18.5343 12.4428L16.4159 8.2488C16.2474 7.91707 15.766 7.91707 15.5975 8.2488Z" stroke="#63686F" stroke-linecap="round"></path></svg>
                            @elseif($qus->qus_type=='dropdown')
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="3" fill="transparent"></rect><rect x="7.5" y="7.5" width="17" height="7" stroke="#63686F"></rect><path d="M18 10L20 11.5L22 10" stroke="#63686F"></path><line x1="11" y1="17.5" x2="25" y2="17.5" stroke="#63686F"></line><line x1="11" y1="20.5" x2="25" y2="20.5" stroke="#63686F"></line><line x1="11" y1="23.5" x2="25" y2="23.5" stroke="#63686F"></line></svg>
                            @elseif($qus->qus_type=='picturechoice')
                            <svg height="32" width="32" fill="none" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><rect height="32" width="32" fill="transparent" rx="3"></rect><rect height="17" width="17" stroke="#63686F" x="7.5" y="7.5"></rect><circle cx="13" cy="13" r="2.5" stroke="#63686F"></circle><path d="M8 24L14 20L16.5 22.5M17 20.5L20 18L24.5 22" stroke="#63686F"></path></svg>
                            @elseif($qus->qus_type=='email')
                            <svg height="32" width="32" fill="none" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><rect height="32" width="32" fill="transparent" rx="3"></rect><path d="M24.0001 8L13.2827 18.7174" stroke="#63686F" stroke-linecap="round"></path><path d="M16.6087 25L13.2826 18.7174L7 15.3913L24 8L16.6087 25Z" stroke="#63686F" stroke-linecap="round"></path></svg>
                            @elseif($qus->qus_type=='matrix_qus')
                            <svg height="32" width="32" fill="none" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><rect height="32" width="32" fill="transparent" rx="3"></rect><circle cx="9" cy="9" fill="#63686F" r="2.5" stroke="#63686F"></circle><circle cx="16" cy="9" fill="#63686F" r="2.5" stroke="#63686F"></circle><circle cx="23" cy="9" fill="#63686F" r="2.5" stroke="#63686F"></circle><circle cx="9" cy="16" r="2.5" stroke="#63686F"></circle><circle cx="16" cy="16" fill="#63686F" r="2.5" stroke="#63686F"></circle><circle cx="23" cy="16" r="2.5" stroke="#63686F"></circle><circle cx="9" cy="23" r="2.5" stroke="#63686F"></circle><circle cx="16" cy="23" r="2.5" stroke="#63686F"></circle><circle cx="23" cy="23" r="2.5" stroke="#63686F"></circle></svg>
                            @endif
                            <?php  $qus_url=route('survey.builder',[$survey->builderID,$qus->id]); ?>
                            <div class="d-flex qus_set" onclick="sectactivequs({{$qus->id}},'{{$qus->qus_type}}','{{$qus_url}}')">
                                <span class="qus_no"><?php echo $i; ?></span>
                                <a href="javascript:void(0);" class="quesset">
                                    @if($qus->question_name!='')
                                    <p><?php echo substr($qus->question_name, 0, 15); if(strlen($qus->question_name)>16) echo ".."; ?></p>
                                    @else
                                    <p class="allqus"></p>
                                    @endif
                                </a>
                            </div>
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
                        <div class="d-flex qus_set">
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
                    $icon_type='';
                    $left_label='Least Likely';
                    $middle_label='Netural';
                    $right_label='Most Likely';
                    if(isset($qusvalue->question_name)){
                        $qus_name=$qusvalue->question_name; 
                    } else if(isset($currentQus->question_name)){
                        $qus_name=$currentQus->question_name; 
                    } 
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
                    ?>
                    {{ Form::open(array('url' => route('survey.qus.update',$currentQus->id),'id'=>'updatequs','class'=>'needs-validation','enctype'=>"multipart/form-data")) }}
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
                            @if(isset($qusvalue->welcome_image))
                            <image src="{{ asset('uploads/survey/'.$qusvalue->welcome_image) }}" alt="image" width="100" height="100" id="existing_image">
                            <a id="ss_draft_remove_image_welcome" class="ss_draft_remove_image pointer--cursor"><svg xmlns="http://www.w3.org/2000/svg" class="" width="12" height="12" viewBox="0 0 21 25" fill="none"><path d="M13.209 20.2187H7.30662C6.83423 20.2187 6.37926 20.0404 6.03265 19.7195C5.68605 19.3985 5.47338 18.9586 5.43715 18.4876L4.63281 8.03125H15.8828L15.0785 18.4876C15.0422 18.9586 14.8296 19.3985 14.483 19.7195C14.1364 20.0404 13.6814 20.2187 13.209 20.2187V20.2187Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M16.9271 8.03125H3.59375" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.91406 5.21875H12.6016C12.8502 5.21875 13.0887 5.31752 13.2645 5.49334C13.4403 5.66915 13.5391 5.90761 13.5391 6.15625V8.03125H6.97656V6.15625C6.97656 5.90761 7.07533 5.66915 7.25115 5.49334C7.42697 5.31752 7.66542 5.21875 7.91406 5.21875V5.21875Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.8984 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.61719 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                            @endif
                            <div id="imgPreview"></div>
                            <div style="<?php if(isset($qusvalue->welcome_image) && $qusvalue->welcome_image!=''){ echo "display:none;"; } ?>" class="upload-image-placeholder" id="trigger_welcome_image">
                                <div class="upload-image-placeholder__upload-btn">
                                    <svg width="40" height="40" viewBox="0 0 36 27"><path fill="#D7D7D7" d="M7.5 8.25a2.25 2.25 0 114.502.002A2.25 2.25 0 017.5 8.25zM21 9l-3.779 6-3.721-2.94-6 8.94h21L21 9zm12-6v21H3V3h30zm3-3H0v27h36V0z"></path></svg>
                                    <p>Click here to upload a welcome image</p>
                                </div>
                            </div>
                            <input style="display:none;" type="file" id="welcome_image" name="welcome_image" required class="course form-control">
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
                            @if(isset($qusvalue->thankyou_image))
                            <image src="{{ asset('uploads/survey/'.$qusvalue->thankyou_image) }}" alt="image" width="100" height="100" id="existing_image_thankyou">
                            <a id="ss_draft_remove_image_thankyou" class="ss_draft_remove_image pointer--cursor"><svg xmlns="http://www.w3.org/2000/svg" class="" width="12" height="12" viewBox="0 0 21 25" fill="none"><path d="M13.209 20.2187H7.30662C6.83423 20.2187 6.37926 20.0404 6.03265 19.7195C5.68605 19.3985 5.47338 18.9586 5.43715 18.4876L4.63281 8.03125H15.8828L15.0785 18.4876C15.0422 18.9586 14.8296 19.3985 14.483 19.7195C14.1364 20.0404 13.6814 20.2187 13.209 20.2187V20.2187Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M16.9271 8.03125H3.59375" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.91406 5.21875H12.6016C12.8502 5.21875 13.0887 5.31752 13.2645 5.49334C13.4403 5.66915 13.5391 5.90761 13.5391 6.15625V8.03125H6.97656V6.15625C6.97656 5.90761 7.07533 5.66915 7.25115 5.49334C7.42697 5.31752 7.66542 5.21875 7.91406 5.21875V5.21875Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.8984 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.61719 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                            @endif
                            <div id="imgPreview"></div>
                            <div style="<?php if(isset($qusvalue->thankyou_image) && $qusvalue->thankyou_image!=''){ echo "display:none;"; } ?>" class="upload-image-placeholder" id="trigger_thankyou_image">
                                <div class="upload-image-placeholder__upload-btn">
                                    <svg width="40" height="40" viewBox="0 0 36 27"><path fill="#D7D7D7" d="M7.5 8.25a2.25 2.25 0 114.502.002A2.25 2.25 0 017.5 8.25zM21 9l-3.779 6-3.721-2.94-6 8.94h21L21 9zm12-6v21H3V3h30zm3-3H0v27h36V0z"></path></svg>
                                    <p>Click here to upload a thank you image</p>
                                </div>
                            </div>
                            <input style="display:none;" type="file" id="thankyou_image" name="thankyou_image" required class="course form-control">
                            
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
                                @if($currentQus->qus_type=='likert')
                                <div class="row">
                                    <div class="col-md-4">
                                        {{ Form::label('left_label','Left label',['class'=>'form-label']) }}
                                        {{ Form::text('left_label', $left_label , array('id'=>'left_label','class' => 'form-control','placeholder'=>'Left Label')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::label('middle_label','Middle label',['class'=>'form-label']) }}
                                        {{ Form::text('middle_label', $middle_label , array('id'=>'middle_label','class' => 'form-control','placeholder'=>'Middle Label')) }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::label('right_label','Right label',['class'=>'form-label']) }}
                                        {{ Form::text('right_label', $right_label , array('id'=>'right_label','class' => 'form-control','placeholder'=>'Right Label')) }}
                                    </div>
                                </div>
                                <div class="ss_row--builder ss-paddding--top-bottom"><div class="opinion-scale-container ss-paddding--top-bottom"><div class="opinion-scale-box"><div class="label label--start"><p id="left_lable_text">{{$left_label}}</p></div><div class="label label--middle"><p id="middle_lable_text">{{$middle_label}}</p></div><div class="label label--end"><p id="right_lable_text">{{$right_label}}</p></div><div class="scale-element"><span>1</span></div><div class="scale-element"><span>2</span></div><div class="scale-element"><span>3</span></div><div class="scale-element"><span>4</span></div><div class="scale-element"><span>5</span></div><div class="scale-element"><span>6</span></div><div class="scale-element"><span>7</span></div><div class="scale-element"><span>8</span></div><div class="scale-element"><span>9</span></div></div></div></div>
                                @endif
                                @if($currentQus->qus_type=='rating')
                                <input type="hidden" value="{{$icon_type}}" id="icon_type" name="icon_type"/>
                                <div class="ss_row--builder ss-paddding--top-bottom ">
                                    <div class="rating-container">
                                        <div class="rating-box smiley_icon"><div class="rating-element"><svg width="22" height="22" class="ss-smiley-icon ss-smiley-icon--1 undefined" viewBox="0 0 44 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 2)" class="ss-smiley-icon__g"><circle cx="20.125" cy="20.125" r="20.125"></circle><path transform="translate(-2 -1)" class="ss-smiley-icon__path" d="M9.77783 17.1117C10.7434 15.9261 12.0634 15.2539 13.4445 15.2539C14.8256 15.2539 16.1089 15.9261 17.1112 17.1117M26.889 17.1117C27.8545 15.9261 29.1745 15.2539 30.5556 15.2539C31.9367 15.2539 33.2201 15.9261 34.2223 17.1117" stroke="inherit" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path><path transform="translate(-1.7 -1)" class="ss-smiley-icon__path" d="M13.4441 31.7765C13.4441 31.7765 16.6537 28.5693 21.9997 28.5693C27.3481 28.5693 30.5552 31.7765 30.5552 31.7765" stroke="inherit" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></g></svg></div><div class="rating-element"><svg width="22" height="22" class="ss-smiley-icon ss-smiley-icon--2 undefined" viewBox="0 0 44 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 1)" class="ss-smiley-icon__g"><circle cx="21" cy="21" r="20.125"></circle><path class="ss-smiley-icon__path" d="M11.375 17.063a.437.437 0 110 .874.437.437 0 010-.875m19.25.001a.437.437 0 100 .874.437.437 0 000-.875M18.375 34.32a11.9 11.9 0 0112.25-5.25"></path></g></svg></div><div class="rating-element"><svg width="22" height="22" class="ss-smiley-icon ss-smiley-icon--3 undefined" viewBox="0 0 44 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 1)" class="ss-smiley-icon__g"><circle cx="21" cy="21" r="20.125"></circle><path class="ss-smiley-icon__path" d="M14.875 13.563a.437.437 0 110 .874.437.437 0 010-.874m12.25 0a.437.437 0 100 .874.437.437 0 000-.874m-17.5 13.562h22.75"></path></g></svg></div><div class="rating-element"><svg width="22" height="22" class="ss-smiley-icon ss-smiley-icon--4 undefined" viewBox="0 0 44 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 2)" class="ss-smiley-icon__g"><circle cx="20.125" cy="20.125" r="20.125"></circle><path class="ss-smiley-icon__path" d="M15.75 15.939a4.128 4.128 0 00-7 0m15.75 0a4.128 4.128 0 017 0M9.625 26.25a11.375 11.375 0 0021 0"></path></g></svg></div><div class="rating-element"><svg width="22" height="22" class="ss-smiley-icon ss-smiley-icon--5 undefined" viewBox="0 0 44 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 1)" class="ss-smiley-icon__g"><circle cx="21" cy="21" r="20.125"></circle><path class="ss-smiley-icon__path" d="M10.5 27.125a11.375 11.375 0 0021 0m-19-7l-4.688-4.89a2.775 2.775 0 01-.525-3.202 2.775 2.775 0 014.443-.72l.765.765.767-.764a2.774 2.774 0 014.441.719 2.774 2.774 0 01-.525 3.203L12.5 20.125zm17 0l4.688-4.891a2.776 2.776 0 00.525-3.203 2.775 2.775 0 00-4.443-.719l-.765.765-.767-.765a2.774 2.774 0 00-4.441.72 2.776 2.776 0 00.525 3.202l4.678 4.891z"></path></g></svg></div></div>
                                        <div class="rating-box star_icon"><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21.108 2.09a.955.955 0 011.787 0l4.832 13.7h13.646a.955.955 0 01.62 1.68l-11.402 9.454 4.773 14.337a.955.955 0 01-1.47 1.07L22 33.606l-11.9 8.727a.955.955 0 01-1.464-1.071l4.773-14.337L2.004 17.47a.955.955 0 01.62-1.68h13.649l4.835-13.7z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21.108 2.09a.955.955 0 011.787 0l4.832 13.7h13.646a.955.955 0 01.62 1.68l-11.402 9.454 4.773 14.337a.955.955 0 01-1.47 1.07L22 33.606l-11.9 8.727a.955.955 0 01-1.464-1.071l4.773-14.337L2.004 17.47a.955.955 0 01.62-1.68h13.649l4.835-13.7z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21.108 2.09a.955.955 0 011.787 0l4.832 13.7h13.646a.955.955 0 01.62 1.68l-11.402 9.454 4.773 14.337a.955.955 0 01-1.47 1.07L22 33.606l-11.9 8.727a.955.955 0 01-1.464-1.071l4.773-14.337L2.004 17.47a.955.955 0 01.62-1.68h13.649l4.835-13.7z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21.108 2.09a.955.955 0 011.787 0l4.832 13.7h13.646a.955.955 0 01.62 1.68l-11.402 9.454 4.773 14.337a.955.955 0 01-1.47 1.07L22 33.606l-11.9 8.727a.955.955 0 01-1.464-1.071l4.773-14.337L2.004 17.47a.955.955 0 01.62-1.68h13.649l4.835-13.7z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21.108 2.09a.955.955 0 011.787 0l4.832 13.7h13.646a.955.955 0 01.62 1.68l-11.402 9.454 4.773 14.337a.955.955 0 01-1.47 1.07L22 33.606l-11.9 8.727a.955.955 0 01-1.464-1.071l4.773-14.337L2.004 17.47a.955.955 0 01.62-1.68h13.649l4.835-13.7z"></path></svg></div></div>
                                        <div class="rating-box thumb_icon"><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 41"><path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2 14.255h3.5c.966 0 1.75.783 1.75 1.75v21a1.75 1.75 0 01-1.75 1.75H2v-24.5zm5.25 19.25c12.843 6.52 12.217 5.661 23.214 5.661 4.606 0 6.926-3.001 8.28-7.399v-.028l3.338-11.2v-.02a3.5 3.5 0 00-3.332-4.514h-8.575a3.5 3.5 0 01-3.384-4.393l1.543-5.852a2.998 2.998 0 00-5.355-2.481l-8.554 12.119a3.5 3.5 0 01-2.86 1.482H7.25v16.625z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 41"><path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2 14.255h3.5c.966 0 1.75.783 1.75 1.75v21a1.75 1.75 0 01-1.75 1.75H2v-24.5zm5.25 19.25c12.843 6.52 12.217 5.661 23.214 5.661 4.606 0 6.926-3.001 8.28-7.399v-.028l3.338-11.2v-.02a3.5 3.5 0 00-3.332-4.514h-8.575a3.5 3.5 0 01-3.384-4.393l1.543-5.852a2.998 2.998 0 00-5.355-2.481l-8.554 12.119a3.5 3.5 0 01-2.86 1.482H7.25v16.625z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 41"><path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2 14.255h3.5c.966 0 1.75.783 1.75 1.75v21a1.75 1.75 0 01-1.75 1.75H2v-24.5zm5.25 19.25c12.843 6.52 12.217 5.661 23.214 5.661 4.606 0 6.926-3.001 8.28-7.399v-.028l3.338-11.2v-.02a3.5 3.5 0 00-3.332-4.514h-8.575a3.5 3.5 0 01-3.384-4.393l1.543-5.852a2.998 2.998 0 00-5.355-2.481l-8.554 12.119a3.5 3.5 0 01-2.86 1.482H7.25v16.625z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 41"><path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2 14.255h3.5c.966 0 1.75.783 1.75 1.75v21a1.75 1.75 0 01-1.75 1.75H2v-24.5zm5.25 19.25c12.843 6.52 12.217 5.661 23.214 5.661 4.606 0 6.926-3.001 8.28-7.399v-.028l3.338-11.2v-.02a3.5 3.5 0 00-3.332-4.514h-8.575a3.5 3.5 0 01-3.384-4.393l1.543-5.852a2.998 2.998 0 00-5.355-2.481l-8.554 12.119a3.5 3.5 0 01-2.86 1.482H7.25v16.625z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 41"><path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2 14.255h3.5c.966 0 1.75.783 1.75 1.75v21a1.75 1.75 0 01-1.75 1.75H2v-24.5zm5.25 19.25c12.843 6.52 12.217 5.661 23.214 5.661 4.606 0 6.926-3.001 8.28-7.399v-.028l3.338-11.2v-.02a3.5 3.5 0 00-3.332-4.514h-8.575a3.5 3.5 0 01-3.384-4.393l1.543-5.852a2.998 2.998 0 00-5.355-2.481l-8.554 12.119a3.5 3.5 0 01-2.86 1.482H7.25v16.625z"></path></svg></div></div>
                                        <div class="rating-box crown_icon"><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 39"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 2)"><circle cx="3.5" cy="7.583" r="2.625"></circle><circle cx="38.5" cy="7.73" r="2.625"></circle><path d="M7 35h28M7 29.75L3.418 10.199S5.25 19.25 12.25 19.25C19.25 19.25 21 7 21 7s1.75 12.25 8.75 12.25 8.832-8.913 8.832-8.913L35 29.75H7z"></path><circle cx="21" cy="3.5" r="3.5"></circle></g></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 39"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 2)"><circle cx="3.5" cy="7.583" r="2.625"></circle><circle cx="38.5" cy="7.73" r="2.625"></circle><path d="M7 35h28M7 29.75L3.418 10.199S5.25 19.25 12.25 19.25C19.25 19.25 21 7 21 7s1.75 12.25 8.75 12.25 8.832-8.913 8.832-8.913L35 29.75H7z"></path><circle cx="21" cy="3.5" r="3.5"></circle></g></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 39"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 2)"><circle cx="3.5" cy="7.583" r="2.625"></circle><circle cx="38.5" cy="7.73" r="2.625"></circle><path d="M7 35h28M7 29.75L3.418 10.199S5.25 19.25 12.25 19.25C19.25 19.25 21 7 21 7s1.75 12.25 8.75 12.25 8.832-8.913 8.832-8.913L35 29.75H7z"></path><circle cx="21" cy="3.5" r="3.5"></circle></g></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 39"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 2)"><circle cx="3.5" cy="7.583" r="2.625"></circle><circle cx="38.5" cy="7.73" r="2.625"></circle><path d="M7 35h28M7 29.75L3.418 10.199S5.25 19.25 12.25 19.25C19.25 19.25 21 7 21 7s1.75 12.25 8.75 12.25 8.832-8.913 8.832-8.913L35 29.75H7z"></path><circle cx="21" cy="3.5" r="3.5"></circle></g></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 44 39"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 2)"><circle cx="3.5" cy="7.583" r="2.625"></circle><circle cx="38.5" cy="7.73" r="2.625"></circle><path d="M7 35h28M7 29.75L3.418 10.199S5.25 19.25 12.25 19.25C19.25 19.25 21 7 21 7s1.75 12.25 8.75 12.25 8.832-8.913 8.832-8.913L35 29.75H7z"></path><circle cx="21" cy="3.5" r="3.5"></circle></g></svg></div></div>
                                        <div class="rating-box user_icon"><div class="rating-element"><svg width="22" height="22" viewBox="0 0 39 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 1)"><circle cx="17.304" cy="12.261" r="11.375"></circle><path d="M35 41.136a18.624 18.624 0 00-35 0h35z"></path></g></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 39 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 1)"><circle cx="17.304" cy="12.261" r="11.375"></circle><path d="M35 41.136a18.624 18.624 0 00-35 0h35z"></path></g></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 39 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 1)"><circle cx="17.304" cy="12.261" r="11.375"></circle><path d="M35 41.136a18.624 18.624 0 00-35 0h35z"></path></g></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 39 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 1)"><circle cx="17.304" cy="12.261" r="11.375"></circle><path d="M35 41.136a18.624 18.624 0 00-35 0h35z"></path></g></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 39 44"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 1)"><circle cx="17.304" cy="12.261" r="11.375"></circle><path d="M35 41.136a18.624 18.624 0 00-35 0h35z"></path></g></svg></div></div>
                                        <div class="rating-box thunder_icon"><div class="rating-element"><svg width="22" height="22" viewBox="0 0 21 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2.4 41.6L8 22H2.856a1.4 1.4 0 01-1.346-1.784l4.799-16.8A1.4 1.4 0 017.656 2.4h10.472a1.4 1.4 0 011.2 2.12L12.2 16.4h5.662a1.4 1.4 0 011.12 2.22L2.4 41.6z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 21 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2.4 41.6L8 22H2.856a1.4 1.4 0 01-1.346-1.784l4.799-16.8A1.4 1.4 0 017.656 2.4h10.472a1.4 1.4 0 011.2 2.12L12.2 16.4h5.662a1.4 1.4 0 011.12 2.22L2.4 41.6z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 21 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2.4 41.6L8 22H2.856a1.4 1.4 0 01-1.346-1.784l4.799-16.8A1.4 1.4 0 017.656 2.4h10.472a1.4 1.4 0 011.2 2.12L12.2 16.4h5.662a1.4 1.4 0 011.12 2.22L2.4 41.6z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 21 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2.4 41.6L8 22H2.856a1.4 1.4 0 01-1.346-1.784l4.799-16.8A1.4 1.4 0 017.656 2.4h10.472a1.4 1.4 0 011.2 2.12L12.2 16.4h5.662a1.4 1.4 0 011.12 2.22L2.4 41.6z"></path></svg></div><div class="rating-element"><svg width="22" height="22" viewBox="0 0 21 44"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2.4 41.6L8 22H2.856a1.4 1.4 0 01-1.346-1.784l4.799-16.8A1.4 1.4 0 017.656 2.4h10.472a1.4 1.4 0 011.2 2.12L12.2 16.4h5.662a1.4 1.4 0 011.12 2.22L2.4 41.6z"></path></svg></div></div>
                                    </div>
                                    </div>

                                <div class="flex-column flex-column--full">
                                    <label class="ss-common-label ss-common-label--no-margin">Choose an icon</label>
                                    <div class="ss-rating-icons fx-row fx-align-center">
                                        <a class="ss-rating-icon star_icon" data-value='star_icon'>
                                            <svg width="18" height="18" class="ss-survey-text-color--secondary ss-rating-icon-fill" viewBox="0 0 44 44">
                                                <path fill="none" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill" d="M21.108 2.09a.955.955 0 011.787 0l4.832 13.7h13.646a.955.955 0 01.62 1.68l-11.402 9.454 4.773 14.337a.955.955 0 01-1.47 1.07L22 33.606l-11.9 8.727a.955.955 0 01-1.464-1.071l4.773-14.337L2.004 17.47a.955.955 0 01.62-1.68h13.649l4.835-13.7z"></path>
                                            </svg>
                                        </a>
                                        <a class="ss-rating-icon thumb_icon" data-value='thumb_icon'>
                                            <svg width="18" height="18" class="ss-survey-text-color--secondary ss-rating-icon-fill" viewBox="0 0 44 41">
                                                <path fill="none" fill-rule="evenodd" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill" d="M2 14.255h3.5c.966 0 1.75.783 1.75 1.75v21a1.75 1.75 0 01-1.75 1.75H2v-24.5zm5.25 19.25c12.843 6.52 12.217 5.661 23.214 5.661 4.606 0 6.926-3.001 8.28-7.399v-.028l3.338-11.2v-.02a3.5 3.5 0 00-3.332-4.514h-8.575a3.5 3.5 0 01-3.384-4.393l1.543-5.852a2.998 2.998 0 00-5.355-2.481l-8.554 12.119a3.5 3.5 0 01-2.86 1.482H7.25v16.625z"></path>
                                            </svg>
                                        </a>
                                        <a class="ss-rating-icon crown_icon" data-value='crown_icon'>
                                            <svg width="18" height="18" class="ss-survey-text-color--secondary ss-rating-icon-fill" viewBox="0 0 44 39">
                                                <g fill="none" fill-rule="evenodd" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 2)" class="ss-survey-text-color--secondary ss-rating-icon-fill">
                                                <circle cx="3.5" cy="7.583" r="2.625"></circle>
                                                <circle cx="38.5" cy="7.73" r="2.625"></circle>
                                                <path d="M7 35h28M7 29.75L3.418 10.199S5.25 19.25 12.25 19.25C19.25 19.25 21 7 21 7s1.75 12.25 8.75 12.25 8.832-8.913 8.832-8.913L35 29.75H7z"></path>
                                                <circle cx="21" cy="3.5" r="3.5"></circle>
                                                </g>
                                            </svg>
                                        </a>
                                        <a class="ss-rating-icon user_icon" data-value='user_icon'>
                                            <svg width="18" height="18" class="ss-survey-text-color--secondary ss-rating-icon-fill" viewBox="0 0 39 44">
                                                <g fill="none" fill-rule="evenodd" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(2 1)" class="ss-survey-text-color--secondary ss-rating-icon-fill">
                                                <circle cx="17.304" cy="12.261" r="11.375"></circle>
                                                <path d="M35 41.136a18.624 18.624 0 00-35 0h35z"></path>
                                                </g>
                                            </svg>
                                        </a>
                                        <a class="ss-rating-icon thunder_icon" data-value='thunder_icon'>
                                            <svg width="18" height="18" class="ss-survey-text-color--secondary ss-rating-icon-fill" viewBox="0 0 21 44">
                                                <path fill="none" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="ss-survey-text-color--secondary ss-rating-icon-fill" d="M2.4 41.6L8 22H2.856a1.4 1.4 0 01-1.346-1.784l4.799-16.8A1.4 1.4 0 017.656 2.4h10.472a1.4 1.4 0 011.2 2.12L12.2 16.4h5.662a1.4 1.4 0 011.12 2.22L2.4 41.6z"></path>
                                            </svg>
                                        </a>
                                        <a class="ss-rating-icon smiley_icon" data-value='smiley_icon'>
                                            <svg width="18" height="18" class="ss-smiley-icon ss-smiley-icon--3 ss-survey-text-color--secondary ss-rating-icon-fill" viewBox="0 0 44 44">
                                                <g fill="none" fill-rule="evenodd" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" transform="translate(1 1)" class="ss-smiley-icon__g">
                                                <circle cx="21" cy="21" r="20.125"></circle>
                                                <path class="ss-smiley-icon__path" d="M14.875 13.563a.437.437 0 110 .874.437.437 0 010-.874m12.25 0a.437.437 0 100 .874.437.437 0 000-.874m-17.5 13.562h22.75"></path>
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                    </div>
                                @endif
                                @if($currentQus->qus_type=='picturechoice')
                                <input type="hidden" id="choices_list_pic" name="choices_list_pic">                           
                                <div class="addchoice">
                                    <input type="button" id="add_choice_pic" onclick="addchoice_pic();" value="Add Choice" class="btn btn-primary">
                                </div>
                                <?php $exiting_choices=$qusvalue!=null ? json_decode($qusvalue->choices_list): []; ?>
                                <div id="picture_choices_section" class="row">
                                    @foreach($exiting_choices as $choice)
                                    <div class="img_placeholder">
                                        <img class="current_image" src="{{$choice->img}}">
                                        <div class="trigger_choice"  style="display:none;">
                                            <svg class="svgsection" width="40" height="40" viewBox="0 0 36 27"><path fill="#D7D7D7" d="M7.5 8.25a2.25 2.25 0 114.502.002A2.25 2.25 0 017.5 8.25zM21 9l-3.779 6-3.721-2.94-6 8.94h21L21 9zm12-6v21H3V3h30zm3-3H0v27h36V0z"></path></svg>
                                        </div>
                                        <input type="file" class="choice_image"   name="choice_image" style="visibility:hidden;"/>
                                        <div class="option-action">
                                            <textarea class="choice_desc"  maxlength="500" name="choice_desc" placeholder="Enter Choice" style="max-height: 44px; height: 25px;">{{$choice->text}}</textarea>
                                            <a class="deletepic_choice ss-button ss-button__icon-only mr--zero" role="button">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.90912 4H3.18185H13.3637" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"></path><path d="M5.09093 4.00004V2.66671C5.09093 2.31309 5.22502 1.97395 5.4637 1.7239C5.70239 1.47385 6.02611 1.33337 6.36366 1.33337H8.90913C9.24669 1.33337 9.57041 1.47385 9.80909 1.7239C10.0478 1.97395 10.1819 2.31309 10.1819 2.66671V4.00004M12.091 4.00004V13.3334C12.091 13.687 11.9569 14.0261 11.7182 14.2762C11.4795 14.5262 11.1558 14.6667 10.8182 14.6667H4.45456C4.11701 14.6667 3.79328 14.5262 3.5546 14.2762C3.31592 14.0261 3.18182 13.687 3.18182 13.3334V4.00004H12.091Z" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6.36368 7.33337V11.3334" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.90915 7.33337V11.3334" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                @if($currentQus->qus_type=='matrix_qus')
                                <input type="hidden" id="choices_list_matrix" name="choices_list_matrix[]">                           
                                <input type="hidden" id="question_list_matrix" name="question_list_matrix[]">                           

                                <div class="matrix_action">
                                <input type="button"  onclick="insert('coloumn')" value="Insert Column" class="btn matrixbtn">
                                <input type="button" onclick="insert('row')" value="Insert Row" class="btn   matrixbtn">
                                <input type="button" onclick="remove('coloumn')" value="Remove Column" class="btn   matrixbtn">
                                <input type="button" onclick="remove('row')" value="Remove Row" class="btn  matrixbtn">

                                </div>
                                <div id="matrix_table">
                                    <table id="matrix_sec">
                                    <?php $exiting_choices_matrix=$qusvalue!=null ? explode(",",$qusvalue->matrix_choice): [];
                                    $exiting_qus_matrix=$qusvalue!=null ? explode(",",$qusvalue->matrix_qus): []; $i=0;
                                     ?>
                                        <tbody>
                                            @if(count($exiting_qus_matrix)>0)
                                                <tr>
                                                    <td></td>
                                                    @foreach($exiting_choices_matrix as $ans)
                                                    <td><input type="text" placeholder="Enter Choice" class="matrix_head" value="{{$ans}}"  name="matrix_choice"></td>
                                                    @endforeach
                                                </tr>
                                            @endif
                                            <?php foreach($exiting_qus_matrix as $qus){
                                                ?>
                                                    <tr>
                                                        <td><input type="text" value="{{$qus}}" placeholder="Enter Question" class="matrix_head" name="matrix_qus"></td>
                                                        <td><input type="radio" name="matrix_anstype"></td>
                                                        <td><input type="radio" name="matrix_anstype"></td>
                                                    </tr>
                                               <?php  
                                                $i++;
                                            } ?>
                                            @if(count($exiting_qus_matrix)<=0)
                                            <tr>
                                                <td></td>
                                                <td><input type="text" placeholder="Enter Choice" class="matrix_head"  name="matrix_choice"></td>
                                                <td><input type="text" placeholder="Enter Choice" class="matrix_head"  name="matrix_choice"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="Enter Question" class="matrix_head" name="matrix_qus"></td>
                                                <td><input type="radio" name="matrix_anstype"></td>
                                                <td><input type="radio" name="matrix_anstype"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" placeholder="Enter Question" class="matrix_head" name="matrix_qus"></td>
                                                <td><input type="radio" name="matrix_anstype"></td>
                                                <td><input type="radio" name="matrix_anstype"></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                
                                @if($currentQus->qus_type=='single_choice' || $currentQus->qus_type=='multi_choice' || $currentQus->qus_type=='dropdown' || $currentQus->qus_type=='rankorder')
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

function addchoice_pic(){
    let wrapperID='';
    let containerID='';
    // newRowAdd ='<div class="col-md-3 picture_choice"><input type="file"  name="picture_choice" required class="course form-control"></div>';
    newRowAdd='<div class="img_placeholder"><img class="current_image" style="display:none;"><div class="trigger_choice"><svg class="svgsection" width="40" height="40" viewBox="0 0 36 27"><path fill="#D7D7D7" d="M7.5 8.25a2.25 2.25 0 114.502.002A2.25 2.25 0 017.5 8.25zM21 9l-3.779 6-3.721-2.94-6 8.94h21L21 9zm12-6v21H3V3h30zm3-3H0v27h36V0z"></path></svg></div><input type="file" class="choice_image"   name="choice_image" style="visibility:hidden;"/><div class="option-action"><textarea class="choice_desc" maxlength="500" name="choice_desc" placeholder="Enter Choice" style="max-height: 44px; height: 25px;"></textarea><a class="deletepic_choice ss-button ss-button__icon-only mr--zero" role="button"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.90912 4H3.18185H13.3637" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"></path><path d="M5.09093 4.00004V2.66671C5.09093 2.31309 5.22502 1.97395 5.4637 1.7239C5.70239 1.47385 6.02611 1.33337 6.36366 1.33337H8.90913C9.24669 1.33337 9.57041 1.47385 9.80909 1.7239C10.0478 1.97395 10.1819 2.31309 10.1819 2.66671V4.00004M12.091 4.00004V13.3334C12.091 13.687 11.9569 14.0261 11.7182 14.2762C11.4795 14.5262 11.1558 14.6667 10.8182 14.6667H4.45456C4.11701 14.6667 3.79328 14.5262 3.5546 14.2762C3.31592 14.0261 3.18182 13.687 3.18182 13.3334V4.00004H12.091Z" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6.36368 7.33337V11.3334" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.90915 7.33337V11.3334" stroke="#64748B" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></div></div>'
    $('#picture_choices_section').append(newRowAdd);
}
function addchoice(){
        newRowAdd ='<div id="row" class="col-md-3"><div class="input-group choicequs"><input type="text" name="choice" class="form-control m-input"><div class="input-group-prepend"><button class="btn btn-danger" id="DeleteRow" type="button">X</button> </div></div> </div>';
 
        $('#choices_section').append(newRowAdd);
}
$("body").on("click",".deletepic_choice",function(){
    $(this).parent().parent().remove();
});
$("body").on("click", "#DeleteRow", function () {
    $(this).parents("#row").remove();
});
$("body").on("click",".trigger_choice",function(){
    $(this).next(".choice_image").trigger('click');
});
$("body").on("change",".choice_image",function(e){
    console.log($(this));
    var id=$(this).parent();
    const files = e.target.files[0];
    console.log(id.children('img.current_image'),"id.children().find('img.current_image'")
    if (files) {
       uploadfile(files,id); 
    }
});
async function  uploadfile(file,id){
    const formdata = new FormData();
    formdata.append("image", file);
    const requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
    };
    let img='';

    await fetch("{{route('survey.uploadimage')}}", requestOptions)
    .then((response) => response.text())
    .then((result) => {
        let img="http://127.0.0.1:8000/uploads/survey/"+result;
        id.children('img.current_image').attr('src',img);
        id.children('img.current_image').css('display','block');
        id.children(".trigger_choice").css('display','none');
    })
    .catch((error) => console.error(error));
    return img;
}
function triggersubmit(qus_type){
    console.log(qus_type,"dd")
    if(qus_type=='picturechoice'){
        let choice_pic=[];
        $('.img_placeholder').each(function(){
            choice_pic.push({'img':$(this).children('.current_image').attr('src'),'text':$(this).children('.option-action').children('textarea.choice_desc').val()});
        });
        $('#choices_list_pic').val(JSON.stringify(choice_pic));
        if(choice_pic.length>0){
            $('#update_qus_final').click();
        }else{
            Swal.fire("Warning", 'Add Choices', "warning") ;
        }
    }
    else if(qus_type=='single_choice' || qus_type=='multi_choice' || qus_type=='dropdown' || qus_type=='rankorder'){
        let choices=[];
        $("input[name=choice]").each(function(idx, elem) {
            choices.push($(elem).val());
        });
        $('#choices_list').val(choices);
        console.log(choices,"choices");
        if(choices.length>0){
            $('#update_qus_final').click();
        }else{
            Swal.fire("Warning", 'Add Choices', "warning") ;
        }
    }else if(qus_type=='matrix_qus'){
        let choices=[];
        $("input[name=matrix_choice]").each(function(idx, elem) {
            choices.push($(elem).val());
        });
        let qus=[];
        $("input[name=matrix_qus]").each(function(idx, elem) {
            qus.push($(elem).val());
        });
        $('#choices_list_matrix').val(choices);
        $('#question_list_matrix').val(qus);
        if(qus.length>=1 && choices.length>=2){
            $('#update_qus_final').click();
        }else{
            Swal.fire("Warning", 'Add Choice & Question to proceed', "warning") ;
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

function sectactivequs(id,type,url){
    console.log(url)
    // console.log(id,type);
    // qustype(type)
    window.location.href=url;
}
function qustype(type){
    console.log(type,"type")
    let qusset={'welcome_page':'Welcome Page','single_choice':'Single Choice','multi_choice':'Multi Choice','open_qus':'Open Questions','likert':'Likert scale','rankorder':'Rank Order','rating':'Rating','dropdown':'Dropdown','picturechoice':'Picture Choice','email':'Email','matrix_qus':'Matrix Question','thank_you':'Thank You Page'};
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
$('.ss-rating-icon').click(function() {
    $('.ss-rating-icon').not(this).removeClass('active');
    $('.rating-box').css('display','none');
    $(this).addClass("active");
    $('.rating-box.'+$(this).data("value")).css('display','flex');
    $('#icon_type').val($(this).data("value"));
});
document.addEventListener("DOMContentLoaded", (event) => {
    let icon_type= $('#icon_type').val();
    $('.rating-box.'+icon_type).css('display','flex');
    $('.'+icon_type).addClass("active");
});
$('#left_label').change(function(){
    $('#left_lable_text').html($(this).val())
});
$('#middle_label').change(function(){
    $('#middle_lable_text').html($(this).val())
});
$('#right_label').change(function(){
    $('#right_lable_text').html($(this).val())
});
// Welcome Image
$('#trigger_welcome_image').click(function(){
    $('#welcome_image').click();
});
$('#welcome_image').change(function(){
    getImgData();
})
function getImgData() {
const chooseFile = document.getElementById("welcome_image");
const imgPreview = document.getElementById("imgPreview");
  const files = chooseFile.files[0];
  if (files) {
    const fileReader = new FileReader();
    fileReader.readAsDataURL(files);
    fileReader.addEventListener("load", function () {
      imgPreview.style.display = "block";
      imgPreview.innerHTML = '<img id="preview_image" src="' + this.result + '" />';
      $('#trigger_welcome_image').css('display','none');
      $('#ss_draft_remove_image_welcome').css('display','block');

    });    
  }
}
$('#ss_draft_remove_image_welcome').click(function(){
    $('#imgPreview').css('display','none');
    $('#existing_image').css('display','none');
    $('#trigger_welcome_image').css('display','inline-block');
    $('#ss_draft_remove_image_welcome').css('display','none');
});
// Welcome Image
// Thank you Image 
$('#trigger_thankyou_image').click(function(){
    $('#thankyou_image').click();
});
$('#thankyou_image').change(function(){
    getImgData();
})
function getImgData() {
const chooseFile = document.getElementById("thankyou_image");
const imgPreview = document.getElementById("imgPreview");
  const files = chooseFile.files[0];
  if (files) {
    const fileReader = new FileReader();
    fileReader.readAsDataURL(files);
    fileReader.addEventListener("load", function () {
      imgPreview.style.display = "block";
      imgPreview.innerHTML = '<img id="preview_image" src="' + this.result + '" />';
      $('#trigger_thankyou_image').css('display','none');
      $('#ss_draft_remove_image_thankyou').css('display','block');

    });    
  }
}
$('#ss_draft_remove_image_thankyou').click(function(){
    $('#existing_image_thankyou').css('display','none');
    $('#trigger_thankyou_image').css('display','inline-block');
    $('#ss_draft_remove_image_thankyou').css('display','none');
    $('#imgPreview').css('display','none');

});
// Thank you Image 
let table = document.querySelectorAll("#matrix_sec tbody");
const addColumn = () => {
    [...document.querySelectorAll('#matrix_sec tr')].forEach((row, i) => {
        const cell = document.createElement("td")
        const input = document.createElement("input")
        if(i==0){
            input.setAttribute("type", "text");
            input.setAttribute("name", "matrix_choice");
            input.setAttribute("placeholder", "Enter Choice");
            input.setAttribute("class", "matrix_head");
            cell.appendChild(input)
        }else{
            input.setAttribute("type", "radio");
            input.setAttribute("name", "matrix_anstype");
            cell.appendChild(input)
        }
        row.appendChild(cell)
    });
 }
 
function insert(type){
    if(type=='row'){
        let tr = document.createElement('tr');
        for (let i = 1; i <= $("#matrix_sec > tbody > tr:first > td").length; i++) {
            let cell = document.createElement('td');
            const input = document.createElement("input")
            if(i==1){
                input.setAttribute("type", "text");
                input.setAttribute("name", "matrix_qus");
                input.setAttribute("placeholder", "Enter Question");
                input.setAttribute("class", "matrix_head");
                cell.appendChild(input)
            }else{
                input.setAttribute("type", "radio");
                input.setAttribute("name", "matrix_anstype");
                cell.appendChild(input)
            }
            cell.appendChild(input);
            tr.appendChild(cell);
        }
        table[0].appendChild(tr);
    }else{
        addColumn();
    }

}
function remove(type){
    if(type=='row'){
        if($("#matrix_sec > tbody >tr").length<=2){
            Swal.fire("Warning", 'Minimum one row required', "warning") ;

        }else{
            $('#matrix_sec tr:last').remove();
        }
    }else{
        if($("#matrix_sec > tbody > tr:first > td").length<=3){
            Swal.fire("Warning", 'Minimum two choices required', "warning") ;

        }else{
            $("#matrix_sec td:last-child").remove();
        }
    }
}
</script>
    @yield('adminside-script')
@include('admin.layout.footer')
