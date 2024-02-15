@include('admin.layout.header')

@yield('adminside-favicon')
@yield('adminside-css')

@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>
.datepicker{
z-index: 1100 !important;
}
#ui-datepicker-div {
width: 30% !important;
}
</style>
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

                        <div class="row">
                            <div class="col-12">

                           

                                <div class="card">
                                    <div class="card-body">
                                    
                                    
                                    
<div class="text-right">


<a href="#!" data-url="{{ route('export_rewards') }}" data-size="xl" data-ajax-popup="true"
                                        class="btn btn-primary" data-bs-original-title="{{ __('Rewards Summary') }}" class="btn btn-primary" data-size="xl"
                                         data-ajax-popup="true" data-bs-toggle="tooltip"
                                        id="export">
                                        Export
                                    </a>



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
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">



                    <div class="card">
                        <div class="card-body">



                            <div class="text-left">



                                <div class="btn-group" role="group">
                                    <button id="btnGroupVerticalDrop1" type="button"
                                        class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Export <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                        <a class="dropdown-item" href="#">Rewards Summary by Month & Year</a>
                                        <a class="dropdown-item" href="#">Rewards Summary by Respondent</a>

                                    </div>
                                </div>
                                <a class="btn btn-danger" class="btn btn-primary" id="delete_all"
                                    style="display: none;">
                                    Delete Selected All
                                </a>
                            </div>

                            <h4 class="card-title"> </h4>
                            <p class="card-title-desc"></p>

                            <table id="myTable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input select_all"
                                                    id="inlineForm-customCheck">
                                                <label class="custom-control-label" for="inlineForm-customCheck"
                                                    style="font-weight: bold;">Select All</label>
                                            </div>
                                        </th>
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
        var tempcsrf = '{!! csrf_token() !!}';
        $(document).ready(function() {
            datatable();
            $("#content_create_form-data").validate();
        });

        function datatable() {
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
                    url: "{{ route('get_all_rewards') }}",
                    data: {
                        _token: tempcsrf,
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
                columnDefs: [{
                        targets: 0,
                        width: 75,
                        className: "text-center"
                    }, {
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
                    },
                    {
                        targets: 5,
                        width: 115,
                        className: "text-center"
                    },
                ],
            });
        }

        function table_checkbox(get_this) {
            count_checkbox = $(".tabel_checkbox").filter(':checked').length;
            if (count_checkbox > 1) {
                $("#delete_all").show();
            } else {
                $("#delete_all").hide();
            }
        }

        $(document).on('click', '#delete_all', function(e) {
            e.preventDefault();
            var all_id = [];

            var values = $("#myTable tbody tr").map(function() {
                var $this = $(this);
                if ($this.find("[type=checkbox]").is(':checked')) {
                    all_id.push($this.find("[type=checkbox]").attr('id'));
                    // return {
                    //     id: $this.find("[type=checkbox]").attr('id'),
                    // };
                }

            }).get();

            $.confirm({
                title: "{{ Config::get('constants.delete') }}",
                content: "{{ Config::get('constants.delete_confirmation') }}",
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
                                url: "{{ route('rewards_multi_delete') }}",
                                dataType: "json",
                                success: function(response) {
                                    if (response.status == 404) {
                                        $('.delete_student').text('');
                                    } else {
                                        datatable();
                                        $.alert('Rewards Deleted!');
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

        function view_details(id) {
            let url = "view_rewards";
            url = url + '/' + id;
            document.location.href = url;
        }
    </script>
