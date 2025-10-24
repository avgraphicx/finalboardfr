<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * Show the user profile.
     */
    public function show(): View
    {
        $user = Auth::user();
        $preferences = $user->preferences ?? null;

        return view('profile.show', compact('user', 'preferences'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit(): View
    {
        $user = Auth::user();
        $preferences = $user->preferences ?? null;

        return view('profile.edit', compact('user', 'preferences'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update user preferences.
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'language' => 'required|string|in:en,fr',
            'theme' => 'required|string|in:light,dark',
        ]);

        $user->preferences()->updateOrCreate([], $validated);

        return redirect()->back()
            ->with('success', 'Preferences updated successfully.');
    }

    /**
     * Show the change password form.
     */
    public function editPassword(): View
    {
        return view('profile.edit-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('profile.show')
            ->with('success', 'Password changed successfully.');
    }

    /**
     * Show login activity history.
     */
    public function loginActivity(): View
    {
        $user = Auth::user();
        $activities = $user->activities()
            ->orderByDesc('login_at')
            ->paginate(15);

        return view('profile.login-activity', compact('activities'));
    }
}
