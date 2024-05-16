<form id="edit_bank_form">
    @csrf
    <input type="hidden" id="id" name="id" value="{{$banks->id}}">
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Bank Name *</label>
        <div class="col-md-10">
           <input type="text" class="form-control" id="bank_name" name="bank_name"  value="{{$banks->bank_name}}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Branch Code *</label>
        <div class="col-md-10">
           <input type="text" class="form-control" id="branch_code" name="branch_code"  value="{{$banks->branch_code}}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Active</label>
        <div class="col-md-10">
        <select name="active" id="active" class="form-control">
            <option value="" selected disabled>Choose an option</option>
            <option @if($banks->active==0) selected @endif value="0">No</option>
            <option @if($banks->active==1) selected @endif value="1">Yes</option>
        </select>
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="banks_update">
            Update
        </button>
    </div>
</form>

<script>
    $("#banks_update").click(function () {
        if (!$("#edit_bank_form").valid()) { // Not Valid
            return false;
        } else {
            var data    = $('#edit_bank_form').serialize();
            var id      = $("#id").val();
            var url_set = "{{ route('banks.update', ':id') }}";
            url_set     = url_set.replace(':id', id);
            $.ajax({
                type: 'PUT',
                url: url_set,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#banks_update').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    banks_table();
                },
                complete: function(response) {
                    $('#banks_update').html('Create New');
                }
            });
        }
    });
</script>
        