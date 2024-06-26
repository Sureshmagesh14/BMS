@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Panel Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Panel Details</li>
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
                                <a href="#!" data-url="{{ route('tags.edit', $data->id) }}" data-size="xl"
                                    data-ajax-popup="true" class="btn btn-primary" data-bs-original-title="Edit Panel"
                                    data-bs-toggle="tooltip" id="create">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            <div class="mb-0">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <td>{{ $data->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $data->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>color</th>
                                            <td>
                                                <button type="button" onClick="myFunction('{{ $data->colour }}')"
                                                    class="btn waves-effect waves-light"
                                                    style="background-color: {{ $data->colour }}">
                                                    <i class="uil uil-user"></i>
                                                </button>
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- rewards start page title -->


                </div> <!-- end col -->
            </div> <!-- end row -->
            <div class="text-right">

                <a href="#!" data-url="{{ route('attach_resp_tags', ['tags_id' => $data->id]) }}" data-size="xl"
                    data-ajax-popup="true" class="btn btn-primary" data-bs-original-title="{{ __('Attach Panel') }}"
                    class="btn btn-primary" data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip"
                    id="create">
                    Attach Panel
                </a>

                <a href="#!" data-url="{{ route('import_resp_tags', ['panel_id' => $data->id]) }}" data-size="xl"
                    data-ajax-popup="true" class="btn btn-primary"
                    data-bs-original-title="{{ __('Import - Respondents to Panels') }}" class="btn btn-primary"
                    data-size="xl" data-ajax-popup="true" data-bs-toggle="tooltip" id="create">
                    Import Panels
                </a>
            </div>
            <br>
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <table id="respondents_datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="select_all" id="inlineForm-customCheck">
                                        </th>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Mobile</th>
                                        <th>Whatsapp</th>
                                        <th>Email</th>
                                        <th>Age</th>
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
            </div>

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
@include('admin.layout.footer')

@stack('adminside-js')
@stack('adminside-validataion')
@stack('adminside-confirm')
@stack('adminside-datatable')
<script>
    var tempcsrf = '{!! csrf_token() !!}';
    $(document).ready(function() {
        respondents_datatable();
    });

    function respondents_datatable() {
        $('#respondents_datatable').dataTable().fnDestroy();
        var postsTable = $('#respondents_datatable').dataTable({
            "ordering": true,
            "processing": true,
            "serverSide": true,
            "iDisplayLength": 100,
            "lengthMenu": [
                [100, "All", 50, 25],
                [100, "All", 50, 25]
            ],
            dom: 'lfrtip',
            "ajax": {
                "url": "{{ route('get_all_respond') }}",
                "data": {
                    _token: tempcsrf,
                    inside_form: 'panels',
                    id: '{{ $data->id }}',
                },
                "dataType": "json",
                "type": "POST"
            },
            "columns": [{
                    "data": "select_all"
                },
                {
                    "data": "id_show"
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

    $(document).on('change', '.respondents_select_box', function(e) {
        value = $(this).val();
        $.post("{{ route('respondents_export') }}", {
                _token: tempcsrf,
                id_value: value,
                form: 'respondents'
            },
            function(resp, textStatus, jqXHR) {

                if (resp == 'Error') {
                    console.log("Error");
                } else {
                    console.log("resps", resp);
                    window.location.assign("../" + resp);
                }
            });
    });

    $(document).on('click', '#delete_respondents', function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var url = "{{ route('respondents.destroy', ':id') }}";
        url = url.replace(':id', id);

        single_delete("DELETE", id, url, "Respondents Deleted", 'respondents_datatable');
    });

    $(document).on('click', '.respondents_datatable.delete_all', function(e) {
        e.preventDefault();
        var all_id = [];

        var values = $("#respondents_datatable tbody tr").map(function() {
            var $this = $(this);
            if ($this.find("[type=checkbox]").is(':checked')) {
                all_id.push($this.find("[type=checkbox]").attr('id'));
            }
        }).get();

        multi_delete("POST", all_id, "{{ route('respondents_multi_delete') }}", "Respondents Deleted",
            'respondents_datatable');
    });

    function myFunction(color) {
        // Log the clicked color to console for debugging
        // Create a temporary textarea element to copy the color value
        var textarea = document.createElement('textarea');
        textarea.value = color;
        textarea.style.position = 'fixed'; // Ensure it's not visible
        document.body.appendChild(textarea);

        // Select and copy the color value from the textarea
        textarea.select();
        document.execCommand('copy');

        // Remove the textarea from the DOM after copying
        document.body.removeChild(textarea);

        // Show Toastr success message
        toastr.success('Copied to clipboard successfully');
    }
</script>
@if (count($errors) > 0)
    @foreach ($errors->all() as $message)
        <script>
            toastr.error("{{ $message }}");
        </script>
    @endforeach
@endif

@if (Session::has('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if (Session::has('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif
