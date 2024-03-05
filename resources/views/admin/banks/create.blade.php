
<form id="bank_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Bank Name *</label>
        <div class="col-md-10">
           <input type="text" class="form-control" id="bank_name" name="bank_name" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Branch Code *</label>
        <div class="col-md-10">
           <input type="text" class="form-control" id="branch_code" name="branch_code" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Active</label>
        <div class="col-md-10">
        <select name="active" id="active" class="form-control">
            <option value="" selected disabled>Choose an option</option>
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
    </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="bank_create">Create New</button>
    </div>
</form>


<script>
    $("#bank_create").click(function () {
        if (!$("#bank_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#bank_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{route('banks.store')}}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#bank_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    datatable();
                },
                complete: function(response) {
                    $('#bank_create').html('Create New');
                }
            });
        }
    });
</script>