<div class="table-responsive mb-0" >
    <table class="table">
        <thead>
      
        </thead>
        <tbody>
        <tr>
            <th>ID</th>
            <td>{{$data->id}}</td>
        </tr>

        <tr>
            <th>Reward Amount (R)</th>
            <td>{{$data->points}}</td>
        </tr>

        <tr>
            <th>Status</th>
            <td>
            @if($data->status_id==1)
                {{'Pending'}}

            @elseif($data->status_id==2)

                {{'Approved'}}

            @elseif($data->status_id==3)

                {{'-'}}

            @elseif($data->status_id==4)

                {{'Processed'}}

            @else
                {{'-'}}

            @endif
                
           
            </td>
        </tr>

        <tr>
            <th>Respondent</th>
            <td>
                
                {{$data->rname}} - {{$data->remail}} - {{$data->rmobile}}         
            </td>
        </tr>

        <tr>
            <th>User</th>
            <td>{{$data->uname}}
                
            </td>
        </tr>
        
        <tr>
            <th>Project</th>
            <td>{{$data->pname}}</td>
        </tr>
      
        </tbody>
    </table>