<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use TCG\Voyager\Models\Role;

class StoreAppointmentByAdminRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doctor_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $doctorRoleId = Role::where('name', 'doctor')->value('id');
                    $exists = User::where('id', $value)->where('role_id', $doctorRoleId)->exists();
            
                    if (!$exists) {
                        $fail('The selected doctor is not valid.');
                    }
                },
            ],
            'scheduled_date' => ['required', 'date', 'after:now'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole('admin');
    }
}
