<form id="edit_projects_form" class="validation">
    <input type="hidden" id="id" name="id" value="{{ $projects->id }}">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Project Number *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="number" name="number" value="{{ $projects->number }}"
                required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Client Name *
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="client" name="client" value="{{ $projects->client }}"
                required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Project Name *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name"
                value="{{ $projects->name }}" required>
            <div id="name-error" class="text-danger"></div>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Creator *</label>
        <div class="col-md-10">
            <select id="user" name="user" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">Choose an option</option>
                @foreach ($users as $user)
                    <option @if ($projects->user_id == $user->id) selected @endif value="{{ $user->id }}">
                        {{ $user->name }} {{ $user->surname }}</option>
                @endforeach
            </select>
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Survey Type *
        </label>
        <div class="col-md-10">
            <select id="type_id" name="type_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                {{-- <option @if ($projects->type_id == 1) selected @endif value="1">
                    Pre-Screener
                </option> --}}
                <option @if ($projects->type_id == 2) selected @endif value="2">
                    Pre-Task
                </option>
                <option @if ($projects->type_id == 3) selected @endif value="3">
                    Paid survey
                </option>
                <option @if ($projects->type_id == 4) selected @endif value="4">
                    Unpaid survey
                </option>
            </select>
        </div>
    </div>


    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Reward Amount (R)
        </label>
        <div class="col-md-10">
            <input type="number" class="form-control" id="reward" name="reward" value="{{ $projects->reward }}">
        </div>
    </div>

    @php
        $refcode = \App\Models\Respondents::randomPassword(); #function call
    @endphp

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Project Link
        </label>
        <div class="col-md-10">
            @if ($projects->project_link != null)
                @php $project_link=$projects->project_link; @endphp
            @else
                @php $project_link=$refcode; @endphp
            @endif
            <input type="url" class="form-control" id="project_link" value="{{ url('share_project', $project_link) }}" disabled>

            <input type="hidden" class="form-control" name="project_link" value="{{ $project_link }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Project Name for Respondents *

        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="project_name_resp" name="project_name_resp"
                value="{{ $projects->project_name_resp }}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Status *
        </label>
        <div class="col-md-10">
            <select id="status_id" name="status_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option @if ($projects->status_id == 1) selected @endif value="1">
                    Pending
                </option>
                <option @if ($projects->status_id == 2) selected @endif value="2">
                    Active
                </option>
                <option @if ($projects->status_id == 3) selected @endif value="3">
                    Completed
                </option>
                <option @if ($projects->status_id == 4) selected @endif value="4">
                    Cancelled
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email Subject
        </label>
        <div class="col-md-10">
            <textarea class="form-control" name="description" id="description">{{ $projects->description }}</textarea>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email Description
        </label>
        <div class="col-md-10">
            <textarea class="form-control" name="description1" id="description1">{{ $projects->description1 }}</textarea>
        </div>
    </div>



    {{-- <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email Description 2 (Pre-task only)

        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="description2" name="description2"
                value="{{ $projects->description2 }}">
        </div>
    </div> --}}

    {{-- <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Survey Duration (Minutes) *</label>
        <div class="col-md-10">
            <input type="number" class="form-control" id="survey_duration" name="survey_duration"
                value="{{ $projects->survey_duration }}">

        </div>
    </div> --}}

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Live Date *
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="published_date" name="published_date"
                value="{{ date('Y-m-d', strtotime($projects->published_date)) }}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Closing Date
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="closing_date" name="closing_date"
                value="{{ date('Y-m-d', strtotime($projects->closing_date)) }}" required>
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Accessibility *
        </label>
        <div class="col-md-10">
            <select id="access_id" name="access_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>

                <option @if ($projects->access_id == 1) selected @endif value="1">
                    Shareable
                </option>
                <option @if ($projects->access_id == 2) selected @endif value="2">
                    Unique
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Survey name *
        </label>
        <div class="col-md-10">
            <select id="survey_link" name="survey_link" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                @foreach ($survey_title as $title)
                    <option @if ($projects->survey_link == $title->id) selected @endif value="{{ $title->id }}">
                        {{ $title->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Survey Link
        </label>
        <div class="col-md-10">
            @php $survey_link=\App\Models\Projects::get_survey($projects->survey_link); @endphp
            <div class="input-group mb-3">
                <input type="text" class="form-control" value="{{ url('survey/view', $survey_link->builderID) }}"
                    name="survey" id="survey" readonly>
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2" onclick="copy_link();">Copy</span>
                </div>
            </div>
        </div>
    </div>



    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="edit_create">Update</button>
    </div>
</form>


<script>
    $("#edit_create").click(function() {

        if (!$("#edit_projects_form").valid()) { // Not Vali
            return false;
        } else {
            var data = $('#edit_projects_form').serialize();
            var id = $("#id").val();
            var url_set = "{{ route('projects.update', ':id') }}";
            url_set = url_set.replace(':id', id);

            $.ajax({
                type: 'PUT',
                url: url_set,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#edit_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');

                    // Check if the projects_table function is defined
                    if (typeof projects_table === 'function') {
                        projects_table(); // Call the function to update the projects table
                    } else {
                        setTimeout(function(){
                            location.reload(); // Reload the page if the function is not defined
                        },800);
                        
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + error);
                },
                complete: function() {
                    $('#edit_create').html('Update');
                }
            });
        }
    });

    $("#survey_link").change(function() {
        var survey = this.value;
        $.ajax({

            type: "GET",
            url: "{{ route('get_survey_link') }}",
            data: {
                "survey_id": survey,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log("response", data.repsonse);
                $("#survey").val(data.repsonse);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    });

    function copy_link() {
        var checkval = $('#survey').val();
        if (checkval != '') {
            let copyGfGText = document.getElementById("survey");
            copyGfGText.select();
            document.execCommand("copy");
            toastr.success('Survey Link Copied Successfully');
        } else {
            toastr.error('No Survey Link Found');
        }
    }
</script>
