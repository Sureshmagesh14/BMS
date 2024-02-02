
<form id="charities_form" class="validation">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name *</label>
        <div class="col-md-10">
           <input type="text" class="form-control" name="name" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Data</label>
        <div class="col-md-10">
            <textarea id="data" name="data" class="form-control" required></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="charities_create">Create New</button>
    </div>
</form>


<script>
    $("#charities_create").click(function () {
        if (!$("#charities_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#charities_form').serialize();

            $.ajax({
                type: 'POST',
                url: "{{route('charities.store')}}",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#charities_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    datatable();
                },
                complete: function(response) {
                    $('#charities_create').html('Create New');
                }
            });
        }
    });
</script>