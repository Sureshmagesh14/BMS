<style>
    .field-icon {
        float: right;
        margin-right: 12px;
        margin-top: -26px;
        position: relative;
        z-index: 2;
    }
</style>
<form id="respondents_form" class="validation" autocomplete="off">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name" autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Surname </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="surname" name="surname" autocomplete="off">
        </div>
    </div>


    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Date Of Birth </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">RSA ID / Passport </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="id_passport" name="id_passport" autocomplete="off">
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Mobile Number
        </label>
        <div class="col-md-10">
            <div class="input-group">
                <div class="input-group-text">+27</div>
                <input type="text" class="form-control" id="mobile" name="mobile" maxlength="16" autocomplete="off">
            </div>
        </div>
    </div>


    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Whatsapp Number
        </label>
        <div class="col-md-10">
            <div class="input-group">
                <div class="input-group-text">+27</div>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp" maxlength="16" autocomplete="off">
            </div>
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email *
        </label>
        <div class="col-md-10">
            <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Bank Name
        </label>
        <div class="col-md-10">
            <select id="bank_name" name="bank_name" class="w-full form-control form-select">
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                @foreach ($banks as $bank)
                    <option value="{{ $bank->id }}">
                        {{ $bank->bank_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Branch Code
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="branch_code" readonly>
            <input type="hidden" class="form-control" id="branch" name="branch_code" autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Account Type
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="account_type" name="account_type" autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Account Holder
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="account_holder" name="account_holder" autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Account Number
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="account_number" name="account_number" autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Status *</label>
        <div class="col-md-10">
            <select id="active_status_id" name="active_status_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option value="1">
                    Active
                </option>
                <option value="4">
                    Pending
                </option>
                <option value="2">
                    Deactivated
                </option>
                <option value="3">
                    Unsubscribed
                </option>
                <option value="5">
                    Blacklisted
                </option>
            </select>

        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Password *
        </label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="password-field" name="password" autocomplete="off" required>
            <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Last Updated
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="updated_at" name="updated_at">
        </div>
    </div>
    @php
        $refcode = \App\Models\Respondents::randomPassword(); #function call
    @endphp
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Referral Code
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="" name=""
                value="{{ URL::to('/') . '?r=' . $refcode }}" disabled>
            <input type="hidden" class="form-control" id="referral_code" name="referral_code"
                value="{{ URL::to('/') . '?r=' . $refcode }}">
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
                <option value="0">
                    No
                </option>
                <option value="1">
                    Yes
                </option>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="respondents_create">Create New</button>
    </div>
</form>


<script>
    $(function() {

        $('#mobile').inputmask("999 999 999");
        $('#whatsapp').inputmask("999 999 999");
        $('#respondents_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    validate_email: true,
                    remote: {
                        url: '{{ route('user_respondent_id_check') }}',
                        data: {
                            'form_name': "usercreate"
                        },
                        type: "GET"
                    }
                },
                password: {
                    required: true,
                    minlength: 8
                },

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

    $("#respondents_create").click(function() {
        if (!$("#respondents_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#respondents_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{ route('respondents.store') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#respondents_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    respondents_datatable();
                },
                complete: function(response) {
                    $('#respondents_create').html('Create New');
                }
            });
        }
    });

    $("#bank_name").change(function() {
        var bank_id = this.value;
        $.ajax({

            type: "GET",
            url: "{{ route('get_branch_code') }}",
            data: {
                "bank_id": bank_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $("#branch_code").val(data.repsonse);
                $("#branch").val(data.repsonse);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    });

    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
