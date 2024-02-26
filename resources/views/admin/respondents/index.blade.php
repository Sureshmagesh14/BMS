@include('admin.layout.header')

@yield('adminside-favicon')
@yield('adminside-css')

@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>
    .datepicker {
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



                                <a href="#!" data-url="{{ route('export_resp') }}" data-size="xl"
                                    data-ajax-popup="true" class="btn btn-primary"
                                    data-bs-original-title="{{ __('export Respondents') }}" class="btn btn-primary"
                                    data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="export">
                                    Export
                                </a>


                                <a href="#!" data-url="{{ route('respondents.create') }}" data-size="xl"
                                    data-ajax-popup="true" class="btn btn-primary"
                                    data-bs-original-title="{{ __('Create Respondents') }}" class="btn btn-primary"
                                    data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
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

                            <table id="myTable" class="table w-full table-responsive" width="100%">
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
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Mobile</th>
                                        <th>Whatsapp</th>
                                        <th>Email</th>
                                        <th>Date of Birth</th>
                                        <th>race</th>
                                        <th>status</th>
                                        <th>profile_completion</th>
                                        <th>inactive_until</th>
                                        <th>opeted_in</th>
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
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>


    <script>
        var tempcsrf = '{!! csrf_token() !!}';
        $(document).ready(function() {
            datatable();


        });



        function datatable() {



            $('#myTable').dataTable().fnDestroy();
            var postsTable = $('#myTable').dataTable({
                "ordering": true,
                "processing": true,
                "serverSide": true,
                dom: 'lfrtip',
                "ajax": {
                    "url": "{{ route('get_all_respond') }}",
                    "data": {
                        _token: tempcsrf,
                    },
                    "dataType": "json",
                    "type": "POST"
                },
                "columns": [

                    {
                        "data": "select_all"
                    },
                    {
                        "data": "id"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "surname"
                    },
                    {
                        "data": "mobile"
                    },
                    {
                        "data": "whatsapp"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "date_of_birth"
                    },
                    {
                        "data": "race"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "profile_completion"
                    },
                    {
                        "data": "inactive_until"
                    },
                    {
                        "data": "opeted_in"
                    },
                    {
                        "data": "options"
                    }
                ],
                "order": [
                    [1, "asc"]
                ],

                stateSave: false,
            });



        }

        $(document).on('click', '#delete_respondents', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "{{ route('respondents.destroy', ':id') }}";
            url = url.replace(':id', id);

            $.confirm({
                title: "{{ Config::get('constants.delete') }}",
                content: "{{ Config::get('constants.delete_confirmation') }}",
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
