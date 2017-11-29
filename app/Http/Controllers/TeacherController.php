<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Http\Requests\TeacherRegistrationRequest;

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
        $teacherLevel       = $request->get('experience_level');

        $teacher = new Teacher;
        $teacher->teacher_name              = $name;
        $teacher->category_id               = $categoryId;
        $teacher->description               = $description;
        $teacher->no_of_session_per_week    = $noOfSessionPerWeek;
        $teacher->teacher_level             = $teacherLevel;
        $teacher->status        = 1;
        if($teacher->save()) {
            return redirect()->back()->with("message","Saved successfully")->with("alert-class","alert-success");
        } else {
            return redirect()->back()->withInput()->with("message","Failed to save the teacher details. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
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
}
