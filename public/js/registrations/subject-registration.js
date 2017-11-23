$(function () {
    //Initialize Select2 Element for subject category select box
    $("#subject_category_id").select2({
        minimumResultsForSearch: 5
    });

    $('body').on("change", ".standard", function () {
        if($(this).is(":checked")) {
            standardId = $(this).val();
            $('#standard_'+ standardId).prop('disabled', false);
            $('#no_of_session_per_week_'+ standardId).prop('disabled', false);
        } else {
            standardId = $(this).val();
            $('#standard_'+ standardId).prop('disabled', true);
            $('#no_of_session_per_week_'+ standardId).prop('disabled', true);
        }
    });
});