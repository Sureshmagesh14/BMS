@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>
    span.badge.bg-primary {
        color: white;
    }
</style>
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
                                <div class="col-md-12">
                                    <h4><span class="badge badge-secondary">Basic</span></h4>
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
                                            <td>{{ date('Y-m-d', strtotime($data->date_of_birth)) }}</td>
                                        </tr>

                                        <tr>
                                            <th>RSA ID / Passport</th>
                                            <td>{{ $data->id_passport }}</td>
                                        </tr>

                                        <tr>
                                            <th>Mobile Number</th>
                                            @if (isset($data->mobile))
                                                @php $mobile='+27 '.$data->mobile;@endphp
                                            @else
                                                @php $mobile='';@endphp
                                            @endif
                                            <td>{{ $mobile }}</td>
                                        </tr>

                                        <tr>
                                            <th>Whatsapp Number</th>
                                            @if (isset($data->whatsapp))
                                                @php $whatsapp='+27 '.$data->whatsapp;@endphp
                                            @else
                                                @php $whatsapp='';@endphp
                                            @endif
                                            <td>{{ $whatsapp }}</td>
                                        </tr>

                                        <tr>
                                            <th>Age</th>
                                            @if (isset($data->date_of_birth))
                                                @php
                                                    $dateOfBirth = $data->date_of_birth;
                                                    $today = date('Y-m-d');
                                                    $diff = date_diff(date_create($dateOfBirth), date_create($today));
                                                    $date = $diff->format('%y') . ' Years';
                                                @endphp
                                            @else
                                                @php $date='';  @endphp
                                            @endif

                                            <td>{{ $date }} </td>
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
                                            <th>Date of Completion</th>
                                            <td>{{ $data->data_completion_id }}</td>
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
                                            <td><a
                                                    href="{{ URL::to('/') }}?r={{ $data->referral_code }}">{{ URL::to('/') }}?r={{ $data->referral_code }}</a>
                                            </td>
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
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <h4><span class="badge badge-secondary">Essential</span></h4>
                            </div>
                            <div class="mb-0">
                                @php
                                    $essential = isset($data->essential_details)
                                        ? json_decode($data->essential_details)
                                        : (object) [];

                                @endphp
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Relationship Status</th>
                                            <td>{{ ucfirst($relationship_status = isset($essential->relationship_status) ? $essential->relationship_status : null) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Gender</th>
                                            <td>{{ ucfirst($gender = isset($essential->gender) ? $essential->gender : null) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Ethnic Group / Race</th>
                                            <td>{{ ucfirst($ethnic_group = isset($essential->ethnic_group) ? $essential->ethnic_group : null) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Highest Education Level</th>
                                            @php
                                                $education_level = isset($essential->education_level)
                                                    ? $essential->education_level
                                                    : null;
                                                $education = '';
                                                switch ($education_level) {
                                                    case 'matric':
                                                        $education = 'Matric';
                                                        break;
                                                    case 'post_matric_courses':
                                                        $education = 'Post Matric Courses / Higher Certificate';
                                                        break;
                                                    case 'post_matric_diploma':
                                                        $education = 'Post Matric Diploma';
                                                        break;
                                                    case 'ug':
                                                        $education = 'Undergrad University Degree';
                                                        break;
                                                    case 'pg':
                                                        $education = 'Post Grad Degree - Honours, Masters, PhD, MBA';
                                                        break;
                                                    case 'school_no_metric':
                                                        $education = 'School But No Matric';
                                                        break;
                                                    default:
                                                        $education = '';
                                                        break;
                                                }
                                            @endphp
                                            <td>{{ $education }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Employment Status</th>
                                            @php
                                                $employment_status = isset($essential->employment_status)
                                                    ? $essential->employment_status
                                                    : null;
                                                $employment = '';
                                                switch ($employment_status) {
                                                    case 'emp_full_time':
                                                        $employment = 'Employed Full-Time';
                                                        break;
                                                    case 'emp_part_time':
                                                        $employment = 'Employed Part-Time';
                                                        break;
                                                    case 'self':
                                                        $$employment = 'Self-Employed';
                                                        break;
                                                    case 'study':
                                                        $employment = 'Studying Full-Time (Not Working)';
                                                        break;
                                                    case 'working_and_studying':
                                                        $employment = 'Working &amp; Studying';
                                                        break;
                                                    case 'home_person':
                                                        $employment = 'Stay at Home person';
                                                        break;
                                                    case 'retired':
                                                        $employment = 'Retired';
                                                        break;
                                                    case 'unemployed':
                                                        $employment = 'Unemployed';
                                                        break;
                                                    case 'other':
                                                        $employment = 'Other';
                                                        break;
                                                    default:
                                                        $employment = '';
                                                        break;
                                                }
                                            @endphp
                                            <td>{{ $employment }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Industry my company is in</th>
                                            @php
                                                $industry_my_company = isset($essential->industry_my_company)
                                                    ? $essential->industry_my_company
                                                    : null;
                                                $industry_name = \App\Models\RespondentProfile::industry(
                                                    $industry_my_company,
                                                );
                                            @endphp
                                            <td>
                                                {{ $industry_name ? $industry_name->company : '' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Job Title</th>
                                            <td>{{ $job_title = isset($essential->job_title) ? $essential->job_title : null }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Personal Income Per Month</th>
                                            @php
                                                $personal_income_per_month = isset(
                                                    $essential->personal_income_per_month,
                                                )
                                                    ? $essential->personal_income_per_month
                                                    : null;
                                                $income_rate = \App\Models\RespondentProfile::income(
                                                    $personal_income_per_month,
                                                );
                                            @endphp
                                            <td>
                                                {{ $income_rate ? $income_rate->income : '' }}
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>Household Income per month</th>
                                            @php
                                                $household_income_per_month = isset(
                                                    $essential->household_income_per_month,
                                                )
                                                    ? $essential->household_income_per_month
                                                    : null;
                                                $household_income = \App\Models\RespondentProfile::income(
                                                    $household_income_per_month,
                                                );
                                            @endphp
                                            <td>
                                                {{ $household_income ? $household_income->income : '' }}
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>Province </th>
                                            @php
                                                $province = isset($essential->province) ? $essential->province : null;
                                                $province_name = \App\Models\RespondentProfile::province($province);
                                            @endphp
                                            <td>
                                                {{ $province_name ? $province_name->state : '' }}
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>Suburb </th>
                                            @php
                                                $district = isset($essential->suburb) ? $essential->suburb : null;
                                                $district_name = \App\Models\RespondentProfile::district($district);
                                            @endphp
                                            <td>
                                                {{ $district_name ? $district_name->district : '' }}
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>Metropolitan Area </th>
                                            @php
                                                $metropolitan_area = isset($essential->metropolitan_area)
                                                    ? $essential->metropolitan_area
                                                    : null;
                                                $metropolitan_area_name = \App\Models\RespondentProfile::metropolitan_area(
                                                    $province,
                                                    $district,
                                                );
                                            @endphp
                                            <td>
                                                {{ $metropolitan_area_name ? $metropolitan_area_name->area : '' }}
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>Number of people living in your household </th>
                                            <td>{{ $no_houehold = isset($essential->no_houehold) ? $essential->no_houehold : null }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Number of Children</th>
                                            <td>{{ $no_vehicle = isset($essential->no_vehicle) ? $essential->no_vehicle : null }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Number of Vehicles</th>
                                            <td>{{ $no_children = isset($essential->no_children) ? $essential->no_children : null }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <h4><span class="badge badge-secondary">Extended</span></h4>
                            </div>
                            <table border="1" id="children_table"
                                class="children_table table table-bordered table-striped table-highlight">
                                <colgroup>
                                    <col width="20%">
                                    <col width="50%">
                                    <col width="30%">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Child</th>
                                        <th style="text-align: center;">DOB</th>
                                        <th style="text-align: center;">Gender</th>
                                    </tr>
                                </thead>
                                @php
                                    $children_data = isset($data->children_data)
                                        ? json_decode($data->children_data)
                                        : (object) [];
                                    $key = 1;
                                @endphp
                                <tbody>
                                    @forelse ($children_data as $key=> $children)
                                        <tr>
                                        <tr class="more_tr role_tr" id="children_tr1">
                                            <td>Child {{ $key + 1 }}</td>
                                            <td>{{ $children->date ?? '' }}</td>
                                            <td>{{ $children->gender ?? '' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                <center>No Data Found.</center>
                                            </td>
                                        </tr>
                                    @endforelse



                                </tbody>
                            </table>

                            <table border="1" id="vehicle_table"
                                class="vehicle_table table table-bordered table-striped table-highlight">
                                <colgroup>
                                    <col width="20%">
                                    <col width="20%">
                                    <col width="20%">
                                    <col width="20%">
                                    <col width="20%">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Vehicle</th>
                                        <th style="text-align: center;">Brand</th>
                                        <th style="text-align: center;">Type of vehicle</th>
                                        <th style="text-align: center;">Model</th>
                                        <th style="text-align: center;">Year</th>
                                    </tr>
                                </thead>
                                @php
                                    $vehicle_data = isset($data->vehicle_data)
                                        ? json_decode($data->vehicle_data)
                                        : (object) [];
                                    $i = 1;
                                @endphp
                                <tbody>
                                    @forelse ($vehicle_data as  $vehicle)
                                        <tr>
                                            <td>Vechile {{ $i }}</td>
                                            <td>{{ $vehicle->type ?? '' }}</td>
                                            <td>{{ $vehicle->year ?? '' }}</td>
                                            <td>{{ $vehicle->brand ?? '' }}</td>
                                            <td>{{ $vehicle->model ?? '' }}</td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <center>No Data Found.</center>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mb-0">
                                @php
                                    $essential = isset($data->extended_details)
                                        ? json_decode($data->extended_details)
                                        : (object) [];

                                @endphp
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Which best describes the role in you business / organization?</th>
                                            @php
                                                $business_org = isset($essential->business_org)
                                                    ? $essential->business_org
                                                    : null;
                                                $business = '';
                                                switch ($business_org) {
                                                    case 'owner_director':
                                                        $business = 'Owner / director (CEO, COO, CFO)';
                                                        break;
                                                    case 'senior_manager':
                                                        $business = 'Senior Manager';
                                                        break;
                                                    case 'mid_level_manager':
                                                        $business = 'Mid-Level Manager';
                                                        break;
                                                    case 'team_leader':
                                                        $business = 'Team leader / Supervisor';
                                                        break;
                                                    case 'general_worker':
                                                        $business = 'General Worker (e.g., Admin, Call Centre Agent, Nurse, Teacher,
                                                Carer, etc.)';
                                                        break;
                                                    case 'worker_etc':
                                                        $business =
                                                            'Worker (e.g., Security Guard, Cleaner, Helper, etc.)';
                                                        break;
                                                    case 'other':
                                                        $business = isset($essential->business_org_other)
                                                            ? $essential->business_org_other
                                                            : null;
                                                        break;
                                                    default:
                                                        $business = '';
                                                        break;
                                                }
                                            @endphp
                                            <td>{{ $business }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>What is the number of people in your organisation / company?</th>
                                            @php
                                                $org_company = isset($essential->org_company)
                                                    ? $essential->org_company
                                                    : null;
                                                $org = '';
                                                switch ($org_company) {
                                                    case 'just_me':
                                                        $org = 'Just Me (Sole Proprietor)';
                                                        break;
                                                    case '2_5':
                                                        $org = '2-5 people';
                                                        break;
                                                    case '6_10':
                                                        $org = '6-10 people';
                                                        break;
                                                    case '11_20':
                                                        $org = '11-20 people';
                                                        break;
                                                    case '21_30':
                                                        $org = '21-30 people';
                                                        break;
                                                    case '31_50':
                                                        $org = '31-50 people';
                                                        break;
                                                    case '51_100':
                                                        $org = '51-100 people';
                                                        break;
                                                    case '101_250':
                                                        $org = '101-250 people';
                                                        break;
                                                    case '251_500':
                                                        $org = '251-500 people';
                                                        break;
                                                    case '500_1000':
                                                        $org = '500-1000 people';
                                                        break;

                                                    case 'more_than_1000':
                                                        $org = 'More than 1000 people';
                                                        break;
                                                    default:
                                                        $org = '';
                                                        break;
                                                }
                                            @endphp
                                            <td>{{ $org }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Which bank do you bank with (which is your bank main)</th>
                                            @php
                                                $bank_main = null; // Initialize $bank_main with null

                                                if (isset($essential->bank_main)) {
                                                    if (
                                                        $essential->bank_main == 'other' &&
                                                        isset($essential->bank_main_other)
                                                    ) {
                                                        // If bank_main is 'other', capitalize the other bank name if it exists
                                                        $bank_main = ucfirst($essential->bank_main_other);
                                                    } else {
                                                        // Otherwise, use the provided bank_main value
                                                        $bank_main = isset($essential->bank_main)
                                                            ? $essential->bank_main
                                                            : null;
                                                        // Assuming \App\Models\RespondentProfile::bank($bank_main) returns an object with 'bank_name' property
                                                        $bankname = \App\Models\RespondentProfile::bank($bank_main);
                                                        $bank_main = $bankname ? $bankname->bank_name : null;
                                                    }
                                                }
                                            @endphp
                                            <td>
                                                {{ $bank_main }}
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>Home Language</th>
                                            @php

                                                if (isset($essential->home_lang)) {
                                                    if ($essential->home_lang == 'other') {
                                                        $home_lang = isset($essential->home_lang_other)
                                                            ? ucfirst($essential->home_lang_other)
                                                            : null;
                                                    } else {
                                                        $home_lang = ucfirst($essential->home_lang);
                                                    }
                                                } else {
                                                    $home_lang = null; // or handle the case where $essential->home_lang is not set
                                                }
                                            @endphp
                                            <td>{{ $home_lang }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>

                    <!-- cashout start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Cashouts</h4>
                            </div>
                        </div>
                    </div>
                    <!-- cashout end page title -->
                    <div class="card">
                        <div class="card-body">
                            @include('admin.table_components.cash_outs_table')
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- cashout end page title -->

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

                    <!-- project start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Projects</h4>
                            </div>
                        </div>
                    </div>
                    <!-- project end page title -->
                    <div class="card">
                        <div class="card-body">
                            @include('admin.table_components.projects_table', [
                                'respondent_id' => $data->id,
                            ])
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- project end page title -->

                    <!-- panel start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Panel</h4>
                            </div>
                        </div>
                    </div>
                    <!-- panel end page title -->
                    <div class="card">
                        <div class="card-body">
                            @include('admin.table_components.tags_table', [
                                'respondent_id' => $data->id,
                            ])
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
    type = '';
    status = '';
    $(document).ready(function() {

        rewards_table();
        projects_table();
        cashout_table(type, status);
        tags_table();
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

    function cashout_type(get_this) {
        type = $(get_this).val();
        cashout_table(type, status);
    }

    function cashout_status(get_this) {
        status = $(get_this).val();
        cashout_table(type, status);
    }

    function cashout_table(type, status) {
        $('#cashout_table').dataTable().fnDestroy();
        $('#cashout_table').DataTable({
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
                url: "{{ route('get_all_cashouts') }}",
                data: {
                    _token: tempcsrf,
                    type: type,
                    status: status,
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
                    data: 'type_id',
                    name: 'type_id',
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
                    data: 'amount',
                    name: 'amount',
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
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                }
            ]
        });
    }

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
                    id: '{{ $data->id }}',
                    inside_form: 'respondents',
                },
                error: function(xhr, error, thrown) {
                    alert("undefind error");
                }
            },
            columns: [
                {data: 'select_all',name: 'select_all',orderable: false,searchable: false},
                {data: 'id_show',name: 'id_show',orderable: true,searchable: true},
                {data: 'name',name: 'name',orderable: true,searchable: true},
                {data: 'colour',name: 'colour',orderable: true,searchable: true},
                {data: 'action',name: 'action',orderable: false,searchable: false}
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

    // $(document).on('click', '.tags_table.delete_all', function(e) {
    //     e.preventDefault();
    //     var all_id = [];

    //     var values = $("#tags_table tbody tr").map(function() {
    //         var $this = $(this);
    //         if ($this.find("[type=checkbox]").is(':checked')) {
    //             all_id.push($this.find("[type=checkbox]").attr('id'));
    //         }
    //     }).get();

    //     multi_delete("POST", all_id, "{{ route('tags_multi_delete') }}", "Pannels Deleted", 'tags_table');
    // });

    $(document).on('click', '#deattach_tags', function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var url = "{{ route('deattach_tags', ':id') }}";
        url = url.replace(':id', id);

        single_delete("POST", id, url, "Deattach Pannel", 'tags_table');
    });
</script>
@if (count($errors) > 0)
    @foreach ($errors->all() as $message)
        <script>
            toastr.error("{{ $message }}");
        </script>
    @endforeach
@endif

@if (Session::has('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if (Session::has('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif
