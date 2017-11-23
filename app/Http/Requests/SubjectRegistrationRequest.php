<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Standard;

class SubjectRegistrationRequest extends FormRequest
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
            'subject_category_id.required'      => "The subject category field is required..",
            'subject_category_id.integer'       => "The selected subject category is invalid.",
            'subject_category_id.in'            => "The selected subject category is invalid.",
            'standard.required'                 => "Minimum one standard should be selected.",
            'standard.*.required'               => "Something went wrong. Please try again after reloading the page.",
            'no_of_session_per_week.*.required' => "No of sessions per week is required.",
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
            'subject_name'              => 'required|max:5|unique:subjects',
            'subject_category_id'       => [
                                                'required',
                                                'integer',
                                                Rule::in([1, 2, 3, 4, 5, 6, 7, 8, 9]),
                                            ],
            'description'               => 'nullable|max:200',
            'standard'                  => 'required',
            'standard.*'                => [
                                                'required',
                                                'integer',
                                                Rule::in(Standard::pluck('id')->toArray()),
                                            ],
            'no_of_session_per_week.*'  => [
                                                'required',
                                                'integer',
                                            ],
        ];
    }
}
