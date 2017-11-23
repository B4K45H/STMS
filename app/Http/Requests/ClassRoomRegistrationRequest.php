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
            'room_id.required'              => "The room number field is required",
            'room_id.max'                   => "The room number field may not be greater than 20 characters.",
            'room_id.unique'                => "The room number value has already been taken.",
            'standard_id.required'          => "The standard field is required.",
            'standard_id.integer'           => "The selected standard is invalid.",
            'standard_id.in'                => "The selected standard is invalid.",
            'division_id.required'          => "The division field is required.",
            'division_id.integer'           => "The selected division is invalid.",
            'division_id.in'                => "The selected division is invalid.",
            'teacher_incharge_id.required'  => "The class incharge field is required.",
            'teacher_incharge_id.integer'   => "The selected class incharge value is invalid.",
            'teacher_incharge_id.in'        => "The selected class incharge value is invalid.",
            'teacher_id.required'           => "The subject - teacher combinations are required.",
            'teacher_id.*.required'         => "The subject - teacher combination is required.",
            'teacher_id.*.integer'          => "The subject - teacher combination is invalid.",
            'teacher_id.*.in'               => "The subject - teacher combination is invalid.",
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
            'room_id'               => 'required|max:20|unique:class_rooms',
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
            'strength'              => 'required|integer|max:99|min:09',
            'teacher_incharge_id'   => [
                                            'required',
                                            'integer',
                                            Rule::in(Teacher::pluck('id')->toArray()),
                                        ],
            'teacher_id'            => [
                                            'required'
                                        ],
            'teacher_id.*'          => [
                                            'required',
                                            'integer',
                                            Rule::in(Teacher::pluck('id')->toArray()),
                                        ],
        ];
    }
}
