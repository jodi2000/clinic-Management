<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupStoreRequest;
use App\Models\Group;
use App\Models\Permission;
use App\Models\Report;
use App\Models\User;
use App\Services\groupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends BaseController
{

    private $groupService;
    public function __construct(groupService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByUser()
    {
        $groups = $this->groupService->getAllGroups();
        return $this->sendResponse($groups,'user groups showed successfully');    
    }

    public function joinGroup($userId, $groupId)
    {
        $result = $this->groupService->join($userId,$groupId);
        return $result;
    }
    public function leaveGroup($groupId, $userId)
    {
        $result = $this->groupService->leave($userId,$groupId);
        return $result;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupStoreRequest $request)
    {
        $group = $this->groupService->addGroup($request);
        return response()->json(['message' => 'Group created successfully','group'=>$group], 201);    
    }

    public function getGroupUsers($groupId)
    {
        $users = $this->groupService->users($groupId);       
        return $this->sendResponse($users,'group users showed successfully');
    }

    public function getGroupFiles($groupId)
    {
        $files = $this->groupService->files($groupId);       
        return $this->sendResponse($files,'group files showed successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->groupService->deleteGroup($id);
        return $this->sendResponse([],'group deleted successfully');

    }
}
