<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileCheckinRequest;
use App\Http\Requests\FileStoreRequest;
use App\Jobs\ApiProcess;
use App\Models\File;
use App\Models\Group;
use App\Models\Report;
use App\Models\User;
use App\Services\fileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FileController extends BaseController
{
    private $fileService;
    public function __construct(fileService $fileService)
    {
        $this->fileService = $fileService;
    }


    public function sendFileToGroup(FileStoreRequest $request, $groupId)
    {
        $maxFiles = env('MAX_FILE_SEND', 20);
        if (count(auth()->user()->files) > $maxFiles) {
            return $this->sendError('You can only send a maximum of 20 files.');
        }
        
        $this->fileService->sendFile($request,$groupId);
        return $this->sendResponse(null,'File sent successfully');
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByGroup($groupId)
    {
        $group = $this->fileService->indexByGroup($groupId);
        return $this->sendResponse($group->files,'group files showed successfully');
    }

    public function checkIn(FileCheckinRequest $request)
    {
        $file = $this->fileService->checkin($request);
        return $file;
    }


    public function checkOut(Request $request, $fileId)
    {
        $file = $this->fileService->checkout($request,$fileId);
        return $file;
    }


    public function downloadReserved($fileId)
    {
        $download = $this->fileService->download($fileId);
        return $download;
    }

    public function testManyUsers($fileId)
    {
        $test = $this->fileService->multipleUsers($fileId);
        return $test;
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


}
