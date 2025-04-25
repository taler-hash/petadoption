<?php

namespace App\Services;

use App\Http\Requests\CreateReportRequest;
use App\Models\Adoption;
use App\Models\Report;
use Carbon\Carbon;

class ReportService {

    public function getReports($request) {
        $model = new Report();
        return Report::with(['shelter'])
        ->when($request->trash === 'true', function($q) {
            $q->onlyTrashed();
        })
        ->whereHas('shelter', function ($q) {
            $q->where('id', auth()->user()->shelter_id);
        })
        ->whereAny($model->getFillable(), 'LIKE', "%{$request->searchString}%")
        ->orderBy($request->sortBy, $request->sortType) 
        ->paginate($request->rows);
    }

    public function showReport($request) {
        return Report::with(['adopter', 'animal', 'shelter'])
        ->whereHas('shelter', function ($q) {
            $q->where('id', auth()->user()->shelter_id);
        })
        ->find($request->id);
    }

    public function storeReport($request) {
        $fields = $request->all();

        Report::create($fields);
    }

    public function restoreReport($request) {
        Report::withTrashed()->find($request->id)->restore();
    }

    public function updateReport($request) {

        $report = Report::find($request->id);
        $report->update($request->all());
    }

    public function deleteReport($request) {
        Report::find($request->id)->delete();
    }

    public function forceDeleteReport($request) {
        Report::withTrashed()->find($request->id)->forceDelete();
    }
}