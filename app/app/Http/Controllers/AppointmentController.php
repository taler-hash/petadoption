<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AppointmentService;
use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public $appointmentService;

    public function __construct()
    {
        $this->appointmentService = new AppointmentService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($this->appointmentService->getAppointments($request));
    }
    
    public function display() {
        return Inertia::render('Appointment/Appointment');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAppointmentRequest $request)
    {
        return response()->json($this->appointmentService->storeAppointment($request));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return $this->appointmentService->showAppointment($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->appointmentService->updateAppointment($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $this->appointmentService->deleteAppointment($request);
    }

    public function forceDelete(Request $request) {
        $this->appointmentService->forceDeleteAppointment($request);
    }

    public function restore(Request $request) {
        $this->appointmentService->restoreAppointment($request);
    }

    public function count(){
        return response()->json($this->appointmentService->getAppointmentCount());
    }
}
