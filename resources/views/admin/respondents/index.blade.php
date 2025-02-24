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
    .dataTables_wrapper {
    overflow-x: auto;
}

#respondents_datatable {
    width: 100%;
    display: block; /* Ensure it takes full width */
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
    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script>
        var tempcsrf = '{!! csrf_token() !!}';
        active_status = '';
        completion_status = '';
        $(document).ready(function() {
            respondents_datatable(active_status, completion_status);
        });

        function filter_respondent_status(get_this) {
            active_status = $(get_this).val();
            respondents_datatable(active_status, completion_status);
        }

        function filter_respondent_profile(get_this) {
            completion_status = $(get_this).val();
            respondents_datatable(active_status, completion_status);
        }


        function respondents_datatable() {
            $('#respondents_datatable').DataTable().destroy(); // Use DataTable() instead of dataTable() for initialization and destroying
            var postsTable = $('#respondents_datatable').DataTable({
                "ordering": true,
                "processing": true,
                "serverSide": true,
                "pageLength": 100, // Change iDisplayLength to pageLength
                "lengthMenu": [
                    [25, 50, 100],
                    [25, 50, 100]
                ], // Adjust lengthMenu as per requirement
                "dom": 'lfrtip', // Customize DOM layout
                "ajax": {
                    "url": "{{ route('get_all_respond') }}",
                    "type": "POST",
                    "dataType": "json",
                    "data": function(d) {
                        d._token = tempcsrf;
                        d.inside_form = 'filter';
                        d.active_status_id = active_status;
                        d.profile_completion_id = completion_status;
                    }
                },
                "columns": [{
                        "data": "select_all",
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "data": "id_show"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "surname"
                    },
                    {
                        "data": "mobile"
                    },
                    {
                        "data": "whatsapp"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "date_of_birth"
                    },
                    // { "data": "race" },
                    {
                        "data": "status"
                    },
                    {
                        "data": "profile_completion"
                    },
                    {
                        "data": "inactive_until"
                    },
                    {
                        "data": "opted_in"
                    },
                    {
                        "data": "updated_at"
                    },
                    {
                        "data": "referral_code"
                    },
                    {
                        "data": "accept_terms"
                    },
                    {
                        "data": "options",
                        "orderable": false,
                        "searchable": false,
                       
                    }
                ],
                "order": [
                    [1, "asc"]
                ], // Default sorting by id_show ascending
                "stateSave": false, // Ensure state saving is disabled for server-side processing
                "responsive": false // Disable responsive feature
            });
        }

        $(document).on('click', '.respondents_play_button', function(e) {
            var all_id = [];
            var values = $("#respondents_datatable tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    console.log("ll",$this.find("[type=checkbox]").attr('id'));
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();

            select_value = (all_id.length != 0) ? $(".respondents_select_box").val() : 0;

            
            if(select_value == "delete_all"){
                multi_delete("POST", all_id, "{{ route('respondents_multi_delete') }}", "Respondents Deleted", 'respondents_datatable');
            }
            else if(select_value == 10){
                titles = "Notify to the Respondent";
                select_action("POST", all_id, select_value, "{{ route('notify_respondent') }}", 'respondents_datatable', titles, "Are You Want To Change Status", "Action");
            }
            else if(select_value == 11){
                titles = "Do you want unassign the project";
                select_action("POST", all_id, select_value, "{{ route('project_unassign') }}", 'respondents_datatable', titles, "Are You Want To Change Status", "Action");
            }
            else if(select_value == "qualified"){
                var get_status = this.value;
                var edit_id = $('#edit_id').val();
                $.ajax({

                    type: "GET",
                    url: "{{ route('get_project_status') }}",
                    data: {
                        "get_status": get_status,
                        "edit_id": edit_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if(data.repsonse==400){
                            toastr.info("Status Already Changed!");
                        }else{

                            if(get_status == 3){
                                toastr.success("Project status changed into Completed");
                            }
                            else if(get_status == 3){
                                toastr.success("Project status changed into Completed and Respondent moved to the Qualified");
                            }
                            else{
                                toastr.success("Project status changed into Completed and rewards added to the respondents");
                            }
                        }
                    
                        setTimeout(function() {
                            location.reload();
                        }, 2000);

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {

                    }
                });
            }
            else if(select_value != ""){
                titles = "Status > Complete";
                select_action("POST", all_id, select_value, "{{ route('respondent_action') }}", 'respondents_datatable', titles, "Are You Want To Change Status", "Action");
            }
            else{
                toastr.info("OOPS! Select the action");
            }
        });

        $(document).on('click', '#deattach_respondents', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "{{ route('respondents.destroy', ':id') }}";
            url = url.replace(':id', id);

            single_delete("DELETE", id, url, "Respondents Deleted", 'respondents_datatable');
        });
    </script>
