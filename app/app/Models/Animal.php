<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Animal extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    protected $fillable = [
        'type',
        'name',
        'description',
        'age',
        'status',
        'color',
        'breed'
    ];

    /**
     * Get the appointments associated with the animal.
     */
    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }

    /**
     * Get the adoption associated with the animal.
     */
    public function adoption()
    {
        return $this->hasOne(Adoption::class);
    }
}
