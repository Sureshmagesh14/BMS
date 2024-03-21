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

        users = ''; roles = ''; action = ''; type = '';
        $(document).ready(function() {
            user_events(users, roles, action,type);
        });

        function select_users(get_this){
            users = $(get_this).val();
            user_events(users, roles, action, type);
        }

        function select_role(get_this){
            roles = $(get_this).val();
            user_events(users, roles, action, type);
        }

        function select_action(get_this){
            action = $(get_this).val();
            user_events(users, roles, action, type);
        }

        function select_type(get_this){
            type = $(get_this).val();
            user_events(users, roles, action, type);
        }
        
        function user_events(users, roles, action,type){
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
                        type: type
                    },
                    "dataType": "json",
                    "type": "POST"
                },
                "columns": [
                    { "data": "id" },
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
    
