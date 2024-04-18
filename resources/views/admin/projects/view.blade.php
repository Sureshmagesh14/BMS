
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

                                    <div class="btn-group mr-2" role="group" aria-label="First group" >
                                      
                                        <input type="hidden" name="project_id" id="project_id" value="{{$data->id}}">
                                        <select name="action_1" id="action_1" class="form-control projects_table show_hided_option select_box">
                                            <option value="">Select Action</option>
                                            <option value="6">Update</option>
                                            <option value="6">Deleted</option>
                                            <option value="6">Deactivated</option>
                                            <option value="6">Activated</option>
                                            <option value="6">Share URL</option>
                                        </select>
                                    </div>
                                
                               
                                   
                                </div>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <td>{{$data->id}}</td>
                                        </tr>
                                        <tr>
                                            <th>Number / Code</th>
                                            <td>{{$data->number}}</td>
                                        </tr>
                                        <tr>
                                            <th>Client</th>
                                            <td>{{$data->client}}</td>
                                        </tr>
                                        <tr>
                                            <th>Creator</th>
                                            <td>{{$data->user_id}}</td>
                                        </tr>
                                        <tr>
                                            <th>Type</th>
                                            <td>{{$data->user_id}}</td>
                                        </tr>
                                        <tr>
                                            <th>Reward Amount (R)</th>
                                            <td>{{$data->reward}}</td>
                                        </tr>
                                        <tr>
                                            <th>Project Link</th>
                                            <td>{{$data->project_link}}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if($data->status_id==1) Pending
                                                @elseif($data->status_id==2) Active
                                                @elseif($data->status_id==3) Completed
                                                @elseif($data->status_id==4) Cancelled @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td>{{$data->description}}</td>
                                        </tr>
                                        <tr>
                                            <th>Email Description 1</th>
                                            <td>{{$data->description1}}</td>
                                        </tr>
                            
                                        <tr>
                                            <th>Email Description 2 (Pre-task only)</th>
                                            <td>{{$data->description2}}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>Survey Duration (Minutes)</th>
                                            <td>{{$data->survey_duration}}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>Live Date</th>
                                            <td>{{$data->published_date}}</td>
                                        </tr>
                                        <tr>
                                            <th>Closing Date</th>
                                            <td>{{$data->closing_date}}</td>
                                        </tr>
                                        <tr>
                                            <th>Accessibility</th>
                                            <td>
                                                @if($data->access_id==1) Shareable
                                                @else Assigned @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Survey Link</th>
                                            <td>{{$data->survey_link}}</td>
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
                            @include('admin.table_components.respondents_table', ['project_id' => $data->id])
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
            columns: [
                { data: 'select_all',name: 'select_all',orderable: false,searchable: false },
                { data: 'id_show',name: 'id_show',orderable: true,searchable: true },
                { data: 'points',name: 'points',orderable: true,searchable: true },
                { data: 'status_id',name: 'status_id',orderable: true,searchable: true },
                { data: 'respondent_id',name: 'respondent_id',orderable: true,searchable: true },
                { data: 'user_id',name: 'user_id',orderable: true,searchable: true },
                { data: 'project_id',name: 'project_id',orderable: true,searchable: true },
                { data: 'action',name: 'action',orderable: false,searchable: false }
            ]
        });
    }

    $(document).on('change', '.rewards_select_box', function(e) {
        var all_id = [];
        values = $(this).val();

        if(values == 2){
            var values = $("#user_table tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                }
            }).get();
            multi_delete("POST", all_id, "{{ route('rewards_multi_delete') }}", "Rewards Deleted", 'rewards_table');
        }
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

    $(document).on('click', '#deattach_respondents', function(e) {
        e.preventDefault();
        project_id     = $("#project_id").val();
        var respondent = $(this).data("id");

        var url = "{{ route('deattach_respondent', ['respondent_id' => ':respondent_id', 'project_id' => ':project_id']) }}";
        url = url.replace(':respondent_id', respondent);
        url = url.replace(':project_id', project_id);

        single_delete("POST", respondent, url, "Deattach Respondent", 'respondents_datatable');
    });
</script>
