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
                                    <h4 class="mb-0">Users</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Users</li>
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
                                    <a  href="#" data-size="lg"
                                            data-ajax-popup="true"
                                            data-bs-original-title="{{ __('Edit Consultant') }}" class="btn btn-primary" >Create User</a>
                                        </div>

                                        <h4 class="card-title"> </h4>
                                        <p class="card-title-desc"></p>
        
                                        <table id="myTable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                           
                                            <tr>
                                                
                                                <th>#</th>
                                                <th>Name</th>         
                                                <th>Surname</th>         
                                                <th>RSA ID / Passport</th>         
                                                <th>Email</th>                                                          
                                                <th>Role</th>                                                           
                                                <th>Status</th>   
                                                <th>Share Link</th>                                           
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

                @include('admin.layout.footer')
        
                @stack('adminside-js')
                @stack('adminside-validataion')
                @stack('adminside-confirm')
                @stack('adminside-datatable')

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
            url: "{{ route('get_all_users') }}",
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
                data: 'id_passport',
                name: 'id_passport',
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
                data: 'role_id',
                name: 'role_id',
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
                data: 'share_link',
                name: 'share_link',
                orderable: true,
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
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
                targets: 8,
                width: 115,
                className: "text-center"
            }
        ],
    });
});
</script>
