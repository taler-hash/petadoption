<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Models\Animal;
use App\Models\Adoption;
use Illuminate\Support\Carbon;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        Animal::find($appointment->animal_id)->update(['status' => 'pending']);
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment): void
    {
        if($appointment->status === 'completed') {
            Adoption::create([
                'adopter_id' => $appointment->adopter_id,
                'animal_id' => $appointment->animal_id,
                'adoption_date' => Carbon::now()
            ]);

            Animal::find($appointment->animal_id)->update(['status' => 'adopted']);
        } else if ($appointment->status === 'cancelled') {
            Animal::find($appointment->animal_id)->update(['status' => 'available']);
        }
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}
