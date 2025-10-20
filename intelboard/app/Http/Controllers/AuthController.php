<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login & Logout (Standard)
    |--------------------------------------------------------------------------
    */
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        // CHANGED: Referenced view path to match your custom structure: pages/pages/sign-in-basic.blade.php
        return view('pages.sign-in-basic');
    }

    /**
     * Handle an authentication attempt (Standard Email/Password).
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        // 1. Manually find the user and ensure status is 'active'
        $user = User::where('email', $credentials['email'])
            ->where('status', 'active')
            ->first();

        // 2. Check if user exists AND password matches
        if ($user && Hash::check($credentials['password'], $user->password)) {

            Auth::login($user, $remember);
            $request->session()->regenerate();

            // 3. Update last login timestamp
            $user->update(['last_login_at' => now()]);

            return redirect()->intended('/');
        }

        // Return generic error if login failed or user is inactive
        return back()->withErrors([
            'email' => __('messages.invalid_credentials'),
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /*
    |--------------------------------------------------------------------------
    | Google Authentication
    |--------------------------------------------------------------------------
    */
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google authentication callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = $googleUser->getEmail();
            $googleId = $googleUser->getId();

            // 1. Check if user exists by google_id and is active
            $user = User::where('google_id', $googleId)
                        ->where('status', 'active')
                        ->first();

            if ($user) {
                // User found via Google ID, log them in
                $user->update(['last_login_at' => now()]);
                Auth::login($user, true);
                return redirect()->intended('/');
            }

            // 2. Check if user exists by email and is active (Link existing account)
            $user = User::where('email', $email)
                        ->where('status', 'active')
                        ->first();

            if ($user) {
                // Existing user found via email, link Google ID and log them in
                $user->update([
                    'google_id'     => $googleId,
                    'last_login_at' => now()
                ]);
                Auth::login($user, true);
                return redirect()->intended('/');
            }

            // 3. New user: Store details in session and redirect to registration completion
            session(['google_user' => [
                'google_id' => $googleId,
                'full_name' => $googleUser->getName(),
                'email'     => $email
            ]]);

            // Redirect to the route where registration is completed (e.g., getting phone number)
            return redirect()->route('register.complete');

        } catch (\Throwable $e) {
            // If anything fails during the Google OAuth process
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('messages.invalid_credentials')]);
        }
    }
}
