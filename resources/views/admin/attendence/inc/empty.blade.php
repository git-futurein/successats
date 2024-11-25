
<div style="display:flex">
    <div style="flex:0 0 120px;position: sticky;left: 0;z-index: 20;">
        <input type="text" class="form-control " readonly placeholder="Date" readonly=""
            name="group[{{ $day }}][date]" placeholder="Date" value="">
    </div>
    <div style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
        <input type="text" class="form-control " readonly=""
            value="" placeholder="Title">
    </div>
    <div style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
        <input type="time" style=" "
            class="form-control"
            name="group[{{ $day }}][in_time]" placeholder="time">
    </div>
    <div style="flex:0 0 120px;position: sticky;left: 120px;z-index: 20;">
        <input type="time" style=" "
            class="form-control"
            name="group[{{ $day }}][out_time]"
            placeholder="time">
    </div>
    <!--next-->
    <div style="flex:0 0 50px;text-align:center">
        <input type="checkbox" class="attendance_next_day1 change" data-line="1" value="1"
            name="group[{{ $day }}][next_day]">
    </div>
    <!--lunch-->
    <div style="flex:0 0 120px;">
        <select class="form-control change`"
            data-line="1" id="attendance_lunch" data-content="" style="width:100%;  ">
            <option value="">Select One</option>
            <option value="30 minutes">30
                minutes</option>
            <option value="45 minutes">45
                minutes</option>
            <option value="1 hour">1 hour
            </option>
            <option value="No Lunch">No Lunch
            </option>
            <option value="1.5 hour">1.5 hour
            </option>
            <option value="2 hour">2 hour
            </option>
        </select>
    </div>
    <!--total-->
    <div style="flex:0 0 120px;">
        <input type="text" style="text-align:center;  "
            class="form-control week_1 {{ $day }} totla_time-{{ $day }}" data-week="1"
            readonly="" name="group[{{ $day }}][total_hour_min]" data-content="-1 h "
            value="0">
    </div>
    <!--normal-->
    <div style="flex:0 0 120px;">
        <input type="text" style="text-align:center;  "
            class="form-control {{ $day }} normal_time-{{ $day }}"
            name="group[{{ $day }}][normal_hour_min]" value="0">
    </div>
    <!--ot-->
    <div style="flex:0 0 120px;">
        <input type="text" style="text-align:center" name="group[{{ $day }}][ot_hour_min]"
            class="form-control" data-week="1" value="0">
    </div>
    <!--ot hidden-->
    <div style="flex:0 0 120px;">
        <input type="text" style="text-align:center" class="form-control"
            name="group[{{ $day }}][ot_calculation]" value="0">
    </div>
    <!--edit-->
    <div style="flex:0 0 80px;text-align:center">
        <input type="checkbox" class="attendance_edit1" data-line="1" value="1"
            name="group[{{ $day }}][ot_edit]">
    </div>
    <!--work-->
    <div style="flex:0 0 100px;text-align:center">
        <input type="checkbox" class="work attendance_work1" data-line="1" value="1"
            name="group[{{ $day }}][work]" onclick="work_check('')">
    </div>
    <!--ph-->
    <div style="flex:0 0 50px;text-align:center">
        <input type="checkbox" class="work attendance_ph1" data-line="1" value="1"
            name="group[{{ $day }}][ph]">
    </div>
    <!--ph pay-->
    <div style="flex:0 0 50px;text-align:center">
        <input type="checkbox" class="work attendance_ph_pay1" data-line="1" value="1"
            name="group[{{ $day }}][ph_pay]">
    </div>
    <!--remark-->
    <div style="flex:0 0 150px;">
        <textarea class="form-control {{ $day }}" rows="1" name="group[{{ $day }}][remark]"
            placeholder="Remarks"></textarea>
    </div>
    <div style="flex:0 0 120px;">
        <select class="form-control change leave_type {{ $day }}" data-line="1"
                style="width:100%;  ;">
            <option value="">Select One</option>
            
        </select>
    </div>
    <!--attendance leave day-->
    <div style="flex:0 0 120px;">
        <select class="form-control change leave_days {{ $day }}" data-line="1"
            name="group[{{ $day }}][leave_day]" style="width:100%;  ">
            <option value="0">Select One</option>
            <option value="Full Day Leave"
                >
                Full Day Leave</option>
            <option value="Half Day AM">
                Half Day AM</option>
            <option value="Half Day PM">
                Half Day PM</option>
        </select>
    </div>
    <!--attendance leave file-->
    <div style="flex:0 0 235px;">
        <input type="file" class="attendance_leave_file-{{ $day }}"
            name="group[{{ $day }}][leave_attachment]">
        <label class="remove-label remove-label-"><i
                class="fas fa-trash text-danger"></i></label>
        <div class="{{ $day }}">

        </div>
    </div>
    <div style="flex:0 0 235px;">
        <input type="file" class="attendance_claim_file-{{ $day }}"
            name="group[{{ $day }}][claim_attachment]">
        <label class="remove-label remove-label-"><i
                class="fas fa-trash text-danger"></i></label>
        <div class="{{ $day }}">

        </div>
    </div>
    <!--reimbursement-->
    <div style="flex:0 0 200px;">
        <select class="form-control change attendance_reimbursement select2 select2-hidden-accessible"
            data-line="1" multiple=""
            style="width:100%" tabindex="-1" aria-hidden="true">

            <option value="1">Transport Reimbursement</option>
            <option value="2">Medical Reimbursement</option>
            <option value="4">Meal Reimbursement</option>
            <option value="3">Other</option>
        </select><span class="select2 select2-container select2-container--default" dir="ltr"
            style="width: 100%;"><span class="selection"><span
                    class="select2-selection select2-selection--multiple" role="combobox"
                    aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0">
                    <ul class="select2-selection__rendered">
                        <li class="select2-search select2-search--inline">
                            <input class="select2-search__field" type="search" tabindex="-1"
                                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                                role="textbox" placeholder="" style="width: 0.75em;">
                        </li>
                    </ul>
                </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
    </div>
    <!--reimbursement amount-->
    <div style="flex:0 0 150px;">
        <input type="text" style="text-align:center" class="form-control" value="" data-week="1">
    </div>
</div>
