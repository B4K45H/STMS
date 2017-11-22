$(function () {
    //new teacher registration link for select2
    teacherRegistrationLink = "No results found. <a href='/teacher/register'>Register new teacher</a>";
    
    //Initialize Select2 Element for standard select box
    $("#standard_id").select2({
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

    //select default values for the selected vehicle based on last sale
    /*$('body').on("change", "#standard_id", function () {
        var standardId = $('#standard_id').val();
        
        if(standardId) {
            $.ajax({
                url: "/get/subjects/standard/" + standardId,
                method: "get",
                success: function(result) {
                    if(result && result.flag) {
                        $("#subject_teacher_assignment_div").html('');
                        $.each($.parseJSON(result.subjects), function(index,subject) {
                            var html = '<tr>'+
                                            '<td>'+($index+1)+'</td>'+
                                            '<td>'+
                                                '<label for="subject_'+ (index+1)+ '" class="form-control">'+ (subject->subject_name) +'</label>'+
                                                '<input type="hidden" name="subjects[]" value="'+ (subject->id) +'">'+
                                            '</td>'+
                                        '<td>'+
                                            '<div class="col-lg-12">'+
                                                '<select class="form-control" name="teacher_id['+ (subject->id) +']" id="teacher_id" tabindex="5">'+
                                                    '<option value="">Select teacher</option>'+
                                                        $.each($.parseJSON(result.teachers), function(index,teacher) {
                                                            '<option value="'+ $teacher->id +'">'+ $teacher->name +'</option>'+
                                                        })
                                                '</select>'+
                                            '</div>'+
                                        '</td>'+
                                    '</tr>';
                            $("#subject_teacher_assignment_div").append(html);
                        });
                    } else {
                        $("#subject_teacher_assignment_div").html('');
                    }
                },
                error: function () {
                    $("#subject_teacher_assignment_div").html('');
                }
            });
        }
    });*/
});