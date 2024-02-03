<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest as UserRegisterRequest;
use App\Models\User;
use App\Services\userService;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    private $userService;
    public function __construct(userService $userService)
    {
        $this->userService = $userService;
    }
    public function register(UserRegisterRequest $request)
    {         
        $user = $this->userService->register($request);
        return $user;
    }
    
    public function login(UserLoginRequest $request)
    {
        $user = $this->userService->login($request);
        return $user;
    }
    public function logout(Request $request)
    {
        $this->userService->logout();
        return $this->sendResponse(null,'logout successfully');
    }

}
