

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
                                            <td>{{ $data->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $data->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Surname</th>
                                            <td>{{ $data->surname }}</td>
                                        </tr>
                            
                                        <tr>
                                            <th>Date Of Birth</th>
                                            <td>{{ $data->date_of_birth }}</td>
                                        </tr>
                            
                                        <tr>
                                            <th>RSA ID / Passport</th>
                                            <td>{{ $data->id_passport }}</td>
                                        </tr>
                            
                                        <tr>
                                            <th>Mobile Number</th>
                                            <td>{{ $data->mobile }}</td>
                                        </tr>
                            
                                        <tr>
                                            <th>Whatsapp Number</th>
                                            <td>{{ $data->whatsapp }}</td>
                                        </tr>
                            
                                        <tr>
                                            <th>Age</th>
                                            @php
                                                $dateOfBirth = $data->date_of_birth;
                                                $today = date('Y-m-d');
                                                $diff = date_diff(date_create($dateOfBirth), date_create($today));
                                            @endphp
                                            <td>{{ $diff->format('%y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bank Name</th>
                                            <td>{{ $data->bank_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Branch Code</th>
                                            <td>{{ $data->branch_code }}</td>
                                        </tr>
                                        <tr>
                                            <th>Account Type</th>
                                            <td>{{ $data->account_type }}</td>
                                        </tr>
                                        <tr>
                                            <th>Account Holder</th>
                                            <td>{{ $data->account_holder }}</td>
                                        </tr>
                                        <tr>
                                            <th>Account Number</th>
                                            <td>{{ $data->account_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ $data->active_status_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Profile Completion</th>
                                            <td>{{ $data->profile_completion_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Opted In</th>
                                            <td>{{ $data->opted_in }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last Updated</th>
                                            <td>{{ $data->updated_at }}</td>
                                        </tr>
                                        <tr>
                                            <th>Referral Code</th>
                                            <td>{{ $data->referral_code }}</td>
                                        </tr>
                                        <tr>
                                            <th>Accepted Terms</th>
                                            <td>{{ $data->accept_terms }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created By</th>
                                            <td>{{ $data->created_at }}</td>
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
                                <h4 class="mb-0">Cash Out</h4>
                            </div>
                        </div>
                    </div>
                    <!-- rewards end page title -->

                    <div class="card">
                        <div class="card-body">
                            <div class="text-right">
                                <a href="#!" data-url="{{ route('export_cash') }}" data-size="xl" data-ajax-popup="true"
                                    class="btn btn-primary" data-bs-original-title="{{ __('Cashout Summary') }}" class="btn btn-primary" data-size="xl"
                                    data-ajax-popup="true" data-bs-toggle="tooltip" id="export">Export
                                </a>
                                <a class="btn btn-danger" class="btn btn-primary" id="delete_all" style="display: none;">
                                    Delete Selected All
                                </a>
                            </div>
                            <h4 class="card-title"> </h4>
                            <p class="card-title-desc"></p>

                            <table id="cashout_datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input select_all" id="inlineForm-customCheck">
                                                <label class="custom-control-label" for="inlineForm-customCheck" style="font-weight: bold;">Select All</label>
                                            </div>
                                        </th>
                                        <th>#</th>      
                                        <th>Type</th>          
                                        <th>Status</th>          
                                        <th>Amount</th>          
                                        <th>Respondent</th>                                           
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

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
        cashout_datatable();
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
                    inside_form: 'respondents',
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

    function cashout_datatable(){
        $('#cashout_datatable').dataTable().fnDestroy();
        $('#cashout_datatable').DataTable({
            searching: true,
            ordering: true,
            dom : 'lfrtip',
            info: true,
            iDisplayLength: 10,
            lengthMenu: [
                [ 10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],
            ajax: {
                url: "{{ route('get_all_cashouts') }}",
                data: {
                    _token: tempcsrf,
                    id: '{{ $data->id }}',
                    inside_form: 'respondents',
                },
                error: function(xhr, error, thrown) {
                alert("undefind error")
                }
            },
            columns: [
                { data: 'select_all', name: 'select_all', orderable: false, searchable: false },
                { data: 'id',name: '#',orderable: true,searchable: true },
                { data: 'type_id',name: 'type_id',orderable: true,searchable: true },
                { data: 'status_id',name: 'status_id',orderable: true,searchable: true },
                { data: 'amount',name: 'amount',orderable: true,searchable: true },
                { data: 'respondent_id',name: 'respondent_id',orderable: true,searchable: true },
                { data: 'action',name: 'action',orderable: true,searchable: true }
        ],
        columnDefs: [
            { targets: 6,width: 115,className: "text-center" }
        ],
    });
}
</script>
