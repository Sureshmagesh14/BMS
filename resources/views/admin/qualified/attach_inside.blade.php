<form id="qualified_respondents_form" class="validation">
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
            <select name="respondents[]" id="respondents" class="form-control select2" multiple>
                <option value="" disabled>Select Respondents</option>
                @foreach ($get_resp as $resp)
                    <option value="{{$resp->id}}" >{{$resp->name}} {{$resp->surname}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="qualified_respondents_button">Qualified Respondent</button>
    </div>
</form>

<script>
    
    $('#qualified_respondents_form').validate({
        ignore: ':hidden:not("#respondents")'
    });
    
    $("#qualified_respondents_button").click(function() {
        if (!$("#qualified_respondents_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#qualified_respondents_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{ route('qualified_respondent_attach_store') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#qualified_respondents_button').html('....Please wait');
                },
                success: function(response) {
                    if(response.text_status == true){
                        toastr.success(response.message);
                    }else{
                        toastr.warning(response.message);
                    }

                    $("#commonModal").modal('hide');
                    qualified_table();
                },
                complete: function(response) {
                    $('#qualified_respondents_button').html('Qualified Respondent');
                }
            });
        }
    });

    
</script>
