@include('user.layout.header-2')
<style>
    #about_brand {
        text-decoration: none;
        color: unset;
    }


    table#DataTables_Table_0 {
        /* width: 709.406px; */
    }

    a.zc-ref {
        display: none;
    }

    table#DataTables_Table_1 {
        /* width: 709.406px; */
    }

    div#DataTables_Table_1_wrapper {
        padding: 20px;
    }

    div#DataTables_Table_0_wrapper {
        padding: 20px;
    }

    div#DataTables_Table_2_wrapper {
        padding: 20px;
    }

    .bg-white.my-2.max-w-100 {
        /* min-height: 581px !important; */
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

    .apexcharts-legend.apexcharts-align-center.apx-legend-position-left {
        text-align: left !important;
    }
    .width-fit-content{
        width: fit-content;
    }
    .ml-auto{
        margin-left:auto;
    }
    .m-h-180{
        min-height:180px;
    }
</style>
@php
    $first_character = mb_substr($data->name, 0, 1);
@endphp

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css">
<section class="">
    <div class="container-fluid">

        @if ($data->profile_completion_id == 0)
            <div class="alert alert-danger bs-alert-old-docs text-center">
                <strong>Alert</strong> Profile Incomplete <a href="{{ route('updateprofile_wizard') }}">Update
                    Profile</a>
                <br>
                <small class="leading-none mt-1 text-danger">
                    Cash Outs and Surveys are available if your profile is up to date.
                    Please update your profile.</small>
            </div>
        @endif


        <div class="alert alert-danger bs-alert-old-docs text-center alert_message" style="display: none;"></div>
        <div class="row justify-content-center py-5 mx-auto mt-auto mb-5">
            <div class="col-md-2 vi-light-grey mx-0 px-0 my-2">
                <div class="logo bg-white pt-3">
                    <div class="profile text-center m-auto ">
                        <span class="vi-usr-profile m-auto p-4"
                            style="text-transform: capitalize;">{{ $first_character }}</span>
                    </div>
                    <div class="py-3 mb-5">
                        <p class="text-center fw-bolder" style="text-transform: capitalize;">{{ $data->name }}</p>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $data->email }}" target="_blank"
                            class="nav-link d-flex align-items-center px-2 small-font"><i
                                class="fa fa-envelope yelow-clr pe-2" aria-hidden="true"></i> {{ $data->email }}</a>
                        <!-- <a href="" class="nav-link d-flex align-items-start px-2 small-font my-3"><i
                                class="fa fa-map-marker yelow-clr pe-2" aria-hidden="true"></i> Suite 835 7664 Jolie
                            Islands, East Ardell, MA 74776</a> -->
                        <a href="tel:{{ $data->mobile }}" class="nav-link d-flex align-items-center px-2 small-font"><i
                                class="fa fa-phone yelow-clr pe-2" aria-hidden="true"></i> {{ $data->mobile }}</a>
                    </div>

                </div>
                <div class="text-section bg-white text-center mx-2 px-2">
                    <p class="py-3"><a id="about_brand"
                            href="https://thebrandsurgeon.co.za/?utm_source=app&utm_medium=link&utm_campaign=AppLinks&utm_content=About"
                            target="_blank">About the brand Surgeon</a></p>
                </div>
                <div class="text-section-one bg-white text-center  mx-2 px-2">
                    <p class="py-3">Chat Support</p>
                </div>
                <div class="text-section-one bg-white text-center mx-2 px-2 py-2 mb-3">
                    <button class="btn w-100 vi-nav-bg text-black border-radius-0" id="opt_out"
                        @if ($data->active_status_id != 1) disabled @endif>OPT OUT</button>
                    <p class="small-font">Stop receiving any research request</p>
                </div>
                <!-- <div class="button text-center">
                    <button class="btn w-100 vi-nav-bg text-white border-radius-0"><img class="w-10 me-3"
                            src="{{ asset('user/images/sent.png') }}" alt="">Contact Us</button>
                </div> -->

            </div>
            <div class="col-md-5 my-sm-5-mob">
                {{-- <div class="bg-white">
                    <iframe class="w-100 px-5 my-3 h-400 h-sm-100"
                        src="https://www.youtube.com/embed/vGq8cT1qF60?si=7D_j6L0CbrIj-wBw" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div> --}}
                <!-- <div class="bg-white my-2 max-w-100" style=""> -->
                    
                    <div class="">
                    <div class="bg-white mt-2 mb-2 max-w-100 p-2" style="min-height: 270px !important;">
                    {{-- <h5 class="d-flex align-items-center justify-content-around vi-light-grey small-font-sm">
                        <div><img class="w-5 me-2 ms-3 my-3" src="{{ asset('user/images/icons/1c-06.png') }}"
                                alt="">
                            <span>Plan Status</span>
                        </div>
                        <div class="px-3 d-flex align-items-center">
                            <ul class="ps-2 navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle me-2" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span style="text-transform: capitalize;">{{ $data->name }}</span><i
                                            class="fa fa-angle-down" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('updateprofile') }}">View
                                                Profile</a></li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <h5>
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle p-3 me-2" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            ...
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('updateprofile') }}">View
                                                    Profile</a></li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </h5>
                        </div>
                    </h5> --}}

                    <div class="text-center">
                        <div id="radial_multi_chart" class="chart--container">
                        </div>
                    </div>
                <!-- </div> -->
                </div>
                <div class="bg-white my-2 max-w-100" style="min-height: 400px;">
                    <h5 class="align-items-center justify-content-around">
                        <div><img class="w-5 me-2 ms-3 my-3" src="{{ asset('user/images/icons/1c-07.png') }}"
                                alt="">
                            <span class="small-font-sm">Your Paid 
Online Surveys</span>
                        </div>
                        <div class="px-3">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown w-30 flex-right ml-auto">
                                    <a class="btn btn-yellow width-fit-content d-flex ml-auto" href="{{ route('user.cashouts') }}">Cashout
                                        History</a>

                                    </a>
                                    {{-- <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('user.cashouts') }}">Cashout
                                            History</a></li>
                                    <!-- <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li><a class="dropdown-item" href="#">Unclaimed Rewards</a></li> -->
                                </ul> --}}
                                </li>
                            </ul>
                        </div>
                    </h5>
                    <div class="">
                        <table class="table table-striped table-bordered table-hover dataTable"
                            id="DataTables_Table_1" style="width: 100%;" aria-describedby="completed_info">
                            <thead>
                                <tr>
                                    <th>NAME </th>
                                    <th>DATE </th>
                                    <th>TYPE OF SURVEY </th>
                                    <th>REWARD POINTS </th>
                                    <th>ACTION </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($get_paid_survey as $res)
                                    <tr>
                                        <td>{{ $res->name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($res->closing_date)) }}</td>
                                        <td title="{{ $res->description }}">

                                        @if ($res->type_id == 1) 
                                        Pre-Screener
                                        @elseif ($res->type_id == 2) 
                                        Pre-Task
                                        @elseif ($res->type_id == 3) 
                                        Paid survey
                                        @elseif ($res->type_id == 4) 
                                        Unpaid survey
                                        @endif
                                         
                                            <!-- {{ Illuminate\Support\Str::limit($res->description, $limit = 10, $end = '...') }} -->
                                        </td>
                                        <td>{{ $res->reward }}</td>
                                        @php $get_link = \App\Models\Respondents::get_respondend_survey($res->survey_link); @endphp

                                        <!-- @if ($data->profile_completion_id == 0)

                                        <td> Profile Incomple </td>
                                        @else 
                                            @if ($get_link != null)
                                                <td><a target="_blank"
                                                        href="{{ url('survey/view', $get_link->builderID) }}"
                                                        class="btn btn-yellow">START</a></td>
                                            @else
                                                <td>No Survey</td>
                                            @endif
                                        @endif -->

                @if ($data->profile_completion_id == 0)
                    <td> Profile Incomple </td>
                @else
                    @if ($get_link != null)
                        <td>

                        <div class="social-icons text-md-end text-lg-end text-sm-start">

                        <a target="_blank" href="{{ url('survey/view', $get_link->builderID) }}" ><i class="fa fa-play" aria-hidden="true" title="Start" style="background-color: #fbbd0a;"></i></a>
                        @if($res->access_id==1)
                        <a href="{{ url('share_project', $res->id) }}"><i class="fa fa-share-square" aria-hidden="true" title="Share" style="background-color: #fbbd0a;"></i></a>
                        @endif
                        </div>

                        </td>
                    @else
                        <td>No Survey</td>
                    @endif
                @endif
                                            
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
                    
                <div class="bg-white my-2 max-w-100" style="min-height: 400px;">
                    <h5 class=" align-items-center justify-content-around">
                        <div><img class="w-5 me-2 ms-3 my-3" src="{{ asset('user/images/icons/1c-07.png') }}"
                                alt="">
                            <span class="small-font-sm">Your Survey History</span>
                        </div>
                        <div class="px-3">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown ml-auto">
                                    <a class="btn btn-yellow width-fit-content ml-auto" href="{{ route('user.cashouts') }}">Cashout
                                        History</a>

                                    </a>
                                    {{-- <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('user.cashouts') }}">Cashout
                                            History</a></li>
                                    <!-- <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li><a class="dropdown-item" href="#">Unclaimed Rewards</a></li> -->
                                </ul> --}}
                                </li>
                            </ul>
                        </div>
                    </h5>
                    <div class="">
                        <table class="table table-striped table-bordered table-hover dataTable"
                            id="DataTables_Table_2" style="width: 100%;" aria-describedby="completed_info">
                            <thead>
                                <tr>
                                    <th>NAME </th>
                                    <th>DATE </th>
                                    <th>TYPE OF SURVEY </th>
                                    <th>REWARD POINTS </th>
                                    <th>ACTION </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($get_completed_survey as $res)
                                    <tr>
                                        <td>{{ $res->name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($res->closing_date)) }}</td>
                                        <td title="{{ $res->description }}">
                                        
                                            @if ($res->type_id == 1) 
                                            Pre-Screener
                                            @elseif ($res->type_id == 2) 
                                            Pre-Task
                                            @elseif ($res->type_id == 3) 
                                            Paid survey
                                            @elseif ($res->type_id == 4) 
                                            Unpaid survey
                                            @endif
                                            
                                            <!-- {{ Illuminate\Support\Str::limit($res->description, $limit = 10, $end = '...') }} -->
                                        </td>
                                        <td>{{ $res->reward }}</td>
                                        @php
                                            $get_link = \App\Models\Respondents::get_respondend_survey(
                                                $res->survey_link,
                                            );
                                        @endphp
                                        @if ($get_link != null)
                                            <td><a class="btn btn-yellow" target="_blank"
                                                    href="{{ url('survey/view', $get_link->builderID) }}">DETAIL</a>
                                            </td>
                                        @else
                                            <td>No Survey</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                
            </div>

            <div class="col-md-5">
            <div class="bg-white my-2 max-w-100" style="min-height: 270px !important;">
                        <h5 class="p-3 align-items-center justify-content-around small-font-sm">
                        <div>Your Rewards Breakdown </div>
                        <div class="row">
                            <div class="col-4 rounded ">
                                <div class="bg-grey-6 p-2 m-2 w-100 m-h-180">
                                    <div class="bg-warning text-white p-2 w-50 rounded my-2 text-center m-auto">2300</div>
                                    <div>Total Rewards since 2024</div>
                                </div>
                            </div>
                            <div class="col-4 rounded ">
                                <div class="bg-grey-6 p-2 m-2 w-100 m-h-180">
                                    <div class="bg-primary text-white p-2 w-50 rounded my-2 text-center m-auto">2300</div>
                                    <div>Total Rewards this year</div>
                                </div>
                            </div>
                            <div class="col-4 rounded ">
                                <div class="bg-grey-6 p-2 m-2 w-100 m-h-180">
                                    <div class="bg-success text-white p-2 w-50 rounded my-2 text-center m-auto">2300</div>
                                    <div>Available points for Cash Out</div>
                                </div>
                            </div>
                        </div>
                        </h5>
                    </div>
            <div class="bg-white my-2 max-w-100">
                        <h5 class=" align-items-center justify-content-around">
                        <div><img class="w-5 me-2 ms-3 my-3" src="{{ asset('user/images/icons/1c-07.png') }}"
                                alt=""> <span class="small-font-sm">See if You Qualify for Other Research</span> </div>
                        <div class="px-3">
                            <!-- <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle p-3 me-2" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        ...
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">View Profile</a></li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li><a class="dropdown-item" href="#">Sign Out</a></li>
                                    </ul>
                                </li>
                            </ul> -->
                        </div>
                        </h5>
                        <table class="table table-striped table-bordered table-hover dataTable" id="DataTables_Table_0"
                            style="width: 100%;" aria-describedby="example_info">
                            <thead>
                                <tr>
                                    <th>NAME </th>
                                    <th>DATE </th>
                                    <th>TYPE OF SURVEY </th>
                                    <th>REWARD POINTS</th>
                                    <th>ACTION </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($get_other_survey as $res)
                                    <tr>
                                        <td>{{ $res->name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($res->closing_date)) }}</td>
                                        <td title="{{ $res->description }}">

                                        @if ($res->type_id == 1) 
                                        Pre-Screener
                                        @elseif ($res->type_id == 2) 
                                        Pre-Task
                                        @elseif ($res->type_id == 3) 
                                        Paid survey
                                        @elseif ($res->type_id == 4) 
                                        Unpaid survey
                                        @endif
                                         
                                            <!-- {{ Illuminate\Support\Str::limit($res->description, $limit = 10, $end = '...') }} -->
                                        </td>
                                        <td>{{ $res->reward }}</td>
                                        @php $get_link = \App\Models\Respondents::get_respondend_survey($res->survey_link); @endphp

                                        <!-- @if ($data->profile_completion_id == 0)

                                        <td> Profile Incomple </td>
                                        @else 
                                            @if ($get_link != null)
                                                <td><a target="_blank"
                                                        href="{{ url('survey/view', $get_link->builderID) }}"
                                                        class="btn btn-yellow">START</a></td>
                                            @else
                                                <td>No Survey</td>
                                            @endif
                                        @endif -->

                @if ($data->profile_completion_id == 0)
                    <td> Profile Incomple </td>
                @else
                    @if ($get_link != null)
                        <td>

                        <div class="social-icons text-md-end text-lg-end text-sm-start">

                        <a target="_blank" href="{{ url('survey/view', $get_link->builderID) }}" ><i class="fa fa-play" aria-hidden="true" title="Start" style="background-color: #fbbd0a;"></i></a>
                        @if($res->access_id==1)
                        <a href="{{ url('share_project', $res->id) }}"><i class="fa fa-share-square" aria-hidden="true" title="Share" style="background-color: #fbbd0a;"></i></a>
                        @endif
                        </div>

                        </td>
                    @else
                        <td>No Survey</td>
                    @endif
                @endif
                                            
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

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    // CHART CONFIG
    var basic_data = @php echo $completed[0]; @endphp;
    var essential_data = @php echo $completed[1]; @endphp;
    var extended_data = @php echo $completed[2]; @endphp;

    var fully_completed = (basic_data + essential_data + extended_data) / 3;
    var round = Math.round(fully_completed);

    var options = {
        series: [extended_data, essential_data, basic_data],
        labels: ['Additional Information', 'Your Essential Information', 'Basic'],
        // colors: ['#775DD0', '#00C8E1', '#FFB900'],
        theme: {
            monochrome: {
                enabled: false
            }
        },
        chart: {
            height: 300,
            type: 'radialBar',
        },
        plotOptions: {
            radialBar: {
                dataLabels: {
                    name: {
                        fontSize: '22px',
                    },
                    value: {
                        fontSize: '16px',
                    },
                    total: {
                        show: true,
                        label: 'Total',
                        formatter: function (w) {
                            return round+"%"
                        }
                    }
                },
                offsetY: -5,
                offsetX: -60
            }
        },
        legend: {
            show: true,
            position: 'left',
            containerMargin: {
                right: 5
            }
        },
        title: {
            text: 'Profile Completion Status Keep your profile up to date',
        }
    };

    var chart = new ApexCharts(document.querySelector("#radial_multi_chart"), options);
    chart.render();


    var tempcsrf = '{!! csrf_token() !!}';
    $(document).ready(function() {

        $('#nav_dashboard').addClass('active');
        $('#DataTables_Table_0').DataTable({
            responsive: true,
            "oLanguage": {
                "sEmptyTable": "No Paid Online Surveys Found"
            }
        });
        $('#DataTables_Table_1').DataTable({
            responsive: true,
            "oLanguage": {
                "sEmptyTable": "No Qualify for Other Research Found"
            }
        });
        $('#DataTables_Table_2').DataTable({
            responsive: true,
            "oLanguage": {
                "sEmptyTable": "No Completed Survey Found"
            }
        });
    });

    $("#opt_out").click(function() {
        $.confirm({
            title: "Alert!",
            content: "Are you sure you want to Unsubscribe?",
            autoClose: 'cancel|8000',
            type: 'red',
            icon: 'fa fa-warning',
            typeAnimated: true,
            draggable: false,
            animationBounce: 2,
            buttons: {
                confirm: {
                    text: "Confirm",
                    btnClass: 'btn-red',
                    action: function() {
                        $.ajax({
                            url: "{{ route('opt_out') }}",
                            data: {
                                _token: tempcsrf,
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success == true) {
                                    $(".alert_message").html(
                                        "We were bummed to hear that you're leaving us. We totally respect your decision to cancel, and we've started processing your request."
                                    )
                                    $(".alert_message").show();
                                    setTimeout(function() {
                                        $("#click_signout").click();
                                    }, 2000);
                                }
                            }
                        });
                    }
                },
                cancel: function() {

                }
            }
        });
    });
</script>
