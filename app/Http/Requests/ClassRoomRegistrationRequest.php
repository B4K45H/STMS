<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Standard;
use App\Models\Division;
use App\Models\Teacher;
use App\Models\Subject;

class ClassRoomRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Customized error messages
     *
     */
    public function messages()
    {
        return [
            'room_number.required'          => "The room number is required.",
            'standard_id.required'          => "The standard field is required.",
            'division_id.required'          => "The division field is required.",
            'strength.required'             => "The strength field is required.",
            'teacher_incharge_id.required'  => "The class incharge field is required.",
            'subjects.*.required'           => "Something went wrong. Please try again after reloading the page.",
            'teacher_id.*.required'         => "Combinations required.",
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'room_number'           => 'required|max:20|unique:class_rooms',
            'standard_id'           => [
                                            'required',
                                            'integer',
                                            Rule::in(Standard::pluck('id')->toArray()),
                                        ],
            'division_id'           => [
                                            'required',
                                            'integer',
                                            Rule::in(Division::pluck('id')->toArray()),
                                        ],
            'strength'              => 'required|numeric|max:99',
            'teacher_incharge_id'   => [
                                            'required',
                                            'integer',
                                            Rule::in(Teacher::pluck('id')->toArray()),
                                        ],
            'subjects.*'            => [
                                            'required',
                                            'integer',
                                            Rule::in(Subject::pluck('id')->toArray()),
                                        ],
            'teacher_id.*'          => [
                                            'required',
                                            'integer',
                                            Rule::in(Teacher::pluck('id')->toArray()),
                                        ],
        ];
    }
}
