
<style>
    .bg-f1f1f1
    {
        background-color: #f1f1f1;
    }
</style>
@isset($attendances)
    @foreach ($attendances as $day => $attendance)
        <div style="display:flex">
            <div style="flex:0 0 120px;position: sticky;left: 0;z-index: 20;">
                <input type="text" class="form-control {{$attendance->work == 1 ? 'bg-f1f1f1' : ''}}" readonly name="group[{{ $day }}][date]" value="{{ Carbon\Carbon::parse($attendance['date'])->format('d-M-Y') }}">
            </div>
            <div style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
                <input type="text" class="form-control {{$attendance->work == 1 ? 'bg-f1f1f1' : ''}}" readonly name="group[{{ $day }}][day]" value="{{ $attendance['day'] }}">
            </div>
            <div style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
                <input type="time" hidden id="oldinTime-{{$day}}" value="{{ $attendance['in_time'] }}">
                <input type="time" class="form-control inTime-{{ $day }}"
                    name="group[{{ $day }}][in_time]" value="{{ $attendance['in_time'] }}" onchange="timeCalculation({{ $day }})">
            </div>
            <div style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
                <input type="time" hidden id="oldoutTime-{{$day}}" value="{{ $attendance['out_time'] }}">
                <input type="time" class="form-control  outTime-{{ $day }}"
                    name="group[{{ $day }}][out_time]" value="{{ $attendance['out_time'] }}" onchange="timeCalculation({{ $day }})">
            </div>
            <!--next-->
            <div style="flex:0 0 50px;text-align:center">
                <input type="checkbox" class="attendance_next_day1 change" onclick="next_day({{$day}})" data-line="1" value="1" name="group[{{ $day }}][next_day]">
            </div>
            <!--lunch-->
            <div style="flex:0 0 120px;">
                <select class="form-control single-select-field change lunch_val-{{ $day }}"
                    data-line="1" onchange="timeCalculation({{ $day }})"
                    name="group[{{ $day }}][lunch_hour]" data-content="" style="width:100%;  ">
                    <option value="">Select One</option>
                    <option value="30 minutes">30 minutes</option>
                    <option value="45 minutes">45 minutes</option>
                    <option value="1 hour">1 hour</option>
                    <option value="No Lunch">No Lunch</option>
                    <option value="1.5 hour">1.5 hour</option>
                    <option value="2 hour">2 hour</option>
                </select>
            </div>
            <!--total-->
            <div style="flex:0 0 120px;">
                <input type="text" style="text-align:center;  "
                    class="form-control week_1 totla_time-{{ $day }}" data-week="1"
                    readonly name="group[{{ $day }}][total_hour_min]"
                    value="{{ $attendance['total_hour_min']}}">
            </div>
            <!--normal-->
            <div style="flex:0 0 120px;">
                <input type="text" style="text-align:center;"
                    class="form-control normal_time-{{ $day }}"
                    name="group[{{ $day }}][normal_hour_min]" value="{{ $attendance['normal_hour_min']}}">
            </div>
            <!--ot-->
            <div style="flex:0 0 120px;">
                <input type="text" style="text-align:center" name="group[{{ $day }}][ot_hour_min]"
                    class="form-control ot-{{ $day }}" data-week="1" value="{{ $attendance['ot_hour_min']}}">
            </div>
            <!--ot hidden-->
            <div style="flex:0 0 120px;">
                <input type="text" style="text-align:center" class="form-control otc-{{$day}}"
                    name="group[{{ $day }}][ot_calculation]" value="{{ $attendance['ot_calculation']}}">
            </div>
            <!--edit-->
            <div style="flex:0 0 80px;text-align:center">
                <input type="checkbox" class="attendance_edit1" id="ot_edit-{{$day}}" data-line="1" value="{{$attendance['ot_edit'] }}" name="group[{{ $day }}][ot_edit]" onclick="ot_edit({{ $day }})">
            </div>
            <!--work-->
            <div style="flex:0 0 100px;text-align:center">
                <input type="checkbox" class="work attendance_work1" id="workCheB-{{$day}}" data-line="1" value="{{$attendance['work']}}" name="group[{{ $day }}][work]" onclick="work_check({{ $day }})" >
            </div>
            <!--ph-->
            <div style="flex:0 0 50px;text-align:center">
                <input type="checkbox" class="work attendance_ph1 ph-{{$day}}" data-line="1"
                    name="group[{{ $day }}][ph]" value="{{$attendance['ph'] }}">
            </div>
            <!--ph pay-->
            <div style="flex:0 0 50px;text-align:center">
                <input type="checkbox" class="work attendance_ph_pay1 ph_pay-{{$day}}" data-line="1" value="{{$attendance['ph_pay'] }}"
                    name="group[{{ $day }}][ph_pay]">
            </div>
            <!--remark-->
            <div style="flex:0 0 150px;">
                <textarea class="form-control remark-{{$day}}" rows="1" name="group[{{ $day }}][remark]" >{{ $attendance['remark'] }}</textarea>
            </div>
            <div style="flex:0 0 220px;">
                <select class="form-control single-select-field change leave_type  type_of_leave-{{$day}}" data-line="1"
                    name="group[{{ $day }}][type_of_leave]" style="width:100%;  ;">
                    <option value="" selected disabled>Select One</option>
                    @foreach ($leaveTypes as $type)
                        <option style="width: 120px" value="{{ $type->id }}" {{ $type->id == $attendance['type_of_leave'] ? 'selected' : '' }}>{{ $type->leavetype_code }}</option>
                    @endforeach
                </select>
            </div>
            <!--attendance leave day-->
            <div style="flex:0 0 220px;">
                <select class="form-control single-select-field change leave_days-{{$day}}"
                    onchange="leaveDay({{ $day }})" data-line="1"
                    name="group[{{ $day }}][leave_day]" style="width:100%;  ">
                    <option value="" selected disabled>Select One</option>
                    <option value="Full Day Leave" {{ $attendance['leave_day'] == 'Full Day Leave' ? 'selected' : '' }}>Full Day Leave</option>
                    <option value="Half Day AM"{{ $attendance['leave_day'] == 'Half Day AM' ? 'selected' : '' }}> Half Day AM</option>
                    <option value="Half Day PM"{{ $attendance['leave_day'] == 'Half Day PM' ? 'selected' : '' }}> Half Day PM</option>
                </select>
            </div>
            <!--attendance leave file-->
            <div style="flex:0 0 280px;" class="d-flex">
                <div class="flex-grow-1" style="width: 200px;">
                    <input type="hidden" name="group[{{ $day }}][old_leave_attachment]" value="{{$attendance['leave_attachment']}}">
                    <input type="file" class="attendance_leave_file-{{ $day }}" name="group[{{ $day }}][leave_attachment]" value="{{ $attendance['leave_attachment'] }}" onchange="hasFile({{ $day }})">
                    <label class="remove-label remove-label-{{$day}}" onclick="removeFile('{{ $day }}')"><i
                            class="fas fa-trash text-danger"></i></label>
                </div>
                <div class="leave_attachment-{{ $day }} pe-3">
                    @if ($attendance['leave_attachment'])
                        <a href="{{ asset('storage/' . $attendance['leave_attachment']) }}" target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>
                    @endif
                </div>
            </div>
            <div style="flex:0 0 280px;" class="d-flex">
                <div class="flex-grow-1" style="width: 200px;">
                    <input type="hidden" name="group[{{ $day }}][old_claim_attachment]" value="{{$attendance['claim_attachment']}}">
                    <input type="file" class="attendance_claim_file-{{ $day }}"
                        name="group[{{ $day }}][claim_attachment]" onchange="hasClaim({{ $day }})">
                    <label class="remove-label remove-claim-{{$day}}" onclick="removeClaim('{{ $day }}')"><i
                            class="fas fa-trash text-danger"></i></label>
                </div>
                <div class="claim_attachment-{{ $day }} pe-3">
                    @if ($attendance['claim_attachment'])
                        <a href="{{ asset('storage/' . $attendance['claim_attachment']) }}" target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>
                    @endif
                </div>
            </div>
            <!--reimbursement-->
            <div style="flex:0 0 280px;">
                <select class="form-control single-select-field change attendance_reimbursement"
                    data-line="1" name="group[{{ $day }}][type_of_reimbursement]"
                    style="width:100%" tabindex="-1" aria-hidden="true">
                    <option value="">Choose One</option>
                    <option value="1">Transport Reimbursement</option>
                    <option value="2">Medical Reimbursement</option>
                    <option value="4">Meal Reimbursement</option>
                    <option value="3">Other</option>
                </select>
            </div>
            <!--reimbursement amount-->
            <div style="flex:0 0 150px;">
                <input type="text" style="text-align:center" class="form-control" value="{{$attendance->amount_of_reimbursement}}" data-week="1"
                    name="group[{{ $day }}][amount_of_reimbursement]">
            </div>
        </div>
    @endforeach
@endisset
