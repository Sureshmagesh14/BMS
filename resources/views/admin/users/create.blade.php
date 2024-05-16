<form id="users_form" class="validation">
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
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Password *</label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Password Confirmation </label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="cpassword" name="cpassword">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Role * </label>
        <div class="col-md-10">
            <select id="role_id" name="role_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">Choose an option</option>
                <option value="1">Admin</option>
                <option value="2">User</option>
                <option value="3">Temp</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Status * </label>
        <div class="col-md-10">
            <select id="status_id" name="status_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">Choose an option</option>
                <option value="1">Active</option>
                <option value="2">Inactive</option>
            </select>
        </div>
    </div>
    @php
        $share_link = \App\Models\User::share_link(); #function call
    @endphp
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Share Link </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="" name="" value="{{ $share_link }}"
            disabled>
        <input type="hidden" class="form-control" id="share_link" name="share_link"
            value="{{ $share_link }}">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="users_create">Create New</button>
    </div>
</form>


<script>
    $("#users_create").click(function() {
        if (!$("#users_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#users_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{ route('users.store') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#users_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    user_datatable();
                },
                complete: function(response) {
                    $('#users_create').html('Create New');
                }
            });
        }
    });

    $(function() {
        $('#users_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    validate_email: true,
                    remote: {
                        url: '{{ route("user_email_id_check") }}',
                        data: { 'form_name' : "usercreate" },
                        type: "GET"
                    }
                },
                password: {
                    required: true,
                    minlength: 8
                },
                cpassword: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password"
                }
            },
            messages: {
                email: {
                    remote: "{{__('email Name already exists!')}}"
                }
            }
        });
    });

    $.validator.addMethod("validate_email", function(value, element) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {
            return true;
        } else {
            return false;
        }
    }, "Please enter a valid email address.");
</script>
