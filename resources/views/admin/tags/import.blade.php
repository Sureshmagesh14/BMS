
<style>
    label#import_excel-error { width: 100%; }
</style>
<form method="POST" action="{{ route('tags_attach_import',['respondent_id' => $project_id]) }}" id="attach_respondents_form" class="validation" enctype="multipart/form-data">
    @csrf

    {{-- upload_respondent -> this a route --}}
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Project</label>
        <div class="col-md-10">
            <input disabled class="form-control" type="text" name="project" id="project" value="@if($projects != null) {{ $projects->name }} @endif">
            <input type="hidden" name="project_id" id="project_id" value="@if($projects != null) {{ $projects->id }} @endif">
        </div>
    </div>
   
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Panel *</label>
        <div class="col-md-10">
            <input class="form-control" type="text" id="tag_id" name="tag_id" value="{{ request()->get('q') }}" required>
        </div>
    </div>
    <span>Note: Upload a CSV of your Respondents Information. The following fields are required in the
        CSV: <strong>Profile ID</strong></span><br>
        <a href="{{ asset('public/import/respondents/resp import csv.csv') }}">Click to
            download sample CSV file.</a>
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

    $("#tag_id").tokenInput("{{ route('tags_seach_result') }}", {
        propertyToSearch: "name",
        tokenValue: "id",
        tokenDelimiter: ",",
        hintText: "{{ __('Search Project... By(ID, Name)') }}",
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

    $('#attach_respondents_form').validate({
        ignore: ':hidden:not("#projects")'
    });
    
</script>
