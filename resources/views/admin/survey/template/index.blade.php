@include('admin.layout.header')
    @yield('adminside-favicon')
    @yield('adminside-css')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
<!-- ========== Left Sidebar Start ========== -->
<link href="{{ asset('assets/css/survey.css') }}" rel="stylesheet" type="text/css" />

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
</style>
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('/assets/images/logo-dark-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/images/logo-dark.png') }}" alt="" height="18">
            </span>
        </a>

        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('/assets/images/logo-light-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/images/logo-light.png') }}" alt="" height="18">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
        <?php
            $link = $_SERVER['PHP_SELF'];
            $link_array = explode('/',$link);
            $page = end($link_array);
        ?>
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
            <a href="{{route('folder')}}"><li class="menu-title" key="t-menu">Folders</li></a>
                @foreach($folders as $folder)
                <li>
                    <a href="{{$folder->id}}" class="waves-effect @if($page==$folder->id) active @endif">
                        <span class="menu-item" key="t-dashboards">{{$folder->folder_name}} ({{$folder->surveycount_count}})</span>
                    </a>
                </li>
                @endforeach
                
            </ul>
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
                <?php $getSurveys = App\Models\Survey::where(['folder_id'=>$page])->get();?>
                @foreach($getSurveys as $survey)
                <div class="row no-gutters w-100 py-5 px-xl-3 ss-dashboard__list-item justify-content-between align-items-center background-color--white pointer--cursor surveyrow">
                    <div class="ss-dashboard__list-item--left col-12 col-xl-5 pe-0 pe-xl-5">
                        <div class="d-flex align-items-center flex-wrap flex-md-nowrap">
                            <div class="ss-dashboard__list-item--sm-survey-identifier d-flex d-md-none py-2 px-3 rounded-sm bg-light-yellow">
                                <p class="ss-text ss-text__size--micro ss-text__weight--bold ss-text__color--grey ss-text__align--center ss-text__transform--uppercase">Classic Form</p>
                            </div>
                            <div spiketip-title="Classic Form" spiketip-pos="top" class="ss-dashboard__list-item--image d-none d-md-flex justify-content-center align-items-center me-5 p-2" style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);">
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
                                <div class="col-4 d-none d-md-flex flex-column align-items-center justify-content-center">
                                    <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--black ss-dashboard__list-item-property-value">0</h3>
                                    <a class="ss-button__link ss-button__link--underline color-grey-2 ss-dashboard-list-item__property-info" href="/builder/edit/504135">Questions</a>
                                </div>
                                <div class="col-4 d-none d-md-flex flex-column align-items-center justify-content-center">
                                    <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--black ss-dashboard__list-item-property-value">0</h3>
                                    <a class="ss-button__link ss-button__link--underline color-grey-2 ss-dashboard-list-item__property-info" href="/survey/504135/results/responses">Responses</a>
                                </div>
                                <div class="col-4 d-none d-md-flex flex-column align-items-center justify-content-center">
                                    <div>
                                        <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--black">--</h3>
                                    </div>
                                    <a class="ss-button__link ss-button__link--underline color-grey-2 ss-dashboard-list-item__property-info" href="/survey/504135/results/questions">Completion Rate</a>
                                </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="row no-gutters">
                                <div class="col-12 ss-dashboard__list-item-nav d-flex align-items-center justify-content-end flex-shrink-0">
                                    <div class="d-flex align-items-center d-md-none">
                                        <button class="ss-dashboard__list-item-sm-button d-flex align-items-center justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16">
                                            <path stroke="#0D1B1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 13.333V6.667M8 13.333V2.667M4 13.333v-4"></path>
                                            </svg>
                                        </button>
                                        <button class="ss-dashboard__list-item-sm-button d-flex align-items-center justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16">
                                            <path stroke="#0D1B1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5.333a2 2 0 100-4 2 2 0 000 4zM4 10a2 2 0 100-4 2 2 0 000 4zM12 14.667a2 2 0 100-4 2 2 0 000 4zM5.727 9.007l4.553 2.653M10.273 4.34L5.727 6.993"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="d-none d-md-flex align-items-center ss-dashboard-list-item__secondary-actions">
                                        <div class="rounded-md me-3">
                                            <a class="ss-button__link bg-grey-6 p-4 rounded-md" spiketip-title="Edit Survey" spiketip-pos="top" href="/builder/edit/504135">
                                            <svg width="16" height="16" class="" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.728 6.68608L11.314 5.27208L2 14.5861V16.0001H3.414L12.728 6.68608ZM14.142 5.27208L15.556 3.85808L14.142 2.44408L12.728 3.85808L14.142 5.27208ZM4.242 18.0001H0V13.7571L13.435 0.322083C13.6225 0.134612 13.8768 0.0292969 14.142 0.0292969C14.4072 0.0292969 14.6615 0.134612 14.849 0.322083L17.678 3.15108C17.8655 3.33861 17.9708 3.59292 17.9708 3.85808C17.9708 4.12325 17.8655 4.37756 17.678 4.56508L4.243 18.0001H4.242Z" fill="#0D1B1E"></path>
                                            </svg>
                                            </a>
                                        </div>
                                        <div class="rounded-md me-3">
                                            <a class="ss-button__link bg-grey-6 p-3 rounded-md" role="button" spiketip-title="Share Survey" spiketip-pos="top">
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
                                    <div>
                                        <span class="bp3-popover2-target">
                                            <div class="ss-dashboard__survey-actions-btn d-flex align-items-center bg-grey-6 rounded-md p-3" spiketip-title="More" spiketip-pos="top">
                                            <a class="ss-button ss-button__icon-only p-0 mx-0" role="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24">
                                                    <g clip-path="url(#clip0_1106_12887)" opacity="0.9">
                                                        <path fill="#0D1B1E" d="M21 12c0-1.1-.9-2-2-2s-2 .9-2 2 .9 2 2 2 2-.9 2-2zM7 12c0-1.1-.9-2-2-2s-2 .9-2 2 .9 2 2 2 2-.9 2-2zm7 0c0-1.1-.9-2-2-2s-2 .9-2 2 .9 2 2 2 2-.9 2-2z"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1106_12887">
                                                        <path fill="#fff" d="M0 0H24V24H0z" transform="rotate(90 12 12)"></path>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </a>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
    @yield('adminside-script')
@include('admin.layout.footer')
