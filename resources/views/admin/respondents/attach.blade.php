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
            <select id="accept_terms" name="accept_terms" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">Select Respondents</option>
                @foreach ($respondents as $resp)
                    <option value="{{$resp->id}}">{{$resp->name}} {{$resp->surname}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="respondents_edit">Attach Respondent</button>
    </div>
</form>

<script>
    $(function() {
        
    });

    $("#respondents_edit").click(function() {
        if (!$("#edit_respondents_form").valid()) { // Not Valid
            return false;
        } else {
           
        }
    });
</script>
