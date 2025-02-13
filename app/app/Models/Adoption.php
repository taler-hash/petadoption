<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adoption extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends= [
        'parsed_adoption_date'
    ];
    
    protected $fillable = [
        'adopter_id',
        'animal_id',
        'adoption_date',
    ];

    /**
     * Get the adopter who adopted the animal.
     */
    public function adopter()
    {
        return $this->belongsTo(Adopter::class);
    }

    /**
     * Get the animal associated with the adoption.
     */
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function getParsedAdoptionDateAttribute() {
        return Carbon::parse($this->attributes['adoption_date'])->format('l F d, Y');
    }
}
