@if (Auth::guard('admin')->user()->role_id != 3)
    <div class="text-right">
        @if (str_contains(Request::url(), '/admin/respondents'))
            <a href="#!" data-url="{{ route('attach_projects', ['respondent_id' => $respondent_id]) }}" data-size="xl"
                data-ajax-popup="true" class="btn btn-primary" data-bs-original-title="{{ __('Attach Respondents') }}"
                class="btn btn-primary" data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
                Attach Projects
            </a>
        @else
            <a href="#!" data-url="{{ route('projects.create') }}" data-size="xl" data-ajax-popup="true"
                class="btn btn-primary" data-bs-original-title="{{ __('Create Projects') }}" class="btn btn-primary"
                data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
                Create Project
            </a>
        @endif
        <br><br>

        <div class="btn-group mr-2 projects_table hided_option" role="group" aria-label="First group" style="display:none;">
            <select name="action_2" id="action_2" class="form-control select_box">
                <option value="">Select Action</option>
                <optgroup label="Project">
                    <option value="3">Status > Complete</option>
                    {{-- <option value="3">Project Complete & Reward</option> --}}
                    {{-- <option value="export_survey_response">Export > Survey Responses</option> --}}
                </optgroup>
                {{-- <optgroup label="Standalone Actions">
                    <option value="export_all_project">Export - All Projects</option>
                </optgroup> --}}
                @if (Auth::guard('admin')->user()->role_id != 3)
                    <optgroup label="Delete Project">
                        <option value="delete_all">Delete Selected</option>
                    </optgroup>
                @endif
                
            </select>

            {{-- <select name="action_1" id="action_1" class="form-control projects_table show_hided_option select_box">
                <option value="">Select Action</option>
                <option value="delete_all">Export - All Projects</option>
            </select> --}}

            <div class="play-button-container ml-3">
                <a class="play-button project_play_button">
                    <div class="play-button__triangle"></div>
                </a>
            </div>
        </div>

        {{-- <a href="#!" data-url="{{ route('export_projects') }}" data-size="xl"
            data-ajax-popup="true" class="btn btn-primary"
            data-bs-original-title="{{ __('Respondent Projects') }}" class="btn btn-primary"
            data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="export">
            Export
        </a> --}}
    </div>
@endif

<h4 class="card-title"> </h4>
<p class="card-title-desc"></p>

<table id="projects_table" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>
                <input type="checkbox" class="select_all" id="inlineForm-customCheck">
            </th>
            <th>#</th>
            <th>Project Number</th>
            <th>Client Name</th>
            <th>Project Name</th>
            <th>Creator</th>
            <th>Survey Type</th>
            <th>Reward Amount</th>
            <th>Created</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
