<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRegistrationRequest extends FormRequest
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
            'category_id.required'              => "The category field is required.",
            'category_id.integer'               => "The selected category id is invalid.",
            'category_id.in'                    => "The selected category id is invalid.",
            'no_of_session_per_week.required'   => "No of sessions per week is required.",
            'teacher_level.required'            => "The teaching level field is required.",
            'teacher_level.integer'             => "The teaching level field value is invalid.",
            'teacher_level.in'                  => "The teaching level field value is invalid.",
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
            'teacher_name'              => 'required|max:50|unique:teachers',
            'category_id'               => [
                                                'required',
                                                'integer',
                                                Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                                            ],
            'description'               => 'nullable|max:2',
            'no_of_session_per_week'    => [
                                                'required',
                                                'integer',
                                                'max:99'
                                            ],
            'teacher_level'                => [
                                                'required',
                                                'integer',
                                                Rule::in([1, 2, 3, 4, 5, 6, 7, 8]),
                                            ],
        ];
    }
}
