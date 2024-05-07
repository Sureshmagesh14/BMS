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
                        <h4 class="mb-0">{{$survey->title}} - Set Quota</h4>
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
            <div class="row">
                
                <div class="col-12">
                     
                    <div class="card">
                        <div class="card-body">
                            <div class="createBtn">
                                <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{route('survey.createquota',$survey->id)}}" data-ajax-popup="true" data-bs-toggle="tooltip" title="Add Quota" data-title="Add Quota">
                                    <button type="button" class="btn btn-primary waves-effect waves-light">Add Quota</button>
                                </a>
                            </div>
                            <table id="template_table" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Quota Name</th>
                                    <th>Max Response</th>
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
        
       
    </script>
