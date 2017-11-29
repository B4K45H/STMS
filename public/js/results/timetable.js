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
    $(".select_2").select2({
        minimumResultsForSearch: 5
    });
    
    //invoke modal for confirmation
    $('body').on("click", "#timetable_generate_btn", function (e) {
        e.preventDefault();
        $('#confirm_modal').modal('show');
    });

    //clear classroom selection on teacher selection
    $('body').on("change", "#substitution_teacher_id", function () {
        var teacherId = $('#substitution_teacher_id').val();
        if(teacherId) {
            $('#class_room_id').val('');
            $('#class_room_id').trigger('change');
        }
    });

    //clear teacher selection on classroom selection
    $('body').on("change", "#class_room_id", function () {
        var classroomId = $('#class_room_id').val();
        if(classroomId) {
            $('#substitution_teacher_id').val('');
            $('#substitution_teacher_id').trigger('change');
        }
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