@include('admin.layout.header')
@yield('adminside-favicon')
@yield('adminside-css')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
                        <h4 class="mb-0">Contents</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Contents</li>
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
                                <a href="{{ route('create_contents') }}"
                                    data-bs-original-title="{{ __('Edit Consultant') }}" class="btn btn-primary">Create
                                    Content</a>
                            </div>

                            <h4 class="card-title"> </h4>
                            <p class="card-title-desc"></p>

                            <table id="myTable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>

                                        <th>#</th>
                                        <th>Type</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script>
        var tempcsrf = '{!! csrf_token() !!}';
        $(document).ready(function() {


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
                    url: "{{ route('get_all_contents') }}",
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
                        data: 'type_id',
                        name: 'type_id',
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
                        targets: 2,
                        width: 115,
                        className: "text-center"
                    }
                ],
            });
        });

        function view_details(id) {
            let url = "view_contents";
            url = url + '/' + id;
            document.location.href = url;
        }
        $(document).on('click', '#edit_content', function(e) {
            var stud_id = $(this).data("id");
            var url = "{{ route('edit_contents', ':id') }}";
            url = url.replace(':id', stud_id);
            location.href = url;
        });

        $(document).on('click', '#delete_content', function(e) {
            e.preventDefault();

            // $(this).text('Deleting..');
            var id = $(this).data("id");

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            var url = "{{ route('delete_contents', ':id') }}";
            url = url.replace(':id', id);
          
            $.confirm({
                title: 'Delete user?',
                content: 'This dialog will automatically trigger \'cancel\' in 6 seconds if you don\'t respond.',
                autoClose: 'cancelAction|8000',
                buttons: {
                    deleteUser: {
                        text: 'delete user',
                        action: function() {
                            $.ajax({
                                type: "DELETE",
                                data: {
                                    _token: tempcsrf,
                                },
                                url: url,
                                dataType: "json",
                                success: function(response) {
                                    // console.log(response);
                                    if (response.status == 404) {

                                        $('.delete_student').text('');
                                    } else {
                                        $('#myTable').DataTable().ajax.reload();
                                        $.alert('Deleted the user!');

                                        $('.delete_student').text('Yes Delete');

                                    }
                                }
                            });

                        }
                    },
                    cancelAction: function() {
                        $.alert('action is canceled');
                    }
                }
            });



        });
    </script>
    <script src="{{ asset('public/assets/js/jquery.validate.js') }}"></script>
