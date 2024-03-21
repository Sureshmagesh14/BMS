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
                        <h4 class="mb-0">Contents</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Contents</li>
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
                                <a href="#!" data-url="{{ route('contents.create') }}" data-size="xl"
                                    data-ajax-popup="true" class="btn btn-primary"
                                    data-bs-original-title="{{ __('Create Content') }}" class="btn btn-primary"
                                    data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
                                    Create Contents
                                </a>

                                <a class="btn btn-danger" class="btn btn-primary" id="delete_all"
                                    style="display: none;">
                                    Delete Selected All
                                </a>
                            </div>

                            <h4 class="card-title"> </h4>
                            <p class="card-title-desc"></p>

                            <table id="contents_table" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="select_all" id="inlineForm-customCheck">
                                        </th>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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
            contents_table();
        });

        function contents_table() {
            $('#contents_table').dataTable().fnDestroy();
            $('#contents_table').DataTable({
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
                    url: "{{ route('contents_datatable') }}",
                    data: {
                        _token: tempcsrf,
                    },
                    error: function(xhr, error, thrown) {
                        location.reload();
                    }
                },
                columns: [
                    { data: 'select_all',name: 'select_all',orderable: false,searchable: false },
                    { data: 'id',name: '#',orderable: true,searchable: true },
                    { data: 'type_id',name: 'type_id',orderable: true,searchable: true },
                    { data: 'action',name: 'action',orderable: false,searchable: false }
                ]
            });
        }

        $(document).on('click', '.contents_table.delete_all', function(e) {
            e.preventDefault();
            var all_id = [];

            var values = $("#contents_table tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();

            multi_delete("POST", all_id, "{{ route('contents_multi_delete') }}", "Contents Deleted", 'contents_table');
        });

        $(document).on('click', '#delete_content', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "{{ route('contents.destroy', ':id') }}";
            url = url.replace(':id', id);

            single_delete("DELETE", id, url, "Content Deleted", 'contents_table');
        });
    </script>
