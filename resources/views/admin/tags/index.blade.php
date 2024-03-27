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
                        <h4 class="mb-0">Panels</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Panels</li>
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
                            @include('admin.table_components.tags_table')
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
            tags_table();
            // $("#content_create_form-data").validate();
        });

        function tags_table() {
            $('#tags_table').dataTable().fnDestroy();
            $('#tags_table').DataTable({
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
                    url: "{{ route('get_all_tags') }}",
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
                    { data: 'colour',name: 'colour',orderable: true,searchable: true },
                    { data: 'action',name: 'action',orderable: false,searchable: false }
                ]
            });
        }

        $(document).on('change', '.tags_select_box', function(e) {
            value = $(this).val();
            form = 'tags';
            
            value_array = [];

            if(value == 'respondents'){
                texthead = 'Export - Respondents';
                $("#tags_table .tabel_checkbox:checked").each(function(){
                    value_array.push($(this).attr('id'));
                });
                excel_report(value, form, "{{ route('tags_export') }}", texthead, value_array);
            }
            else if(value == 'panels'){
                texthead = 'Export - Panels';
                excel_report(value, form, "{{ route('tags_export') }}", texthead, value_array);
            }
        });

        $(document).on('click', '.tags_table.delete_all', function(e) {
            e.preventDefault();
            var all_id = [];

            var values = $("#tags_table tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();

            multi_delete("POST", all_id, "{{ route('tags_multi_delete') }}", "Pannels Deleted", 'tags_table');
        });

        $(document).on('click', '#delete_tags', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "{{ route('tags.destroy', ':id') }}";
            url = url.replace(':id', id);

            single_delete("DELETE", id, url, "Pannel Deleted", 'tags_table');
        });
    </script>
