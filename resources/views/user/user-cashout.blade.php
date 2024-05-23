@include('user.layout.header-2')
@php
    $cat = '';
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap4.css">
<style>
    table#DataTables_Table_0 {
        /* width: 709.406px; */
    }

    div#DataTables_Table_0_wrapper {
        padding: 20px;
    }

    a.btn.btn-yellow {
        background-color: #edbf1b;
        color: white;
    }
    .form-control-sm {
        height: calc(1.5em + 0.5rem + 2px) !important;
        line-height: 1.5 !important;

    }
    label {
        display: inline-block;
        margin-bottom: 0.5rem !important;
    }
</style>
<section class="bg-greybg vh-100">
    <div class="container">
        <div class="row align-items-center justify-content-center pt-5">


            <div class="bg-white my-2 max-w-100">
                <h4 class="d-flex align-items-center justify-content-around">
                    <span class="small-font-sm">Cashout Summary</span>
                </h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable" style="width: 100%;"
                        aria-describedby="cashout_info">
                        <thead>
                            <tr>
                                <th>Project </th>
                                <th>Type </th>
                                <th>Points </th>
                                <th>Amount </th>
                                <th>Status </th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($get_res as $res)
                                <tr>
                                    <td>{{ $res->name }}</td>
                                    <td>
                                        @php
                                            if ($res->type_id == 1) {
                                                $types = 'EFT';
                                            } elseif ($res->type_id == 2) {
                                                $types = 'Data';
                                            } elseif ($res->type_id == 3) {
                                                $types = 'Airtime';
                                            } elseif ($res->type_id == 4) {
                                                $types = 'Donation';
                                            } else {
                                                $types = '-';
                                            }
                                        @endphp
                                        {{ $types }}
                                    </td>
                                    <td>
                                        {{ $res->points }}
                                    </td>
                                    <td>
                                        {{ $res->amount / 10 }}
                                    </td>
                                    <td>
                                        @php
                                            if ($res->status_id == 0) {
                                                $stats = 'Failed';
                                            } elseif ($res->status_id == 1) {
                                                $stats = 'Pending';
                                            } elseif ($res->status_id == 2) {
                                                $stats = 'Processing';
                                            } elseif ($res->status_id == 3) {
                                                $stats = 'Complete';
                                            } elseif ($res->status_id == 4) {
                                                $stats = 'Declined';
                                            } else {
                                                $stats = 'Approved For Processing';
                                            }
                                        @endphp

                                        {{ $stats }}
                                    </td>
                                    <td>
                                        {{ $res->updated_at }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</section>


@include('user.layout.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap4.js"></script>
<script>
    $(document).ready(function() {

        $('#nav_rewards').addClass('active');
        $('table.table.table-striped.table-bordered.table-hover.dataTable').DataTable({
            responsive: true,
            "oLanguage": {
                "sEmptyTable": "No Cashout Summary Found"
            }
        });

    });
</script>
