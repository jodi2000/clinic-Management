<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\ListAppointmentsRequest;
use App\Http\Requests\ListDoctorsRequest;
use App\Http\Requests\ListUsersRequest;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\StoreSpecializationRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Requests\UpdateSpecializationRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\adminService;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    private $adminService;
    public function __construct(adminService $adminService)
    {
        $this->adminService = $adminService;
    }
    public function getAllUsers(ListUsersRequest $request)
    {
        $users = $this->adminService->getAllUsers();
        return $this->sendResponse($users,'users showed successfully'); 
    }
    public function getUser(ListUsersRequest $request,$id)
    {
        $user = $this->adminService->getUser($id);
        return $this->sendResponse($user,'user showed successfully'); 
    }
    public function getAllDoctors(ListDoctorsRequest $request)
    {
        $doctors = $this->adminService->getAllDoctors();
        return $this->sendResponse($doctors,'doctors showed successfully'); 
    }
    public function getDoctor(ListDoctorsRequest $request,$id)
    {
        $doctor = $this->adminService->getDoctor($id);
        return $this->sendResponse($doctor,'doctor showed successfully'); 
    }
    public function storeUser(StoreUserRequest $request)
    {
        $user = $this->adminService->storeUser($request->validated());
        return $this->sendResponse($user,'user stored successfully'); 
    }
    public function updateUser(UpdateUserRequest $request,$id)
    {
        $user = $this->adminService->updateUser($request->validated(),$id);
        return $this->sendResponse($user,'user updated successfully'); 
    }
    public function updateDoctor(UpdateDoctorRequest $request,$id)
    {
        $doctor = $this->adminService->UpdateDoctor($request->validated(),$id);
        return $this->sendResponse($doctor,'doctor updated successfully'); 
    }

    //used for all roles
    public function deleteUser(DeleteUserRequest $request,$id)
    {
        $user = $this->adminService->deleteUser($id);
        return $this->sendResponse($user,'user deleted successfully'); 
    }
    public function getAllSpecializations(Request $request)
    {
        $Specializations = $this->adminService->getAllSpecializations();
        return $this->sendResponse($Specializations,'Specializations showed successfully'); 
    }
    public function getSpecialization(Request $request,$id)
    {
        $Specialization = $this->adminService->getSpecialization($id);
        return $this->sendResponse($Specialization,'Specialization showed successfully'); 
    }
    public function storeSpecialization(StoreSpecializationRequest $request)
    {
        $Specialization = $this->adminService->storeSpecialization($request->validated());
        return $this->sendResponse($Specialization,'Specialization stored successfully'); 
    }
    public function updateSpecialization(UpdateSpecializationRequest $request, $id)
    {
        $Specialization = $this->adminService->updateSpecialization($request->validated(),$id);
        return $this->sendResponse($Specialization,'Specialization updated successfully'); 
    }
    public function deleteSpecialization(UpdateSpecializationRequest $request, $id)
    {
        $Specialization = $this->adminService->deleteSpecialization($id);
        return $this->sendResponse($Specialization,'Specialization deleted successfully'); 
    }

    public function getAllAppointments(ListAppointmentsRequest $request)
    {
        $Appointments = $this->adminService->getAllAppointments();
        return $this->sendResponse($Appointments,'Appointments showed successfully'); 
    }
    public function getUserAppointments(ListAppointmentsRequest $request, $id)
    {
        $Appointments = $this->adminService->getUserAppointments($id);
        return $this->sendResponse($Appointments,'Appointments showed successfully'); 
    }
    public function storeAppointmentByAdmin(ListAppointmentsRequest $request)
    {
        $Appointment = $this->adminService->storeAppointment($request->validated());
        return $this->sendResponse($Appointment,'Appointment stored successfully'); 
    }
}
