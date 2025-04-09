<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TrackService;
use Inertia\Inertia;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, TrackService $trackService)
    {
        return response()->json($trackService->getTracks($request));
    }
    
    public function display() {
        return Inertia::render('Track/Track');
    }
}
