<?php

namespace App\Services;

use App\Models\Adoption;

class AdoptionService {
    
    public function getAdoptions($request) {
        $model = new Adoption();

        $adoptions = Adoption::with(['animal.media', 'adopter'])
        ->when(!empty($request?->shelter), function($q) use ($request) {
            $q->where('shelter_id', $request->shelter);
        })
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
        $shelter = auth()->user()->shelter?->id;

        return Adoption::with('animal')
        ->whereHas('animal', function($q) use ($shelter) {
            $q->when(!empty($shelter), function($q2) use ($shelter) {
                $q2->where('shelter_id', $shelter);
            });
        })->count();
    }
}