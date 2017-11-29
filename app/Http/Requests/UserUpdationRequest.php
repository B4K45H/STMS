<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class UserUpdationRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|max:200',
            'email'                 => [
                                            'nullable',
                                            'email',
                                            'max:145',
                                            Rule::unique('users')->ignore(Auth::User()->id),
                                        ],

            'password'              => 'required|min:6|max:25|confirmed',
        ];
    }
}
