
<form id="content_create_form-data">
    @csrf
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Type*</label>
        <div class="col-md-10">
            <select name="type_id" id="type_id" class="form-control" required>
                <option value="" selected disabled>Choose an option</option>
                <option value="1">Terms of use</option>
                <option value="2">Terms and Condition</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Search</label>
        <div class="col-md-10">
            <textarea id="data" name="data" class="form-control" required></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="create_and_store" 
            data-create_route="{{route('contents.store')}}" data-form_name="content_create_form-data">
            Create New
        </button>
    </div>
</form>