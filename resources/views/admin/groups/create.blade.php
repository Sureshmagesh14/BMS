<form id="groups_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Type *</label>
        <div class="col-md-10">
            <select id="type_id" name="type_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option value="1">
                    Basic
                </option>
                <option value="2">
                    Essential
                </option>
                <option value="3">
                    Extended
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Survey URL *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="survey_url" name="survey_url" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="groups_create">Create New</button>
    </div>
</form>


<script>
    $("#groups_create").click(function() {
        if (!$("#groups_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#groups_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{ route('groups.store') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#groups_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    datatable();
                },
                complete: function(response) {
                    $('#groups_create').html('Create New');
                }
            });
        }
    });
</script>
