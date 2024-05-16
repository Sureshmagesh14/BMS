<form id="edit_network_form">
    @csrf
    <input type="hidden" id="id" name="id" value="{{$network->id}}">
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Type*</label>
        <div class="col-md-10">
        <input class="form-control" type="text" name="name" id="name" value="{{$network->name}}">
        </div>
    </div>
   
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="network_update">
            Update
        </button>
    </div>
</form>

<script>
    $("#network_update").click(function () {
        if (!$("#edit_network_form").valid()) { // Not Valid
            return false;
        } else {
            var data    = $('#edit_network_form').serialize();
            var id      = $("#id").val();
            var url_set = "{{ route('networks.update', ':id') }}";
            url_set     = url_set.replace(':id', id);
            $.ajax({
                type: 'PUT',
                url: url_set,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#network_update').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    network_table();
                },
                complete: function(response) {
                    $('#network_update').html('Create New');
                }
            });
        }
    });
</script>
        