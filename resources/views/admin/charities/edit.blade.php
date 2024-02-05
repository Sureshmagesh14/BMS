<form id="edit_charities_form">
    @csrf
    <input type="hidden" id="id" name="id" value="{{$charities->id}}">
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name *</label>
        <div class="col-md-10">
            <div class="col-md-10">
                <input type="text" class="form-control" name="name" value="{{$charities->name}}" required>
             </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Data</label>
        <div class="col-md-10">
            <textarea id="data" name="data" class="form-control" required>{{$charities->data}}</textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="charities_update">
            Update
        </button>
    </div>
</form>

<script>
    $("#charities_update").click(function () {
        if (!$("#edit_charities_form").valid()) { // Not Valid
            return false;
        } else {
            var data    = $('#edit_charities_form').serialize();
            var id      = $("#id").val();
            var url_set = "{{ route('charities.update', ':id') }}";
            url_set     = url_set.replace(':id', id);
            $.ajax({
                type: 'PUT',
                url: url_set,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#charities_update').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    datatable();
                },
                complete: function(response) {
                    $('#charities_update').html('Create New');
                }
            });
        }
    });
</script>
        