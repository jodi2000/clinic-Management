<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Models\Status;
use Carbon\Carbon;

class AppointmentObserver
{

    public function saving(Appointment $appointment)
    {
        $now = Carbon::now();

        // Check if the scheduled booking date is in the past
        if ($appointment->scheduled_date < $now && $appointment->status_id !== Status::where('title','expired')->first()->id) {
            $appointment->status_id = Status::where('title','expired')->first()->id;
        }
    }
    /**
     * Handle the Appointment "created" event.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return void
     */
    public function created(Appointment $appointment)
    {
        //
    }

    /**
     * Handle the Appointment "updated" event.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return void
     */
    public function updated(Appointment $appointment)
    {
        //
    }

    /**
     * Handle the Appointment "deleted" event.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return void
     */
    public function deleted(Appointment $appointment)
    {
        //
    }

    /**
     * Handle the Appointment "restored" event.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return void
     */
    public function restored(Appointment $appointment)
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return void
     */
    public function forceDeleted(Appointment $appointment)
    {
        //
    }
}
