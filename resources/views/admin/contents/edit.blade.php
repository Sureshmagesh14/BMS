@php
    $form_name = 'contentupdate'; // Set this based on your context
@endphp
<form id="content_form">
    @csrf
    <input type="hidden" id="update_type" name="update_type">
    <input type="hidden" id="id" name="id" value="{{ $content->id }}">

    <div class="form-group row">
        <label for="type_id" class="col-md-2 col-form-label">Type*</label>
        <div class="col-md-10">
            <select name="type_id" id="type_id" class="form-control" required>
                <option value="" selected="selected" disabled="disabled">Choose an option</option>
                <option @if ($content->type_id == 1) selected @endif value="1">Terms of use</option>
                <option @if ($content->type_id == 2) selected @endif value="2">Terms and Condition</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="data" class="col-md-2 col-form-label">Content</label>
        <div class="col-md-10">
            <textarea id="data" name="data" class="form-control" required>{{ $content->data }}</textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="content_update">Update</button>
    </div>
</form>
<script>
    $("#content_update").click(function() {
        if (!$("#content_form").valid()) { // Not Valid
            return false;
        } else {
            // Serialize form data and include TinyMCE content
            var data = $('#content_form').serialize();
            var id = $("#id").val();
            var url_set = "{{ route('contents.update', ':id') }}";
            url_set = url_set.replace(':id', id);

            // Add TinyMCE content to form data
            data += '&data=' + encodeURIComponent(tinyMCE.get('data').getContent());

            $.ajax({
                type: 'PUT',
                url: url_set,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#content_update').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    contents_table();
                },
                complete: function(response) {
                    $('#content_update').html('Update');
                }
            });
        }
    });

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
                                return $("#type_id").val(); // Get the value from the select input
                            },
                            form_name: function() {
                                return "{{ $form_name }}"; // Pass form_name dynamically, ensure it's set correctly
                            },
                            id: function() {
                                return "{{ $content->id ?? '' }}"; // For updates, pass the id if available
                            }
                        }
                    }
                }
            },
            messages: {
                type_id: {
                    remote: "Type Name already exists!" // Error message to display
                }
            }
        });

        // Initialize TinyMCE editor
        tinymce.init({
            selector: '#data',
            plugins: 'advlist autolink lists link image charmap preview anchor textcolor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            menubar: false,
            height: 300,
            branding: false,
            setup: function(editor) {
                editor.on('init', function() {
                    // Optionally, you can use the editor.setContent to set initial content
                });
            }
        });
    });
</script>
