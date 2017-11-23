$(function () {
    //setting random captcha to confirmation model
    var captchaString = randomString(6, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    $('#captcha_message').val(captchaString);

    var today = new Date();
    //Date picker
    $('.datepicker').datepicker({
        todayHighlight: true,
        startDate: today,
        format: 'dd-mm-yyyy',
        autoclose: true,
    });

    //Initialize Select2 Element for teacher select box
    $("#teacher_id").select2({
        minimumResultsForSearch: 5
    });

    $("#class_room_id").select2({
        minimumResultsForSearch: 5
    });

    $("#no_of_days").select2({
        minimumResultsForSearch: 5
    });

    $("#no_of_session").select2({
        minimumResultsForSearch: 10
    });

    $("#day_index").select2({
        minimumResultsForSearch: 10
    });
    
    //invoke modal for confirmation
    $('body').on("click", "#timetable_generate_btn", function (e) {
        e.preventDefault();
        $('#confirm_modal').modal('show');
    });

    //invoke modal for confirmation
    $('body').on("click", "#btn_modal_submit", function (e) {
        e.preventDefault();
        var captchaMessage  = $('#captcha_message').val();
        var userCaptcha     = $('#user_captcha').val();

        if(captchaMessage && userCaptcha) {
            if(captchaMessage == userCaptcha) {
                $('#timetable_generate_form').submit();
            } else {
                alert("Invalid captcha!");
            }
        } else {
            alert("Invalid captcha!");
        }
    });
});
//function to generate random strings
function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i)
    {
        result += chars[Math.floor(Math.random() * chars.length)];
    }
    return result;
}