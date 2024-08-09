<div class="text-right">
    @isset($project_id)
        @php $projects_id = $project_id; @endphp
    @else
        @php $projects_id = '0'; @endphp
    @endisset

    @if (str_contains(Request::url(), '/admin/projects'))
        <a href="#!" data-url="{{ route('attach_respondents', ['project_id' => $projects_id]) }}" data-size="xl"
            data-ajax-popup="true" class="btn btn-primary" data-bs-original-title="{{ __('Attach Respondents') }}"
            class="btn btn-primary" data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
            Attach Respondents
        </a>

        <a href="#!" data-url="{{ route('import_respondents', ['project_id' => $projects_id]) }}" data-size="xl"
            data-ajax-popup="true" class="btn btn-primary"
            data-bs-original-title="{{ __('Import - Respondents to Project') }}" class="btn btn-primary" data-size="xl"
            data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
            Import Respondents
        </a>
    @elseif (str_contains(Request::url(), '/admin/respondents'))
        <a href="#!" data-url="{{ route('respondents.create') }}" data-size="xl" data-ajax-popup="true"
            class="btn btn-primary" data-bs-original-title="{{ __('Create Respondents') }}" class="btn btn-primary"
            data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
            Create Respondents
        </a>
    @else
   
    @endif
    <br><br>

    <div class="btn-group mr-2 respondents_datatable hided_option" role="group" aria-label="First group" style="display: none;">

        {{-- ACTION --}}
        <select name="action_2" id="action_2" class="form-control respondents_datatable hided_option respondents_select_box">
            <option value="">Select Action</option>
            @if (str_contains(Request::url(), '/admin/tags'))
                <optgroup label="Extras">
                    <option value="11">Un-Assign from Project</option>
                </optgroup>
            @else
                <optgroup label="Extras">
                    <option value="10">Notify All Respondents</option>
                    <option value="11">Un-Assign from Project</option>
                </optgroup>

                <optgroup label="Respondent">
                    @if (str_contains(Request::url(), '/admin/projects'))
                        <option value="qualified">Move to Qualified</option>
                    @endif
                    <option value="1">Status > Activate</option>
                    <option value="2">Status > Deactivate</option>
                    <option value="3">Status > Opt-Out</option>
                    @if (Auth::guard('admin')->user()->role_id == 1)
                        @if (str_contains(Request::url(), '/admin/respondents'))
                            <option value="delete_all">Delete Selected All</option>
                        @endif
                    @endif
                </optgroup>
            @endif
        </select>

        {{-- PLAY BUTTON --}}
        <div class="play-button-container ml-3">
            <a class="play-button respondents_play_button">
                <div class="play-button__triangle"></div>
            </a>
        </div>
    </div>


    {{-- FILTER --}}
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
                                <option value="4">Pending</option>
                                <option value="2">Deactivated</option>
                                <option value="3">Unsubscribed</option>
                                <option value="5">Blacklisted</option>
                            </select>
                        </li>
                        <li class="mb-3">
                            <h5>Respondent Profile</h5>
                            <select name="filter_respondent_profile" id="filter_respondent_profile" class="form-control"
                                onchange="filter_respondent_profile(this)">
                                <option value="">Select Profile Status</option>
                                <option value="1">Completed</option>
                                <option value="0">Not Completed</option>
                            </select>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

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
            {{-- <th>race</th> --}}
            <th>Status</th>
            <th>Profile Completion</th>
            <th>Inactive Until</th>
            <th>Opted In</th>
            <th>Last Updated</th>
            <th>Referral Code</th>
            <th>Accepted Terms</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
