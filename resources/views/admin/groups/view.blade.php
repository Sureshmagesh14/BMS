
<div class="table-responsive mb-0" >
    <table class="table">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{$data->id}}</td>
            </tr>
            <tr>
                <th>Bank Name</th>
                <td>{{$data->bank_name}}</td>
            </tr>
            <tr>
                <th>Branch Code</th>
                <td>{{$data->branch_code}}</td>
            </tr>
            <tr>
                <th>Active</th>
                <td>
                    @if($data->active==1)
                    @php
                        $active='Yes';
                    @endphp
                    @else
                    @php
                    $active='No';
                @endphp
                    @endif
                    {{$active}}
                </td>
            </tr>
        </tbody>
    </table>
</div>