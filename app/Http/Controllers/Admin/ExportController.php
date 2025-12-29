<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\VehicleRequisition;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RequisitionsExport;
use App\Exports\UsersExport;

class ExportController extends Controller
{
    /**
     * Export requisitions to Excel
     */
    public function exportRequisitionsExcel(Request $request)
    {
        // Log activity
        ActivityLog::log(
            'export',
            'Exported requisitions to Excel',
            null,
            null
        );

        return Excel::download(new RequisitionsExport($request), 'vehicle-requisitions-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export users to Excel
     */
    public function exportUsersExcel(Request $request)
    {
        // Log activity
        ActivityLog::log(
            'export',
            'Exported users to Excel',
            null,
            null
        );

        return Excel::download(new UsersExport($request), 'users-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export requisitions to PDF
     */
    public function exportRequisitionsPdf(Request $request)
    {
        $query = VehicleRequisition::with('user', 'passengers');

        // Apply filters if any
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('from_date') && $request->from_date != '') {
            $query->whereDate('starting_date', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date != '') {
            $query->whereDate('starting_date', '<=', $request->to_date);
        }

        $requisitions = $query->latest()->get();

        // Log activity
        ActivityLog::log(
            'export',
            'Exported requisitions to PDF',
            null,
            null
        );

        $pdf = Pdf::loadView('exports.requisitions-pdf', compact('requisitions'));
        return $pdf->download('vehicle-requisitions-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export single requisition to PDF
     */
    public function exportSingleRequisitionPdf(VehicleRequisition $requisition)
    {
        $requisition->load('user', 'passengers');

        // Log activity
        ActivityLog::log(
            'export',
            "Exported requisition #{$requisition->id} to PDF",
            VehicleRequisition::class,
            $requisition->id
        );

        $pdf = Pdf::loadView('exports.single-requisition-pdf', compact('requisition'));
        return $pdf->download('requisition-' . $requisition->id . '-' . date('Y-m-d') . '.pdf');
    }
}