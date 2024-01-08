<?php

namespace App\Jobs;

use App\Models\File;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $file;
    protected $usersWhoTookFile;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param File $file
     */
    public function __construct(User $user, File $file)
    {
        $this->user = $user;
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token=$this->user->createToken('token')->plainTextToken;
        $body = [
            'file_ids' => [$this->file->id],
        ];
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->withBody(json_encode($body), 'application/json')
          ->post('http://localhost:8000/api/files/check-in');

        if (!$response->successful()) {
            $responseBody = $response->body();
            Log::error('API call failed with message: ' . $responseBody);
        }
        else
        {             
            $this->usersWhoTookFile= $this->user->id;
        }

    }
}