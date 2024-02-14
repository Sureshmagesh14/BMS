@include('admin.layout.header')
    @yield('adminside-favicon')
    @yield('adminside-css')
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
    <a href="/dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
    </a>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu1">
            <div class="ss-dashboard--sidebar position--relative fx--fh fx-column pb-7 bg-grey-7">
                <div class="ss-dashboard--sidebar-container h-100 d-flex flex-column">
                    <div class="ss-overflow-y--auto ss-scrollbar--hide h-100" style="padding-top: 30px;">
                        <div class="fx-row mb-5 fx-ai--center justify-content-between px-7">
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
                                <div class="col-4 d-none d-md-flex flex-column align-items-center justify-content-center">
                                    <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--black ss-dashboard__list-item-property-value">{{$survey->questions->count()}}</h3>
                                    <a class="ss-button__link ss-button__link--underline color-grey-2 ss-dashboard-list-item__property-info">Questions</a>
                                </div>
                                <div class="col-4 d-none d-md-flex flex-column align-items-center justify-content-center">
                                    <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--black ss-dashboard__list-item-property-value">0</h3>
                                    <a class="ss-button__link ss-button__link--underline color-grey-2 ss-dashboard-list-item__property-info">Responses</a>
                                </div>
                                <div class="col-4 d-none d-md-flex flex-column align-items-center justify-content-center">
                                    <div>
                                        <h3 class="ss-text ss-text__size--h3 ss-text__weight--normal ss-text__color--black">--</h3>
                                    </div>
                                    <a class="ss-button__link ss-button__link--underline color-grey-2 ss-dashboard-list-item__property-info">Completion Rate</a>
                                </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="row no-gutters">
                                <div class="col-12 ss-dashboard__list-item-nav d-flex align-items-center justify-content-end flex-shrink-0">
                                   
                                    <div class="d-none d-md-flex align-items-center ss-dashboard-list-item__secondary-actions">
                                        <div class="rounded-md me-3">
                                            <a class="ss-button__link bg-grey-6 p-4 rounded-md" spiketip-title="Edit Survey" spiketip-pos="top" href="{{route('survey.builder',[$survey->builderID,0])}}">
                                                <i data-feather="edit"></i>
                                            </a>
                                        </div>
                                        <div class="rounded-md me-3">
                                        <a href="#" class="ss-button__link bg-grey-6 p-3 rounded-md" data-url="{{route('survey.sharesurvey',$survey->id)}}" data-ajax-popup="true" data-bs-toggle="tooltip" title="Share Survey" data-title="Share Survey">
                                                <i data-feather="share-2"></i>
                                            </a>
                                        </div>
                                        <div class="rounded-md me-3">
                                            <a href="{{route('survey.surveyduplication',$survey->id)}}" class="ss-button__link bg-grey-6 p-3 rounded-md" role="button" spiketip-title="Duplicate Survey" spiketip-pos="top">
                                                <i data-feather="copy"></i>
                                            </a>
                                        </div>
                                        <div class="rounded-md me-3">
                                            <a class="ss-button__link bg-grey-6 p-3 rounded-md" role="button" spiketip-title="Duplicate Survey" spiketip-pos="top">
                                                <i data-feather="trash-2"></i>
                                            </a>
                                        </div>
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
<script>
$(document).mouseup(function(e) 
{
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
   
</script>
    @yield('adminside-script')
@include('admin.layout.footer')
