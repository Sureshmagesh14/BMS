<form id="projects_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Project Number *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="number" name="number">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Client Name *
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="client" name="client">
        </div>
    </div>


    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Project Name *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name" oninput="validateProjectName()"
                required>
            <div id="name-error" class="text-danger"></div>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Creator *</label>
        <div class="col-md-10">
            <select id="user" name="user" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">Choose an option</option>
                @foreach ($users as $user)
                    <option @if (Session::has('user_to_project_id')) 
                            @if (Session::get('user_to_project_id') == $user->id) selected @endif
                            @else 
                            @if (Auth::guard('admin')->user()->id == $user->id) selected @endif                            
                            @endif
                        value="{{ $user->id }}">{{ $user->name }} {{ $user->surname }}</option>
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
                {{-- <option value="1">
                    Pre-Screener
                </option> --}}
                <option value="2">
                    Pre-Task
                </option>
                <option value="3">
                    Paid survey
                </option>
                <option value="4">
                    Unpaid survey
                </option>
            </select>
        </div>
    </div>


    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Reward Amount (R)
        </label>
        <div class="col-md-10">
            <input type="number" class="form-control" id="reward" name="reward">
        </div>
    </div>

    @php
        $refcode = \App\Models\Respondents::randomPassword(); #function call
    @endphp

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Project Link
        </label>
        <div class="col-md-10">
            <input type="url" class="form-control" id="project_link" value="{{ url('share_project', $refcode) }}" disabled>
            <input type="hidden" class="form-control" name="project_link" value="{{ $refcode }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Project Name for Respondents *

        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="project_name_resp" name="project_name_resp" required>
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
                <option value="1">
                    Pending
                </option>
                <option value="2">
                    Active
                </option>
                <option value="3">
                    Completed
                </option>
                <option value="4">
                    Cancelled
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email Subject
        </label>
        <div class="col-md-10">
            <textarea class="form-control" name="description" id="description"></textarea>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email Description 1
        </label>
        <div class="col-md-10">
            <textarea class="form-control" name="description1" id="description1"></textarea>
        </div>
    </div>



    {{-- <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email Description 2 (Pre-task only)

        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="description2" name="description2">
        </div>
    </div> --}}

    {{-- <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Survey Duration (Minutes) *</label>
        <div class="col-md-10">
            <input type="number" class="form-control" id="survey_duration" name="survey_duration">

        </div>
    </div> --}}

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Live Date *
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="published_date" name="published_date" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Closing Date
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="closing_date" name="closing_date">
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
                <option value="1">
                    Shareable
                </option>
                <option value="2">
                    Unique
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Survey Name*
        </label>
        <div class="col-md-10">
            <select id="survey_link" name="survey_link" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                @foreach ($survey_title as $title)
                    <option value="{{ $title->id }}">
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
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="survey" id="survey" readonly>
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2" onclick="copy_link();">Copy</span>
                </div>
            </div>
        </div>
    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="projects_create">Create New</button>
    </div>
</form>


<script>
     $(function() {
        var today = new Date().toISOString().split('T')[0];
        $("#published_date").val(today);

        var endday = new Date();
        endday.setFullYear(endday.getFullYear() + 1);  // Add 1 year
        var formattedDate = endday.toISOString().split('T')[0];
        $("#closing_date").val(formattedDate);


    });

    function validateProjectName() {
        var input = document.getElementById("name");
        var errorDiv = document.getElementById("name-error");
        var regex = /^[A-Za-z0-9\-]+$/;
        var value = input.value;

        if (!regex.test(value)) {
            errorDiv.textContent = "Only letters, numbers, and dashes are allowed.";
            input.setCustomValidity("Invalid input");
        } else {
            errorDiv.textContent = "";
            input.setCustomValidity("");
        }
    }
    $("#projects_create").click(function() {
        validateProjectName(); // Validate the project name before form submission

        if (!$("#projects_form")[0].checkValidity()) { // Not Valid
            return false;
        } else {
            var data = $('#projects_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{ route('projects.store') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#projects_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    projects_table();
                },
                complete: function(response) {
                    $('#projects_create').html('Create New');
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
