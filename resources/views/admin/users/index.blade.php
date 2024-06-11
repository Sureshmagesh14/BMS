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
                                <li class="breadcrumb-item"><a href=" {{ route('admin.dashboard') }}">Dashboards</a></li>
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
                            @include('admin.table_components.user_table')
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
            user_datatable();
        });

        function user_datatable() {
            $('#user_table').dataTable().fnDestroy();
            $('#user_table').DataTable({
                searching: true,
                ordering: true,
                dom: 'lfrtip',
                info: true,
                iDisplayLength: 100,
                lengthMenu: [[100, "All", 50, 25], [100, "All", 50, 25]],               
                ajax: {
                    url: "{{ route('get_all_users') }}",
                    data: {
                        _token: tempcsrf,
                    },
                    error: function(xhr, error, thrown) {
                        console.log("User Datatabel Error");

                        setTimeout(function() {
                            // location.reload();
                        }, 2000);
                    }
                },
                columns: [
                    { data: 'select_all',name: 'select_all',orderable: false,searchable: false },
                    { data: 'id_show',name: '#id_show',orderable: true,searchable: true },
                    { data: 'name',name: 'name',orderable: true,searchable: true },
                    { data: 'surname',name: 'surname',orderable: true,searchable: true },
                    { data: 'id_passport',name: 'id_passport',orderable: true,searchable: true },
                    { data: 'email',name: 'email',orderable: true,searchable: true },
                    { data: 'role_id',name: 'role_id',orderable: true,searchable: true },
                    { data: 'status_id',name: 'status_id',orderable: true,searchable: true },
                    { data: 'share_link',name: 'share_link',orderable: true,searchable: true },
                    { data: 'action',name: 'action',orderable: true,searchable: true }
                ]
            });
        }

        $(document).on('click', '#delete_users', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "{{ route('users.destroy', ':id') }}";
            url = url.replace(':id', id);

            single_delete("DELETE", id, url, "User Deleted", 'user_datatable');
        });

        $(document).on('click', '.user_play_button', function(e) {
            value = $(".user_select").val();

            var all_id = [];
            var values = $("#user_table tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();

            if(value == "delete_all"){
                multi_delete("POST", all_id, "{{ route('users_multi_delete') }}", "Users Deleted", 'user_datatable');
            }
            else if(value == "active" || value == "deactive"){
                titles = (value == "active") ? "Active Users" :  "De-Active Users";
                select_action("POST", all_id, value, "{{ route('users_action') }}", 'user_datatable', titles, "Are You Want To Change Status", "Action");
            }
            else{
                toastr.info("OOPS! Select the action");
            }
        });
    </script>
