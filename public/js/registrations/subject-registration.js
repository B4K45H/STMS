$(function () {
    //new teacher registration link for select2
    //teacherRegistrationLink = "No results found. <a href='/vehicle/register'>Register new teacher</a>";
    
    //Initialize Select2 Element for standard select box
    $("#subject_category_id").select2({
        minimumResultsForSearch: 5
    });

    //Initialize Select2 Element for standard select box
    $("#division_id").select2({
        minimumResultsForSearch: 5
    });

    //Initialize Select2 Element for teacher incharge select box
    $("#teacher_incharge_id").select2({
        language: {
             noResults: function() {
                return teacherRegistrationLink;
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });
});