@include('admin.layout.header')

@yield('adminside-favicon')
@yield('adminside-css')

@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
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
                        <h4 class="mb-0">Internal Report</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Internal Report</li>
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
                            

                            <h4 class="card-title"> </h4>
                            <p class="card-title-desc"></p>

                            <table id="myTable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Type</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Count</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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
        @stack('adminside-validataion')
        @stack('adminside-confirm')
        @stack('adminside-datatable')
        
    <script>
        var tempcsrf = '{!! csrf_token() !!}';
        $(document).ready(function() {
            datatable();
        });
        
   

        function datatable(){
            $('#myTable').dataTable().fnDestroy();
            var postsTable = $('#myTable').dataTable({
                "ordering": true,
                "processing": true,
                "serverSide": true,
                dom: 'lfrtip',
                "ajax": {
                    "url": "{{ route('user-events-show') }}",
                    "data": {
                        _token: tempcsrf,
                    },
                    "dataType": "json",
                    "type": "POST"
                },
                "columns": [

                    {
                        "data": "id"
                    },
                    {
                        "data": "user_id"
                    },
                    {
                        "data": "action"
                    },
                    {
                        "data": "type"
                    },
                    {
                        "data": "month"
                    },
                    {
                        "data": "year"
                    },
                    {
                        "data": "count"
                    },
                    {
                        "data": "options"
                    },
                  
                    ],
                "order": [
                    [1, "asc"]
                ],

                stateSave: false,
            });



        
        }

    </script>
    
