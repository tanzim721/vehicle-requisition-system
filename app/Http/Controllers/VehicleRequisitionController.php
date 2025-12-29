<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\VehicleRequisition;
use Illuminate\Http\Request;

class VehicleRequisitionController extends Controller
{
    /**
     * Display a listing of user's requisitions.
     */
    public function index()
    {
        $requisitions = auth()->user()->vehicleRequisitions()
            ->with('passengers')
            ->latest()
            ->paginate(10);

        return view('requisitions.index', compact('requisitions'));
    }

    /**
     * Show the form for creating a new requisition.
     */
    public function create()
    {
        return view('requisitions.create');
    }

    /**
     * Store a newly created requisition in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'purpose' => 'required|string',
            'starting_date' => 'required|date',
            'starting_time' => 'required',
            'ending_date' => 'required|date|after_or_equal:starting_date',
            'ending_time' => 'required',
            'pickup_address' => 'required|string',
            'drop_address' => 'required|string',
            'requisition_type' => 'required|in:official,personal',
            'passengers' => 'nullable|array',
            'passengers.*' => 'nullable|string|max:255',
            'flight_no' => 'nullable|string|max:50',
            'departure_time' => 'nullable',
            'arrival_time' => 'nullable',
            'business_unit' => 'nullable|string|max:50',
            'account' => 'nullable|string|max:50',
            'contract' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:50',
            'analysis_code' => 'nullable|string|max:50',
            'project_id' => 'nullable|string|max:50',
            'project_activity' => 'nullable|string|max:50',
        ]);

        $validated['user_id'] = auth()->id();

        $requisition = VehicleRequisition::create($validated);

        // Add passengers
        if ($request->has('passengers') && is_array($request->passengers)) {
            foreach ($request->passengers as $index => $passengerName) {
                if (!empty($passengerName)) {
                    $requisition->passengers()->create([
                        'name' => $passengerName,
                        'order' => $index + 1,
                    ]);
                }
            }
        }

        // Log activity
        ActivityLog::log(
            'create',
            'Created vehicle requisition #' . $requisition->id,
            VehicleRequisition::class,
            $requisition->id
        );

        return redirect()->route('requisitions.index')
            ->with('success', 'Vehicle requisition submitted successfully!');
    }

    /**
     * Display the specified requisition.
     */
    public function show(VehicleRequisition $requisition)
    {
        // Check authorization
        if ($requisition->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $requisition->load('passengers', 'user');

        return view('requisitions.show', compact('requisition'));
    }

    /**
     * Show the form for editing the specified requisition.
     */
    public function edit(VehicleRequisition $requisition)
    {
        // Check authorization and status
        if ($requisition->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($requisition->status !== 'pending') {
            return redirect()->route('requisitions.index')
                ->with('error', 'Only pending requisitions can be edited.');
        }

        $requisition->load('passengers');

        return view('requisitions.edit', compact('requisition'));
    }

    /**
     * Update the specified requisition in storage.
     */
    public function update(Request $request, VehicleRequisition $requisition)
    {
        // Check authorization
        if ($requisition->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($requisition->status !== 'pending') {
            return redirect()->route('requisitions.index')
                ->with('error', 'Only pending requisitions can be edited.');
        }

        $validated = $request->validate([
            'staff_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'purpose' => 'required|string',
            'starting_date' => 'required|date',
            'starting_time' => 'required',
            'ending_date' => 'required|date|after_or_equal:starting_date',
            'ending_time' => 'required',
            'pickup_address' => 'required|string',
            'drop_address' => 'required|string',
            'requisition_type' => 'required|in:official,personal',
            'passengers' => 'nullable|array',
            'passengers.*' => 'nullable|string|max:255',
            'flight_no' => 'nullable|string|max:50',
            'departure_time' => 'nullable',
            'arrival_time' => 'nullable',
            'business_unit' => 'nullable|string|max:50',
            'account' => 'nullable|string|max:50',
            'contract' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:50',
            'analysis_code' => 'nullable|string|max:50',
            'project_id' => 'nullable|string|max:50',
            'project_activity' => 'nullable|string|max:50',
        ]);

        $requisition->update($validated);

        // Update passengers
        $requisition->passengers()->delete();
        if ($request->has('passengers') && is_array($request->passengers)) {
            foreach ($request->passengers as $index => $passengerName) {
                if (!empty($passengerName)) {
                    $requisition->passengers()->create([
                        'name' => $passengerName,
                        'order' => $index + 1,
                    ]);
                }
            }
        }

        // Log activity
        ActivityLog::log(
            'update',
            'Updated vehicle requisition #' . $requisition->id,
            VehicleRequisition::class,
            $requisition->id
        );

        return redirect()->route('requisitions.index')
            ->with('success', 'Vehicle requisition updated successfully!');
    }

    /**
     * Remove the specified requisition from storage.
     */
    public function destroy(VehicleRequisition $requisition)
    {
        // Check authorization
        if ($requisition->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($requisition->status !== 'pending') {
            return redirect()->route('requisitions.index')
                ->with('error', 'Only pending requisitions can be deleted.');
        }

        // Log activity
        ActivityLog::log(
            'delete',
            'Deleted vehicle requisition #' . $requisition->id,
            VehicleRequisition::class,
            $requisition->id
        );

        $requisition->delete();

        return redirect()->route('requisitions.index')
            ->with('success', 'Vehicle requisition deleted successfully!');
    }
}