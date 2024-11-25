@extends('layouts.master')
@section('title')
    Attendence
@endsection
@section('page-title')
    Attendence
@endsection
@section('css')
    <!-- choices css -->
    <link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection
@section('body')

    <body>
    @endsection
    @section('content')
        <style>
            .remove-label,
            .remove-claim {
                display: none;
                cursor: pointer;
            }

            .bg-f1f1f1 {
                background-color: #f1f1f1;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
            function allWork(days) {
                for (let day = 1; day <= days; day++) {
                    if ($('#allCheckB').is(':checked')) {
                        $('.bg-' + day).addClass('bg-f1f1f1');
                        $('#workCheB-' + day).prop('checked', true).addClass('checked');
                        $('.s-' + day).hide();
                        $('.hi-' + day).show();
                    } else if ($('#allCheckB').is(':not(:checked)')) {
                        $('.bg-' + day).removeClass('bg-f1f1f1');
                        $('#workCheB-' + day).prop('checked', false).removeClass('checked');
                        $('.s-' + day).show();
                        $('.hi-' + day).hide();
                    }

                    timeCalculation(day);
                }
            }

            function work_check(day) {
                if ($('#workCheB-' + day).is(':checked')) {
                    $('.bg-' + day).addClass('bg-f1f1f1');
                    $('.s-' + day).hide();
                    $('.hi-' + day).show();
                    $('#workCheB-' + day).prop('checked', true).addClass('checked');
                } else if ($('#workCheB-' + day).is(':not(:checked)')) {
                    $('.bg-' + day).removeClass('bg-f1f1f1');
                    $('.hi-' + day).hide();
                    $('.s-' + day).show();
                    $('#workCheB-' + day).prop('checked', false).removeClass('checked');
                }
                timeCalculation(day);
            }

            function removeFile(day) {
                $('.attendance_leave_file-' + day).val('');
                $('.remove-label').hide();
            }

            function hasFile(day) {
                $('.remove-label-' + day).show();
            }

            function removeClaim(day) {
                $('.attendance_claim_file-' + day).val('');
                $('.remove-claim').hide();
            }

            function hasClaim(day) {
                $('.remove-claim-' + day).show();
            }

            function timeCalculation(day) {
                let lunch_val = tream($('.lunch_val-' + day).val());
                let inTime = $('.inTime-' + day).val();
                let outTime = $('.outTime-' + day).val();
                let ot = parseTimeString($('.ot-' + day).val());
                const timeDifference = calculateTimeDifference(inTime, outTime);
                const sumTimeDifference = sumTimeDifferences([timeDifference, ot]);
                const normal_time = sumTimeDifference.hours + ' h ' + sumTimeDifference.minutes + ' m';
                let result = subtractTimeDifference(sumTimeDifference, lunch_val);
                result = leaveDay(day, result);
                const total_time = result.hours + ' h ' + result.minutes + ' m';

                $('.totla_time-' + day).val(total_time);
                $('.normal_time-' + day).val(normal_time);
            }

            function leaveDay(day, hour_min) {
                let hours = 0;
                let minutes = 0;
                let will_pay = 1;
                let leave_day = $('.change.leave_days.hi-' + day).val();
                if (leave_day == 'Full Day Leave') {
                    will_pay = 0;
                } else if (leave_day == 'Half Day AM' || leave_day == 'Half Day PM') {
                    will_pay = 0.5;
                }

                const total_min = (hour_min.hours * 60 + hour_min.minutes) * will_pay;
                // Calculate hours and remaining minutes
                hours = Math.floor(total_min / 60);
                minutes = total_min % 60;

                return {
                    hours,
                    minutes
                };
            }

            function parseTimeString(timeString) {
                const regex = /(\d+)\s*h\s*(\d+)\s*m/;
                const match = timeString.match(regex);

                let hours = 0;
                let minutes = 0;

                if (match) {
                    hours = parseInt(match[1], 10);
                    minutes = parseInt(match[2], 10);
                }

                return {
                    hours,
                    minutes
                };
            }

            function tream(value) {
                let totalMinutes = 0;
                if (value === '30 minutes') {
                    totalMinutes = 30;
                } else if (value === '45 minutes') {
                    totalMinutes = 45;
                } else if (value === '1 hour') {
                    totalMinutes = 60;
                } else if (value === '1.5 hour') {
                    totalMinutes = 90;
                } else if (value === '2 hour') {
                    totalMinutes = 120;
                }

                const hours = Math.floor(totalMinutes / 60);
                const minutes = totalMinutes % 60;
                return {
                    hours,
                    minutes
                };
            }

            function calculateTimeDifference(inTime, outTime) {
                let hours = 0;
                let minutes = 0;
                if (!inTime || !outTime) {
                    return {
                        hours,
                        minutes
                    };
                }
                const [inHours, inMinutes] = inTime.split(':').map(Number);
                const [outHours, outMinutes] = outTime.split(':').map(Number);

                const totalInMinutes = inHours * 60 + inMinutes;
                const totalOutMinutes = outHours * 60 + outMinutes;

                const minutesDifference = totalOutMinutes - totalInMinutes;
                hours = (Math.floor(minutesDifference / 60));
                minutes = (minutesDifference % 60);

                return {
                    hours,
                    minutes
                };
            }

            function isValidTimeString(timeString) {
                const regex = /^([01]\d|2[0-3]):([0-5]\d)$/;
                return regex.test(timeString);
            }

            function subtractTimeDifference(minuend, subtrahend) {
                let totalHours = minuend.hours - subtrahend.hours;
                let totalMinutes = minuend.minutes - subtrahend.minutes;

                if (totalMinutes < 0) {
                    totalHours--;
                    totalMinutes += 60;
                }
                return {
                    hours: totalHours,
                    minutes: totalMinutes
                };
            }

            function sumTimeDifferences(timeDifferences) {
                let totalHours = 0;
                let totalMinutes = 0;

                for (const timeDiff of timeDifferences) {
                    totalHours += timeDiff.hours;
                    totalMinutes += timeDiff.minutes;
                }

                // Adjust total minutes if it exceeds 60
                totalHours += Math.floor(totalMinutes / 60);
                totalMinutes %= 60;

                return {
                    hours: totalHours,
                    minutes: totalMinutes
                };
            }
        </script>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Attendence</h4>
                    </div>

                    <div class="card-body" style="overflow-x: hidden;">
                        <!-- Nav tabs -->
                        <div class="row">
                            <div class="col-lg-1">
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#General" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Attendence</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="General" role="tabpanel">
                                <form action="{{ route('get.month.attendence.data') }}" method="POST" id="attendenceForm">
                                    @csrf
                                    <div class="row">
                                        <div class="row col-lg-6 mb-4">
                                            <label for="thirteen" class="col-sm-3 col-form-label">Select Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" name="date" id="dateInput" class="form-control"
                                                    value="{{ isset($selectedDate) ? $selectedDate : Carbon\Carbon::now() }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6  mb-4">
                                            <label for="eleven" class="col-sm-3 col-form-label">Candidate</label>
                                            <div class="col-sm-9">
                                                <input type="hidden" id="candidateId" name="candidate_id">
                                                <select id="candidateDropdown" class="form-control">
                                                    <option value="">Select One</option>
                                                    @foreach ($candidates as $candidate)
                                                        <option
                                                            value="{{ $candidate->candidate_outlet_id }}-{{ $candidate->id }}"
                                                            {{ isset($selectCandidate) ? ($candidate->candidate_outlet_id . '-' . $candidate->id == $selectCandidate ? 'selected' : '') : '' }}>
                                                            {{ $candidate->candidate_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6  mb-4">
                                            <label for="eleven" class="col-sm-3 col-form-label">Company</label>
                                            <div class="col-sm-9">
                                                <select name="company_id" id="companyDropdown" class="form-control">
                                                    <option value="">Select One</option>
                                                    @if (isset($selectCandidate))
                                                        @php
                                                            $company = explode('-', $selectCandidate);
                                                            $company_id = $company[0];
                                                        @endphp
                                                        <option selected value="{{ $company_id }}"> {{ $company_name }}
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row col-lg-6 mb-4">
                                            <label for="thirteen" class="col-sm-3 col-form-label">Invoice Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="invoice_no" class="form-control invoice"
                                                    placeholder="Invoice no">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-sm-12">

                                        <p style="color:red">
                                            Reminders:<br>
                                            1 Indicate actual working hours if you are on half day leave (example: 9am -
                                            1pm)<br>
                                            2 Indicate lunch hours properly. Non-working days must be "no lunch".<br>
                                            3 Do not upload attachments with special character on file name (example: /
                                            \ : * " ? &lt; &gt; ')<br>
                                            4 Wrong / incomplete attendance submission will result to delay in
                                            payment.<br>
                                        </p>
                                        <form method="POST" action="{{ route('mystore') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group" style="max-width: 100%; overflow: auto;">
                                                <div style="display:flex">
                                                    <label class="control-label">Date</label>
                                                    <label class="control-label" style="margin-left: 90px">Day</label>
                                                    <label class="control-label" style="margin-left: 100px;">Time
                                                        In</label>
                                                    <label class="control-label" style="margin-left:90px;">Time
                                                        Out</label>
                                                    <label class="control-label" style="margin-left: 90px;">Next
                                                        Day</label>
                                                    <label class="control-label" style="margin-left: 20px;">Lunch
                                                        Hour</label>
                                                    <label class="control-label" style="margin-left: 80px;">Total
                                                        Hour /
                                                        Minute</label>
                                                    <label class="control-label" style="margin-left: 80px;">Normal Hour /
                                                        Minute</label>
                                                    <label class="control-label" style="margin-left: 70px;">OT
                                                        Hour / Minute</label>
                                                    <label class="control-label" style="margin-left: 65px;">OT
                                                        Calculation</label>
                                                    <label class="control-label" style="margin-left: 60px;">OT
                                                        Edit</label>
                                                    <label style="margin-left: 70px;" class="control-label"><input
                                                            type="checkbox" id="allCheckB" name="work_checkbox"
                                                            class="work_checkbox_parent"
                                                            onclick="allWork({{ $daysInMonth ?? '' }})">
                                                        Work</label>
                                                    <label class="control-label" style="margin-left: 30px;">PH</label>
                                                    <label class="control-label" style="margin-left: 40px;">PH
                                                        Pay</label>
                                                    <label class="control-label"
                                                        style="margin-left: 20px;">Remarks</label>
                                                    <label class="control-label" style="margin-left: 100px;">Type of
                                                        Leave</label>
                                                    <label class="control-label" style="margin-left: 70px;">Leave
                                                        Days</label>
                                                    <label class="control-label" style="margin-left: 80px;">Leave
                                                        Attachment</label>
                                                    <label class="control-label" style="margin-left: 220px;">Claim
                                                        Attachment</label>
                                                    <label class="control-label" style="margin-left: 220px;">Type of
                                                        Reimbursement</label>
                                                    <label class="control-label" style="margin-left: 100px;">Amount of
                                                        Reimbursement</label>
                                                </div>

                                                @if (isset($daysInMonth))
                                                    @for ($day = 1; $day <= $daysInMonth; $day++)
                                                        @php
                                                            $currentDay = $currentMonth->copy()->day($day);
                                                            $isWorkDay = false;
                                                            $inTime = null;
                                                            $outTime = null;
                                                            $lunchTime = null;

                                                            foreach ($timeSheetData as $timesheet) {
                                                                if ($timesheet->day == $currentDay->format('l') && $timesheet->isWork == '1') {
                                                                    $isWorkDay = true;
                                                                    $workingDay = $timesheet->day;
                                                                    $inTime = $timesheet->in_time;
                                                                    $outTime = $timesheet->out_time;
                                                                    $lunchTime = $timesheet->lunch_time;
                                                                    $otRate = $timesheet->ot_rate;
                                                                    $minimum = $timesheet->minimum;
                                                                    $allowance = $timesheet->allowance;
                                                                    $isNextDay = $timesheet->isNextDay;
                                                                    break; // Exit the loop if a matching work day is found
                                                                }
                                                            }
                                                            $isLeave = false;
                                                            $leaveDateFrom = null;
                                                            $leaveType = null;
                                                            $leaveRemarks = null;
                                                            $leaveFilePath = null;
                                                            $leaveDateFrom = null;
                                                            foreach ($leaves as $leave) {
                                                                $leaveDateFrom = $leave->leave_datefrom;
                                                                $leaveDateto = $leave->leave_dateto;

                                                                $date1 = Carbon\Carbon::parse($leaveDateFrom);
                                                                $date2 = Carbon\Carbon::parse($leaveDateto);
                                                                $currentDay = Carbon\Carbon::parse($currentDay);
                                                                for ($date = $date1->copy(); $date->lte($date2); $date->addDay()) {
                                                                    if ($currentDay->isSameDay($date)) {
                                                                        $isLeave = true;
                                                                        $leaveType = $leave->leave_types_id;
                                                                        $leaveDuration = $leave->leave_duration;
                                                                        $leaveRemarks = $leave->leave_reason;
                                                                        $leaveFilePath = $leave->leave_file_path;
                                                                    }
                                                                }
                                                            }

                                                            $startTime = Carbon\Carbon::parse($inTime);
                                                            $endTime = Carbon\Carbon::parse($outTime);

                                                            $duration = $endTime->diff($startTime);

                                                            $hours = $duration->h;
                                                            $minutes = $duration->i;
                                                            $durationParts = [];
                                                            if ($hours > 0) {
                                                                $durationParts[] = $hours . ' h';
                                                            }
                                                            if ($minutes > 0) {
                                                                $durationParts[] = $minutes . ' m';
                                                            }
                                                            $normalTime = implode(' ', $durationParts);

                                                            $l_minutes = 0;
                                                            $l_hours = 0;
                                                            $launch_part = 0;

                                                            if ($lunchTime == '30 minutes') {
                                                                $l_minutes = 30;
                                                                $launch_part = $duration + $l_minutes;
                                                            }
                                                            if ($lunchTime == '45 minutes') {
                                                                $l_minutes = 45;
                                                            }
                                                            if ($lunchTime == '1 hour') {
                                                                $l_hours = 1;
                                                            }
                                                            if ($lunchTime == '1.5 hour') {
                                                                $l_hours = 1;
                                                                $l_minutes = 30;
                                                            }
                                                            if ($lunchTime == '2 hour') {
                                                                $l_hours = 2;
                                                            }
                                                            $updatedEndTime = $endTime
                                                                ->copy()
                                                                ->subHours($l_hours)
                                                                ->subMinutes($l_minutes);

                                                            $updatedDuration = $updatedEndTime->diff($startTime);
                                                            $updatedHours = $updatedDuration->h;
                                                            $updatedMinutes = $updatedDuration->i;
                                                            $total_part = [];
                                                            if ($updatedHours > 0) {
                                                                $total_part[] = $updatedHours . ' h';
                                                            }
                                                            if ($updatedMinutes > 0) {
                                                                $total_part[] = $updatedMinutes . ' m';
                                                            }

                                                            $total_part = implode(' ', $total_part);
                                                        @endphp
                                                        <input type="hidden" value="{{ $candidate_id }}"
                                                            name="group[{{ $day }}][candidate_id]">
                                                        <input type="hidden" value="{{ $company_id }}"
                                                            name="group[{{ $day }}][company_id]">
                                                        <input type="hidden"
                                                            name="group[{{ $day }}][invoice_no]"
                                                            class="form-control" id="invoice" placeholder="Invoice no">
                                                        <div style="display:flex">
                                                            <div
                                                                style="flex:0 0 120px;position: sticky;left: 0;z-index: 20;">
                                                                <input type="text"
                                                                    class="form-control bg-{{ $day }}" readonly
                                                                    placeholder="Date" readonly=""
                                                                    name="group[{{ $day }}][date]"
                                                                    placeholder="Date"
                                                                    value="{{ $currentDay->format('Y-m-d') }}">
                                                            </div>
                                                            <div
                                                                style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
                                                                <input type="text"
                                                                    class="form-control bg-{{ $day }}"
                                                                    readonly="" name="group[{{ $day }}][day]"
                                                                    value="{{ $currentDay->format('l') }}"
                                                                    placeholder="Title">
                                                            </div>
                                                            {{-- <div
                                                                style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
                                                                <input type="time" class="form-control"
                                                                    name="attendance_day1"
                                                                    value="{{ Carbon\Carbon::parse($currentDay)->format('Y-m-d') == $leaveDateFrom ? '--' : ($isWorkDay ? $inTime : '') }}"
                                                                    placeholder="time">
                                                            </div> --}}
                                                            <div
                                                                style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
                                                                <input type="time" style="display: none"
                                                                    class="form-control hi-{{ $day }} inTime-{{ $day }}"
                                                                    name="group[{{ $day }}][in_time]"
                                                                    value="{{ $isLeave == true ? '--' : ($isWorkDay ? $inTime : '') }}"
                                                                    placeholder="time"
                                                                    onchange="timeCalculation({{ $day }})">
                                                                <input type="time"
                                                                    class="form-control s-{{ $day }}"
                                                                    value="" placeholder="time">

                                                                {{-- <input type="time" class="form-control"
                                                                    name="attendance_day1"
                                                                    value="{{ $isLeave == true ? '--' : ($isWorkDay ? $inTime : '') }}"
                                                                    placeholder="time"> --}}
                                                            </div>
                                                            <div
                                                                style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
                                                                <input type="time" style="display: none"
                                                                    class="form-control hi-{{ $day }}  outTime-{{ $day }}"
                                                                    name="group[{{ $day }}][out_time]"
                                                                    value="{{ $isLeave == true ? '--' : ($isWorkDay ? $outTime : '') }}"
                                                                    placeholder="time"
                                                                    onchange="timeCalculation({{ $day }})">
                                                                <input type="time"
                                                                    class="form-control s-{{ $day }}"
                                                                    placeholder="time">
                                                            </div>
                                                            <!--next-->
                                                            <div style="flex:0 0 50px;text-align:center">
                                                                <input type="hidden"
                                                                    name="group[{{ $day }}][next_day]"
                                                                    value="0">
                                                                <input type="checkbox" class="attendance_next_day1 change"
                                                                    data-line="1" value="1"
                                                                    name="group[{{ $day }}][next_day]"
                                                                    {{ $isNextDay == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!--lunch-->
                                                            <div style="flex:0 0 120px;">
                                                                <select
                                                                    class="form-control change hi-{{ $day }} lunch_val-{{ $day }}"
                                                                    data-line="1"
                                                                    onchange="timeCalculation({{ $day }})"
                                                                    id="attendance_lunch"
                                                                    name="group[{{ $day }}][lunch_hour]"
                                                                    data-content="" style="width:100%; display: none">
                                                                    <option value="">Select One</option>
                                                                    @include('admin.attendence.inc.options')
                                                                </select>
                                                                <select class="form-control change s-{{ $day }}"
                                                                    data-line="1" data-content="" style="width:100%">
                                                                    <option value="">Select One</option>
                                                                    @include('admin.attendence.inc.options')
                                                                </select>
                                                            </div>
                                                            <!--total-->
                                                            <div style="flex:0 0 120px;">
                                                                <input type="text"
                                                                    style="text-align:center; display: none"
                                                                    class="form-control week_1 hi-{{ $day }} totla_time-{{ $day }}"
                                                                    data-week="1" readonly=""
                                                                    name="group[{{ $day }}][total_hour_min]"
                                                                    data-content="-1 h "
                                                                    value="{{ $isLeave == true ? '--' : ($isWorkDay ? $total_part : '') }}">
                                                                <input type="text" style="text-align:center"
                                                                    class="form-control week_1 s-{{ $day }}"
                                                                    data-week="1" readonly="" data-content="-1 h "
                                                                    value="0 h">
                                                            </div>
                                                            <!--normal-->
                                                            <div style="flex:0 0 120px;">
                                                                <input type="text"
                                                                    style="text-align:center; display: none"
                                                                    class="form-control hi-{{ $day }} normal_time-{{ $day }}"
                                                                    name="group[{{ $day }}][normal_hour_min]"
                                                                    value="{{ $isLeave == true ? '--' : ($isWorkDay ? $normalTime : '') }}">
                                                                <input type="text" style="text-align:center;"
                                                                    class="form-control s-{{ $day }}"
                                                                    value="0 h">
                                                            </div>
                                                            <!--ot-->
                                                            <div style="flex:0 0 120px;">
                                                                <input type="text" style="text-align:center"
                                                                    name="group[{{ $day }}][ot_hour_min]"
                                                                    class="form-control ot-{{ $day }}"
                                                                    data-week="1" value="0">
                                                                <!--<input type="hidden" id="attendance_ot_hidden1" name="attendance_ot_hidden1" value="">-->


                                                                {{-- <input type="hidden" id="attendance_ot_rate1"
                                                                    name="attendance_ot_rate1" value="">
                                                                <input type="hidden" id="attendance_allowance_minimum1"
                                                                    name="attendance_allowance_minimum1" value="">
                                                                <input type="hidden" id="attendance_allowance_maximum1"
                                                                    name="attendance_allowance_maximum1" value="">
                                                                <input type="hidden" id="attendance_allowance1"
                                                                    name="attendance_allowance1" value=""> --}}
                                                            </div>
                                                            <!--ot hidden-->
                                                            <div style="flex:0 0 120px;">
                                                                <input type="text" style="text-align:center"
                                                                    class="form-control"
                                                                    name="group[{{ $day }}][ot_calculation]"
                                                                    value="0">
                                                            </div>
                                                            <!--edit-->
                                                            <div style="flex:0 0 80px;text-align:center">
                                                                <input type="checkbox" class="attendance_edit1"
                                                                    data-line="1" value="1"
                                                                    name="group[{{ $day }}][ot_edit]">
                                                            </div>
                                                            <!--work-->
                                                            <div style="flex:0 0 100px;text-align:center">
                                                                @if ($isWorkDay == true && $isLeave == false)
                                                                    <input type="checkbox"
                                                                        id="workCheB-{{ $day }}"
                                                                        class="work attendance_work1" data-line="1"
                                                                        value="1"
                                                                        name="group[{{ $day }}][work]"
                                                                        onclick="work_check('{{ $day }}')">
                                                                @else
                                                                    <input type="checkbox" class="work attendance_work1"
                                                                        value="0"
                                                                        name="group[{{ $day }}][work]"
                                                                        onclick="work_check('{{ $day }}')">
                                                                @endif


                                                            </div>
                                                            <!--ph-->
                                                            <div style="flex:0 0 50px;text-align:center">
                                                                <input type="checkbox" class="work attendance_ph1"
                                                                    data-line="1" value="1"
                                                                    name="group[{{ $day }}][ph]">
                                                            </div>
                                                            <!--ph pay-->
                                                            <div style="flex:0 0 50px;text-align:center">
                                                                <input type="checkbox" class="work attendance_ph1"
                                                                    data-line="1" value="1"
                                                                    name="group[{{ $day }}][ph_pay]">
                                                            </div>
                                                            <!--remark-->
                                                            <div style="flex:0 0 150px;">
                                                                <textarea class="form-control hi-{{ $day }}" rows="1" name="group[{{ $day }}][remark]"
                                                                    style="display: none" placeholder="{{ $isLeave ? '' : 'Remarks' }}">{{ $isLeave ? $leaveRemarks : '' }}</textarea>

                                                                <textarea class="form-control s-{{ $day }}" rows="1" placeholder="Remarks"></textarea>
                                                            </div>
                                                            <div style="flex:0 0 120px;">
                                                                <select
                                                                    class="form-control change leave_type hi-{{ $day }}"
                                                                    data-line="1"
                                                                    name="group[{{ $day }}][type_of_leave]"
                                                                    style="width:100%; display: none;">
                                                                    <option value="">Select One</option>
                                                                    @foreach ($leaveTypes as $type)
                                                                        <option value="{{ $type->id }}"
                                                                            {{ $isLeave == false ? '' : ($type->id == $leaveType ? 'selected' : '') }}>
                                                                            {{ $type->leavetype_code }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <select
                                                                    class="form-control change leave_type s-{{ $day }}"
                                                                    data-line="1" style="width:100%;">
                                                                    <option value="">Select One</option>
                                                                    @foreach ($leaveTypes as $type)
                                                                        <option> {{ $type->leavetype_code }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <!--attendance leave day-->
                                                            <div style="flex:0 0 120px;">
                                                                <select
                                                                    class="form-control change leave_days hi-{{ $day }}"
                                                                    onchange="timeCalculation({{ $day }})"
                                                                    data-line="1"
                                                                    name="group[{{ $day }}][leave_day]"
                                                                    style="width:100%; display: none">
                                                                    <option value="0">Select One</option>
                                                                    <option value="Full Day Leave"
                                                                        {{ $isLeave == true ? ($leaveDuration == 'Full Day Leave' ? 'selected' : '') : '' }}>
                                                                        Full Day Leave</option>
                                                                    <option value="Half Day AM"
                                                                        {{ $isLeave == true ? ($leaveDuration == 'Half Day AM' ? 'selected' : '') : '' }}>
                                                                        Half Day AM</option>
                                                                    <option value="Half Day PM"
                                                                        {{ $isLeave == true ? ($leaveDuration == 'Half Day PM' ? 'selected' : '') : '' }}>
                                                                        Half Day PM</option>
                                                                </select>
                                                                <select
                                                                    class="form-control change leave_days s-{{ $day }}"
                                                                    data-line="1" style="width:100%"
                                                                    onchange="timeCalculation({{ $day }})">
                                                                    <option value="0">Select One</option>
                                                                    <option value="Full Day Leave">
                                                                        Full Day Leave</option>
                                                                    <option value="Half Day AM">
                                                                        Half Day AM</option>
                                                                    <option value="Half Day PM">
                                                                        Half Day PM</option>
                                                                </select>

                                                            </div>
                                                            <!--attendance leave file-->
                                                            <div style="flex:0 0 235px;">
                                                                <input type="file"
                                                                    class="attendance_leave_file-{{ $day }}"
                                                                    name="group[{{ $day }}][leave_attachment]"
                                                                    multiple=""
                                                                    onchange="hasFile({{ $day }})">
                                                                <label
                                                                    class="remove-label remove-label-{{ $day }}"
                                                                    onclick="removeFile('{{ $day }}')"><i
                                                                        class="fas fa-trash text-danger"></i></label>
                                                                <div class="hi-{{ $day }}"
                                                                    style="display: none">
                                                                    @if ($isLeave == true)
                                                                        <a href="{{ asset('storage/' . $leaveFilePath) }}"
                                                                            target="_blank">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!--attendance claim file-->
                                                            <div style="flex:0 0 235px;">
                                                                <input type="file"
                                                                    class="attendance_claim_file-{{ $day }}"
                                                                    name="group[{{ $day }}][claim_attachment]"
                                                                    multiple=""
                                                                    onchange="hasClaim({{ $day }})">
                                                                <label
                                                                    class="remove-claim remove-claim-{{ $day }}"
                                                                    onclick="removeClaim('{{ $day }}')"><i
                                                                        class="fas fa-trash text-danger"></i></label>
                                                            </div>
                                                            <!--reimbursement-->
                                                            <div style="flex:0 0 200px;">
                                                                <select
                                                                    class="form-control change attendance_reimbursement select2 select2-hidden-accessible"
                                                                    data-line="1" multiple=""
                                                                    name="group[{{ $day }}][type_of_reimbursement]"
                                                                    style="width:100%" tabindex="-1" aria-hidden="true">
                                                                    <!--<select class="form-control change attendance_reimbursement select2 select2-hidden-accessible" data-line="1" id="attendance_reimbursement1" name="attendance_reimbursement1[]" style = 'width:100%'>-->
                                                                    <option value="1">Transport Reimbursement</option>
                                                                    <option value="2">Medical Reimbursement</option>
                                                                    <option value="4">Meal Reimbursement</option>
                                                                    <option value="3">Other</option>
                                                                </select><span
                                                                    class="select2 select2-container select2-container--default"
                                                                    dir="ltr" style="width: 100%;"><span
                                                                        class="selection"><span
                                                                            class="select2-selection select2-selection--multiple"
                                                                            role="combobox" aria-autocomplete="list"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            tabindex="0">
                                                                            <ul class="select2-selection__rendered">
                                                                                <li
                                                                                    class="select2-search select2-search--inline">
                                                                                    <input class="select2-search__field"
                                                                                        type="search" tabindex="-1"
                                                                                        autocomplete="off"
                                                                                        autocorrect="off"
                                                                                        autocapitalize="off"
                                                                                        spellcheck="false" role="textbox"
                                                                                        placeholder=""
                                                                                        style="width: 0.75em;">
                                                                                </li>
                                                                            </ul>
                                                                        </span></span><span class="dropdown-wrapper"
                                                                        aria-hidden="true"></span></span>
                                                            </div>
                                                            <!--reimbursement amount-->
                                                            <div style="flex:0 0 150px;">
                                                                <input type="text" style="text-align:center"
                                                                    class="form-control" value="0" data-week="1"
                                                                    name="group[{{ $day }}][amount_of_reimbursement]">
                                                            </div>
                                                        </div>

                                                        @if ($currentDay->format('l') == 'Saturday')
                                                            <hr>
                                                        @endif
                                                    @endfor
                                                @else
                                                    @php
                                                        $currentMonth = Carbon\Carbon::now();
                                                        $daysInMonth = $currentMonth->daysInMonth;
                                                    @endphp
                                                    @for ($day = 1; $day <= $daysInMonth; $day++)
                                                        @php
                                                            $currentDay = $currentMonth->copy()->day($day);
                                                        @endphp
                                                        <div style="display:flex">
                                                            <div
                                                                style="flex:0 0 120px;position: sticky;left: 0;z-index: 20;">
                                                                <input type="date" class="form-control" readonly=""
                                                                    placeholder="Date"
                                                                    value="{{ $currentDay->toDateString() }}">
                                                            </div>
                                                            <div
                                                                style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
                                                                <input type="text" class="form-control" readonly=""
                                                                    value="{{ $currentDay->format('l') }}"
                                                                    placeholder="Title">
                                                            </div>
                                                            <div
                                                                style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
                                                                <input type="time" class="form-control"
                                                                    placeholder="time">
                                                            </div>
                                                            <div
                                                                style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
                                                                <input type="time" class="form-control"
                                                                    placeholder="time">
                                                            </div>
                                                            <!--next-->
                                                            <div style="flex:0 0 50px;text-align:center">
                                                                <input type="checkbox" class="attendance_next_day1 change"
                                                                    data-line="1" name="attendance_next_day1">
                                                            </div>
                                                            <!--lunch-->
                                                            <div style="flex:0 0 120px;">
                                                                <select class="form-control change" data-line="1"
                                                                    id="attendance_lunch1" data-content=""
                                                                    style="width:100%">
                                                                    <option value="1">30 minutes</option>
                                                                    <option value="2">45 minutes</option>
                                                                    <option value="3">1 hour</option>
                                                                    <option value="4">No Lunch</option>
                                                                    <option value="5">1.5 hour</option>
                                                                    <option value="6">2 hour</option>
                                                                </select>
                                                            </div>
                                                            <!--total-->
                                                            <div style="flex:0 0 120px;">
                                                                <input type="text" style="text-align:center"
                                                                    class="form-control week_1" data-week="1"
                                                                    readonly="" id="attendance_total1"
                                                                    data-content="-1 h " value="--">
                                                            </div>
                                                            <!--normal-->
                                                            <div style="flex:0 0 120px;">
                                                                <input type="text" style="text-align:center"
                                                                    class="form-control" data-week="1">
                                                                <input type="hidden" id="attendance_normal_hidden1"
                                                                    value="">
                                                            </div>
                                                            <!--ot-->
                                                            <div style="flex:0 0 120px;">
                                                                <input type="text" name="ot[]"
                                                                    style="text-align:center" class="form-control"
                                                                    data-week="1">
                                                                <!--<input type="hidden" id="attendance_ot_hidden1" name="attendance_ot_hidden1" value="">-->


                                                                {{-- <input type="hidden" id="attendance_ot_rate1"
                                                                    name="attendance_ot_rate1" value="">
                                                                <input type="hidden" id="attendance_allowance_minimum1"
                                                                    name="attendance_allowance_minimum1" value="">
                                                                <input type="hidden" id="attendance_allowance_maximum1"
                                                                    name="attendance_allowance_maximum1" value="">
                                                                <input type="hidden" id="attendance_allowance1"
                                                                    name="attendance_allowance1" value=""> --}}
                                                            </div>
                                                            <!--ot hidden-->
                                                            <div style="flex:0 0 120px;">
                                                                <input type="text" style="text-align:center"
                                                                    class="form-control">
                                                            </div>
                                                            <!--edit-->
                                                            <div style="flex:0 0 80px;text-align:center">
                                                                <input type="checkbox" class="attendance_edit1">
                                                            </div>
                                                            <!--work-->
                                                            <div style="flex:0 0 100px;text-align:center">
                                                                <input type="checkbox" class="work attendance_work1"
                                                                    data-line="1">
                                                            </div>
                                                            <!--ph-->
                                                            <div style="flex:0 0 50px;text-align:center">
                                                                <input type="checkbox" class="work attendance_ph1"
                                                                    data-line="1">
                                                            </div>
                                                            <!--ph pay-->
                                                            <div style="flex:0 0 50px;text-align:center">
                                                                <input type="checkbox" class="work attendance_ph_pay1"
                                                                    data-line="1">
                                                            </div>
                                                            <!--remark-->
                                                            <div style="flex:0 0 150px;">
                                                                <textarea class="form-control" rows="1" placeholder="Remarks"></textarea>
                                                            </div>
                                                            <!--<div style="flex:0 0 120px;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <input type="text" class="form-control" id="attendance_date1" readonly name="attendance_date1" value = "01-Jan-2024" placeholder="Date" >
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div style="flex:0 0 120px;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <input type="text" class="form-control attendance_day1" id="attendance_day" readonly name="attendance_day1" value = "Monday" placeholder="Title">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>-->
                                                            <!--leave-->
                                                            <div style="flex:0 0 120px;">
                                                                <select class="form-control change leave_type"
                                                                    data-line="1" style="width:100%">
                                                                    <option value="" selected="SELECTED">Select One
                                                                    </option>
                                                                    <option value="1">Annual Leave</option>
                                                                    <option value="2">Medical Leave</option>
                                                                    <option value="3">Hospitalisation Leave</option>
                                                                    <option value="8">Off In Lieu</option>
                                                                    <option value="4">Childcare Leave</option>
                                                                    <option value="5">Maternity/Paternity Leave
                                                                    </option>
                                                                    <option value="11">Reservist</option>
                                                                    <option value="12">Compassionate Leave</option>
                                                                    <option value="7">Marriage Leave</option>
                                                                    <option value="9">Unpaid Annual Leave</option>
                                                                    <option value="14">Unpaid Medical Leave</option>
                                                                </select>
                                                            </div>
                                                            <!--attendance leave day-->
                                                            <div style="flex:0 0 120px;">
                                                                <select class="form-control change leave_days"
                                                                    data-line="1" style="width:100%">
                                                                    <option value="0">Select One</option>
                                                                    <option value="Full Day Leave">Full Day Leave</option>
                                                                    <option value="0.5 AM">Half Day AM</option>
                                                                    <option value="0.5 PM">Half Day PM</option>
                                                                </select>
                                                            </div>
                                                            <!--attendance leave file-->
                                                            <div style="flex:0 0 235px;">
                                                                <input type="file" multiple="">
                                                                <input type="hidden" id="attendance_leave_existing_file1"
                                                                    name="attendance_leave_existing_file1" value="">
                                                            </div>
                                                            <!--attendance claim file-->
                                                            <div style="flex:0 0 235px;">
                                                                <input type="file" style="width" multiple="">
                                                            </div>
                                                            <!--reimbursement-->
                                                            <div style="flex:0 0 200px;">
                                                                <select
                                                                    class="form-control change attendance_reimbursement select2 select2-hidden-accessible"
                                                                    data-line="1" multiple="" style="width:100%"
                                                                    tabindex="-1" aria-hidden="true">
                                                                    <!--<select class="form-control change attendance_reimbursement select2 select2-hidden-accessible" data-line="1" id="attendance_reimbursement1" name="attendance_reimbursement1[]" style = 'width:100%'>-->
                                                                    <option value="1">Transport Reimbursement</option>
                                                                    <option value="2">Medical Reimbursement</option>
                                                                    <option value="4">Meal Reimbursement</option>
                                                                    <option value="3">Other</option>
                                                                </select><span
                                                                    class="select2 select2-container select2-container--default"
                                                                    dir="ltr" style="width: 100%;"><span
                                                                        class="selection"><span
                                                                            class="select2-selection select2-selection--multiple"
                                                                            role="combobox" aria-autocomplete="list"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            tabindex="0">
                                                                            <ul class="select2-selection__rendered">
                                                                                <li
                                                                                    class="select2-search select2-search--inline">
                                                                                    <input class="select2-search__field"
                                                                                        type="search" tabindex="-1"
                                                                                        autocomplete="off"
                                                                                        autocorrect="off"
                                                                                        autocapitalize="off"
                                                                                        spellcheck="false" role="textbox"
                                                                                        placeholder=""
                                                                                        style="width: 0.75em;">
                                                                                </li>
                                                                            </ul>
                                                                        </span></span><span class="dropdown-wrapper"
                                                                        aria-hidden="true"></span></span>
                                                            </div>
                                                            <!--reimbursement amount-->
                                                            <div style="flex:0 0 150px;">
                                                                <input type="text" style="text-align:center"
                                                                    class="form-control" value="" data-week="1">
                                                            </div>
                                                        </div>
                                                    @endfor
                                                @endif

                                                {{-- <input type="hidden" name="attendance_total_day" value="31">
                                                <input type="hidden" name="date" value="2024-01-06">
                                                <input type="hidden" name="empl" value="">
                                                <input type="hidden" name="supervisor_name" class="supervisor_name"
                                                    value="">
                                                <input type="hidden" name="supervisor_email" class="supervisor_email"
                                                    value=""> --}}
                                                {{-- <input type="hidden" name="submit_type" class="submit_type"
                                                    value=""> --}}
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col-sm-9">
                                                    <div>
                                                        <a href="{{ route('clients.index') }}"
                                                            class="btn btn-sm btn-secondary w-md">Cancel</a>
                                                        <button type="submit"
                                                            class="btn btn-sm btn-info w-md">Submit</button>
                                                        <a href="#" class="btn btn-sm btn-primary w-md">Print TNC
                                                            SRC</a>
                                                        <a href="#" class="btn btn-sm btn-primary w-md">Print TNC
                                                            SHRC</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div>
        </div>
        </div>
    @endsection

    @section('scripts')
        <!-- choices js -->
        <script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
        <!-- init js -->
        <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('#candidateDropdown').change(function() {
                    var selectedCandidateId = $(this).val();
                    var selectedDate = $('#dateInput').val(); // Get the selected date from the dateInput
                    console.log(selectedCandidateId);
                    console.log(selectedDate);
                    // fetchData(selectedCandidateId, selectedDate);
                });

                // Event handler for dateInput change
                $('#dateInput').change(function() {
                    var selectedCandidateId = $('#candidateDropdown').val();
                    var selectedDate = $(this).val();
                    console.log(selectedDate);

                    // fetchData(selectedCandidateId, selectedDate);
                });

                function fetchData(selectedCandidateId, selectedDate) {
                    $.ajax({
                        type: 'GET',
                        url: '/ATS/get/candidate/company/' + selectedCandidateId + '/' + selectedDate,
                        // data: { date: selectedDate }
                        success: function(response) {
                            console.log(response);
                            updateCompanyDropdown(response);

                            submitForm();
                        },
                        error: function(error) {
                            $('#companyDropdown').empty();
                            $('#companyDropdown').append(
                                '<option value="" disabled selected>No Company Available</option>'
                            );
                            $('#candidateId').val('');
                        }
                    });
                }
                // Listen for changes in the candidate dropdown
                // $('#candidateDropdown').change(function() {
                //     var selectedCandidateId = $(this).val();
                //     $.ajax({
                //         type: 'GET',
                //         url: '/ATS/get/candidate/company/' + selectedCandidateId,
                //         success: function(response) {
                //             updateCompanyDropdown(response);

                //             submitForm();

                //         },
                //         error: function(error) {
                //             $('#companyDropdown').empty();
                //             $('#companyDropdown').append(
                //                 '<option value="" disabled selected>No Company Available</option>'
                //             );
                //             $('#candidateId').val('');
                //         }
                //     });
                // });

                function updateCompanyDropdown(response) {
                    $('#companyDropdown').empty();

                    if (response.company && response.candidateId) {
                        $('#companyDropdown').append('<option value="' + response.company.id + '">' + response.company
                            .name + '</option>');
                        $('#candidateId').val(response.candidateId);
                    } else {
                        $('#companyDropdown').append(
                            '<option value="" disabled selected>No Company Available</option>');
                    }
                }

                $(".invoice").on('keyup', function() {
                    var inp = $(this).val();
                    $("#invoice").val(inp);
                });

                function submitForm() {
                    $('#attendenceForm').submit();
                }

            });
        </script>
    @endsection
