<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ url('/dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">{{ Config::get('constants.app_title') }}</span>
            <span class="logo-lg">{{ Config::get('constants.app_title') }}</span>
        </a>

        <a href="{{ url('/dashboard') }}" class="logo logo-light">
            <span class="logo-sm h5 text-white">{{ Config::get('constants.app_title') }}</span>
            <span class="logo-lg h5 text-white">{{ Config::get('constants.app_title') }}</span>
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
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="fas fa-warehouse"></i>
                        <span class="menu-item" key="t-dashboards">Dashboards</span>
                    </a>
                </li>


                <li class="menu-title" key="t-apps">Admin</li>

                <li>
                    <a href="{{ route('users.index') }}" class="waves-effect">
                        <i class="fas fa-users"></i>
                        <span class="menu-item" key="t-calendar">Users</span>
                    </a>
                </li>
                <?php
                $user = Auth::guard('admin')->user();
                // public folders
                $folderspublic = \App\Models\Folder::where(['folder_type' => 'public'])
                    ->withCount('surveycount')
                    ->pluck('id')
                    ->toArray();
                $foldersprivate = \App\Models\Folder::where(['folder_type' => 'private'])
                    ->withCount('surveycount')
                    ->get();
                $privateFoldres = [];
                foreach ($foldersprivate as $private) {
                    $user_ids = explode(',', $private->user_ids);
                    if (in_array($user->id, $user_ids)) {
                        array_push($privateFoldres, $private->id);
                    } elseif ($private->created_by == $user->id) {
                        array_push($privateFoldres, $private->id);
                    }
                }
                $folders1 = \App\Models\Folder::whereIn('id', $privateFoldres)->withCount('surveycount')->pluck('id')->toArray();
                $folder = array_merge($folderspublic, $folders1);
                $folders = \App\Models\Folder::whereIn('id', $folder)->withCount('surveycount')->get();
                if (count($folder) > 0) {
                    $survey = \App\Models\Survey::where(['folder_id' => $folder[0], 'is_deleted' => 0])->first();
                } else {
                    $survey = \App\Models\Survey::where(['is_deleted' => 0])
                        ->orderBy('id', 'asc')
                        ->first();
                }
                
                if (isset($survey)) {
                    $templateRoute = route('survey.template', $survey->folder_id);
                } else {
                    $initialFolder = \App\Models\Folder::orderBy('id', 'desc')->first();
                    if ($initialFolder) {
                        $templateRoute = route('survey.template', $initialFolder->id);
                    } else {
                        $templateRoute = route('survey.template', 0);
                    }
                }
                
                ?>
                <li>
                    <a href="{{ $templateRoute }}" class="waves-effect">
                        <i class="fas fa-poll"></i>
                        <span class="menu-item" key="t-contacts">Survey</span>
                    </a>
                </li>
                <li style="display:none;">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="icon nav-icon" data-feather="book"></i>
                        <span class="menu-item" key="t-contacts">Survey</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#" key="t-user-grid">Folder</a></li>
                        {{-- <li><a href="{{route('folder')}}" key="t-user-grid">Folder</a></li> --}}
                        <li><a href="{{ route('survey') }}" key="t-user-list">Survey</a></li>
                        <li><a href="{{ $templateRoute }}" key="t-profile">Templates</a></li>
                        <li><a href="contacts-profile.html" key="t-profile">Response</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('user-events') }}" class=" waves-effect">
                        <i class="fas fa-database"></i>
                        <span class="menu-item" key="t-chat">Internal Reports</span>
                    </a>
                </li>

                @if (Auth::guard('admin')->user()->role_id == 1)
                    <li>
                        <a href="{{ route('cashouts') }}" class=" waves-effect">
                            <i class="fas fa-money-bill"></i>
                            <span class="menu-item" key="t-chat">Cash Outs</span>
                        </a>
                    </li>
                @endif

                {{-- <li>
                    <a href="{{route('actions')}}" class=" waves-effect">
                        <i class="icon nav-icon" data-feather="message-square"></i>
                        <span class="menu-item" key="t-chat">Action Events</span>
                    </a>
                </li> --}}

                <li class="menu-title" key="t-pages">Database</li>

                <li>
                    <a href="{{ route('projects.index') }}" class="waves-effect">
                        <i class="fas fa-project-diagram"></i>
                        <span class="menu-item" key="t-calendar">Projects</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('respondents.index') }}" class=" waves-effect">
                        <i class="fas fa-user-friends"></i>
                        <span class="menu-item" key="t-chat">Respondents</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('tags.index') }}" class=" waves-effect">
                        <i class="fas fa-drum-steelpan"></i>
                        <span class="menu-item" key="t-chat">Panels</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('rewards.index') }}" class=" waves-effect">
                        <i class="fas fa-gift"></i>
                        <span class="menu-item" key="t-chat">Rewards</span>
                    </a>
                </li>

                <li class="menu-title">Settings</li>

                <li>
                    <a href="{{ route('groups.index') }}" class="waves-effect">
                        <i class="fas fa-layer-group"></i>
                        <span class="menu-item" key="t-calendar">Profile Groups</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('banks.index') }}" class=" waves-effect">
                        <i class="fas fa-piggy-bank"></i>
                        <span class="menu-item" key="t-chat">Banks</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('charities.index') }}" class=" waves-effect">
                        <i class="fas fa-briefcase"></i>
                        <span class="menu-item" key="t-chat">Charities</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('networks.index') }}" class=" waves-effect">
                        <i class="fas fa-network-wired"></i>
                        <span class="menu-item" key="t-chat">Cellular Networks
                        </span>
                    </a>
                </li>

                @if (Auth::guard('admin')->user()->role_id == 1)
                    <li>
                        <a href="{{ route('contents.index') }}" class=" waves-effect">
                            <i class="fab fa-elementor"></i>
                            <span class="menu-item" key="t-chat">Contents
                            </span>
                        </a>
                    </li>
                @endif

                <li class="menu-title" key="t-apps">Downloads </li>

                <li>
                    <a href="{{ route('admin.export') }}" class="waves-effect">
                        <i class="fas fa-file-export"></i>
                        <span class="menu-item" key="t-calendar">Export</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
