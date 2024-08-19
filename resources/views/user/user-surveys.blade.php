@include('user.layout.header-2')
@php
    $cat = '';
@endphp
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css">
<style>
    table#DataTables_Table_1 {
        /* width: 709.406px; */
    }

    div#DataTables_Table_0_wrapper {
        padding: 20px;
    }

    div#DataTables_Table_1_wrapper {
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
<section class="bg-greybg">
    <div class="container mb-5">
        <div class="row align-items-center justify-content-center pt-5 mb-3">

            <div class="bg-white my-2 w-100">
                <h4 class="d-flex align-items-center justify-content-around">
                    <span class="small-font-sm"> Your Paid 
Online Surveys</span>
                </h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable" id="current_survey"
                        style="width: 100%;" aria-describedby="current_survey">
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


                                @if ($profile_data->profile_completion_id == 0)
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
            <br>
            <div class="bg-white my-2 w-100">
                <h4 class="d-flex align-items-center justify-content-around">
                    <span class="small-font-sm">See If You Qualify 
for Other Research</span>
                </h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable" id="current_survey1"
                        style="width: 100%;" aria-describedby="current_survey1">
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

                                      

                @if ($profile_data->profile_completion_id == 0)
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
            <br>

            <div class="bg-white my-2 w-100">
                <h4 class="d-flex align-items-center justify-content-around">
                    <span class="small-font-sm"> Your Survey History</span>
                </h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable" id="completed_survey"
                        style="width: 100%;" aria-describedby="completed_survey">
                        <thead>
                            <tr>
                                <th>NAME </th>
                                <th>DATE </th>
                                <th>TASK </th>
                                <th>AMOUNT </th>
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
                                        $get_link = \App\Models\Respondents::get_respondend_survey($res->survey_link);
                                    @endphp
                                    @if ($get_link != null)
                                        <td><a target="_blank" href="{{ url('survey/view', $get_link->builderID) }}"
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
    </div>
    <div class="my-4 py-1"></div>
</section>



@include('user.layout.footer')



<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nav_surveys').addClass('active');
        $('#current_survey').DataTable({
            responsive: true,
            "oLanguage": {
                "sEmptyTable": "No Paid Online Surveys Found"
            }
        });
        $('#current_survey1').DataTable({
            responsive: true,
            "oLanguage": {
                "sEmptyTable": "No Qualify for Other Research Found"
            }
        });
        $('#completed_survey').DataTable({
            responsive: true,
            "oLanguage": {
                "sEmptyTable": "No Completed Survey Found"
            }
        });

    });
</script>
