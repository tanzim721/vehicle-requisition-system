<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\VehicleRequisition;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_requisitions' => VehicleRequisition::count(),
            'pending_requisitions' => VehicleRequisition::where('status', 'pending')->count(),
            'approved_requisitions' => VehicleRequisition::where('status', 'approved')->count(),
            'rejected_requisitions' => VehicleRequisition::where('status', 'rejected')->count(),
        ];

        $recentRequisitions = VehicleRequisition::with('user', 'passengers')
            ->latest()
            ->take(10)
            ->get();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(15)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequisitions', 'recentActivities'));
    }

    /**
     * Display all requisitions.
     */
    public function requisitions(Request $request)
    {
        $query = VehicleRequisition::with('user', 'passengers');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from_date') && $request->from_date != '') {
            $query->whereDate('starting_date', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date != '') {
            $query->whereDate('starting_date', '<=', $request->to_date);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('staff_name', 'like', "%{$search}%")
                  ->orWhere('purpose', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $requisitions = $query->latest()->paginate(20);

        return view('admin.requisitions', compact('requisitions'));
    }

    /**
     * Update requisition status.
     */
    public function updateRequisitionStatus(Request $request, VehicleRequisition $requisition)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'assigned_driver' => 'nullable|string|max:255',
            'assigned_vehicle' => 'nullable|string|max:255',
        ]);

        $requisition->update($validated);

        if ($request->status === 'approved' && $request->has('assigned_driver')) {
            $requisition->update(['assigned_at' => now()]);
        }

        // Log activity
        ActivityLog::log(
            'status_update',
            "Changed requisition #{$requisition->id} status to {$request->status}",
            VehicleRequisition::class,
            $requisition->id
        );

        return back()->with('success', 'Requisition status updated successfully!');
    }

    /**
     * Display activity logs.
     */
    public function activities(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filter by action
        if ($request->has('action') && $request->action != '') {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->has('from_date') && $request->from_date != '') {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date != '') {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $activities = $query->latest()->paginate(50);

        return view('admin.activities', compact('activities'));
    }
}