
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
                                                @if($data->status_id==1)
                                                    Pending
                                                @elseif($data->status_id==2)
                                                    Active
                                               @elseif($data->status_id==3)
                                                    Completed
                                                @elseif($data->status_id==4)
                                                    Cancelled
                                                @endif
                                                
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
                                            @if($data->access_id==1)
                                            Shareable
                                            @else
                                            Assigned
                                            @endif
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
