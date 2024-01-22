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
                                    <h4 class="mb-0">Banks</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Banks</li>
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
                                                <th>Bank</th>
                                                <th>Branch Code</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
        
        
                                            <tbody>
                                            
                                           
                                            </tbody>
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

@yield('adminside-script')
@include('admin.layout.footer')

<script>
$(document).ready(function() {
    var tempcsrf = '{!! csrf_token() !!}';
    
    $('#myTable').DataTable({
        dom: '<"pull-left"f><"pull-right"l>tip',
        bFilter: true,
        bInfo: false,
        bLengthChange: true,
        iDisplayLength: 3,
        lengthChange: true,
        processing: true,
        serverSide: true,
        bAutoWidth: false,
        oLanguage: {
            sLengthMenu: "Show more _MENU_ "
        },
        lengthMenu: [
            [3, 25, 50, -1],
            [3, 25, 50, "All"]
        ],
        ajax: {
            url: 'get_all_banks',
            data: {
                _token: tempcsrf,
            },
            error: function(xhr, error, thrown) {
               alert("undefind error")
            }
        },
        order: [
            [1, 'desc']
        ],
        columns: [{
                data: 'bank_name',
                name: 'bank_name',
                orderable: true,
                searchable: true
            },
            {
                data: 'branch_code',
                name: 'branch_code',
                orderable: true,
                searchable: true
            },
            {
                data: 'active',
                name: 'active',
                orderable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        columnDefs: [{
                width: 575,
                targets: 0
            },
            {
                targets: 1,
                className: "text-center"
            },
            {
                targets: 2,
                className: "text-center"
            },
            {
                targets: 3,
                className: "text-center"
            }
        ],
        aaSorting: [],
    });
});
</script>