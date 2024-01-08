<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class FileStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $fileSizeLimitInKB = env('FILE_SIZE_LIMIT', 10240);

        return [
            'file' => ['required', 'file', 'max:' . $fileSizeLimitInKB],
            'name' => ['required', 'string'],
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
