@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')


<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Users</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Users</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-0">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <td>{{ $data->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $data->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Surname</th>
                                            <td>{{ $data->surname }}</td>
                                        </tr>
                                        <tr>
                                            <th>RSA ID / Passport</th>
                                            <td>
                                                {{ $data->id_passport }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $data->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Role</th>
                                            <td>
                                                @if ($data->role_id == 1)
                                                    Admin
                                                @elseif($data->role_id == 2)
                                                    User
                                                @else
                                                    Temp
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if ($data->status_id == 1)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Share Link</th>
                                            <td>{{ $data->share_link }}</td>
                                        </tr>

                                    </tbody>
                                </table>

                                {{-- <a href="{{ route('inner_module', ['module' => 'user_to_project', 'id' => $data->id]) }}" class="btn btn-primary">Create Project</a> --}}
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- rewards start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Rewards</h4>
                            </div>
                        </div>
                    </div>
                    <!-- rewards end page title -->

                    <div class="card">
                        <div class="card-body">
                            <div class="text-right">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupVerticalDrop1" type="button"
                                        class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Export <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                        <a class="dropdown-item" href="#">Rewards Summary by Month & Year</a>
                                        <a class="dropdown-item" href="#">Rewards Summary by Respondent</a>
                                    </div>
                                </div>
                                <a class="btn btn-danger" class="btn btn-primary" id="rewards_delete_all"
                                    style="display: none;">
                                    Delete Selected All
                                </a>
                            </div>
                            <table id="rewards_datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input select_all"
                                                    id="inlineForm-customCheck">
                                                <label class="custom-control-label" for="inlineForm-customCheck"
                                                    style="font-weight: bold;">Select All</label>
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>REWARD AMOUNT (R)</th>
                                        <th>STATUS</th>
                                        <th>RESPONDENT</th>
                                        <th>USER</th>
                                        <th>PROJECT</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- end card-body -->
                    </div>

                    <!-- projects start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Projects</h4>
                            </div>
                        </div>
                    </div>
                    <!-- projects end page title -->

                    <div class="card">
                        <div class="card-body">
                            <div class="text-right">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupVerticalDrop1" type="button"
                                        class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">Export <i
                                            class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                        <a class="dropdown-item" href="#">Respondent Project Engagement by Month &
                                            Year</a>
                                        <a class="dropdown-item" href="#">Respondent Project Engagement by
                                            Respondent</a>
                                    </div>
                                </div>
                                <a href="{{ url('projects_export/xlsx') }}"
                                    class="btn btn-primary waves-effect waves-light"><i class="fa fa-file-excel"></i>
                                    Export</a>
                                <a href="#!" data-url="{{ route('projects.create') }}" data-size="xl"
                                    data-ajax-popup="true" class="btn btn-primary"
                                    data-bs-original-title="{{ __('Create Projects') }}" class="btn btn-primary"
                                    data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
                                    Create Project
                                </a>
                                <a class="btn btn-danger" class="btn btn-primary" id="project_delete_all"
                                    style="display: none;">
                                    Delete Selected All
                                </a>
                                {{-- <a href="{{ route('inner_module', ['module' => 'user_to_project', 'id' => $data->id]) }}" class="btn btn-primary">Create Project</a> --}}
                            </div>
                            <h4 class="card-title"> </h4>
                            <p class="card-title-desc"></p>
                            <table id="projects_datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input select_all"
                                                    id="inlineForm-customCheck">
                                                <label class="custom-control-label" for="inlineForm-customCheck"
                                                    style="font-weight: bold;">Select All</label>
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>Number/Code</th>
                                        <th>Client</th>
                                        <th>Name</th>
                                        <th>Creator</th>
                                        <th>Type</th>
                                        <th>Reward Amount</th>
                                        <th>Project Link</th>
                                        <th>Created</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- end card-body -->
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
    @include('admin.layout.footer')

    @stack('adminside-js')
    @stack('adminside-validataion')
    @stack('adminside-confirm')
    @stack('adminside-datatable')

    <script>
        var tempcsrf = '{!! csrf_token() !!}';
        $(document).ready(function() {
            projects_datatable();
            rewards_datatable();
        });

        function rewards_datatable() {
            $('#rewards_datatable').dataTable().fnDestroy();
            $('#rewards_datatable').DataTable({
                searching: true,
                ordering: true,
                dom: 'lfrtip',
                info: true,
                iDisplayLength: 10,
                lengthMenu: [
                    [10, 50, 100, -1],
                    [10, 50, 100, "All"]
                ],
                ajax: {
                    url: "{{ route('get_all_rewards') }}",
                    data: {
                        _token: tempcsrf,
                        id: '{{ $data->id }}',
                    },
                    error: function(xhr, error, thrown) {
                        alert("undefind error")
                    }
                },
                columns: [{
                        data: 'select_all',
                        name: 'select_all',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: '#',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'points',
                        name: 'points',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status_id',
                        name: 'status_id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'respondent_id',
                        name: 'respondent_id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'project_id',
                        name: 'project_id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        }

        function projects_datatable() {
            $('#projects_datatable').dataTable().fnDestroy();
            $('#projects_datatable').DataTable({
                searching: true,
                ordering: true,
                dom: 'lfrtip',
                info: true,
                iDisplayLength: 10,
                lengthMenu: [
                    [10, 50, 100, -1],
                    [10, 50, 100, "All"]
                ],
                ajax: {
                    url: "{{ route('get_all_projects') }}",
                    data: {
                        _token: tempcsrf,
                        id: '{{ $data->id }}',
                        inside_form: 'users',
                    },
                    error: function(xhr, error, thrown) {
                        alert("undefind error");
                    }
                },
                columns: [{
                        data: 'select_all',
                        name: 'select_all',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: '#',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'numbers',
                        name: 'numbers',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'client',
                        name: 'client',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'creator',
                        name: 'creator',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'reward_amount',
                        name: 'reward_amount',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'project_link',
                        name: 'project_link',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'created',
                        name: 'created',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    }
                ]
            });
        }

        function table_checkbox(get_this) {
            count_checkbox = $(".tabel_checkbox").filter(':checked').length;
            if (count_checkbox > 1) {
                $("#project_delete_all").show();
            } else {
                $("#project_delete_all").hide();
            }
        }

        $(document).on('click', '#project_delete_all', function(e) {
            e.preventDefault();
            var all_id = [];

            var values = $("#myTable tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();

            $.confirm({
                title: "{{ Config::get('constants.delete') }}",
                content: "{{ Config::get('constants.delete_confirmation') }}",
                autoClose: 'cancelAction|8000',
                buttons: {
                    delete: {
                        text: 'delete',
                        action: function() {
                            $.ajax({
                                type: "POST",
                                data: {
                                    _token: tempcsrf,
                                    all_id: all_id
                                },
                                url: "{{ route('projects_multi_delete') }}",
                                dataType: "json",
                                success: function(response) {
                                    if (response.status == 404) {
                                        $('.delete_student').text('');
                                    } else {
                                        datatable();
                                        $.alert('Projects Deleted!');
                                        $("#project_delete_all").hide();
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {

                    }
                }
            });
        });

        $(document).on('click', '#delete_projects', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "{{ route('projects.destroy', ':id') }}";
            url = url.replace(':id', id);

            $.confirm({
                title: "{{ Config::get('constants.delete') }}",
                content: "{{ Config::get('constants.delete_confirmation') }}",
                autoClose: 'cancelAction|8000',
                buttons: {
                    delete: {
                        text: 'delete',
                        action: function() {
                            $.ajax({
                                type: "DELETE",
                                data: {
                                    _token: tempcsrf,
                                },
                                url: url,
                                dataType: "json",
                                success: function(response) {
                                    if (response.status == 404) {
                                        $('.delete_student').text('');
                                    } else {
                                        datatable();
                                        $.alert('Project Deleted!');
                                        $('.delete_student').text('Yes Delete');
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {

                    }
                }
            });
        });
    </script>
