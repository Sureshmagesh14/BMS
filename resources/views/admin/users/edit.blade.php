<form id="edit_users_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Surname *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="surname" name="surname" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">RSA ID / Passport *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="id_passport" name="id_passport" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="id_passport" name="id_passport" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Password *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="id_passport" name="id_passport" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Password Confirmation </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="id_passport" name="id_passport">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Role * </label>
        <div class="col-md-10">
            <select id="role_id" name="role_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                Choose an option
              </option> <option value="1">
                Admin
              </option><option value="2">
                User
              </option><option value="3">
                Temp
              </option></select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Status * </label>
        <div class="col-md-10">
            <select id="status_id" name="status_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                Choose an option
              </option> <option value="1">
                Active
              </option><option value="2">
                Inactive
              </option></select>
          
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Share Link  </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="id_passport" name="id_passport">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="users_update">Create New</button>
    </div>
</form>


<script>
    $("#users_update").click(function() {
        if (!$("#edit_users_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#edit_users_form').serialize();
            var id      = $("#id").val();
            var url_set = "{{ route('users.update', ':id') }}";
            url_set     = url_set.replace(':id', id);
            $.ajax({
                type: 'PUT',
                url: url_set,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#users_update').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    datatable();
                },
                complete: function(response) {
                    $('#users_update').html('Create New');
                }
            });
        }
    });
</script>
