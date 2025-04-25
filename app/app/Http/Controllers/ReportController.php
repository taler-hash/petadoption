<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Illuminate\Http\Request;
use App\Services\ReportService;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportController extends Controller
{
    use SoftDeletes;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ReportService $reportService)
    {
        return response()->json($reportService->getReports($request));
    }
    
    public function display(Request $request) {
        return Inertia::render('Report/Report');
    }

    public function store(CreateReportRequest $request, ReportService $reportService)
    {
        $reportService->storeReport($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, ReportService $reportService)
    {
        $reportService->updateReport($request);
    }

        /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, ReportService $reportService)
    {
        $reportService->deleteReport($request);
    }

    public function forceDelete(Request $request, ReportService $reportService) {
        $reportService->forceDeleteReport($request);
    }

    public function restore(Request $request, ReportService $reportService) {
        $reportService->restoreReport($request);
    }
}
