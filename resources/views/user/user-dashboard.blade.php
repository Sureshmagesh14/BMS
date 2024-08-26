@include('user.layout.header-2')
<style>
    #about_brand {
        text-decoration: none;
        color: unset;
    }
.h-100p{
    height:100%;
}
.fa{
    font-size:18px !important;
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
    .bg-yellow{
        background: #fabd21;
    }
    .bg-blues{
        background: #2197bd !important; 
    }
    .bg-green{
        background: #04c47d;
    }
    .cir-border{
        border: 1px solid #fff;
    border-radius: 25px !important;
    }
    .row2 .col-md-6{
        width: calc(50% - 10px) !important;
    margin: 10px;
    }
    .center-col{
        width:calc(33% - 20px);
        margin:0px 10px;
    }
    .fit-content{
        width: fit-content;
    }
    @media (max-width: 768px) {
    .row2 .col-md-6 {
        width: 100% !important; /* Adjust width for smaller screens */
        margin: 5px; /* Adjust margin for smaller screens */
    }
    .center-col{
        width:calc(100% - 0px);
        margin:10px 0px 10px 0px ;
    }
    .cir-border{
    margin-bottom: 10px;
    }
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
          <div class="col-md-12">
             <div class="row">
                <div class="col-md-4 vi-light-grey bg-white cir-border">
                   <div class="logo bg-white pt-3">
                    @if ($data->profile_image != null)
                    <div class="avatar-preview d-flex justify-content-center align-items-center">
                        <div id="imagePreview" class="rounded-circle overflow-hidden"
                            style="background-image: url('{{ asset($data->profile_path.$data->profile_image) }}');
                                    width: 150px; height: 150px; background-size: cover; background-position: center;
                                    border: 2px solid #000;">
                        </div>
                    </div>
                @else
                    <div class="profile text-center m-auto">
                        <span class="vi-usr-profile1 d-inline-block p-4 rounded-circle"
                            style="font-size: 72px; line-height: 72px; width: 150px; height: 150px; background-color: #edbf1b; color: #ffffff;">
                            {{ $first_character }}
                        </span>
                    </div>
                @endif
                
                      <div class="py-3 mb-5 text-center">
                        <p class="text-center fw-bolder" style="text-transform: capitalize;">{{ $data->name }}</p>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center d-flex">
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $data->email }}" target="_blank"
                                   class="nav-link d-flex align-items-center text-center m-auto">
                                   <i class="fa fa-envelope yelow-clr pe-2" aria-hidden="true"></i> {{ $data->email }}
                                </a>
                            </div>
                            <div class="col-md-12 text-center d-flex">
                                <a href="tel:{{ $data->mobile }}" class="nav-link d-flex align-items-center text-center m-auto">
                                   <i class="fa fa-phone yelow-clr pe-2" aria-hidden="true"></i>
                                        @php
                                            // Clean up the mobile number by removing any whitespace
                                            $m_number = preg_replace('/\s+/', '', $data->mobile);
                                        
                                            // Initialize $mobile_number to avoid undefined variable error
                                            $mobile_number = '';
                                        
                                            if (strlen($m_number) == 9) {
                                                // Prepend '+27' to 9-digit numbers
                                                $mobile_number = '+27(0) ' . $m_number;
                                            } elseif (strlen($m_number) == 11 && strpos($m_number, '27') === 0) {
                                                // If the number starts with '27' and has 11 digits, add '+' before '27'
                                                $mobile_number = '+' . $m_number;
                                            } elseif (strlen($m_number) == 12 && strpos($m_number, '+27') === 0) {
                                                // If the number starts with '+27' and has 12 digits, use it as is
                                                $mobile_number = $m_number;
                                            } else {
                                                // Handle unexpected formats or provide a default/fallback
                                                $mobile_number = '';
                                            }
                                        @endphp
                                        {{ $mobile_number }}
                                </a>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="btn btn-yellow rounded-pill d-flex align-items-center">
                                    <i class="fa fa-sign-out me-2" aria-hidden="true"></i> Logout
                                </a>
                            </form>
                        </div>
                    </div>
                
                   </div>
                </div>
                <div class="col-md-4 bg-white cir-border center-col">
                   <div class=" max-w-100 h-100p " >
                      <h5 class="p-3 align-items-center justify-content-around small-font-sm">
                         <div class="text-center py-2">Your Rewards Breakdown </div>
                         <div class="row">
                            <!-- <div class="col-4 rounded ">
                               <div class="bg-grey-6 p-2 m-2 w-100 m-h-180 rounded">
                                  <div class="bg-yellow text-white p-2 rounded mt-2 text-center m-auto">{{$get_overrall_rewards}}</div>
                                  <div class="down-triangle-yellow triangle"></div>
                                  <div class="text-center my-2">Total Rewards since {{ \Carbon\Carbon::now()->year }}</div>
                               </div>
                            </div> -->
                            <div class="col-6 rounded ">
                               <div class="bg-grey-6 p-2 m-2 w-100 m-h-180 rounded">
                                  <div class="bg-blues text-white p-2 rounded mt-2 text-center m-auto">{{$get_current_rewards}}</div>
                                  <div class="down-triangle-blue triangle"></div>
                                  <div class="text-center my-2">Total Rewards this year</div>
                               </div>
                            </div>
                            <div class="col-6 rounded ">
                               <div class="bg-grey-6 p-2 m-2 w-100 m-h-180 rounded">
                                  <div class="bg-green text-white p-2 rounded mt-2 text-center m-auto">{{$available_points ?? '0'}}</div>
                                  <div class="down-triangle-green triangle"></div>
                                  <div class="text-center my-2">Available points for Cash Out</div>
                               </div>
                            </div>
                            <div class="col-md-12">
                               <div class="row my-3">
                                  <div class="col-6 my-auto">10 points = R1</div>
                                  <div class="col-6 my-auto">
                                    @if($get_reward >= 40)
                                    <a class="btn btn-yellow width-fit-content ml-auto d-flex" id="request_press"
                                    data-url="{{ route('cashout_form') }}" data-size="xl" data-ajax-popup="true"
                                    data-bs-original-title="{{ __('Cashout Process') }}" data-bs-toggle="tooltip" data-value="{{ $get_reward }}">Request Cash Out</a>
                                    @endif
                                </div>
                               </div>
                            </div>
                         </div>
                      </h5>
                   </div>
                </div>

              


                <div class="col-md-4 bg-white cir-border">
                   <div class="max-w-100 h-100p " style="">
                      <div class="text-center p-2">
                         <div id="radial_multi_chart" class="chart--container">
                         </div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-md-12 row2">
                <div class="row">
                   <div class="col-md-6 bg-white ms-0 cir-border">
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
                                     {{-- 
                                     <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('user.cashouts') }}">Cashout
                                           History</a>
                                        </li>
                                        <!-- <li>
                                           <hr class="dropdown-divider" />
                                           </li>
                                           <li><a class="dropdown-item" href="#">Unclaimed Rewards</a></li> -->
                                     </ul>
                                     --}}
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
                                     <td>
                                     @if($res->project_name_resp!='')
                                     {{ $res->project_name_resp }}
                                     @else 
                                     {{ $res->name }}
                                     @endif 
                                     </td>
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
                                     </td>
                                     <td>{{ $res->reward }}</td>
                                     @php $get_link = \App\Models\Respondents::get_respondend_survey($res->survey_link); @endphp
                                     @if ($data->profile_completion_id == 0)
                                     <td> 
                                     <a href="{{ route('updateprofile_wizard') }}">
                                     To continue please complete your profile </a> </td>
                                     @else
                                     @if ($get_link != null)
                                     <td>
                                        <div class="social-icons text-md-end text-lg-end text-sm-start">
                                           <a target="_blank" href="{{ url('survey/view', $get_link->builderID) }}" ><i class="fa fa-play" aria-hidden="true" title="Start" style="background-color: #fbbd0a;"></i></a>
                                           @if($res->access_id==1)
                                           
                                            @if (Carbon\Carbon::parse($res->created_at)->toDateString() >= '2024-08-23')
                                            <a href="{{ url('share_project', $res->project_link) }}"><i class="fa fa-share-square" aria-hidden="true" title="Share" style="background-color: #fbbd0a;"></i></a>
                                            @endif 
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
                   <div class="col-md-6 my-sm-5-mob bg-white me-0 cir-border">
                      <div class="bg-white my-2 max-w-100">
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
                                     <td>
                                     @if($res->project_name_resp!='')
                                    {{ $res->project_name_resp }}
                                    @else 
                                    {{ $res->name }}
                                    @endif 
                                    
                                     </td>
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
                                     </td>
                                     <td>
                                        @if($res->is_frontend_complete==1)
                                        {{ $res->reward }}
                                        @endif
                                    </td>
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
          <div class="col-md-12 bg-white my-2 cir-border">
             <div class="bg-white  max-w-100">
                <h5 class=" align-items-center justify-content-around">
                   <div class="w-50"><img class="w-5 me-2 ms-3 my-3" src="{{ asset('user/images/icons/1c-07.png') }}"
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
                         <td>
                          @if($res->project_name_resp!='')
                          {{ $res->project_name_resp }}
                          @else 
                          {{ $res->name }}
                          @endif 
                          
                         </td>
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
                         <td> 
                         <a href="{{ route('updateprofile_wizard') }}">
                         To continue please complete your profile
                         </a>
                                 </td>
                         @else
                         @if ($get_link != null)
                         <td>
                            <div class="social-icons text-md-end text-lg-end text-sm-start">
                               <a target="_blank" href="{{ url('survey/view', $get_link->builderID) }}" ><i class="fa fa-play" aria-hidden="true" title="Start" style="background-color: #fbbd0a;"></i></a>
                               @if($res->access_id==1)

                               
                                @if (Carbon\Carbon::parse($res->created_at)->toDateString() >= '2024-08-23')
                                <a href="{{ url('share_project', $res->project_link) }}"><i class="fa fa-share-square" aria-hidden="true" title="Share" style="background-color: #fbbd0a;"></i></a>
                                @endif 
                                
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
        colors: ['#2197bd', '#04c47d', '#fabd21'],
        theme: {
            monochrome: {
                enabled: false
            }
        },
        chart: {
            height: 400,
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
        },
        responsive: [{
        breakpoint: 480, // Adjust as per your mobile breakpoint
        options: {
            chart: {
                height: 350 // Adjust height for mobile
            },
            plotOptions: {
                radialBar: {
                    size: 100 // Adjust size for mobile
                }
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
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

    $("#request_press, .btn.close").click(function() {
        $('#commonModal').modal('hide'); // Replace #myModal with your modal ID
    });
</script>