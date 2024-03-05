
<form id="tags_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name *</label>
        <div class="col-md-10">
            <div class="col-md-10">
                <input class="form-control" type="text" name="name" id="name" required>
             </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Type*</label>
        <div class="col-md-10">
            <div class="col-md-10">
                <input name="colour" class="form-control" type="color" value="" id="example-color-input">
             </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="tags_create">Create New</button>
    </div>
</form>


<script>
    $("#tags_create").click(function () {
        if (!$("#tags_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#tags_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{route('tags.store')}}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#tags_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    datatable();
                },
                complete: function(response) {
                    $('#tags_create').html('Create New');
                }
            });
        }
    });
</script>