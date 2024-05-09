@include('user.layout.header-2')
@php 
$cat = '';
@endphp

 <section class="bg-greybg vh-100">
      <div class="container">
        <div class="row align-items-center justify-content-center pt-5">
        
              
                <div class="bg-white my-2 max-w-100" >
                  <h4 class="d-flex align-items-center justify-content-around">                       
                          <span class="small-font-sm">Cashout Summary</span>   
                  </h4>
                      <table class="table text-center vitable">
                        <thead>
                            <tr>
                                <th>Project </th>
                                <th>Type </th>
                                <th>Points </th>
                                <th>Amount </th>
                                <th>Status </th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($get_res as $res)
                                <tr>
                                <td>{{$res->name}}</td>
                                <td>
                                    @php 
                                    if($res->type_id==1){
                                        $types= 'EFT';
                                    }else if($res->type_id==2){
                                        $types= 'Data';
                                    }else if($res->type_id==3){
                                        $types= 'Airtime';
                                    }
                                    else if($res->type_id==4){
                                        $types= 'Donation';
                                    }
                                    else{  
                                        $types= '-';
                                    }
                                    @endphp 
                                    {{$types}}
                                </td>
                                <td>
                                    {{$res->points}}
                                </td>
                                <td>
                                    {{$res->amount}}
                                </td>
                                <td>
                                    @php 
                                    if($res->status_id == 0){
                                        $stats= 'Failed';
                                    }else if($res->status_id == 1){
                                        $stats= 'Pending';
                                    }else if($res->status_id == 2){
                                        $stats= 'Processing';
                                    }else if($res->status_id == 3){
                                        $stats= 'Complete';
                                    }else if($res->status_id == 4){
                                        $stats= 'Declined';
                                    }else{  
                                        $stats= 'Approved For Processing';
                                    }
                                    @endphp 

                                    {{$stats}}
                                </td>
                                <td>
                                    {{$res->updated_at}}
                                </td>
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

  $('#nav_rewards').addClass('active');
    
});
</script>
