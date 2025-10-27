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
        /** @var \App\Models\User $user */
        $user = Auth::user()->load(['subscription.subscriptionType', 'preferences']);
        $preferences = $user->preferences ?? null;

        return view('pages.profile', compact('user', 'preferences'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user()->load(['subscription.subscriptionType', 'preferences']);
        $preferences = $user->preferences ?? null;

        return view('pages.profile', compact('user', 'preferences'));
    }

    /**
     * Update the user's profile information (combined with preferences).
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'language' => 'nullable|string|in:en,fr',
            'theme' => 'nullable|string|in:light,dark',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8',
        ]);

        // Update basic user fields
        $user->full_name = $validated['full_name'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'] ?? $user->phone_number;
        $user->company_name = $validated['company_name'] ?? $user->company_name;

        // Handle logo upload (store on public disk)
        $uploadedPath = null;
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            // Keep the same format used elsewhere: store 'storage/...' so asset($user->logo) works
            $uploadedPath = 'storage/' . $path;
            $user->logo = $uploadedPath;
        }

        // Handle optional password change (if both fields provided)
        if (!empty($validated['current_password']) && !empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        // Update or create Company record associated with the user
        $companyData = [];
        if (!empty($validated['company_name'])) {
            $companyData['company_name'] = $validated['company_name'];
        }
        if (!empty($uploadedPath)) {
            $companyData['logo'] = $uploadedPath;
        }
        if (!empty($companyData)) {
            // Use user_id as the identifying attribute so updateOrCreate links the company to the user
            $user->company()->updateOrCreate(['user_id' => $user->id], array_merge($companyData, ['user_id' => $user->id]));
        }

        // Update preferences if provided
        $preferencesData = [];
        if (!empty($validated['language'])) {
            $preferencesData['language'] = $validated['language'];
        }
        if (!empty($validated['theme'])) {
            $preferencesData['theme'] = $validated['theme'];
        }

        if (!empty($preferencesData)) {
            // Ensure the preferences row is linked to this user
            $user->preferences()->updateOrCreate(['user_id' => $user->id], array_merge($preferencesData, ['user_id' => $user->id]));
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update user preferences.
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
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
        return view('pages.profile');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $activities = $user->activities()
            ->orderByDesc('login_at')
            ->paginate(15);

        return view('pages.profile', compact('activities'));
    }
}
