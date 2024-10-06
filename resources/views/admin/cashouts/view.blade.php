<div class="table-responsive mb-0">
    <table class="table">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $data->id }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>
                    @if ($data->type_id == 1)
                        @php $type='EFT'; @endphp
                    @elseif($data->type_id == 2)
                        @php $type='Data';  @endphp
                    @elseif($data->type_id == 3)
                        @php $type='Airtime';  @endphp
                    @elseif($data->type_id == 4)
                        @php $type='Donation';  @endphp
                    @else
                        @php $type='-'; @endphp
                    @endif
                    {{ $type }}
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if ($data->status_id == 0)
                        @php $status='Failed'; @endphp
                    @elseif($data->status_id == 1)
                        @php $status='Pending';  @endphp
                    @elseif($data->status_id == 2)
                        @php $status='Processing';  @endphp
                    @elseif($data->status_id == 3)
                        @php $status='Complete';  @endphp
                    @elseif($data->status_id == 4)
                        @php $status='Declined';  @endphp
                    @elseif($data->status_id == 5)
                        @php $status='Approved For Processing';  @endphp
                    @else
                        @php $status='-'; @endphp
                    @endif

                    {{ $status }}
                </td>
            </tr>
            <tr>
                <th>Amount (R)</th>
                <td>{{ $data->amount / 10 }}</td>
            </tr>
            <tr>
                <th>Points</th>
                <td>
                    @php
                        $points = floor($data->amount / 10) * 10;
                    @endphp
                    
                    {{ $points }}
                </td>
            </tr>
            <tr>
                <th>Respondent</th>
                <td>{{ $data->name . ' - ' . $data->email . ' - ' . $data->mobile }}</td>
            </tr>
            <tr>
                <th>Charity</th>
                <td>{{ $data->charity_id ?? '-' }}</td>
            </tr>
        </tbody>
    </table>
</div>
