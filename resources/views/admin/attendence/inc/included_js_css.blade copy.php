
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    function allWork(days) {
        var checkbox = document.getElementById('allCheckB');
        var emptyDiv = document.getElementById('empty');
        var haveDataDiv = document.getElementById('haveData');

        if (checkbox.checked) {
            emptyDiv.style.display = 'none';
            haveDataDiv.style.display = 'block';
        } else {
            emptyDiv.style.display = 'block';
            haveDataDiv.style.display = 'none';
        }

        for (let day = 1; day <= days; day++) {
            let worked = $('#workCheB-' + day).val();
            console.log(worked);
            if ($('#allCheckB').is(':checked')) {
                $('.bg-' + day).addClass('bg-f1f1f1');
                $('.totla_time-' + day).val('');
                $('.normal_time-' + day).val('');
                if(worked == 1){
                    $('#workCheB-' + day).prop('checked', true).addClass('checked');
                } else if(worked == 0) {
                    $('#workCheB-' + day).prop('checked', false).removeClass('checked');
                }
            } else if ($('#allCheckB').is(':not(:checked)')) {
                $('.bg-' + day).removeClass('bg-f1f1f1');
                if(worked == 1){
                    $('#workCheB-' + day).prop('checked', true).addClass('checked');
                } else if(worked == 0) {
                    $('#workCheB-' + day).prop('checked', false).removeClass('checked');
                }
            }

            timeCalculation(day);
        }
    }

    function work_check(day) {
        if ($('#workCheB-' + day).is(':checked')) {
            $('.bg-' + day).addClass('bg-f1f1f1');
            $('#workCheB-' + day).prop('checked', true).addClass('checked');
        } else if ($('#workCheB-' + day).is(':not(:checked)')) {
            $('.bg-' + day).removeClass('bg-f1f1f1');
            $('#workCheB-' + day).prop('checked', false).removeClass('checked');
            $('.inTime-' + day).val('');
            $('.outTime-' + day).val('');
        }
        timeCalculation(day);
    }

    function removeFile(day) {
        $('.attendance_leave_file-' + day).val('');
        $('.remove-label-' + day).hide();
    }

    function hasFile(day) {
        $('.remove-label-' + day).show();
    }

    function removeClaim(day) {
        $('.attendance_claim_file-' + day).val('');
        $('.remove-claim-' + day).hide();
    }

    function hasClaim(day) {
        $('.remove-claim-' + day).show();
    }

    function next_day(day)
    {

    }

    function timeCalculation(day) {
        let lunch_val = tream($('.lunch_val-' + day).val());
        let inTime = $('.inTime-' + day).val();
        let outTime = $('.outTime-' + day).val();
        let ot = parseTimeString($('.ot-' + day).val());
        const timeDifference = calculateTimeDifference(inTime, outTime, day, lunch_val);

        const after_leave = leaveDay(day, timeDifference);
        // const sumTimeDifference = sumTimeDifferences([after_leave, ot]);
        // console.log(sumTimeDifference);
        const total_time = sumTimeDifference.hours + ' h ' + sumTimeDifference.minutes + ' m';

        let result = subtractTimeDifference(sumTimeDifference, lunch_val);
        console.log(result);
        if(result.hours < 0)  { result.hours = 0; }
        if(result.minutes < 0)  {  result.minutes = 0; }

        const normal_time = result.hours + ' h ' + result.minutes + ' m';

        $('.totla_time-' + day).val(normal_time);
    }

    function leaveDay(day, hour_min) {
        let hours = 0;
        let minutes = 0;
        let will_pay = 1;
        let inTime = $('#oldinTime-' + day).val();
        let outTime = $('#oldoutTime-' + day).val();

        let leave_day = $('.change.leave_days.hi-' + day).val();
        if (leave_day == 'Full Day Leave') {
            will_pay = 0;
            $('.inTime-' + day).val('');
            $('.outTime-' + day).val('');
            $('.lunch_val-' + day).val('');
            $('.totla_time-' + day).val(0);
            $('#workCheB-' + day).prop('checked', false);
        } else if (leave_day == 'Half Day AM' || leave_day == 'Half Day PM') {
            if (leave_day === 'Half Day AM') {
                let inTimex = calculateHalfTime(inTime, outTime, 'AM');
                $('.inTime-' + day).val(inTimex);
                $('.outTime-' + day).val(outTime);
            } else if (leave_day === 'Half Day PM') {
                let outTimex = calculateHalfTime(inTime, outTime, 'PM');
                $('.inTime-' + day).val(inTime);
                $('.outTime-' + day).val(outTimex);
            }
            will_pay = 0.5;
        }

        const total_min = (hour_min.hours * 60 + hour_min.minutes) * will_pay;
        hours = Math.floor(total_min / 60);
        minutes = total_min % 60;

        return {
            hours,
            minutes
        };
    }
    function calculateHalfTime(startTime, endTime, halfType) {
        let halfHour = halfType === 'AM' ? 12 : 24; // Determine the half hour

        // Split start and end times
        let [startHour, startMinute] = startTime.split(':').map(Number);
        let [endHour, endMinute] = endTime.split(':').map(Number);

        // Calculate the total minutes for the start and end times
        let totalStartMinutes = startHour * 60 + startMinute;
        let totalEndMinutes = endHour * 60 + endMinute;

        // Calculate the halfway point in minutes
        let halfwayMinutes = (totalStartMinutes + totalEndMinutes) / 2;

        // Adjust the hour and minute for the halfway point
        let halfwayHour = Math.floor(halfwayMinutes / 60) % 24;
        let halfwayMinute = halfwayMinutes % 60;

        // Format the halfway time
        return `${halfwayHour}:${halfwayMinute < 10 ? '0' : ''}${halfwayMinute}`;
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

    function calculateTimeDifference(inTime, outTime, day = 0, lunch_val) {
        let hours = 0;
        let minutes = 0;
        let overtime = 0;

        if (!inTime || !outTime) {
            return { hours, minutes };
        }

        let inMoment = moment(inTime, 'HH:mm');
        let outMoment = moment(outTime, 'HH:mm');

        let minutesDifference = outMoment.diff(inMoment, 'minutes');

        let oldIn = $('#oldinTime-' + day).val();
        let oldOut = $('#oldoutTime-' + day).val();

        if (!oldIn || !oldOut) {
            return { hours, minutes };
        }

        let oldinMoment = moment(oldIn, 'HH:mm');
        let oldoutMoment = moment(oldOut, 'HH:mm');

        const oldMinutesDifference = oldoutMoment.diff(oldinMoment, 'minutes');
        normal_time(oldMinutesDifference, day, lunch_val);

        if (minutesDifference > oldMinutesDifference) {
            overtime = minutesDifference - oldMinutesDifference;
            // minutesDifference = oldMinutesDifference;
        }

        ot_calculation(overtime, day);

        hours = Math.floor(minutesDifference / 60);
        minutes = minutesDifference % 60;
        return {
            hours,
            minutes
        };
    }

    function normal_time(oldMinutesDifference, day, lunch_val)
    {
        let hours = 0;
        let minutes = 0;
        let normal_time = hours + ' h ' + minutes + ' m';

        if(oldMinutesDifference)
        {
            hours = Math.floor(oldMinutesDifference / 60);
            minutes = oldMinutesDifference % 60;

            let result = subtractTimeDifference({hours, minutes}, lunch_val);
            normal_time = result.hours + ' h ' + result.minutes + ' m';
        }

        $('.normal_time-' + day).val(normal_time);
    }

    function ot_calculation(minutesD, day)
    {
        let hours = 0;
        let minutes = 0;

        hours = Math.floor(minutesD / 60);
        minutes = minutesD % 60;

        let over = (hours + 'h '+ minutes + 'm');
        $('.ot-' + day).val(over);
    }

    function subtractTimeDifference(minuend, subtrahend)
    {
        let totalHours = minuend.hours - subtrahend.hours;
        let totalMinutes = minuend.minutes - subtrahend.minutes;

        if (totalHours <= 0) {
            totalHours = 0;
        }
        if (totalMinutes < 0) {
            totalHours--;
            totalMinutes += 60;
        }
        return {
            hours: totalHours,
            minutes: totalMinutes
        };
    }

    // function sumTimeDifferences(timeDifferences)
    // {
    //     console.log(timeDifferences);
    //     let totalHours = 0;
    //     let totalMinutes = 0;

    //     for (const timeDiff of timeDifferences) {
    //         totalHours += timeDiff.hours;
    //         totalMinutes += timeDiff.minutes;
    //     }

    //     // Adjust total minutes if it exceeds 60
    //     totalHours += Math.floor(totalMinutes / 60);
    //     totalMinutes %= 60;

    //     return {
    //         hours: totalHours,
    //         minutes: totalMinutes
    //     };
    // }

    function ot_edit(day)
    {
        let ot_edit = $('#ot_edit-' + day); // Retrieve the checkbox element
        if (ot_edit.prop('checked')) { // Check if the checkbox is checked
            $('.ot-' + day).prop('readonly', true);
            $('.otc-' + day).prop('readonly', true);
        } else { // If the checkbox is not checked
            $('.ot-' + day).prop('readonly', false);
            $('.otc-' + day).prop('readonly', false);
        }
    }

</script>
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
