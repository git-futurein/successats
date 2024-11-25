<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Print Attendance</title>
     <style>
        .table th, td{
            padding: 0 !important;
            font-size: 10px;
            text-align: center;
        }
    </style>
</head>

<body onload="printPage()">

    <div class="row">
        <div class="col-lg-12">
            <div class="card p-3">
                <div class="card-body">
                    <div class="print_table">
                        <table class="table table-bordered border-dark">
                            <thead>
                                <tr>
                                    <th colspan="12">
                                        <h4 class="text-center">SUCCESS RESOURCE CENTRE PTE LTD</h4>
                                    </th>
                                    <th colspan="2">
                                        <div class="text-center bg-secondary fs-6 text-white">TIMESHEET</div>
                                        <div>Month: {{ Carbon\Carbon::parse($parent->month_year)->format('F') }}</div>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="7">Company: {{ $parent->client->client_name }}</th>
                                    <th colspan="5">DEPT: ---</th>
                                    <th colspan="2">POSITION: ---</th>
                                </tr>
                                <tr>
                                    <th colspan="9">Full Name: {{ $parent->candidate->candidate_name }}</th>
                                    <th colspan="3">Mobile No: {{ $parent->candidate->candidate_home_phone }}</th>
                                    <th colspan="2"></th>
                                </tr>
                                <tr>
                                    <th colspan="14">Official Working Hours: Mon to Fri : 09:00 - 18:00</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Time In</th>
                                    <th scope="col">Time Out</th>
                                    <th scope="col">Lunch Break</th>
                                    <th scope="col">Total Hours Worked</th>
                                    <th scope="col">Overtime Hours (1.5)</th>
                                    <th scope="col">Overtime Hours (2.0)</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">PH</th>
                                    <th scope="col">Type of Leave</th>
                                    <th scope="col">Leave Days</th>
                                    <th scope="col">Type of Reimbursement</th>
                                    <th scope="col">Amount of Reimbursement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $day => $attendance)
                                    @php
                                        ++$day;
                                    @endphp
                                    <tr>
                                        <td style="width: 80px">{{ $attendance->date }}</td>
                                        <td>{{ $attendance->day }}</td>
                                        <td>{{ $attendance->in_time }}</td>
                                        <td>{{ $attendance->out_time }}</td>
                                        <td>{{ $attendance->lunch_hour }}</td>
                                        <td>{{ $attendance->total_hour_min }}</td>
                                        <td>{{ $attendance->ot_hour_min }}</td>
                                        <td>---</td>
                                        <td>{{ $attendance->remark }}</td>
                                        <td>{{ $attendance->ph }}</td>
                                        <td>
                                            @foreach ($leaveTypes as $type)
                                                <span
                                                    style="display: {{ $type->id == $attendance->type_of_leave ? '' : 'none' }}">{{ $type->leavetype_code }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $attendance->leave_day }}</td>
                                        <td>{{ $attendance->type_of_reimbursement }}</td>
                                        <td>{{ $attendance->amount_of_reimbursement }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    <script>
        function printPage() {
            window.print();
        }
    </script>
</body>

</html>
