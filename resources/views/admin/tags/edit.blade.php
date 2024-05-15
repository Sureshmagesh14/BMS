
<form id="edit_tags_form" class="validation">
    <input type="hidden" id="id" name="id" value="{{$tags->id}}">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name *</label>
        <div class="col-md-10">
            <div class="col-md-10">
                <input class="form-control" type="text" name="name" value="{{$tags->name}}" id="name" required>
             </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Type*</label>
        <div class="col-md-10">
            <div class="col-md-10">
                <input class="form-control" type="color" name="colour" value="{{$tags->colour}}"  id="example-color-input">
             </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="tags_update">Create New</button>
    </div>
</form>


<script>
    $("#edit_tags_form").click(function () {
        if (!$("#edit_tags_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#edit_tags_form').serialize();
            var id      = $("#id").val();
            var url_set = "{{ route('tags.update', ':id') }}";
            url_set     = url_set.replace(':id', id);
            $.ajax({
                type: 'POST',
                url: url_set,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#tags_update').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    tags_table();
                },
                complete: function(response) {
                    $('#tags_update').html('Create New');
                }
            });
        }
    });
</script>