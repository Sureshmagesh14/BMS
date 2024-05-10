@include('user.layout.header-2')
@php 
$cat = '';
@endphp

 <section class="bg-greybg vh-100">
      <div class="container">
        <div class="row align-items-center justify-content-center pt-5">
        
                <div class="bg-white my-2 max-w-100" >
                  <h4 class="d-flex align-items-center justify-content-around">                       
                          <span class="small-font-sm">Current Survey</span>   
                  </h4>
                  <table class="table text-center" id="respondents_datatable">
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
                                  @if($get_link != null)
                                      <td><a target="_blank" href="{{ url('survey/view', $get_link->builderID) }}" class="btn btn-yellow">DETAIL</a></td>
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

                <div class="bg-white my-2 max-w-100" >
                  <h4 class="d-flex align-items-center justify-content-around">                       
                          <span class="small-font-sm">Completed Survey</span>   
                  </h4>
                      <table class="table text-center vitable">
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
                            @forelse ($get_completed_survey as $res)
                                <tr>
                                    <td>{{ $res->name }}</td>
                                    <td>{{ $res->closing_date }}</td>
                                    <td>{{ $res->description }}</td>
                                    <td>{{ $res->reward }}</td>
                                    @php
                                        $get_link = \App\Models\Respondents::get_respondend_survey($res->survey_link);
                                    @endphp
                                    @if($get_link != null)
                                        <td><a target="_blank" href="{{ url('survey/view', $get_link->builderID) }}" class="btn btn-yellow">DETAIL</a></td>
                                    @else
                                        <td>No Survey</td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No Completed Survey</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
        
        
        </div>
      </div>
    </section>


@include('user.layout.footer')
<script>
$(document).ready(function() {

  $('#nav_surveys').addClass('active');
    
});
</script>
