<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Services\AnimalService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnimalController extends Controller
{
    public $animalService;

    public function __construct()
    {
        $this->animalService = new AnimalService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($this->animalService->getAnimals($request));
    }
    
    public function display() {
        return Inertia::render('Animal/Animal');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAnimalRequest $request)
    {
       
        $this->animalService->storeAnimal($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return response()->json($this->animalService->showAnimal($request));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnimalRequest $request)
    {
        $this->animalService->updateAnimal($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $this->animalService->deleteAnimal($request);
    }

    public function forceDelete(Request $request) {
        $this->animalService->forceDeleteAnimal($request);
    }

    public function restore(Request $request) {
        $this->animalService->restoreAnimal($request);
    }

    public function count() {
        return response()->json($this->animalService->getAnimalCount());
    }

    public function getAdoptedAnimals(Request $request) {
        return response()->json($this->animalService->getAdoptedAnimals());
    }
}
