<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Settings;
use App\Models\Teacher;
use App\Models\Combination;
use App\Models\Timetable;
use App\Models\Leave;
use App\Models\ClassRoom;
use App\Models\Substitution;
use App\Models\SessionTime;
use App\Http\Requests\SubstitutionRegistrationRequest;

class SubstitutionController extends Controller
{
    /**
     * Return view for substitution
     */
    public function substitution(Request $request)
    {
        $teacherId          = $request->get('leave_teacher_id');
        $substitutionDate   = $request->get('sub_date');

        $dayIndex               = 0;
        $leaveExcludeArr        = [];
        $engageExcludeArr       = [];
        $substituted            = [];
        $leavetimetableSessions = [];
        $leavetimetable         = [];
        $classCombinations      = [];
        $leaveTeacherName       = "";
        
        if(!empty($substitutionDate) && !empty($substitutionDate)) {
            $timestamp      = strtotime($substitutionDate);
            $dayIndex       = (date('w', $timestamp));
            //excluding leave teachers
            $leaveExcludeArr     = Leave::where('leave_date', date('Y-m-d', strtotime($substitutionDate)))->pluck('teacher_id')->toArray();

            //check & confirm, a leave teacher is substituted
            if(!in_array($teacherId, $leaveExcludeArr)) {
                return redirect()->back()->withInput()->with("message","Selected teacher is not marked as absent for the selected date.!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
            }

            $leavetimetable  = Timetable::where('status', 1)->whereHas('combination', function ($qry) use($teacherId) {
                                            $qry->where('teacher_id', $teacherId);
                                        })->whereHas('session', function ($qry) use($dayIndex) {
                                            $qry->where('day_index', $dayIndex);
                                        })->with('combination')->get();

            foreach ($leavetimetable as $key => $record) {
                array_push($leavetimetableSessions, $record->session_id);
            }

            $engagedTimetable = Timetable::where('status', 1)->whereIn('session_id', $leavetimetableSessions)->with('combination')->get();
            
            foreach ($engagedTimetable as $key => $record) {
                if(empty($engageExcludeArr[$record->session_id])) {
                    $engageExcludeArr[$record->session_id] = [];
                }
                array_push($engageExcludeArr[$record->session_id], $record->combination->teacher_id);
            }

            if(!empty($teacherId)) {
                $selectedTeacher    = Teacher::find($teacherId);
                $leaveTeacherName   = $selectedTeacher->teacher_name;
            } else {
                $leaveTeacherName = "";
            }
        }

        $combinations   = Combination::where('status', 1)->with(['teacher', 'subject'])->get();
        foreach ($combinations as $key => $combination) {
            if(empty($classCombinations[$combination->classRoom->id])) {
                $classCombinations[$combination->classRoom->id] = [];
            }
            array_push($classCombinations[$combination->classRoom->id], $combination);
        }

        $substitutions  = Substitution::where('status', 1)->where('substitution_date', date('Y-m-d', strtotime($substitutionDate)))->with('combination')->get();
        foreach ($substitutions as $key => $substitution) {
            if(empty($engageExcludeArr[$substitution->session_id])) {
                $engageExcludeArr[$substitution->session_id] = [];
            }

            if($substitution->leave_teacher_id == $teacherId) {
                $substituted[$substitution->session_id] = $substitution->combination_id;
            } else {
                array_push($engageExcludeArr[$substitution->session_id], $substitution->combination->teacher_id);
            }
        }

        $teacherCombo   = Teacher::where('status', 1)->get();
        $settings       = Settings::where('status', 1)->first();
        $sessions       = Session::where('status', 1)->where('day_index', $dayIndex)->get();

        if(!empty($settings) && !empty($settings->id)) {
            $noOfSessionPerDay  = $settings->session_per_day;
        } else {
            $noOfSessionPerDay  = 0;
        }

        return view('substitution.substitution', [
                'teacherId'         => $teacherId,
                'substitutionDate'  => $substitutionDate,
                'noOfSession'       => $noOfSessionPerDay,
                'sessions'          => $sessions,
                'leaveTeacherName'  => $leaveTeacherName,
                'leaveExcludeArr'   => $leaveExcludeArr,
                'engageExcludeArr'  => $engageExcludeArr,
                'substituted'       => $substituted,
                'classCombinations' => $classCombinations,
                'teacherCombo'      => $teacherCombo,
                'timetable'         => $leavetimetable
            ]);
    }

    /**
     * action for substitution registration
     */
    public function substitutionAction(SubstitutionRegistrationRequest $request)
    {
        $substitutionArr        = [];
        $substitutionSessions   = [];
        $emptyCount             = 0;
        $combinationIds         = $request->get('combination_id');
        $leaveTeacherId         = $request->get('leave_teacher_id');
        $substitutionDate       = $request->get('sub_date');

        $subDate    = $substitutionDate;
        $subDate    = date('Y-m-d', strtotime($subDate));

        if(empty(($combinationIds)) || count($combinationIds) <= 0) {
            return redirect()->back()->withInput()->with("message","Failed to save the substitution details. Minimum one substitution is required.!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
        }
        foreach ($combinationIds as $sessionId => $combinationId) {
            if(!empty($combinationId)) {
                array_push($substitutionSessions, $sessionId);

                $substitutionArr[] = [
                    'substitution_date' => $subDate,
                    'leave_teacher_id'  => $leaveTeacherId,
                    'session_id'        => $sessionId,
                    'combination_id'    => $combinationId,
                    'status'            => 1,
                ];
            } else {
                $emptyCount = $emptyCount + 1;
            }
        }
        if($emptyCount >= count($combinationIds)) {
            return redirect()->back()->withInput()->with("message","Failed to save the substitution details. Minimum one substitution is required.!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
        }

        //deleting existing substitution
        $deleteFlag = Substitution::where('leave_teacher_id', $leaveTeacherId)->where('substitution_date', $subDate)->whereIn('session_id', $substitutionSessions)->delete();
        
        $substitution = Substitution::insert($substitutionArr);
        if($substitution) {
            return redirect(route('substituted-timetable',[
                'substitution_date'   => $substitutionDate,
                ]))->with("message","Substitution saved successfully")->with("alert-class","alert-success");
        } else {
            return redirect()->back()->withInput()->with("message","Failed to save the substitution details. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
        }
    }

    /**
     * view for substituted timetable
     */
    public function substitutedTimetable(Request $request)
    {
        $substitutions      = [];
        $timetable          = [];
        $sessionTime        = [];
        $teacherName        = "";
        $classRoomName      = "";
        $substitutionDate   = $request->get('substitution_date');
        $teacherId          = $request->get('substitution_teacher_id');
        $classRoomId        = $request->get('class_room_id');

        $timestamp      = strtotime($substitutionDate);
        $dayIndex       = (date('w', $timestamp));
        
        if(!empty($substitutionDate)) {
            $subDate = date('Y-m-d', strtotime($substitutionDate));
            $substitutions = Substitution::where('substitution_date', $subDate)->where('status', 1)
                            ->with(['combination.classRoom.standard', 'combination.classRoom.division', 'combination.subject', 'combination.teacher'])->get();

            $substitutions->keyBy('session_id');
        }
        if(!empty($teacherId) && !empty($substitutionDate)) {
            $timetable  = Timetable::where('status', 1)->whereHas('combination', function ($qry) use($teacherId) {
                            $qry->where('teacher_id', $teacherId);
                        })->whereHas('session', function ($qry) use($dayIndex) {
                            $qry->where('day_index', $dayIndex);
                        })->with(['combination.classRoom.standard', 'combination.classRoom.division', 'combination.subject'])->get();

            $selectedTeacher    = Teacher::find($teacherId);
            $teacherName    = $selectedTeacher->teacher_name;
            $classRoomName  = "";
        } elseif(!empty($classRoomId) && !empty($substitutionDate)) {
            $timetable  = Timetable::where('status', 1)->whereHas('combination', function ($qry) use($classRoomId) {
                            $qry->where('class_room_id', $classRoomId);
                        })->whereHas('session', function ($qry) use($dayIndex) {
                            $qry->where('day_index', $dayIndex);
                        })->with(['combination.classRoom.standard', 'combination.classRoom.division', 'combination.subject'])->get();
            
            $selectedclassRoom  = ClassRoom::find($classRoomId);
            $classRoomName      = $selectedclassRoom->standard->standard_name;
            $teacherName        = "";
        }

        
        $teacherCombo   = Teacher::where('status', 1)->get();
        $classRooms     = ClassRoom::where('status', 1)->with(['standard', 'division'])->get();
        $settings       = Settings::where('status', 1)->first();
        $sessions       = Session::where('status', 1)->where('day_index', $dayIndex)->get();
        $timeSessions   = SessionTime::where('status', 1)->get();

        if(!empty($settings) && !empty($settings->id)) {
            $noOfSessionPerDay  = $settings->session_per_day;
        } else {
            $noOfSessionPerDay  = 0;
        }

        foreach ($timeSessions as $key => $timeSession) {
            $sessionTime[$timeSession->session_index] = $timeSession;
        }

        return view('substitution.substituted-timetable',[
                'teacherName'       => $teacherName,
                'classRoomName'     => $classRoomName,
                'classRooms'        => $classRooms,
                'teacherId'         => $teacherId,
                'classRoomId'       => $classRoomId,
                'teacherCombo'      => $teacherCombo,
                'timetable'         => $timetable,
                'substitutionDate'  => $substitutionDate,
                'substitutions'     => $substitutions,
                'noOfSession'       => $noOfSessionPerDay,
                'sessions'          => $sessions,
                'sessionTime'       => $sessionTime,
                ]);
    }
}
