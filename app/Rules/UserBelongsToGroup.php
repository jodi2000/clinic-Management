<?php

namespace App\Rules;

use App\Models\Group;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserBelongsToGroup implements Rule
{
    private $groupId;

    public function __construct($groupId)
    {
        $this->groupId = $groupId;
    }

    public function passes($attribute, $value)
    {
        $user = Auth::user();
        $group = Group::find($this->groupId);

        return $user && $group && $user->groups()->where('group_id', $group->id)->exists();
    }

    public function message()
    {
        return 'The user does not belong to the specified group.';
    }
}
