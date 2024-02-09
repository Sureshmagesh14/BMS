<div class="table-responsive mb-0">
    <table class="table">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $data->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $data->name }}</td>
            </tr>
            <tr>
                <th>Surname</th>
                <td>{{ $data->surname }}</td>
            </tr>

            <tr>
                <th>Date Of Birth</th>
                <td>{{ $data->date_of_birth }}</td>
            </tr>

            <tr>
                <th>RSA ID / Passport</th>
                <td>{{ $data->id_passport }}</td>
            </tr>

            <tr>
                <th>Mobile Number</th>
                <td>{{ $data->mobile }}</td>
            </tr>

            <tr>
                <th>Whatsapp Number</th>
                <td>{{ $data->whatsapp }}</td>
            </tr>

            <tr>
                <th>Age</th>
                @php
                    $dateOfBirth = $data->date_of_birth;
                    $today = date('Y-m-d');
                    $diff = date_diff(date_create($dateOfBirth), date_create($today));
                @endphp
                <td>{{ $diff->format('%y') }}</td>
            </tr>
            <tr>
                <th>Bank Name</th>
                <td>{{ $data->bank_name }}</td>
            </tr>
            <tr>
                <th>Branch Code</th>
                <td>{{ $data->branch_code }}</td>
            </tr>
            <tr>
                <th>Account Type</th>
                <td>{{ $data->account_type }}</td>
            </tr>
            <tr>
                <th>Account Holder</th>
                <td>{{ $data->account_holder }}</td>
            </tr>
            <tr>
                <th>Account Number</th>
                <td>{{ $data->account_number }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $data->active_status_id }}</td>
            </tr>
            <tr>
                <th>Profile Completion</th>
                <td>{{ $data->profile_completion_id }}</td>
            </tr>
            <tr>
                <th>Opted In</th>
                <td>{{ $data->opted_in }}</td>
            </tr>
            <tr>
                <th>Last Updated</th>
                <td>{{ $data->updated_at }}</td>
            </tr>
            <tr>
                <th>Referral Code</th>
                <td>{{ $data->referral_code }}</td>
            </tr>
            <tr>
                <th>Accepted Terms</th>
                <td>{{ $data->accept_terms }}</td>
            </tr>
            <tr>
                <th>Created By</th>
                <td>{{ $data->created_at }}</td>
            </tr>

        </tbody>
    </table>
</div>
