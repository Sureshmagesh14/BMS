<form id="attach_tags_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Panel</label>
        <div class="col-md-10">
            <input disabled class="form-control" type="text" name="project" id="project" value="@if($tags != null) {{ $tags->name }} @endif">
            <input type="hidden" name="tag_id" id="" value="@if($tags != null) {{ $tags->id }} @endif">
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
        <button type="button" class="btn btn-primary" id="attach_tags_button">Attach Panel</button>
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

    $('#attach_tags_form').validate({
        ignore: ':hidden:not("#respondents")'
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
                    respondents_datatable();
                },
                complete: function(response) {
                    $('#attach_tags_button').html('Attach');
                }
            });
        }
    });
</script>
