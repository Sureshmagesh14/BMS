<style>
    .field-icon {
        float: right;
        margin-right: 12px;
        margin-top: -26px;
        position: relative;
        z-index: 2;
    }
</style>
<form id="edit_users_form" class="validation" autocomplete="off">
    <input type="hidden" id="id" name="id" value="{{ $users->id }}">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" autocomplete="off" value="{{ $users->name }}"
                required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Surname *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter Your Surname" autocomplete="off" value="{{ $users->surname }}"
                required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">RSA ID / Passport *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="id_passport" name="id_passport" placeholder="Enter Your RSA ID / Passport" autocomplete="off"
                value="{{ $users->id_passport }}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email *</label>
        <div class="col-md-10">
            <input type="email" class="form-control" id="email" name="email" autocomplete="off" placeholder="Enter Your Email" value="{{ $users->email }}"
                required>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Password </label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password" autocomplete="off">
            <span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Password Confirmation </label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Re-enter Your Password" autocomplete="off">
            <span toggle="#cpassword" class="fa fa-fw fa-eye-slash field-icon toggle-password1"></span>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Role * </label>
        <div class="col-md-10">
            <select id="role_id" name="role_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option @if ($users->role_id == 1) selected @endif value="1">
                    Super User
                </option>
                <option @if ($users->role_id == 2) selected @endif value="2">
                    User
                </option>
                <option @if ($users->role_id == 3) selected @endif value="3">
                    Temp
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Status * </label>
        <div class="col-md-10">
            <select id="status_id" name="status_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option @if ($users->status_id == 1) selected @endif value="1">
                    Active
                </option>
                <option @if ($users->status_id == 2) selected @endif value="2">
                    Inactive
                </option>
            </select>

        </div>
    </div>
    @php
        $sharelink = \App\Models\User::share_link(); #function call
    @endphp
    @if ($users->share_link != null)
        @php $share_link=$users->share_link; @endphp
    @else
        @php $share_link=$sharelink; @endphp
    @endif
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Share Link
        </label>
        <div class="col-md-10">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="share_link_url" name=""
                    value="{{ Config::get('constants.url') . '/?r=' . $share_link }}" readonly>
                <input type="hidden" class="form-control" id="share_link" name="share_link"
                    value="{{ Config::get('constants.url') . '/' . $share_link }}">
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2" onclick="copy_link();">Copy</span>
                </div>
            </div>
        </div>
    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="users_edit">Update</button>
    </div>
</form>



<script>
    $("#users_edit").click(function() {
        if (!$("#edit_users_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#edit_users_form').serialize();
            var id = $("#id").val();
            var url_set = "{{ route('users.update', ':id') }}";
            url_set = url_set.replace(':id', id);
            $.ajax({
                type: 'PUT',
                url: url_set,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#users_edit').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    datatable();
                },
                complete: function(response) {
                    $('#users_edit').html('Create New');
                }
            });
        }
    });

    $(function() {
        $('#edit_users_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    validate_email: true,
                    remote: {
                        url: '{{ route('user_email_id_check') }}',
                        data: {
                            'form_name': "useredit",
                            'id': '{{ $users->id }}'
                        },
                        type: "GET"
                    }
                },
                password: {

                    minlength: 8
                },
                cpassword: {

                    minlength: 8,
                    equalTo: "#password"
                }
            },
            messages: {
                email: {
                    remote: "{{ __('email Name already exists!') }}"
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

    function copy_link() {
        var checkval = $('#share_link_url').val();
        if (checkval != '') {
            let copyGfGText = document.getElementById("share_link_url");
            copyGfGText.select();
            document.execCommand("copy");
            toastr.success('Sharable Link Copied Successfully');
        } else {
            toastr.error('No Survey Link Found');
        }
    }
    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $(".toggle-password1").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $(document).ready(function() {
    // Ensure autocomplete="new-password" is applied to password fields
    $('#password').attr('autocomplete', 'new-password');
    $('#cpassword').attr('autocomplete', 'new-password');

    // Clear autofill values if browser still autofills despite autocomplete="off"
    $('#password').on('focus', function() {
        $(this).attr('type', 'password');
    });

    $('#cpassword').on('focus', function() {
        $(this).attr('type', 'password');
    });
  });
</script>
