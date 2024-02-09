<form id="respondents_form" class="validation" action="{{url('cash_export')}}">
    @csrf

    <div class="form-group row">
    <label class="col-md-2 col-form-label">Choose Module</label>
    <div class="col-md-10">
    
    
    <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="module_name" id="exampleRadios1" value="cash_summary_export" checked="">
        <label class="form-check-label" for="exampleRadios1">
        Cash Outs Summary by Month & Year
        </label>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="module_name" id="exampleRadios2" value="cash_summary_resp_export" checked="">
        <label class="form-check-label" for="exampleRadios2">
        Cash Outs Summary by Respondent
        </label>
    </div>

    
    </div>
    </div>
   
    <div class="form-group row">
    <label class="col-md-2 col-form-label">Date Range</label>
    <div class="col-md-10">
    <div class="input-daterange input-group" data-provide="datepicker" data-date-format="dd M, yyyy" data-date-autoclose="true">
    <input type="text" class="form-control" name="start" />
    <input type="text" class="form-control" name="end" />
    </div>
    </div>
    </div>

    
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="respondents_create">Export</button>
    </div>
</form>
