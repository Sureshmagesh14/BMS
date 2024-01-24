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
        $(document).ready(function() {
            var tempcsrf = '{!! csrf_token() !!}';

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

//         $(document).on('click', '#delete_content', function(e) {
//             e.preventDefault();
//             var id = $(this).data('id');
//             let url = "delete_contents";
//                                     url = url + '/' + id;
//             document.location.href = url;
//             var trObj = $(this);

// if (confirm("Are you sure you want to delete this user?") == true) {
//     $.ajax({
//         url: url,
//         type: 'DELETE',
//         dataType: 'json',
//         success: function(data) {
//             //alert(data.success);
//             trObj.parents("tr").remove();
//         }
//     });
// }

// });

$(document).on('click', '#delete_content', function() {
     
     var id = $(this).data("id");
     confirm("Are You sure want to delete !");
     let url = "delete_contents";
                                    url = url + '/' + id;
            document.location.href = url;
     $.ajax({
         type: "DELETE",
         url: url,
         success: function (data) {
             table.draw();
         },
         error: function (data) {
             console.log('Error:', data);
         }
     });
 });

        // function delete_contents(id) {
           
        //     $.confirm({
        //                 title: 'Delete Resource?',
        //                 content: 'Are you sure you want to delete the selected resources?',
        //                 autoClose: 'cancelAction|8000',
        //                 buttons: {
        //                     deleteUser: {
        //                         text: 'Delete',
        //                         action: function() {
        //                             let url = "delete_contents";
        //                             url = url + '/' + id;
        //     document.location.href = url;
        //     var trObj = $(this);

        //                                         $.ajax({
        //                                             type: 'POST',
        //                                             url: url,
                                                  
        //                                             headers: {
        //                                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
        //                                                     'content')
        //                                             },

        //                                             success: function(response) {
        //                                                 trObj.parents("tr").remove();
        //                                                 $('#myTable').DataTable().ajax.reload();
        //                                                 $.alert('Deleted the user!');
                                                       
        //                                             },
                                                  

        //                                         });

                                               
        //                                     }
        //                                 },
        //                                 cancel: function() {

        //                                 }
        //                         }
        //                     });
        //             }
    </script>
    <script src="{{ asset('public/assets/js/jquery.validate.js') }}"></script>
