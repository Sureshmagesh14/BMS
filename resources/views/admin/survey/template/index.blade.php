@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
<!-- ========== Left Sidebar Start ========== -->
<link href="{{ asset('assets/css/survey.css') }}" rel="stylesheet" type="text/css" />
<?php
    $link = $_SERVER['PHP_SELF'];
    $link_array = explode('/',$link);
    $page = end($link_array);
?>
<style>
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
    .foldermenu.ss-overflow-y--auto.ss-scrollbar--hide.h-100 {
        height: 82vh !important;
    }
</style>
<div class="vertical-menu  bg-grey-7">
    <!-- LOGO -->
    <div class="navbar-brand-box  bg-grey-7">
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('/assets/images/brand_surgen.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/images/brand_surgen.png') }}" alt="" height="18">
            </span>
        </a>
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('/assets/images/brand_surgen.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/images/brand_surgen.png') }}" alt="" height="18">
            </span>
        </a>
    </div>
    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn1">
    <a href="/admin/dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
    </a>
    </button>
    <div class="sidebar-menu-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu1">
            <div class="ss-dashboard--sidebar position--relative fx--fh fx-column pb-7 bg-grey-7">
                <div class="ss-dashboard--sidebar-container h-100 d-flex flex-column">
                    <div class="fx-row mb-5 fx-ai--center justify-content-between px-7 folderplus">
                        <h3 class="ss-text ss-text__size--h3 ss-text__weight--semibold ss-text__color--grey">Folders</h3>
                        <div class="fx-row create-workspace--button">
                        <span class="bp3-popover2-target" tabindex="0">
                        <a href="#" class="mx-3 btn btn-sm align-items-center createfoldericon" data-url="{{route('folder.create')}}" data-ajax-popup="true" data-bs-toggle="tooltip" title="Create Folder" data-title="Create Folder">
                                <svg width="12" height="12" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g opacity="1">
                                    <line x1="10" y1="1" x2="10" y2="19" stroke="#4A9CA6" stroke-width="2" stroke-linecap="round"></line>
                                    <line x1="19" y1="10.5" x2="1" y2="10.5" stroke="#4A9CA6" stroke-width="2" stroke-linecap="round"></line>
                                    </g>
                                </svg>
                            </a>
                        </span>
                        </div>
                    </div>
                    <div class="foldermenu ss-overflow-y--auto ss-scrollbar--hide h-100" style="padding-bottom: 100px;">
                       
                        @foreach($folders as $folder)
                            <div class="ss-dashboard--folder-item fx-row px-7 py-3 position--relative mb-3 @if($page==$folder->id) folder active @endif">
                                <div class="fx-grow-1 fx-row">
                                    <a href="{{$folder->id}}" class="waves-effect">
                                        <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--grey ss-text__line-height--medium">
                                            {{$folder->folder_name}} ({{$folder->surveycount_count}})
                                        </h3>
                                    </a>
                                </div>
                                <div tabindex="0" class="ss-button--dropdown actionfolder" aria-haspopup="true" aria-expanded="false" aria-controls="ss-drop-menu-106" role="menubar">
                                    <span class="ss-button ss-button__icon-only">
                                        <svg height="16" width="16" class="" fill="none" viewBox="0 0 18 4" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="2" cy="2" fill="#0D1B1E" r="2"></circle>
                                            <circle cx="9" cy="2" fill="#0D1B1E" r="2"></circle>
                                            <circle cx="16" cy="2" fill="#0D1B1E" r="2"></circle>
                                        </svg>
                                    </span>
                                    <ul class="ss-dropdown__main-list action_list" role="menu" id="ss-drop-menu-106" aria-label="Open Menu" style="margin-top: 8px;">
                                    <a href="#"  data-url="{{route('folder.edit',$folder->id)}}" data-ajax-popup="true" data-bs-toggle="tooltip" title="Edit Folder" data-title="Edit Folder">
                                        <li class="d-flex align-items-center py-3 my-2">
                                            <svg width="18" height="18" class="" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.728 6.68608L11.314 5.27208L2 14.5861V16.0001H3.414L12.728 6.68608ZM14.142 5.27208L15.556 3.85808L14.142 2.44408L12.728 3.85808L14.142 5.27208ZM4.242 18.0001H0V13.7571L13.435 0.322083C13.6225 0.134612 13.8768 0.0292969 14.142 0.0292969C14.4072 0.0292969 14.6615 0.134612 14.849 0.322083L17.678 3.15108C17.8655 3.33861 17.9708 3.59292 17.9708 3.85808C17.9708 4.12325 17.8655 4.37756 17.678 4.56508L4.243 18.0001H4.242Z" fill="#0D1B1E"></path>
                                            </svg>
                                            <h3 class="ss-text ss-text__size--h3 ss-text__color--black ms-4">Edit</h3>
                                        </li>
                                        </a>
                                        <?php $deleteLink =route('folder.delete',$folder->id); ?>
                                        <li class="d-flex align-items-center py-3 my-2" onclick="folderdelete('{{$deleteLink}}',{{$folder->id}})">
                                            <svg width="18" height="18" class="" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 2V0H15V2H20V4H18V19C18 19.2652 17.8946 19.5196 17.7071 19.7071C17.5196 19.8946 17.2652 20 17 20H3C2.73478 20 2.48043 19.8946 2.29289 19.7071C2.10536 19.5196 2 19.2652 2 19V4H0V2H5ZM4 4V18H16V4H4ZM7 7H9V15H7V7ZM11 7H13V15H11V7Z" fill="#F46685"></path>
                                            </svg>
                                            <h3 class="ss-text ss-text__size--h3 ss-text__color--red ms-4">Delete</h3>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<?php $selectedFolder = \App\Models\Folder::where(['id'=>$page])->first(); 
$getSurveys = App\Models\Survey::where(['folder_id'=>$page,'is_deleted'=>0])->get();?>
<div class="main-content1">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center   @if($selectedFolder) justify-content-between @else createfolderbtn @endif">
                        @if($selectedFolder)
                        <h4 class="mb-0">{{$selectedFolder->folder_name}}</h4>
                        @endif
                        <div class="page-title-right">
                            @if($selectedFolder)
                                <div class="ms-3 ps-3 border-left createsurveyBtn">
                                    <a href="#" class="ss-button ss-button__primary mb--sm" data-url="{{route('survey.create')}}" id="tracking-survey__new-survey" data-ajax-popup="true" data-bs-toggle="tooltip" title="Create Survey" data-title="Create Survey">
                                        <svg width="14" height="14" class="me-3" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="1">
                                                <line x1="10" y1="1" x2="10" y2="19" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"></line>
                                                <line x1="19" y1="10.5" x2="1" y2="10.5" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"></line>
                                            </g>
                                        </svg>New Survey
                                    </a>
                                </div>
                            @else
                                <div class="ms-3 ps-3 border-left createsurveyBtn">
                                    <a href="#" class="ss-button ss-button__primary mb--sm" data-url="{{route('folder.create')}}" id="tracking-survey__new-survey" data-ajax-popup="true" data-bs-toggle="tooltip" title="Create Folder" data-title="Create Folder">
                                        <svg width="14" height="14" class="me-3" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="1">
                                                <line x1="10" y1="1" x2="10" y2="19" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"></line>
                                                <line x1="19" y1="10.5" x2="1" y2="10.5" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"></line>
                                            </g>
                                        </svg>New Folder
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}" />
           
            <!-- end page title -->
           
            <div class="card card-body">

                
                @foreach($getSurveys as $survey)
                <div class="row no-gutters w-100 py-5 px-xl-3 ss-dashboard__list-item justify-content-between align-items-center background-color--white pointer--cursor surveyrow">
                    <div class="ss-dashboard__list-item--left col-12 col-xl-5 pe-0 pe-xl-5">
                        <div class="d-flex align-items-center flex-wrap flex-md-nowrap">
                            <div class="surveyIcon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <g stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" opacity="0.9">
                                    <path d="M19 15V7.828a2 2 0 00-.586-1.414l-2.828-2.828A2 2 0 0014.172 3H7a2 2 0 00-2 2v14a2 2 0 002 2h6m8-3l-3 3-2-2m-8-8h6m-6 3h6m-6 3h4.33"></path>
                                    <path d="M19 8h-4a1 1 0 01-1-1V3"></path>
                                </g>
                                </svg>
                            </div>
                            <div class="d-flex flex-column ss-dashboard__list-item--left-desc mt-3 mt-xl-0">
                                <h3 class="ss-text ss-text__size--h3 ss-text__weight--semibold ss-text__color--black mb--xs ss-text__overflow-wrap">{{$survey->title}}</h3>
                                <h4 class="ss-text ss-text__size--h4 ss-text__weight--normal ss-text__color--grey ss-text__line-height--large">Last Modified: 
                                    <span class="ss-dashboard-list-item__short-date">
                                        <?php $dt = \Carbon\Carbon::parse($survey->updated_at);
                                            echo $dt->diffForHumans();
                                           ?>
                                    </span></h4>
                            </div>
                        </div>
                    </div>
                    <div class="ss-dashboard__list-item--right col-12 col-xl-7 py-md-3">
                        <div class="row no-gutters">
                            <div class="col-7">
                                <div class="row no-gutters align-items-center h-100">
                                <div class="col-6 d-none d-md-flex flex-column align-items-center justify-content-center">
                                    <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--black ss-dashboard__list-item-property-value">{{$survey->questions->count()}}</h3>
                                    <a class="ss-button__link ss-button__link--underline color-grey-2 ss-dashboard-list-item__property-info">Questions</a>
                                </div>
                                <?php 
                                $query="SELECT * FROM `survey_response` WHERE (`survey_id` = $survey->id) GROUP BY `response_user_id`, `survey_id`";
                                $responsCount =  DB::select($query);
                                 ?>
                                <div class="col-6 d-none d-md-flex flex-column align-items-center justify-content-center">
                                    <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--black ss-dashboard__list-item-property-value">{{count($responsCount)}}</h3>
                                    <a class="ss-button__link ss-button__link--underline color-grey-2 ss-dashboard-list-item__property-info">Responses</a>
                                </div>
                                <!-- <div class="col-4 d-none d-md-flex flex-column align-items-center justify-content-center">
                                    <div>
                                        <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--black">--</h3>
                                    </div>
                                    <a class="ss-button__link ss-button__link--underline color-grey-2 ss-dashboard-list-item__property-info">Completion Rate</a>
                                </div> -->
                                </div>
                            </div>
                            <?php $qus_id=0; ?>
                            <div class="col-5">
                                <div class="row no-gutters">
                                    <div class="col-12 ss-dashboard__list-item-nav d-flex align-items-center justify-content-end flex-shrink-0">
                                        <div class="d-none d-md-flex align-items-center ss-dashboard-list-item__secondary-actions">
                                            <div class="rounded-md me-3">
                                                <a class="ss-button__link bg-grey-6 p-4 rounded-md" spiketip-title="Edit Survey" spiketip-pos="top" href="{{route('survey.builder',[$survey->builderID,0])}}">
                                                    <svg width="16" height="16" class="" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12.728 6.68608L11.314 5.27208L2 14.5861V16.0001H3.414L12.728 6.68608ZM14.142 5.27208L15.556 3.85808L14.142 2.44408L12.728 3.85808L14.142 5.27208ZM4.242 18.0001H0V13.7571L13.435 0.322083C13.6225 0.134612 13.8768 0.0292969 14.142 0.0292969C14.4072 0.0292969 14.6615 0.134612 14.849 0.322083L17.678 3.15108C17.8655 3.33861 17.9708 3.59292 17.9708 3.85808C17.9708 4.12325 17.8655 4.37756 17.678 4.56508L4.243 18.0001H4.242Z" fill="#0D1B1E"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="rounded-md me-3">
                                                <a class="ss-button__link bg-grey-6 p-3 rounded-md" role="button" spiketip-title="Share Survey" spiketip-pos="top"  data-url="{{route('survey.sharesurvey',$survey->id)}}" data-ajax-popup="true" data-bs-toggle="tooltip"
                                                        title="Share Survey" data-title="Share Survey">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" class="">
                                                        <g stroke="#0D1B1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" clip-path="url(#clip0_1106_12949)" opacity="0.9">
                                                        <path d="M8.553 10.114a2.667 2.667 0 11-3.772 3.772 2.667 2.667 0 013.772-3.772M19.219 4.781a2.667 2.667 0 11-3.772 3.772 2.667 2.667 0 013.772-3.772M19.219 15.447a2.667 2.667 0 11-3.772 3.772 2.667 2.667 0 013.772-3.772M9.04 10.81l5.92-2.96M9.04 13.19l5.92 2.96"></path>
                                                        </g>
                                                        <defs>
                                                        <clipPath id="clip0_1106_12949">
                                                            <path fill="#fff" d="M0 0H24V24H0z"></path>
                                                        </clipPath>
                                                        </defs>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Actions -->
                                        <div tabindex="0" class="ss-button--dropdown actionsurvey" aria-haspopup="true" aria-expanded="false"
                                            aria-controls="ss-drop-menu-106" role="menubar">
                                            <span class="ss-button ss-button__icon-only">
                                                <svg height="16" width="16" class="" fill="none" viewBox="0 0 18 4" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="2" cy="2" fill="#0D1B1E" r="2"></circle>
                                                    <circle cx="9" cy="2" fill="#0D1B1E" r="2"></circle>
                                                    <circle cx="16" cy="2" fill="#0D1B1E" r="2"></circle>
                                                </svg>
                                            </span>
                                            <ul class="ss-dropdown__main-list action_list action_list_survey" role="menu" id="ss-drop-menu-106" aria-label="Open Menu"
                                                style="margin-top: 8px;">
                                                <a href="{{route('survey.builder',[$survey->builderID,0])}}">
                                                    <li class="d-flex align-items-center py-3 my-2">
                                                        <h3 class="ss-text ss-text__size--h3 ss-text__color--black ms-4">Edit Survey</h3>
                                                    </li>
                                                </a>
                                                <a href="#" data-html="true" data-url="{{route('survey.sharesurvey',$survey->id)}}" data-ajax-popup="true"
                                                    data-bs-toggle="tooltip" title="Share Survey" data-title="Share Survey">
                                                    <li class="d-flex align-items-center py-3 my-2">
                                                        <h3 class="ss-text ss-text__size--h3 ss-text__color--black ms-4">Share Survey</h3>
                                                    </li>
                                                </a>
                                                <a data-html="true" href="#" data-url="{{route('survey.movesurvey',$survey->id)}}" data-ajax-popup="true"
                                                    data-bs-toggle="tooltip" title="Move Survey" data-title="Move Survey">
                                                    <li class="d-flex align-items-center py-3 my-2">
                                                        <h3 class="ss-text ss-text__size--h3 ss-text__color--black ms-4">Move to</h3>
                                                    </li>
                                                </a>
                                                <a href="{{route('survey.surveyduplication',$survey->id)}}">
                                                    <li class="d-flex align-items-center py-3 my-2">
                                                        <h3 class="ss-text ss-text__size--h3 ss-text__color--black ms-4">Duplicate</h3>
                                                    </li>
                                                </a>

                                                <a href="{{route('survey.delete',$survey->id)}}" data-html="true" class="deletesurvey">
                                                    <li class="d-flex align-items-center py-3 my-2">
                                                        <h3 class="ss-text ss-text__size--h3 ss-text__color--red ms-4">Close</h3>
                                                    </li>
                                                </a>
                                            </ul>
                                        </div>
                                        <!-- Actions -->
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if($selectedFolder)
                    @if(count($getSurveys)<=0)
                    <div class="ss-dashboard--contents px-5 px-xl-11 pb-7"><div class="ss-dashboard--inner-container px-5 px-xl-6 py-5 py-xl-7 h-100 bg-white"><div class="ss-dashboard--contents ss-no-survey--container px-11 fx-column fx-ai--center fx-jc--center"><div class="ss-no-survey--wrapper d-flex flex-column align-items-center justify-content-center px-7 w-100 h-100"><svg width="126" height="147" viewBox="0 0 126 147" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-6"><path d="M114.306 12.9721C114.306 12.9721 114.306 12.9721 114.001 12.3962C113.696 11.8203 112.995 12.4871 112.995 12.4871C112.995 12.4871 113.117 12.1234 112.812 11.5476C112.507 10.9717 112.141 12.5478 112.141 12.5478C112.141 12.5478 112.233 11.8507 111.44 10.608C110.648 9.36529 110.617 13.3358 110.617 13.3358C110.617 13.3358 110.709 17.5185 114.306 12.9721Z" fill="#19AF99"></path><path d="M110.648 13.3359C110.648 12.6994 110.678 12.0932 110.77 11.4567C110.8 11.1536 110.831 10.7292 111.044 10.4868C111.105 10.3958 111.166 10.3958 111.227 10.4565C111.288 10.5171 111.318 10.5777 111.379 10.6383C111.501 10.8202 111.623 11.0323 111.715 11.2445C111.898 11.6082 112.111 12.0932 112.05 12.5175C112.05 12.6084 112.172 12.6084 112.172 12.5478C112.233 12.2447 112.324 11.9113 112.477 11.6385C112.507 11.6082 112.568 11.487 112.599 11.487C112.69 11.487 112.782 11.7598 112.812 11.8204C112.873 12.0022 112.965 12.275 112.904 12.4872C112.873 12.5478 112.965 12.6084 113.025 12.5478C113.208 12.3659 113.605 12.0932 113.849 12.3053C114.001 12.4569 114.092 12.7297 114.214 12.9115C114.245 12.9418 114.245 12.9721 114.275 13.0024C114.306 13.0934 114.428 13.0024 114.397 12.9418C114.367 12.8812 114.336 12.8206 114.306 12.76C114.184 12.5478 114.092 12.2447 113.849 12.1235C113.544 12.0022 113.178 12.2447 112.965 12.4569C112.995 12.4872 113.056 12.4872 113.086 12.5175C113.147 12.275 112.965 11.0929 112.568 11.4263C112.385 11.5476 112.324 11.8204 112.233 12.0325C112.172 12.2144 112.111 12.3659 112.08 12.5478C112.111 12.5478 112.172 12.5478 112.202 12.5781C112.233 12.2144 112.08 11.7901 111.928 11.4567C111.776 11.1233 111.623 10.7595 111.379 10.4868C111.318 10.3958 111.196 10.3352 111.074 10.3352C110.8 10.3958 110.739 10.8808 110.709 11.0929C110.617 11.5476 110.587 12.0022 110.556 12.4872C110.526 12.7903 110.526 13.0934 110.526 13.3965C110.495 13.4268 110.648 13.4268 110.648 13.3359Z" fill="black"></path><path d="M111.135 69.0747L63 55.678L16.2668 68.8626L62.2379 82.0774L111.135 69.0747Z" fill="#364250"></path><path d="M63 131.755V91.2916" stroke="black" stroke-miterlimit="10"></path><path d="M63 135.452V141.029" stroke="black" stroke-miterlimit="10"></path><path d="M109.215 89.0486V133.058L62.9999 146L15.2607 133.513L16.0229 100.354" stroke="black" stroke-miterlimit="10"></path><path d="M16.2668 89.0486V95.1712" stroke="black" stroke-miterlimit="10"></path><path d="M73.0294 120.328C74.5952 120.328 75.8645 118.808 75.8645 116.933C75.8645 115.059 74.5952 113.539 73.0294 113.539C71.4637 113.539 70.1943 115.059 70.1943 116.933C70.1943 118.808 71.4637 120.328 73.0294 120.328Z" fill="black"></path><path d="M99.5817 112.023C101.147 112.023 102.417 110.503 102.417 108.628C102.417 106.754 101.147 105.234 99.5817 105.234C98.0159 105.234 96.7466 106.754 96.7466 108.628C96.7466 110.503 98.0159 112.023 99.5817 112.023Z" fill="black"></path><path d="M81.9617 124.45C81.9617 124.45 82.6628 116.903 88.4854 116.903C92.5703 116.903 92.5703 122.177 92.5703 122.177" stroke="black" stroke-miterlimit="10"></path><path d="M93.6982 73.5908L97.3259 72.6209" stroke="black" stroke-miterlimit="10"></path><path d="M101.289 71.7116L111.135 69.0747L63 55.678L16.2668 68.8626L62.2379 82.0774L89.3998 74.7426" stroke="black" stroke-miterlimit="10"></path><path d="M65.6523 84.1386L77.267 92.1099L122.506 78.8647L112.629 70.5903" stroke="black" stroke-miterlimit="10"></path><path d="M80.803 47.2218L124 58.5272L112.629 66.832" stroke="black" stroke-miterlimit="10"></path><path d="M60.3173 53.9808L48.977 44.9789L39.5876 47.2218" stroke="black" stroke-miterlimit="10"></path><path d="M31.2044 49.4645L2.45728 57.0419L14.1329 67.5896" stroke="black" stroke-miterlimit="10"></path><path d="M33.4297 49.4647L37.6061 48.7372" stroke="black" stroke-miterlimit="10"></path><path d="M14.1329 70.5903L2 80.3802L48.977 92.4433L60.3173 83.6536" stroke="black" stroke-miterlimit="10"></path><path d="M58.0919 55.769C58.0919 54.9507 58.1529 54.1323 58.2443 53.314C58.7321 48.5251 60.5002 43.8574 64.89 41.0387C75.4987 34.2494 81.4432 44.5849 75.2853 48.1917C65.6521 53.8595 54.2813 36.5226 50.4707 29.7333" stroke="black" stroke-miterlimit="10" stroke-dasharray="6 6"></path><path d="M60.3172 69.681C59.9514 68.6504 58.1528 62.8916 58.0918 56.5873" stroke="white" stroke-miterlimit="10" stroke-dasharray="6 6"></path><path d="M47.3003 24.6412C48.1538 24.429 49.0684 24.3381 49.9524 24.3078C51.3547 24.2775 53.1229 24.3987 54.0679 25.5808C54.769 26.4901 54.7385 27.6721 53.7021 28.248C52.6961 28.8239 51.3547 28.7633 50.3183 28.3692C48.6416 27.7327 47.6661 26.2173 47.4222 24.4896C47.3917 24.3381 47.1783 24.3987 47.2088 24.5503C47.4527 26.187 48.3063 27.6418 49.8305 28.3995C50.9584 28.9451 52.3607 29.0967 53.5192 28.6117C54.5252 28.1874 55.0739 27.2478 54.6776 26.187C54.0984 24.6715 52.4217 24.1865 50.9584 24.0956C49.739 24.035 48.4587 24.1562 47.2698 24.429C47.0869 24.4593 47.1478 24.6715 47.3003 24.6412Z" fill="#0D1B1E"></path><path d="M47.1478 24.5502C47.4527 25.2473 47.6966 26.0051 47.91 26.7325C48.2758 28.0661 48.6111 29.4906 48.4282 30.8849C48.3368 31.4911 48.1538 32.0973 47.6966 32.5216C47.2088 33.0065 46.4162 33.1884 45.7456 33.1278C44.2213 32.9762 43.825 31.4001 43.9774 30.0968C44.2213 27.9146 45.6541 25.9141 47.3612 24.5805C47.4832 24.4896 47.3003 24.338 47.2088 24.429C45.5626 25.702 44.2518 27.5205 43.8555 29.5513C43.6116 30.8243 43.6726 32.5519 45.0444 33.1581C46.2943 33.7036 47.849 33.1278 48.3977 31.9154C48.9769 30.5818 48.7026 28.9754 48.3977 27.6115C48.1538 26.5506 47.8185 25.4898 47.3917 24.4593C47.3308 24.3684 47.1174 24.429 47.1478 24.5502Z" fill="#0D1B1E"></path><path d="M46.8126 25.7323C47.7891 25.7323 48.5807 24.9453 48.5807 23.9744C48.5807 23.0035 47.7891 22.2165 46.8126 22.2165C45.8361 22.2165 45.0444 23.0035 45.0444 23.9744C45.0444 24.9453 45.8361 25.7323 46.8126 25.7323Z" fill="#0D1B1E"></path><path d="M94.0641 35.977C103.779 35.977 111.654 28.1472 111.654 18.4885C111.654 8.82988 103.779 1 94.0641 1C84.3495 1 76.4744 8.82988 76.4744 18.4885C76.4744 28.1472 84.3495 35.977 94.0641 35.977Z" fill="white"></path><path d="M111.196 22.0044C113.483 22.0044 115.312 20.1858 115.312 17.9126C115.312 15.6394 113.33 13.8209 111.044 13.8209C111.044 13.8209 111.745 15.9728 111.654 18.0642C111.562 20.1555 111.196 22.0044 111.196 22.0044Z" fill="white"></path><path d="M94.0641 35.977C103.779 35.977 111.654 28.1472 111.654 18.4885C111.654 8.82988 103.779 1 94.0641 1C84.3495 1 76.4744 8.82988 76.4744 18.4885C76.4744 28.1472 84.3495 35.977 94.0641 35.977Z" stroke="black" stroke-miterlimit="10"></path><path d="M84.2174 32.1278C84.5541 32.1278 84.827 31.8564 84.827 31.5217C84.827 31.1869 84.5541 30.9155 84.2174 30.9155C83.8806 30.9155 83.6077 31.1869 83.6077 31.5217C83.6077 31.8564 83.8806 32.1278 84.2174 32.1278Z" fill="black"></path><path d="M88.7291 31.3094C89.0658 31.3094 89.3388 31.038 89.3388 30.7032C89.3388 30.3684 89.0658 30.097 88.7291 30.097C88.3924 30.097 88.1194 30.3684 88.1194 30.7032C88.1194 31.038 88.3924 31.3094 88.7291 31.3094Z" fill="black"></path><path d="M85.6196 32.1883C85.6196 32.1883 84.9794 36.2195 86.4122 35.4618C87.8755 34.704 88.3327 33.2188 88.3327 33.2188C88.3327 33.2188 87.1743 31.3396 85.6196 32.1883Z" fill="#E6823A"></path><path d="M114.855 16.0941C114.855 16.0941 116.989 16.7002 117.294 17.3064C117.598 17.9126 115.312 17.7611 115.312 17.7611" stroke="black" stroke-miterlimit="10"></path><path d="M85.5282 32.1581C85.4063 32.9764 85.3148 33.8251 85.4063 34.6131C85.4368 34.9768 85.5282 35.5224 85.955 35.6437C86.1684 35.7043 86.3818 35.6133 86.5647 35.5224C86.961 35.3102 87.3268 35.0072 87.6317 34.6738C87.9975 34.2797 88.3024 33.7645 88.4853 33.2492C88.5158 33.0977 88.3024 33.0371 88.2719 33.1886C88.15 33.5523 87.9366 33.916 87.6927 34.2494C87.4488 34.5828 87.1439 34.8859 86.8391 35.0981C86.6562 35.2193 86.3513 35.4618 86.1074 35.4315C85.7721 35.4012 85.7112 34.8556 85.6807 34.5828C85.6197 34.0979 85.6502 33.5826 85.6807 33.0977C85.7112 32.7946 85.7416 32.4915 85.7721 32.1884C85.7721 32.0671 85.5587 32.0065 85.5282 32.1581Z" fill="black"></path><path d="M80.6811 11.1538C80.6811 11.1538 81.4433 7.51666 79.8276 7.21356C79.3093 7.21356 80.4373 10.396 79.9495 12.0024" fill="white"></path><path d="M80.8031 11.1841C80.8945 10.7901 80.925 10.3961 80.9555 10.0021C81.0165 9.33527 81.0165 8.57752 80.7726 7.94102C80.6811 7.66824 80.4982 7.42578 80.2544 7.27424C80.1019 7.18331 79.8276 7.03175 79.6752 7.18329C79.5532 7.33484 79.5837 7.60762 79.5837 7.78948C79.6142 8.15319 79.6752 8.54721 79.7361 8.91092C79.8886 9.88082 80.1019 11.0023 79.8276 11.9722C79.7971 12.1237 80.0105 12.1843 80.041 12.0328C80.2544 11.275 80.1629 10.4567 80.0715 9.66866C79.98 8.97154 79.7971 8.27444 79.7971 7.57733C79.7971 7.51671 79.7666 7.36515 79.8276 7.33484C79.8581 7.30453 79.98 7.36515 80.041 7.39546C80.2849 7.5167 80.4373 7.75917 80.5287 8.00165C80.7726 8.57752 80.7726 9.24433 80.7116 9.88083C80.6811 10.3052 80.6507 10.7295 80.5592 11.1235C80.5592 11.275 80.7726 11.3357 80.8031 11.1841Z" fill="#111110"></path><path d="M79.7666 12.8208C79.7666 12.8208 78.852 9.21396 77.2668 9.6686C76.8095 9.88077 79.2178 12.2752 79.4922 13.9119" fill="white"></path><path d="M79.8886 12.7905C79.7971 12.3965 79.6447 12.0025 79.4923 11.6388C79.2484 11.0326 78.9131 10.3658 78.4253 9.91114C78.2119 9.72928 77.968 9.54743 77.6632 9.51712C77.4803 9.48681 77.145 9.48682 77.1145 9.72929C77.084 9.94146 77.2669 10.1536 77.3583 10.3355C77.5717 10.6689 77.7851 10.972 77.9985 11.3054C78.5473 12.0934 79.2179 12.9724 79.3703 13.9726C79.4008 14.1242 79.6142 14.0635 79.5837 13.912C79.4618 13.1239 79.0045 12.4268 78.5777 11.76C78.1814 11.1841 77.7242 10.6386 77.4193 10.0021C77.3888 9.94147 77.3279 9.88084 77.3583 9.78991C77.3583 9.7596 77.3583 9.7596 77.3583 9.78991C77.3888 9.7596 77.5413 9.75959 77.5717 9.75959C77.8461 9.75959 78.09 9.91114 78.3034 10.0627C78.7607 10.487 79.0655 11.0932 79.3094 11.6691C79.4618 12.0631 79.6142 12.4571 79.7057 12.8512C79.7057 13.0027 79.9191 12.9421 79.8886 12.7905Z" fill="#111110"></path><path d="M79.6448 13.7301C79.6448 13.7301 78.8827 8.75933 76.9317 7.15294C76.1391 6.42551 80.6508 5.78901 79.9192 12.7905" fill="white"></path><path d="M79.7668 13.6998C79.6448 12.8511 79.4314 12.0024 79.1875 11.1841C78.7912 9.85048 78.3035 8.42594 77.3585 7.36511C77.2365 7.24387 77.0536 7.12264 76.9927 6.97109C76.9927 6.94078 76.9927 6.94078 76.9927 6.91047C77.0841 6.81954 77.2975 6.78924 77.4499 6.81955C78.1511 6.84986 78.7303 7.36511 79.0961 7.91068C80.0106 9.30491 79.9801 11.1841 79.7972 12.7602C79.7972 12.9117 80.0106 12.9117 80.0411 12.7602C80.1936 11.2144 80.224 9.45646 79.4314 8.03192C79.0656 7.36512 78.4559 6.75892 77.6938 6.60738C77.4195 6.54676 76.6573 6.54675 76.7488 7.0014C76.7793 7.09232 76.8402 7.15295 76.9012 7.21356C77.1756 7.48635 77.4194 7.72883 77.6328 8.03192C78.0901 8.72904 78.4254 9.48676 78.6998 10.2748C79.0961 11.3963 79.401 12.548 79.5839 13.6998C79.5534 13.9119 79.7972 13.8513 79.7668 13.6998Z" fill="#111110"></path><path d="M111.044 13.8209C113.33 13.8209 115.312 15.6394 115.312 17.9126C115.312 20.1858 113.483 22.0044 111.196 22.0044" stroke="black" stroke-miterlimit="10"></path><path d="M116.653 15.5487C116.653 15.5487 116.653 15.5487 116.684 14.791C116.714 14.0333 115.617 14.306 115.617 14.306C115.617 14.306 115.952 14.0029 115.983 13.2755C116.013 12.5481 114.733 13.8514 114.733 13.8514C114.733 13.8514 115.22 13.2149 115.19 11.5479C115.159 9.88086 112.751 13.7302 112.751 13.7302C112.751 13.7302 111.928 15.2153 112.568 15.9124C113.026 16.3671 114.123 16.4883 116.653 15.5487Z" fill="#19AF99"></path><path d="M112.843 13.7603C113.239 13.1238 113.635 12.5176 114.092 11.972C114.245 11.7902 114.367 11.6386 114.55 11.4871C114.641 11.3962 114.794 11.2446 114.946 11.2143C115.068 11.184 115.098 11.2749 115.129 11.3659C115.22 11.7296 115.159 12.1539 115.098 12.5479C115.038 12.9722 114.977 13.4875 114.702 13.8512C114.641 13.9118 114.763 14.0028 114.824 13.9422C115.098 13.6694 115.373 13.3663 115.739 13.2147C115.8 13.1844 115.891 13.1238 115.952 13.1844C115.983 13.2147 115.983 13.2753 115.983 13.3056C115.983 13.4572 115.952 13.5784 115.922 13.73C115.861 13.9422 115.8 14.1543 115.647 14.3059C115.586 14.3665 115.647 14.4271 115.708 14.4271C115.983 14.3665 116.44 14.3059 116.623 14.5786C116.714 14.6999 116.684 14.8514 116.684 14.9727C116.684 15.1242 116.684 15.2758 116.653 15.4273C116.653 15.4879 116.653 15.5486 116.653 15.6092C116.653 15.7001 116.775 15.7001 116.806 15.6092C116.806 15.5182 116.806 15.397 116.806 15.3061C116.806 15.0333 116.897 14.6696 116.684 14.4574C116.44 14.2149 115.983 14.2452 115.678 14.3059C115.708 14.3362 115.708 14.3968 115.739 14.4271C115.952 14.2452 116.044 13.9422 116.074 13.6694C116.104 13.4875 116.196 13.0329 115.891 13.0329C115.647 13.0329 115.373 13.2753 115.22 13.4269C115.068 13.5481 114.916 13.6997 114.763 13.8512C114.794 13.8815 114.824 13.9118 114.885 13.9422C115.129 13.6088 115.22 13.1541 115.281 12.7601C115.342 12.3358 115.403 11.8811 115.342 11.4568C115.312 11.3355 115.281 11.184 115.159 11.1234C114.885 11.0021 114.519 11.4265 114.367 11.578C114.001 11.972 113.696 12.3964 113.391 12.851C113.178 13.1541 112.995 13.4572 112.812 13.7603C112.66 13.7603 112.782 13.8209 112.843 13.7603Z" fill="black"></path></svg>
                        @if($selectedFolder)
                        <h1 class="ss-text ss-text__size--jumbo ss-text__weight--semibold ss-text__color--black mb--xs">{{$selectedFolder->folder_name}}</h1>
                        @endif
                        <h4 class="ss-text ss-text__size--h4 ss-text__weight--normal ss-text__color--grey">No surveys or good souls here yet!</h4><div class="row pt-9"><div class="ss-dashboard__no-survey col-12 d-flex flex-column align-items-center justify-content-center"><div class="position--relative">
                        <a href="#" class="ss-button ss-button__primary mb--sm" data-url="{{route('survey.create')}}" id="tracking-survey__new-survey" data-ajax-popup="true" data-bs-toggle="tooltip" title="Create Survey" data-title="Create Survey">
                    Add a New Survey</a>
                    </div></div></div></div></div></div></div>
                    @endif
                @else 
                <div class="ss-dashboard--contents px-5 px-xl-11 pb-7">
                    <div class="ss-dashboard--inner-container px-5 px-xl-6 py-5 py-xl-7 h-100 bg-white">
                        <div class="ss-dashboard--contents ss-no-survey--container px-11 fx-column fx-ai--center fx-jc--center">
                            <div class="ss-no-survey--wrapper d-flex flex-column align-items-center justify-content-center px-7 w-100 h-100">
                                <svg width="126" height="147" viewBox="0 0 126 147" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-6">
                                    <path d="M114.306 12.9721C114.306 12.9721 114.306 12.9721 114.001 12.3962C113.696 11.8203 112.995 12.4871 112.995 12.4871C112.995 12.4871 113.117 12.1234 112.812 11.5476C112.507 10.9717 112.141 12.5478 112.141 12.5478C112.141 12.5478 112.233 11.8507 111.44 10.608C110.648 9.36529 110.617 13.3358 110.617 13.3358C110.617 13.3358 110.709 17.5185 114.306 12.9721Z" fill="#19AF99">
                                    </path>
                                    <path d="M110.648 13.3359C110.648 12.6994 110.678 12.0932 110.77 11.4567C110.8 11.1536 110.831 10.7292 111.044 10.4868C111.105 10.3958 111.166 10.3958 111.227 10.4565C111.288 10.5171 111.318 10.5777 111.379 10.6383C111.501 10.8202 111.623 11.0323 111.715 11.2445C111.898 11.6082 112.111 12.0932 112.05 12.5175C112.05 12.6084 112.172 12.6084 112.172 12.5478C112.233 12.2447 112.324 11.9113 112.477 11.6385C112.507 11.6082 112.568 11.487 112.599 11.487C112.69 11.487 112.782 11.7598 112.812 11.8204C112.873 12.0022 112.965 12.275 112.904 12.4872C112.873 12.5478 112.965 12.6084 113.025 12.5478C113.208 12.3659 113.605 12.0932 113.849 12.3053C114.001 12.4569 114.092 12.7297 114.214 12.9115C114.245 12.9418 114.245 12.9721 114.275 13.0024C114.306 13.0934 114.428 13.0024 114.397 12.9418C114.367 12.8812 114.336 12.8206 114.306 12.76C114.184 12.5478 114.092 12.2447 113.849 12.1235C113.544 12.0022 113.178 12.2447 112.965 12.4569C112.995 12.4872 113.056 12.4872 113.086 12.5175C113.147 12.275 112.965 11.0929 112.568 11.4263C112.385 11.5476 112.324 11.8204 112.233 12.0325C112.172 12.2144 112.111 12.3659 112.08 12.5478C112.111 12.5478 112.172 12.5478 112.202 12.5781C112.233 12.2144 112.08 11.7901 111.928 11.4567C111.776 11.1233 111.623 10.7595 111.379 10.4868C111.318 10.3958 111.196 10.3352 111.074 10.3352C110.8 10.3958 110.739 10.8808 110.709 11.0929C110.617 11.5476 110.587 12.0022 110.556 12.4872C110.526 12.7903 110.526 13.0934 110.526 13.3965C110.495 13.4268 110.648 13.4268 110.648 13.3359Z" fill="black"></path><path d="M111.135 69.0747L63 55.678L16.2668 68.8626L62.2379 82.0774L111.135 69.0747Z" fill="#364250"></path><path d="M63 131.755V91.2916" stroke="black" stroke-miterlimit="10"></path><path d="M63 135.452V141.029" stroke="black" stroke-miterlimit="10"></path><path d="M109.215 89.0486V133.058L62.9999 146L15.2607 133.513L16.0229 100.354" stroke="black" stroke-miterlimit="10"></path><path d="M16.2668 89.0486V95.1712" stroke="black" stroke-miterlimit="10"></path><path d="M73.0294 120.328C74.5952 120.328 75.8645 118.808 75.8645 116.933C75.8645 115.059 74.5952 113.539 73.0294 113.539C71.4637 113.539 70.1943 115.059 70.1943 116.933C70.1943 118.808 71.4637 120.328 73.0294 120.328Z" fill="black"></path><path d="M99.5817 112.023C101.147 112.023 102.417 110.503 102.417 108.628C102.417 106.754 101.147 105.234 99.5817 105.234C98.0159 105.234 96.7466 106.754 96.7466 108.628C96.7466 110.503 98.0159 112.023 99.5817 112.023Z" fill="black"></path><path d="M81.9617 124.45C81.9617 124.45 82.6628 116.903 88.4854 116.903C92.5703 116.903 92.5703 122.177 92.5703 122.177" stroke="black" stroke-miterlimit="10"></path><path d="M93.6982 73.5908L97.3259 72.6209" stroke="black" stroke-miterlimit="10"></path><path d="M101.289 71.7116L111.135 69.0747L63 55.678L16.2668 68.8626L62.2379 82.0774L89.3998 74.7426" stroke="black" stroke-miterlimit="10"></path><path d="M65.6523 84.1386L77.267 92.1099L122.506 78.8647L112.629 70.5903" stroke="black" stroke-miterlimit="10"></path><path d="M80.803 47.2218L124 58.5272L112.629 66.832" stroke="black" stroke-miterlimit="10"></path><path d="M60.3173 53.9808L48.977 44.9789L39.5876 47.2218" stroke="black" stroke-miterlimit="10"></path><path d="M31.2044 49.4645L2.45728 57.0419L14.1329 67.5896" stroke="black" stroke-miterlimit="10"></path><path d="M33.4297 49.4647L37.6061 48.7372" stroke="black" stroke-miterlimit="10"></path><path d="M14.1329 70.5903L2 80.3802L48.977 92.4433L60.3173 83.6536" stroke="black" stroke-miterlimit="10"></path><path d="M58.0919 55.769C58.0919 54.9507 58.1529 54.1323 58.2443 53.314C58.7321 48.5251 60.5002 43.8574 64.89 41.0387C75.4987 34.2494 81.4432 44.5849 75.2853 48.1917C65.6521 53.8595 54.2813 36.5226 50.4707 29.7333" stroke="black" stroke-miterlimit="10" stroke-dasharray="6 6"></path><path d="M60.3172 69.681C59.9514 68.6504 58.1528 62.8916 58.0918 56.5873" stroke="white" stroke-miterlimit="10" stroke-dasharray="6 6"></path><path d="M47.3003 24.6412C48.1538 24.429 49.0684 24.3381 49.9524 24.3078C51.3547 24.2775 53.1229 24.3987 54.0679 25.5808C54.769 26.4901 54.7385 27.6721 53.7021 28.248C52.6961 28.8239 51.3547 28.7633 50.3183 28.3692C48.6416 27.7327 47.6661 26.2173 47.4222 24.4896C47.3917 24.3381 47.1783 24.3987 47.2088 24.5503C47.4527 26.187 48.3063 27.6418 49.8305 28.3995C50.9584 28.9451 52.3607 29.0967 53.5192 28.6117C54.5252 28.1874 55.0739 27.2478 54.6776 26.187C54.0984 24.6715 52.4217 24.1865 50.9584 24.0956C49.739 24.035 48.4587 24.1562 47.2698 24.429C47.0869 24.4593 47.1478 24.6715 47.3003 24.6412Z" fill="#0D1B1E"></path><path d="M47.1478 24.5502C47.4527 25.2473 47.6966 26.0051 47.91 26.7325C48.2758 28.0661 48.6111 29.4906 48.4282 30.8849C48.3368 31.4911 48.1538 32.0973 47.6966 32.5216C47.2088 33.0065 46.4162 33.1884 45.7456 33.1278C44.2213 32.9762 43.825 31.4001 43.9774 30.0968C44.2213 27.9146 45.6541 25.9141 47.3612 24.5805C47.4832 24.4896 47.3003 24.338 47.2088 24.429C45.5626 25.702 44.2518 27.5205 43.8555 29.5513C43.6116 30.8243 43.6726 32.5519 45.0444 33.1581C46.2943 33.7036 47.849 33.1278 48.3977 31.9154C48.9769 30.5818 48.7026 28.9754 48.3977 27.6115C48.1538 26.5506 47.8185 25.4898 47.3917 24.4593C47.3308 24.3684 47.1174 24.429 47.1478 24.5502Z" fill="#0D1B1E"></path><path d="M46.8126 25.7323C47.7891 25.7323 48.5807 24.9453 48.5807 23.9744C48.5807 23.0035 47.7891 22.2165 46.8126 22.2165C45.8361 22.2165 45.0444 23.0035 45.0444 23.9744C45.0444 24.9453 45.8361 25.7323 46.8126 25.7323Z" fill="#0D1B1E"></path><path d="M94.0641 35.977C103.779 35.977 111.654 28.1472 111.654 18.4885C111.654 8.82988 103.779 1 94.0641 1C84.3495 1 76.4744 8.82988 76.4744 18.4885C76.4744 28.1472 84.3495 35.977 94.0641 35.977Z" fill="white"></path><path d="M111.196 22.0044C113.483 22.0044 115.312 20.1858 115.312 17.9126C115.312 15.6394 113.33 13.8209 111.044 13.8209C111.044 13.8209 111.745 15.9728 111.654 18.0642C111.562 20.1555 111.196 22.0044 111.196 22.0044Z" fill="white"></path><path d="M94.0641 35.977C103.779 35.977 111.654 28.1472 111.654 18.4885C111.654 8.82988 103.779 1 94.0641 1C84.3495 1 76.4744 8.82988 76.4744 18.4885C76.4744 28.1472 84.3495 35.977 94.0641 35.977Z" stroke="black" stroke-miterlimit="10"></path><path d="M84.2174 32.1278C84.5541 32.1278 84.827 31.8564 84.827 31.5217C84.827 31.1869 84.5541 30.9155 84.2174 30.9155C83.8806 30.9155 83.6077 31.1869 83.6077 31.5217C83.6077 31.8564 83.8806 32.1278 84.2174 32.1278Z" fill="black"></path><path d="M88.7291 31.3094C89.0658 31.3094 89.3388 31.038 89.3388 30.7032C89.3388 30.3684 89.0658 30.097 88.7291 30.097C88.3924 30.097 88.1194 30.3684 88.1194 30.7032C88.1194 31.038 88.3924 31.3094 88.7291 31.3094Z" fill="black"></path><path d="M85.6196 32.1883C85.6196 32.1883 84.9794 36.2195 86.4122 35.4618C87.8755 34.704 88.3327 33.2188 88.3327 33.2188C88.3327 33.2188 87.1743 31.3396 85.6196 32.1883Z" fill="#E6823A"></path><path d="M114.855 16.0941C114.855 16.0941 116.989 16.7002 117.294 17.3064C117.598 17.9126 115.312 17.7611 115.312 17.7611" stroke="black" stroke-miterlimit="10"></path><path d="M85.5282 32.1581C85.4063 32.9764 85.3148 33.8251 85.4063 34.6131C85.4368 34.9768 85.5282 35.5224 85.955 35.6437C86.1684 35.7043 86.3818 35.6133 86.5647 35.5224C86.961 35.3102 87.3268 35.0072 87.6317 34.6738C87.9975 34.2797 88.3024 33.7645 88.4853 33.2492C88.5158 33.0977 88.3024 33.0371 88.2719 33.1886C88.15 33.5523 87.9366 33.916 87.6927 34.2494C87.4488 34.5828 87.1439 34.8859 86.8391 35.0981C86.6562 35.2193 86.3513 35.4618 86.1074 35.4315C85.7721 35.4012 85.7112 34.8556 85.6807 34.5828C85.6197 34.0979 85.6502 33.5826 85.6807 33.0977C85.7112 32.7946 85.7416 32.4915 85.7721 32.1884C85.7721 32.0671 85.5587 32.0065 85.5282 32.1581Z" fill="black"></path><path d="M80.6811 11.1538C80.6811 11.1538 81.4433 7.51666 79.8276 7.21356C79.3093 7.21356 80.4373 10.396 79.9495 12.0024" fill="white"></path><path d="M80.8031 11.1841C80.8945 10.7901 80.925 10.3961 80.9555 10.0021C81.0165 9.33527 81.0165 8.57752 80.7726 7.94102C80.6811 7.66824 80.4982 7.42578 80.2544 7.27424C80.1019 7.18331 79.8276 7.03175 79.6752 7.18329C79.5532 7.33484 79.5837 7.60762 79.5837 7.78948C79.6142 8.15319 79.6752 8.54721 79.7361 8.91092C79.8886 9.88082 80.1019 11.0023 79.8276 11.9722C79.7971 12.1237 80.0105 12.1843 80.041 12.0328C80.2544 11.275 80.1629 10.4567 80.0715 9.66866C79.98 8.97154 79.7971 8.27444 79.7971 7.57733C79.7971 7.51671 79.7666 7.36515 79.8276 7.33484C79.8581 7.30453 79.98 7.36515 80.041 7.39546C80.2849 7.5167 80.4373 7.75917 80.5287 8.00165C80.7726 8.57752 80.7726 9.24433 80.7116 9.88083C80.6811 10.3052 80.6507 10.7295 80.5592 11.1235C80.5592 11.275 80.7726 11.3357 80.8031 11.1841Z" fill="#111110"></path><path d="M79.7666 12.8208C79.7666 12.8208 78.852 9.21396 77.2668 9.6686C76.8095 9.88077 79.2178 12.2752 79.4922 13.9119" fill="white"></path><path d="M79.8886 12.7905C79.7971 12.3965 79.6447 12.0025 79.4923 11.6388C79.2484 11.0326 78.9131 10.3658 78.4253 9.91114C78.2119 9.72928 77.968 9.54743 77.6632 9.51712C77.4803 9.48681 77.145 9.48682 77.1145 9.72929C77.084 9.94146 77.2669 10.1536 77.3583 10.3355C77.5717 10.6689 77.7851 10.972 77.9985 11.3054C78.5473 12.0934 79.2179 12.9724 79.3703 13.9726C79.4008 14.1242 79.6142 14.0635 79.5837 13.912C79.4618 13.1239 79.0045 12.4268 78.5777 11.76C78.1814 11.1841 77.7242 10.6386 77.4193 10.0021C77.3888 9.94147 77.3279 9.88084 77.3583 9.78991C77.3583 9.7596 77.3583 9.7596 77.3583 9.78991C77.3888 9.7596 77.5413 9.75959 77.5717 9.75959C77.8461 9.75959 78.09 9.91114 78.3034 10.0627C78.7607 10.487 79.0655 11.0932 79.3094 11.6691C79.4618 12.0631 79.6142 12.4571 79.7057 12.8512C79.7057 13.0027 79.9191 12.9421 79.8886 12.7905Z" fill="#111110"></path><path d="M79.6448 13.7301C79.6448 13.7301 78.8827 8.75933 76.9317 7.15294C76.1391 6.42551 80.6508 5.78901 79.9192 12.7905" fill="white"></path><path d="M79.7668 13.6998C79.6448 12.8511 79.4314 12.0024 79.1875 11.1841C78.7912 9.85048 78.3035 8.42594 77.3585 7.36511C77.2365 7.24387 77.0536 7.12264 76.9927 6.97109C76.9927 6.94078 76.9927 6.94078 76.9927 6.91047C77.0841 6.81954 77.2975 6.78924 77.4499 6.81955C78.1511 6.84986 78.7303 7.36511 79.0961 7.91068C80.0106 9.30491 79.9801 11.1841 79.7972 12.7602C79.7972 12.9117 80.0106 12.9117 80.0411 12.7602C80.1936 11.2144 80.224 9.45646 79.4314 8.03192C79.0656 7.36512 78.4559 6.75892 77.6938 6.60738C77.4195 6.54676 76.6573 6.54675 76.7488 7.0014C76.7793 7.09232 76.8402 7.15295 76.9012 7.21356C77.1756 7.48635 77.4194 7.72883 77.6328 8.03192C78.0901 8.72904 78.4254 9.48676 78.6998 10.2748C79.0961 11.3963 79.401 12.548 79.5839 13.6998C79.5534 13.9119 79.7972 13.8513 79.7668 13.6998Z" fill="#111110"></path><path d="M111.044 13.8209C113.33 13.8209 115.312 15.6394 115.312 17.9126C115.312 20.1858 113.483 22.0044 111.196 22.0044" stroke="black" stroke-miterlimit="10"></path><path d="M116.653 15.5487C116.653 15.5487 116.653 15.5487 116.684 14.791C116.714 14.0333 115.617 14.306 115.617 14.306C115.617 14.306 115.952 14.0029 115.983 13.2755C116.013 12.5481 114.733 13.8514 114.733 13.8514C114.733 13.8514 115.22 13.2149 115.19 11.5479C115.159 9.88086 112.751 13.7302 112.751 13.7302C112.751 13.7302 111.928 15.2153 112.568 15.9124C113.026 16.3671 114.123 16.4883 116.653 15.5487Z" fill="#19AF99"></path><path d="M112.843 13.7603C113.239 13.1238 113.635 12.5176 114.092 11.972C114.245 11.7902 114.367 11.6386 114.55 11.4871C114.641 11.3962 114.794 11.2446 114.946 11.2143C115.068 11.184 115.098 11.2749 115.129 11.3659C115.22 11.7296 115.159 12.1539 115.098 12.5479C115.038 12.9722 114.977 13.4875 114.702 13.8512C114.641 13.9118 114.763 14.0028 114.824 13.9422C115.098 13.6694 115.373 13.3663 115.739 13.2147C115.8 13.1844 115.891 13.1238 115.952 13.1844C115.983 13.2147 115.983 13.2753 115.983 13.3056C115.983 13.4572 115.952 13.5784 115.922 13.73C115.861 13.9422 115.8 14.1543 115.647 14.3059C115.586 14.3665 115.647 14.4271 115.708 14.4271C115.983 14.3665 116.44 14.3059 116.623 14.5786C116.714 14.6999 116.684 14.8514 116.684 14.9727C116.684 15.1242 116.684 15.2758 116.653 15.4273C116.653 15.4879 116.653 15.5486 116.653 15.6092C116.653 15.7001 116.775 15.7001 116.806 15.6092C116.806 15.5182 116.806 15.397 116.806 15.3061C116.806 15.0333 116.897 14.6696 116.684 14.4574C116.44 14.2149 115.983 14.2452 115.678 14.3059C115.708 14.3362 115.708 14.3968 115.739 14.4271C115.952 14.2452 116.044 13.9422 116.074 13.6694C116.104 13.4875 116.196 13.0329 115.891 13.0329C115.647 13.0329 115.373 13.2753 115.22 13.4269C115.068 13.5481 114.916 13.6997 114.763 13.8512C114.794 13.8815 114.824 13.9118 114.885 13.9422C115.129 13.6088 115.22 13.1541 115.281 12.7601C115.342 12.3358 115.403 11.8811 115.342 11.4568C115.312 11.3355 115.281 11.184 115.159 11.1234C114.885 11.0021 114.519 11.4265 114.367 11.578C114.001 11.972 113.696 12.3964 113.391 12.851C113.178 13.1541 112.995 13.4572 112.812 13.7603C112.66 13.7603 112.782 13.8209 112.843 13.7603Z" fill="black">
                                    </path>
                                </svg>
                                <h4 class="ss-text ss-text__size--h4 ss-text__weight--normal ss-text__color--grey">No folder here yet!</h4>
                                <div class="row pt-9">
                                    <div class="ss-dashboard__no-survey col-12 d-flex flex-column align-items-center justify-content-center">
                                        <div class="position--relative">
                                            <a href="#" class="ss-button ss-button__primary mb--sm" data-url="{{route('folder.create')}}" id="tracking-survey__new-survey" data-ajax-popup="true" data-bs-toggle="tooltip" title="Create Folder" data-title="Create Folder">
                                                Add a New Folder
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    {{-- <script src="{{ asset('/assets/js/jquery.min.js') }}"></script> --}}
<style>
div#survey-table_wrapper .row {
    width: 100%;
}

</style>

    
@include('admin.layout.footer')
    @stack('adminside-js')
<script>
    $(document).mouseup(function(e) 
    {
        $('[data-toggle="popover"]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
        var container = $(".action_list");


        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            container.hide();
        }
    });
    $("body").on("click", ".actionfolder", function () {
        $(".action_list").css('display','none');
        $(this).children(".action_list").toggle();
    });

    $("body").on("click", ".actionsurvey", function () {
        $(".action_list_survey").css('display','none');
        $(this).children(".action_list_survey").toggle();
    });

    function folderdelete(url,id){
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
                        t.value && Swal.fire({
                            title:"Deleted!", 
                            text:result.success, 
                            icon:"success"
                        }).then(function (t) { 
                            window.location.reload();
                        }) ;
                    }
                
                }});
            }
        })
        console.log(id)
    }

    $(document).ready(function(){
        $('.actionsurvey1').popover({
        html: true,
        content: function() {
        let contentID = $(this).data('htmlcontent');
        return $(contentID).html();
        }
    });
    });

    $('.actionsurvey1').on('click', function (e) {
        $('.actionsurvey1').not(this).popover('hide');
    });

    function surveydelete(url,id){
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
                        t.value && Swal.fire({
                            title:"Deleted!", 
                            text:result.success, 
                            icon:"success"
                        }).then(function (t) { 
                            window.location.reload();
                        }) ;
                    }
                }});
            }
            
        })
        console.log(id)
    }

    // $(document).on('click', '.deletesurvey', function(){
    //       console.log($(this).parent().parent().siblings('#deletelink'))
    // });
    // $('.deletesurvey').on('click', function (e) {
    //     console.log($(this).data('deleteurl'))
    // });
</script>

<script>
    toastr.options = { "closeButton" : true, "progressBar" : true }
</script>
@if(session()->has('success'))
<script>toastr.success("{{ session()->get('success') }}");</script>
@endif

@if(session()->has('error'))
<script>toastr.error("{{ session()->get('error') }}");</script>
@endif