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
                        <h4 class="mb-0">Rewards</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Rewards</li>
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
                            @include('admin.table_components.rewards_table')
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
            rewards_table();
        });

        function rewards_table() {
            $('#rewards_table').dataTable().fnDestroy();
            $('#rewards_table').DataTable({

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
                    url: "{{ route('get_all_rewards') }}",
                    data: {
                        _token: tempcsrf,
                    },
                    error: function(xhr, error, thrown) {
                        alert("undefind error")
                    }
                },
                columns: [
                    { data: 'select_all',name: 'select_all',orderable: false,searchable: false },
                    { data: 'id',name: '#',orderable: true,searchable: true },
                    { data: 'points',name: 'points',orderable: true,searchable: true },
                    { data: 'status_id',name: 'status_id',orderable: true,searchable: true },
                    { data: 'respondent_id',name: 'respondent_id',orderable: true,searchable: true },
                    { data: 'user_id',name: 'user_id',orderable: true,searchable: true },
                    { data: 'project_id',name: 'project_id',orderable: true,searchable: true },
                    { data: 'action',name: 'action',orderable: false,searchable: false }
                ]
            });
        }

        

        $(document).on('change', '.rewards_select_box', function(e) {
            var all_id = [];
            values = $(this).val();

            if(values == 2){
                var values = $("#user_table tbody tr").map(function() {
                    var $this = $(this);
                    if ($this.find("[type=checkbox]").is(':checked')) {
                        all_id.push($this.find("[type=checkbox]").attr('id'));
                    }
                }).get();
                multi_delete("POST", all_id, "{{ route('rewards_multi_delete') }}", "Rewards Deleted", 'rewards_table');
            }
        });

        function view_details(id) {
            let url = "view_rewards";
            url = url + '/' + id;
            document.location.href = url;
        }
    </script>
