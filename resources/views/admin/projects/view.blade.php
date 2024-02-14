
<div class="table-responsive mb-0" >
    <table class="table">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{$data->id}}</td>
            </tr>
            <tr>
                <th>Number / Code</th>
                <td>{{$data->number}}</td>
            </tr>
            <tr>
                <th>Client</th>
                <td>{{$data->client}}</td>
            </tr>
            <tr>
                <th>Creator</th>
                <td>{{$data->user_id}}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{$data->user_id}}</td>
            </tr>
            <tr>
                <th>Reward Amount (R)</th>
                <td>{{$data->reward}}</td>
            </tr>
            <tr>
                <th>Project Link</th>
                <td>{{$data->project_link}}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($data->status_id==1)
                        Pending
                    @elseif($data->status_id==2)
                        Active
                   @elseif($data->status_id==3)
                        Completed
                    @elseif($data->status_id==4)
                        Cancelled
                    @endif
                    
                </td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{$data->description}}</td>
            </tr>
            <tr>
                <th>Email Description 1</th>
                <td>{{$data->description1}}</td>
            </tr>

            <tr>
                <th>Email Description 2 (Pre-task only)</th>
                <td>{{$data->description2}}</td>
            </tr>
            
            <tr>
                <th>Survey Duration (Minutes)</th>
                <td>{{$data->survey_duration}}</td>
            </tr>
            
            <tr>
                <th>Live Date</th>
                <td>{{$data->published_date}}</td>
            </tr>
            <tr>
                <th>Closing Date</th>
                <td>{{$data->closing_date}}</td>
            </tr>
            <tr>
                <th>Accessibility</th>
                <td>
                @if($data->access_id==1)
                Shareable
                @else
                Assigned
                @endif
                </td>
            </tr>
            <tr>
                <th>Survey Link</th>
                <td>{{$data->survey_link}}</td>
            </tr>

        </tbody>
    </table>
</div>