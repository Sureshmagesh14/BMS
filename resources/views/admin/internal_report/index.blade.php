@include('admin.layout.header')

@yield('adminside-favicon')
@yield('adminside-css')

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
                        <h4 class="mb-0">Internal Report</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Internal Report</li>
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
                            @include('admin.table_components.user_events_table', ['users' => $users])
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @include('admin.layout.footer')
        @stack('adminside-js')
        @stack('adminside-datatable')
        
    <script>
        var tempcsrf = '{!! csrf_token() !!}';

        $(document).ready(function() {
            banks_table();
        });

        function banks_table() {
            $('#banks_table').dataTable().fnDestroy();
            $('#banks_table').DataTable({
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
                    url: "{{ route('get_all_banks') }}",
                    data: {
                        _token: tempcsrf,
                    },
                    error: function(xhr, error, thrown) {
                        alert("undefind error");
                    }
                },
                columns: [
                    { data: 'select_all',name: 'select_all',orderable: false,searchable: false },
                    { data: 'id_show',name: 'id_show',orderable: true,searchable: true },
                    { data: 'bank_name',name: 'bank_name',orderable: true,searchable: true },
                    { data: 'branch_code',name: 'branch_code',orderable: true,searchable: true },
                    { data: 'active',name: 'active',orderable: false,searchable: false },
                    { data: 'action',name: 'action',orderable: false,searchable: false }
                ]
            });
        }

        users = ''; roles = ''; action = ''; type = ''; year = ''; month = '';
        $(document).ready(function() {
            user_events(users, roles, action,type,year,month);
        });

        function select_users(get_this){
            users = $(get_this).val();
            user_events(users, roles, action, type,year,month);
        }

        function select_role(get_this){
            roles = $(get_this).val();
            user_events(users, roles, action, type,year,month);
        }

        function select_action(get_this){
            action = $(get_this).val();
            user_events(users, roles, action, type,year,month);
        }

        function select_type(get_this){
            type = $(get_this).val();
            user_events(users, roles, action, type,year,month);
        }

        function select_year(get_this){
            year = $(get_this).val();
            user_events(users, roles, action, type,year,month);
        }

        function select_month(get_this){
            month = $(get_this).val();
            user_events(users, roles, action, type,year,month);
        }
        
        
        function user_events(users, roles, action,type,year,month){
            $('#user_events').dataTable().fnDestroy();
            var postsTable = $('#user_events').dataTable({
                "ordering": true,
                "processing": true,
                "serverSide": true,
                dom: 'lfrtip',
                "ajax": {
                    "url": "{{ route('user-events-show') }}",
                    "data": {
                        _token: tempcsrf,
                        users: users,
                        roles: roles,
                        action: action,
                        type: type,
                        year:year,
                        month:month,
                    },
                    "dataType": "json",
                    "type": "POST"
                },
                "columns": [
                    { "data": "id_show" },
                    { "data": "user_id" },
                    { "data": "action" },
                    { "data": "type" },
                    { "data": "month" },
                    { "data": "year" },
                    { "data": "count" },
                    { "data": "options" },
                ],
                "order": [
                    [1, "asc"]
                ],
                stateSave: false,
            });
        }
    </script>
    
