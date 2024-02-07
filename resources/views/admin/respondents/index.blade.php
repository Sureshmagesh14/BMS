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



                                    <div class="text-right">
                                        


<div class="btn-group" role="group">
    <button id="btnGroupVerticalDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Export <i class="mdi mdi-chevron-down"></i>
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">

        <a class="dropdown-item" href="#">Respondent Details</a>
        <a class="dropdown-item" href="#">General Respondent Activity by Respondent</a>
        <a class="dropdown-item" href="#">General Respondent Activity by Month & Year</a>
    </div>
</div>


                                        <a href="{{url('respondent_export/deact')}}" class="btn btn-primary waves-effect waves-light"><i class="fa fa-file-excel"></i> Export Deactivated Respondents</a>
                                        <a href="#!" data-url="{{ route('respondents.create') }}" data-size="xl" data-ajax-popup="true"
                                        class="btn btn-primary" data-bs-original-title="{{ __('Create Respondents') }}" class="btn btn-primary" data-size="xl"
                                         data-ajax-popup="true" data-bs-toggle="tooltip"
                                        id="create">
                                        Create Respondents
                                    </a>
                                        {{-- <div class="btn-group">
                                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                            Action
                                            <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Action</a></li>
                                            </ul>
                                        </div> --}}


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
                var tempcsrf = '{!! csrf_token() !!}';
                $(document).ready(function() {
                    datatable();
                  
                });
                
               
            
                function datatable(){
                    $('#myTable').dataTable().fnDestroy();
                    $('#myTable').DataTable({
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
                            url: "{{ route('get_all_respondents') }}",
                            data: {
                                _token: tempcsrf,
                            },
                            error: function(xhr, error, thrown) {
                                alert("undefind error");
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
                            targets: 12
                        },
                        {
                            targets: 13,
                            width: 115,
                            className: "text-center"
                        }
                    ],
                    });
                }
            
                $(document).on('click', '#delete_respondents', function(e) {
                    e.preventDefault();
                    var id = $(this).data("id");
                    var url = "{{ route('respondents.destroy', ':id') }}";
                    url = url.replace(':id', id);
                  
                    $.confirm({
                        title: "{{Config::get('constants.delete')}}",
                        content:  "{{Config::get('constants.delete_confirmation')}}",
                        autoClose: 'cancelAction|8000',
                        buttons: {
                            delete: {
                                text: 'delete',
                                action: function() {
                                    $.ajax({
                                        type: "DELETE",
                                        data: {
                                            _token: tempcsrf,
                                        },
                                        url: url,
                                        dataType: "json",
                                        success: function(response) {
                                            if (response.status == 404) {
                                                $('.delete_student').text('');
                                            } else {
                                                datatable();
                                                $.alert('Respondents Deleted!');
                                                $('.delete_student').text('Yes Delete');
                                            }
                                        }
                                    });
                                }
                            },
                            cancel: function() {
                                
                            }
                        }
                    });
                });
            </script>
            