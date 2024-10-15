<style>
    .field-icon {
        float: right;
        margin-right: 12px;
        margin-top: -26px;
        position: relative;
        z-index: 2;
    }

    label#mobile-error {
        width: 100% !important;
    }

    label#whatsapp-error {
        width: 100% !important;
    }

    .invalid-feedback {
        display: block;
        /* Ensure it displays as a block element */
        color: #dc3545;
        /* Bootstrap's default error color */
        font-size: 0.875em;
        /* Slightly smaller font size for error messages */
        margin-top: 0.25rem;
        /* Space between input and error message */
    }

    #email-error {
        padding-left: 0;
        /* Default padding for small screens */
    }

    @media (min-width: 768px) {

        /* Adjust padding for medium and larger screens */
        #email-error {
            padding-left: 200px;
        }
    }

    #mobile-error {
        padding-left: 0;
        /* Default padding for small screens */
    }

    @media (min-width: 768px) {

        /* Adjust padding for medium and larger screens */
        #mobile-error {
            padding-left: 200px;
        }
    }
</style>
<form id="edit_respondents_form" class="validation">
    <input type="hidden" id="id" name="id" value="{{ $respondents->id }}">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ $respondents->name }}"
                placeholder="Enter Your Name" autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Surname </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter Your Surname"
                autocomplete="off" value="{{ $respondents->surname }}">
        </div>
    </div>


    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Date Of Birth </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="date_of_birth" name="date_of_birth"
                value="{{ $respondents->date_of_birth }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">RSA ID / Passport </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="id_passport" name="id_passport"
                placeholder="Enter Your RSA ID / Passport" autocomplete="off" value="{{ $respondents->id_passport }}">
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Mobile Number *
        </label>
        <div class="col-md-10">
            <div class="input-group">
                <div class="input-group-text">+27(0)</div>
                <input type="text" class="form-control" id="mobile" name="mobile" autocomplete="off"
                    value="{{ str_starts_with($respondents->mobile, '27') ? ltrim(substr($respondents->mobile, 2), '0') : ltrim($respondents->mobile, '0') }}"
                    maxlength="16" required>
            </div>
            <small class="form-text text-muted">Don’t include 0 in starting.</small>
        </div>
    </div>


    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Whatsapp Number *
        </label>
        <div class="col-md-10">
            <div class="input-group">
                <div class="input-group-text">+27(0)</div>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                    placeholder="Don’t include 0 in starting." autocomplete="off"
                    value="{{ str_starts_with($respondents->whatsapp, '27') ? ltrim(substr($respondents->whatsapp, 2), '0') : ltrim($respondents->whatsapp, '0') }}"
                    maxlength="16">

                <span id="mobile-error" class="invalid-feedback"></span>
            </div>
            <small class="form-text text-muted">Don’t include 0 in starting.</small>
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email *
        </label>
        <div class="col-md-10">
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email"
                autocomplete="off" value="{{ $respondents->email }}" required>
            <span id="email-error" class="invalid-feedback d-block mt-1"></span>
        </div>
    </div>

    <div class="form-group row" style="display: none;">
        <label for="example-search-input" class="col-md-2 col-form-label">Bank Name
        </label>
        <div class="col-md-10">
            <select id="bank_name" name="bank_name" class="w-full form-control form-select">
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                @foreach ($banks as $bank)
                    <option value="{{ $bank->id }}"
                        {{ $bank->id == old('bank_name', $respondents->bank_name) ? 'selected' : '' }}>
                        {{ $bank->bank_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- <div class="form-group row"> --}}
    {{-- <label for="example-search-input" class="col-md-2 col-form-label">Branch Code
        </label> --}}
    <div class="col-md-10">
        <input type="hidden" class="form-control" id="branch_code" autocomplete="off"
            value="{{ $respondents->branch_code }}" readonly>
        <input type="hidden" class="form-control" id="branch" name="branch_code"
            value="{{ $respondents->branch_code }}">
    </div>
    {{-- </div> --}}

    {{-- <div class="form-group row"> --}}
    {{-- <label for="example-search-input" class="col-md-2 col-form-label">Account Type --}}
    </label>
    <div class="col-md-10">
        <input type="hidden" class="form-control" id="account_type" placeholder="Enter Your Account Type"
            autocomplete="off" name="account_type" value="{{ $respondents->account_type }}">
    </div>
    {{-- </div> --}}

    {{-- <div class="form-group row"> --}}
    {{-- <label for="example-search-input" class="col-md-2 col-form-label">Account Holder --}}
    </label>
    <div class="col-md-10">
        <input type="hidden" class="form-control" id="account_holder" placeholder="Enter Your Account Holder"
            autocomplete="off" name="account_holder" value="{{ $respondents->account_holder }}">
    </div>
    {{-- </div> --}}

    {{-- <div class="form-group row"> --}}
    {{-- <label for="example-search-input" class="col-md-2 col-form-label">Account Number --}}
    </label>
    <div class="col-md-10">
        <input type="hidden" class="form-control" id="account_number" placeholder="Enter Your Account Number"
            autocomplete="off" name="account_number" value="{{ $respondents->account_number }}">
    </div>
    {{-- </div> --}}

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
        <label for="example-search-input" class="col-md-2 col-form-label">Password
        </label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="password-field"
                placeholder="Enter Your Account Password" autocomplete="off" name="password">
            <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Last Updated
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="updated_at" name="updated_at"
                value="{{ \Carbon\Carbon::parse($respondents->updated_at)->format('Y-m-d') }}">
        </div>
    </div>
    @php
        $refcode = \App\Models\Respondents::randomPassword(); #function call
    @endphp
    @if ($respondents->referral_code != null)
        @php $share_link=$respondents->referral_code; @endphp
    @else
        @php $share_link=$refcode; @endphp
    @endif
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Referral Code
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="" name=""
                value="{{ URL::to('/') . '?r=' . $share_link }}" disabled>
            <input type="hidden" class="form-control" id="referral_code" name="referral_code"
                value="{{ URL::to('/') . '?r=' . $share_link }}">
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

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Deactivated Date
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="deactivated_date" name="deactivated_date"
                value="{{ \Carbon\Carbon::parse($respondents->deactivated_date)->format('Y-m-d') }}">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="respondents_edit">Update</button>
    </div>
</form>



<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    $(function() {


        $(document).ready(function() {

            $('#date_of_birth').inputmask("yyyy/mm/dd", {
                "placeholder": "YYYY/MM/DD",
                onincomplete: function() {
                    $(this).val('');
                }
            });

            $('#mobile').inputmask("99 999 9999");
            $('#whatsapp').inputmask("99 999 9999");

            $('#edit_respondents_form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: '{{ route('user_respondent_id_check') }}',
                            type: "GET",
                            data: {
                                form_name: "useredit",
                                id: function() {
                                    return '{{ $respondents->id }}'; // Ensure this variable is properly rendered in the template
                                },
                                email: function() {
                                    return $('#email')
                                .val(); // Ensure email field value is sent
                                }
                            },
                            dataFilter: function(response) {
                                // Parse the JSON response
                                var json = JSON.parse(response);
                                // Return validation result based on 'exists' key
                                return json.exists === false ? 'true' : 'false';
                            }
                        }
                    },
                    mobile: {
                        required: true,
                        remote: {
                            url: '{{ route('user_respondent_mobile_check') }}',
                            type: "GET",
                            data: {
                                form_name: "useredit",
                                id: function() {
                                    return '{{ $respondents->id }}'; // Ensure this variable is properly rendered in the template
                                },
                                mobile: function() {
                                    return $('#mobile')
                                .val(); // Ensure email field value is sent
                                }
                            },
                            dataFilter: function(response) {
                                var json = JSON.parse(response);
                                return json.valid ? "true" : "false";
                            }
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
                        remote: "{{ __('Email Name already exists!') }}"
                    },
                    mobile: {
                        remote: "Mobile number already exists!" // Error message for mobile number
                    }
                },
                errorElement: "span", // HTML element for error messages
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback'); // Add a class for styling
                    element.closest('.form-group').append(
                        error); // Append the error message to the form group
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass(
                        'is-valid'); // Add class for invalid state
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass(
                        'is-valid'); // Add class for valid state
                }
            });

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
                    if (response.message == 'Email already exists.') {
                        toastr.error(response.message);
                        $("#commonModal").modal('hide');
                        if (typeof respondents_datatable === 'function') {
                            respondents_datatable
                        (); // Call the function to update the projects table
                        } else {
                            setTimeout(function() {
                                location
                            .reload(); // Reload the page if the function is not defined
                            }, 800);

                        }
                    } else {
                        toastr.success(response.message);
                        $("#commonModal").modal('hide');
                        if (typeof respondents_datatable === 'function') {
                            respondents_datatable
                        (); // Call the function to update the projects table
                        } else {
                            setTimeout(function() {
                                location
                            .reload(); // Reload the page if the function is not defined
                            }, 800);

                        }
                    }

                },
                complete: function(response) {
                    $('#respondents_edit').html('Create New');
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
    // Get the current date
</script>
