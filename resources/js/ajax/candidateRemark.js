$(document).ready(function () {
    $('#remark_type_test').change(function () {

        alert('sdg')
        var selectedValue = $(this).val();
        // AssignToManager Start
        if (selectedValue === '1') {
            $('#AssignToManager').show().css('display', 'show');
        } else {
            $('#AssignToManager').hide().css('display', 'none');
        }

        if (selectedValue === '12') {
            $('#AssignToManager').css('display', 'show');
        } else {
            $('#AssignToManager').css('display', 'none');
        }

        // AssignToManager end
        // AssignToTeamLeader Start
        if (selectedValue === '2') {
            $('#AssignToTeamLeader').show().css('display', 'show');
        } else {
            $('#AssignToTeamLeader').hide().css('display', 'none');
        }
        //AssignToTeamLeader end
        // AssignToRC Start
        if (selectedValue === '3') {
            $('#AssignToRC').show().css('display', 'show');
        } else {
            $('#AssignToRC').hide().css('display', 'none');
        }
        //AssignToRC end
        //AssignInterview start
        if (selectedValue === '5') {
            $('#interviewTime').show().css('display', 'show');
            $('#interviewCompany').show().css('display', 'show');
            $('#expectedSalary').show().css('display', 'show');
            $('#interviewPosition').show().css('display', 'show');
            $('#receivedJobOffer').show().css('display', 'show');
            $('#emailNoticeDate').show().css('display', 'show');
            $('#interviewDate').show().css('display', 'show');
            $('#interviewBy').show().css('display', 'show');
            $('#jobOfferSalary').show().css('display', 'show');
            $('#attendInterview').show().css('display', 'show');
            $('#availableDate').show().css('display', 'show');
            $('#interviewEmailNoticeDate').show().css('display', 'show');
        } else {
            $('#interviewTime').hide().css('display', 'none');
            $('#interviewCompany').hide().css('display', 'none');
            $('#expectedSalary').hide().css('display', 'none');
            $('#interviewPosition').hide().css('display', 'none');
            $('#receivedJobOffer').hide().css('display', 'none');
            $('#emailNoticeDate').hide().css('display', 'none');
            $('#interviewDate').hide().css('display', 'none');
            $('#interviewBy').hide().css('display', 'none');
            $('#jobOfferSalary').hide().css('display', 'none');
            $('#attendInterview').hide().css('display', 'none');
            $('#availableDate').hide().css('display', 'none');
            $('#interviewEmailNoticeDate').hide().css('display', 'none');
        }
        //AssignInterview end

        // AssignToRC Start
        if (selectedValue === '6') {
            $('#AssignToClient').show().css('display', 'show');
            $('#clientArNo').show().css('display', 'show');
        } else {
            $('#AssignToClient').hide().css('display', 'none');
            $('#clientArNo').hide().css('display', 'none');
        }
        //AssignToRC end
        // AssignToClient Start

        if (selectedValue === '7') {
            $('#shortlistClientCompany').show().css('display', 'show');
            $('#shortlistDepartment').show().css('display', 'show');
            $('#shortlistPlacement').show().css('display', 'show');
            $('#shortlistJobTitle').show().css('display', 'show');
            $('#shortlistJobType').show().css('display', 'show');
            $('#shortlistProbationPeriod').show().css('display', 'show');
            $('#shortlistContractSigningDate').show().css('display', 'show');
            $('#shortlistEmailNoticeDate').show().css('display', 'show');
            $('#shortlistSalary').show().css('display', 'show');
            $('#shortlistArNo').show().css('display', 'show');
            $('#shortlistHourlyRate').show().css('display', 'show');
            $('#shortlistAdminFee').show().css('display', 'show');
            $('#shortlistStartDate').show().css('display', 'show');
            $('#shortlistReminderPeriod').show().css('display', 'show');
            $('#shortlistContractSigningTime').show().css('display', 'show');
            $('#shortlistLastDay').show().css('display', 'show');
            $('#shortlistEmailNoticeTime').show().css('display', 'show');
            $('#shortlistCoEndDate').show().css('display', 'show');
        } else {
            $('#shortlistClientCompany').hide().css('display', 'none');
            $('#shortlistDepartment').hide().css('display', 'none');
            $('#shortlistPlacement').hide().css('display', 'none');
            $('#shortlistJobTitle').show().css('display', 'none');
            $('#shortlistJobType').hide().css('display', 'none');
            $('#shortlistProbationPeriod').hide().css('display', 'none');
            $('#shortlistContractSigningDate').hide().css('display', 'none');
            $('#shortlistEmailNoticeDate').hide().css('display', 'none');
            $('#shortlistSalary').hide().css('display', 'none');
            $('#shortlistArNo').hide().css('display', 'none');
            $('#shortlistHourlyRate').hide().css('display', 'none');
            $('#shortlistAdminFee').hide().css('display', 'none');
            $('#shortlistStartDate').hide().css('display', 'none');
            $('#testone').hide().css('display', 'none');
            $('#shortlistReminderPeriod').hide().css('display', 'none');
            $('#shortlistContractSigningTime').hide().css('display', 'none');
            $('#shortlistLastDay').hide().css('display', 'none');
            $('#shortlistEmailNoticeTime').hide().css('display', 'none');
            $('#shortlistCoEndDate').hide().css('display', 'none');
        }
        //AssignToClient end

    });
    // $('#remark_type').trigger('change');
});
