<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Substitution;
use App\Models\Teacher;
use App\Models\Settings;
use App\Http\Requests\LeaveRegistrationRequest;

class LeaveController extends Controller
{
    /**
     * Return view for leave registration
     */
    public function leaveRegister()
    {
        $settings = Settings::where('status', 1)->where('time_table_status', 1)->first();
        $teachers   = Teacher::where('status', 1)->get();
        $leaves     = Leave::where('status', 1)->where('leave_date',">=",date('Y-m-d'))->paginate(10);

        if(empty($settings)) {
            return redirect(route('timetable-settings'))->with("message", "Settings/resources changed! Current timetable is invalid. Please regenerate timetable with new settings.")->with("alert-class", "alert-danger");
        }

        return view('substitution.leave-register', [
                'teachers'  => $teachers,
                'leaves'    => $leaves,
            ]);
    }

    /**
     * action for leave registration
     */
    public function leaveRegisterAction(LeaveRegistrationRequest $request)
    {
        $teacherId      = $request->get('teacher_id');
        $leaveDate      = $request->get('leave_date');
        $msgLeaveDate   = $leaveDate;
        $teacherName    = "";

        $leaveDate  = date('Y-m-d', strtotime($leaveDate));
        $teacher    = Teacher::find($teacherId);
        if(!empty($teacher) && !empty($teacher->id)) {
            $teacherName    = $teacher->teacher_name;
        }

        $leaveFlag  = Leave::where('leave_date', $leaveDate)->where('teacher_id', $teacherId)->first();

        if(!empty($leaveFlag) && !empty($leaveFlag->id)) {
            return redirect()->back()->withInput()->with("message","Error! Leave for the teacher, ". $teacherName. " on ". $msgLeaveDate." is already registered!")->with("alert-class","alert-danger");
        }

        $leave = new Leave;
        $leave->teacher_id  = $teacherId;
        $leave->leave_date  = $leaveDate;
        $leave->status      = 1;
        if($leave->save()) {
            return redirect()->back()->with("message","Saved successfully")->with("alert-class","alert-success");
        } else {
            return redirect()->back()->withInput()->with("message","Failed to save the leave details. Try again after reloading the page!")->with("alert-class","alert-danger");
        }
    }

    /**
     * Action for leave deletion
     */
    public function leaveDeletion(Request $request)
    {
        $leaveId      = $request->get('leave_id');
        if(!empty($leaveId)) {
            $leave = Leave::where('status', 1)->where('id', $leaveId)->first();
            if(!empty($leave) && !empty($leave->id)) {
                $substitutionDate   = $leave->leave_date;
                $leaveTeacherId     = $leave->teacher_id;

                if($leave->update(['status' => 0])) {
                    $updateSub = Substitution::where('status', 1)->where('substitution_date', $substitutionDate)
                                ->where('leave_teacher_id', $leaveTeacherId)->update(['status' => 0]);
                    return redirect(route('substitution-leave-register'))->with("message", "Leave record and related substitutions are deleted successfully.")->with("alert-class", "alert-success");
                }
            }
        }
        return redirect()->back()->with("message", "Failed to delete the leave record. Try again after reloading the page!")->with("alert-class","alert-danger");
    }
}
