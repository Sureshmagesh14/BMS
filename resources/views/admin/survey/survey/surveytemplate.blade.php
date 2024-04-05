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
                        <h4 class="mb-0">{{$survey->title}} - @if($type =='welcome') Welcome @else Thank you @endif Templates</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href=" {{ route('admin.dashboard') }}">Dashboards</a></li>
                                <li class="breadcrumb-item"><a href=" {{ route('survey.template',$survey->folder->id) }}">{{$survey->folder->folder_name}}</a></li>
                                <li class="breadcrumb-item"><a href=" {{ route('survey.builder',[$survey->builderID,0]) }}">{{$survey->title}}</a></li>
                                <li class="breadcrumb-item">Template</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <input type="hidden" value="{{$type}}" id="page_type"/>
            <div class="row">
                
                <div class="col-12">
                     
                    <div class="card">
                        <div class="card-body">
                            <div class="createBtn">
                                <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{route('survey.createtemplate',$type)}}" data-ajax-popup="true" data-bs-toggle="tooltip" title="Create @if($type =='welcome') Welcome @elseif($type =='thankyou') Thankyou @endif Template" data-title="Create @if($type =='welcome') Welcome @elseif($type =='thankyou') Thankyou @endif Template">
                                    <button type="button" class="btn btn-primary waves-effect waves-light">Create Template</button>
                                </a>
                            </div>
                            <table id="template_table" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    @if($type == 'welcome')
                                    <th>Title</th>
                                    <th>Sub title</th>
                                    <th>Description</th>
                                    <th>Button Label</th>
                                    <th>Image</th>
                                    @elseif($type == 'thankyou')
                                    <th>Title</th>
                                    <th>Sub title</th>
                                    <th>Image</th>
                                    @endif
                                    <th>Actions</th>
                                    
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
            let page_type = $('#page_type').val();
            let cols;
            if(page_type == 'welcome'){
                cols = [{"data":"title","name":"Title","orderable":true,"searchable":true},{"data":"sub_title","name":"Sub title","orderable":true,"searchable":true},{"data":"description","name":"Description","orderable":true,"searchable":true},{"data":"button_label","name":"Button Label","orderable":true,"searchable":true},{"data":"image","name":"Image","orderable":true,"searchable":true},{"data":"action","name":"Actions","orderable":true,"searchable":true},];
            }else{
                cols = [{"data":"title","name":"Title","orderable":true,"searchable":true},{"data":"sub_title","name":"Sub title","orderable":true,"searchable":true},{"data":"image","name":"Image","orderable":true,"searchable":true},{"data":"action","name":"Actions","orderable":true,"searchable":true},];
            }
            $('#template_table').dataTable().fnDestroy();
            $('#template_table').DataTable({
                searching: true,
                ordering: true,
                dom: 'lfrtip',
                // dom: 'Bfrtip',
                // buttons: [
                //     'excel'
                // ],
                info: true,
                iDisplayLength: 10,
                lengthMenu: [
                    [10, 50, 100, -1],
                    [10, 50, 100, "All"]
                ],
                ajax: {
                    url: "{{ route('get_all_templates',[$survey->id,$type]) }}",
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
                columns: cols
            });
        }

       
    </script>
