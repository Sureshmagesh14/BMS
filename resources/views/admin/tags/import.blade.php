
<style>
    label#import_excel-error { width: 100%; }
</style>
<form method="POST" action="{{ route('tags_attach_import',['respondent_id' => $respondent_id]) }}" id="attach_respondents_form" class="validation" enctype="multipart/form-data">
    @csrf

    {{-- upload_respondent -> this a route --}}
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Respondent</label>
        <div class="col-md-10">
            <input disabled class="form-control" type="text" name="project" id="project" value="@if($fullName != null) {{ $fullName}} @endif">
            <input type="hidden" name="respondent_id" id="respondent_id" value="@if($fullName != null) {{$respondent_id}} @endif">
        </div>
    </div>
   
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Panel *</label>
        <div class="col-md-10">
            <input type="file" name="file" id="import_excel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
        </div>
    </div>
    <span>Note: Upload a CSV of your Respondents Information. The following fields are required in the
        CSV: <strong>Panel ID</strong></span><br>
        <a href="{{ asset('public/import/respondents/resp import csv.csv') }}">Click to
            download sample CSV file.</a>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="attach_respondents_button">Import Panel</button>
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
