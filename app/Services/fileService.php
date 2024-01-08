<?php

namespace App\Services;

use App\Http\Controllers\BaseController;
use App\Http\Requests\FileRequest;
use App\Http\Requests\groupRequest;
use App\Jobs\ApiProcess;
use App\Models\file;
use App\Models\group;
use App\Models\report;
use App\Models\User;
use App\Repository\Eloquent\FileRepository;
use App\Repository\Eloquent\reportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class fileService extends BaseController
{
    private $fileRpository;
    public function __construct(FileRepository $fileRpository)
    {
        $this->fileRpository = $fileRpository;
    }

    public function sendFile($request,$groupId)
    {
        $group = Group::findOrFail($groupId);
        $path = $request->file('file')->store('files','public'); 
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
    
        $group->files()->save($file);
        Log::channel('custom')->info('User send a file', ['user' => auth()->user()->name, 'file' => $file]);

        return $file;

    }
    public function indexByGroup($groupId)
    {
        $group = Group::with('files.user','files.status')->findOrFail($groupId);
        return $group;
    }

    public function checkin($request)
    {

        $fileIds = $request->input('file_ids', []);
        $reservedFiles = [];
        DB::beginTransaction();

        try {
            foreach ($fileIds as $fileId) {
                // Lock the file using shared lock
                $file = File::lockForUpdate()->findOrFail($fileId);

                if ($file->status_id !== 1) {
                    DB::rollBack();
                    return response()->json(['message' => 'One or more files are already reserved or taken'], 400);
                }

                $file->status_id = 2;
                $file->save();

                // Store the reserved file IDs
                $reservedFiles[] = $fileId;

                Report::create([
                    'user_id' => Auth::id(),
                    'file_id' => $fileId,
                    'time_in' => now(),
                    'group_id' => $request->groupId
                ]);
                Log::channel('custom')->info('User reserved file', ['user' => auth()->user()->name, 'files' => $file ,'Ip' => request()->ip()]);

            }

            DB::commit();

            $downloadUrls = [];
            foreach ($reservedFiles as $fileId) {
                $downloadUrls[] = route('file.download.reserved', ['file' => $fileId]);
            }

            return response()->json(['message' => 'Files reserved successfully', 'download_urls' => $downloadUrls], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to reserve the files'], 500);
        }
    }

    public function checkout($request,$fileId)
    {
        $file = File::findOrFail($fileId);

        // Check if the file is reserved
        if ($file->status_id !== 2) {
            return response()->json(['message' => 'File is not currently reserved'], 400);
        }

        // file update if requested
        if ($request->has('file')) {
            $path = $request->file('file')->store('files'); 
            $file->update([
                'path'=>$path
            ]);
            $file->save();
        }
        if ($request->has('name')) {
            $file->update([
                'name'=>$request->input('name')
            ]);
            $file->save();
        }

        $file->status_id = 1;
        $file->save();


        $report = Report::where('file_id', $file->id)->whereNull('time_out')->first();
        $report->time_out = now();
        $report->save(); 
        Log::channel('custom')->info('User unreserved file', ['user' => auth()->user()->name, 'files' => $file,'Ip' => request()->ip()]);

        return response()->json(['message' => 'File returned successfully'], 200);
    }

    public function download($fileId)
    {
        $file = File::findOrFail($fileId);

        if ($file->status_id !== 2) {
            return response()->json(['message' => 'File is not reserved'], 400);
        }
        return response()->download('storage/'.$file->path, $file->name);
    }

    public function multipleUsers($fileId)
    {
        $requiredUsersCount = env('USERS_TEST', 100);
        
        $existingUsersCount = User::count();

        if ($existingUsersCount < $requiredUsersCount) {
            $usersToCreate = $requiredUsersCount - $existingUsersCount;
            User::factory()->count($usersToCreate)->create();
        }
        $users=User::all();
        $file = File::findOrFail($fileId);
        if($file->status_id==2)
        {
            return response()->json(['The file is alraedy taken']);
        }

        foreach ($users as $user) {
            ApiProcess::dispatch($user,$file);
        }        
        // Artisan::call('queue:work', ['--stop-when-empty' => true]);
        return response()->json('test work succsufully');
    }
}
