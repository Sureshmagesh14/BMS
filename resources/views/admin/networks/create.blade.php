
<form id="network_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Type*</label>
        <div class="col-md-10">
            <div class="col-md-10">
                <input class="form-control" type="text" name="name" id="name" required>
             </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="network_create">Create New</button>
    </div>
</form>

<script>
    $("#network_create").click(function () {
        if (!$("#network_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#network_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{route('networks.store')}}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#network_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    network_table();
                },
                complete: function(response) {
                    $('#network_create').html('Create New');
                }
            });
        }
    });
</script>