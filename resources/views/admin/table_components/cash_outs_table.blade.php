<div class="text-right">
    <div class="btn-group mr-2" role="group" aria-label="First group" >
        <select name="action_2" id="action_2" class="form-control cashout_table hided_option cashout_select_box" style="display:none;">
            <option value="">Select Action</option>
            <optgroup label="Cash Out">
                <option value="1">EFT > Approve & Process</option>
                <option value="2">Status > Completed</option>
                <option value="3">Status > Declined</option>
                <option value="4">Status > Failed</option>
                <option value="5">Delete Cash Outs</option>
            </optgroup>
            <optgroup label="Standalone Actions">
                <option value="6">Export - Airtime Cash Outs</option>
                {{-- <option value="7">Airtime - Status > Complete by Import</option> --}}
            </optgroup>
        </select>

        <select name="action_1" id="action_1" class="form-control cashout_table show_hided_option cashout_select_box">
            <option value="">Select Action</option>
            <option value="6">Export - Airtime Cash Outs</option>
            {{-- <option value="7">Airtime - Status > Complete by Import</option> --}}
        </select>
    </div>
  
    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group mr-2" role="group" aria-label="First group">
            <div class="btn-group dropdown-filter">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="filter" role="presentation" class="fill-current text-80">
                        <path fill-rule="nonzero" d="M.293 5.707A1 1 0 0 1 0 4.999V1A1 1 0 0 1 1 0h18a1 1 0 0 1 1 1v4a1 1 0 0 1-.293.707L13 12.413v2.585a1 1 0 0 1-.293.708l-4 4c-.63.629-1.707.183-1.707-.708v-6.585L.293 5.707zM2 2v2.585l6.707 6.707a1 1 0 0 1 .293.707v4.585l2-2V12a1 1 0 0 1 .293-.707L18 4.585V2H2z"></path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6" class="ml-2">
                        <path fill="var(--90)" d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z"></path>
                    </svg>
                </button>
                <br>
                <div class="card">
                    <ul class="dropdown-menu dropdown-menu-right p-2">
                        <li class="mb-3">
                            <h5>Type Filter</h5>
                            <select name="users" id="users" class="form-control" onchange="cashout_type(this)">
                                <option value="">Select Type</option>
                                <option value="1">EFT</option>
                                <option value="2">Data</option>
                                <option value="3">Airtime</option>
                                <option value="4">Donation</option>
                                {{-- <option value="5">Excel Import</option> --}}
                            </select>
                        </li>
                        <li class="mb-3">
                            <h5>Status Filter</h5>
                            <select name="users" id="users" class="form-control" onchange="cashout_status(this)">
                                <option value="">Select Status</option>
                                <option value="1">Pending</option>
                                <option value="5">Approved for Processing</option>
                                <option value="2">Processing</option>
                                <option value="3">Complete</option>
                                <option value="4">Declined</option>
                                <option value="0">Failed</option>
                            </select>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- <a href="#!" data-url="{{ route('export_cash') }}" data-size="xl"
        data-ajax-popup="true" class="btn btn-primary"
        data-bs-original-title="{{ __('Cashout Summary') }}" class="btn btn-primary"
        data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="export">
        Export
    </a> --}}
</div>

<h4 class="card-title"> </h4>
<p class="card-title-desc"></p>

<table id="cashout_table" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>
                <input type="checkbox" class="select_all" id="inlineForm-customCheck">
            </th>
            <th>#</th>
            <th>Type</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Respondent</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<script>
$(document).ready(function() {
    cashout_table();
});
</script>