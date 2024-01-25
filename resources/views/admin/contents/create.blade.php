@include('admin.layout.header')
@yield('adminside-favicon')
@yield('adminside-css')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                                    <form id="form-data">
                                        @csrf
                                        <input type="hidden" id="create_type" name="create_type">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Type
                                                *</label>
                                            <div class="col-md-10">
                                                <select name="type_id" id="type_id" class="form-control" required>
                                                    <option value="" selected="selected" disabled="disabled">
                                                        Choose an option
                                                    </option>
                                                    <option value="1">Terms of use</option>
                                                    <option value="2">Terms and Condition</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-search-input"
                                                class="col-md-2 col-form-label">Search</label>
                                            <div class="col-md-10">
                                                <textarea id="data" name="data" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-secondary waves-effect" type="button">
                                                Cancel
                                            </button>&nbsp;&nbsp;
                                            <button class="btn btn-success" id="create_another" type="button">
                                                Create & Add Another
                                            </button>&nbsp;&nbsp;
                                            <button class="btn btn-primary" id="create" type="button">
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
        <script src="{{ asset('public/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        @if (Session::has('success'))
            <script>
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.success("{{ session('success') }}");
            </script>
        @endif

        @if (Session::has('error'))
            <script>
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error("{{ session('error') }}");
            </script>
        @endif
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
            };

            $("#create").click(function(e) {
                e.preventDefault();
                $('#create_type').val(0);
                var data = $('#form-data').serialize();
                $.ajax({
                    type: 'post',
                    url: "{{ route('save_contents') }}",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('#create').html('....Please wait');
                    },
                    success: function(response) {
                        toastr.success(response.success);
                        $('#form-data')[0].reset();
                        setTimeout(function() {
                            window.location.href = "view_contents/" + id";
                        }, 200);

                    },
                    complete: function(response) {
                        $('#create').html('Create New');
                    }
                });
            });

            $("#create_another").click(function(e) {
                e.preventDefault();
                $('#create_type').val(1);
                var data = $('#form-data').serialize();
                $.ajax({
                    type: 'post',
                    url: "{{ route('save_contents') }}",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('#create_another').html('....Please wait');
                    },
                    success: function(response) {
                        toastr.success(response.success);
                        $('#form-data')[0].reset();
                    },
                    complete: function(response) {
                        $('#create_another').html('Create New');
                    }
                });
            });
        </script>
        @include('admin.layout.footer')
        <script src="{{ asset('public/assets/js/jquery.validate.js') }}"></script>
