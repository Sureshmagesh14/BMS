<form id="copy_projects_form" class="validation">
    <input type="hidden" id="id" name="id" value="{{ $projects->id }}">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name / Code *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="number" name="number" value="{{ $projects->number }}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Client *
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="client" name="client" value="{{ $projects->client }}" required>
        </div>
    </div>


    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ $projects->name }}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Creator *</label>
        <div class="col-md-10">
            <select id="user" name="user" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">Choose an option</option>
                @foreach ($users as $user)
                    <option @if($projects->user_id  == $user->id) selected @endif
                    value="{{$user->id}}">{{$user->name}} {{$user->surname}}</option>
                @endforeach
            </select>
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Type *
        </label>
        <div class="col-md-10">
            <select id="type_id" name="type_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option @if($projects->type_id==1) selected @endif value="1">
                    Pre-Screener
                </option>
                <option @if($projects->type_id==2) selected @endif value="2">
                    Pre-Task
                </option>
                <option @if($projects->type_id==3) selected @endif value="3">
                    Paid survey
                </option>
                <option @if($projects->type_id==4) selected @endif value="4">
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
            <input type="url" class="form-control" id="project_link" name="project_link"
                value="{{ Config::get('constants.url') . $refcode }}" disabled>
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
                <option @if($projects->status_id==1) selected @endif  value="1">
                    Pending
                </option>
                <option @if($projects->status_id==2) selected @endif value="2">
                    Active
                </option>
                <option @if($projects->status_id==3) selected @endif value="3">
                    Completed
                </option>
                <option @if($projects->status_id==4) selected @endif value="4">
                    Cancelled
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Description
        </label>
        <div class="col-md-10">
            <textarea class="form-control" name="description" id="description">{{ $projects->description }}</textarea>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email Description 1
        </label>
        <div class="col-md-10">
            <textarea class="form-control" name="description1" id="description1">{{ $projects->description1 }}</textarea>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email Description 2 (Pre-task only)

        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="description2" name="description2" value="{{ $projects->description2 }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Survey Duration (Minutes) *</label>
        <div class="col-md-10">
            <input type="number" class="form-control" id="survey_duration" name="survey_duration" value="{{ $projects->survey_duration }}" required>

        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Live Date *
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="published_date" name="published_date" value="{{date('Y-m-d', strtotime($projects->published_date))}}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Closing Date
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="closing_date" name="closing_date" value="{{date('Y-m-d', strtotime($projects->closing_date))}}">
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
            
                <option @if($projects->access_id==1) selected @endif value="1">
                    Shareable
                </option>
                <option @if($projects->access_id==2) selected @endif value="2">
                    Assigned
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Survey Link *
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="survey_link" name="survey_link" value="{{$projects->survey_link}}" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="copy_create">Create New</button>
    </div>
</form>


<script>
    $("#copy_create").click(function() {
        if (!$("#copy_projects_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#copy_projects_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{ route('projects.store') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#copy_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    projects_table();
                },
                complete: function(response) {
                    $('#copy_create').html('Create New');
                }
            });
        }
    });
</script>
