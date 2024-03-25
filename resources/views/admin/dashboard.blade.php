@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>
    #demo {
        display: none;
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

            <div class="container">
                <div class="row">
                    <div class="col card">
                        <div class="apex-charts" id="chart"></div>
                    </div>
                    <div class="col card">
                        <div class="apex-charts" id="chart_one"></div>
                    </div>
                    <div class="col card"<h3 class="flex mb-3 text-base text-80 font-bold"> Shareable URL to join the
                        database </h3>
                        <div class="min-h-90px">
                            <p class="text-xs text-80 leading-normal">Copy below share link to share with friends and
                                family </p>
                            <div class="overflow-visible max-h-90px flex relative">
                                <input id="" class="form-control"
                                    value="{{ URL::to('/') }}?r={{ $share_link->share_link }}" disabled>
                                <span id="demo"> {{ URL::to('/') }}?r={{ $share_link->share_link }}</span>
                                <br>
                                <button class="btn btn-primary btn-block text-center rounded w-4/12 ml-2 p-3"
                                    style="width: 96%;" onclick="copy('#demo')">Copy</button>
                                <div id="copiedMessage" class="cmessage">
                                    <p class="text-white">Copied to clipboard</p>
                                </div>
                            </div>
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
