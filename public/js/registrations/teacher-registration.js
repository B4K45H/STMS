$(function () {
    //Initialize Select2 Element for category select box
    $("#category_id").select2({
        minimumResultsForSearch: 5
    });

    //Initialize Select2 Element for teacher level select box
    $("#teacher_level").select2({
        minimumResultsForSearch: 5
    });
});