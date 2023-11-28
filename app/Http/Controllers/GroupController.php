<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupStoreRequest;
use App\Models\Group;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByUser()
    {
        $user = Auth::user();
        $groups = $user->groups()->with('permissions')->get();
        return $this->sendResponse($groups,'user groups showed successfully');    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupStoreRequest $request)
    {
        // Create a new Group instance
        $group = new Group();
        $group->name = $request->name;
        $group->save();
        $permissions = Permission::all();

        // Attach the current user to the group as an admin
        $group->users()->attach(auth()->user()->id, ['role' => 'admin']);
    
        // Attach all permissions to the group
        foreach ($permissions as $permission) {
            $group->permissions()->attach($permission->id);
        }
        return response()->json(['message' => 'Group created successfully'], 201);    
    }
    public function getGroupUsers($groupId)
    {
        $group = Group::findOrFail($groupId);
        $users = $group->users()->get();        
        return $this->sendResponse($users,'group users showed successfully');
    }

    public function getGroupFiles($groupId)
    {
        $group = Group::findOrFail($groupId);

        $files = $group->files()->with('user')->get();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        //
    }
}
