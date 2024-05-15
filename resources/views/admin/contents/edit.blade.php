<form id="content_form">
    @csrf
    <input type="hidden" id="update_type" name="update_type">
    <input type="hidden" id="id" name="id" value="{{$content->id}}">
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Type*</label>
        <div class="col-md-10">
            <select name="type_id" id="type_id" class="form-control" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option @if($content->type_id==1) selected @endif value="1">Terms of use</option>
                <option @if($content->type_id==2) selected @endif value="2">Terms and Condition</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-search-input"
            class="col-md-2 col-form-label">Search</label>
        <div class="col-md-10">
            <textarea id="data" name="data" class="form-control" required>{{$content->data}}</textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="content_update">
            Update
        </button>
    </div>
</form>

<script>
    $("#content_update").click(function () {
        if (!$("#content_form").valid()) { // Not Valid
            return false;
        } else {
            var data    = $('#content_form').serialize();
            var id      = $("#id").val();
            var url_set = "{{ route('contents.update', ':id') }}";
            url_set     = url_set.replace(':id', id);
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
                    $('#content_update').html('Create New');
                }
            });
        }
    });
</script>
        