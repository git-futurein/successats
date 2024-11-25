<option value="30 minutes"
    {{ $isLeave == true ? '' : ($isWorkDay ? ($lunchTime == '30 minutes' ? 'selected' : '') : '') }}>
    30 minutes</option>
<option value="45 minutes"
    {{ $isLeave == true ? '' : ($isWorkDay ? ($lunchTime == '45 minutes' ? 'selected' : '') : '') }}>
    45 minutes</option>
<option value="1 hour"
    {{ $isLeave == true ? '' : ($isWorkDay ? ($lunchTime == '1 hour' ? 'selected' : '') : '') }}>
    1 hour</option>
<option value="No Lunch"
    {{ $isLeave == true ? '' : ($isWorkDay ? ($lunchTime == 'No Lunch' ? 'selected' : '') : '') }}>
    No Lunch</option>
<option value="1.5 hour"
    {{ $isLeave == true ? '' : ($isWorkDay ? ($lunchTime == '1.5 hour' ? 'selected' : '') : '') }}>
    1.5 hour</option>
<option value="2 hour"
    {{ $isLeave == true ? '' : ($isWorkDay ? ($lunchTime == '2 hour' ? 'selected' : '') : '') }}>
    2 hour</option>
