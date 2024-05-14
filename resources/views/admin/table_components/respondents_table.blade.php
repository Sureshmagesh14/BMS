<div class="text-right">
    @isset($project_id)
        @php $projects_id = $project_id; @endphp
    @else
        @php $projects_id = '0'; @endphp
    @endisset
    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
        @if (str_contains(Request::url(), '/admin/projects'))
            <a href="#!" data-url="{{ route('attach_respondents', ['project_id' => $projects_id]) }}" data-size="xl"
                data-ajax-popup="true" class="btn btn-primary" data-bs-original-title="{{ __('Attact Respondents') }}"
                class="btn btn-primary" data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
                Attact Respondents
            </a>
        @else
            <a href="#!" data-url="{{ route('respondents.create') }}" data-size="xl" data-ajax-popup="true"
                class="btn btn-primary" data-bs-original-title="{{ __('Create Respondents') }}" class="btn btn-primary"
                data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
                Create Respondents
            </a>
        @endif
    </div>

    <div class="btn-group mr-2" role="group" aria-label="First group">
        <select name="action_2" id="action_2"
            class="form-control respondents_datatable hided_option respondents_select_box" style="display:none;">
            <option value="">Select Action</option>
            <optgroup label="Respondent">
                <option value="1">Status > Activate</option>
                <option value="2">Status > Deactivate</option>
                <option value="3">Status > Opt-Out</option>
                <option value="4">Export - Simple Database</option>
                <option value="5">Export - Normal Database</option>
                <option value="6">Export - Extended Database</option>
            </optgroup>
            <optgroup label="Standalone Actions">
                <option value="7">Export - Deactivated Respondents</option>
                {{-- <option value="8">Import - Old Respondents</option> --}}
                {{-- <option value="9">Updates imports with file</option> --}}
            </optgroup>
        </select>

        <select name="action_1" id="action_1"
            class="form-control respondents_datatable show_hided_option respondents_select_box">
            <option value="">Select Action</option>
            <option value="7">Export - Deactivated Respondents</option>
            {{-- <option value="8">Import - Old Respondents</option> --}}
            {{-- <option value="9">Updates imports with file</option> --}}
        </select>
    </div>

    {{-- <a href="#!" data-url="{{ route('export_resp') }}" data-size="xl"
        data-ajax-popup="true" class="btn btn-primary"
        data-bs-original-title="{{ __('export Respondents') }}" class="btn btn-primary"
        data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="export">
        Export
    </a> --}}
    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group mr-2" role="group" aria-label="First group">
            <div class="btn-group dropdown-filter">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                        aria-labelledby="filter" role="presentation" class="fill-current text-80">
                        <path fill-rule="nonzero"
                            d="M.293 5.707A1 1 0 0 1 0 4.999V1A1 1 0 0 1 1 0h18a1 1 0 0 1 1 1v4a1 1 0 0 1-.293.707L13 12.413v2.585a1 1 0 0 1-.293.708l-4 4c-.63.629-1.707.183-1.707-.708v-6.585L.293 5.707zM2 2v2.585l6.707 6.707a1 1 0 0 1 .293.707v4.585l2-2V12a1 1 0 0 1 .293-.707L18 4.585V2H2z">
                        </path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"
                        class="ml-2">
                        <path fill="var(--90)"
                            d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                        </path>
                    </svg>
                </button>
                <br>
                <div class="card">
                    <ul class="dropdown-menu dropdown-menu-right p-2">
                        <li class="mb-3">
                            <h5>Status Filter</h5>
                            <select name="filter_respondent_status" id="filter_respondent_status" class="form-control"
                                onchange="filter_respondent_status(this)">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Pending</option>
                                <option value="3">Deactivated</option>
                                <option value="4">Unsubscribed</option>
                                <option value="5">Blacklisted</option>
                            </select>
                        </li>
                        <li class="mb-3">
                            <h5>Respondent Profile</h5>
                            <select name="filter_respondent_profile" id="filter_respondent_profile" class="form-control"
                                onchange="filter_respondent_profile(this)">
                                <option value="">Select Profile Status</option>
                                <option value="yes">Completed</option>
                                <option value="no">Not Completed</option>
                            </select>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::guard('admin')->user()->role_id == 1)
        <div class="btn-group respondents_datatable hided_option" role="group" aria-label="Third group"
            style="display: none;">
            <div class="btn-group dropdown-filter">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                        aria-labelledby="delete" role="presentation" class="fill-current text-80">
                        <path fill-rule="nonzero"
                            d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z">
                        </path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"
                        class="ml-2">
                        <path fill="var(--90)"
                            d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                        </path>
                    </svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-header">
                        <a class="btn btn-danger respondents_datatable delete_all" class="btn btn-primary">
                            Delete Selected All
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    @endif
</div>

<h4 class="card-title"> </h4>
<p class="card-title-desc"></p>

<table id="respondents_datatable" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>
                <input type="checkbox" class="select_all" id="inlineForm-customCheck">
            </th>
            <th>#</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Mobile</th>
            <th>Whatsapp</th>
            <th>Email</th>
            <th>Age</th>
            <th>race</th>
            <th>status</th>
            <th>profile_completion</th>
            <th>inactive_until</th>
            <th>opeted_in</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        respondents_datatable();
    });
</script>
