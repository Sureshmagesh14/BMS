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

                    <div class="card">
                        <div class="card-body">
                            <div class="text-right">
                                <a href="{{ route('inner_module', ['module' => 'user_to_project', 'id' => $data->id]) }}" class="btn btn-primary">Create Project</a>
                            </div>
                            <h4 class="card-title"> </h4>
                            <p class="card-title-desc"></p>
                            <table id="myTable" class="table dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    
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

    @include('admin.layout.footer')

    @stack('adminside-js')
    @stack('adminside-validataion')
    @stack('adminside-confirm')
    @stack('adminside-datatable')

    <script>
        var tempcsrf = '{!! csrf_token() !!}';
        $(document).ready(function() {
            datatable();
        });

        function datatable(){
            $('#myTable').dataTable().fnDestroy();
            $('#myTable').DataTable({
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
                        id: '{{$data->id}}',
                    },
                    error: function(xhr, error, thrown) {
                        alert("undefind error");
                    }
                },
                columns: [
                    {data: 'id', name: '#', orderable: true, searchable: true},
                    {data: 'numbers', name: 'numbers', orderable: true, searchable: true},
                    {data: 'client', name: 'client', orderable: true, searchable: true},
                    {data: 'name', name: 'name', orderable: true, searchable: true},
                    {data: 'creator', name: 'creator', orderable: true, searchable: true },
                    {data: 'type', name: 'type', orderable: true, searchable: true },
                    {data: 'reward_amount', name: 'reward_amount', orderable: true, searchable: true},
                    {data: 'project_link', name: 'project_link', orderable: true, searchable: true},
                    {data: 'created', name: 'created', orderable: true, searchable: true},
                    {data: 'status', name: 'status', orderable: true, searchable: true},
                    {data: 'action', name: 'action', orderable: true, searchable: true}
                ],
                columnDefs: [
                    {targets: 0,width: 75,className: "text-center"},
                    {targets: 3,width: 175,},
                    {targets: 10,width: 115,className: "text-center"}
                ],
            });
        }
    </script>
