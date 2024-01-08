<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Client\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function updateForm()
    {
        $envFile = base_path('.env');
        $envContent = File::get($envFile);
        return view('config.update')->with('envContent', $envContent);
    }
    public function save(Request $request)
    {
        $envFile = base_path('.env');
        $newEnvContent = $request->input('envContent');
    
        File::put($envFile, $newEnvContent);
    
        return redirect()->back()->with('success', 'Configuration updated successfully.');
    }
}
