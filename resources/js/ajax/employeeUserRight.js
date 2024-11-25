const { log } = require("handsontable/helpers");

$(document).ready(function() {
    $('#mySelect').change(function() {
        var selectedValue = $(this).val();
        // if (selectedValue === '4') {
        //     myPayroll();
        // } else {
        //     $('#role4input').hide().css('display', 'none');
        // }


        // function myPayroll() {
        //     $('#role4input').show().css('display', 'show');
        // }

        // Payroll end
        if (selectedValue === '8') {
            myConsultent();
        } else {
            $('#role7input').hide().css('display', 'none');
            $('#role7inputanother').hide().css('display', 'none');
        }

        function myConsultent() {
            $('#role7input').show().css('display', 'show');
            $('#role7inputanother').show().css('display', 'show');
        }

        // Consultent

        if (selectedValue === '12') {
            myInternship();
        } else {
            $('#role9input').hide().css('display', 'none');
            $('#role9inputanother').hide().css('display', 'none');
        }

        function myInternship() {
            $('#role9input').show().css('display', 'show');
            $('#role9inputanother').show().css('display', 'show');
        }
        // Internship
        if (selectedValue === '11') {
            myTeamLeader();
        } else {
            $('#role10input').hide().css('display', 'none');
        }


        function myTeamLeader() {
            $('#role10input').show().css('display', 'show');
        }
        ///Manager

    });
    $('#mySelect').trigger('change');
});
