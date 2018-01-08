<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Settings;
use App\Http\Requests\TeacherRegistrationRequest;
use App\Http\Requests\TeacherUpdationRequest;

class TeacherController extends Controller
{
    /**
     * Return view for product registration
     */
    public function register()
    {
        return view('teacher.register');
    }

     /**
     * Handle new product registration
     */
    public function registerAction(TeacherRegistrationRequest $request)
    {
        $name               = $request->get('teacher_name');
        $categoryId         = $request->get('category_id');
        $description        = $request->get('description');
        $noOfSessionPerWeek = $request->get('no_of_session_per_week');
        $teacherLevel       = $request->get('teacher_level');

        $teacher = new Teacher;
        $teacher->teacher_name              = $name;
        $teacher->category_id               = $categoryId;
        $teacher->description               = $description;
        $teacher->no_of_session_per_week    = $noOfSessionPerWeek;
        $teacher->teacher_level             = $teacherLevel;
        $teacher->status        = 1;
        if($teacher->save()) {
            //invalidating the current timetable if major change is made
            $settingsFlag = Settings::where('status', 1)->first();
            if(!empty($settingsFlag) && !empty($settingsFlag->id)) {
                $settingsFlag->update(['time_table_status' => 0]);
            }
            
            return redirect()->back()->with("message","Saved successfully")->with("alert-class","alert-success");
        } else {
            return redirect()->back()->withInput()->with("message","Failed to save the teacher details. Try again after reloading the page!")->with("alert-class","alert-danger");
        }
    }

    /**
     * Return view for product listing
     */
    public function teacherList()
    {
        $teachers = Teacher::where('status', 1)->paginate(15);
        if(empty($teachers) || count($teachers) == 0) {
            session()->flash('message', 'No teachers available to show!');
        }
        
        return view('teacher.list',[
            'teachers' => $teachers
        ]);
    }

    /**
     * Return view for teacher edit
     */
    public function editTeacher($teacherId)
    {
        $teacher = Teacher::where('status', 1)->where('id', $teacherId)->first();
        
        if(!empty($teacher) && !empty($teacher->id)) {
            return view('teacher.edit', [
                    'teacher' => $teacher
                ]);
        }
        
        return redirect()->back()->with("message", "Something Went wrong, Selected record not found. Try again after reloading the page!")->with("alert-class","alert-danger");
    }

     /**
     * Handle edit teacher action
     */
    public function editTeacherAction(TeacherUpdationRequest $request)
    {
        $teacherId          = $request->get('teacher_id');
        $name               = $request->get('teacher_name');
        $categoryId         = $request->get('category_id');
        $description        = $request->get('description');
        $noOfSessionPerWeek = $request->get('no_of_session_per_week');
        $teacherLevel       = $request->get('teacher_level');

        $teacher = Teacher::where('status', 1)->where('id', $teacherId)->first();

        if(!empty($teacher) && !empty($teacher->id)) {
            $oldNoofSessionPerWeek = $teacher->no_of_session_per_week;

            $teacher->teacher_name              = $name;
            $teacher->category_id               = $categoryId;
            $teacher->description               = $description;
            $teacher->no_of_session_per_week    = $noOfSessionPerWeek;
            $teacher->teacher_level             = $teacherLevel;
            $teacher->status                    = 1;
            if($teacher->save()) {
                if($noOfSessionPerWeek != $oldNoofSessionPerWeek) {
                    //invalidating the current timetable if major change is made
                    $settingsFlag = Settings::where('status', 1)->first();
                    if(!empty($settingsFlag) && !empty($settingsFlag->id)) {
                        $settingsFlag->update(['time_table_status' => 0]);
                    }
                    return redirect(route('teacher-list'))->with("message","Updated successfully.Current timetable invalidated, due to resource change.")->with("alert-class","alert-success");
                }
                return redirect(route('teacher-list'))->with("message","Updated successfully")->with("alert-class","alert-success");
            }
        }
        return redirect()->back()->withInput()->with("message","Failed to update the teacher details. Try again after reloading the page!")->with("alert-class","alert-danger");
    }

    /**
     * Action for teacher deletion
     */
    public function deleteTeacher($teacherId)
    {
        $teacher = Teacher::where('status', 1)->where('id', $teacherId)->first();
        
        if(!empty($teacher) && !empty($teacher->id)) {
            $teacher->teacher_name  = $teacher->teacher_name."_deleted";
            $teacher->status        = 0;
            if($teacher->save()) {
                //invalidating the current timetable if major change is made
                $settingsFlag = Settings::where('status', 1)->first();
                if(!empty($settingsFlag) && !empty($settingsFlag->id)) {
                    $settingsFlag->update(['time_table_status' => 0]);
                }

                return redirect(route('teacher-list'))->with("message", "Selected teacher record deleted successfully. Current timetable invalidated, due to resource change.Current timetable invalidated, due to resource change.")->with("alert-class", "alert-success");
            }
        }

        return redirect()->back()->with("message", "Failed to delete the teacher record. Try again after reloading the page!")->with("alert-class","alert-danger");
    }
}
