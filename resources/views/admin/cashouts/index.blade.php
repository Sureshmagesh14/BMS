@include('admin.layout.header')

@yield('adminside-favicon')
@yield('adminside-css')

@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>
    .datepicker {
        z-index: 1100 !important;
    }

    #ui-datepicker-div {
        width: 30% !important;
    }
</style>

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
                        <h4 class="mb-0">Cashouts</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Cashouts</li>
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
                            @include('admin.table_components.cash_outs_table')
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cash Outs Summary by Month & Year</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('export_cashout_year') }}">
                        @csrf
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Select Year:</label>
                            <select id="user" name="user" class="w-full form-control form-select" required="">
                                <option value="" selected="selected" disabled="disabled">Please select</option>
                                {{ $last = date('Y') - 15 }}
                                {{ $now = date('Y') }}
                                @for ($i = $now; $i >= $last; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Select Month:</label>
                            <select id="user" name="user" class="w-full form-control form-select" required="">
                                <option value="" selected="selected" disabled="disabled">Please select</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    @php
                                        $lval = date('F', strtotime("$i/12/10"));
                                    @endphp
                                    <option value="{{ $i }}">{{ $lval }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    @include('admin.layout.footer')

    @stack('adminside-js')
    @stack('adminside-datatable')

    <script>
        var tempcsrf = '{!! csrf_token() !!}';
        type = ''; status = '';
    
        $(document).ready(function() {
            cashout_table(type, status);
        });

        function cashout_table(type, status) {
            $('#cashout_table').dataTable().fnDestroy();
            $('#cashout_table').DataTable({
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
                    url: "{{ route('get_all_cashouts') }}",
                    data: {
                        _token: tempcsrf,
                        type: type,
                        status: status
                    },
                    error: function(xhr, error, thrown) {
                        alert("undefind error")
                    }
                },
                columns: [
                    { data: 'select_all',name: 'select_all',orderable: false,searchable: false },
                    { data: 'id',name: '#',orderable: true,searchable: true },
                    { data: 'type_id',name: 'type_id',orderable: true,searchable: true },
                    { data: 'status_id',name: 'status_id',orderable: true,searchable: true },
                    { data: 'amount',name: 'amount',orderable: true,searchable: true },
                    { data: 'respondent_id',name: 'respondent_id',orderable: true,searchable: true },
                    { data: 'action',name: 'action',orderable: true,searchable: true }
                ]
            });
        }

        function cashout_type(get_this){
            type = $(get_this).val();
            cashout_table(type, status);
        }

        function cashout_status(get_this){
            status = $(get_this).val();
            cashout_table(type, status);
        }

        $(document).on('click', '.cashout_select_box', function(e) {
            values = $(this).val();

            if(values == 5){
                var all_id = [];

                var values = $("#cashout_table tbody tr").map(function() {
                    var $this = $(this);
                    if ($this.find("[type=checkbox]").is(':checked')) {
                        all_id.push($this.find("[type=checkbox]").attr('id'));
                    }
                }).get();

                multi_delete("POST", all_id, "{{ route('cash_multi_delete') }}", "Cashout Deleted", 'cashout_table');
            }
        });
    </script>
