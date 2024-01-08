<?php

namespace App\Http\Requests;

use App\Rules\UserBelongsToGroup;
use Illuminate\Foundation\Http\FormRequest;


class FileCheckinRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'groupId' => ['required', new UserBelongsToGroup($this->input('groupId'))],
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
