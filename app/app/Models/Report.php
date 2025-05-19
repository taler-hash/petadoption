<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Report extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

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
