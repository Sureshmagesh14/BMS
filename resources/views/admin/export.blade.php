@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<link rel="stylesheet" type="text/css"
    href="https://cdn.rawgit.com/wenzhixin/multiple-select/e14b36de/multiple-select.css">
<style>
    #demo {
        display: none;
    }

    .card {
        min-height: 231px !important;
    }

    .apexcharts-legend.apexcharts-align-center.position-right {
        top: 38px !important;
    }
</style>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <!-- starts -->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Export</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">BMS</a></li>
                                <li class="breadcrumb-item active">Export</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>


            <!-- start col-->


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"></h4>


                            <form action="{{ url('admin/export_all') }}" method="post">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Choose Module</label>
                                    <div class="col-md-10">
                                        <select name="module" id="module" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Respondents info">Respondents Info</option>
                                            <option value="Respondents">Respondents</option>
                                            <option value="Projects">Projects</option>
                                            <option value="Rewards">Rewards</option>
                                            <option value="Cashout">Cashout</option>
                                            <option value="Team Activity">Team Activity</option>
                                            <option value="Internal Reports">Internal Reports</option>
                                            <option value="Panel">Panel</option>
                                            <option value="Survey">Survey</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row methods">
                                    <label class="col-md-2 col-form-label">Choose</label>
                                    <div class="col-md-10">
                                        <select name="methods" id="methods" class="form-control">
                                            <option value="">Select</option>
                                            <option value="respondents_type">Respondents</option>
                                            <option value="projects_type">Projects</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row date_range" style="display: none;">
                                    <label class="col-md-2 col-form-label">Date Range</label>
                                    <div class="col-md-10">
                                        <div class="input-daterange input-group" data-provide="datepicker"
                                            data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                                            <input type="text" class="form-control" name="start" />
                                            <input type="text" class="form-control" name="end" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row show_resp_type" style="display: none;">
                                    <label class="col-md-2 col-form-label">Choose Type</label>
                                    <div class="col-md-10">
                                        <select name="show_resp_type" id="show_resp_type" class="form-control">
                                            <option value="">Select</option>
                                            <option value="simple">Simple Database</option>
                                            <option value="essential">Normal Database</option>
                                            <option value="extended">Extended Database</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row show_cashout_type">
                                    <label class="col-md-2 col-form-label">Choose Type</label>
                                    <div class="col-md-10">
                                        <select name="show_cashout_val" id="show_cashout_val" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">EFT</option>
                                            <option value="3">Airtime</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row show_year">
                                    <label class="col-md-2 col-form-label">Select Year</label>
                                    <div class="col-md-10">
                                        <select id="year" name="year" class="w-full form-control form-select">
                                            <option value="" selected="selected" disabled="disabled">Please select
                                            </option>
                                            {{ $last = date('Y') - 15 }}
                                            {{ $now = date('Y') }}
                                            @for ($i = $now; $i >= $last; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                               
                                <div class="form-group row show_resp">
                                    <label class="col-md-2 col-form-label">Status</label>
                                    <div class="col-md-10">

                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="Deactivated" name="resp_status"
                                                class="custom-control-input" value="Deactivated">
                                            <label class="custom-control-label" for="Deactivated">Deactivated</label>
                                        </div>

                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="Blacklisted" name="resp_status"
                                                class="custom-control-input" value="Blacklisted">
                                            <label class="custom-control-label" for="Blacklisted">Blacklisted</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row report_type">
                                    <label class="col-md-2 col-form-label">Type</label>
                                    <div class="col-md-10">

                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="Individual" name="type_method"
                                                class="custom-control-input type_method" value="Individual">
                                            <label class="custom-control-label" for="Individual">Individual</label>
                                        </div>

                                        <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="All" name="type_method"
                                                class="custom-control-input type_method" value="All">
                                            <input type="hidden" name="all" id="all">
                                            <label class="custom-control-label" for="All">All</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row projects">
                                    <label class="col-md-2 col-form-label">Projects</label>
                                    <div class="col-md-10">

                                        <input class="form-control" type="text" id="projects"
                                            name="projects[]" value="{{ request()->get('q') }}">
                                    </div>
                                </div>

                                <div class="form-group row panel">
                                    <label class="col-md-2 col-form-label">Panel Name</label>
                                    <div class="col-md-10">

                                        <input class="form-control" type="text" id="panel"
                                            name="panel[]" value="{{ request()->get('q') }}">
                                    </div>
                                </div>

                                <div class="form-group row respondents">
                                    <label class="col-md-2 col-form-label">Respondents</label>
                                    <div class="col-md-10">

                                        <input class="form-control" type="text" id="respondents"
                                            name="respondents[]" value="{{ request()->get('q') }}">
                                    </div>
                                </div>

                                <div class="form-group row show_action">
                                    <label class="col-md-2 col-form-label">Action</label>
                                    <div class="col-md-10">
                                        <select name="action" id="action" class="form-control">
                                            <option value="">Select Action</option>
                                            <option value="created">Created</option>
                                            <option value="updated">Updated</option>
                                            <option value="deleted">Deleted</option>
                                            <option value="activated">Activated</option>
                                            <option value="deactivated">Deactivated</option>
                                            <option value="created by share url">Created With Share URL</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row show_role">
                                    <label class="col-md-2 col-form-label">Role</label>
                                    <div class="col-md-10">
                                        <select id="role" name="role"
                                            class="w-full form-control form-select">
                                            <option value="" selected="selected" disabled="disabled">Please
                                                select
                                            </option>
                                            <option value="">Select Role</option>
                                            <option value="1">Administrator</option>
                                            <option value="2">User</option>
                                            <option value="3">Temp</option>
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="form-group row show_month">
                                    <label class="col-md-2 col-form-label">Month</label>
                                    <div class="col-md-10">
                                        <select id="month" name="month"
                                            class="w-full form-control form-select">
                                            <option value="" selected="selected" disabled="disabled">Please
                                                select
                                            </option>
                                            <option value="">Select Month</option>
                                            <?php
                                            for ($i = 1; $i <= 12; $i++) {
                                                // Get the month name using DateTime class
                                                $monthName = DateTime::createFromFormat('!m', $i)->format('F');
                                                // Output option tag with month name and value (1-indexed)
                                                echo "<option value='$monthName'>$monthName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row show_pro_type">
                                    <label class="col-md-2 col-form-label">Type</label>
                                    <div class="col-md-10">
                                        <select id="pro_type" name="pro_type"
                                            class="w-full form-control form-select">
                                            <option value="" selected="selected" disabled="disabled">Please
                                                select
                                            </option>
                                            <option value="project">Project</option>
                                            <option value="respondent">Respondent</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Export</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!-- end col-->



            <!-- End Page-content -->
            @include('admin.layout.footer')
            @yield('adminside-script')
            @stack('adminside-js')
            <script src="https://cdn.rawgit.com/wenzhixin/multiple-select/e14b36de/multiple-select.js"></script>
            <script>
                $(document).ready(function() {
                    $(".show_resp").hide();
                    $(".show_resp_status").hide();
                    $(".show_resp_type").hide();
                    $(".show_user").hide();
                    $(".projects").hide();
                    $(".report_type").hide();
                    $(".respondents").hide();
                    $(".show_year").hide();
                    $(".show_month").hide();
                    $(".show_role").hide();
                    $(".show_action").hide();
                    $(".show_pro_type").hide();
                    $(".methods").hide();
                    $(".show_cashout_type").hide();
                    $("#module").val("");
                    $("#year").val("");
                    $("#month").val("");

                    $('input[type=radio][name=type_method]').change(function() {
                        if (this.value == 'Individual') {
                            $(".respondents").show();
                        } else if (this.value == 'All') {
                            $(".respondents").hide();
                        }
                    });

                    
                    $('#methods').on('change', function() {
                        if (this.value == 'projects_type') {
                            $(".projects").show();
                            $(".report_type").hide();
                            $(".respondents").hide();
                        } else{
                            $(".projects").hide();
                            $(".report_type").show();
                            $(".respondents").show();
                        }
                    });

                    $('#module').on('change', function() {
                        if (this.value == 'Respondents') {
                            $(".show_year").hide();
                            $(".show_month").hide();
                            $(".show_role").hide();
                            $(".show_action").hide();
                            $(".show_resp").show();
                            $(".show_resp_status").hide();
                            $(".projects").hide();
                            $(".show_resp_type").hide();
                            $(".show_pro_type").hide();
                            $(".show_user").hide();
                            $(".respondents").show();
                            $(".report_type").show();
                            $(".date_range").show();
                            $(".panel").hide();
                            $(".methods").hide();
                            $(".show_cashout_type").hide();
                        } else if (this.value == 'Respondents info') {
                            $(".show_year").hide();
                            $(".show_month").hide();
                            $(".show_role").hide();
                            $(".show_action").hide();
                            $(".show_resp").hide();
                            $(".show_resp_type").show();
                            $(".show_resp_status").hide();
                            $(".show_user").hide();
                            $(".report_type").show();
                            $(".respondents").hide();
                            $(".date_range").hide(); 
                            $(".projects").hide();
                            $(".show_pro_type").hide();
                            $(".methods").hide();
                            $(".panel").hide();
                            $(".show_cashout_type").hide();
                        } else if ((this.value == 'Cashout')) {
                            $(".show_year").hide();
                            $(".show_month").hide();
                            $(".show_role").hide();
                            $(".show_action").hide();
                            $(".projects").hide();
                            $(".show_resp").hide();
                            $(".show_resp_status").hide();
                            $(".show_resp_type").hide();
                            $(".show_user").hide();
                            $(".respondents").show();
                            $(".report_type").show();
                            $(".methods").hide();
                            $(".show_pro_type").hide();
                            $(".date_range").show();
                            $(".panel").hide();
                            $(".show_cashout_type").show();
                        } else if (this.value == 'Rewards') {
                            $(".methods").show();
                            $(".show_year").hide();
                            $(".show_month").hide();
                            $(".report_type").hide();
                            $(".show_role").hide();
                            $(".show_action").hide();
                            $(".show_resp").hide();
                            $(".show_resp_status").hide();
                            $(".show_resp_type").hide();
                            $(".show_user").hide();
                            $(".respondents").hide();
                            $(".projects").hide();
                            $(".show_pro_type").hide();
                            $(".date_range").hide();
                            $(".panel").hide();
                            $(".show_cashout_type").hide();
                        } else if (this.value == 'Team Activity') {
                            $(".show_year").hide();
                            $(".show_month").hide();
                            $(".show_role").hide();
                            $(".show_action").hide();
                            $(".show_resp").hide();
                            $(".show_resp_status").hide();
                            $(".show_resp_type").hide();
                            $(".show_user").show();
                            $(".respondents").show();
                            $(".show_pro_type").hide();
                            $(".report_type").show();
                            $(".date_range").show();
                            $(".projects").hide();
                            $(".methods").hide();
                            $(".panel").hide();
                            $(".show_cashout_type").hide();
                        } else if (this.value == 'Internal Reports') {
                            $(".show_year").show();
                            $(".show_month").show();
                            $(".show_role").show();
                            $(".show_action").show();
                            $(".show_resp").hide();
                            $(".show_resp_status").hide();
                            $(".show_resp_type").hide();
                            $(".show_user").show();
                            $(".respondents").hide();
                            $(".report_type").hide();
                            $(".show_pro_type").show();
                            $(".date_range").hide();
                            $(".methods").hide();
                            $(".projects").hide();
                            $(".panel").hide();
                            $(".show_cashout_type").hide();
                        }else if (this.value == 'Panel') {
                            $(".show_year").hide();
                            $(".show_month").hide();
                            $(".show_role").hide();
                            $(".show_action").hide();
                            $(".show_resp").hide();
                            $(".show_resp_status").hide();
                            $(".show_resp_type").hide();
                            $(".show_user").hide();
                            $(".respondents").hide();
                            $(".panel").show();
                            $(".report_type").show();
                            $(".show_pro_type").hide();
                            $(".date_range").hide();
                            $(".methods").hide();
                            $(".projects").hide();
                            $(".show_cashout_type").hide();
                           
                        }
                        else {
                            $(".show_user").hide();
                            $(".projects").hide();
                            $(".show_year").hide();
                            $(".show_month").hide();
                            $(".show_role").hide();
                            $(".show_action").hide();
                            $(".show_resp").hide();
                            $(".report_type").hide();
                            $(".show_resp_status").hide();
                            $(".show_resp_type").hide();
                            $(".respondents").hide();
                            $(".show_year").hide();
                            $(".show_month").hide();
                            $(".show_pro_type").show();
                            $(".date_range").show();
                            $(".methods").hide();
                            $(".panel").hide();
                            $(".show_cashout_type").hide();
                        }
                    });

                    $("#respondents").tokenInput("{{ route('respondent_seach_result') }}", {
                        propertyToSearch: "name",
                        tokenValue: "id",
                        tokenDelimiter: ",",
                        hintText: "{{ __('Search Respondent... By(ID, Name, Surname, Mobile)') }}",
                        noResultsText: "{{ __('Respondent not found.') }}",
                        searchingText: "{{ __('Searching...') }}",
                        deleteText: "&#215;",
                        minChars: 2,
                        tokenLimit: 20,
                        zindex: 9999,
                        animateDropdown: false,
                        resultsLimit: 20,
                        deleteText: "&times;",
                        preventDuplicates: true,
                        theme: "bootstrap"
                    });

                    $("#panel").tokenInput("{{ route('tags_search_result') }}", {
                        propertyToSearch: "name",
                        tokenValue: "id",
                        tokenDelimiter: ",",
                        hintText: "{{ __('Search Panel... By(ID, Name)') }}",
                        noResultsText: "{{ __('Panel not found.') }}",
                        searchingText: "{{ __('Searching...') }}",
                        deleteText: "&#215;",
                        minChars: 2,
                        tokenLimit: 20,
                        zindex: 9999,
                        animateDropdown: false,
                        resultsLimit: 20,
                        deleteText: "&times;",
                        preventDuplicates: true,
                        theme: "bootstrap"
                    });


                    $("#projects").tokenInput("{{ route('project_seach_result') }}", {
                        propertyToSearch: "name",
                        tokenValue: "id",
                        tokenDelimiter: ",",
                        hintText: "{{ __('Search Project... By(ID, Name, Client)') }}",
                        noResultsText: "{{ __('Project not found.') }}",
                        searchingText: "{{ __('Searching...') }}",
                        deleteText: "&#215;",
                        minChars: 2,
                        tokenLimit: 1,
                        zindex: 9999,
                        animateDropdown: false,
                        resultsLimit: 20,
                        deleteText: "&times;",
                        preventDuplicates: true,
                        theme: "bootstrap"
                    });

                    $('#attach_respondents_form').validate({
                        ignore: ':hidden:not("#respondents")'
                    });
                });
            </script>
