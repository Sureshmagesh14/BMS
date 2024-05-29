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

    div#DataTables_Table_0_wrapper {
        padding: 20px;
    }

    div#DataTables_Table_1_wrapper {
        padding: 20px;
    }

    .bg-white.my-2.max-w-100 {
        min-height: 581px !important;
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
@php
    $first_character = mb_substr($data->name, 0, 1);
@endphp
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css">
<section class="">
    <div class="container-fluid">

        @if ($data->profile_completion_id == 0)
            <div class="alert alert-danger bs-alert-old-docs text-center">
                <strong>Alert</strong> Profile Incomplete <a href="{{ route('updateprofile_wizard') }}">Update
                    Profile</a>
                <br>
                <small class="leading-none mt-1 text-danger">Cash outs are only available if your profile is up to date.
                    Please update your profile.</small>
            </div>
        @endif


        <div class="alert alert-danger bs-alert-old-docs text-center alert_message" style="display: none;"></div>
        <div class="row justify-content-center py-5 m-auto">
            <div class="col-md-2 vi-light-grey mx-0 px-0">
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
                <div class="bg-white">
                    <iframe class="w-100 px-5 my-3 h-400 h-sm-100"
                        src="https://www.youtube.com/embed/vGq8cT1qF60?si=7D_j6L0CbrIj-wBw" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
                <div class="bg-white my-2 max-w-100" style="min-height: 400px;">
                    <h5 class="d-flex align-items-center justify-content-around">
                        <div><img class="w-5 me-2 ms-3 my-3" src="{{ asset('user/images/icons/1c-07.png') }}"
                                alt=""> <span class="small-font-sm">Current Survey</span> </div>
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
                    <div class="">
                        <table class="table table-striped table-bordered table-hover dataTable" id="DataTables_Table_0"
                            style="width: 100%;" aria-describedby="example_info">
                            <thead>
                                <tr>
                                    <th>NAME </th>
                                    <th>DATE </th>
                                    <th>TASK </th>
                                    <th>REWARD POINTS</th>
                                    <th>ACTION </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($get_respondent as $res)
                                    <tr>
                                        <td>{{ $res->name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($res->closing_date)) }}</td>
                                        <td title="{{ $res->description }}">
                                            {{ Illuminate\Support\Str::limit($res->description, $limit = 10, $end = '...') }}
                                        </td>
                                        <td>{{ $res->reward }}</td>
                                        @php $get_link = \App\Models\Respondents::get_respondend_survey($res->survey_link); @endphp
                                        @if ($get_link != null)
                                            <td><a target="_blank"
                                                    href="{{ url('survey/view', $get_link->builderID) }}"
                                                    class="btn btn-yellow">DETAIL</a></td>
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
                <div class="bg-white" style="min-height: 440px;;">


                    <h5 class="d-flex align-items-center justify-content-around vi-light-grey small-font-sm">
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
                    </h5>


                    <div class="text-center mt-4">

                        <div id="myChart" class="chart--container">
                            <a href="https://www.zingchart.com/" rel="noopener" class="zc-ref">Powered by
                                ZingChart</a>
                        </div>

                    </div>
                    <div class="bg-white my-2 max-w-100" style="min-height: 400px;">
                        <h5 class="d-md-flex align-items-center justify-content-around">
                            <div><img class="w-5 me-2 ms-3 my-3" src="{{ asset('user/images/icons/1c-07.png') }}"
                                    alt="">
                                <span class="small-font-sm">Completed Survey</span>
                            </div>
                            <div class="px-3">
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a class="btn btn-yellow" href="{{ route('user.cashouts') }}">Cashout
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
                                        <th>TASK </th>
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
                                                {{ Illuminate\Support\Str::limit($res->description, $limit = 10, $end = '...') }}
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


            </div>

        </div>
    </div>
</section>
@include('user.layout.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap4.js"></script>


<script src="https://cdn.zingchart.com/zingchart.min.js"></script>

<script>
    // CHART CONFIG

    var completed_imp_one = @php echo $completed[0]; @endphp;
    var completed_imp_two = @php echo $completed[1]; @endphp;
    var completed_imp_three = @php echo $completed[2]; @endphp;

    var notcompleted_imp_one = @php echo $notcompleted[0]; @endphp;
    var notcompleted_imp_two = @php echo $notcompleted[1]; @endphp;
    var notcompleted_imp_three = @php echo $notcompleted[2]; @endphp;

    // -----------------------------
    let chartConfig = {
        type: 'nestedpie',
        title: {
            text: 'Profile Pie Chart',
        },
        legend: {
            borderColor: 'gray',
            borderRadius: '5px',
            borderWidth: '1px',
            dragHandler: 'icon',
            header: {
                text: 'Status',
                fontColor: 'purple',
                fontFamily: 'Georgia',
                fontSize: '12px',
                fontWeight: 'normal',
            },
            icon: {
                lineColor: 'orange',
            },
            item: {
                fontColor: 'black',
                fontFamily: 'Georgia',
            },
            lineStyle: 'dashdot',
            marker: {
                type: 'circle',
            },
            minimize: true,
            toggleAction: 'remove',
        },
        plot: {
            tooltip: {
                text: '%data-year Ages %t: %v',
                padding: '10%',
                alpha: 0.7,
                backgroundColor: 'white',
                borderColor: 'gray',
                borderRadius: '3px',
                borderWidth: '1px',
                fontColor: 'black',
                fontFamily: 'Georgia',
                fontSize: '12px',
                lineStyle: 'dashdot',
                textAlpha: 1,
            },
            valueBox: {
                text: '%data-year',
                fontColor: 'white',
                fontFamily: 'Georgia',
                fontSize: '12px',
                fontWeight: 'normal',
                rules: [{
                    rule: '%p != 0',
                    visible: false,
                }, ],
            },
            alpha: 0.8,
            animation: {
                effect: 'ANIMATION_EXPAND_LEFT',
                onLegendToggle: false,
                method: 'ANIMATION_BACK_EASE_OUT',
                sequence: 'ANIMATION_BY_PLOT',
                speed: 700,
            },
            borderColor: 'white',
            borderWidth: '1px',
            dataYear: ['Basic', 'Essential', 'Extended'],
            shadow: false,
            sliceStart: '30%',
        },
        series: [{
                text: 'Completed',
                values: [completed_imp_one, completed_imp_two, completed_imp_three],
                backgroundColor: 'green',
            },
            {
                text: 'Not-Completed',
                values: [notcompleted_imp_one, notcompleted_imp_two, notcompleted_imp_three],
                backgroundColor: 'red',
            },
        ],
    };

    // RENDER CHARTS
    // -----------------------------
    zingchart.render({
        id: 'myChart',
        data: chartConfig,
    });

    // RENDER CHARTS


    var tempcsrf = '{!! csrf_token() !!}';
    $(document).ready(function() {

        $('#nav_dashboard').addClass('active');
        $('#DataTables_Table_0').DataTable({
            responsive: true,
            "oLanguage": {
                "sEmptyTable": "No Current Survey Found"
            }
        });
        $('#DataTables_Table_1').DataTable({
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
