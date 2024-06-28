<form id="attach_tags_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Respondent</label>
        <div class="col-md-10">
            <input disabled class="form-control" type="text" name="project" id="project" value="@if($respondents != null) {{ $respondents->name }} {{ $respondents->surname }} @endif">
            <input type="hidden" name="respondents" id="respondents" value="@if($respondents != null) {{ $respondents->id }} @endif">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Panel *</label>
        <div class="col-md-10">
            <input class="form-control" type="text" id="tag_id" name="tag_id" value="{{ request()->get('q') }}" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="attach_tags_button">Attach Panel</button>
    </div>
</form>

<script>
    $("#tag_id").tokenInput("{{ route('tags_seach_result') }}", {
        propertyToSearch: "name",
        tokenValue: "id",
        tokenDelimiter: ",",
        hintText: "{{ __('Search Panel... By(ID, Name)') }}",
        noResultsText: "{{ __('Panel not found.') }}",
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

    $('#attach_tags_form').validate({
        ignore: ':hidden:not("#projects")'
    });
    
    $("#attach_tags_button").click(function() {
        if (!$("#attach_tags_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#attach_tags_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{ route('tags_attach_store') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#attach_tags_button').html('....Please wait');
                },
                success: function(response) {
                    if(response.text_status == true){
                        toastr.success(response.message);
                    }else{
                        toastr.warning(response.message);
                    }

                    $("#commonModal").modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                complete: function(response) {
                    $('#attach_tags_button').html('Attach');
                }
            });
        }
    });
</script>
