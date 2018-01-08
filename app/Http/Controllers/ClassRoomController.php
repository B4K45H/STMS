<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Standard;
use App\Models\Division;
use App\Models\ClassRoom;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Combination;
use App\Models\Settings;
use App\Http\Requests\ClassRoomRegistrationRequest;
use App\Http\Requests\ClassRoomUpdationRequest;

class ClassRoomController extends Controller
{
    /**
     * Return view for product registration
     */
    public function register()
    {
        $standards  = Standard::where('status', 1)->get();
        $divisions  = Division::where('status', 1)->get();
        $teachers   = Teacher::where('status', 1)->get();
        $subjects   = Subject::where('status', 1)->get();

        return view('classroom.register', [
                'standards' => $standards,
                'divisions' => $divisions,
                'teachers'  => $teachers,
                'subjects'  => $subjects
            ]);
    }

     /**
     * Handle new class room registration
     */
    public function registerAction(ClassRoomRegistrationRequest $request)
    {
        $combinationArr = [];
        $roomNumber         = $request->get('room_id');
        $standardId         = $request->get('standard_id');
        $divisionId         = $request->get('division_id');
        $strength           = $request->get('strength');
        $teacherInchargeId  = $request->get('teacher_incharge_id');        
        $teacherId          = $request->get('teacher_id');

        $uniqueFlag = ClassRoom::where('standard_id', $standardId)->where('division_id', $divisionId)->where('status', 1)->first();
        if(!empty($uniqueFlag) || !empty($uniqueFlag->id)) {
            return redirect()->back()->withInput()->with("message","Failed to save the class details. Standard - Division combination already exists!")->with("alert-class","alert-danger");
        }

        $standard = Standard::find($standardId);
        if(!empty($standard) && !empty($standard->id)) {
            $subjects = $standard->subjects;
            foreach ($subjects as $key => $subject) {
                if(empty($teacherId[$subject->id])) {
                    return redirect()->back()->withInput()->with("message","Failed to save the class details. Try again after reloading the page!")->with("alert-class","alert-danger");
                }
            }
        }

        $classRoom = new ClassRoom;
        $classRoom->standard_id = $standardId;
        $classRoom->division_id = $divisionId;
        $classRoom->room_id     = $roomNumber;
        $classRoom->strength    = $strength;
        $classRoom->incharge_id = $teacherInchargeId;
        $classRoom->status      = 1;
        if($classRoom->save()) {
            foreach ($subjects as $key => $subject) {                
                $combinationArr[] = [
                    'class_room_id' => $classRoom->id,
                    'subject_id'    => $subject->id,
                    'teacher_id'    => $teacherId[$subject->id],
                    'status'        => 1
                ];
                /*if(!empty($teacherId[$subject][2])) {
                    $combinationArr[] = [
                        'class_room_id' => $classRoom->id,
                        'subject_id'    => $subject,
                        'teacher_id'    => $teacherId[$subject][2],
                        'status'        => 1
                    ];
                }*/
            }
            if(Combination::insert($combinationArr)) {
                //invalidating the current timetable if major change is made
                $settingsFlag = Settings::where('status', 1)->first();
                if(!empty($settingsFlag) && !empty($settingsFlag->id)) {
                    $settingsFlag->update(['time_table_status' => 0]);
                }
                return redirect()->back()->with("message","Saved successfully")->with("alert-class","alert-success");
            } else {
                $classRoom->delete();
                return redirect()->back()->withInput()->with("message","Failed to save the class details. Try again after reloading the page!")->with("alert-class","alert-danger");
            }
        } else {
            return redirect()->back()->withInput()->with("message","Failed to save the class details. Try again after reloading the page!")->with("alert-class","alert-danger");
        }
    }

    /**
     * Return view for product listing
     */
    public function classRoomList()
    {
        $classRooms = ClassRoom::where('status', 1)->paginate(15);
        if(empty($classRooms) || count($classRooms) == 0) {
            session()->flash('message', 'No classes available to show!');
        }
        
        return view('classroom.list',[
            'classRooms' => $classRooms
        ]);
    }

    /**
     * Return view for combination details listing
     */
    public function combinationList($classRoomId)
    {
        $classRoom = ClassRoom::where('id', $classRoomId)->with(['combinations.subject', 'combinations.teacher'])->first();

        return view('classroom.combination',[
            'classRoom'  => $classRoom
        ]);
    }

    /**
     * Return view for combination details listing
     */
    public function getSubjectsByStandard(Request $request, $standardId)
    {
        if($request->ajax()) {
            $standard   = Standard::find($standardId);
            $teachers   = Teacher::where('status', 1)->get();
            if(!empty($standard) && !empty($standard->id)) {
                return([
                    'flag'      => true,
                    'subjects'  => $standard->subjects->toJson(),
                    'teachers'  => $teachers->toJson(),
                    ]);
            }
        }
        return([
            'flag'  => false,
            ]);
    }

    /**
     * Return view for classroom editing
     */
    public function editClassroom($classRoomId)
    {
        $teachers   = Teacher::where('status', 1)->get();
        $classRoom  = ClassRoom::where('status', 1)->where('id', $classRoomId)->first();

        if(!empty($classRoom) && !empty($classRoom->id)) {
            return view('classroom.edit', [
                    'teachers'  => $teachers,
                    'classRoom' => $classRoom
                ]);
        }

        return redirect()->back()->with("message", "Something Went wrong, Selected record not found. Try again after reloading the page!")->with("alert-class","alert-danger");
    }

    /**
     * Handle updation of class room
     */
    public function editClassroomAction(ClassRoomUpdationRequest $request)
    {
        $combinationArr = [];
        $classRoomId        = $request->get('class_room_id');
        $roomNumber         = $request->get('room_id');
        $strength           = $request->get('strength');
        $teacherInchargeId  = $request->get('teacher_incharge_id');        
        $teacherId          = $request->get('teacher_id');

        $classRoom = ClassRoom::find($classRoomId);
        if(!empty($classRoom) && !empty($classRoom->id)) {
            $subjects = $classRoom->standard->subjects;

            foreach ($subjects as $key => $subject) {
                if(empty($teacherId[$subject->id])) {

                    return redirect()->back()->withInput()->with("message","Failed to update the class details. Try again after reloading the page!")->with("alert-class","alert-danger");
                }
            }
        }

        $classRoom->room_id     = $roomNumber;
        $classRoom->strength    = $strength;
        $classRoom->incharge_id = $teacherInchargeId;
        $classRoom->status      = 1;
        if($classRoom->save()) {
            foreach ($subjects as $key => $subject) {                
                $combinationArr[] = [
                    'class_room_id' => $classRoom->id,
                    'subject_id'    => $subject->id,
                    'teacher_id'    => $teacherId[$subject->id],
                    'status'        => 1
                ];
            }
            //invalidating the current timetable if major change is made
            $settingsFlag = Settings::where('status', 1)->first();
            if(!empty($settingsFlag) && !empty($settingsFlag->id)) {
                $settingsFlag->update(['time_table_status' => 0]);
            }

            //deleting existing combinations
            Combination::where('class_room_id', $classRoom->id)->delete();

            if(Combination::insert($combinationArr)) {
                return redirect()->back()->with("message","Saved successfully")->with("alert-class","alert-success");
            } else {
                return redirect()->back()->withInput()->with("message","Failed to update the class details. Try again after reloading the page!")->with("alert-class","alert-danger");
            }
        } else {
            return redirect()->back()->withInput()->with("message","Failed to update the class details. Try again after reloading the page!")->with("alert-class","alert-danger");
        }
    }

    public function deleteClassroom($classRoomId)
    {
        $classRoom = ClassRoom::where('status', 1)->where('id', $classRoomId)->first();
        
        if(!empty($classRoom) && !empty($classRoom->id)) {
            $classRoom->status        = 0;
            if($classRoom->save()) {
                //invalidating the current timetable if major change is made
                $settingsFlag = Settings::where('status', 1)->first();
                if(!empty($settingsFlag) && !empty($settingsFlag->id)) {
                    $settingsFlag->update(['time_table_status' => 0]);
                }

                return redirect(route('subject-list'))->with("message", "Selected classroom record deleted successfully.Current timetable invalidated, due to resource change.")->with("alert-class", "alert-success");
            }
        }

        return redirect()->back()->with("message", "Failed to delete the subject record. Try again after reloading the page!")->with("alert-class","alert-danger");
    }
}
