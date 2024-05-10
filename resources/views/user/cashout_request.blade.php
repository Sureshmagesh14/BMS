<style>
    select {width: 100%;margin-bottom: 0px !important;}
</style>
<form action="{{route('cashout_sent')}}" method="POST" class="validation">
    @csrf
    <input type="hidden" name="reward" value="{{ $points }}">
    <div class="form-group row">
        <label for="example-text-input" class="col-md-3 col-form-label">Bank *</label>
        <div class="col-md-9">
            <select name="bank_value" class="form-control" required>
                <option value="">Select Bank</option>
                @foreach ($banks as $bank)
                    <option value="{{$bank->id}}">{{$bank->bank_name}} - {{$bank->branch_code}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-3 col-form-label">Branch Name *</label>
        <div class="col-md-9">
            <input type="text" name="branch_name" class="form-control" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-3 col-form-label">Account Number *</label>
        <div class="col-md-9">
            <input type="text" name="account_number" class="form-control" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-3 col-form-label">Account Holder Name *</label>
        <div class="col-md-9">
            <input type="text" name="holder_name" class="form-control" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="bank_create">Request Confirmation</button>
    </div>
</form>
