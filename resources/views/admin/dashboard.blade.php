@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>
    #demo {
        display: none;
    }

    .card {
        min-height: 231px !important;
    }

    .apexcharts-legend.apexcharts-align-center.position-right {
        top: 38px !important;
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
                    <div class="card tasks-box">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Shareable URL to join the database</h4>
                            <p class="">Copy below share link to share with friends and
                                family </p>
                            <div class="col-sm-12 d-flex">
                                <input class="form-control mr-1" id="survey"
                                    value="{{ URL::to('/') }}?r={{ $share_link->share_link }}" readonly type="text"
                                    name="SearchString" placeholder="Search">
                                <button type="submit" class="btn btn-default btn-info"
                                    onclick="copy_link();">Copy</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- end col-->
            </div>

            <div class="row">

            <div class="col-12 text-right">
            <select id="year">
            @for($i = date('Y'); $i>=date('Y')-10; $i--)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
            </select>

            <select name="month" id="month" size='1'>
            @for ($i = 0; $i < 12; $i++)
                @php 
                $time = strtotime(sprintf('%d months', $i));   
                $label = date('F', $time);   
                $value = date('n', $time);
                @endphp 
                <option value='{{$value}}'>{{$label}}</option>
            @endfor
            </select>
            <button type="submit" class="btn btn-default btn-primary" onclick="banks_table();">Submit</button>
            </div>
            <div class="col-12">
                    <div class="card">
                        <div class="card-body">
            
            <table id="banks_table" class="table dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>User Code</th>
                        <th>User Name</th>
                        <th>New Respondents Added</th>
                        <th>New Respondents Deactivated</th>
                        <th>Respondent Profile Updated</th>
                    </tr>
                </thead>
               
                <tbody>
                @foreach($dashboard_data as $data)
                    <tr>
                        <td>{{$data['id']}}</td>
                        <td>{{$data['name']}}</td>
                        <td>{{$data['createCount']}}</td>
                        <td>{{$data['deactCount']}}</td>
                        <td>{{$data['updateCount']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>


                </div>
                </div>
                </div>
            </div>

            <!-- End Page-content -->
            @include('admin.layout.footer')
            @yield('adminside-script')
            @stack('adminside-js')
            <script src="{{ asset('assets//libs/apexcharts/apexcharts.min.js') }}"></script>
            <script>
                var tempcsrf = '{!! csrf_token() !!}';

                $(document).ready(function() {
                    //banks_table();
                });

                function banks_table(year,month) {
                    $('#banks_table').dataTable().fnDestroy();
                    $('#banks_table').DataTable({
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
                            url: "{{ route('get_all_banks') }}",
                            data: {
                                _token: tempcsrf,
                                year: year,
                                month: month,
                            },
                            error: function(xhr, error, thrown) {
                                alert("undefind error");
                            }
                        },
                        columns: [
                            { data: 'select_all',name: 'select_all',orderable: false,searchable: false },
                            { data: 'id_show',name: 'id_show',orderable: true,searchable: true },
                            { data: 'bank_name',name: 'bank_name',orderable: true,searchable: true },
                            { data: 'branch_code',name: 'branch_code',orderable: true,searchable: true },
                            { data: 'active',name: 'active',orderable: false,searchable: false },
                            { data: 'action',name: 'action',orderable: false,searchable: false }
                        ]
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
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
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
                    series: [{{ $complete }}, {{ $incomplete }}],
                    labels: ['Incomplete {{ $comp_per }}', 'Complete {{ $incomp_per }}'],
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
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
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
