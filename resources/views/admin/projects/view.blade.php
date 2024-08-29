@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Projects</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Projects</li>
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

                            <div class="mb-0">
                                <div class="text-right">

                                    <div class="btn-group mr-2">

                                        <a href="#!" data-url="{{ route('projects.edit', $data->id) }}"
                                            data-size="xl" data-ajax-popup="true" class="btn btn-primary"
                                            data-bs-original-title="Edit Projects" data-bs-toggle="tooltip"
                                            id="create">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
 
                                        <input type="hidden" name="project_id" id="project_id" value="{{ $data->id }}">
                                        <select name="action_1" id="action_1" class="form-control projects_table show_hided_option select_box">
                                            <option value="">Select Action</option>
                                            <option value="3">Status &gt; Complete</option>
                                            <option value="5">Project Complete &amp; Qualified</option>
                                        </select>
                                    </div>



                                </div>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <input type="hidden" name="edit_id" id="edit_id"
                                                value="{{ $data->id }}">
                                            <td>{{ $data->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Project Number</th>
                                            <td>{{ $data->number }}</td>
                                        </tr>

                                        <tr>
                                            <th>Project Name</th>
                                            <td>{{ $data->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client Name</th>
                                            <td>{{ $data->client }}</td>
                                        </tr>
                                        <tr>
                                            <th>Creator</th>
                                            <td>
                                                @php $name_r=\App\Models\Projects::get_user_name($data->user_id); @endphp
                                                {{ $name_r->name }} {{ $name_r->lname }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Survey Type</th>
                                            <td>
                                                @if ($data->status_id == 2)
                                                    Pre-Task
                                                @elseif($data->status_id == 3)
                                                    Paid survey
                                                @elseif($data->status_id == 4)
                                                    Unpaid survey
                                                @endif
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>Reward Amount (R)</th>
                                            <td>{{ $data->reward }}</td>
                                        </tr>
                                        <tr>
                                            <th>Project Name for Respondents</th>
                                            <td>{{ $data->project_name_resp }}</td>
                                        </tr>

                                      
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if ($data->status_id == 1)
                                                    Pending
                                                @elseif($data->status_id == 2)
                                                    Active
                                                @elseif($data->status_id == 3)
                                                    Completed
                                                @elseif($data->status_id == 4)
                                                    Cancelled
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email Subject</th>
                                            <td>{{ $data->description }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email Description 1</th>
                                            <td>{{ $data->description1 }}</td>
                                        </tr>

                                        {{-- <tr>
                                            <th>Email Description 2 (Pre-task only)</th>
                                            <td>{{$data->description2}}</td>
                                        </tr> --}}

                                        {{-- <tr>
                                            <th>Survey Duration (Minutes)</th>
                                            <td>{{$data->survey_duration}}</td>
                                        </tr> --}}

                                        <tr>
                                            <th>Live Date</th>
                                            <td>{{ $data->published_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Closing Date</th>
                                            <td>{{ $data->closing_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Accessibility</th>
                                            <td>
                                                @if ($data->access_id == 1)
                                                    Shareable
                                                @else
                                                    Unique
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Survey Link</th>
                                            @php $survey_link=\App\Models\Projects::get_survey($data->survey_link); @endphp

                                            <td><a title="{{ $survey_link->title ?? '' }}" class="btn btn-yellow"
                                                    target="_blank"
                                                    href="{{ url('survey/view', $survey_link->builderID ?? '') }}">{{ url('survey/view', $survey_link->builderID ?? '') }}</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- rewards start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Rewards</h4>
                            </div>
                        </div>
                    </div>
                    <!-- rewards end page title -->
                    <div class="card">
                        <div class="card-body">
                            @include('admin.table_components.rewards_table')
                        </div>
                        <!-- end card-body -->
                    </div>

                    <!-- Respondent start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Respondents</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Respondent end page title -->
                    <div class="card">
                        <div class="card-body">
                            @include('admin.table_components.respondents_table', [
                                'project_id' => $data->id,
                            ])
                        </div>
                        <!-- end card-body -->
                    </div>

                    <!-- Respondent start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Qualified Respondents</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Respondent end page title -->
                    <div class="card">
                        <div class="card-body">
                            @include('admin.table_components.qualified_table', ['project_id' => $data->id,])
                        </div>
                        <!-- end card-body -->
                    </div>

                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
@include('admin.layout.footer')

@stack('adminside-js')
@stack('adminside-validataion')
@stack('adminside-confirm')
@stack('adminside-datatable')

<script>
    var tempcsrf = '{!! csrf_token() !!}';
    $(document).ready(function() {
        rewards_table();
        respondents_datatable();
        qualified_table();
    });

    /* Rewards Inner Page */
    function rewards_table() {
        $('#rewards_table').dataTable().fnDestroy();
        $('#rewards_table').DataTable({

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
                url: "{{ route('get_all_rewards') }}",
                data: {
                    _token: tempcsrf,
                    id: '{{ $data->id }}',
                    inside_form: 'projects',
                },
                error: function(xhr, error, thrown) {
                    alert("undefind error")
                }
            },
            columns: [{
                    data: 'select_all',
                    name: 'select_all',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id_show',
                    name: 'id_show',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'points',
                    name: 'points',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status_id',
                    name: 'status_id',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'respondent_id',
                    name: 'respondent_id',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'user_id',
                    name: 'user_id',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'project_id',
                    name: 'project_id',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    }

    $(document).on('change', '.rewards_select_box', function(e) {
        var all_id = [];
        values = $(this).val();

        if (values == 2) {
            var values = $("#user_table tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();
            multi_delete("POST", all_id, "{{ route('rewards_multi_delete') }}", "Rewards Deleted",
                'rewards_table');
        }
    });

    $("#action_1").change(function() {
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
    });

    function view_details(id) {
        let url = "view_rewards";
        url = url + '/' + id;
        document.location.href = url;
    }

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
                    id: '{{ $data->id }}',
                    inside_form: 'projects',
                },
                "dataType": "json",
                "type": "POST"
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
                // {
                //     "data": "race"
                // },
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
                    "data": "options"
                }
            ],
            "order": [
                [1, "asc"]
            ],
            stateSave: false,
        });
    }

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

        multi_delete("POST", all_id, "{{ route('networks_multi_delete') }}", "Respondents Deleted",
            'respondents_datatable');
    });

    $(document).on('click', '#deattach_respondents', function(e) {
        e.preventDefault();
        project_id = $("#project_id").val();
        var respondent = $(this).data("id");

        var url =
            "{{ route('deattach_respondent', ['respondent_id' => ':respondent_id', 'project_id' => ':project_id']) }}";
        url = url.replace(':respondent_id', respondent);
        url = url.replace(':project_id', project_id);

        single_delete("POST", respondent, url, "Deattach Respondent", 'respondents_datatable');
    });

    $(document).on('click', '.user_play_button', function(e) {
        var all_id = [];
        var project_id = $("#project_id").val();
        var values = $("#respondents_datatable tbody tr").map(function() {
            var $this = $(this);

            if ($this.find("[type=checkbox]").is(':checked')) {

                console.log($this.find("[type=checkbox]").attr('id'));
                all_id.push($this.find("[type=checkbox]").attr('id'));
            }
        }).get();


        select_value = (all_id.length == 0) ? $(".show_hided_option").val() : $("#action_2").val();

        // alert(select_value);

        if (select_value == 11) {
            titles = "Un-Assign from Project";
            select_action("POST", all_id, project_id, "{{ route('project_unassign') }}",
                'respondents_datatable', titles, "Are You Want To Un-Assign from Project", "Action");
        } else if (select_value == 10) {
            titles = "Notify Respondent";
            select_action("POST", all_id, project_id, "{{ route('notify_respondent') }}",
                'respondents_datatable', titles, "Are You Want Send Notification", "Action");
        } else if (select_value == "delete_all") {
            multi_delete("POST", all_id, "{{ route('projects_multi_delete') }}", "Projects Deleted",
                'respondents_datatable');
        } else {
            toastr.info("OOPS! Select the action");
        }
    });

    $(document).on('click', '.respondents_play_button', function(e) {
        var all_id = [];
        var project_id = $("#project_id").val();
        var values = $("#respondents_datatable tbody tr").map(function() {
            var $this = $(this);
            if ($this.find("[type=checkbox]").is(':checked')) {
                console.log("ll",$this.find("[type=checkbox]").attr('id'));
                all_id.push($this.find("[type=checkbox]").attr('id'));
            }
        }).get();

        select_value = (all_id.length != 0) ? $(".respondents_select_box").val() : 0;

        if(select_value == 3){
            titles = "Status > Complete";
            select_action("POST", all_id, select_value, "{{ route('project_action') }}", 'respondents_datatable', titles, "Are You Want To Change Status", "Action");
        }
        else if (select_value == 10) {
            titles = "Notify Respondent";
            select_action("POST", all_id, project_id, "{{ route('notify_respondent') }}",
                'respondents_datatable', titles, "Are You Want Send Notification", "Action");
        } 
        else if (select_value == 11) {
            titles = "Notify Respondent";
            select_action("POST", all_id, project_id, "{{ route('notify_respondent') }}",
                'qualified_table', titles, "Are You Want Send Notification", "Action");
               
        }
        else if(select_value == "qualified"){
            var get_status = this.value;
            var edit_id = $('#edit_id').val();
            $.ajax({

                type: "GET",
                url: "{{ route('qualified_respondent_status') }}",
                data: {
                    "get_status": get_status,
                    "edit_id": edit_id,
                    'all_id': all_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data.repsonse==400){
                        toastr.info("Status Already Changed!");
                    }else{
                        toastr.success("Project status changed into Completed and Respondent moved to the Qualified");
                    }
                
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {

                }
            });
        }
        else{
            toastr.info("OOPS! Select the action");
        }
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
                    id: '{{ $data->id }}',
                    inside_form: 'projects',
                },
                error: function(xhr, error, thrown) {
                    alert("undefind error");
                }
            },
            columns: [
                // { data: 'select_all',name: 'select_all',orderable: false,searchable: false },
                { data: 'respondent_id',name: 'respondent_id',orderable: true,searchable: true },
                { data: 'name',name: 'name',orderable: true,searchable: true },
                { data: 'surname',name: 'surname',orderable: true,searchable: true },
                { data: 'points',name: 'points',orderable: true,searchable: true },
                { data: 'status',name: 'status',orderable: true,searchable: true },
                { data: 'created_at',name: 'created_at',orderable: true,searchable: true },
                { data: 'action',name: 'action',orderable: true,searchable: true }
            ]
        });
    }

    $(document).on('click', '.qualified_play_button', function(e) {
            var all_id = [];
            var select_value =  $("#action_3").val();

           

            if(select_value == 3){
                titles = "Status > Complete";
                select_action("POST", all_id, select_value, "{{ route('change_all_rewards_status') }}", 'qualified_table', titles, "Are You Want To Change Status", "Action");
              
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

    $(document).on('click', '#deattach_projects', function(e) {
        e.preventDefault();
        var respondent = $(this).data("respondent-id");
        var project_id = $(this).data("project-id");
        console.log("respondent",respondent);
        console.log("project_id",project_id);
        var url ="{{ route('deattach_project', ['respondent_id' => ':respondent_id', 'project_id' => ':project_id']) }}";
        url = url.replace(':respondent_id', respondent);
        url = url.replace(':project_id', project_id);

        single_delete("POST", respondent, url, "Deattach Project Successfully", 'qualified_table');
    });

</script>

@if (Session::has('success'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('success') }}");
    </script>
@endif
@if (Session::has('error'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
    </script>
@endif
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
    };
</script>
