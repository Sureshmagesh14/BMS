
<div class="table-responsive mb-0" >
    <table class="table">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{$data->id}}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>
                    @if($data->type_id=='1')
                        Terms of use
                    @else
                        Terms and condition';
                    @endif
                </td>
            </tr>
            <tr>
                <th>Content</th>
                <td>{{$data->data}}</td>
            </tr>
        </tbody>
    </table>
</div>