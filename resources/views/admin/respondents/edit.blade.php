<form id="edit_respondents_form" class="validation">
    <input type="hidden" id="id" name="id" value="{{ $respondents->id }}">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ $respondents->name }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Surname </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="surname" name="surname"
                value="{{ $respondents->surname }}">
        </div>
    </div>


    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Date Of Birth </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                value="{{ $respondents->date_of_birth }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">RSA ID / Passport </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="id_passport" name="id_passport"
                value="{{ $respondents->id_passport }}">
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Mobile Number
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $respondents->mobile }}" maxlength="16">
        </div>
    </div>


    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Whatsapp Number
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                value="{{ $respondents->whatsapp }}" maxlength="16">
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email *
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="email" name="email" value="{{ $respondents->email }}"
                required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Bank Name
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="bank_name" name="bank_name"
                value="{{ $respondents->bank_name }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Branch Code
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="branch_code" name="branch_code"
                value="{{ $respondents->branch_code }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Account Type
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="account_type" name="account_type"
                value="{{ $respondents->account_type }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Account Holder
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="account_holder" name="account_holder"
                value="{{ $respondents->account_holder }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Account Number
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="account_number" name="account_number"
                value="{{ $respondents->account_number }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Status *</label>
        <div class="col-md-10">
            <select id="active_status_id" name="active_status_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option @if ($respondents->active_status_id == 1) selected @endif value="1">Active</option>
                <option @if ($respondents->active_status_id == 2) selected @endif value="2">Deactivated</option>
                <option @if ($respondents->active_status_id == 3) selected @endif value="3">Unsubscribed</option>
                <option @if ($respondents->active_status_id == 4) selected @endif value="4">Pending</option>
                <option @if ($respondents->active_status_id == 5) selected @endif value="5">Blacklisted</option>
            </select>

        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Password *
        </label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Last Updated
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="updated_at" name="updated_at"
                value="{{ $respondents->updated_at }}">
        </div>
    </div>
    @php
        $refcode = \App\Models\Respondents::randomPassword(); #function call
    @endphp
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Referral Code
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="" name="" value="{{ $refcode }}"
                disabled>
            <input type="hidden" class="form-control" id="referral_code" name="referral_code"
                value="{{ $respondents->referral_code }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Accepted Terms *
        </label>
        <div class="col-md-10">
            <select id="accept_terms" name="accept_terms" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option @if ($respondents->accept_terms == 0) selected @endif value="0">No</option>
                <option @if ($respondents->accept_terms == 1) selected @endif value="1">Yes</option>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="respondents_edit">Update</button>
    </div>
</form>


<script>
 $(function() {
        $('#edit_respondents_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    validate_email: true,
                    remote: {
                        url: '{{ route("user_respondent_id_check") }}',
                        data: { 'form_name' : "useredit" ,'id':'{{ $respondents->id }}'},
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
                    remote: "{{__('Email Name already exists!')}}"
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

    $("#respondents_edit").click(function() {
        if (!$("#edit_respondents_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#edit_respondents_form').serialize();
            var id = $("#id").val();
            var url_set = "{{ route('respondents.update', ':id') }}";
            url_set = url_set.replace(':id', id);
            $.ajax({
                type: 'PUT',
                url: url_set,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#respondents_edit').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    respondents_datatable();
                },
                complete: function(response) {
                    $('#respondents_edit').html('Create New');
                }
            });
        }
    });
</script>
