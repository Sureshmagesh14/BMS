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
