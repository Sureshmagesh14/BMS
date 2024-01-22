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



                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        @csrf
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Type *</label>
                                        <div class="col-md-10">
                                            <select class="form-control" required>
                                                <option value="" selected="selected" disabled="disabled">
                                                    Choose an option
                                                  </option>
                                               <option value="1">Terms of use</option>
                                               <option value="2">Terms and Condition</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-search-input" class="col-md-2 col-form-label">Search</label>
                                        <div class="col-md-10">
                                            <textarea  class="form-control" ></textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-secondary waves-effect" type="button">
                                          Cancel
                                        </button>&nbsp;&nbsp;
                                        <button class="btn btn-success" id="create" type="button">
                                            Create & Add Another
                                          </button>&nbsp;&nbsp;
                                          <button class="btn btn-primary" type="button">
                                            Create Content
                                          </button>&nbsp;&nbsp;
                                      </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div> <!-- end row -->



            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @yield('adminside-script')
        <script>
              var tempcsrf = '{!! csrf_token() !!}';
              $("#create").click(function(){
                $.post("{{route('save_contents')}}", {username:un,_token: tempcsrf},
                    function (resp, textStatus, jqXHR) {
                        
                    });
});
        </script>
        @include('admin.layout.footer')
        <script src="{{ asset('public/assets/js/jquery.validate.js') }}"></script>
