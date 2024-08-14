<form id="content_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="type_id" class="col-md-2 col-form-label">Type*</label>
        <div class="col-md-10">
            <select name="type_id" id="type_id" class="form-control" required>
                <option value="" selected disabled>Choose an option</option>
                <option value="1">Terms of use</option>
                <option value="2">Terms and Condition</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="data" class="col-md-2 col-form-label">Content</label>
        <div class="col-md-10">
            <textarea id="data" name="data" class="form-control" required></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="content_create">Create New</button>
    </div>
</form>


<script>
    $(function() {
        $('#content_form').validate({
            rules: {
                type_id: {
                    required: true,
                    remote: {
                        url: '{{ route('check_content_duplicate') }}',
                        type: "GET",
                        data: {
                            type_id: function() {
                                return $("#type_id").val();
                            }
                        }
                    }
                }
            },
            messages: {
                type_id: {
                    remote: "{{ __('Type Name already exists!') }}"
                }
            }
        });

        // Initialize TinyMCE editor
        tinymce.init({
            selector: '#data', // Apply TinyMCE to the textarea with id 'data'
            plugins: 'advlist autolink lists link image charmap preview anchor textcolor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            menubar: false,
            height: 300, // Adjust height as needed
            branding: false, // Remove TinyMCE branding
            // Remove content if it exists (optional)
            setup: function(editor) {
                editor.on('init', function() {
                    editor.setContent('');
                });
            }
        });
    });

    $("#content_create").click(function() {
        if (!$("#content_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#content_form').serialize();

            // Add TinyMCE content to form data
            data += '&data=' + encodeURIComponent(tinyMCE.get('data').getContent());

            $.ajax({
                type: 'POST',
                url: "{{ route('contents.store') }}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#content_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    contents_table();
                },
                complete: function(response) {
                    $('#content_create').html('Create New');
                }
            });
        }
    });
</script>
