<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'string', Rule::unique('users')->ignore($this->id)],
            'password' => ['sometimes', 'min:6'],
            'specializations' => ['sometimes', 'array', 'min:1'], 
            'specializations.*' => ['required', 'exists:specializations,id'],
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
