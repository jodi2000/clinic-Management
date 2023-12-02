<?php

namespace Tests\Feature;

use App\Jobs\ApiProcess;
use App\Models\File;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use Illuminate\Http\UploadedFile;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Foundation\Testing\Concerns\MocksApplicationServices;
use Illuminate\Foundation\Testing\Concerns\InteractsWithUrls;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession as InteractsWithSessionAlias;
use Illuminate\Http\Response;
use Tests\TestCase;

class UsersAccessFiles extends TestCase
{
    public function testMultipleUsersCanAccessAndUpdateFile()
    {
        $requiredUsersCount = 100;

        // Check the existing user count
        $existingUsersCount = User::count();

        // Create additional users if needed
        if ($existingUsersCount < $requiredUsersCount) {
            $usersToCreate = $requiredUsersCount - $existingUsersCount;
            User::factory()->count($usersToCreate)->create();
        }
        $users=User::all();


        $file = File::findOrFail(1);
        if($file->status_id==2)
        {
            $this->fail('The file is alraedy taken');
        }
        $usersWhoTookFile = []; 

        foreach ($users as $user) {
            ApiProcess::dispatch($user,$file);

        }


        // Assert that the file was updated by one user
        $this->assertCount(1, $usersWhoTookFile);

    }
}
