<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UserLoginRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'min:6'],

        ];
    }



    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
