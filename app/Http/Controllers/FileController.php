<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileStoreRequest;
use App\Models\File;
use App\Models\Group;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FileController extends BaseController
{

    public function sendFileToGroup(FileStoreRequest $request, $groupId)
    {

        $group = Group::findOrFail($groupId);
        $path = $request->file('file')->store('files'); 
        try {
            $file = File::create([
                'path' => $path,
                'name' => $request->name,
                'status_id' => 1,
                'user_id' => Auth::id(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create file: ' . $e->getMessage()], 500);
        }
    
        // Associate the file with the group
        $group->files()->save($file);
        

        $group->files()->save($file);
        return $this->sendResponse(null,'File sent successfully');

    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByGroup($groupId)
    {
        $group = Group::with('files.user','files.status')->findOrFail($groupId);

        // Return the group's files with owners
        return response()->json($group->files, 200);    
    }
    public function reserveFile(Request $request, $fileId)
    {
        $file = File::findOrFail($fileId);

        // Begin a database transaction
        DB::beginTransaction();

        try {
            // Lock the file using shared lock
            $file = File::lockForUpdate()->findOrFail($fileId);


            // Check if the file is already reserved or taken
            if ($file->status_id !== 1) {
                return response()->json(['message' => 'File is already reserved or taken'], 400);
            }

            // Update the file status to reserved
            $file->status_id = 2;
            $file->save();
            Report::create([
                'user_id' => Auth::id(),
                'file_id' => $fileId,
                'time_in' => now(),
            ]);

            // Commit the transaction
            DB::commit();

            // Return a success response
            return response()->json(['message' => 'File reserved successfully'], 200);
        } catch (\Exception $e) {
            // Rollback the transaction in case of any exception
            DB::rollBack();

            // Handle the exception or return an error response
            return response()->json(['message' => 'Failed to reserve the file'], 500);
        }
    }


    public function returnFile(Request $request, $fileId)
    {
        $file = File::findOrFail($fileId);

        // Check if the file is reserved
        if ($file->status_id !== 2) {
            return response()->json(['message' => 'File is not currently reserved'], 400);
        }


        // Update the file status to free and remove the lock
        $file->status_id = 1;
        $file->save();

        // Update the corresponding report entry
        $report = Report::where('file_id', $file->id)->whereNull('time_out')->first();
        $report->time_out = now();
        $report->save();

        // Return a success response
        return response()->json(['message' => 'File returned successfully'], 200);
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
    public function store(Request $request)
    {
        //
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
