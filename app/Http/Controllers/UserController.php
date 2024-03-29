<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeAppointmentStatusRequest;
use App\Http\Requests\DeleteAppointmentRequest;
use App\Http\Requests\ListAppointmentsRequest;
use App\Http\Requests\ListDoctorsRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Status;
use App\Models\User;
use App\Services\userService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class UserController extends BaseController
{

    private $userService;
    public function __construct(userService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of my appointments.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyAppointments(ListAppointmentsRequest $request)
    {
        $appointments= $this->userService->getMyAppointments();
        return $this->sendResponse($appointments,'appointments showed successfully');    
    }
    /**
     * store a new appointment.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeAppointment(StoreAppointmentRequest $request)
    {
        $appointment= $this->userService->storeAppointment($request->validated());
        return $this->sendResponse($appointment,'appointment stored successfully');    
    }
    /**
     * cancel an appointment.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelAppointment(DeleteAppointmentRequest $request , $id)
    {
        $appointment= $this->userService->cancelAppointment($id);
        if($appointment==null)
        {
            return $this->sendError('invalid data');  
        }
        return $this->sendResponse($appointment,'appointment canceled successfully');  
    }

    /**
     * update appointment status by doctor.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAppointmentStatus(ChangeAppointmentStatusRequest $request , $id)
    {
        $appointment= $this->userService->updateAppointmentStatus($request->validated(),$id);
        if($appointment==null)
        {
            return $this->sendError('invalid data');  
        }
        return $this->sendResponse($appointment,'appointment updated successfully');  
    }

    /**
     * Display a listing of doctors by specialization.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDoctorsBySpecialization(ListDoctorsRequest $request,$id)
    {
        $specializations = $this->userService->getDoctorsBySpecialization($id);
        return $specializations;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 

    }
}
