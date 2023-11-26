<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest as UserRegisterRequest;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{

    public function register(UserRegisterRequest $request)
    {         
        // Create a new User instance
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        // Return a response
        return $this->sendResponse($user,'user Registerd successullly ');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            
            return $this->sendResponse($token,'user Registerd successullly ');
        } else {
            return $this->sendError('please validate error');
        }
    }
    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->sendResponse(null,'logout successfully');
    }
}
