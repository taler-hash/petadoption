<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shelter_id',
        'location',
        'landmark',
        'animal_status',
        'status',
        'contact_number',
    ];

    public function shelter() {
        return $this->belongsTo(Shelter::class);
    }
}
