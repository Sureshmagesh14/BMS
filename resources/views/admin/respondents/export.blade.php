<form id="respondents_form" class="validation" action="{{url('respondent_export')}}">
    @csrf

    <div class="form-group row">
    <label class="col-md-2 col-form-label">Choose Module</label>
    <div class="col-md-10">
    
    
    <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="module_name" id="exampleRadios1" value="respondent_export" checked="">
        <label class="form-check-label" for="exampleRadios1">
        Respondent Details
        </label>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="module_name" id="exampleRadios2" value="gen_respondent_res_export" checked="">
        <label class="form-check-label" for="exampleRadios2">
        General Respondent Activity by Respondent
        </label>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="module_name" id="exampleRadios3" value="gen_respondent_mon_export" checked="">
        <label class="form-check-label" for="exampleRadios3">
        General Respondent Activity by Month & Year
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
