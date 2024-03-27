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
    .apexcharts-legend.apexcharts-align-center.position-right{
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
                                <input class="form-control mr-1"
                                    value="{{ URL::to('/') }}?r={{ $share_link->share_link }}" disabled type="text"
                                    name="SearchString" placeholder="Search">
                                <button type="submit" class="btn btn-default btn-info"
                                    onclick="copy('#demo')">Copy</button>
                            </div>
                        </div>
                    </div>
                </div>

                
                <!-- end col-->
            </div>


            <!-- End Page-content -->
            @include('admin.layout.footer')
            @yield('adminside-script')
            @stack('adminside-js')
            <script src="{{ asset('assets//libs/apexcharts/apexcharts.min.js') }}"></script>
            <script>
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


                function copy(selector) {

                    var $temp = $("<div>");
                    $("body").append($temp);
                    $temp.attr("contenteditable", true).html($(selector).html()).select().on("focus", function() {
                        document.execCommand('selectAll', false, null);
                    }).focus();
                    document.execCommand("copy");
                    $temp.remove();
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.success("Link copied");
                }
            </script>
