<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the user profile.
     */
    public function show()
    {
        $user = auth()->user();
        $requisitionsCount = 0;
        $recentRequisitions = $user->vehicleRequisitions()
            ->latest()
            ->take(5)
            ->get();

        return view('profile.show', compact('user', 'requisitionsCount', 'recentRequisitions'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'designation' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        // Log activity
        ActivityLog::log(
            'update',
            'Updated profile information',
            User::class,
            $user->id
        );

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the form for changing password.
     */
    public function editPassword()
    {
        return view('profile.password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Log activity
        ActivityLog::log(
            'update',
            'Changed password',
            User::class,
            $user->id
        );

        return redirect()->route('profile.show')
            ->with('success', 'Password changed successfully!');
    }
}