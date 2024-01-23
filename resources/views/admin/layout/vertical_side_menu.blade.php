<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{url('/dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
            {{Config::get('constants.app_title')}}
            </span>
            <span class="logo-lg">
            {{Config::get('constants.app_title')}}
            </span>
        </a>

        <a href="{{url('/dashboard')}}" class="logo logo-light">
            <span class="logo-sm h5 text-white">
            {{Config::get('constants.app_title')}}
            </span>
            <span class="logo-lg h5 text-white">
            {{Config::get('constants.app_title')}}
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
                    <a href="#" class="waves-effect">
                        <i class="icon nav-icon" data-feather="calendar"></i>
                        <span class="menu-item" key="t-calendar">Users</span>
                    </a>
                </li>

                <li>
                    <a href="#" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Internal Reports</span>
                    </a>
                </li>

                <li>
                    <a href="#" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Cash Outs</span>
                    </a>
                </li>

                <li>
                    <a href="#" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Action Events</span>
                    </a>
                </li>
              

            

                <li class="menu-title" key="t-pages">Database</li>

                <li>
                    <a href="projects" class="waves-effect">
                        <i class="icon nav-icon" data-feather="calendar"></i>
                        <span class="menu-item" key="t-calendar">Projects</span>
                    </a>
                </li>

                <li>
                    <a href="respondents" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Respondents</span>
                    </a>
                </li>

                <li>
                    <a href="tags" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Panels</span>
                    </a>
                </li>

                <li>
                    <a href="rewards" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Rewards</span>
                    </a>
                </li>

                <li class="menu-title">Settings</li>

                <li>
                    <a href="groups" class="waves-effect">
                        <i class="icon nav-icon" data-feather="calendar"></i>
                        <span class="menu-item" key="t-calendar">Profile Groups</span>
                    </a>
                </li>

                <li>
                    <a href="banks" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Banks</span>
                    </a>
                </li>

                <li>
                    <a href="charities" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Charities</span>
                    </a>
                </li>

                <li>
                    <a href="networks" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Cellular Networks
                        </span>
                    </a>
                </li>

                <li>
                    <a href="contents" class=" waves-effect">
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