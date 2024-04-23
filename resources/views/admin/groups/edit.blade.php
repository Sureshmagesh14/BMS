<form id="edit_groups_form">
    @csrf
    <input type="hidden" id="id" name="id" value="{{$groups->id}}">
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name" value="{{$groups->name}}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Type *</label>
        <div class="col-md-10">
            <select id="type_id" dusk="type_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option @if($groups->type_id==1) selected @endif value="1">Basic</option>
                <option @if($groups->type_id==2) selected @endif value="2">Essential</option>
                <option @if($groups->type_id==3) selected @endif value="3">Extended</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Survey URL *</label>
        <div class="col-md-10">
            <select id="survey_url" name="survey_url" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                @foreach ($survey_title as $title)
                    <option @if ($groups->survey_link == $title->id) selected @endif value="{{ $title->id }}">
                        {{ $title->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="groups_update">
            Update
        </button>
    </div>
</form>

<script>
    $("#groups_update").click(function () {
        if (!$("#edit_groups_form").valid()) { // Not Valid
            return false;
        } else {
            var data    = $('#edit_groups_form').serialize();
            var id      = $("#id").val();
            var url_set = "{{ route('groups.update', ':id') }}";
            url_set     = url_set.replace(':id', id);
            $.ajax({
                type: 'PUT',
                url: url_set,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#groups_update').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    datatable();
                },
                complete: function(response) {
                    $('#groups_update').html('Create New');
                }
            });
        }
    });
</script>
        