
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
                            <div class="mb-0" >
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
                            <div class="text-right">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupVerticalDrop1" type="button"
                                        class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Export <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                        <a class="dropdown-item" href="#">Rewards Summary by Month & Year</a>
                                        <a class="dropdown-item" href="#">Rewards Summary by Respondent</a>
                                    </div>
                                </div>
                                <a class="btn btn-danger" class="btn btn-primary" id="rewards_delete_all"
                                    style="display: none;">
                                    Delete Selected All
                                </a>
                            </div>
                            <table id="rewards_datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input select_all"
                                                    id="inlineForm-customCheck">
                                                <label class="custom-control-label" for="inlineForm-customCheck"
                                                    style="font-weight: bold;">Select All</label>
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>REWARD AMOUNT (R)</th>
                                        <th>STATUS</th>
                                        <th>RESPONDENT</th>
                                        <th>USER</th>
                                        <th>PROJECT</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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
                            <div class="text-right">
                                <a href="#!" data-url="{{ route('export_resp') }}" data-size="xl"
                                    data-ajax-popup="true" class="btn btn-primary"
                                    data-bs-original-title="{{ __('export Respondents') }}" class="btn btn-primary"
                                    data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="export">
                                    Export
                                </a>

                                <a href="#!" data-url="{{ route('respondents.create') }}" data-size="xl"
                                    data-ajax-popup="true" class="btn btn-primary"
                                    data-bs-original-title="{{ __('Create Respondents') }}" class="btn btn-primary"
                                    data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
                                    Create Respondents
                                </a>

                                <a class="btn btn-danger" class="btn btn-primary" id="delete_all" style="display: none;">
                                    Delete Selected All
                                </a>
                            </div>

                            <h4 class="card-title"> </h4>
                            <p class="card-title-desc"></p>

                            <table id="respondent_datatable" class="table w-full table-responsive" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input select_all" id="inlineForm-customCheck">
                                                <label class="custom-control-label" for="inlineForm-customCheck" style="font-weight: bold;">Select All</label>
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Mobile</th>
                                        <th>Whatsapp</th>
                                        <th>Email</th>
                                        <th>Date of Birth</th>
                                        <th>race</th>
                                        <th>status</th>
                                        <th>profile_completion</th>
                                        <th>inactive_until</th>
                                        <th>opeted_in</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
        rewards_datatable();
        respondent_datatable();
    });

    function rewards_datatable() {
        $('#rewards_datatable').dataTable().fnDestroy();
        $('#rewards_datatable').DataTable({
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
                { data: 'id',name: '#',orderable: true,searchable: true },
                { data: 'points',name: 'points',orderable: true,searchable: true },
                { data: 'status_id',name: 'status_id',orderable: true,searchable: true },
                { data: 'respondent_id',name: 'respondent_id',orderable: true,searchable: true },
                { data: 'user_id',name: 'user_id',orderable: true,searchable: true },
                { data: 'project_id',name: 'project_id',orderable: true,searchable: true },
                { data: 'action',name: 'action',orderable: false,searchable: false }
            ],
            columnDefs: [
                { targets: 0,width: 75,className: "text-center" },
                { targets: 4,width: 115,className: "text-center" },
                { targets: 5,width: 115,className: "text-center" },
            ],
        });
    }

    function respondent_datatable() {
        $('#respondent_datatable').dataTable().fnDestroy();
        var postsTable = $('#respondent_datatable').dataTable({
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
                {"data": "select_all"},
                {"data": "id"},
                {"data": "name"},
                {"data": "surname"},
                {"data": "mobile"},
                {"data": "whatsapp"},
                {"data": "email"},
                {"data": "date_of_birth"},
                {"data": "race"},
                {"data": "status"},
                {"data": "profile_completion"},
                {"data": "inactive_until"},
                {"data": "opeted_in"},
                {"data": "options"}
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

        $.confirm({
            title: "{{ Config::get('constants.delete') }}",
            content: "{{ Config::get('constants.delete_confirmation') }}",
            autoClose: 'cancelAction|8000',
            buttons: {
                delete: {
                    text: 'delete',
                    action: function() {
                        $.ajax({
                            type: "DELETE",
                            data: {
                                _token: tempcsrf,
                            },
                            url: url,
                            dataType: "json",
                            success: function(response) {
                                if (response.status == 404) {
                                    $('.delete_student').text('');
                                } else {
                                    datatable();
                                    $.alert('Respondents Deleted!');
                                    $('.delete_student').text('Yes Delete');
                                }
                            }
                        });
                    }
                },
                cancel: function() {

                }
            }
        });
    });
</script>
