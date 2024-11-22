<?php

namespace App\Models;

use App\Observers\AppointmentObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Carbon;

#[ObservedBy([AppointmentObserver::class])]
class Appointment extends Model
{
    use HasFactory;
    
    protected $appends = [
        'parsed_appointment_date',
    ];

    protected $fillable = [
        'adopter_id',
        'animal_id',
        'appointment_date',
        'status',
    ];

    /**
     * Get the adopter who made the appointment.
     */
    public function adopter()
    {
        return $this->belongsTo(Adopter::class);
    }

    /**
     * Get the animal associated with the appointment.
     */
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function getParsedAppointmentDateAttribute() {
        return Carbon::parse($this->attributes['appointment_date'])->format('l F d, Y');
    }

    public function getCodeAttribute() {
        return base64_encode($this->attributes['code']);
    }
}
