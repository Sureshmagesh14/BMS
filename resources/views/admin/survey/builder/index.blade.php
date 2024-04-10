@include('admin.layout.header')
    @yield('adminside-favicon')
    @yield('adminside-css')
<div class="horizontal_left_menu">
@include('admin.layout.horizontal_left_menu')
</div>
<style>
.horizontal_left_menu {
    display: none;
}
.respondant_selection.row {
    margin-top: 1rem;
}
.logic_section_display_row ,.logic_section_skip_row{
    margin-bottom: 1rem;
}
/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
@include('admin.layout.horizontal_right_menu')
<!-- ========== Left Sidebar Start ========== -->
<link href="{{ asset('assets/css/builder.css') }}" rel="stylesheet" type="text/css" />

<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{route('survey.template',$survey->folder_id)}}"  class="logo  surveytitle">
            {{$survey->title}}
        </a>
        <a href="{{route('survey.template',$survey->folder_id)}}" ><i data-feather="home"></i></a>

       
    </div>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <div class=" fx-jc--between ss-builder-add-new ss-builder-add-new--sm-sidebar-card surveyques" >
                <a class="setbackground"  href="{{route('survey.surveytemplate',[$survey->id,'welcome'])}}">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 21H0V19H5V21ZM8.424 15.282L12.826 19.681L7 21L8.424 15.282ZM24 8.534L14.311 18.338L9.775 13.802L19.464 4L24 8.534Z" fill="#63686F"></path></svg>
                    <p>Welcome Templates</p>
                </a>
            </div>
            <div class=" fx-jc--between ss-builder-add-new ss-builder-add-new--sm-sidebar-card surveyques" >
                <a class="setbackground"  href="{{route('survey.surveytemplate',[$survey->id,'thankyou'])}}">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 21H0V19H5V21ZM8.424 15.282L12.826 19.681L7 21L8.424 15.282ZM24 8.534L14.311 18.338L9.775 13.802L19.464 4L24 8.534Z" fill="#63686F"></path></svg>
                    <p>Thankyou Templates</p>
                </a>
            </div>
            <div class=" fx-jc--between ss-builder-add-new ss-builder-add-new--sm-sidebar-card surveyques" >
                <a class="setbackground"  href="{{route('survey.background',$survey->id)}}">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M17.839 7.66998C18.934 6.57198 20.713 5.79898 21.524 4.55698C22.411 3.19198 22.026 1.36898 20.661 0.474979C19.298 -0.410021 17.473 -0.024021 16.575 1.33998C15.737 2.62798 15.784 4.66398 15.151 6.12098C14.339 8.00398 11.599 8.24398 8.445 6.60898C6.723 9.96498 4.38 13.566 2 16.493L13.548 24C15.044 21.114 17.955 16.652 19.989 14.117C17.162 11.854 16.314 9.19198 17.839 7.66998ZM19.591 2.12498C20.043 2.41898 20.173 3.03098 19.873 3.48198C19.579 3.94298 18.968 4.06598 18.517 3.77198C18.059 3.47298 17.932 2.86898 18.23 2.41598C18.522 1.95798 19.133 1.82698 19.591 2.12498ZM12.927 21.352L4.677 15.99C5.653 14.725 6.43 13.509 7.489 11.886C7.916 11.23 8.422 11.093 8.723 11.288C9.827 12.005 7.216 14.913 8.394 15.679C9.563 16.438 11.283 12.311 12.555 13.14C13.54 13.78 11.765 15.838 12.764 16.486C13.229 16.789 13.897 16.228 14.48 15.855C15.486 15.21 16.419 15.861 15.436 17.371C14.455 18.872 13.92 19.686 12.927 21.352Z" fill="#63686F"></path></g></svg> <p>Design Background</p>
                </a>
            </div>
            <div class=" fx-jc--between ss-builder-add-new ss-builder-add-new--sm-sidebar-card surveyques" >
            <a class="setbackground"  data-url="{{route('survey.surveysettings',$survey->id)}}" data-ajax-popup="true" data-bs-toggle="tooltip" title="Survey Settings" data-title="Survey Settings">

                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M24 13.616V10.384C22.349 9.797 21.306 9.632 20.781 8.365V8.364C20.254 7.093 20.881 6.23 21.628 4.657L19.343 2.372C17.782 3.114 16.91 3.747 15.636 3.219H15.635C14.366 2.693 14.2 1.643 13.616 0H10.384C9.802 1.635 9.635 2.692 8.365 3.219H8.364C7.093 3.747 6.232 3.121 4.657 2.372L2.372 4.657C3.117 6.225 3.747 7.091 3.219 8.364C2.692 9.635 1.635 9.802 0 10.384V13.616C1.632 14.196 2.692 14.365 3.219 15.635C3.749 16.917 3.105 17.801 2.372 19.342L4.657 21.628C6.219 20.885 7.091 20.253 8.364 20.781H8.365C9.635 21.307 9.801 22.36 10.384 24H13.616C14.198 22.364 14.366 21.31 15.643 20.778H15.644C16.906 20.254 17.764 20.879 19.342 21.629L21.627 19.343C20.883 17.78 20.252 16.91 20.779 15.637C21.306 14.366 22.367 14.197 24 13.616ZM12 16C9.791 16 8 14.209 8 12C8 9.791 9.791 8 12 8C14.209 8 16 9.791 16 12C16 14.209 14.209 16 12 16Z" fill="#63686F"></path></svg><p>Settings</p>
                </a>
            </div>
       
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
                            @elseif($qus->qus_type=='photo_capture')
                            <svg width="32" height="32" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.32344 3.07344L9.98604 3.73604C10.0969 3.84686 10.2472 3.90911 10.4039 3.90911H11.9318C12.2453 3.90911 12.5459 4.03363 12.7675 4.25526C12.9891 4.47689 13.1137 4.77749 13.1137 5.09093V10.4091C13.1137 10.7226 12.9891 11.0232 12.7675 11.2448C12.5459 11.4664 12.2453 11.5909 11.9318 11.5909H3.65911C3.34568 11.5909 3.04508 11.4664 2.82344 11.2448C2.60181 11.0232 2.47729 10.7226 2.47729 10.4091V5.09093C2.47729 4.77749 2.60181 4.47689 2.82344 4.25526C3.04508 4.03363 3.34568 3.90911 3.65911 3.90911H5.18708C5.3438 3.90911 5.4941 3.84686 5.60491 3.73604L6.26751 3.07344C6.37725 2.9637 6.50753 2.87665 6.65092 2.81726C6.79431 2.75786 6.94799 2.72729 7.10319 2.72729H8.48777C8.64297 2.72729 8.79665 2.75786 8.94003 2.81726C9.08342 2.87665 9.2137 2.9637 9.32344 3.07344Z" stroke="#63686F" stroke-width="0.886364" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.79552 9.81821C9.10092 9.81821 10.1592 8.75998 10.1592 7.45458C10.1592 6.14918 9.10092 5.09094 7.79552 5.09094C6.49012 5.09094 5.43188 6.14918 5.43188 7.45458C5.43188 8.75998 6.49012 9.81821 7.79552 9.81821Z" stroke="#63686F" stroke-width="0.886364" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.3705 5.68181C11.3705 5.68765 11.3687 5.69336 11.3655 5.69821C11.3622 5.70306 11.3576 5.70684 11.3522 5.70907C11.3468 5.7113 11.3409 5.71188 11.3352 5.71074C11.3294 5.7096 11.3242 5.70679 11.3201 5.70266C11.3159 5.69853 11.3131 5.69327 11.312 5.68754C11.3108 5.68181 11.3114 5.67587 11.3136 5.67048C11.3159 5.66508 11.3197 5.66046 11.3245 5.65722C11.3294 5.65397 11.3351 5.65223 11.3409 5.65222C11.3448 5.65222 11.3486 5.65298 11.3522 5.65446C11.3558 5.65595 11.3591 5.65813 11.3618 5.66088C11.3646 5.66363 11.3668 5.66689 11.3683 5.67048C11.3697 5.67407 11.3705 5.67792 11.3705 5.68181" stroke="#63686F" stroke-width="0.886364" stroke-linecap="round" stroke-linejoin="round"></path></svg>        
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
                
                <a data-url="{{route('survey.questiontype',$survey->id)}}" data-ajax-popup="true" data-bs-toggle="tooltip" title="Choose Question Type" data-title="Choose Question Type">
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
                        <h4 class="mb-0">{{$survey->title}}</h4>
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
                    $likert_range = 10;
                    $likert_scale = [4,5,6,7,8,9,10];
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
                    if(isset($qusvalue->likert_range)){
                        $likert_range=$qusvalue->likert_range;
                    }
                    if(isset($qusvalue->left_label)){
                        $left_label=$qusvalue->left_label;
                    }
                    ?>
                    <input type="hidden" name="page_type" id="pagetype" value="{{$pagetype}}"/>
                    <?php 
                    $qusNo=1;
                    foreach($questions as $key=>$qus){
                        if($currentQus->id==$qus->id){
                            $qusNo=$qusNo+$key;
                        }
                    } ?>
                  
                    <div id="qus_content">
                    <div class="page_head">
                        <h4>Question Type : <span id="qus_type">{{$qus_type}}</span></h4>
                        <?php  $qus_url=route('survey.builder',[$survey->builderID,$currentQus->id]); ?>
                        <button class="btn  btn-primary" data-url="{{$qus_url}}" id="preview_qus">Preview</button>
                    </div>
                    {{ Form::open(array('url' => route('survey.qus.update',$currentQus->id),'id'=>'updatequs','class'=>'needs-validation','enctype'=>"multipart/form-data")) }}
                    
                    @if($currentQus->qus_type=='welcome_page')
                        <div class="modal-body">
                            <div>
                                <?php $templatesWel = \App\Models\SurveyTemplate::where(['type'=>'welcome'])->pluck('template_name', 'id')->toArray();
                                 $template_id_welcome = '';
                                 if(isset($qusvalue->welcome_template)){
                                    $template_id_welcome = $qusvalue->welcome_template;
                                 }
                                  ?>
                               
                                {{ Form::label('welcome_template', __('Welcome Template'),['class'=>'form-label']) }}
                                <select id="welcome_template" class="welcome_template form-control" name="welcome_template" data-placeholder="Choose ...">
                                    <option value="">Choose Template</option>
                                    @foreach($templatesWel as $key=>$value)
                                        <option value="{{$key}}" @if($key==$template_id_welcome) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div>
                                {{ Form::label('welcome_title', __('Title'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->welcome_title))
                                    {{ Form::text('welcome_title', $qusvalue->welcome_title , array('class' => 'form-control',
                                'placeholder'=>'Enter Welcome Page title','id'=>'welcome_title')) }}
                                @else 
                                    {{ Form::text('welcome_title', null , array('class' => 'form-control',
                                'placeholder'=>'Enter Welcome Page title','id'=>'welcome_title')) }}
                                @endif
                            </div>
                            <br>
                            <div>
                                {{ Form::label('welcome_imagetitle', __('Sub Title'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->welcome_imagetitle))
                                    {{ Form::text('welcome_imagetitle', $qusvalue->welcome_imagetitle , array('class' => 'form-control',
                                'placeholder'=>'Sub title','id'=>'welcome_imagetitle')) }}
                                @else 
                                    {{ Form::text('welcome_imagetitle', null , array('class' => 'form-control',
                                'placeholder'=>'Sub title','id'=>'welcome_imagetitle')) }}
                                @endif
                            </div>
                            <br>
                            <div>
                                {{ Form::label('welcome_imagesubtitle', __('Description'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->welcome_imagetitle))
                                    {{ Form::text('welcome_imagesubtitle', $qusvalue->welcome_imagesubtitle , array('class' => 'form-control',
                                'placeholder'=>'Description','id'=>'welcome_imagesubtitle')) }}
                                @else 
                                    {{ Form::text('welcome_imagesubtitle', null , array('class' => 'form-control',
                                'placeholder'=>'Description','id'=>'welcome_imagesubtitle')) }}
                                @endif
                            
                            </div>
                            <br>
                            @if(isset($qusvalue->welcome_image))
                            <div class="exitingImg">
                                <image src="{{ asset('uploads/survey/'.$qusvalue->welcome_image) }}" alt="image" width="100" height="100" id="existing_image">
                                <a id="ss_draft_remove_image_welcome" class="ss_draft_remove_image pointer--cursor"><svg xmlns="http://www.w3.org/2000/svg" class="" width="30" height="30" viewBox="0 0 21 25" fill="none"><path d="M13.209 20.2187H7.30662C6.83423 20.2187 6.37926 20.0404 6.03265 19.7195C5.68605 19.3985 5.47338 18.9586 5.43715 18.4876L4.63281 8.03125H15.8828L15.0785 18.4876C15.0422 18.9586 14.8296 19.3985 14.483 19.7195C14.1364 20.0404 13.6814 20.2187 13.209 20.2187V20.2187Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M16.9271 8.03125H3.59375" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.91406 5.21875H12.6016C12.8502 5.21875 13.0887 5.31752 13.2645 5.49334C13.4403 5.66915 13.5391 5.90761 13.5391 6.15625V8.03125H6.97656V6.15625C6.97656 5.90761 7.07533 5.66915 7.25115 5.49334C7.42697 5.31752 7.66542 5.21875 7.91406 5.21875V5.21875Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.8984 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.61719 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                            </div>
                            @else
                            <div class="exitingImg" style="display:none;">
                                <image src="" alt="image" width="100" height="100" id="existing_image">
                                <a id="ss_draft_remove_image_thankyou" class="ss_draft_remove_image pointer--cursor"><svg xmlns="http://www.w3.org/2000/svg" class="" width="30" height="30" viewBox="0 0 21 25" fill="none"><path d="M13.209 20.2187H7.30662C6.83423 20.2187 6.37926 20.0404 6.03265 19.7195C5.68605 19.3985 5.47338 18.9586 5.43715 18.4876L4.63281 8.03125H15.8828L15.0785 18.4876C15.0422 18.9586 14.8296 19.3985 14.483 19.7195C14.1364 20.0404 13.6814 20.2187 13.209 20.2187V20.2187Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M16.9271 8.03125H3.59375" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.91406 5.21875H12.6016C12.8502 5.21875 13.0887 5.31752 13.2645 5.49334C13.4403 5.66915 13.5391 5.90761 13.5391 6.15625V8.03125H6.97656V6.15625C6.97656 5.90761 7.07533 5.66915 7.25115 5.49334C7.42697 5.31752 7.66542 5.21875 7.91406 5.21875V5.21875Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.8984 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.61719 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                            </div>
                            @endif
                            <div id="imgPreview"></div>
                            <div style="<?php if(isset($qusvalue->welcome_image) && $qusvalue->welcome_image!=''){ echo "display:none;"; } ?>" class="upload-image-placeholder" id="trigger_welcome_image">
                                <div class="upload-image-placeholder__upload-btn">
                                    <svg width="40" height="40" viewBox="0 0 36 27"><path fill="#D7D7D7" d="M7.5 8.25a2.25 2.25 0 114.502.002A2.25 2.25 0 017.5 8.25zM21 9l-3.779 6-3.721-2.94-6 8.94h21L21 9zm12-6v21H3V3h30zm3-3H0v27h36V0z"></path></svg>
                                    <p>Click here to upload a welcome image</p>
                                </div>
                            </div>
                            
                            @if(isset($qusvalue->welcome_image))
                            <input style="display:none;" type="hidden" id="existing_image_uploaded" name="existing_image_uploaded"  class="course form-control" value="{{$qusvalue->welcome_image}}">
                            @endif
                           
                            <input style="display:none;" type="file" id="welcome_image" name="welcome_image"  class="course form-control">
                            <div>
                                {{ Form::label('welcome_btn', __('Button Label'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->welcome_imagetitle))
                                    {{ Form::text('welcome_btn', $qusvalue->welcome_btn , array('class' => 'form-control',
                                'placeholder'=>'Enter Button Label','id'=>'welcome_btn')) }}
                                @else 
                                    {{ Form::text('welcome_btn', null , array('class' => 'form-control',
                                'placeholder'=>'Enter Button Label','id'=>'welcome_btn')) }}
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
                                <?php $templatesWel = \App\Models\SurveyTemplate::where(['type'=>'thankyou'])->pluck('template_name', 'id')->toArray();
                                 $template_id_thankyou = '';
                                 if(isset($qusvalue->thankyou_template)){
                                    $template_id_thankyou = $qusvalue->thankyou_template;
                                 }
                                  ?>
                               
                                {{ Form::label('thankyou_template', __('Thankyou Template'),['class'=>'form-label']) }}
                                <select id="thankyou_template" class="thankyou_template form-control" name="thankyou_template" data-placeholder="Choose ...">
                                    <option value="">Choose Template</option>
                                    @foreach($templatesWel as $key=>$value)
                                        <option value="{{$key}}" @if($key==$template_id_thankyou) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div>
                                {{ Form::label('thankyou_title', __('Title'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->thankyou_title))
                                    {{ Form::text('thankyou_title', $qusvalue->thankyou_title , array('class' => 'form-control',
                                'placeholder'=>'Enter thank you page title','id'=>'thankyou_title')) }}
                                @else 
                                    {{ Form::text('thankyou_title', null , array('class' => 'form-control',
                                'placeholder'=>'Enter thank you page title','id'=>'thankyou_title')) }}
                                @endif
                            </div>
                            <br>
                            <div>
                                {{ Form::label('thankyou_imagetitle', __('Sub Title'),['class'=>'form-label']) }}
                                @if(isset($qusvalue->thankyou_imagetitle))
                                    {{ Form::text('thankyou_imagetitle', $qusvalue->thankyou_imagetitle , array('class' => 'form-control',
                                'placeholder'=>'Sub title','id'=>'thankyou_imagetitle')) }}
                                @else 
                                    {{ Form::text('thankyou_imagetitle', null , array('class' => 'form-control',
                                'placeholder'=>'Sub title','id'=>'thankyou_imagetitle')) }}
                                @endif
                            </div>
                            <br>
                            @if(isset($qusvalue->thankyou_image))
                            <input style="display:none;" type="hidden" id="existing_image_uploaded" name="existing_image_uploaded_thankyou"  class="course form-control" value="{{$qusvalue->thankyou_image}}">
                            <div class="exitingImg">
                                <image src="{{ asset('uploads/survey/'.$qusvalue->thankyou_image) }}" alt="image" width="100" height="100" id="existing_image_thankyou">
                                <a id="ss_draft_remove_image_thankyou" class="ss_draft_remove_image pointer--cursor"><svg xmlns="http://www.w3.org/2000/svg" class="" width="30" height="30" viewBox="0 0 21 25" fill="none"><path d="M13.209 20.2187H7.30662C6.83423 20.2187 6.37926 20.0404 6.03265 19.7195C5.68605 19.3985 5.47338 18.9586 5.43715 18.4876L4.63281 8.03125H15.8828L15.0785 18.4876C15.0422 18.9586 14.8296 19.3985 14.483 19.7195C14.1364 20.0404 13.6814 20.2187 13.209 20.2187V20.2187Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M16.9271 8.03125H3.59375" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.91406 5.21875H12.6016C12.8502 5.21875 13.0887 5.31752 13.2645 5.49334C13.4403 5.66915 13.5391 5.90761 13.5391 6.15625V8.03125H6.97656V6.15625C6.97656 5.90761 7.07533 5.66915 7.25115 5.49334C7.42697 5.31752 7.66542 5.21875 7.91406 5.21875V5.21875Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.8984 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.61719 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                            </div>
                            @else
                            <div class="exitingImg" style="display:none;">
                                <image src="" alt="image" width="100" height="100" id="existing_image_thankyou">
                                <a id="ss_draft_remove_image_thankyou" class="ss_draft_remove_image pointer--cursor"><svg xmlns="http://www.w3.org/2000/svg" class="" width="30" height="30" viewBox="0 0 21 25" fill="none"><path d="M13.209 20.2187H7.30662C6.83423 20.2187 6.37926 20.0404 6.03265 19.7195C5.68605 19.3985 5.47338 18.9586 5.43715 18.4876L4.63281 8.03125H15.8828L15.0785 18.4876C15.0422 18.9586 14.8296 19.3985 14.483 19.7195C14.1364 20.0404 13.6814 20.2187 13.209 20.2187V20.2187Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M16.9271 8.03125H3.59375" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.91406 5.21875H12.6016C12.8502 5.21875 13.0887 5.31752 13.2645 5.49334C13.4403 5.66915 13.5391 5.90761 13.5391 6.15625V8.03125H6.97656V6.15625C6.97656 5.90761 7.07533 5.66915 7.25115 5.49334C7.42697 5.31752 7.66542 5.21875 7.91406 5.21875V5.21875Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.8984 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.61719 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
                            </div>
                            @endif
                            <div id="imgPreviewthanksyou"></div>
                            <div style="<?php if(isset($qusvalue->thankyou_image) && $qusvalue->thankyou_image!=''){ echo "display:none;"; } ?>" class="upload-image-placeholder" id="trigger_thankyou_image">
                                <div class="upload-image-placeholder__upload-btn">
                                    <svg width="40" height="40" viewBox="0 0 36 27"><path fill="#D7D7D7" d="M7.5 8.25a2.25 2.25 0 114.502.002A2.25 2.25 0 017.5 8.25zM21 9l-3.779 6-3.721-2.94-6 8.94h21L21 9zm12-6v21H3V3h30zm3-3H0v27h36V0z"></path></svg>
                                    <p>Click here to upload a thank you image</p>
                                </div>
                            </div>
                            <input style="display:none;" type="file" id="thankyou_image" name="thankyou_image"  class="course form-control">
                            
                        </div>
                    @endif
                   
                    @if($currentQus->qus_type!='welcome_page' && $currentQus->qus_type!='thank_you')
                        <div class="modal-body">
                                <div>
                                    {{ Form::label('question_name', __('Question Title'),['class'=>'form-label']) }}
                                        {{ Form::text('question_name', $qus_name , array('class' => 'form-control',
                                    'placeholder'=>'Enter Question title','required'=>true)) }}
                                </div>
                                <br>
                                <div>
                                    {{ Form::label('question_description', __('Add description to your question'),['class'=>'form-label']) }}
                                        {{ Form::text('question_description', $qus_name , array('class' => 'form-control',
                                    'placeholder'=>'Enter Question description')) }}
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
                                <div class="row">
                                    <div class="col-md-4">
                                        {{ Form::label('likert_range','Likert Range',['class'=>'form-label']) }}
                                        <select id="likert_range" class="likert_range form-control" name="likert_range" data-placeholder="Choose ...">
                                            @foreach($likert_scale as $scale)
                                                <option value="{{$scale}}" @if($scale==$likert_range) selected @endif>{{$scale}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="ss_row--builder ss-paddding--top-bottom">
                                    <div class="opinion-scale-container ss-paddding--top-bottom">
                                        <div class="opinion-scale-box" id="likert_scale_option">
                                            <div class="label label--start">
                                                <p id="left_lable_text">{{$left_label}}</p>
                                            </div>
                                            @if($likert_range != 4)
                                            <div class="label label--middle">
                                                <p id="middle_lable_text">{{$middle_label}}</p>
                                            </div>
                                            @endif
                                            <div class="label label--end">
                                                <p id="right_lable_text">{{$right_label}}</p>
                                            </div>
                                            <div class="scale-element"><span>1</span></div>
                                            <div class="scale-element"><span>2</span></div>
                                            <div class="scale-element"><span>3</span></div>
                                            <div class="scale-element"><span>4</span></div>
                                            @if($likert_range >=5)<div class="scale-element"><span>5</span></div>@endif
                                            @if($likert_range >=6)<div class="scale-element"><span>6</span></div>@endif
                                            @if($likert_range >=7)<div class="scale-element"><span>7</span></div>@endif
                                            @if($likert_range >=8)<div class="scale-element"><span>8</span></div>@endif
                                            @if($likert_range >=9)<div class="scale-element"><span>9</span></div>@endif
                                            @if($likert_range >=10)<div class="scale-element"><span>10</span></div>@endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($currentQus->qus_type=='photo_capture')
                                    <div class="ss-camera-input upload_wrapper">
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
                                    </div>
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
                                    @if($exiting_choices!=null)
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
                                    @endif
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
                                            @if(count($exiting_choices_matrix)>0)
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
                                                        @foreach($exiting_choices_matrix as $ans)
                                                        <td><input type="radio" name="matrix_anstype{{$qus}}"></td>
                                                        @endforeach
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
                    <!-- Display Logic  -->
                    <input type="hidden" id="display_logic_type_value_display" name="display_logic_type_value_display">   
                    <input type="hidden" id="logic_type_value_option_display" name="logic_type_value_option_display">   
                    <input type="hidden" id="display_qus_choice_andor_display" name="display_qus_choice_andor_display">   
                    <input type="hidden" id="display_qus_choice_display" name="display_qus_choice_display"> 
                    <!-- Display Logic  -->
                    <!-- Skip Logic  -->
                    <input type="hidden" id="skiplogic_type_value_skip" name="skiplogic_type_value_skip">   
                    <input type="hidden" id="logic_type_value_option_skip" name="logic_type_value_option_skip">   
                    <input type="hidden" id="display_qus_choice_andor_skip" name="display_qus_choice_andor_skip">   
                    <input type="hidden" id="display_qus_choice_skip" name="display_qus_choice_skip"> 
                    <!-- Skip Logic -->
                    @if($currentQus->qus_type!='welcome_page' && $currentQus->qus_type!='thank_you')
                        <div class="tab">
                        @if($qusNo!=1)<button type="button" class="tablinks" onclick="openLogic(event, 'display_logic')">Display Logic</button>@endif
                            <button  type="button" class="tablinks" onclick="openLogic(event, 'skip_logic')">Skip Logic</button>
                        </div>
                        @if($qusNo!=1)
                            <div id="display_logic" class="tabcontent">
                                <input type="hidden" value="{{json_encode($display_logic)}}" name="display_qus" id="display_qus"/>
                                <input type="hidden" value="{{json_encode($display_logic_matrix)}}" name="display_qus_matrix" id="display_qus_matrix"/>
                            
                                    <p>Display the question only</p>
                                    {{ Form::label('display_type','If',['class'=>'form-label']) }}
                                    <div id="logic_section_display">
                                        <?php 
                                            $display_logic_DB = json_decode($currentQus->display_logic); 
                                            if($display_logic_DB!=null){
                                                $display_logic_DB1=json_decode($display_logic_DB->display_qus_choice_display); 
                                                $logic_type_value=json_decode($display_logic_DB->logic_type_value_display); 
                                                $logic_type_value_option_display=json_decode($display_logic_DB->logic_type_value_option_display); 
                                                $display_qus_choice_andor_display=json_decode($display_logic_DB->display_qus_choice_andor_display); 
                                            }else{
                                                $display_logic_DB1=[]; $logic_type_value=[];
                                                $logic_type_value_option_display=[]; $display_qus_choice_andor_display=[];
                                            }
                                            // echo "<pre>"; print_r($logic_type_value);
                                            ?>
                                            @foreach($display_logic_DB1 as $key=>$v1)
                                                <?php 
                                                if($logic_type_value){
                                                    $vlogic= $logic_type_value[$key]; 
                                                    $vlogicoption= $logic_type_value_option_display[$key]; 
                                                    $andOrVal=$display_qus_choice_andor_display[$key]; 
                                                }else{
                                                    $vlogic= ''; 
                                                    $vlogicoption= ''; 
                                                    $andOrVal=''; 
                                                } 
                                                // echo $vlogic.'-vlogic';
                                                ?>
                                                <div class="logic_section_display_row">
                                                    <div class="row">
                                                        @if($key>0)
                                                        <div class="col-md-4">
                                                            <select class="display_qus_choice_andor form-control" name="display_qus_choice_andor" data-placeholder="Choose ...">
                                                                <option value="and" @if($andOrVal=='and') selected @endif>AND</option>
                                                                <option value="or" @if($andOrVal=='or') selected @endif>OR</option>
                                                            </select>
                                                        </div>
                                                        @endif
                                                        <div class="col-md-4">
                                                            {{ Form::text('display_type',"Question" , array('id'=>'display_type','class' => 'form-control','readonly'=>true)) }}
                                                        </div>
                                                        <div class="@if($key>0) col-md-4 @else col-md-8 @endif ">
                                                            <div class="form-group mb-0">
                                                                <select class="display_qus_choice form-control" name="display_qus_choice" data-placeholder="Choose ...">
                                                                    <option value="">Choose ...</option>
                                                                    @foreach($display_logic as $key=>$value)
                                                                        @if($v1 == $key)
                                                                        <option selected value="{{$key}}">{{$value}}</option>
                                                                        @else 
                                                                        <option value="{{$key}}">{{$value}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                    @foreach($display_logic_matrix as $key=>$value) 
                                                                        <optgroup label="{{$value->question_name}}">
                                                                            <?php if($value!=null){
                                                                                if($value->qus_ans!=null){
                                                                                    $qusvalue1 = json_decode($value->qus_ans); 
                                                                                }else{
                                                                                    $qusvalue1=[];
                                                                                }
                                                                            }else{
                                                                                $qusvalue1=[];
                                                                            }
                                                                            $exiting_qus_matrix=$qusvalue1!=null ? explode(",",$qusvalue1->matrix_qus): []; $i=0; ?>
                                                                            @foreach($exiting_qus_matrix as $key1=>$qus) 
                                                                                @if($v1 == $value->id.'_'.$key1)
                                                                                    <option selected value="{{$value->id}}_{{$key1}}">{{$qus}} </option>
                                                                                @else 
                                                                                    <option value="{{$value->id}}_{{$key1}}">{{$qus}} </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </optgroup>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Get Qus Choice Details -->
                                                    <?php $qus_display=\App\Models\Questions::where(['id'=>$v1])->first();
                                                            $resp_logic_type_display=[];
                                                            $resp_logic_type_display_value=[];
                                                            if($qus_display!=null){
                                                                $qusvalue_display = json_decode($qus_display->qus_ans); 
                                                                switch ($qus_display->qus_type) {
                                                                    case 'single_choice':
                                                                        $resp_logic_type_display_value=explode(",",$qusvalue_display->choices_list);
                                                                        $resp_logic_type_display=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                        break;
                                                                    case 'multi_choice':
                                                                        $resp_logic_type_display_value=explode(",",$qusvalue_display->choices_list);
                                                                        $resp_logic_type_display=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                        break;
                                                                    case 'dropdown':
                                                                        $resp_logic_type_display_value=explode(",",$qusvalue_display->choices_list);
                                                                        $resp_logic_type_display=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                        break;
                                                                    case 'picturechoice':
                                                                        $resp_logic_type_display_value=json_decode($qusvalue_display->choices_list);
                                                                        $resp_logic_type_display=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                        break;
                                                                    case 'photo_capture':
                                                                        $resp_logic_type_display=['isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                        break;
                                                                    case 'open_qus':
                                                                        $resp_logic_type_display=['contains'=>'Contains','doesNotContain'=>'Does not Contain','startsWith'=>'Starts With','endsWith'=>'Ends With','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered','equalsString'=>'Equals','notEqualTo'=>'Not Equal To'];
                                                                        break; 
                                                                    case 'likert':
                                                                        $resp_logic_type_display_value=["1"=>1,"2"=>3,"3"=>3,"4"=>4,"5"=>5,"6"=>6,"7"=>7,"8"=>8,"9"=>9];
                                                                        $resp_logic_type_display=['lessThanForScale'=>'Less than','greaterThanForScale'=>'Greater than','equalToForScale'=>'Equal To','notEqualToForScale'=>'Not Equal To','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                        break;
                                                                    case 'rankorder':
                                                                        $resp_logic_type_display=['isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                        break;
                                                                    case 'rating':
                                                                        $resp_logic_type_display_value=["1"=>1,"2"=>3,"3"=>3,"4"=>4,"5"=>5];
                                                                        $resp_logic_type_display=['lessThanForScale'=>'Less than','greaterThanForScale'=>'Greater than','equalToForScale'=>'Equal To','notEqualToForScale'=>'Not Equal To','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                        break;
                                                                    case 'email':
                                                                        $resp_logic_type_display=['contains'=>'Contains','doesNotContain'=>'Does not Contain','startsWith'=>'Starts With','endsWith'=>'Ends With','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered','equalsString'=>'Equals','notEqualTo'=>'Not Equal To'];
                                                                        break;
                                                                    case 'matrix_qus':
                                                                        $resp_logic_type_display_value=explode(",",$qusvalue_display->matrix_choice);
                                                                        $resp_logic_type_display=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                        break;
                                                                }
                                                            }else{
                                                                $qusvalue_display=[];
                                                            }
                                                            // echo "<pre>"; print_r($resp_logic_type_display);
                                                            ?>
                                                    @if($qus_display!=null)
                                                    <div class="respondant_selection row">
                                                        <div class="col-md-4" >
                                                            <?php //echo (strval($logic_type_value[$key])); ?>
                                                            <select class="form-control logic_type_value_display" name="logic_type_value_display">
                                                                <option value="">Choose</option>
                                                                @foreach($resp_logic_type_display as $key1=>$value)
                                                                    @if($key1 == $vlogic)
                                                                    <option value="{{$key1}}" selected>{{$value}}</option>
                                                                    @else
                                                                    <option value="{{$key1}}">{{$value}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 choice_list_sec" style="@if($vlogic=='isAnswered' || $vlogic=='isNotAnswered') display:none; @endif">
                                                        @if($qus_display->qus_type=='email' || $qus_display->qus_type=='open_qus')
                                                            <input class="form-control logic_type_value_option" value="{{$vlogicoption}}" type="text" name="logic_type_value_option"/>
                                                        @elseif($qus_display->qus_type=='rankorder')
                                                            <input style="display:none;" class="form-control logic_type_value_option" value="{{$vlogicoption}}" type="text" name="logic_type_value_option"/>
                                                        @elseif($qus_display->qus_type=='picturechoice')
                                                            <select class="form-control logic_type_value_option" name="logic_type_value_option">
                                                                <option value="">Choose</option>
                                                                @foreach($resp_logic_type_display_value as $key=>$value)
                                                                    @if($key==$vlogicoption)
                                                                        <option selected value="{{$key}}">{{$value->text}}</option>
                                                                    @else 
                                                                        <option value="{{$key}}">{{$value->text}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <select class="form-control logic_type_value_option" name="logic_type_value_option">
                                                                <option value="">Choose</option>
                                                                @foreach($resp_logic_type_display_value as $key=>$value)
                                                                    @if($value==$vlogicoption || $key==$vlogicoption)
                                                                        <option selected value="{{$key}}">{{$value}}</option>
                                                                    @else 
                                                                        <option value="{{$key}}">{{$value}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="ss-logic-item-actions mb-3">
                                                                <button type="button" name="minus" class="removechoicelist_display">−</button>
                                                                <button type="button" name="add" class="addchoicelist_display">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                            @if(count($display_logic_DB1)<=0)
                                                <div class="logic_section_display_row">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            {{ Form::text('display_type',"Question" , array('id'=>'display_type','class' => 'form-control','readonly'=>true)) }}
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group mb-0">
                                                                <select class="display_qus_choice form-control" name="display_qus_choice" data-placeholder="Choose ...">
                                                                    <option value="">Choose ...</option>
                                                                    @foreach($display_logic as $key=>$value)
                                                                        <option value="{{$key}}">{{$value}}</option>
                                                                    @endforeach
                                                                    @foreach($display_logic_matrix as $key=>$value) 
                                                                        <optgroup label="{{$value->question_name}}">
                                                                            <?php $qusvalue1 = json_decode($value->qus_ans); 
                                                                            $exiting_qus_matrix=$qusvalue1!=null ? explode(",",$qusvalue1->matrix_qus): []; $i=0; ?>
                                                                            @foreach($exiting_qus_matrix as $key1=>$qus) 
                                                                                <option value="{{$value->id}}_{{$key1}}">{{$qus}}</option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                    </div>
                            </div>
                        @endif

                        <div id="skip_logic" class="tabcontent">
                            <input type="hidden" value="{{json_encode($skip_logic)}}" name="skip_qus" id="skip_qus"/>
                            <input type="hidden" value="{{json_encode($skip_logic_matrix)}}" name="skip_qus_matrix" id="skip_qus_matrix"/>
                            <p>When answering this question</p>
                            {{ Form::label('skip_type','If',['class'=>'form-label']) }}
                            <div id="logic_section_skip">
                                <?php 
                                    $skip_logic_DB = json_decode($currentQus->skip_logic); 
                                    if($skip_logic_DB!=null){
                                        $skip_logic_DB1=json_decode($skip_logic_DB->display_qus_choice_skip); 
                                        if($skip_logic_DB1!=null){
                                            $logic_type_value_skip=json_decode($skip_logic_DB->skiplogic_type_value_skip); 
                                            $logic_type_value_option_skip=json_decode($skip_logic_DB->logic_type_value_option_skip); 
                                            $skip_qus_choice_andor_skip=json_decode($skip_logic_DB->display_qus_choice_andor_skip); 
                                            $jump_type=$skip_logic_DB->jump_type;
                                        }else{
                                            $skip_logic_DB1=[]; $logic_type_value_skip=[];
                                            $logic_type_value_option_skip=[]; $skip_qus_choice_andor_skip=[];
                                            $jump_type='';
                                        }
                                    }else{
                                        $skip_logic_DB1=[]; $logic_type_value_skip=[];
                                        $logic_type_value_option_skip=[]; $skip_qus_choice_andor_skip=[];
                                        $jump_type='';

                                    }
                                ?>
                                @if($skip_logic_DB1!=null)
                                    @foreach($skip_logic_DB1 as $key=>$v1)
                                        <?php 
                                        // echo $key;
                                        // echo "<pre>"; print_r($skip_qus_choice_andor_skip[$key]);
                                        if($logic_type_value_skip){
                                            $vlogic_skip= $logic_type_value_skip[$key]; 
                                            $vlogicoption_skip= $logic_type_value_option_skip[$key]; 
                                            $andOrVal_skip=$skip_qus_choice_andor_skip[$key]; 
                                        }else{
                                            $vlogic_skip= ''; 
                                            $vlogicoption_skip= ''; 
                                            $andOrVal_skip=''; 
                                        }
                                        // echo $andOrVal_skip;
                                        ?>
                                        <div class="logic_section_skip_row">
                                            <div class="row">
                                                @if($key>0)
                                                <div class="col-md-4">
                                                    <select class="skip_qus_choice_andor form-control" name="skip_qus_choice_andor" data-placeholder="Choose ...">
                                                        <option value="and" @if($andOrVal_skip=='and') selected @endif>AND</option>
                                                        <option value="or" @if($andOrVal_skip=='or') selected @endif>OR</option>
                                                    </select>
                                                </div>
                                                @endif
                                                <div class="col-md-4">
                                                    {{ Form::text('skip_type',"Question" , array('id'=>'skip_type','class' => 'form-control','readonly'=>true)) }}
                                                </div>
                                                <div class="@if($key>0) col-md-4 @else col-md-8 @endif ">
                                                    <div class="form-group mb-0">
                                                        <select class="skip_qus_choice form-control" name="skip_qus_choice" data-placeholder="Choose ...">
                                                            <option value="">Choose ...</option>
                                                            @foreach($skip_logic as $key=>$value)
                                                                @if($v1 == $key)
                                                                <option selected value="{{$key}}">{{$value}}</option>
                                                                @else 
                                                                <option value="{{$key}}">{{$value}}</option>
                                                                @endif
                                                            @endforeach
                                                            @foreach($skip_logic_matrix as $key=>$value) 
                                                                <optgroup label="{{$value->question_name}}">
                                                                    <?php if($value!=null){
                                                                        if($value->qus_ans!=null){
                                                                            $qusvalue1 = json_decode($value->qus_ans); 
                                                                        }else{
                                                                            $qusvalue1=[];
                                                                        }
                                                                    }else{
                                                                        $qusvalue1=[];
                                                                    }
                                                                    $exiting_qus_matrix=$qusvalue1!=null ? explode(",",$qusvalue1->matrix_qus): []; $i=0; ?>
                                                                    @foreach($exiting_qus_matrix as $key1=>$qus) 
                                                                        @if($v1 == $value->id.'_'.$key1)
                                                                            <option selected value="{{$value->id}}_{{$key1}}">{{$qus}} </option>
                                                                        @else 
                                                                            <option value="{{$value->id}}_{{$key1}}">{{$qus}} </option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Get Qus Choice Details -->
                                            <?php $qus_skip=\App\Models\Questions::where(['id'=>$v1])->first();
                                                    $resp_logic_type_skip=[];
                                                    $resp_logic_type_skip_value=[];
                                                    if($qus_skip!=null){
                                                        $qusvalue_skip = json_decode($qus_skip->qus_ans); 
                                                        switch ($qus_skip->qus_type) {
                                                            case 'single_choice':
                                                                $resp_logic_type_skip_value=explode(",",$qusvalue_skip->choices_list);
                                                                $resp_logic_type_skip=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                break;
                                                            case 'multi_choice':
                                                                $resp_logic_type_skip_value=explode(",",$qusvalue_skip->choices_list);
                                                                $resp_logic_type_skip=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                break;
                                                            case 'dropdown':
                                                                $resp_logic_type_skip_value=explode(",",$qusvalue_skip->choices_list);
                                                                $resp_logic_type_skip=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                break;
                                                            case 'picturechoice':
                                                                $resp_logic_type_skip_value=json_decode($qusvalue_skip->choices_list);
                                                                $resp_logic_type_skip=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                break;
                                                            case 'photo_capture':
                                                                $resp_logic_type_skip=['isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                break;
                                                            case 'open_qus':
                                                                $resp_logic_type_skip=['contains'=>'Contains','doesNotContain'=>'Does not Contain','startsWith'=>'Starts With','endsWith'=>'Ends With','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered','equalsString'=>'Equals','notEqualTo'=>'Not Equal To'];
                                                                break; 
                                                            case 'likert':
                                                                $resp_logic_type_skip_value=["1"=>1,"2"=>3,"3"=>3,"4"=>4,"5"=>5,"6"=>6,"7"=>7,"8"=>8,"9"=>9];
                                                                $resp_logic_type_skip=['lessThanForScale'=>'Less than','greaterThanForScale'=>'Greater than','equalToForScale'=>'Equal To','notEqualToForScale'=>'Not Equal To','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                break;
                                                            case 'rankorder':
                                                                $resp_logic_type_skip=['isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                break;
                                                            case 'rating':
                                                                $resp_logic_type_skip_value=["1"=>1,"2"=>3,"3"=>3,"4"=>4,"5"=>5];
                                                                $resp_logic_type_skip=['lessThanForScale'=>'Less than','greaterThanForScale'=>'Greater than','equalToForScale'=>'Equal To','notEqualToForScale'=>'Not Equal To','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                break;
                                                            case 'email':
                                                                $resp_logic_type_skip=['contains'=>'Contains','doesNotContain'=>'Does not Contain','startsWith'=>'Starts With','endsWith'=>'Ends With','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered','equalsString'=>'Equals','notEqualTo'=>'Not Equal To'];
                                                                break;
                                                            case 'matrix_qus':
                                                                $resp_logic_type_skip_value=explode(",",$qusvalue_skip->matrix_choice);
                                                                $resp_logic_type_skip=['isSelected'=>'Respondent selected','isNotSelected'=>'Respondent has not selected','isAnswered'=>'Is Answered','isNotAnswered'=>'Is Not Answered'];
                                                                break;
                                                        }
                                                    }else{
                                                        $qusvalue_skip=[];
                                                    }
                                                        ?>
                                            @if($qus_skip!=null)
                                            <div class="respondant_selection row">
                                                <div class="col-md-4" >
                                                    <?php //echo (strval($logic_type_value[$key])); ?>
                                                    <select class="form-control logic_type_value_skip" name="logic_type_value_skip">
                                                        <option value="">Choose</option>
                                                        @foreach($resp_logic_type_skip as $key1=>$value)
                                                            @if($key1 == $vlogic_skip)
                                                            <option value="{{$key1}}" selected>{{$value}}</option>
                                                            @else
                                                            <option value="{{$key1}}">{{$value}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 choice_list_sec" style="@if($vlogic_skip=='isAnswered' || $vlogic_skip=='isNotAnswered') display:none; @endif">
                                                @if($qus_skip->qus_type=='email' || $qus_skip->qus_type=='open_qus')
                                                    <input class="form-control skip_logic_type_value_option" value="{{$vlogicoption_skip}}" type="text" name="skip_logic_type_value_option"/>
                                                @elseif($qus_skip->qus_type=='rankorder')
                                                    <input style="display:none;" class="form-control skip_logic_type_value_option" value="{{$vlogicoption_skip}}" type="text" name="skip_logic_type_value_option"/>
                                                @elseif($qus_skip->qus_type=='picturechoice')
                                                    <select class="form-control skip_logic_type_value_option" name="skip_logic_type_value_option">
                                                        <option value="">Choose</option>
                                                        @foreach($resp_logic_type_skip_value as $key=>$value)
                                                            @if($key==$vlogicoption_skip)
                                                                <option selected value="{{$key}}">{{$value->text}}</option>
                                                            @else 
                                                                <option value="{{$key}}">{{$value->text}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select class="form-control skip_logic_type_value_option" name="skip_logic_type_value_option">
                                                        <option value="">Choose</option>
                                                        @foreach($resp_logic_type_skip_value as $key=>$value)
                                                            @if($value==$vlogicoption_skip || $key==$vlogicoption_skip)
                                                                <option selected value="{{$key}}">{{$value}}</option>
                                                            @else 
                                                                <option value="{{$key}}">{{$value}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="ss-logic-item-actions mb-3">
                                                        <button type="button" name="minus" class="removechoicelist_skip">−</button>
                                                        <button type="button" name="add" class="addchoicelist_skip">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                                @if(is_countable($skip_logic_DB1) && count($skip_logic_DB1)<=0)
                                    <div class="logic_section_skip_row">
                                        <div class="row">
                                            <div class="col-md-4">
                                                {{ Form::text('skip_type',"Question" , array('id'=>'skip_type','class' => 'form-control','readonly'=>true)) }}
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group mb-0">
                                                    <select class="skip_qus_choice form-control" name="skip_qus_choice" data-placeholder="Choose ...">
                                                        <option value="">Choose ...</option>
                                                        @foreach($skip_logic as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                        @foreach($skip_logic_matrix as $key=>$value) 
                                                            <optgroup label="{{$value->question_name}}">
                                                                <?php $qusvalue1 = json_decode($value->qus_ans); 
                                                                $exiting_qus_matrix=$qusvalue1!=null ? explode(",",$qusvalue1->matrix_qus): []; $i=0; ?>
                                                                @foreach($exiting_qus_matrix as $key1=>$qus) 
                                                                    <option value="{{$value->id}}_{{$key1}}">{{$qus}}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                <p>else d</p>
                                @endif
                                <div class="ss-logic-row c_jump_to">
                                    <p style="margin-top: 6px;">Then Jump to</p>
                                    <select class="form-control jump_type" name="jump_type">
                                        <option value="">--Select--</option>
                                        @foreach($jump_to as $key=>$value)
                                            <option value="{{$key}}" @if($jump_type == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                        @foreach($jump_to_tq as $key=>$value)
                                            <option value="{{$key}}"  @if($jump_type == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="below_space"></div>
                    @endif
                    <input type="button" id="update_qus" onclick="triggersubmit('{{$currentQus->qus_type}}')" value="Submit" class="btn  btn-primary">
                    <input type="submit" id="update_qus_final" value="Submit" class="btn  btn-primary">
                    </div>
                   
                    {{Form::close()}}
                @endif
                @if(!$currentQus)
                <div class="ss-dashboard--contents px-5 px-xl-11 pb-7">
                    <div class="ss-dashboard--inner-container px-5 px-xl-6 py-5 py-xl-7 h-100 bg-white">
                        <div class="ss-dashboard--contents ss-no-survey--container px-11 fx-column fx-ai--center fx-jc--center">
                            <div class="ss-no-survey--wrapper d-flex flex-column align-items-center justify-content-center px-7 w-100 h-100">
                                <svg width="126" height="147" viewBox="0 0 126 147" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-6">
                                    <path d="M114.306 12.9721C114.306 12.9721 114.306 12.9721 114.001 12.3962C113.696 11.8203 112.995 12.4871 112.995 12.4871C112.995 12.4871 113.117 12.1234 112.812 11.5476C112.507 10.9717 112.141 12.5478 112.141 12.5478C112.141 12.5478 112.233 11.8507 111.44 10.608C110.648 9.36529 110.617 13.3358 110.617 13.3358C110.617 13.3358 110.709 17.5185 114.306 12.9721Z" fill="#19AF99"></path>
                                    <path d="M110.648 13.3359C110.648 12.6994 110.678 12.0932 110.77 11.4567C110.8 11.1536 110.831 10.7292 111.044 10.4868C111.105 10.3958 111.166 10.3958 111.227 10.4565C111.288 10.5171 111.318 10.5777 111.379 10.6383C111.501 10.8202 111.623 11.0323 111.715 11.2445C111.898 11.6082 112.111 12.0932 112.05 12.5175C112.05 12.6084 112.172 12.6084 112.172 12.5478C112.233 12.2447 112.324 11.9113 112.477 11.6385C112.507 11.6082 112.568 11.487 112.599 11.487C112.69 11.487 112.782 11.7598 112.812 11.8204C112.873 12.0022 112.965 12.275 112.904 12.4872C112.873 12.5478 112.965 12.6084 113.025 12.5478C113.208 12.3659 113.605 12.0932 113.849 12.3053C114.001 12.4569 114.092 12.7297 114.214 12.9115C114.245 12.9418 114.245 12.9721 114.275 13.0024C114.306 13.0934 114.428 13.0024 114.397 12.9418C114.367 12.8812 114.336 12.8206 114.306 12.76C114.184 12.5478 114.092 12.2447 113.849 12.1235C113.544 12.0022 113.178 12.2447 112.965 12.4569C112.995 12.4872 113.056 12.4872 113.086 12.5175C113.147 12.275 112.965 11.0929 112.568 11.4263C112.385 11.5476 112.324 11.8204 112.233 12.0325C112.172 12.2144 112.111 12.3659 112.08 12.5478C112.111 12.5478 112.172 12.5478 112.202 12.5781C112.233 12.2144 112.08 11.7901 111.928 11.4567C111.776 11.1233 111.623 10.7595 111.379 10.4868C111.318 10.3958 111.196 10.3352 111.074 10.3352C110.8 10.3958 110.739 10.8808 110.709 11.0929C110.617 11.5476 110.587 12.0022 110.556 12.4872C110.526 12.7903 110.526 13.0934 110.526 13.3965C110.495 13.4268 110.648 13.4268 110.648 13.3359Z" fill="black"></path><path d="M111.135 69.0747L63 55.678L16.2668 68.8626L62.2379 82.0774L111.135 69.0747Z" fill="#364250"></path>
                                    <path d="M63 131.755V91.2916" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M63 135.452V141.029" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M109.215 89.0486V133.058L62.9999 146L15.2607 133.513L16.0229 100.354" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M16.2668 89.0486V95.1712" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M73.0294 120.328C74.5952 120.328 75.8645 118.808 75.8645 116.933C75.8645 115.059 74.5952 113.539 73.0294 113.539C71.4637 113.539 70.1943 115.059 70.1943 116.933C70.1943 118.808 71.4637 120.328 73.0294 120.328Z" fill="black"></path>
                                    <path d="M99.5817 112.023C101.147 112.023 102.417 110.503 102.417 108.628C102.417 106.754 101.147 105.234 99.5817 105.234C98.0159 105.234 96.7466 106.754 96.7466 108.628C96.7466 110.503 98.0159 112.023 99.5817 112.023Z" fill="black"></path>
                                    <path d="M81.9617 124.45C81.9617 124.45 82.6628 116.903 88.4854 116.903C92.5703 116.903 92.5703 122.177 92.5703 122.177" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M93.6982 73.5908L97.3259 72.6209" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M101.289 71.7116L111.135 69.0747L63 55.678L16.2668 68.8626L62.2379 82.0774L89.3998 74.7426" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M65.6523 84.1386L77.267 92.1099L122.506 78.8647L112.629 70.5903" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M80.803 47.2218L124 58.5272L112.629 66.832" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M60.3173 53.9808L48.977 44.9789L39.5876 47.2218" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M31.2044 49.4645L2.45728 57.0419L14.1329 67.5896" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M33.4297 49.4647L37.6061 48.7372" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M14.1329 70.5903L2 80.3802L48.977 92.4433L60.3173 83.6536" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M58.0919 55.769C58.0919 54.9507 58.1529 54.1323 58.2443 53.314C58.7321 48.5251 60.5002 43.8574 64.89 41.0387C75.4987 34.2494 81.4432 44.5849 75.2853 48.1917C65.6521 53.8595 54.2813 36.5226 50.4707 29.7333" stroke="black" stroke-miterlimit="10" stroke-dasharray="6 6"></path>
                                    <path d="M60.3172 69.681C59.9514 68.6504 58.1528 62.8916 58.0918 56.5873" stroke="white" stroke-miterlimit="10" stroke-dasharray="6 6"></path>
                                    <path d="M47.3003 24.6412C48.1538 24.429 49.0684 24.3381 49.9524 24.3078C51.3547 24.2775 53.1229 24.3987 54.0679 25.5808C54.769 26.4901 54.7385 27.6721 53.7021 28.248C52.6961 28.8239 51.3547 28.7633 50.3183 28.3692C48.6416 27.7327 47.6661 26.2173 47.4222 24.4896C47.3917 24.3381 47.1783 24.3987 47.2088 24.5503C47.4527 26.187 48.3063 27.6418 49.8305 28.3995C50.9584 28.9451 52.3607 29.0967 53.5192 28.6117C54.5252 28.1874 55.0739 27.2478 54.6776 26.187C54.0984 24.6715 52.4217 24.1865 50.9584 24.0956C49.739 24.035 48.4587 24.1562 47.2698 24.429C47.0869 24.4593 47.1478 24.6715 47.3003 24.6412Z" fill="#0D1B1E"></path>
                                    <path d="M47.1478 24.5502C47.4527 25.2473 47.6966 26.0051 47.91 26.7325C48.2758 28.0661 48.6111 29.4906 48.4282 30.8849C48.3368 31.4911 48.1538 32.0973 47.6966 32.5216C47.2088 33.0065 46.4162 33.1884 45.7456 33.1278C44.2213 32.9762 43.825 31.4001 43.9774 30.0968C44.2213 27.9146 45.6541 25.9141 47.3612 24.5805C47.4832 24.4896 47.3003 24.338 47.2088 24.429C45.5626 25.702 44.2518 27.5205 43.8555 29.5513C43.6116 30.8243 43.6726 32.5519 45.0444 33.1581C46.2943 33.7036 47.849 33.1278 48.3977 31.9154C48.9769 30.5818 48.7026 28.9754 48.3977 27.6115C48.1538 26.5506 47.8185 25.4898 47.3917 24.4593C47.3308 24.3684 47.1174 24.429 47.1478 24.5502Z" fill="#0D1B1E"></path>
                                    <path d="M46.8126 25.7323C47.7891 25.7323 48.5807 24.9453 48.5807 23.9744C48.5807 23.0035 47.7891 22.2165 46.8126 22.2165C45.8361 22.2165 45.0444 23.0035 45.0444 23.9744C45.0444 24.9453 45.8361 25.7323 46.8126 25.7323Z" fill="#0D1B1E"></path>
                                    <path d="M94.0641 35.977C103.779 35.977 111.654 28.1472 111.654 18.4885C111.654 8.82988 103.779 1 94.0641 1C84.3495 1 76.4744 8.82988 76.4744 18.4885C76.4744 28.1472 84.3495 35.977 94.0641 35.977Z" fill="white"></path>
                                    <path d="M111.196 22.0044C113.483 22.0044 115.312 20.1858 115.312 17.9126C115.312 15.6394 113.33 13.8209 111.044 13.8209C111.044 13.8209 111.745 15.9728 111.654 18.0642C111.562 20.1555 111.196 22.0044 111.196 22.0044Z" fill="white"></path>
                                    <path d="M94.0641 35.977C103.779 35.977 111.654 28.1472 111.654 18.4885C111.654 8.82988 103.779 1 94.0641 1C84.3495 1 76.4744 8.82988 76.4744 18.4885C76.4744 28.1472 84.3495 35.977 94.0641 35.977Z" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M84.2174 32.1278C84.5541 32.1278 84.827 31.8564 84.827 31.5217C84.827 31.1869 84.5541 30.9155 84.2174 30.9155C83.8806 30.9155 83.6077 31.1869 83.6077 31.5217C83.6077 31.8564 83.8806 32.1278 84.2174 32.1278Z" fill="black"></path>
                                    <path d="M88.7291 31.3094C89.0658 31.3094 89.3388 31.038 89.3388 30.7032C89.3388 30.3684 89.0658 30.097 88.7291 30.097C88.3924 30.097 88.1194 30.3684 88.1194 30.7032C88.1194 31.038 88.3924 31.3094 88.7291 31.3094Z" fill="black"></path>
                                    <path d="M85.6196 32.1883C85.6196 32.1883 84.9794 36.2195 86.4122 35.4618C87.8755 34.704 88.3327 33.2188 88.3327 33.2188C88.3327 33.2188 87.1743 31.3396 85.6196 32.1883Z" fill="#E6823A"></path>
                                    <path d="M114.855 16.0941C114.855 16.0941 116.989 16.7002 117.294 17.3064C117.598 17.9126 115.312 17.7611 115.312 17.7611" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M85.5282 32.1581C85.4063 32.9764 85.3148 33.8251 85.4063 34.6131C85.4368 34.9768 85.5282 35.5224 85.955 35.6437C86.1684 35.7043 86.3818 35.6133 86.5647 35.5224C86.961 35.3102 87.3268 35.0072 87.6317 34.6738C87.9975 34.2797 88.3024 33.7645 88.4853 33.2492C88.5158 33.0977 88.3024 33.0371 88.2719 33.1886C88.15 33.5523 87.9366 33.916 87.6927 34.2494C87.4488 34.5828 87.1439 34.8859 86.8391 35.0981C86.6562 35.2193 86.3513 35.4618 86.1074 35.4315C85.7721 35.4012 85.7112 34.8556 85.6807 34.5828C85.6197 34.0979 85.6502 33.5826 85.6807 33.0977C85.7112 32.7946 85.7416 32.4915 85.7721 32.1884C85.7721 32.0671 85.5587 32.0065 85.5282 32.1581Z" fill="black"></path>
                                    <path d="M80.6811 11.1538C80.6811 11.1538 81.4433 7.51666 79.8276 7.21356C79.3093 7.21356 80.4373 10.396 79.9495 12.0024" fill="white"></path><path d="M80.8031 11.1841C80.8945 10.7901 80.925 10.3961 80.9555 10.0021C81.0165 9.33527 81.0165 8.57752 80.7726 7.94102C80.6811 7.66824 80.4982 7.42578 80.2544 7.27424C80.1019 7.18331 79.8276 7.03175 79.6752 7.18329C79.5532 7.33484 79.5837 7.60762 79.5837 7.78948C79.6142 8.15319 79.6752 8.54721 79.7361 8.91092C79.8886 9.88082 80.1019 11.0023 79.8276 11.9722C79.7971 12.1237 80.0105 12.1843 80.041 12.0328C80.2544 11.275 80.1629 10.4567 80.0715 9.66866C79.98 8.97154 79.7971 8.27444 79.7971 7.57733C79.7971 7.51671 79.7666 7.36515 79.8276 7.33484C79.8581 7.30453 79.98 7.36515 80.041 7.39546C80.2849 7.5167 80.4373 7.75917 80.5287 8.00165C80.7726 8.57752 80.7726 9.24433 80.7116 9.88083C80.6811 10.3052 80.6507 10.7295 80.5592 11.1235C80.5592 11.275 80.7726 11.3357 80.8031 11.1841Z" fill="#111110"></path>
                                    <path d="M79.7666 12.8208C79.7666 12.8208 78.852 9.21396 77.2668 9.6686C76.8095 9.88077 79.2178 12.2752 79.4922 13.9119" fill="white"></path>
                                    <path d="M79.8886 12.7905C79.7971 12.3965 79.6447 12.0025 79.4923 11.6388C79.2484 11.0326 78.9131 10.3658 78.4253 9.91114C78.2119 9.72928 77.968 9.54743 77.6632 9.51712C77.4803 9.48681 77.145 9.48682 77.1145 9.72929C77.084 9.94146 77.2669 10.1536 77.3583 10.3355C77.5717 10.6689 77.7851 10.972 77.9985 11.3054C78.5473 12.0934 79.2179 12.9724 79.3703 13.9726C79.4008 14.1242 79.6142 14.0635 79.5837 13.912C79.4618 13.1239 79.0045 12.4268 78.5777 11.76C78.1814 11.1841 77.7242 10.6386 77.4193 10.0021C77.3888 9.94147 77.3279 9.88084 77.3583 9.78991C77.3583 9.7596 77.3583 9.7596 77.3583 9.78991C77.3888 9.7596 77.5413 9.75959 77.5717 9.75959C77.8461 9.75959 78.09 9.91114 78.3034 10.0627C78.7607 10.487 79.0655 11.0932 79.3094 11.6691C79.4618 12.0631 79.6142 12.4571 79.7057 12.8512C79.7057 13.0027 79.9191 12.9421 79.8886 12.7905Z" fill="#111110"></path>
                                    <path d="M79.6448 13.7301C79.6448 13.7301 78.8827 8.75933 76.9317 7.15294C76.1391 6.42551 80.6508 5.78901 79.9192 12.7905" fill="white"></path>
                                    <path d="M79.7668 13.6998C79.6448 12.8511 79.4314 12.0024 79.1875 11.1841C78.7912 9.85048 78.3035 8.42594 77.3585 7.36511C77.2365 7.24387 77.0536 7.12264 76.9927 6.97109C76.9927 6.94078 76.9927 6.94078 76.9927 6.91047C77.0841 6.81954 77.2975 6.78924 77.4499 6.81955C78.1511 6.84986 78.7303 7.36511 79.0961 7.91068C80.0106 9.30491 79.9801 11.1841 79.7972 12.7602C79.7972 12.9117 80.0106 12.9117 80.0411 12.7602C80.1936 11.2144 80.224 9.45646 79.4314 8.03192C79.0656 7.36512 78.4559 6.75892 77.6938 6.60738C77.4195 6.54676 76.6573 6.54675 76.7488 7.0014C76.7793 7.09232 76.8402 7.15295 76.9012 7.21356C77.1756 7.48635 77.4194 7.72883 77.6328 8.03192C78.0901 8.72904 78.4254 9.48676 78.6998 10.2748C79.0961 11.3963 79.401 12.548 79.5839 13.6998C79.5534 13.9119 79.7972 13.8513 79.7668 13.6998Z" fill="#111110"></path>
                                    <path d="M111.044 13.8209C113.33 13.8209 115.312 15.6394 115.312 17.9126C115.312 20.1858 113.483 22.0044 111.196 22.0044" stroke="black" stroke-miterlimit="10"></path>
                                    <path d="M116.653 15.5487C116.653 15.5487 116.653 15.5487 116.684 14.791C116.714 14.0333 115.617 14.306 115.617 14.306C115.617 14.306 115.952 14.0029 115.983 13.2755C116.013 12.5481 114.733 13.8514 114.733 13.8514C114.733 13.8514 115.22 13.2149 115.19 11.5479C115.159 9.88086 112.751 13.7302 112.751 13.7302C112.751 13.7302 111.928 15.2153 112.568 15.9124C113.026 16.3671 114.123 16.4883 116.653 15.5487Z" fill="#19AF99"></path>
                                    <path d="M112.843 13.7603C113.239 13.1238 113.635 12.5176 114.092 11.972C114.245 11.7902 114.367 11.6386 114.55 11.4871C114.641 11.3962 114.794 11.2446 114.946 11.2143C115.068 11.184 115.098 11.2749 115.129 11.3659C115.22 11.7296 115.159 12.1539 115.098 12.5479C115.038 12.9722 114.977 13.4875 114.702 13.8512C114.641 13.9118 114.763 14.0028 114.824 13.9422C115.098 13.6694 115.373 13.3663 115.739 13.2147C115.8 13.1844 115.891 13.1238 115.952 13.1844C115.983 13.2147 115.983 13.2753 115.983 13.3056C115.983 13.4572 115.952 13.5784 115.922 13.73C115.861 13.9422 115.8 14.1543 115.647 14.3059C115.586 14.3665 115.647 14.4271 115.708 14.4271C115.983 14.3665 116.44 14.3059 116.623 14.5786C116.714 14.6999 116.684 14.8514 116.684 14.9727C116.684 15.1242 116.684 15.2758 116.653 15.4273C116.653 15.4879 116.653 15.5486 116.653 15.6092C116.653 15.7001 116.775 15.7001 116.806 15.6092C116.806 15.5182 116.806 15.397 116.806 15.3061C116.806 15.0333 116.897 14.6696 116.684 14.4574C116.44 14.2149 115.983 14.2452 115.678 14.3059C115.708 14.3362 115.708 14.3968 115.739 14.4271C115.952 14.2452 116.044 13.9422 116.074 13.6694C116.104 13.4875 116.196 13.0329 115.891 13.0329C115.647 13.0329 115.373 13.2753 115.22 13.4269C115.068 13.5481 114.916 13.6997 114.763 13.8512C114.794 13.8815 114.824 13.9118 114.885 13.9422C115.129 13.6088 115.22 13.1541 115.281 12.7601C115.342 12.3358 115.403 11.8811 115.342 11.4568C115.312 11.3355 115.281 11.184 115.159 11.1234C114.885 11.0021 114.519 11.4265 114.367 11.578C114.001 11.972 113.696 12.3964 113.391 12.851C113.178 13.1541 112.995 13.4572 112.812 13.7603C112.66 13.7603 112.782 13.8209 112.843 13.7603Z" fill="black"></path>
                                </svg>
                                <h4 class="ss-text ss-text__size--h4 ss-text__weight--normal ss-text__color--grey">No questions here yet!</h4>
                                <div class="row pt-9">
                                    <div class="ss-dashboard__no-survey col-12 d-flex flex-column align-items-center justify-content-center">
                                        <div class="position--relative">
                                            <a href="#" data-url="{{route('survey.questiontype',$survey->id)}}" data-ajax-popup="true" data-bs-toggle="tooltip" title="Choose Question Type" data-title="Choose Question Type"   class="ss-button ss-button__primary mb--sm" >
                                                Add a New Question
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
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>

<style>
div#survey-table_wrapper .row {
    width: 100%;
}

</style>

@include('admin.layout.footer')
    @stack('adminside-js')
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
    var id=$(this).parent();
    const files = e.target.files[0];
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
    // Display Logic 
    let emptyVal='';
    let display_qus_choice=[];
    let display_qus_choice_andor =[''];
    let logic_type_value=[];
    let logic_type_value_option=[];

    $('.display_qus_choice').each(function(){
        if($(this).val()==''){
            emptyVal=1;
        }
        display_qus_choice.push($(this).val())
    });
    
    $('.display_qus_choice_andor').each(function(){
        if($(this).val()==''){
            emptyVal=1;
        }
        display_qus_choice_andor.push($(this).val())
    });
    $('.logic_type_value_display').each(function(){
        if($(this).val()==''){
            emptyVal=1;
        }
        logic_type_value.push($(this).val())
    });
    $('.logic_type_value_option').each(function(){
        logic_type_value_option.push($(this).val())
    });
    if(display_qus_choice.length==1){
        if(display_qus_choice[0]==''){
            emptyVal='';
        }
    }
    if(emptyVal!=''){
        Swal.fire("Warning", 'Invalid display logic settings', "warning") ;
        return false;
    }
    $('#display_logic_type_value_display').val(JSON.stringify(logic_type_value));
    $('#logic_type_value_option_display').val(JSON.stringify(logic_type_value_option));
    $('#display_qus_choice_andor_display').val(JSON.stringify(display_qus_choice_andor));
    $('#display_qus_choice_display').val(JSON.stringify(display_qus_choice));
    
    // Display Logic
    // Skip Logic 
    let emptyVal_skip='';
    let skip_qus_choice=[];
    let skip_qus_choice_andor =[''];
    let skip_logic_type_value=[];
    let skip_logic_type_value_option=[];

    $('.skip_qus_choice').each(function(){
        if($(this).val()==''){
            emptyVal_skip=1;
        }
        skip_qus_choice.push($(this).val())
    });
    
    $('.skip_qus_choice_andor').each(function(){
        if($(this).val()==''){
            emptyVal_skip=1;
        }
        skip_qus_choice_andor.push($(this).val())
    });
    $('.logic_type_value_skip').each(function(){
        if($(this).val()==''){
            emptyVal_skip=1;
        }
        skip_logic_type_value.push($(this).val())
    });
    $('.skip_logic_type_value_option').each(function(){
        skip_logic_type_value_option.push($(this).val())
    });
    if(skip_qus_choice.length==1){
        if(skip_qus_choice[0]==''){
            emptyVal_skip='';
        }
    }
    console.log(emptyVal_skip,'emptyVal_skip')
    if(emptyVal_skip!=''){
        Swal.fire("Warning", 'Invalid skip logic settings', "warning") ;
        return false;
    }
    $('#skiplogic_type_value_skip').val(JSON.stringify(skip_logic_type_value));
    $('#logic_type_value_option_skip').val(JSON.stringify(skip_logic_type_value_option));
    $('#display_qus_choice_andor_skip').val(JSON.stringify(skip_qus_choice_andor));
    $('#display_qus_choice_skip').val(JSON.stringify(skip_qus_choice));

    
    // Skip Logic
    

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
    let pagetype=$('#pagetype').val();
    window.location.href=url+"?pagetype="+pagetype;
}
function qustype(type){
    let qusset={'welcome_page':'Welcome Page','single_choice':'Single Choice','multi_choice':'Multi Choice','open_qus':'Open Questions','likert':'Likert scale','rankorder':'Rank Order','rating':'Rating','dropdown':'Dropdown','picturechoice':'Picture Choice','photo_capture':'Photo Capture','email':'Email','matrix_qus':'Matrix Question','thank_you':'Thank You Page'};
}
$('input[type=radio][name=open_qus_choice]').change(function() {
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
    if($('#pagetype').val()=='editor'){
        $('#pagetype').val('editor');
        $('#preview_content').css('display','none');
        $('#qus_content').css('display','block');
    }else if($('#pagetype').val()=='preview'){
        $('#pagetype').val('preview');
        $('#preview_content').css('display','block');
        $('#qus_content').css('display','none');
    }
        
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
    getImgDataweclome();
})
function getImgDataweclome() {
    const chooseFile = document.getElementById("welcome_image");
    const imgPreview = document.getElementById("imgPreview");
    const files = chooseFile.files[0];
  if (files) {
    const fileReader = new FileReader();
    fileReader.readAsDataURL(files);
    fileReader.addEventListener("load", function () {
      $('.exitingImg').css('display','flex');
      $('#existing_image').attr('src',this.result);
      $('#existing_image').css('display',"block");
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
const imgPreview = document.getElementById("imgPreviewthanksyou");
  const files = chooseFile.files[0];
  if (files) {
    const fileReader = new FileReader();
    fileReader.readAsDataURL(files);
    fileReader.addEventListener("load", function () {
    //   imgPreview.style.display = "block";
    //   imgPreview.innerHTML = '<img id="preview_image" src="' + this.result + '" />';
      $('.exitingImg').css('display','flex');
      $('#existing_image_thankyou').attr('src',this.result);
      $('#existing_image_thankyou').css('display',"block");
      $('#trigger_thankyou_image').css('display','none');
      $('#ss_draft_remove_image_thankyou').css('display','block');

    });    
  }
}
$('#ss_draft_remove_image_thankyou').click(function(){
    $('#existing_image_thankyou').css('display','none');
    $('#trigger_thankyou_image').css('display','inline-block');
    $('#ss_draft_remove_image_thankyou').css('display','none');
    $('#imgPreviewthanksyou').css('display','none');

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
$('form').bind("keypress", function(e) {
  if (e.keyCode == 13) {               
    e.preventDefault();
    return false;
  }
});
$('#preview_qus').click(function(){
    $('#pagetype').val('preview');
    let url=$('#preview_qus').data('url');
    window.location.href=url+"?pagetype=preview";
    // $('#preview_content').css('display','block');
    // $('#qus_content').css('display','none');
});

$('#back_editor').click(function(){
    $('#pagetype').val('editor');
    $('#preview_content').css('display','none');
    $('#qus_content').css('display','block');

});
function openLogic(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
// Dispaly Logic
$("html body").delegate('.display_qus_choice', "change", function() {    
    let val=$(this).val();
    let split_val=val.split('_');
    val=split_val[0];
    let parentv=$(this).parent().parent().parent();
    parentv.siblings().remove()
    let url="{{route('survey.getqus')}}?qus_id="+val;
    $.ajax({url: url, success: function(result){
        var optionv=result?.resp_logic_type;
        let textDiv='<div class="respondant_selection row"><div class="col-md-4"><select class="form-control logic_type_value_display" name="logic_type_value_display"><option value="">Choose</option>';
        Object.entries(optionv).forEach(([key, value]) => {
            textDiv+='<option value="'+key+'">'+value+'</option>';
        });
        textDiv+='</select></div>';
        if(result?.qus_type=='single_choice' || result?.qus_type=='multi_choice' || result?.qus_type =='dropdown'){
            let choice_list=JSON.parse(result?.qus?.qus_ans);
            optionv=choice_list?.choices_list.split(',');
            textDiv+='<div class="col-md-4 choice_list_sec"><select class="form-control logic_type_value_option" name="logic_type_value_option"><option value="">Choose</option>';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+value+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }else if(result?.qus_type=='picturechoice'){
            let choice_list=JSON.parse(result?.qus?.qus_ans);
            optionv=JSON.parse(choice_list?.choices_list);
            textDiv+='<div class="col-md-4 choice_list_sec"><select class="form-control logic_type_value_option" name="logic_type_value_option"><option value="">Choose</option>';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+key+'">'+value.text+'</option>';
            });
            textDiv+='</select>';
        }
        else if(result?.qus_type=='matrix_qus'){
            let choice_list=JSON.parse(result?.qus?.qus_ans);
            optionv=choice_list?.matrix_choice.split(',');
            textDiv+='<div class="col-md-4 choice_list_sec"><select class="form-control logic_type_value_option" name="logic_type_value_option"><option value="">Choose</option>';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+value+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }

        else if(result?.qus_type=='likert'){
            optionv={"1":1,"2":3,"3":3,"4":4,"5":5,"6":6,"7":7,"8":8,"9":9};
            textDiv+='<div class="col-md-4 choice_list_sec"><select class="form-control logic_type_value_option" name="logic_type_value_option"><option value="">Choose</option>';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+key+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }
        else if(result?.qus_type=='rankorder' || result?.qus_type=='photo_capture'){
            textDiv+='<div class="col-md-4 choice_list_sec"><input style="display:none;" class="form-control logic_type_value_option" type="text" name="logic_type_value_option"/>';
        }
        else if(result?.qus_type=='rating'){
            optionv={"1":1,"2":3,"3":3,"4":4,"5":5};
            textDiv+='<div class="col-md-4 choice_list_sec"><select class="form-control logic_type_value_option" name="logic_type_value_option"><option value="">Choose</option>';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+key+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }
        else if(result?.qus_type=='open_qus' || result?.qus_type=='email'){
            textDiv+='<div class="col-md-4 choice_list_sec"><input class="form-control logic_type_value_option" type="text" name="logic_type_value_option"/>';
        }
        
        textDiv+='</div><div class="col-md-4"><div class="ss-logic-item-actions mb-3"><button type="button" name="minus" class="removechoicelist_display">−</button><button type="button" name="add" class="addchoicelist_display">+</button> </div></div></div>';
        parentv.after(textDiv);

    }});
});
$("html body").delegate('.removechoicelist_display', "click", function() {  
    if( document.getElementById("logic_section_display").children.length <=1){
        $(this).parent().parent().parent().remove();
    }else{
        $(this).parent().parent().parent().parent().remove();
    }
    
});
$("html body").delegate('.addchoicelist_display', "click", function() {  
    // $(this).parent().parent().remove();  
    let appendDiv='<div class="logic_section_display_row"><div class="row"><div class="col-md-4"><select class="display_qus_choice_andor form-control" name="display_qus_choice_andor" data-placeholder="Choose ..."><option value="and">AND</option><option value="or">OR</option></select></div><div class="col-md-4"><input id="display_type" class="form-control" readonly="" name="display_type" type="text" value="Question"></div><div class="col-md-4"><div class="form-group mb-0"><select class="display_qus_choice form-control" name="display_qus_choice" data-placeholder="Choose ..."><option value="">Choose ...</option>';
    let display_qus=$('#display_qus').val();
    display_qus=JSON.parse(display_qus);
    Object.entries(display_qus).forEach(([key, value]) => {
        appendDiv+='<option value="'+key+'">'+value+'</option>';
    });
    let display_qus_matrix=$('#display_qus_matrix').val();
    display_qus_matrix=JSON.parse(display_qus_matrix);
    Object.entries(display_qus_matrix).forEach(([key, value]) => {
        appendDiv+='<optgroup label="'+value.question_name+'">';
        let option1=JSON.parse(value.qus_ans);
        option1=option1?.matrix_qus.split(',');
        Object.entries(option1).forEach(([key, value1]) => {
            appendDiv+='<option value="'+value.id+'_'+key+'">'+value1+'</option>';
        });
        appendDiv+='</optgroup>';
    });
    appendDiv+='</select></div></div></div></div>';
    $(this).parent().parent().parent().parent().after(appendDiv);

});
$("html body").delegate('.logic_type_value_display', "change", function() {    
    let val=$(this).val();
    if(val=='isAnswered' || val=='isNotAnswered'){
        $(this).parent().siblings().first().css('display','none')
    }else{
        $(this).parent().siblings().first().css('display','block')
    }
});
// Display Logic
// Skip Logic
$("html body").delegate('.skip_qus_choice', "change", function() {    
    let val=$(this).val();
    let split_val=val.split('_');
    val=split_val[0];
    let parentv=$(this).parent().parent().parent();
    parentv.siblings().remove()
    let url="{{route('survey.getqus')}}?qus_id="+val;
    $.ajax({url: url, success: function(result){
        var optionv=result?.resp_logic_type;
        let textDiv='<div class="respondant_selection row"><div class="col-md-4"><select class="form-control logic_type_value_skip" name="logic_type_value_skip"><option value="">Choose</option>';
        Object.entries(optionv).forEach(([key, value]) => {
            textDiv+='<option value="'+key+'">'+value+'</option>';
        });
        textDiv+='</select></div>';
        if(result?.qus_type=='single_choice' || result?.qus_type=='multi_choice' || result?.qus_type =='dropdown'){
            let choice_list=JSON.parse(result?.qus?.qus_ans);
            optionv=choice_list?.choices_list.split(',');
            textDiv+='<div class="col-md-4 choice_list_sec"><select class="form-control skip_logic_type_value_option" name="skip_logic_type_value_option"><option value="">Choose</option>';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+value+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }else if(result?.qus_type=='picturechoice'){
            let choice_list=JSON.parse(result?.qus?.qus_ans);
            optionv=JSON.parse(choice_list?.choices_list);
            textDiv+='<div class="col-md-4 choice_list_sec"><select class="form-control skip_logic_type_value_option" name="skip_logic_type_value_option"><option value="">Choose</option>';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+key+'">'+value.text+'</option>';
            });
            textDiv+='</select>';
        }
        else if(result?.qus_type=='matrix_qus'){
            let choice_list=JSON.parse(result?.qus?.qus_ans);
            optionv=choice_list?.matrix_choice.split(',');
            textDiv+='<div class="col-md-4 choice_list_sec"><select class="form-control skip_logic_type_value_option" name="skip_logic_type_value_option"><option value="">Choose</option>';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+value+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }

        else if(result?.qus_type=='likert'){
            optionv={"1":1,"2":3,"3":3,"4":4,"5":5,"6":6,"7":7,"8":8,"9":9};
            textDiv+='<div class="col-md-4 choice_list_sec"><select class="form-control skip_logic_type_value_option" name="skip_logic_type_value_option"><option value="">Choose</option>';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+key+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }
        else if(result?.qus_type=='rankorder' || result?.qus_type=='photo_capture'){
            textDiv+='<div class="col-md-4 choice_list_sec"><input style="display:none;" class="form-control skip_logic_type_value_option" type="text" name="skip_logic_type_value_option"/>';
        }
        else if(result?.qus_type=='rating'){
            optionv={"1":1,"2":3,"3":3,"4":4,"5":5};
            textDiv+='<div class="col-md-4 choice_list_sec"><select class="form-control skip_logic_type_value_option" name="skip_logic_type_value_option"><option value="">Choose</option>';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+key+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }
        else if(result?.qus_type=='open_qus' || result?.qus_type=='email'){
            textDiv+='<div class="col-md-4 choice_list_sec"><input class="form-control skip_logic_type_value_option" type="text" name="skip_logic_type_value_option"/>';
        }
        
        textDiv+='</div><div class="col-md-4"><div class="ss-logic-item-actions mb-3"><button type="button" name="minus" class="removechoicelist_skip">−</button><button type="button" name="add" class="addchoicelist_skip">+</button> </div></div></div>';
        parentv.after(textDiv);

    }});
});
$("html body").delegate('.removechoicelist_skip', "click", function() {  
    if( document.getElementById("logic_section_skip").children.length <=1){
        $(this).parent().parent().parent().remove();
    }else{
        $(this).parent().parent().parent().parent().remove();
    }
    
});
$("html body").delegate('.addchoicelist_skip', "click", function() {  
    // $(this).parent().parent().remove();  
    let appendDiv='<div class="logic_section_skip_row"><div class="row"><div class="col-md-4"><select class="skip_qus_choice_andor form-control" name="skip_qus_choice_andor" data-placeholder="Choose ..."><option value="and">AND</option><option value="or">OR</option></select></div><div class="col-md-4"><input id="skip_type" class="form-control" readonly="" name="skip_type" type="text" value="Question"></div><div class="col-md-4"><div class="form-group mb-0"><select class="skip_qus_choice form-control" name="skip_qus_choice" data-placeholder="Choose ..."><option value="">Choose ...</option>';
    let skip_qus=$('#skip_qus').val();
    skip_qus=JSON.parse(skip_qus);
    Object.entries(skip_qus).forEach(([key, value]) => {
        appendDiv+='<option value="'+key+'">'+value+'</option>';
    });
    let skip_qus_matrix=$('#skip_qus_matrix').val();
    skip_qus_matrix=JSON.parse(skip_qus_matrix);
    Object.entries(skip_qus_matrix).forEach(([key, value]) => {
        appendDiv+='<optgroup label="'+value.question_name+'">';
        let option1=JSON.parse(value.qus_ans);
        option1=option1?.matrix_qus.split(',');
        Object.entries(option1).forEach(([key, value1]) => {
            appendDiv+='<option value="'+value.id+'_'+key+'">'+value1+'</option>';
        });
        appendDiv+='</optgroup>';
    });
    appendDiv+='</select></div></div></div></div>';
    $(this).parent().parent().parent().parent().after(appendDiv);

});
$("html body").delegate('.logic_type_value_skip', "change", function() {    
    let val=$(this).val();
    if(val=='isAnswered' || val=='isNotAnswered'){
        $(this).parent().siblings().first().css('display','none')
    }else{
        $(this).parent().siblings().first().css('display','block')
    }
});
$('#likert_range').change(function(e){
    let output_start ='<div class="label label--start"><p id="left_lable_text">'+$('#left_label').val()+'</p></div>';
    let output_mid ='<div class="label label--middle"><p id="middle_lable_text">'+$('#middle_label').val()+'</p></div>';
    let output_end= '<div class="label label--end"><p id="right_lable_text">'+$('#right_label').val()+'</p></div>';
    let output='';
    if($(this).val() == 4){
    output=output_start+output_end+'<div class="scale-element"><span>1</span></div><div class="scale-element"><span>2</span></div><div class="scale-element"><span>3</span></div><div class="scale-element"><span>4</span></div>';
    }else{
        output=output_start+output_mid+output_end+'<div class="scale-element"><span>1</span></div><div class="scale-element"><span>2</span></div><div class="scale-element"><span>3</span></div><div class="scale-element"><span>4</span></div><div class="scale-element"><span>5</span></div>';
        if($(this).val() >= 6){
            output+='<div class="scale-element"><span>6</span></div>';
        }
        if($(this).val() >= 7){
            output+='<div class="scale-element"><span>7</span></div>';
        }
        if($(this).val() >= 8){
            output+='<div class="scale-element"><span>8</span></div>';
        }
        if($(this).val() >= 9){
            output+='<div class="scale-element"><span>9</span></div>';
        }
        if($(this).val() >= 10){
            output+='<div class="scale-element"><span>10</span></div>';
        }
    }
    $('#likert_scale_option').html(output);

});
// Skip Logic

$('#welcome_template').on("change",function(){
    let id = $(this).val();
    let url="{{route('survey.templatedetails')}}?id="+id;

    $.ajax({
        url: url, 
        success: function(result){
            $('#welcome_title').val(result?.title);
            $('#welcome_imagetitle').val(result?.sub_title);
            $('#welcome_imagesubtitle').val(result?.description);
            $('#welcome_btn').val(result?.button_label);
            $('#existing_image').attr("src","http://127.0.0.1:8000/uploads/survey/"+result?.image);
            $('#existing_image_uploaded').val(result?.image);
            $('.exitingImg').css('display','flex');
            $('#existing_image').css('display',"block");
            $('#trigger_welcome_image').css('display','none');
            $('#ss_draft_remove_image_welcome').css('display','block');
        }
    });

});
$('#thankyou_template').on("change",function(){
    let id = $(this).val();
    let url="{{route('survey.templatedetails')}}?id="+id;
    $.ajax({
        url: url, 
        success: function(result){
            $('.exitingImg').css('display','flex');
            $('#existing_image_thankyou').css('display',"block");
            $('#trigger_thankyou_image').css('display','none');
            $('#ss_draft_remove_image_thankyou').css('display','block');
            $('#thankyou_title').val(result?.title);
            $('#thankyou_imagetitle').val(result?.sub_title);
            $('#existing_image_uploaded').val(result?.image);
            $('#existing_image_thankyou').attr("src","http://127.0.0.1:8000/uploads/survey/"+result?.image);
        }
    });

});
</script>

