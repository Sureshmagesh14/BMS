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
                        <h4 class="mb-0">Respondents</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Respondents</li>
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
                            @include('admin.table_components.respondents_table')
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
            respondents_datatable();
        });

        function respondents_datatable() {
            $('#respondents_datatable').dataTable().fnDestroy();
            var postsTable = $('#respondents_datatable').dataTable({
                "ordering": true,
                "processing": true,
                "serverSide": true,
                dom: 'lfrtip',
                "ajax": {
                    "url": "{{ route('get_all_respond') }}",
                    "data": {
                        _token: tempcsrf,
                    },
                    "dataType": "json",
                    "type": "POST"
                },
                "columns": [
                    { "data": "select_all" },
                    { "data": "id_show" },
                    { "data": "name" },
                    { "data": "surname" },
                    { "data": "mobile" },
                    { "data": "whatsapp" },
                    { "data": "email" },
                    { "data": "date_of_birth" },
                    { "data": "race" },
                    { "data": "status" },
                    { "data": "profile_completion" },
                    { "data": "inactive_until" },
                    { "data": "opeted_in" },
                    { "data": "options" }
                ],
                "order": [[1, "asc"]],
                stateSave: false,
            });
        }

        $(document).on('change', '.respondents_select_box', function(e) {
            value = $(this).val();
            $.post("{{ route('respondents_export') }}", {
                _token: tempcsrf,
                id_value: value,
                form: 'respondents'
            },
            function(resp, textStatus, jqXHR) {

                if(resp=='Error'){
                   console.log("Error");
                }
                else{
                    console.log("resps",resp);
                    window.location.assign("../"+resp);
                }
            });
        });

        $(document).on('click', '#delete_respondents', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "{{ route('respondents.destroy', ':id') }}";
            url = url.replace(':id', id);

            single_delete("DELETE", id, url, "Respondents Deleted", 'respondents_datatable');
        });

        $(document).on('click', '.respondents_datatable.delete_all', function(e) {
            e.preventDefault();
            var all_id = [];

            var values = $("#respondents_datatable tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();

            multi_delete("POST", all_id, "{{ route('networks_multi_delete') }}", "Respondents Deleted", 'respondents_datatable');
        });
    </script>
