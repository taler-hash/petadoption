<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMonitorRequest;
use Illuminate\Http\Request;
use App\Services\MonitorService;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitorController extends Controller
{

    use SoftDeletes;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MonitorService $monitorService)
    {
        return response()->json($monitorService->getMonitors($request));
    }
    
    public function display(Request $request) {
        return Inertia::render('Monitor/Monitor');
    }

    public function store(CreateMonitorRequest $request, MonitorService $monitorService)
    {
        $monitorService->storeMonitor($request);
    }

        /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, MonitorService $monitorService)
    {
        $monitorService->deleteMonitor($request);
    }

    public function forceDelete(Request $request, MonitorService $monitorService) {
        $monitorService->forceDeleteMonitor($request);
    }

    public function restore(Request $request, MonitorService $monitorService) {
        $monitorService->restoreMonitor($request);
    }
}
