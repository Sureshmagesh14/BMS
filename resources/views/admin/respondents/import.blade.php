<form method="POST" action="{{ route('upload_respondent') }}" id="attach_respondents_form" class="validation" enctype="multipart/form-data">
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
            <input type="hidden" id="project_id" value="{{$project_id}}" name="project_id">
            <input type="file" name="import_excel" id="import_excel" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="attach_respondents_button">Import Respondent</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#attach_respondents_form').validate({
            focusCleanup: true,
            focusInvalid: false,
            ignore: [],
            rules: {
                import_excel: {
                    required: true,
                    extensionempty: 'xls|xlsx',
                    filesize: 5000000
                },
            }
        });

        $.validator.addMethod('filesize', function (value, element, param) {
            console.log("param",param);
            console.log("Size",element.files[0].size);
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than 5mb');

        $.validator.addMethod("extensionempty", function(value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, "|") : "xls|xlsx";
            return this.optional(element) || value.match(new RegExp("\\.(" + param + ")$", "i")) || value.indexOf('.') == -1;
        }, $.validator.format("Please Upload only xls|xlsx File."));
    });
</script>