<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class TimetableController extends Controller
{
    /**
     * Return view for teacher level timetable
     */
    public function teacherLevel()
    {
        return view('timetable.teacher-level', []);
    }

    /**
     * Return view for student level timetable
     */
    public function studentLevel()
    {
        $subjects   = Subject::where('status', 1)->get();
        
        return view('timetable.student-level', [
                'subjects'  => $subjects
            ]);
    }
}
