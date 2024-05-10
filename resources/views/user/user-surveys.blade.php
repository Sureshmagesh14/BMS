@include('user.layout.header-2')
@php
    $cat = '';
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap4.css">

<section class="bg-greybg vh-100">
    <div class="container">
        <div class="row align-items-center justify-content-center pt-5">

            <div class="bg-white my-2 max-w-100">
                <h4 class="d-flex align-items-center justify-content-around">
                    <span class="small-font-sm">Current Survey</span>
                </h4>
                <table class="table table-striped">
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
                        @forelse ($get_respondent as $res)
                            <tr>
                                <td>{{ $res->name }}</td>
                                <td>{{ $res->closing_date }}</td>
                                <td>{{ $res->description }}</td>
                                <td>{{ $res->reward }}</td>
                                @php $get_link = \App\Models\Respondents::get_respondend_survey($res->survey_link); @endphp
                                @if ($get_link != null)
                                    <td><a target="_blank" href="{{ url('survey/view', $get_link->builderID) }}"
                                            class="btn btn-yellow">DETAIL</a></td>
                                @else
                                    <td>No Survey</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No Survey Assigned</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <br>

            <div class="bg-white my-2 max-w-100">
                <h4 class="d-flex align-items-center justify-content-around">
                    <span class="small-font-sm">Completed Survey</span>
                </h4>
                <table class="table table-striped">
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
                                <td>{{ $res->closing_date }}</td>
                                <td>{{ $res->description }}</td>
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
</section>



@include('user.layout.footer')



<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap4.js"></script>

<script>
    $(document).ready(function() {
        $('table.table.table-striped').dataTable().fnDestroy();
        $('table.table.table-striped').DataTable();
        $('#nav_surveys').addClass('active');



    });

    // $(document).ready(function() {
    //     $('table.display').DataTable();
    // } );
</script>
