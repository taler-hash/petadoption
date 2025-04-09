<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monitor extends Model
{
    use SoftDeletes;
    
    protected $appends= [
        'parsed_date'
    ];

    protected $fillable = [
        'shelter_id',
        'user_id',
        'adopter_id',
        'animal_id',
        'feedback',
        'date'
    ];

     /**
     * Get the adopter who adopted the animal.
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

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

    public function shelter() {
        return $this->belongsTo(Shelter::class, 'shelter_id');
    }

    public function getParsedDateAttribute() {
        return Carbon::parse($this->attributes['date'])->format('l F d, Y');
    }
}
