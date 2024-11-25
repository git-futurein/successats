@extends('layouts.master')
@section('title')
    Attendence Management
@endsection
@section('page-title')
    Attendence Management
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

    <style>
        .table th, td{
            padding: 1px 0 1px 5px !important;
        }

        .print_table {
            overflow-x: auto;
            width: 100%;
        }

        .print_table table {
            margin-right: 1px;
            min-width: 1700px;
        }
    </style>
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-12">
                @if($errors->any())
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                          <strong>{{$errors->first()}}</strong>
                        </div>
                    </div>
                @endif

                <div class="card p-3">
                    <div class="card-header">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h6 class="card-title mb-0">Attendence Table</h6>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('attendence.print_p', $parent->id) }}" class="btn btn-warning btn-sm me-2">Print</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="print_table">
                            <table class="table table-bordered border-dark">
                                <thead>
                                    <tr>
                                        <th colspan="12"> <h4 class="text-center">SUCCESS RESOURCE CENTRE PTE LTD</h4> </th>
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
                                        <td width="80px">{{ $attendance->date }}</td>
                                        <td width="80px">{{ $attendance->day }}</td>
                                        <td width="80px">{{ $attendance->in_time }}</td>
                                        <td width="80px">{{ $attendance->out_time }}</td>
                                        <td width="100px">{{ $attendance->lunch_hour }}</td>
                                        <td width="100px">{{ $attendance->total_hour_min }}</td>
                                        <td width="100px">{{ $attendance->ot_hour_min }}</td>
                                        <td width="80px">---</td>
                                        <td width="200px">{{ $attendance->remark }}</td>
                                        <td width="80px">{{ $attendance->ph }}</td>
                                        <td width="200px">
                                            @foreach ($leaveTypes as $type)
                                                <span style="display: {{$type->id == $attendance->type_of_leave ? '' : 'none'}}">{{$type->leavetype_code}}</span>
                                            @endforeach
                                        </td>
                                        <td width="150px">{{ $attendance->leave_day }}</td>
                                        <td width="200px">{{ $attendance->type_of_reimbursement }}</td>
                                        <td width="150px">{{ $attendance->amount_of_reimbursement }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                $('#start_date, #end_date').on('change', function () {
                    var startDateValue = $('#start_date').val();
                    var endDateValue = $('#end_date').val();

                    var newUrl = "{{ route('attendence.index') }}?start_date=" + startDateValue + "&end_date=" + endDateValue;
                    window.location.href = newUrl;
                });
            });
        </script>
    @endsection
