<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Session;
use App\Models\Settings;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\Combination;
use App\Models\Timetable;
use App\Models\Standard;

class TimetableController extends Controller
{
    /**
     * Return view for teacher level timetable
     */
    public function teacherLevel(Request $request)
    {
        $selectedTeacherName = "";
        $teacherId  = $request->get('teacher_id');
        $settings   = Settings::where('status', 1)->first();
        $teachers   = Teacher::where('status', 1)->get();
        $sessions   = Session::where('status', 1)->get();
        $timetable  = Timetable::where('status', 1)->whereHas('combination', function ($qry) use($teacherId) {
                                $qry->where('teacher_id', $teacherId);
                            })->get();

        if(!empty($teacherId)) {
            $selectedTeacher  = Teacher::find($teacherId);
            $selectedTeacherName = $selectedTeacher->name;
        } else {
            $selectedClassRoomName = "";
        }

        $noOfSession    = $settings->session_per_day;

        return view('timetable.teacher-level', [
                'noOfSession'   => $noOfSession,
                'sessions'      => $sessions,
                'selectedTeacherName' => $selectedTeacherName,
                'teachers'      => $teachers,
                'timetable'     => $timetable
            ]);
    }

    /**
     * Return view for student level timetable
     */
    public function studentLevel(Request $request)
    {
        $classRoomId    = $request->get('class_room_id');
        $settings       = Settings::where('status', 1)->first();
        $classRooms     = ClassRoom::where('status', 1)->get();
        $sessions       = Session::where('status', 1)->get();
        $timetable      = Timetable::where('status', 1)->whereHas('combination', function ($qry) use($classRoomId) {
                                $qry->where('class_room_id', $classRoomId);
                            })->get();
        if(!empty($classRoomId)) {
            $selectedClassRoom  = ClassRoom::find($classRoomId);
            $selectedClassRoomName = ($selectedClassRoom->standard->standard_name. " - ". $selectedClassRoom->division->division_name);
        } else {
            $selectedClassRoomName = "";
        }
        $noOfSession    = $settings->session_per_day;
        //$noOfDays       = $settings->working_days_in_week;

        return view('timetable.student-level', [
                'noOfSession'   => $noOfSession,
                'sessions'      => $sessions,
                'selectedClassRoomName' => $selectedClassRoomName,
                //'noOfDays'      => $noOfDays,
                'classRooms'    => $classRooms,
                'timetable'     => $timetable
            ]);
    }

    /**
     * Return view for timetable settings
     */
    public function settings()
    {
        return view('timetable.settings', []);
    }

    /**
     * Return view for timetable settings
     */
    public function settingsAction(Request $request)
    {
        $sessionArray   = [];
        $noOfDays       = $request->get('no_of_days');
        $noOfSession    = $request->get('no_of_session');

        $day        = [1 => 'Monday', 2 => 'Tuesday', 3=> 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'];
        $session    = [1 => 'Mo', 2 => 'Tu', 3 => 'We', 4 => 'Th', 5 => 'Fr', 6 => 'Sa'];

        for ($i=1; $i <= $noOfDays; $i++) { 
            for ($j=1; $j <= $noOfSession; $j++) { 
                $sessionArray[] = [
                    'day_index'     => $i,
                    'session_index' => $j,
                    'day_name'      => $day[$i],
                    'session_name'  => ($session[$i]. " - ". $j),
                    'time_from'     => '09:30:00',
                    'time_to'       => '16:00:00',
                    'status'        => 1
                ];
            }
        }

        //delete all existing records
        Session::truncate();
        Settings::truncate();

        $settings = new Settings;
        $settings->working_days_in_week = $noOfDays;
        $settings->session_per_day      = $noOfSession;
        $settings->status               = 1;
        if($settings->save())
        {
            $session = Session::insert($sessionArray);
            if($session) {
                return redirect()->back()->withInput()->with("message","Settings saved successfully")->with("alert-class","alert-success");
            } else {
                return redirect()->back()->withInput()->with("message","Failed to save the settings. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
            }
        } else {
            return redirect()->back()->withInput()->with("message","Failed to save the settings. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
        }
    }

    /**
     * action for timetable generation
     */
    public function generateTimetableAction()
    {
        $loopFlag               = true;
        $loopCount              = 0;
        $prevcombination        = 0;
        $beforprevcombination   = 0;
        $sessionTeacher         = [];
        $sessionClassRoom       = [];
        $noOfSessionPerWeek     = [];
        $classRoomSubjectCount  = [];
        $timetableArray         = [];
        //$combinationFlag      = [];
        //$combinationCount     = [];
        $classCombinationsArr   = [];
        $settings               = Settings::where('status', 1)->first();
        $teachers               = Teacher::where('status', 1)->get();
        $sessions               = Session::where('status', 1)->get();
        $classRooms             = ClassRoom::where('status', 1)->get();//->where('id', 1)
        $combinations           = Combination::where('status', 1)->get();//->where('class_room_id', 1)
        $standards              = Standard::where('status', 1)->get();

        $noOfSessionPerDay  = $settings->session_per_day;
        //$noOfDays           = $settings->working_days_in_week;
        /* || $noOfSessionPerDay > count($combinations)*/
        /*if($noOfSessionPerDay > count($teachers)) {
            return redirect()->back()->withInput()->with("message","Failed to generate the timetable. Not enough resources available as per the current settings.")->with("alert-class","alert-danger");
        }*/

        foreach ($standards as $standard) {
            foreach ($standard->subjects as $subject) {
                $noOfSessionPerWeek[$standard->id][$subject->id] = $subject->pivot->no_of_session_per_week;
            }
        }

        /*foreach ($classRooms as $classRoom) {
            $combinationCount[$classRoom->id] = count($classRoom->combinations);
        }*/
        
        //$classCombinationsArr[$classRoom->id] = [];
        foreach ($combinations as $comb) {
            if(empty($classCombinationsArr[$comb->class_room_id])) {
                $classCombinationsArr[$comb->class_room_id] = [];
            }
            //if($comb->class_room_id == $classRoom->id) {
            array_push($classCombinationsArr[$comb->class_room_id], $comb->id);
            //}
        }

        foreach ($classRooms as $classRoom) {
            foreach ($sessions as $session) {
                print_r("..." .$classRoom->id. "... <br>");
                do {
                    $loopFlag   = true;
                    $loopCount  = $loopCount + 1;
                    //selecting a random combination of the current class
                    $combination = $combinations[array_rand($classCombinationsArr[$classRoom->id])];
                    if($combination->id == $prevcombination && $combination->id == $beforprevcombination) {
                        continue;
                    }
//dd($classCombinationsArr[$classRoom->id]);
                    $classRoomId    = $combination->class_room_id;
                    $teacherId      = $combination->teacher_id;
                    $subjectId      = $combination->subject_id;

//print_r($combination->id. "<br>");

                    if(empty($classRoomSubjectCount[$classRoomId][$subjectId])) {
                        $classRoomSubjectCount[$classRoomId][$subjectId] = 0;
                    }
                    /*if(empty($combinationFlag[$classRoom->id])) {
                        $combinationFlag[$classRoom->id] = [];
                    }*/
                    
                    if(empty($sessionTeacher[$session->id][$teacherId]) && empty($sessionClassRoom[$session->id][$classRoomId])) {
                        if($noOfSessionPerWeek[$classRoom->standard->id][$subjectId] >= $classRoomSubjectCount[$classRoomId][$subjectId]) {
                            //if(!in_array($combination->id, $combinationFlag[$classRoom->id])) {
                                //array_push($combinationFlag[$classRoom->id], $combination->id);
                                //if($combinationCount[$classRoom->id] == count($combinationFlag[$classRoom->id])) {
                                    //$combinationFlag[$classRoom->id] = [];
                                //}
                                $sessionTeacher[$session->id][$teacherId] = $classRoomId;
                                $sessionClassRoom[$session->id][$classRoomId] = $teacherId;
                                $classRoomSubjectCount[$classRoomId][$subjectId] = $classRoomSubjectCount[$classRoomId][$subjectId] + 1;

                                $timetableArray[] = [
                                    'session_id'        => $session->id,
                                    'combination_id'    => $combination->id,
                                    'status'            => 1
                                ];
                                //loop termination
                                $loopFlag   = false;
                                $loopCount  = 0;
                                $beforprevcombination   = $prevcombination;
                                $prevcombination        = $combination->id;
                            //}
                        } else {
                            if (($key = array_search($combination->id, $classCombinationsArr[$classRoom->id])) !== false) {
                                unset($classCombinationsArr[$classRoom->id][$key]);
                            }
                            //$combinationCount[$classRoom->id] = $combinationCount[$classRoom->id] -1;
                        }
                    }
                } while($loopFlag && $loopCount <= 100);
                print_r($session->id. " + ". $classRoom->id. " = ". $sessionClassRoom[$session->id][$classRoom->id]. "<br>");

                if(empty($sessionClassRoom[$session->id][$classRoom->id])) {
                    //print_r($session->id. " + ". $classRoom->id. " = ". $sessionClassRoom[$session->id][$classRoom->id]. "<br>");
                    return redirect()->back()->withInput()->with("message","Failed to generate the timetable. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
                } else {
                    //print_r($session->id. " + ". $classRoom->id. " = ". $sessionClassRoom[$session->id][$classRoom->id]. "<br>");
                }
            }
        }
        dd(1);
//dd($timetableArray);
        //delete all existing records
        Timetable::truncate();

        $timetable = Timetable::insert($timetableArray);

        if($timetable) {
            return redirect()->back()->withInput()->with("message","Timetable generated successfully")->with("alert-class","alert-success");
        } else {
            return redirect()->back()->withInput()->with("message","Failed to generate the timetable. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
        }
    }

    /**
     * Return view for substitution
     */
    public function substitution(Request $request)
    {
        $selectedTeacherName = "";
        $teacherId  = $request->get('teacher_id');
        $dayIndex   = !empty($request->get('day_index')) ? $request->get('day_index') : 0;
        $settings   = Settings::where('status', 1)->first();
        $teachers   = Teacher::where('status', 1)->get();
        $sessions   = Session::where('status', 1)->where('day_index', $dayIndex)->get();
        $timetable  = Timetable::where('status', 1)->whereHas('combination', function ($qry) use($teacherId) {
                                $qry->where('teacher_id', $teacherId);
                            })->get();

        if(!empty($teacherId)) {
            $selectedTeacher  = Teacher::find($teacherId);
            $selectedTeacherName = $selectedTeacher->name;
        } else {
            $selectedClassRoomName = "";
        }

        $noOfSession    = $settings->session_per_day;

        return view('timetable.substitution', [
                'noOfSession'   => $noOfSession,
                'sessions'      => $sessions,
                'selectedTeacherName' => $selectedTeacherName,
                'teachers'      => $teachers,
                'timetable'     => $timetable
            ]);
    }
}
/*$flag = Timetable::where('session_id', $session->id)->whereHas('combination', function ($qry) use($classRoomId, $teacherId) {
                                $qry->where('class_id', $classRoomId)->orWhere('teacher_id', $teacherId);
                            })->count();*/