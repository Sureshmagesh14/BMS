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
                        <h4 class="mb-0">Profile Group Details:</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Profile Group Details</li>
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
                                <a href="#!" data-url="{{ route('groups.edit', $data->id) }}" data-size="xl"
                                    data-ajax-popup="true" class="btn btn-primary" data-bs-original-title="Edit Profile Group"
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
                                            <th>Survey URL</th>
                                            <td>{{ $data->survey_url }}</td>
                                        </tr>
                                        <tr>
                                            <th>Survey URL</th>
                                            <td>
                                                @if ($data->type_id == 1)
                                                    @php
                                                        $type_id = 'Basic';
                                                    @endphp
                                                @elseif($data->type_id == 2)
                                                    @php
                                                        $type_id = 'Essential';
                                                    @endphp
                                                @else
                                                    @php
                                                        $type_id = 'Extended';
                                                    @endphp
                                                @endif
                                                {{ $type_id }}
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

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
@include('admin.layout.footer')

@stack('adminside-js')
@stack('adminside-validataion')
@stack('adminside-confirm')
@stack('adminside-datatable')
