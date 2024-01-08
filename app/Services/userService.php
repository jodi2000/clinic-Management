<?php

namespace App\Services;

use App\Http\Controllers\BaseController;
use App\Http\Requests\groupRequest;
use App\Models\file;
use App\Models\group;
use App\Models\Otp;
use App\Models\Permission;
use App\Models\User;
use App\Repository\Eloquent\GroupRepository;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class  userService extends BaseController
{
    private $userRpository;

    public function __construct(UserRepository $userRpository)
    {
        $this->userRpository = $userRpository;
    }

    public function register($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();  
        
        $otp = Otp::create([
            'user_id' => $user->id,
            'otp' => mt_rand(100000, 999999),
            'expires_at' =>now()->addMinutes(20)
        ]);

        $message = Mail::raw('FILE MANAGER', function ($message) use ($user, $otp) {
            $message->from("jodialmalt@gmail.com");
            $message->to($user->email);
            $message->subject($otp);
        });
        return $user;
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            
            return $this->sendResponse($token,'user login successullly ');
        } else {
            return $this->sendError('please validate error');
        }
    }
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
    }
    public function addGroup($request)
    {
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

        Log::channel('custom')->info('User create a group', ['user' => auth()->user()->name, 'group' => $group]);

        return $group;
    }
    public function getAllUsers()
    {
        $users=User::all();
        Log::channel('custom')->info('User fetch all contacts', ['user' => auth()->user()->name]);
        return $users;
    }

    public function users($groupId)
    {
        $group = Group::findOrFail($groupId);
        $users = $group->users()->get();        
        Log::channel('custom')->info('User fetch all groups', ['user' => auth()->user()->name, 'groups' => $group]);
        return $users;
    }

    public function files($groupId)
    {
        $group = Group::findOrFail($groupId);
        $files = $group->files()->with('user')->get();     
        Log::channel('custom')->info('User fetch all groups', ['user' => auth()->user()->name, 'groups' => $group]);
        return $files;
    }
    public function deleteUser($id)
    {
        $user=User::find($id);
        $user->delete();
        Log::channel('custom')->info('User delete a contact', ['user' => auth()->user()->name, 'user' => $user]);

    }

    public function sendOtp($userId,$otp)
    {
        $otpRecord = Otp::where('user_id', $userId)->latest()->first();

        if ($otpRecord && $otpRecord->otp === $otp && $otpRecord->expires_at > now()) {

            $user = User::find($userId);
            $user->is_verified = true;
            $user->save();

            $otpRecord->delete();

            return 'OTP is valid. User is now verified.';
        } else {

            return 'Invalid OTP. Please try again.';
        }
    }
    public function showGroup($id){
        $user = auth('sanctum')->user();
        $group = $this->groupRpository->find($id);
        $files=file::where('group_id',$id)->get();
        Log::channel('custom')->info('show info group '.$group->name, ['user' => $user->name,'Ip' => request()->ip(), 'groups' => $group]);
        return $files;
    }


}
