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
                                    <h4 class="mb-0">Rewards</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Rewards</li>
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
                                    
                                    
                                    
<div class="text-left">



<div class="btn-group" role="group">
<button id="btnGroupVerticalDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Export <i class="mdi mdi-chevron-down"></i>
</button>
<div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
<a class="dropdown-item" href="#">Rewards Summary by Month & Year</a>
<a class="dropdown-item" href="#">Rewards Summary by Respondent</a>
</div>
</div>

</div>

                                        <h4 class="card-title"> </h4>
                                        <p class="card-title-desc"></p>
        
                                        <table id="myTable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                
                                                <th>#</th>
                                                <th>REWARD AMOUNT (R)</th>
                                                <th>STATUS</th>
                                                <th>RESPONDENT</th>
                                                <th>USER</th>
                                                <th>PROJECT</th>
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
            url: "{{ route('get_all_rewards') }}",
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
                targets: 4,
                width: 115,
                className: "text-center"
            }
        ],
    });
});

function view_details(id) {
    let url = "view_rewards";
    url = url + '/' + id;
    document.location.href = url;
}
</script>
