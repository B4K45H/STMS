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

    //Timepicker
    $(".timepicker").timepicker({
        minuteStep : 1,
        showInputs : false,
        showMeridian : true,
        defaultTime: '09:00 AM'
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

    //invoke modal for confirmation
    $('body').on("click", "#delete_leave_btn", function (e) {
        e.preventDefault();
        $('#confirm_leave_delete_modal').modal('show');
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

    //submit timetable generation form on confirmation
    $('body').on("click", "#btn_modal_submit", function (e) {
        e.preventDefault();
        var captchaMessage  = $('#captcha_message').val();
        var userCaptcha     = $('#user_captcha').val();

        if(captchaMessage && userCaptcha) {
            if(captchaMessage == userCaptcha) {
                $("#btn_modal_submit").prop("disabled", true);
                $('#timetable_generate_form').submit();
                $("#confirm_modal").modal("hide");
                $("#wait_modal").modal("show");
                changeMessage();
            } else {
                alert("Invalid captcha!");
            }
        } else {
            alert("Invalid captcha!");
        }
    });

    //submit form on confirmation
    $('body').on("click", "#btn_leave_delete_modal_submit", function (e) {
        e.preventDefault();
        $('#leave_deletion_form').submit();
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

//function to show messages one by one in modal
function changeMessage() {
    var countFlag = 1;
    setInterval(function() {
        if(countFlag == 1) {
            $("#wait_modal_message_1").hide();
            $("#wait_modal_message_2").show();
            $("#wait_modal_message_3").hide();
            countFlag = 2;
        } else if(countFlag == 2) {
            $("#wait_modal_message_1").hide();
            $("#wait_modal_message_2").hide();
            $("#wait_modal_message_3").show();
            countFlag = 3;
        } else {
            $("#wait_modal_message_1").show();
            $("#wait_modal_message_2").hide();
            $("#wait_modal_message_3").hide();
            countFlag = 1;
        }
    }, 4000 );
}