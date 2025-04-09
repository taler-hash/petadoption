<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Track extends Model
{
    protected $fillable = [
        'status',
        'date'
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

    public function getDateAttribute() {
        return Carbon::parse($this->attributes['date'])->format('l F d, Y');
    }
}
