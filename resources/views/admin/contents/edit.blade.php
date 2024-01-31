<form id="content_update_form-data">
    @csrf
    <input type="hidden" id="update_type" name="update_type">
    <input type="hidden" id="id" name="id" value="{{$content->id}}">
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Type
            *</label>
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
        <button type="button" class="btn btn-primary" id="update_and_edit" 
            data-create_route="{{route('contents.update')}}" data-form_name="content_update_form-data">
            Update
        </button>
    </div>
</form>

<script>
    

    
</script>
        