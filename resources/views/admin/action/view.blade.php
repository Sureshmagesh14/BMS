
<div class="table-responsive mb-0" >
    <table class="table">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{$data->id}}</td>
            </tr>
            <tr>
                <th>Action Name</th>
                <td>
                  
                    {{$data->name}}
                </td>
            </tr>
            <tr>
                <th>Action Initiated By</th>
                <td>
                    {{$data->uname}}
                </td>
            </tr>
            <tr>
                <th>Action Target</th>
                <td>{{$data->actionable_id}}</td>
            </tr>
            <tr>
                <th>Action Status</th>
                <td>{{$data->status}}</td>
            </tr>
            <tr>
                <th>Original</th>
                <td>{{$data->charity_id}}</td>
            </tr>
            <tr>
                <th>Changes</th>
                <td>{{$data->charity_id}}</td>
            </tr>
            <tr>
                <th>Exception</th>
                <td>{{$data->charity_id}}</td>
            </tr>

            <tr>
                <th>Action Happened At</th>
                <td>{{ date('Y-m-d h:i A', strtotime($data->created_at)) }}</td>
            </tr>
            
        </tbody>
    </table>
</div>

