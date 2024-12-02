$(document).ready(function () {
    $('#mySelect').change(function () {
        var selectedValue = $(this).val();

        // Nationality Start
        if (selectedValue === '2') {
            myNationality();
        } else {
            $('#myNationality').hide().css('display', 'none');
        }


        function myNationality() {
            $('#myNationality').show().css('display', 'show');
        }

        // Nationality end

    });
    $('#mySelect').trigger('change');
});
