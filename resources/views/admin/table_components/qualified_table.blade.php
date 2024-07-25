<div class="text-right">
    @isset($project_id)
        @php $projects_id = $project_id; @endphp
    @else
        @php $projects_id = '0'; @endphp
    @endisset
    
    <a href="#!" data-url="#" data-size="xl"
        data-ajax-popup="true" class="btn btn-primary" data-bs-original-title="{{ __('Attach Respondents') }}"
        class="btn btn-primary" data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
        Attach Projects
    </a>

    <div class="btn-group mr-2 qualified_table hided_option" role="group" aria-label="First group" style="display:none;">
        <select name="action_2" id="action_2" class="form-control select_box">
            <option value="">Select Action</option>
            <option value="3">Rewarded to the Respondent</option>
        </select>

        <div class="play-button-container ml-3">
            <a class="play-button project_play_button">
                <div class="play-button__triangle"></div>
            </a>
        </div>
    </div>
</div>

<h4 class="card-title"> </h4>
<p class="card-title-desc"></p>

<table id="qualified_table" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>
                <input type="checkbox" class="select_all" id="inlineForm-customCheck">
            </th>
            <th>Respondent ID</th>
            <th>Respondent Name</th>
            <th>Points</th>
            <th>Status</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
