<form id="attach_respondents_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Project</label>
        <div class="col-md-10">
            <input disabled class="form-control" type="text" name="project" id="project" value="@if($projects != null) {{ $projects->name }} @endif">
            <input type="hidden" name="project_id" id="project_id" value="@if($projects != null) {{ $projects->id }} @endif">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Respondents *</label>
        <div class="col-md-10">
            <input class="form-control" type="text" id="respondents" name="respondents" value="{{ request()->get('q') }}" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="respondents_edit">Attach Respondent</button>
    </div>
</form>

<script>
    $("#respondents").tokenInput("{{ route('respondent_seach_result') }}", {
        propertyToSearch: "name",
        tokenValue: "id",
        tokenDelimiter: ",",
        hintText: "{{ __('Search Respondent... By(ID, Name, Surname, Mobile)') }}",
        noResultsText: "{{ __('Respondent not found.') }}",
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

    $("#respondents_edit").click(function() {
        if (!$("#edit_respondents_form").valid()) { // Not Valid
            return false;
        } else {
           
        }
    });


</script>
