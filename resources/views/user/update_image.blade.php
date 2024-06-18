@include('user.layout.header-2')
<style>
    .container {
        max-width: 960px;
        margin: 30px auto;
        padding: 20px;
    }

    h1 {
        font-size: 20px;
        text-align: center;
        margin: 20px 0 20px;

        small {
            display: block;
            font-size: 15px;
            padding-top: 8px;
            color: gray;
        }
    }

    .avatar-upload {
        position: relative;
        max-width: 205px;
        margin: 50px auto;

        .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;

            input {
                display: none;

                +label {
                    display: inline-block;
                    width: 34px;
                    height: 34px;
                    margin-bottom: 0;
                    border-radius: 100%;
                    background: #FFFFFF;
                    border: 1px solid transparent;
                    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                    cursor: pointer;
                    font-weight: normal;
                    transition: all .2s ease-in-out;

                    &:hover {
                        background: #f1f1f1;
                        border-color: #d6d6d6;
                    }

                    &:after {
                        content: "\f040";
                        font-family: 'FontAwesome';
                        color: #757575;
                        position: absolute;
                        top: 10px;
                        left: 0;
                        right: 0;
                        text-align: center;
                        margin: auto;
                    }
                }
            }
        }

        .avatar-preview {
            width: 192px;
            height: 192px;
            position: relative;
            border-radius: 100%;
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);

            >div {
                width: 100%;
                height: 100%;
                border-radius: 100%;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }
        }
    }

    button#profile:hover {
        background-color: #6396b1;
        color: #fff;
    }
</style>
<section class="bg-greybg vh-100">
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-md-6 yelow-bg text-center d-none-mobile">
                <img class="img-fluid m-auto w-75" src="{{ asset('assets/images/img44.png') }}" alt="">
            </div>
            <div class="col-md-6 bg-white p-5">
                <div class="text-center">
                    @php
                        $profile_image = $data->profile_image ?? '';
                        $profile_path = $data->profile_path ?? '';
                    @endphp
                    <form class="validation" id="image-upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <h1>Change Profile</h1>
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input name="image" type='file' id="imageUpload"
                                        accept=".png, .jpg, .jpeg,.gif" />
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview"
                                        @if ($profile_image != null) style="background-image: url({{ asset($profile_path . $profile_image) }});" @else style="background-image: url({{ asset('assets/images/avatar.png') }});" @endif
                                        height="10">
                                    </div>
                                </div>
                                <span class="text-danger" id="image-input-error"></span>
                            </div>
                        </div>

                        <div class="submit-btn text-start">
                            <button type="submit" id="profile"
                                class="btn vi-nav-bg border-radius-0 text-white px-5 py-3 w-100">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('user.layout.footer')

<!--  jquery script  -->
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
<!--  validation script  -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {

        $('#nav_profile').addClass('active');
    });



    $('#image-upload').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('#image-input-error').text('');

        $.ajax({
            type: 'POST',
            url: "{{ route('user.image_update') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                if (response.status == 400) {
                    this.reset();
                    toastr.info(response.message);
                } else if (response.status == 500) {
                    this.reset();
                    toastr.error(response.message);
                } else {
                    this.reset();
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);

                }

            },
            error: function(response) {
                $('#image-upload').find(".print-error-msg").find("ul").html('');
                $('#image-upload').find(".print-error-msg").css('display', 'block');
                $.each(response.responseJSON.errors, function(key, value) {
                    $('#image-upload').find(".print-error-msg").find("ul").append('<li>' +
                        value + '</li>');
                });
            }
        });
    });

    $(function() {
        $('#reg_form').validate({
            rules: {

                current_password: {
                    required: true,
                    minlength: 6
                },
                new_password: {
                    required: true,
                    minlength: 6,

                }
            },

        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).on('change', '#imageUpload', function() {
        var fileExtension = ['jpeg', 'jpg', 'png', 'pdf', 'gif'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $('button#profile').prop('disabled', true);
            $("#image-input-error").html("Upload only pdf, jpeg, jpg, png, gif");

            return false;
        } else {
            readURL(this);
            $('button#profile').prop('disabled', false);
            $("#image-input-error").hide();
            return true;
        }
    });
</script>
