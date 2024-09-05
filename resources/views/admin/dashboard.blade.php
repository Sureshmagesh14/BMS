@include('admin.layout.header')
@yield('adminside-favicon')
@yield('adminside-css')

@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>
    #demo {
        display: none;
    }

    div#tasks-box {
        min-height: 231px !important;
    }

    .apexcharts-legend.apexcharts-align-center.position-right {
        top: 38px !important;
    }

    .card.tasks-box {
        height: 233px;
    }
    
    .card-body {
        overflow: auto; /* Allows the content to scroll */
        /* display: flex; */
        flex-direction: column;
    }
</style>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <!-- starts -->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">BMS</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="card tasks-box">
                        <div class="card-body">

                            <h4 class="card-title mb-4">Respondent Status</h4>
                            <div class="apex-charts" id="chart"></div>
                        </div>
                    </div>
                </div>
                <!-- end col-->
                <div class="col-xl-4">
                    <div class="card tasks-box">
                        <div class="card-body">

                            <h4 class="card-title mb-4">Respondent Profile Completion</h4>
                            <div class="apex-charts" id="chart_one"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card tasks-box" id="tasks-box">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Shareable URL to join the database</h4>
                            <p class="">Copy below share link to share with friends and
                                family </p>
                            <div class="col-sm-12 d-flex">
                                <div class="input-group mb-3">
                                    <input type="text" value="{{ URL::to('/') }}?r={{ $share_link->share_link }}" readonly type="text"
                                    name="SearchString"   class="form-control" id="survey" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                      <span  onclick="copy_link();" class="input-group-text" id="basic-addon2">Copy</span>
                                    </div>
                                  </div>
                            </div>
                            
                        </div>
                    </div>
                </div>


                <!-- end col-->
            </div>

            <div class="row">
                <div class="col-12 text-right">
                    <div class="btn-group dropdown-filter">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                aria-labelledby="filter" role="presentation" class="fill-current text-80">
                                <path fill-rule="nonzero"
                                    d="M.293 5.707A1 1 0 0 1 0 4.999V1A1 1 0 0 1 1 0h18a1 1 0 0 1 1 1v4a1 1 0 0 1-.293.707L13 12.413v2.585a1 1 0 0 1-.293.708l-4 4c-.63.629-1.707.183-1.707-.708v-6.585L.293 5.707zM2 2v2.585l6.707 6.707a1 1 0 0 1 .293.707v4.585l2-2V12a1 1 0 0 1 .293-.707L18 4.585V2H2z">
                                </path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"
                                class="ml-2">
                                <path fill="var(--90)"
                                    d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z">
                                </path>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="card p-2" style="max-height: 300px; overflow-y: auto;">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <h5>Year Filter</h5>
                                        <select name="type_filter" id="type_filter" class="form-control"
                                            onchange="select_year(this);">
                                            <option value="">Select Year</option>
                                            @for ($i = date('Y'); $i >= date('Y') - 10; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </li>
                                    <li class="mb-2">
                                        <h5>Month Filter</h5>
                                        <select name="status_filter" id="status_filter" class="form-control"
                                            onchange="select_month(this);">
                                            <option value="">Select Month</option>
                                            @php
                                                // Get current month and year
                                                $currentMonth = date('n');
                                                $currentYear = date('Y');

                                                $months = [];
                                                for ($i = 0; $i < 12; $i++) {
                                                    $timestamp = mktime(0, 0, 0, $currentMonth + $i, 1, $currentYear);
                                                    $label = date('F', $timestamp);
                                                    $value = date('n', $timestamp);
                                                    $months[$value] = $label;
                                                }
                                                ksort($months);
                                            @endphp
                                            @foreach ($months as $value => $label)
                                                <option value="{{ $label }}">{{ $label }}</option>
                                            @endforeach
                                        </select>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="user_events" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Name</th>
                                        <th>New Respondents Added</th>
                                        <th>New Respondents Deactivated</th>
                                        <th>Respondent Profile Updated</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- End Page-content -->
            @include('admin.layout.footer')
            @yield('adminside-script')
            @stack('adminside-js')
            @stack('adminside-datatable')
            <script src="{{ asset('assets//libs/apexcharts/apexcharts.min.js') }}"></script>
            <script>
                var tempcsrf = '{!! csrf_token() !!}';

                year = '';
                month = '';
                $(document).ready(function() {
                    user_events(year, month);
                });



                function select_year(get_this) {
                    year = $(get_this).val();
                    user_events(year, month);
                }

                function select_month(get_this) {
                    month = $(get_this).val();
                    user_events(year, month);
                }


                function user_events(year, month) {
                    $('#user_events').dataTable().fnDestroy();
                    var postsTable = $('#user_events').dataTable({
                        "ordering": false,
                        "processing": true,
                        "searching": false,
                        "serverSide": true,
                        "deferRender": true,
                        "iDisplayLength": 100,
                        "lengthMenu": [
                            [100, "All", 50, 25],
                            [100, "All", 50, 25]
                        ],
                        dom: 'lfrtip',
                        "ajax": {
                            "url": "{{ route('get_activity_data') }}",
                            "data": {
                                _token: tempcsrf,
                                year: year,
                                month: month,
                            },
                            "dataType": "json",
                            "type": "POST"
                        },
                        "columns": [{
                                "data": "id"
                            },
                            {
                                "data": "full_name"
                            },
                            {
                                "data": "createCount"
                            },
                            {
                                "data": "updateCount"
                            },
                            {
                                "data": "deactCount"
                            },

                        ],
                        "order": [
                            [1, "asc"]
                        ],
                        stateSave: false,
                    });
                }



                var options = {
                    series: [{{ $active_val }}, {{ $pending_val }}, {{ $deactive_val }}, {{ $unsub_val }},
                        {{ $black_val }}
                    ],
                    labels: ['Active {{ $act_per }}', 'Pending {{ $dec_per }}', 'Deactivated {{ $unsub_pre }}',
                        'Unsubscribed {{ $pen_per }}', 'Blacklisted {{ $bla_per }}'
                    ],
                    chart: {
                        width: 380,
                        type: 'donut',
                    },
                    plotOptions: {
                        pie: {
                            startAngle: -90,
                            endAngle: 270
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'gradient',
                    },
                    legend: {
                        formatter: function(val, opts) {
                            return val + " - " + opts.w.globals.series[opts.seriesIndex]
                        }
                    },
                    title: {
                        text: 'Respondent Status {{ $tot }} total'
                    },
                    responsive: [{
                        breakpoint: 768, // Adjust for different breakpoints as needed
                        options: {
                            chart: {
                                width: '90%' // Adjust width for medium screens
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }, {
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%' // Full width on small screens
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();

                var colors = ["#FF0000", "#008000"];
                var options = {
                    series: [{{ $incomplete }}, {{ $complete }}],
                    labels: ['Incomplete {{ $incomp_per }}', 'Complete {{ $comp_per }}'],
                    colors: colors,
                    chart: {
                        width: 380,
                        type: 'donut',
                    },
                    plotOptions: {
                        pie: {
                            startAngle: -90,
                            endAngle: 270
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        colors: ['#FF0000', '#008000']
                    },

                    legend: {
                        formatter: function(val, opts) {
                            return val + " - " + opts.w.globals.series[opts.seriesIndex]
                        }
                    },
                    title: {
                        text: 'Respondent Profile Completion {{ $tot }} total'
                    },
                    responsive: [{
                        breakpoint: 768, // Adjust for different breakpoints as needed
                        options: {
                            chart: {
                                width: '90%' // Adjust width for medium screens
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }, {
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%' // Full width on small screens
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#chart_one"), options);
                chart.render();


                function copy_link() {
                    var checkval = $('#survey').val();
                    if (checkval != '') {
                        let copyGfGText = document.getElementById("survey");
                        copyGfGText.select();
                        document.execCommand("copy");
                        toastr.success('Survey Link Copied Successfully');
                    } else {
                        toastr.error('No Survey Link Found');
                    }
                }
            </script>
