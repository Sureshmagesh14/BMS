<form id="attach_projects_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Respondent</label>
        <div class="col-md-10">
            <input disabled class="form-control" type="text" name="project" id="project" value="@if($respondents != null) {{ $respondents->name }} {{ $respondents->surname }} @endif">
            <input type="hidden" name="respondents" id="respondents" value="@if($respondents != null) {{ $respondents->id }} @endif">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Projects *</label>
        <div class="col-md-10">
            <input class="form-control" type="text" id="project_id" name="project_id" value="{{ request()->get('q') }}" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="attach_projects_button">Attach Respondent</button>
    </div>
</form>

<script>
    $("#project_id").tokenInput("{{ route('project_seach_result') }}", {
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

    $('#attach_projects_form').validate({
        ignore: ':hidden:not("#projects")'
    });
    
    $("#attach_projects_button").click(function() {
        if (!$("#attach_projects_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#attach_projects_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{ route('project_attach_store') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#attach_projects_button').html('....Please wait');
                },
                success: function(response) {
                    if(response.text_status == true){
                        toastr.success(response.message);
                    }else{
                        toastr.warning(response.message);
                    }

                    $("#commonModal").modal('hide');
                    projects_table();
                },
                complete: function(response) {
                    $('#attach_projects_button').html('Attach');
                }
            });
        }
    });
</script>
