<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Teacher;

class LeaveRegistrationRequest extends FormRequest
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
            'teacher_id.required'       => "The teacher name field is required.",
            'teacher_id.integer'        => "The teacher name field value is invalid.",
            'teacher_id.in'             => "The teacher name field value is invalid.",
            'leave_date.required'       => "The leave date field is required.",
            'leave_date.date_format'    => "The leave date field value is invalid.",
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
            'teacher_id'    => [
                                    'required',
                                    'integer',
                                    Rule::in(Teacher::pluck('id')->toArray()),
                                ],
            'leave_date'    => [
                                    'required',
                                    'date_format:d-m-Y',
                                ],
        ];
    }
}
