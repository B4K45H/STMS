$(function () {
    //select subjects and teachers for selected standard
    $('body').on("change", "#standard_id", function () {
        var html = "";
        var teachersSelectOptions = "";
        var standardId = $('#standard_id').val();
        
        if(standardId) {
            $("#no_rows_error_container").html("");
            $.ajax({
                url: "/get/subjects/standard/" + standardId,
                method: "get",
                success: function(result) {
                    if(result && result.flag) {
                        $.each($.parseJSON(result.teachers), function(index,teacher) {
                            teachersSelectOptions = teachersSelectOptions + ('<option value="'+ teacher.id +'">'+ teacher.teacher_name +'</option>');
                        });
                        $("#subject_teacher_assignment_container").html('');
                        if($.parseJSON(result.subjects).length > 0) {
                            $.each($.parseJSON(result.subjects), function(index,subject) {
                                html = ('<tr>'+
                                                '<td>'+(index+1)+'</td>'+
                                                '<td>'+
                                                    '<label for="subject_'+ (index+1)+ '" class="form-control">'+ (subject.subject_name) +'</label>'+
                                                    '<input type="hidden" name="subjects[]" value="'+ (subject.id) +'">'+
                                                '</td>'+
                                            '<td>'+
                                                '<div class="col-lg-12">'+
                                                    '<select class="form-control select_2" name="teacher_id['+ (subject.id) +']" id="teacher_id" tabindex="5">'+
                                                        '<option value="">Select teacher</option>'+
                                                            teachersSelectOptions+
                                                    '</select>'+
                                                '</div>'+
                                            '</td>'+
                                        '</tr>');
                                $("#subject_teacher_assignment_container").append(html);
                            });
                        } else {
                            $("#no_rows_error_container").html(
                                "<h3 style='color:red;'><br>No subjects are allotted to the selected standard.</h3>"
                                );
                        }
                    } else {
                        $("#subject_teacher_assignment_container").html('');
                    }
                    $('.select_2').select2({
                        minimumResultsForSearch: 5
                    });
                },
                error: function () {
                    $("#subject_teacher_assignment_container").html('');
                }
            });
        }
    });
});