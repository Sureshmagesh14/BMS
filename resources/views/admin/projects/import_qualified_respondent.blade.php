<form method="POST" action="{{ str_contains(url()->previous(), '/admin/projects') ? route('store_qualified_respondents', ['project_id' => $project_id]) : route('project_store_qualified_respondents') }}" id="attach_respondents_form" class="validation" enctype="multipart/form-data">
    @csrf

    {{-- Project Field --}}
    @if (str_contains(url()->previous(), '/admin/projects'))
    <div class="form-group row">
        <label for="project" class="col-md-2 col-form-label">Project</label>
        <div class="col-md-10">
            <input disabled class="form-control" type="text" id="project" value="{{ $projects->name ?? '' }}">
            <input type="hidden" name="project_id" value="{{ $projects->id ?? '' }}">
        </div>
    </div>
    @else
    <div class="form-group row">
        <label for="project_id" class="col-md-2 col-form-label">Project *</label>
        <div class="col-md-10">
            <select name="project_id" id="project_id" class="form-control" required>
                <option value="">Select Project</option>
                @foreach ($project_all as $pro)
                <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif

    {{-- Respondents File --}}
    <div class="form-group row">
        <label for="import_excel" class="col-md-2 col-form-label">Respondents *</label>
        <div class="col-md-10">
            <input type="file" name="file" id="import_excel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
        </div>
    </div>

    {{-- Note and Sample CSV --}}
    <div class="form-group row">
        <div class="col-md-10 offset-md-2">
            <span>Note: Upload a CSV of your Respondents Information. The following fields are required in the CSV: <strong>Profile ID</strong></span><br>
            <a href="{{ asset('public/import/respondents/resp_import_csv.csv') }}">Click to download sample CSV file.</a>
        </div>
    </div>

    {{-- Modal Footer with Buttons --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="attach_respondents_button">Import Respondent</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#attach_respondents_form').validate({
            rules: {
                file: {
                    required: true,
                    extension: "csv,xlsx,xls",
                    filesize: 5242880 // 5MB in bytes
                }
            },
            messages: {
                file: {
                    required: "Please select a file",
                    extension: "Please upload only CSV, XLSX or XLS files",
                    filesize: "File size must be less than 5MB"
                }
            }
        });

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param);
        }, 'File size must be less than 5MB');
    });
</script>
