$(document).ready(function () {
    $('#jobTypes').change(function () {
        var selectedValue = $(this).val();
        // AssignToManager Start
        if (selectedValue === '1') {
            $('#adminFeeMonthly').show().css('display', 'none');
            $('#dailyRate').show().css('display', 'none');
            $('#department').show().css('display', 'none');
            $('#wica').show().css('display', 'none');
            $('#university').show().css('display', 'none');
            $('#costCenter').show().css('display', 'none');
            $('#salesPeriod').show().css('display', 'none');
            $('#charge').show().css('display', 'none');
            $('#recruitmentFee').show().css('display', 'none');
            $('#adminFeeDaily').show().css('display', 'none');
            $('#salary').show().css('display', 'none');
            $('#dailyRateNightShift').show().css('display', 'none');
            $('#programme').show().css('display', 'none');
            $('#insuranceFee').show().css('display', 'none');
            $('#guaranteePeriod').show().css('display', 'none');
        }

        else if (selectedValue == '2') {
            $('#invoiceRate').show().css('display', 'none');
            $('#university').show().css('display', 'none');
            $('#workingHour').show().css('display', 'none');
            $('#salesPeriod').show().css('display', 'none');
            $('#invoiceNo').show().css('display', 'none');
            $('#charge').show().css('display', 'none');
            $('#cutOff').show().css('display', 'none');
            $('#salary').show().css('display', 'none');
            $('#guaranteePeriod').show().css('display', 'none');

            $('#adminFeeMonthly').show().css('display', 'default');
            $('#dailyRate').show().css('display', 'default');
            $('#department').show().css('display', 'default');
            $('#wica').show().css('display', 'default');
            $('#costCenter').show().css('display', 'default');
            $('#recruitmentFee').show().css('display', 'default');
            $('#adminFeeDaily').show().css('display', 'default');
            $('#dailyRateNightShift').show().css('display', 'default');
            $('#programme').show().css('display', 'default');
            $('#insuranceFee').show().css('display', 'default');


        }
        else if(selectedValue == '3') {
            $('#adminFeeMonthly').show().css('display', 'none');
            $('#invoiceRate').show().css('display', 'none');
            $('#dailyRate').show().css('display', 'none');
            $('#department').show().css('display', 'none');
            $('#wica').show().css('display', 'none');
            $('#university').show().css('display', 'none');
            $('#costCenter').show().css('display', 'none');
            $('#workingHour').show().css('display', 'none');
            $('#cutOff').show().css('display', 'none');
            $('#adminFeeDaily').show().css('display', 'none');
            $('#dailyRateNightShift').show().css('display', 'none');
            $('#programme').show().css('display', 'none');
            $('#hourlyRate').show().css('display', 'none');
            $('#insuranceFee').show().css('display', 'none');
            $('#teamLead').show().css('display', 'none');
            $('#endDate').show().css('display', 'none');
            $('#poNo').show().css('display', 'none');
            $('#payrollRemark').show().css('display', 'none');

            $('#salesPeriod').show().css('display', 'default');
            $('#invoiceNo').show().css('display', 'default');
            $('#charge').show().css('display', 'default');
            $('#salary').show().css('display', 'default');
            $('#guaranteePeriod').show().css('display', 'default');
        }
        else if(selectedValue == '4') {
            $('#invoiceRate').show().css('display', 'none');
            $('#dailyRate').show().css('display', 'none');
            $('#workingHour').show().css('display', 'none');
            $('#salesPeriod').show().css('display', 'none');
            $('#cutOff').show().css('display', 'none');
            $('#charge').show().css('display', 'none');
            $('#adminFeeDaily').show().css('display', 'none');
            $('#dailyRateNightShift').show().css('display', 'none');
            $('#guaranteePeriod').show().css('display', 'none');


            $('#recruitmentFee').show().css('display', 'default');
            $('#adminFeeMonthly').show().css('display', 'default');
            $('#department').show().css('display', 'default');
            $('#wica').show().css('display', 'default');
            $('#university').show().css('display', 'default');
            $('#costCenter').show().css('display', 'default');
            $('#programme').show().css('display', 'default');
            $('#hourlyRate').show().css('display', 'default');
            $('#insuranceFee').show().css('display', 'default');
            $('#teamLead').show().css('display', 'default');
            $('#endDate').show().css('display', 'default');
            $('#poNo').show().css('display', 'default');
            $('#payrollRemark').show().css('display', 'default');
            $('#salary').show().css('display', 'default');
        }
         else {
            $('#invoiceRate').show().css('display', 'default');
            $('#university').show().css('display', 'default');
            $('#workingHour').show().css('display', 'default');
            $('#salesPeriod').show().css('display', 'default');
            $('#invoiceNo').show().css('display', 'default');
            $('#charge').show().css('display', 'default');
            $('#cutOff').show().css('display', 'default');
            $('#salary').show().css('display', 'default');
            $('#guaranteePeriod').show().css('display', 'default');
            $('#recruitmentFee').show().css('display', 'default');
            $('#payrollRemark').show().css('display', 'default');
            $('#adminFeeMonthly').show().css('display', 'default');
            $('#dailyRate').show().css('display', 'default');
            $('#department').show().css('display', 'default');
            $('#wica').show().css('display', 'default');
            $('#costCenter').show().css('display', 'default');
            $('#adminFeeDaily').show().css('display', 'default');
            $('#dailyRate').show().css('display', 'default');
            $('#insuranceFee').show().css('display', 'default');
        }
    });
    $('#jobTypes').trigger('change');
});
