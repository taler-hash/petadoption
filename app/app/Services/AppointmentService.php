<?php

namespace App\Services;
use App\Traits\Integrity;
use App\Models\Appointment;
use App\Models\Animal;
use App\Models\Adopter;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class AppointmentService {
    use Integrity;

    public function getAppointments($request) {
        $model = new Appointment();

        $appointments = Appointment::when($request->trash === 'true', function($q) {
            $q->onlyTrashed();
        })
        ->with(['animal.media', 'animal.shelter', 'adopter'])
        ->whereAny($model->getFillable(), 'LIKE', "%{$request->searchString}%")
        ->when(!empty($request?->shelter), function($q) use ($request) {
            $q->where('shelter_id', $request->shelter);
        })
        ->orWhereHas('animal', function ($query) use ($request) {
            $query->where('name', 'LIKE', "%{$request->searchString}%");
        })
        ->orWhereHas('adopter', function ($query) use ($request) {
            $query->where('name', 'LIKE', "%{$request->searchString}%");
        })
        ->orderBy($request->sortBy, $request->sortType)
        ->paginate($request->rows);
        
        return $appointments;
    }

    public function storeAppointment($request) {
        return $this->checkIntegrity(Animal::class, $this->createRequest($request->animal), function () use ($request) {
            $adopter = AdopterService::storeAdopter($request);
            $animal = Animal::find($request->animal['id']);
            
            $appointment = Appointment::create([
                'adopter_id' => $adopter->id,
                'animal_id' => $animal->id,
                'status' => 'pending',
                'appointment_date' => Carbon::parse($request->appointment_date)->addDay()->format('Y-m-d')
            ]);

            return base64_encode($appointment->id);
        }, ['integrity' => true, 'exist' => true, ]);
    }

    public function showAppointment($request) {
        $id = base64_decode($request->code);
        if(!$id){
            return response()->json(['code' => 'code not valid'], 422);
        } else {
            $id = base64_decode($request->code);
            return response()->json(Appointment::with(['animal.media', 'animal.shelter','adopter'])->find($id));
        }
    }

    public function updateAppointment($request) {
        $this->checkIntegrity(Appointment::class, $request, function() use ($request) {
            Appointment::find($request->id)->update($request->only(['status']));
        }, ['integrity' => true, 'exist' => true, 'toExcludeInputs' => ['status']]);
    }

    public function deleteAppointment($request) {
        $appointment = Appointment::find($request->id)->first();
        $this->checkIntegrity(Appointment::class, $this->createRequest($appointment), function() use ($request) {
            Appointment::find($request->id)->delete();
        }, ['integrity' => true, 'exist' => true]);
    }

    public function restoreAppointment($request) {
        $appointment = Appointment::find($request->id)->first();
        $this->checkIntegrity(Appointment::withTrashed(), $this->createRequest($appointment), function() use ($request) {
            Appointment::withTrashed()->find($request->id)->restore();
        }, ['integrity' => true, 'exist' => true]);
    }

    public function forceDeleteAppointment($request) {
        $appointment = Appointment::find($request->id)->first();
        $this->checkIntegrity(Appointment::withTrashed(), $this->createRequest($appointment), function() use ($request) {
            Appointment::withTrashed()->find($request->id)->forceDelete();
        }, ['integrity' => true, 'exist' => true]);
    }

    private function createRequest($object) {
        return Request::create(
            '/animals/store',
            'POST',
            (array) $object
        );
    }

    public function getAppointmentCount() {
        $shelter = auth()->user()->shelter?->id;

        return Appointment::with('animal')
        ->whereHas('animal', function($q) use ($shelter) {
            $q->when(!empty($shelter), function($q2) use ($shelter) {
                $q2->where('shelter_id', $shelter);
            });
        })
        ->count();
    }
}