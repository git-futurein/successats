<div class="form-group">
    <div class="row mt-3">
        <label for="time_sheet_day"
            class="col-sm-1 control-label">{{ $day }}</label>
        <div class="col-sm-3">
            <input type="time" class="form-control"
                name="{{ strtolower($day) }}_in" placeholder="Time In"
                disabled>
        </div>
        <div class="col-sm-3">
            <input type="time" class="form-control"
                name="{{ strtolower($day) }}_out"
                placeholder="Time Out" disabled>
        </div>
        <div class="col-sm-2">
            <select class="form-control"
                name="{{ strtolower($day) }}_lunch" disabled>
                <option value="30 minutes">30 minutes</option>
                <option value="45 minutes">45 minutes</option>
                <option value="1 hour">1 hour</option>
                <option value="1.5 hour">1.5 hour</option>
                <option value="2 hour">2 hour</option>
                <option value="No Lunch">No Lunch</option>
            </select>
        </div>
        <div class="col-sm-1">
            <label>
                <input type="checkbox"
                    name="{{ strtolower($day) }}_isWork" disabled>
            </label>
        </div>
    </div>

</div>
