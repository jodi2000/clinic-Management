<?php

namespace App\Services;

use App\Http\Controllers\BaseController;
use App\Http\Requests\groupRequest;
use App\Models\file;
use App\Models\group;
use App\Models\Permission;
use App\Models\Report;
use App\Models\User;
use App\Repository\Eloquent\GroupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class  groupService extends BaseController
{
    private $groupRpository;

    public function __construct(GroupRepository $groupRpository)
    {
        $this->groupRpository = $groupRpository;
    }

    public function addGroup($request)
    {
        $group = $this->groupRpository->create($request->toArray());
        $permissions = Permission::all();

        // Attach the current user to the group as an admin
        $group->users()->attach(auth()->user()->id, ['role' => 'admin']);
    
        // Attach all permissions to the group
        foreach ($permissions as $permission) {
            $group->permissions()->attach($permission->id);
        }

        Log::channel('custom')->info('User create a group', ['user' => auth()->user()->name, 'group' => $group]);

        return $group;
    }
    public function getAllGroups()
    {
        $user = Auth::user();
        $groups = $user->groups()->with('permissions')->get();
        Log::channel('custom')->info('User fetch all groups', ['user' => $user->name, 'groups' => $groups]);
        return $groups;
    }

    public function users($groupId)
    {
        $group = $this->groupRpository->find($groupId);
        $users = $group->users()->get();        
        Log::channel('custom')->info('User fetch all groups', ['user' => auth()->user()->name, 'groups' => $group]);
        return $users;
    }

    public function files($groupId)
    {
        $group = $this->groupRpository->find($groupId);
        $files = $group->files()->with('user')->get();     
        Log::channel('custom')->info('User fetch all groups', ['user' => auth()->user()->name, 'groups' => $group]);
        return $files;
    }
    public function deleteGroup($id)
    {
        $group = $this->groupRpository->find($id);
        $this->groupRpository->deleteGroup($group);
        Log::channel('custom')->info('User delete a group', ['user' => auth()->user()->name, 'groups' => $group]);

    }

    public function join($userId,$groupId)
    {
        $user = User::find($userId);
        $group = Group::find($groupId);
    
        if ($user && $group) {
            $user->groups()->attach($group);
            Log::channel('custom')->info('User join group', ['user' => auth()->user()->name, 'group' => $group]);

            return $this->sendResponse([], 'User joined the group successfully');
        } else {
            return $this->sendError('User or group not found');
        }
    }

    public function leave($userId,$groupId)
    {
        $user = User::find($userId);
        $group = Group::find($groupId);
    
        if ($user && $group) {
            // Check if the user is a member of the group
            if ($user->groups()->where('group_id', $group->id)->exists()) {
                // Check if the user has a file with null timeout in the group
                $fileWithNullTimeout = Report::where('group_id',$group->id)->where('user_id',$user->id)->whereNull('time_out')->exists();
    
                if (!$fileWithNullTimeout) {
                    $user->groups()->detach($group); 
                    Log::channel('custom')->info('User left group', ['user' => auth()->user()->name, 'group' => $group]);
                    return $this->sendResponse([], 'User left the group successfully');
                } else {
                    return $this->sendError('User does not have a file with null timeout in the group');
                }
            } else {
                return $this->sendError('User is not a member of the group');
            }
        } else {
            return $this->sendError('User or group not found');
        }
    }
    //
    public function showGroup($id){
        $user = auth('sanctum')->user();
        $group = $this->groupRpository->find($id);
        $files=file::where('group_id',$id)->get();
        Log::channel('custom')->info('show info group '.$group->name, ['user' => $user->name,'Ip' => request()->ip(), 'groups' => $group]);
        return $files;
    }


}
