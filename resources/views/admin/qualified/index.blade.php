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
    
        $(document).ready(function() {
            qualified_table();
        });
    
        function qualified_table() {
            if ($.fn.DataTable.isDataTable('#qualified_table')) {
                $('#qualified_table').DataTable().destroy();
            }
    
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
                    type: 'GET',
                    data: {
                        _token: tempcsrf
                    },
                    dataSrc: function (json) {
                        // Check if json.data is an array
                        if (!Array.isArray(json.data)) {
                            console.error("Unexpected data format:", json);
                            return [];
                        }
                        return json.data;
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        alert("An error occurred while fetching data.");
                    }
                },
                columns: [
                    { data: 'respondent_id', name: 'respondent_id', orderable: true, searchable: true },
                    { data: 'name', name: 'name', orderable: true, searchable: true },
                    { data: 'surname', name: 'surname', orderable: true, searchable: true },
                    { data: 'points', name: 'points', orderable: true, searchable: true },
                    { data: 'status', name: 'status', orderable: true, searchable: true },
                    { data: 'created_at', name: 'created_at', orderable: true, searchable: true },
                    { data: 'action', name: 'action', orderable: true, searchable: true }
                ]
            });
        }
    
        function select_action(method, all_id, select_value, route, table_id, titles, confirmMessage, successMessage) {
    $.confirm({
        title: titles,
        content: confirmMessage,
        autoClose: 'cancel|8000',
        type: 'red',
        typeAnimated: true,
        buttons: {
            confirm: {
                text: 'Confirm',
                action: function() {
                    $.ajax({
                        type: method,
                        url: route,
                        data: {
                            _token: tempcsrf,
                            ids: all_id,
                            value: select_value
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log("Response received:", response); // Log the response for debugging
                            
                            if (response.success) {
                                toastr.success(successMessage || "Status Changed Successfully"); // Use provided successMessage or default
                                qualified_table(); // Refresh DataTable
                            } else {
                                toastr.error(response.message || "An error occurred. Please try again."); // Display specific message from response
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                          
                            toastr.error("An error occurred. Please try again.");
                        }
                    });
                }
            },
            cancel: function() {
                // Optional: code to execute on cancel
            }
        }
    });
}

    
        $(document).on('click', '.qualified_play_button', function(e) {
            e.preventDefault(); // Prevent the default action
    
            var all_id = []; // Populate this with the IDs you need
            var select_value = $("#action_3").val();
    
            if (select_value == 3) {
                var titles = "Status > Complete";
                select_action("POST", all_id, select_value, "{{ route('change_all_rewards_status') }}", 'qualified_table', titles, "Are you sure you want to change status?", "Status changed successfully!");
            } else if (select_value == "delete_all") {
                multi_delete("POST", all_id, "{{ route('projects_multi_delete') }}", "Projects deleted successfully", 'qualified_table');
            } else if (select_value == "export_all_project") {
                // Add your export logic here
            } else if (select_value == "export_survey_response") {
                // Add your export logic here
            } else {
                toastr.info("OOPS! Select an action");
            }
        });
    </script>
    
    @if (Session::has('success'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        };
        toastr.success("{{ session('success') }}");
    </script>
    @endif
    
    @if (Session::has('error'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        };
        toastr.error("{{ session('error') }}");
    </script>
    @endif
    
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        };
    </script>
    
    