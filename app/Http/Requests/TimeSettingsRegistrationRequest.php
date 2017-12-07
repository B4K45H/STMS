<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Session;

class TimeSettingsRegistrationRequest extends FormRequest
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
            'from_time.*.required'          => "The from time field is required.",
            'from_time.*.string'            => "The from time is invalid.",
            'from_time.*.size'              => "The from time is invalid.",
            'to_time.*.required'            => "The to time field is required.",
            'to_time.*.string'              => "The to time is invalid.",
            'to_time.*.size'                => "The to time is invalid.",
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
            'from_time.*'           => 'required|string|size:8',
            'to_time.*'             => 'required|string|size:8',
        ];
    }
}
