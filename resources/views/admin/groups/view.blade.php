
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
                <th>Survey URL</th>
                <td>{{$data->survey_url}}</td>
            </tr>
            <tr>
                <th>Survey URL</th>
                <td>
                    @if($data->type_id==1)
                    @php
                        $type_id='Basic';
                    @endphp
                    @elseif($data->type_id==2)
                    @php
                        $type_id='Essential';
                    @endphp
                    @else
                    @php
                    $type_id='Extended';
                @endphp
                    @endif
                    {{$type_id}}
                </td>
            </tr>
           
           
        </tbody>
    </table>
</div>