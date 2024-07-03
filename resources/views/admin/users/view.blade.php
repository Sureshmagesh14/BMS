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
                            <div class="text-right">
                                <a href="#!" data-url="{{ route('users.edit', $data->id) }}" data-size="xl"
                                    data-ajax-popup="true" class="btn btn-primary" data-bs-original-title="Edit Users"
                                    data-bs-toggle="tooltip" id="create">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            <div class="mb-0">
                                <input type="hidden" id="tag_id" value="{{$data->id}}">
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
                                                    Super User
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
                                            <td><a target="_blank" rel="noopener" href="{{ Config::get('constants.url').'/?r='.$data->share_link }}">{{ Config::get('constants.url').'/?r='.$data->share_link }}<a></td>
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
                            @include('admin.table_components.rewards_table')
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
                            @include('admin.table_components.projects_table')
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
@stack('adminside-datatable')

<script>
    var tempcsrf = '{!! csrf_token() !!}';
    $(document).ready(function() {
        projects_table();
        rewards_table();
    });

    /* Projects Inner Page */
    function projects_table() {
        $('#projects_table').dataTable().fnDestroy();
        $('#projects_table').DataTable({
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

    $(document).on('click', '.projects_table.delete_all', function(e) {
        e.preventDefault();
        var all_id = [];

        var values = $("#projects_table tbody tr").map(function() {
            var $this = $(this);
            if ($this.find("[type=checkbox]").is(':checked')) {
                all_id.push($this.find("[type=checkbox]").attr('id'));
            }
        }).get();

        multi_delete("POST", all_id, "{{ route('projects_multi_delete') }}", "Projects Deleted",
            'projects_table');
    });

    $(document).on('click', '#delete_projects', function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var url = "{{ route('projects.destroy', ':id') }}";
        url = url.replace(':id', id);

        single_delete("DELETE", id, url, "Project Deleted", 'projects_table');
    });

    /* Rewards Inner Page */
    function rewards_table() {
        $('#rewards_table').dataTable().fnDestroy();
        $('#rewards_table').DataTable({

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
                    inside_form: 'users',
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

    $(document).on('change', '.rewards_select_box', function(e) {
        var all_id = [];
        values = $(this).val();

        if (values == 2) {
            var values = $("#user_table tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();
            multi_delete("POST", all_id, "{{ route('rewards_multi_delete') }}", "Rewards Deleted",
                'rewards_table');
        }
    });
    $(document).on('click', '#deattach_respondents', function(e) {
        alert("fghj");
        e.preventDefault();
        var id = $(this).data("id");
        console.log("id",id);
        var url = "{{ route('deattach_tags', ':id') }}";
        url = url.replace(':id', id);

        single_delete("POST", id, url, "Deattach Pannel", 'respondents_datatable');
    });
    function view_details(id) {
        let url = "view_rewards";
        url = url + '/' + id;
        document.location.href = url;
    }
</script>
