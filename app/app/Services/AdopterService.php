<?php

namespace App\Services;

use App\Models\Adopter;

class AdopterService {
    
    public static function storeAdopter($request) {
        return Adopter::create($request->except(['animal']));
    }
}