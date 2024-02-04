<?php

namespace App\Services;

use App\Http\Controllers\BaseController;
use App\Http\Requests\groupRequest;
use App\Models\Appointment;
use App\Models\file;
use App\Models\group;
use App\Models\Otp;
use App\Models\Permission;
use App\Models\Specialization;
use App\Models\Status;
use App\Models\User;
use App\Repository\Eloquent\GroupRepository;
use App\Repository\Eloquent\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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
        
        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return $this->sendResponse($response,'user Registerd successully ');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            
            return $this->sendResponse($token,'user login successully ');
        } else {
            return $this->sendError('please validate error');
        }
    }
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
    }

    public function storeAppointment($data)
    {
        $data['user_id'] = Auth::id();
        $data['status_id'] = Status::where('title','pending')->first()->id;
        $appointment = Appointment::create($data);
        return $appointment;
    }
    public function getMyAppointments()
    {
        $now = Carbon::now();

        $appointments = QueryBuilder::for(Appointment::class)
            ->with(['doctor','status'])
            ->where('user_id', Auth::id())
            ->allowedFilters([
                'id',
                AllowedFilter::scope('status'),
                AllowedFilter::scope('doctor'),
                AllowedFilter::scope('specialization'),
            ])
            ->get();

        foreach ($appointments as $appointment) {
            if ($appointment->scheduled_date < $now && $appointment->status_id !== Status::where('title','expired')->first()->id) {
                $appointment->status_id = Status::where('title','expired')->first()->id;
                $appointment->save();
            }
        }

        return $appointments;
    }

    public function cancelAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->user_id !== Auth::id()) {
            return null;
        }

        if ($appointment->status_id !== Status::where('title','pending')->first()->id) {
            return null;
        }

        $appointment->status_id = Status::where('title','canceled')->first()->id;
        $appointment->save();
        
        return $appointment;
    }
    public function updateAppointmentStatus($data, $id)
    {
        $doctor = Auth::user();
        $appointment = Appointment::findOrFail($id);
    
        if ($appointment->doctor_id != $doctor->id) {
            return null;
        }
    
        if ($appointment->status_id !== Status::where('title','pending')->first()->id) {
            return null;
        }
    
        $status = $data['status'];
    
        if ($status === 'accepted') {
            $appointment->status_id = Status::where('title','accepted')->first()->id; 
        } elseif ($status === 'rejected') {
            $appointment->status_id = Status::where('title','rejected')->first()->id; 
        } else {
            return null;
        }
    
        $appointment->save();
    
        return $appointment;
    }

    
    public function getDoctorsBySpecialization($id)
    {
        $Specialization = Specialization::findOrFail($id);
        $doctors = $Specialization->doctors;

        return $doctors;
    }

}
