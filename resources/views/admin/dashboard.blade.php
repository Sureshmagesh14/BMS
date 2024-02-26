@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">

    <!-- starts -->
    <div class="container-fluid" >
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
            <!-- end page title -->

            <div class="row">
               
                    <div class="card">
                        <div class="card-body">

                        <!-- starts -->
                       
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                              
                                                <div>
                                                    <div class="apex-charts" id="chart"></div>
                                                </div>
                                            </div>
            
                                            
                                        </div>
                                 
                        
                                        
                        <!-- ends -->
                        </div>
                    </div>
               
            </div>
    </div>   
    <!-- ends -->
 
       
    
    </div>
    <!-- End Page-content -->

    @yield('adminside-script')
    @include('admin.layout.footer')
    @stack('adminside-js')


@include('admin.layout.footer')

<script src="{{ asset('public/assets//libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
  
  var options = {
          series: [{{$active_val}}, {{$pending_val}}, {{$deactive_val}}, {{$unsub_val}}, {{$black_val}}],
          labels: ['Active', 'Pending', 'Deactivated', 'Unsubscribed','Blacklisted'],
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
          text: 'Respondent Status  '
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
      
</script>