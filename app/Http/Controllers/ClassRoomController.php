<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Standard;
use App\Models\Division;
use App\Models\ClassRoom;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Combination;
use App\Http\Requests\ClassRoomRegistrationRequest;

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
        $roomNumber         = $request->get('room_number');
        $standardId         = $request->get('standard_id');
        $divisionId         = $request->get('division_id');
        $strength           = $request->get('strength');
        $teacherInchargeId  = $request->get('teacher_incharge_id');
        $subjects           = $request->get('subjects');
        $teacherId          = $request->get('teacher_id');

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
                    'subject_id'    => $subject,
                    'teacher_id'    => $teacherId[$subject],
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
                return redirect()->back()->with("message","Saved successfully")->with("alert-class","alert-success");
            } else {
                $classRoom->delete();
                return redirect()->back()->withInput()->with("message","Failed to save the class details. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
            }
        } else {
            return redirect()->back()->withInput()->with("message","Failed to save the class details. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
        }
    }

    /**
     * Return view for product listing
     */
    public function list()
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
        $className      = '';
        $combinations   = Combination::where('class_room_id', $classRoomId)->where('status', 1)->get();
        if(empty($combinations) || count($combinations) == 0) {
            session()->flash('message', 'No combinations available to show!');
        }

        $classRoom = ClassRoom::where('id', $classRoomId)->first();
        if(!empty($classRoom) && !empty($classRoom->id)) {
            $className = $classRoom->standard->standard_name. " - ". $classRoom->division->division_name;
        }
        
        return view('classroom.combination',[
            'combinations' => $combinations,
            'className'    =>  $className
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
}
