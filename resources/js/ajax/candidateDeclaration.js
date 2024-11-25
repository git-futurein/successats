
$(document).ready(function() {
    $('input[name="candidate_dec_bankrupt"]').change(function() {
        var selectedValue = $(this).val();

        // candidate_dec_bankrupt Start
        if (selectedValue === '1') {
            myBankrupt();
        } else {
            $('#candidate_dec_bankrupt_details').hide().css('display', 'none');
        }

        function myBankrupt() {
            $('#candidate_dec_bankrupt_details').show().css('display', 'show');
        }

        // candidate_dec_bankrupt end

    });
    // Trigger the change event on page load
    if ($('input[name="candidate_dec_bankrupt"]:checked').length > 0) {
        // If any radio button is already checked on page load
        $('input[name="candidate_dec_bankrupt"]:checked').trigger('change');
    } else {
        // If no radio button is checked on page load, hide the details
        $('#candidate_dec_bankrupt_details').hide();
    }
});
$(document).ready(function() {
    $('input[name="candidate_dec_physical"]').change(function() {
        var selectedValue = $(this).val();

        // candidate_dec_bankrupt Start
        if (selectedValue === '1') {
            myBankrupt();
        } else {
            $('#candidate_dec_physical_details').hide().css('display', 'none');
        }

        function myBankrupt() {
            $('#candidate_dec_physical_details').show().css('display', 'show');
        }

        // candidate_dec_bankrupt end

    });
    // Trigger the change event on page load
    if ($('input[name="candidate_dec_physical"]:checked').length > 0) {
        // If any radio button is already checked on page load
        $('input[name="candidate_dec_physical"]:checked').trigger('change');
    } else {
        // If no radio button is checked on page load, hide the details
        $('#candidate_dec_physical_details').hide();
    }
});
$(document).ready(function() {
    $('input[name="candidate_dec_lt_medical"]').change(function() {
        var selectedValue = $(this).val();

        // candidate_dec_bankrupt Start
        if (selectedValue === '1') {
            myBankrupt();
        } else {
            $('#candidate_dec_lt_medical_details').hide().css('display', 'none');
        }

        function myBankrupt() {
            $('#candidate_dec_lt_medical_details').show().css('display', 'show');
        }

        // candidate_dec_bankrupt end

    });
    // Trigger the change event on page load
    if ($('input[name="candidate_dec_lt_medical"]:checked').length > 0) {
        // If any radio button is already checked on page load
        $('input[name="candidate_dec_lt_medical"]:checked').trigger('change');
    } else {
        // If no radio button is checked on page load, hide the details
        $('#candidate_dec_lt_medical_details').hide();
    }
});
$(document).ready(function() {
    $('input[name="candidate_dec_law"]').change(function() {
        var selectedValue = $(this).val();

        // candidate_dec_bankrupt Start
        if (selectedValue === '1') {
            myBankrupt();
        } else {
            $('#candidate_dec_law_details').hide().css('display', 'none');
        }

        function myBankrupt() {
            $('#candidate_dec_law_details').show().css('display', 'show');
        }

        // candidate_dec_bankrupt end

    });
    // Trigger the change event on page load
    if ($('input[name="candidate_dec_law"]:checked').length > 0) {
        // If any radio button is already checked on page load
        $('input[name="candidate_dec_law"]:checked').trigger('change');
    } else {
        // If no radio button is checked on page load, hide the details
        $('#candidate_dec_law_details').hide();
    }
});
$(document).ready(function() {
    $('input[name="candidate_dec_warning"]').change(function() {
        var selectedValue = $(this).val();

        // candidate_dec_bankrupt Start
        if (selectedValue === '1') {
            myBankrupt();
        } else {
            $('#candidate_dec_warning_details').hide().css('display', 'none');
        }

        function myBankrupt() {
            $('#candidate_dec_warning_details').show().css('display', 'show');
        }

        // candidate_dec_bankrupt end

    });
    // Trigger the change event on page load
    if ($('input[name="candidate_dec_warning"]:checked').length > 0) {
        // If any radio button is already checked on page load
        $('input[name="candidate_dec_warning"]:checked').trigger('change');
    } else {
        // If no radio button is checked on page load, hide the details
        $('#candidate_dec_warning_details').hide();
    }
});
$(document).ready(function() {
    $('input[name="candidate_dec_applied"]').change(function() {
        var selectedValue = $(this).val();

        // candidate_dec_bankrupt Start
        if (selectedValue === '1') {
            myBankrupt();
        } else {
            $('#candidate_dec_applied_details').hide().css('display', 'none');
        }

        function myBankrupt() {
            $('#candidate_dec_applied_details').show().css('display', 'show');
        }

        // candidate_dec_bankrupt end

    });
    // Trigger the change event on page load
    if ($('input[name="candidate_dec_applied"]:checked').length > 0) {
        // If any radio button is already checked on page load
        $('input[name="candidate_dec_applied"]:checked').trigger('change');
    } else {
        // If no radio button is checked on page load, hide the details
        $('#candidate_dec_applied_details').hide();
    }
});
