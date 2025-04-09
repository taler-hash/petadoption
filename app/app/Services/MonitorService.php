<?php

namespace App\Services;

use App\Http\Requests\CreateMonitorRequest;
use App\Models\Adoption;
use App\Models\Monitor;
use Carbon\Carbon;

class MonitorService {

    public function getMonitors($request) {
        $model = new Monitor();
        return Monitor::with(['adopter', 'animal.media', 'staff', 'shelter'])
        ->when($request->trash === 'true', function($q) {
            $q->onlyTrashed();
        })
        ->whereHas('shelter', function ($q) {
            $q->where('id', auth()->user()->shelter_id);
        })
        ->whereAny($model->getFillable(), 'LIKE', "%{$request->searchString}%")
        ->when(!empty($request?->adopter), function($q) use ($request) {
            $q->where('adopter_id', $request->adopter);
        })
        ->when($request?->animal, function($q) use ($request) {
            $q->where('animal_id', $request->animal);
        })
        ->orderBy($request->sortBy, $request->sortType) 
        ->paginate($request->rows);
    }

    public function showMonitor($request) {
        return Monitor::with(['adopter', 'animal', 'shelter'])
        ->whereHas('shelter', function ($q) {
            $q->where('id', auth()->user()->shelter_id);
        })
        ->find($request->id);
    }

    public function storeMonitor($request) {
        $fields = $request->all();
        $fields['adopter_id'] = Adoption::where('animal_id', $fields['animal_id'])->first()->id;
        $fields['date'] = Carbon::parse($request->date)->addDay()->format('Y-m-d');
        $fields['shelter_id'] = auth()->user()->shelter_id;

        Monitor::create($fields);
    }

    public function restoreMonitor($request) {
        Monitor::withTrashed()->find($request->id)->restore();
    }

    public function updateMonitor($request) {
        $monitor = Monitor::find($request->id);
        $monitor->update($request->except(['image', 'media', 'created_at', 'updated_at']));
    }

    public function deleteMonitor($request) {
        Monitor::find($request->id)->delete();
    }

    public function forceDeleteMonitor($request) {
        Monitor::withTrashed()->find($request->id)->forceDelete();
    }
}