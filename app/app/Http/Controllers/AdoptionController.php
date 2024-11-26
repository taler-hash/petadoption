<?php

namespace App\Http\Controllers;

use App\Services\AdoptionService;
use Illuminate\Http\Request;

use Inertia\Inertia;

class AdoptionController extends Controller
{
    protected $adoptionService;

    public function __construct()
    {
        $this->adoptionService = new AdoptionService();
    }
    public function index(Request $request) {
        return response()->json($this->adoptionService->getAdoptions($request));
    }

    public function display() {
        return Inertia::render('Adoption/Adoption');
    }

    public function count() {
        return response()->json($this->adoptionService->getAdoptionCount());
    }
}
