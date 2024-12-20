<?

namespace App\Services;
use App\Models\Animal;
use App\Services\Base64;

class AnimalService {

    public function getAnimals($request) {
        $model = new Animal();
        $animals = Animal::with(['media', 'shelter'])
        ->whereAny($model->getFillable(), 'LIKE', "%{$request->searchString}%")
        ->when(!empty($request?->shelter), function($q) use ($request) {
            $q->where('shelter_id', $request->shelter);
        })
        ->when($request?->type, function($q) use ($request) {
            $q->where('type', $request->type);
        })
        ->when($request?->status, function($q) use ($request) {
            $q->where('status', $request->status);
        })
        ->orderBy($request->sortBy, $request->sortType)
        ->paginate($request->rows);

        return $animals;
    }

    public function showAnimal($request) {
        return Animal::with(['media'])->find($request->id);
    }

    public function storeAnimal($request) {
        $animal = Animal::create($request->except(['image']));

        $animal->addMedia(Base64::convertToUploadedFile($request->image, $request->name))->toMediaCollection('animals');
    }

    public function updateAnimal($request) {
        
        $animal = Animal::find($request->id);
        $animal->update($request->except(['image', 'media', 'created_at', 'updated_at']));

        if(!empty($request->image)) {
            $animal->clearMediaCollection('animals');
            $animal->addMedia(Base64::convertToUploadedFile($request->image, $request->name))->toMediaCollection('animals');
        }
    }

    public function deleteAnimal($request) {
        Animal::find($request->id)->delete();
    }

    public function getAnimalCount() {
        $shelter = auth()->user()->shelter?->id;

        return Animal::when(!empty($shelter), function($q) use ($shelter) {
            $q->where('shelter_id', $shelter);
        })->count();
    }
    
}