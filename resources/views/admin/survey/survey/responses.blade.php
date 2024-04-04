@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>.card-body{overflow:auto}
img.photo_capture {
    width: 60px;
    height: 50px;
    object-fit: contain;
}</style>

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
                                    @foreach($cols as $qus)
                                    <th>{{$qus['name']}}</th>
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
    <input type="hidden" id="cols" value="{{json_encode($cols)}}"/>
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
            let cols = $('#cols').val();
            $('#response_table').dataTable().fnDestroy();
            $('#response_table').DataTable({
                searching: true,
                ordering: true,
                // dom: 'lfrtip',
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ],
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
                    // success:function(xhr,data){
                    //     console.log(xhr,data);

                    // },
                    error: function(xhr, error, thrown) {
                        console.log(xhr,error,thrown)
                        console.log("User Datatabel Error");

                        // setTimeout(function() {
                        //     location.reload();
                        // }, 2000);
                    }
                },
                initComplete: function (settings, json) {
                    console.log(settings,json)
                    
                },
                columns: JSON.parse(cols)
            });
        }

       
    </script>
