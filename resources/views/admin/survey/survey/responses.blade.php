@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>.card-body{overflow:auto}</style>

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
                        <h4 class="mb-0">Responses</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href=" {{ route('admin.dashboard') }}">Dashboards</a></li>
                                <li class="breadcrumb-item active">Responses</li>
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

                            <table id="response_table" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="select_all" id="inlineForm-customCheck">
                                    </th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Response Info</th>
                                    @foreach($question as $qus)
                                    <th>{{$qus->question_name}}</th>
                                    @endforeach
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
        @stack('adminside-datatable')

    <script>
        var tempcsrf = '{!! csrf_token() !!}';

        $(document).ready(function() {
            response_datatable();
        });

        function response_datatable() {
            $('#response_table').dataTable().fnDestroy();
            $('#response_table').DataTable({
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
                    url: "{{ route('get_all_response',$survey_id) }}",
                    data: {
                        _token: tempcsrf,
                    },
                    error: function(xhr, error, thrown) {
                        console.log("User Datatabel Error");

                        // setTimeout(function() {
                        //     location.reload();
                        // }, 2000);
                    }
                },
                initComplete: function (settings, json) {
                    console.log(settings,json)
                    
                },
                columns: [
                    { data: 'select_all',name: 'select_all',orderable: false,searchable: false },
                    { data: 'id',name: '#',orderable: true,searchable: true },
                    { data: 'name',name: 'name',orderable: true,searchable: true },
                    { data: 'surname',name: 'surname',orderable: true,searchable: true },
                    { data: 'id_passport',name: 'id_passport',orderable: true,searchable: true },
                    { data: 'email',name: 'email',orderable: true,searchable: true },
                    { data: 'role_id',name: 'role_id',orderable: true,searchable: true },
                    { data: 'status_id',name: 'status_id',orderable: true,searchable: true },
                    { data: 'share_link',name: 'share_link',orderable: true,searchable: true },
                ]
            });
        }

       
    </script>
