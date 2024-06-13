<div class="text-right">

    {{-- <div class="btn-group" role="group">
        <button id="btnGroupVerticalDrop1" type="button"
            class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Export <i class="mdi mdi-chevron-down"></i>
        </button>&nbsp;
        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
            <a class="dropdown-item" href="{{ url('export_user_activity') }}">User Activity
                by User</a>
            <a class="dropdown-item" href="{{ url('export_referrals') }}">Referrals</a>
        </div>
    </div> --}}

    @if (Auth::guard('admin')->user()->role_id == 1)
        <div class="btn-group mr-2" role="group" aria-label="Second group">
            <a href="#!" data-url="{{ route('users.create') }}" data-size="xl" data-ajax-popup="true"
                class="btn btn-primary" data-bs-original-title="{{ __('Create Users') }}" class="btn btn-primary"
                data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
                Create Users
            </a>
        </div><br><br>

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
                                <h5>Role Filter</h5>
                                <select name="role" id="role" class="form-control" onchange="role_type(this)">
                                    <option value="">Select Role</option>
                                    <option value="1">Super User</option>
                                    <option value="2">User</option>
                                    <option value="3">Temp</option>
                                </select>
                            </li>
                            <li class="mb-3">
                                <h5>Status Filter</h5>
                                <select name="status" id="status_id" class="form-control" onchange="user_status(this)">
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="btn-group mr-2 user_table hided_option" role="group" aria-label="First group" style="display: none;">
                <select name="action" id="action" class="form-control user_select">
                    <option value="">Select Action</option>
                    <option value="active">Active</option>
                    <option value="deactive">De-Active</option>
                    <option value="delete_all">Delete Selected</option>
                </select>

                <div class="play-button-container ml-3">
                    <a class="play-button user_play_button">
                        <div class="play-button__triangle"></div>
                    </a>
                </div>
            </div>

            {{-- <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">
                    <a class="btn btn-danger user_table delete_all" class="btn btn-primary">
                        Delete Selected All
                    </a>
                </li>
            </ul> --}}
        </div>
    @endif
</div>

<h4 class="card-title"></h4>
<p class="card-title-desc"></p>

<table id="user_table" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>
                <input type="checkbox" class="select_all" id="inlineForm-customCheck">
            </th>
            <th>#</th>
            <th>Name</th>
            <th>Surname</th>
            <th>RSA ID / Passport</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Share Link</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
