
<div class="table-responsive mb-0" >
    <table class="table">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{$data->id}}</td>
            </tr>
            <tr>
                <th>User</th>
                <td>{{$data->users_data->name.' '.$data->users_data->surname}}</td>
            </tr>
            <tr>
                <th>Action</th>
                <td>{{$data->action}}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{$data->type}}</td>
            </tr>
            <tr>
                <th>Month</th>
                <td>{{$data->month}}</td>
            </tr>
            <tr>
                <th>Year</th>
                <td>{{$data->year}}</td>
            </tr> 
            <tr>
                <th>Count</th>
                <td>{{$data->count}}</td>
            </tr>
           
        </tbody>
    </table>
</div>