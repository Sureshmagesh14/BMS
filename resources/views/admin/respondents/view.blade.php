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
                            <div class="mb-0">
                                <div class="text-right">
                                    <a href="#!" data-url="{{ route('respondents.edit', $data->id) }}"
                                        data-size="xl" data-ajax-popup="true" class="btn btn-primary"
                                        data-bs-original-title="Edit Respondents" data-bs-toggle="tooltip"
                                        id="create">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <input type="hidden" name="respondent_id" id="respondent_id"
                                                value="{{ $data->id }}">
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
                                            @if ($data->active_status_id == 1)
                                                @php $active_status_id='Active'; @endphp
                                            @elseif ($data->active_status_id == 2)
                                                @php $active_status_id='Deactivated'; @endphp
                                            @elseif ($data->active_status_id == 3)
                                                @php $active_status_id='Unsubscribed'; @endphp
                                            @elseif ($data->active_status_id == 4)
                                                @php $active_status_id='Pending'; @endphp
                                            @elseif ($data->active_status_id == 5)
                                                @php $active_status_id='Blacklisted'; @endphp
                                            @endif
                                            <td>{{ $active_status_id }}</td>
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
                                            <td><a href="{{ URL::to('/') }}?r={{ $data->referral_code }}">{{ URL::to('/') }}?r={{ $data->referral_code }}</a></td>
                                        </tr>
                                        <tr>
                                            <th>Accepted Terms</th>
                                            @if ($data->accept_terms == 1)
                                                @php $accept_terms='Yes'; @endphp
                                            @else
                                                @php $accept_terms='No'; @endphp
                                            @endif
                                            <td>{{ $accept_terms }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created By</th>
                                            @php
                                                $user = Auth::guard('admin')->user();
                                                $name_r = \App\Models\Projects::get_user_name($user->id);
                                            @endphp

                                            <td> {{ $name_r->name }} {{ $name_r->lname }}</td>
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
                    <!-- rewards end page title -->

                    <!-- rewards start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Projects</h4>
                            </div>
                        </div>
                    </div>
                    <!-- rewards end page title -->
                    <div class="card">
                        <div class="card-body">
                            @include('admin.table_components.projects_table', [
                                'respondent_id' => $data->id,
                            ])
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- rewards end page title -->

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
        projects_table();
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
                    inside_form: 'respondents',
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

    function view_details(id) {
        let url = "view_rewards";
        url = url + '/' + id;
        document.location.href = url;
    }

    /* Projects Inner Page */
    function projects_table() {
        $('#projects_table').dataTable().fnDestroy();
        $('#projects_table').DataTable({
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
                url: "{{ route('get_all_projects') }}",
                data: {
                    _token: tempcsrf,
                    id: '{{ $data->id }}',
                    inside_form: 'respondents',
                },
                error: function(xhr, error, thrown) {
                    alert("undefind error");
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
                    data: 'numbers',
                    name: 'numbers',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'client',
                    name: 'client',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'creator',
                    name: 'creator',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'type',
                    name: 'type',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'reward_amount',
                    name: 'reward_amount',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'project_link',
                    name: 'project_link',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'created',
                    name: 'created',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                }
            ]
        });
    }

    $(document).on('click', '#deattach_projects', function(e) {
        e.preventDefault();
        respondent = $("#respondent_id").val();
        var project_id = $(this).data("id");

        var url =
            "{{ route('deattach_project', ['respondent_id' => ':respondent_id', 'project_id' => ':project_id']) }}";
        url = url.replace(':respondent_id', respondent);
        url = url.replace(':project_id', project_id);

        single_delete("POST", respondent, url, "Deattach Project", 'projects_table');
    });
</script>
