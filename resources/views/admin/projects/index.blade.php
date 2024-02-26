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
                                    <h4 class="mb-0">projects</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">projects</li>
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
<a class="dropdown-item" href="#">Respondent Project Engagement by Month & Year</a>
<a class="dropdown-item" href="#">Respondent Project Engagement by Respondent</a>
</div>
</div>


                                            <a href="{{url('projects_export/xlsx')}}" class="btn btn-primary waves-effect waves-light"><i class="fa fa-file-excel"></i> Export</a>

                                    <a href="#!" data-url="{{ route('projects.create') }}" data-size="xl" data-ajax-popup="true"
                                        class="btn btn-primary" data-bs-original-title="{{ __('Create Projects') }}" class="btn btn-primary" data-size="xl"
                                         data-ajax-popup="true" data-bs-toggle="tooltip"
                                        id="create">
                                        Create Project
                                    </a>
                                    @if (Auth::user()->role_id == 1)
                                        <a class="btn btn-danger" class="btn btn-primary" id="delete_all" style="display: none;">
                                            Delete Selected All
                                        </a>
                                    @endif
                                        </div>

                                        <h4 class="card-title"> </h4>
                                        <p class="card-title-desc"></p>
        
                                        <table id="myTable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input select_all" id="inlineForm-customCheck">
                                                        <label class="custom-control-label" for="inlineForm-customCheck" style="font-weight: bold;">Select All</label>
                                                    </div>
                                                </th>
                                                <th>#</th>
                                                <th>Number/Code</th>
                                                <th>Client</th>
                                                <th>Name</th>
                                                <th>Creator</th>
                                                <th>Type</th>
                                                <th>Reward Amount</th>
                                                <th>Project Link</th>
                                                <th>Created</th>
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


            
    @include('admin.layout.footer')
        
    @stack('adminside-js')
    @stack('adminside-validataion')
    @stack('adminside-confirm')
    @stack('adminside-datatable')


    <script>
        var tempcsrf = '{!! csrf_token() !!}';
        function table_checkbox(get_this){
            count_checkbox = $(".tabel_checkbox").filter(':checked').length;
            if(count_checkbox > 1){
                $("#delete_all").show();
            }
            else{
                $("#delete_all").hide();
            }
        }

        $(document).on('click', '#delete_all', function(e) {
            e.preventDefault();
            var all_id = [];

            var values = $("#myTable tbody tr").map(function() {
                var $this = $(this);
                if($this.find("[type=checkbox]").is(':checked')){
                    all_id.push($this.find("[type=checkbox]").attr('id')); 
                    // return {
                    //     id: $this.find("[type=checkbox]").attr('id'),
                    // };
                }
                
            }).get();
          
            $.confirm({
                title: "{{Config::get('constants.delete')}}",
                content:  "{{Config::get('constants.delete_confirmation')}}",
                autoClose: 'cancelAction|8000',
                buttons: {
                    delete: {
                        text: 'delete',
                        action: function() {
                            $.ajax({
                                type: "POST",
                                data: {
                                    _token: tempcsrf,
                                    all_id: all_id
                                },
                                url: "{{ route('projects_multi_delete') }}",
                                dataType: "json",
                                success: function(response) {
                                    if (response.status == 404) {
                                        $('.delete_student').text('');
                                    } else {
                                        datatable();
                                        $.alert('Projects Deleted!');
                                        $("#delete_all").hide();
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

        $(document).ready(function() {
            // user_to_project = "{{ Session::get('user_to_project') }}";
            // if(user_to_project == 1){
            //     $("#create").click();
            // }
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
                    url: "{{ route('get_all_projects') }}",
                    data: {
                        _token: tempcsrf,
                    },
                    error: function(xhr, error, thrown) {
                        alert("undefind error");
                    }
                },
                columns: [
                    { data: 'select_all', name: 'select_all', orderable: false, searchable: false },
            {
                data: 'id',
                name: '#',
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
                targets: 3,
                width: 175,
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
                targets: 10,
                width: 115,
                className: "text-center"
            },
            {
                targets: 11,
                width: 115,
                className: "text-center"
            },
        ],
            });
        }
    
        $(document).on('click', '#delete_projects', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "{{ route('projects.destroy', ':id') }}";
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
                                        $.alert('Project Deleted!');
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
    