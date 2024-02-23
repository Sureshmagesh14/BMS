<!-- ========== Left Sidebar Start ========== -->
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
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="icon nav-icon" data-feather="home"></i>
                        <span class="menu-item" key="t-dashboards">Dashboards</span>
                    </a>
                  
                </li>

               
                <li class="menu-title" key="t-apps">Admin</li>

                <li>
                    <a href="calendar.html" class="waves-effect">
                        <i class="icon nav-icon" data-feather="calendar"></i>
                        <span class="menu-item" key="t-calendar">Users</span>
                    </a>
                </li>
                <?php $getfirstSurvey=\App\Models\Survey::where(['is_deleted'=>0])->orderBy("id", "asc")->first(); if(isset($getfirstSurvey)) 
                $templateRoute=route('survey.template',$getfirstSurvey->folder_id); else $templateRoute=route('survey.template',0); 
                
                ?>
                <li>
                    <a href="{{$templateRoute}}" class="waves-effect">
                        <i class="icon nav-icon" data-feather="calendar"></i>
                        <span class="menu-item" key="t-contacts">Survey</span>
                    </a>
                </li>
                <li style="display:none;">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="icon nav-icon" data-feather="book"></i>
                        <span class="menu-item" key="t-contacts">Survey</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('folder')}}" key="t-user-grid">Folder</a></li>
                        <li><a href="{{route('survey')}}" key="t-user-list">Survey</a></li>
                        <li><a href="{{$templateRoute}}" key="t-profile">Templates</a></li>
                        <li><a href="contacts-profile.html" key="t-profile">Response</a></li>
                    </ul>
                </li>

                <li>
                    <a href="chat.html" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Internal Reports</span>
                    </a>
                </li>

                <li>
                    <a href="chat.html" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Cash Outs</span>
                    </a>
                </li>

                <li>
                    <a href="chat.html" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Action Events</span>
                    </a>
                </li>
              

            

                <li class="menu-title" key="t-pages">Database</li>

                <li>
                    <a href="calendar.html" class="waves-effect">
                        <i class="icon nav-icon" data-feather="calendar"></i>
                        <span class="menu-item" key="t-calendar">Projects</span>
                    </a>
                </li>

                <li>
                    <a href="chat.html" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Respondents</span>
                    </a>
                </li>

                <li>
                    <a href="chat.html" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Panels</span>
                    </a>
                </li>

                <li>
                    <a href="chat.html" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Rewards</span>
                    </a>
                </li>

                <li class="menu-title">Settings</li>

                <li>
                    <a href="calendar.html" class="waves-effect">
                        <i class="icon nav-icon" data-feather="calendar"></i>
                        <span class="menu-item" key="t-calendar">Profile Groups</span>
                    </a>
                </li>

                <li>
                    <a href="chat.html" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Banks</span>
                    </a>
                </li>

                <li>
                    <a href="chat.html" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Charities</span>
                    </a>
                </li>

                <li>
                    <a href="chat.html" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Cellular Networks
                        </span>
                    </a>
                </li>

                <li>
                    <a href="chat.html" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Contents
                        </span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->