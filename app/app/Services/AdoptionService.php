<?php

namespace App\Services;

use App\Models\Adoption;

class AdoptionService {
    
    public function getAdoptions($request) {
        $model = new Adoption();

        $adoptions = Adoption::with(['animal.media', 'adopter'])
        ->orWhereAny($model->getFillable(), 'LIKE', "%{$request->searchString}%")
        ->orWhereHas('animal', function($q) use ($request) {
            $q->where('name', 'LIKE', "%{$request->searchString}%");
        })
        ->orWhereHas('adopter', function($q) use ($request) {
            $q->where('name', 'LIKE', "%{$request->searchString}%");
        })
        ->orderBy($request->sortBy, $request->sortType)
        ->paginate($request->rows);
        
        return $adoptions;
    }

    public function getAdoptionCount() {
        return Adoption::count();
    }
}