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
                            })->with(['combination.classRoom.standard', 'combination.classRoom.division', 'combination.subject'])->get();

        if(!empty($teacherId)) {
            $selectedTeacher  = Teacher::find($teacherId);
            $selectedTeacherName = $selectedTeacher->teacher_name;
        } else {
            $selectedClassRoomName = "";
        }
        if(!empty($settings) && !empty($settings->id)) {
            $noOfSession = $settings->session_per_day;
        } else {
            $noOfSession = 0;
        }

        return view('timetable.teacher-level', [
                'selectedTeacherId'     => $teacherId,
                'noOfSession'           => $noOfSession,
                'sessions'              => $sessions,
                'selectedTeacherName'   => $selectedTeacherName,
                'teachers'              => $teachers,
                'timetable'             => $timetable
            ]);
    }

    /**
     * Return view for student level timetable
     */
    public function studentLevel(Request $request)
    {
        $classRoomId    = $request->get('class_room_id');
        $settings       = Settings::where('status', 1)->first();
        $classRooms     = ClassRoom::where('status', 1)->with(['standard', 'division'])->get();
        $sessions       = Session::where('status', 1)->get();
        $timetable      = Timetable::where('status', 1)->whereHas('combination', function ($qry) use($classRoomId) {
                                $qry->where('class_room_id', $classRoomId);
                            })->with(['combination.subject', 'combination.teacher'])->get();
        if(!empty($classRoomId)) {
            $selectedClassRoom  = ClassRoom::find($classRoomId);
            $selectedClassRoomName = ($selectedClassRoom->standard->standard_name. " - ". $selectedClassRoom->division->division_name);
        } else {
            $selectedClassRoomName = "";
        }

        if(!empty($settings) && !empty($settings->id)) {
            $noOfSession = $settings->session_per_day;
        } else {
            $noOfSession = 0;
        }

        return view('timetable.student-level', [
                'classRoomId'           => $classRoomId,
                'noOfSession'           => $noOfSession,
                'sessions'              => $sessions,
                'selectedClassRoomName' => $selectedClassRoomName,
                'classRooms'            => $classRooms,
                'timetable'             => $timetable
            ]);
    }

    /**
     * Return view for timetable settings
     */
    public function settings()
    {
        $noOfDays       = 0;
        $noOfSession    = 0;
        $settings       = Settings::first();

        if(!empty($settings) && !empty($settings->id)) {
            $noOfDays       = $settings->working_days_in_week;
            $noOfSession    = $settings->session_per_day;
        }
        return view('timetable.settings', [
                'noOfDays'      => $noOfDays,
                'noOfSession'   => $noOfSession
            ]);
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
        // Get default request execution limit
        $normalTimeLimit = ini_get('max_execution_time');

        // Set new request execution limit
        ini_set('max_execution_time', 300);

        $loopFlag               = true;
        $prevcombination        = 0;
        $beforeprevcombination  = 0;
        $kgFirstCombination     = [];
        $kgFirstTeacher         = [];
        $sessionTeacher         = [];
        $sessionClassRoom       = [];
        $noOfSessionPerWeek     = [];
        $classRoomSubjectCount  = [];
        $timetableArray         = [];
        $classCombinationsArr   = [];
        $settings               = Settings::where('status', 1)->first();
        $sessions               = Session::where('status', 1)->get();
        $classRooms             = ClassRoom::where('status', 1)->with('standard')->get();
        $combinations           = Combination::where('status', 1)->get();
        $standards              = Standard::where('status', 1)->with('subjects')->get();

        $noOfSessionPerDay  = $settings->session_per_day;

        foreach ($standards as $standard) {
            foreach ($standard->subjects as $subject) {
                $noOfSessionPerWeek[$standard->id][$subject->id] = $subject->pivot->no_of_session_per_week;
            }
        }

        foreach ($combinations as $comb) {
            if(empty($classCombinationsArr[$comb->class_room_id])) {
                $classCombinationsArr[$comb->class_room_id] = [];
            }
            array_push($classCombinationsArr[$comb->class_room_id], $comb->id);
        }

        foreach ($classRooms as $classRoom) {
            $kgFirstCombination[$classRoom->id] = "";
            $kgFirstTeacher[$classRoom->id]     = "";

            foreach ($sessions as $session) {
                $loopCount  = 0;
                do {
                    //considering 2 sessions as 1 for kg classes
                    if(($classRoom->standard->level < 3) && (($session->id % 2) == 0) && !empty($kgFirstCombination[$classRoom->id])) {
                        $timetableArray[] = [
                                'session_id'        => $session->id,
                                'combination_id'    => $kgFirstCombination[$classRoom->id],
                                'status'            => 1
                            ];

                        $sessionTeacher[$session->id][$kgFirstTeacher[$classRoom->id]] = $classRoom->id;
                        $sessionClassRoom[$session->id][$classRoom->id] = $kgFirstTeacher[$classRoom->id];
                        $kgFirstCombination[$classRoom->id] = "";
                        $kgFirstTeacher[$classRoom->id]     = "";
                    } else {
                        $loopFlag   = true;
                        $loopCount  = $loopCount + 1;
                        //selecting a random combination of the current class
                        $randomCombinationIndex = array_rand($classCombinationsArr[$classRoom->id]);
                        $randomCombinationId    = $classCombinationsArr[$classRoom->id][$randomCombinationIndex]; //print_r($randomCombinationId."<br>");
                        $combination = $combinations[$randomCombinationId-1];

                        if(($combination->id == $prevcombination && $combination->id == $beforeprevcombination) || ((($session->id % $noOfSessionPerDay) == 1) && ($combination->subject->category_id) > 5)) {
                            continue;
                        }

                        $classRoomId    = $combination->class_room_id;
                        $teacherId      = $combination->teacher_id;
                        $subjectId      = $combination->subject_id;

                        if(empty($classRoomSubjectCount[$classRoomId][$subjectId])) {
                            $classRoomSubjectCount[$classRoomId][$subjectId] = 0;
                        }
                        
                        if(empty($sessionTeacher[$session->id][$teacherId]) && empty($sessionClassRoom[$session->id][$classRoomId])) {
                            if($noOfSessionPerWeek[$classRoom->standard->id][$subjectId] >= $classRoomSubjectCount[$classRoomId][$subjectId]) {
                                $sessionTeacher[$session->id][$teacherId] = $classRoomId;
                                $sessionClassRoom[$session->id][$classRoomId] = $teacherId;
                                $classRoomSubjectCount[$classRoomId][$subjectId] = $classRoomSubjectCount[$classRoomId][$subjectId] + 1;

                                $timetableArray[] = [
                                    'session_id'        => $session->id,
                                    'combination_id'    => $combination->id,
                                    'status'            => 1
                                ];
                                //considering 2 sessions as 1 for kg classes
                                if(($classRoom->standard->level < 3) && (($session->id % 2) != 0) && empty($kgFirstCombination[$classRoom->id])) {
                                    $kgFirstCombination[$classRoom->id] = $combination->id;
                                    $kgFirstTeacher[$classRoom->id]     = $teacherId;
                                }
                                //loop termination
                                $loopFlag   = false;
                                $loopCount  = 0;
                                $beforeprevcombination  = $prevcombination;
                                $prevcombination        = $combination->id;
                            } else {
                                if (($key = array_search($combination->id, $classCombinationsArr[$classRoom->id])) !== false) {
                                    unset($classCombinationsArr[$classRoom->id][$key]);
                                }
                            }
                        }
                    }
                } while($loopFlag && $loopCount <= 100);

                if(empty($sessionClassRoom[$session->id][$classRoom->id])) { /* && !(($classRoom->standard->level < 3) && (($session->id % 2) == 0))) {*/
                    // Restore to default request execution limit
                    ini_set('max_execution_time', $normalTimeLimit); 

                    return redirect()->back()->withInput()->with("message","Failed to generate the timetable. Not enough resources available as per the current settings. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
                }
            }
        }
        //delete all existing records
        Timetable::truncate();

        $timetable = Timetable::insert($timetableArray);

        if($timetable) {
            // Restore to default request execution limit
            ini_set('max_execution_time', $normalTimeLimit); 

            return redirect()->back()->withInput()->with("message","Timetable generated successfully")->with("alert-class","alert-success");
        } else {
            // Restore to default request execution limit
            ini_set('max_execution_time', $normalTimeLimit); 

            return redirect()->back()->withInput()->with("message","Failed to generate the timetable. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
        }
        // Restore to default request execution limit
        ini_set('max_execution_time', $normalTimeLimit); 
    }
}