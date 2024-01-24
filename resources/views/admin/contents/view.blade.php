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
                                        <div class="table-responsive mb-0" >
                                            <table class="table">
                                                <thead>
                                              
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <th>ID</th>
                                                    <td>{{$data->id}}</td>
                                                </tr>
                                                  <tr>
                                                    <th>Type</th>
                                                    <td>
                                                        @if($data->type_id=='1')
                                                        Terms of use
                                                        @else
                                                          Terms and condition';
                                                        @endif
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Content</th>
                                                    <td>{{$data->data}}</td>
                                                </tr>
                                              
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

<script>
<script src="{{ asset('public/assets/js/jquery.validate.js') }}"></script>