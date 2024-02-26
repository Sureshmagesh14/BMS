

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


