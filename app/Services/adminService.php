<?php

namespace App\Services;

use App\Http\Controllers\BaseController;
use App\Models\Appointment;
use App\Models\Specialization;
use App\Models\Status;
use App\Models\User;
use App\Repository\Eloquent\AdminRepository;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TCG\Voyager\Models\Role;

class adminService extends BaseController
{
    private $adminRpository;

    public function __construct(AdminRepository $adminRpository)
    {
        $this->adminRpository = $adminRpository;
    }

    public function getAllUsers()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->get();
        return $users;
    }

    public function getUser($data)
    {
        $user=User::where('id',$data)->with('role:id,disply_name')->first();
        return $user;
    }
    public function storeUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return $user;
    }

    public function updateUser($data,$id)
    {
        $user = User::findOrFail($id);

        $user->update($data);
        return $user;
    }
    public function deleteUser($data)
    {
        $user=User::findOrFail($data);
        $user->delete();
        return null;
    }

    public function getAllDoctors()
    {
        $doctors = User::whereHas('role', function ($query) {
            $query->where('name', 'doctor');
        })->get();
        return $doctors;
    }

    public function getDoctor($data)
    {
        $user=User::where('id',$data)->with(['role:id,display_name','specializations:title'])->first();
        return $user;
    }
    public function storeDoctor($data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['role_id'] = 3;
        $user = User::create($data);
        $specializations = $data['specializations'];
        $user->specializations()->sync($specializations);
        return $user;
    }

    public function updateDoctor($data,$id)
    {
        $user = User::with('specializations:title')->findOrFail($id);

        if($data)
        {
            $user->update($data);
            if(isset($data['specializations']))
            {
                $user->specializations()->sync($data['specializations']);  
            }
        }

        return $user;
    }
    public function getAllSpecializations()
    {
        $specializations = Specialization::all();
    
        return $specializations;
    }
    public function getSpecialization($data)
    {
        $specialization = Specialization::findOrFail($data);

        return $specialization;
    }
    public function storeSpecialization($data)
    {
        $specialization = Specialization::create($data);
        return $specialization;
    }
    public function updateSpecialization($data,$id)
    {
        $specialization = Specialization::findOrFail($id);
        $specialization->update($data);
        return $specialization;
    }
    public function deleteSpecialization($id)
    {
        $specialization = Specialization::findOrFail($id);
        $specialization->delete();

        return null;
    }
    public function getAllAppointments()
    {
        $appointments = QueryBuilder::for(Appointment::class)
                        ->allowedFilters([
                            'id',
                            AllowedFilter::scope('status'),
                            AllowedFilter::scope('doctor'),
                            AllowedFilter::scope('user'),
                            AllowedFilter::scope('specialization'),
                        ])
                        ->get();

        return $appointments;
    }
    public function getUserAppointments($id)
    {
        $appointments = QueryBuilder::for(Appointment::class)
                        ->where('user_id',$id)
                        ->allowedFilters([
                            'id',
                            AllowedFilter::scope('status'),
                            AllowedFilter::scope('doctor'),
                            AllowedFilter::scope('specialization'),
                        ])->get();

        return $appointments;
    }
    public function storeAppointment($data)
    {
        $data['status_id'] = Status::where('title','pending')->first()->id;
        $appointment = Appointment::create($data);
        return $appointment;
    }
}
