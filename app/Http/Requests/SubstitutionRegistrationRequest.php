<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Combination;
use App\Models\Teacher;

class SubstitutionRegistrationRequest extends FormRequest
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
            'leave_teacher_id.required' => "The absent teacher name is required.",
            'leave_teacher_id.in'       => "Something went wrong. Please try again after reloading the page..",
            'combination_id.*.integer'  => "Something went wrong. Please try again after reloading the page.",
            'combination_id.*.in'       => "Something went wrong. Please try again after reloading the page.",
            'sub_date.required'         => "The substitution date field is required.",
            'sub_date.date_format'      => "The substitution date field value is invalid.",
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
            'leave_teacher_id'  => [
                                    'required',
                                    Rule::in(Teacher::pluck('id')->toArray()),
                                    ],
            'combination_id.*'  => [
                                    'nullable',
                                    'integer',
                                    Rule::in(Combination::pluck('id')->toArray()),
                                ],
            'sub_date'          => [
                                    'required',
                                    'date_format:d-m-Y',
                                ],
        ];
    }
}
