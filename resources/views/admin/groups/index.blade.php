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
                        <h4 class="mb-0">groups</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">groups</li>
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
                            @include('admin.table_components.profile_group_table')
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
            groups_table();
        });

        function groups_table() {
            $('#groups_table').dataTable().fnDestroy();
            $('#groups_table').DataTable({
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
                    url: "{{ route('get_groups_banks') }}",
                    data: {
                        _token: tempcsrf,
                    },
                    error: function(xhr, error, thrown) {
                        alert("undefind error");
                    }
                },
                columns: [
                    { data: 'select_all',name: 'select_all',orderable: false,searchable: false },
                    { data: 'id',name: '#',orderable: true,searchable: true },
                    { data: 'name',name: 'name',orderable: true,searchable: true },
                    { data: 'type_id',name: 'type_id',orderable: true,searchable: true },
                    { data: 'survey_url',name: 'survey_url',orderable: true,searchable: true },
                    { data: 'action',name: 'action',orderable: false,searchable: false }
                ]
            });
        }

        $(document).on('click', '.groups_table.delete_all', function(e) {
            e.preventDefault();
            var all_id = [];

            var values = $("#groups_table tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();

            multi_delete("POST", all_id, "{{ route('groups_multi_delete') }}", "Profile Groups Deleted", 'groups_table');
        });

        $(document).on('click', '#delete_groups', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "{{ route('groups.destroy', ':id') }}";
            url = url.replace(':id', id);

            single_delete("DELETE", id, url, "Profile Group Deleted", 'groups_table');
        });
    </script>
