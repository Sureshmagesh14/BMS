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
                                    <h4 class="mb-0">respondents</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">respondents</li>
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
                                    <div class="text-right">
                                      
                                    
                                        </div>

                                        <h4 class="card-title"> </h4>
                                        <p class="card-title-desc"></p>
        
                                        <table id="myTable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Surname</th>
                                                <th>Mobile</th>
                                                <th>Whatsapp</th>
                                                <th>Email</th>
                                                <th>Age</th>
                                                <th>Gender</th>
                                                <th>Race</th>
                                                <th>Status</th>
                                                <th>Profile Completion</th>
                                                <th>Inactive Until</th>
                                                <th>Opted In</th>
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
    
    $('#myTable').dataTable().fnDestroy();

    $('#myTable').DataTable({
      
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
            url: "{{ route('get_all_respondents') }}",
            data: {
                _token: tempcsrf,
            },
            error: function(xhr, error, thrown) {
               alert("undefind error")
            }
        },
       
        columns: [{
                data: 'id',
                name: '#',
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
                data: 'surname',
                name: 'surname',
                orderable: true,
                searchable: true
            },
            {
                data: 'mobile',
                name: 'mobile',
                orderable: true,
                searchable: true
            },
            {
                data: 'whatsapp',
                name: 'whatsapp',
                orderable: true,
                searchable: true
            },
            {
                data: 'email',
                name: 'email',
                orderable: true,
                searchable: true
            },
            {
                data: 'age',
                name: 'age',
                orderable: true,
                searchable: true
            },
            {
                data: 'gender',
                name: 'gender',
                orderable: true,
                searchable: true
            },
            {
                data: 'race',
                name: 'race',
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
                data: 'profile_completion',
                name: 'profile_completion',
                orderable: true,
                searchable: true
            },
            {
                data: 'inactive_until',
                name: 'inactive_until',
                orderable: true,
                searchable: true
            },
            {
                data: 'opeted_in',
                name: 'opeted_in',
                orderable: true,
                searchable: true
            }
        ],
        columnDefs: [
            {
                targets: 0,
                width: 75,
                className: "text-center"
            },{
                targets: 1
            },
            {
                targets: 2
            },
            {
                targets: 3
            },
            {
                targets: 4
            },
            {
                targets: 5
            },
            {
                targets: 6
            },
            {
                targets: 7
            },
            {
                targets: 8
            },
            {
                targets: 9
            },
            {
                targets: 10
            },
            {
                targets: 11
            },
            {
                targets: 12,
                width: 115,
                className: "text-center"
            }
        ],
    });
});
</script>
<script src="{{ asset('public/assets/js/jquery.validate.js') }}"></script>