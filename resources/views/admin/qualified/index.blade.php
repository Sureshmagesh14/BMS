@include('admin.layout.header')

@yield('adminside-favicon')
@yield('adminside-css')

@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>
    .datepicker {
        z-index: 1100 !important;
    }

    #ui-datepicker-div {
        width: 30% !important;
    }
</style>
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
                        <h4 class="mb-0">Qualified Respondent</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Qualified Respondent</li>
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
                            @include('admin.table_components.qualified_table')
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

        $(document).on('click', '.qualified_table.delete_all', function(e) {
            e.preventDefault();
            var all_id = [];

            var values = $("#qualified_table tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();

            multi_delete("POST", all_id, "{{ route('projects_multi_delete') }}", "Projects Deleted", 'qualified_table');
        });

        $(document).ready(function() {
            qualified_table();
        });

        function qualified_table() {
            $('#qualified_table').dataTable().fnDestroy();
            $('#qualified_table').DataTable({
                searching: true,
                ordering: true,
                dom: 'lfrtip',
                info: true,
                iDisplayLength: 100,
                lengthMenu: [
                    [100, 50, 25, -1],
                    [100, 50, 25, "All"]
                ],
                ajax: {
                    url: "{{ route('get_all_qualified') }}",
                    data: {
                        _token: tempcsrf,
                    },
                    error: function(xhr, error, thrown) {
                        alert("undefind error");
                    }
                },
                columns: [
                    { data: 'select_all',name: 'select_all',orderable: false,searchable: false },
                    { data: 'respondent_id',name: 'respondent_id',orderable: true,searchable: true },
                    { data: 'name',name: 'name',orderable: true,searchable: true },
                    { data: 'points',name: 'points',orderable: true,searchable: true },
                    { data: 'status',name: 'status',orderable: true,searchable: true },
                    { data: 'created_at',name: 'created_at',orderable: true,searchable: true },
                    { data: 'action',name: 'action',orderable: true,searchable: true }
                ]
            });
        }

        $(document).on('click', '#delete_projects', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "{{ route('projects.destroy', ':id') }}";
            url = url.replace(':id', id);

            single_delete("DELETE", id, url, "Project Deleted", 'qualified_table');
        });

        $(document).on('click', '.project_play_button', function(e) {
            var all_id = [];
            var values = $("#qualified_table tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();

            select_value = (all_id.length == 0) ? $(".show_hided_option").val() : $(".hided_option").val();

            if(select_value == 3){
                titles = "Status > Complete";
                select_action("POST", all_id, select_value, "{{ route('project_action') }}", 'qualified_table', titles, "Are You Want To Change Status", "Action");
            }
            else if(select_value == "delete_all"){
                multi_delete("POST", all_id, "{{ route('projects_multi_delete') }}", "Projects Deleted", 'qualified_table');
            }
            else if(select_value == "export_all_project"){
               
            }
            else if(select_value == "export_survey_response"){
               
            }
            else{
                toastr.info("OOPS! Select the action");
            }
        });
    </script>
