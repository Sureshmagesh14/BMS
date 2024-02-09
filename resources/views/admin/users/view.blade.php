
<div class="table-responsive mb-0" >
    <table class="table">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{$data->id}}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{$data->name}}</td>
            </tr>
            <tr>
                <th>Surname</th>
                <td>{{$data->surname}}</td>
            </tr>
            <tr>
                <th>RSA ID / Passport</th>
                <td>
                    {{$data->id_passport}}
                </td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{$data->email }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>
                    @if($data->role_id==1)
                        Admin
                      @elseif($data->role_id==2)
                        User
                    @else
                        Temp
                   @endif
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if($data->status_id==1)
                        Active
                     @else
                        Inactive
                     @endif
                   
                </td>
            </tr>
            <tr>
                <th>Share Link</th>
                <td>{{$data->share_link}}</td>
            </tr>
           
        </tbody>
    </table>

    <a href="{{ route('inner_module',['module' => 'user_to_project', 'id' => $data->id]) }}" class="btn btn-primary">Create Project</a>
</div>