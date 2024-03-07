<div class="text-right">
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
                            <h5>User Filter</h5>
                            <select name="users" id="users" class="form-control">
                                <option value="">Select Users</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="mb-3">
                            <h5>Role Filter</h5>
                            <select name="users" id="users" class="form-control">
                                <option value="">Select Role</option>
                                <option value="1">Administrator</option>
                                <option value="2">User</option>
                                <option value="3">Temp</option>
                            </select>
                        </li>
                        <li class="mb-3">
                            <h5>Action Filter</h5>
                            <select name="users" id="users" class="form-control">
                                <option value="">Select Action</option>
                                <option value="created">Created</option>
                                <option value="updated">Updated</option>
                                <option value="deleted">Deleted</option>
                                <option value="activated">Activated</option>
                                <option value="deactivated">Deactivated</option>
                                <option value="created_with_share_url">Created With Share URL</option>
                            </select>
                        </li>
                        <li class="mb-3">
                            <h5>Type Filter</h5>
                            <select name="users" id="users" class="form-control">
                                <option value="">Select Type</option>
                                <option value="project">Project</option>
                                <option value="respondent">Respondent</option>
                            </select>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<h4 class="card-title"> </h4>
<p class="card-title-desc"></p>

<table id="user_events" class="table dt-responsive nowrap w-100">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Action</th>
            <th>Type</th>
            <th>Month</th>
            <th>Year</th>
            <th>Count</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>