<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Standard;
use App\Models\Settings;
use App\Http\Requests\SubjectRegistrationRequest;

class SubjectController extends Controller
{
    /**
     * Return view for subject registration
     */
    public function register()
    {
        $standards  = Standard::where('status', 1)->get();

        return view('subject.register',
            [
                'standards' => $standards,
            ]);
    }

     /**
     * Handle new subject registration
     */
    public function registerAction(SubjectRegistrationRequest $request)
    {
        $standardSubjectArr = [];
        $name               = $request->get('subject_name');
        $categoryId         = $request->get('subject_category_id');
        $description        = $request->get('description');
        $standards          = $request->get('standard');
        $noOfSessionPerWeek = $request->get('no_of_session_per_week');

        $subject = new Subject;
        $subject->subject_name  = $name;
        $subject->category_id   = $categoryId;
        $subject->description   = $description;
        $subject->status        = 1;
        if($subject->save()) {
            foreach ($standards as $key => $standard) {
                $standardSubjectArr[] = [
                    'standard_id'               => $standard,
                    'subject_id'                => $subject->id,
                    'no_of_session_per_week'    => $noOfSessionPerWeek[$standard]
                ];
            }
            if($subject->standards()->sync($standardSubjectArr)) {
                return redirect()->back()->with("message","Saved successfully")->with("alert-class","alert-success");
            } else {
                $subject->delete();
                return redirect()->back()->withInput()->with("message","Failed to save the subject details. Try again after reloading the page!")->with("alert-class","alert-danger");
            }
        } else {
            return redirect()->back()->withInput()->with("message","Failed to save the subject details. Try again after reloading the page!")->with("alert-class","alert-danger");
        }
    }

    /**
     * Return view for product listing
     */
    public function subjectList()
    {
        $subjects = Subject::where('status', 1)->with('standards')->paginate(15);
        if(empty($subjects) || count($subjects) == 0) {
            session()->flash('message', 'No subjects available to show!');
        }
        
        return view('subject.list',[
            'subjects' => $subjects
        ]);
    }

    /**
     * Return detailed view for subject
     */
    public function details($subjectId)
    {
        $subject = Subject::where('status', 1)->where('id', $subjectId)->with('standards')->first();
        
        return view('subject.details',[
            'subject' => $subject
        ]);
    }

    /**
     * Return view for subject edit
     */
    public function editSubject($subjectId)
    {
        $subject    = Subject::where('status', 1)->where('id', $subjectId)->first();
        $standards  = Standard::where('status', 1)->get();
        
        if(!empty($subject) && !empty($subject->id)) {
            return view('subject.edit', [
                    'subject'   => $subject,
                    'standards' => $standards,
                ]);
        }
        
        return redirect()->back()->with("message", "Something Went wrong, Selected record not found. Try again after reloading the page!")->with("alert-class","alert-danger");
    }

    /**
     * Handle edit subject action
     */
    public function editSubjectAction(SubjectRegistrationRequest $request)
    {
        $standardSubjectArr = [];
        $subjectId          = $request->get('subject_id');
        $name               = $request->get('subject_name');
        $categoryId         = $request->get('subject_category_id');
        $description        = $request->get('description');
        $standards          = $request->get('standard');
        $noOfSessionPerWeek = $request->get('no_of_session_per_week');

        $subject = Subject::find($subjectId);
        $subject->subject_name  = $name;
        $subject->category_id   = $categoryId;
        $subject->description   = $description;
        $subject->status        = 1;
        if($subject->save()) {
            foreach ($standards as $key => $standard) {
                $standardSubjectArr[] = [
                    'standard_id'               => $standard,
                    'subject_id'                => $subject->id,
                    'no_of_session_per_week'    => $noOfSessionPerWeek[$standard]
                ];
            }
            //invalidating the current timetable if change is made
            $settingsFlag = Settings::where('status', 1)->first();
            if(!empty($settingsFlag) && !empty($settingsFlag->id)) {
                $settingsFlag->update(['time_table_status' => 0]);
            }
            if($subject->standards()->sync($standardSubjectArr)) {
                return redirect()->back()->with("message","Updated successfully. Current timetable invalidated, due to resource change.")->with("alert-class","alert-success");
            } else {
                return redirect()->back()->withInput()->with("message","Failed to update the subject details. Try again after reloading the page!")->with("alert-class","alert-danger");
            }
        } else {
            return redirect()->back()->withInput()->with("message","Failed to update the subject details. Try again after reloading the page!")->with("alert-class","alert-danger");
        }
    }

    /**
     * Action for subject deletion
     */
    public function deleteSubject($subjectId)
    {
        $subject = Subject::where('status', 1)->where('id', $subjectId)->first();
        
        if(!empty($subject) && !empty($subject->id)) {
            $subject->subject_name  = $subject->subject_name."_deleted";
            $subject->status        = 0;
            if($subject->save()) {
                //invalidating the current timetable if major change is made
                $settingsFlag = Settings::where('status', 1)->first();
                if(!empty($settingsFlag) && !empty($settingsFlag->id)) {
                    $settingsFlag->update(['time_table_status' => 0]);
                }

                return redirect(route('subject-list'))->with("message", "Selected subject record deleted successfully.Current timetable invalidated, due to resource change.")->with("alert-class", "alert-success");
            }
        }

        return redirect()->back()->with("message", "Failed to delete the subject record. Try again after reloading the page!")->with("alert-class","alert-danger");
    }
}
