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
<form id="respondents_form" class="validation" autocomplete="off">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name" autocomplete="off"
                placeholder="Enter Your Name">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Surname </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="surname" name="surname" autocomplete="off"
                placeholder="Enter Your Surname">
        </div>
    </div>


    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Date Of Birth </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">RSA ID / Passport </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="id_passport" name="id_passport" autocomplete="off"
                placeholder="Enter Your RSA ID / Passport">
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Mobile Number *
        </label>
        <div class="col-md-10">
            <div class="input-group">
                <div class="input-group-text">+27(0)</div>
                <input type="text" class="form-control" id="mobile" name="mobile" maxlength="16"
                    placeholder="Don’t include 0 in starting." autocomplete="off" required>
                <span id="mobile-error" class="invalid-feedback"></span>
            </div>
            <small class="form-text text-muted">Don’t include 0 in starting.</small>
        </div>
    </div>


    <div class="form-group row">
        <label for="whatsapp" class="col-md-2 col-form-label">WhatsApp Number *</label>
        <div class="col-md-10">
            <div class="input-group">
                <div class="input-group-text">+27</div>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp" maxlength="15"
                    autocomplete="off" placeholder="Don’t include 0 in starting." required>
            </div>
            <small class="form-text text-muted">Don’t include 0 in starting.</small>
        </div>
    </div>




    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email *
        </label>
        <div class="col-md-10">
            <input type="email" class="form-control" id="email" name="email" autocomplete="off" required
                placeholder="Enter Your Email">
            <span id="email-error" class="invalid-feedback d-block mt-1"></span>
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
            <input type="text" class="form-control" id="account_type" name="account_type" autocomplete="off"
                placeholder="Enter Your Account Type">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Account Holder
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="account_holder" name="account_holder"
                placeholder="Enter Your Account Holder" autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Account Number
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="account_number" name="account_number"
                placeholder="Enter Your Account Number" autocomplete="off">
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
            <input type="password" class="form-control" id="password-field" name="password" autocomplete="off"
                placeholder="Enter Your Password" required>
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

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Deactivated Date
        </label>
        <div class="col-md-10">
            <input class="form-control" type="date" name="deactivated_date" id="deactivated_date">
        </div>
    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="respondents_create">Create New</button>
    </div>
</form>


<script>
    $(function() {

        $('#date_of_birth').inputmask("yyyy/mm/dd", {
            "placeholder": "YYYY/MM/DD",
            onincomplete: function() {
                $(this).val('');
            }
        });

        $('#mobile').inputmask("99 999 9999");
        $('#whatsapp').inputmask("99 999 9999");
        $(document).ready(function() {
          
                $('#respondents_form').validate({
                    rules: {
                        email: {
                            required: true,
                            email: true,
                            remote: {
                                url: '{{ route('user_respondent_id_check') }}',
                                type: "GET",
                                data: {
                                    email: function() {
                                        return $('#email')
                                            .val(); // Ensure this matches the input's ID or name
                                    },
                                    form_name: "usercreate"
                                },
                                dataFilter: function(response) {
                                    // Parse the JSON response from the server
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
                                    mobile: function() {
                                        return $('#mobile')
                                            .val(); // Ensure this matches the input's ID or name
                                    },
                                    form_name: "usercreate"
                                },
                                dataFilter: function(response) {
                                    var json = JSON.parse(response);
                                    return json.valid ? "true" : "false";
                                }
                            }
                        },
                        password: {
                            required: true,
                            minlength: 8
                        }
                    },
                    messages: {
                        email: {
                            remote: "Email already exists!" // Display this message if the email is not valid
                        },
                        mobile: {
                            remote: "Mobile number already exists!" // Error message for mobile number
                        }
                    },
                    errorElement: "span", // HTML element for error messages
                    errorPlacement: function(error, element) {
                        error.addClass(
                            'invalid-feedback'); // Add a class for styling
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
    // Get the current date
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    // Format the date
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }

    today = yyyy + '-' + mm + '-' + dd;

    // Set the minimum date
    document.getElementById("deactivated_date").setAttribute("min", today);
</script>
