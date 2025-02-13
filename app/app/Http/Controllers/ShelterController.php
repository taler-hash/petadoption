<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShelterRequest;
use App\Http\Requests\UpdateShelterRequest;
use App\Services\ShelterService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShelterController extends Controller
{
    public $shelterService;

    public function __construct()
    {
        $this->shelterService = new ShelterService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($this->shelterService->getShelters($request));
    }
    
    public function display() {
        return Inertia::render('Shelter/Shelter');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateShelterRequest $request)
    {
       
        $this->shelterService->storeShelter($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return response()->json($this->shelterService->showShelter($request));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShelterRequest $request)
    {
        $this->shelterService->updateShelter($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $this->shelterService->deleteShelter($request);
    }

    public function restore(Request $request) {
        $this->shelterService->restoreShelter($request);
    }

    public function forceDelete(Request $request) {
        $this->shelterService->forceDeleteShelter($request);
    }

    public function count() {
        return response()->json($this->shelterService->getShelterCount());
    }
}
