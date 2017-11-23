<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Standard;
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
                return redirect()->back()->withInput()->with("message","Failed to save the subject details. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
            }
        } else {
            return redirect()->back()->withInput()->with("message","Failed to save the subject details. Try again after reloading the page!<small class='pull-right'> #00/00</small>")->with("alert-class","alert-danger");
        }
    }

    /**
     * Return view for product listing
     */
    public function list()
    {
        $subjects = Subject::where('status', 1)->with('standards')->paginate(15);
        if(empty($subjects) || count($subjects) == 0) {
            session()->flash('message', 'No subjects available to show!');
        }
        
        return view('subject.list',[
            'subjects' => $subjects
        ]);
    }
}
