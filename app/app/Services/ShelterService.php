<?

namespace App\Services;
use App\Models\Shelter;

class ShelterService {

    public function getShelters($request) {
        $model = new Shelter();
        $shelters = Shelter::when($request->trash === 'true', function($q) {
            $q->onlyTrashed();
        })
        ->with(['animals', 'staffs'])
        ->whereAny($model->getFillable(), 'LIKE', "%{$request->searchString}%")
        ->when($request?->type, function($q) use ($request) {
            $q->where('type', $request->type);
        })
        ->orderBy($request->sortBy, $request->sortType)
        ->paginate($request->rows);

        return $shelters;
    }

    public function showShelter($request) {
        return Shelter::with(['animals', 'staffs'])->find($request->id);
    }

    public function storeShelter($request) {
        Shelter::create($request->all());
    }

    public function updateShelter($request) {
        
        $shelter = Shelter::find($request->id);
        $shelter->update($request->except(['created_at', 'updated_at']));
    }

    public function deleteShelter($request) {
        Shelter::find($request->id)->delete();
    }

    public function forceDeleteShelter($request) {
        Shelter::withTrashed()->find($request->id)->forceDelete();
    }
    
    public function restoreShelter($request) {
        Shelter::withTrashed()->find($request->id)->restore();
    }

    public function getShelterCount() {
        return Shelter::count();
    }
    
}