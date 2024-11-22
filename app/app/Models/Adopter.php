<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adopter extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * Get the appointments made by the adopter.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the adoptions made by the adopter.
     */
    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }
}
