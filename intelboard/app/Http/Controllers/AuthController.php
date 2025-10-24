<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
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

        // 1. Find active user by email
        $user = User::where('email', $credentials['email'])
            ->where('active', true)
            ->first();

        // 2. Check if user exists AND password matches
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();

            // 3. Log user activity
            $user->activities()->create([
                'login_at' => now(),
                'browser' => $request->header('User-Agent'),
                'ip_address' => $request->ip(),
                'device' => $this->getDeviceType($request),
                'location' => $this->getLocation($request),
            ]);

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
                        ->where('active', true)
                        ->first();

            if ($user) {
                Auth::login($user, true);
                $this->logUserActivity($user);
                return redirect()->intended('/');
            }

            // 2. Check if user exists by email and is active (Link existing account)
            $user = User::where('email', $email)
                        ->where('active', true)
                        ->first();

            if ($user) {
                // Link Google ID to existing user
                $user->update(['google_id' => $googleId]);
                Auth::login($user, true);
                $this->logUserActivity($user);
                return redirect()->intended('/');
            }

            // 3. New user: Store details in session and redirect to registration completion
            session(['google_user' => [
                'google_id' => $googleId,
                'name' => $googleUser->getName(),
                'email' => $email
            ]]);

            return redirect()->route('register.complete');

        } catch (\Throwable $e) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('messages.invalid_credentials')]);
        }
    }

    /**
     * Log user activity for tracking.
     */
    private function logUserActivity(User $user, Request $request = null): void
    {
        $request = $request ?? request();

        $user->activities()->create([
            'login_at' => now(),
            'browser' => $request->header('User-Agent'),
            'ip_address' => $request->ip(),
            'device' => $this->getDeviceType($request),
            'location' => $this->getLocation($request),
        ]);
    }

    /**
     * Determine device type from user agent.
     */
    private function getDeviceType(Request $request): string
    {
        $userAgent = $request->header('User-Agent');

        if (strpos($userAgent, 'Mobile') !== false) {
            return 'mobile';
        } elseif (strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'iPad') !== false) {
            return 'tablet';
        }

        return 'desktop';
    }

    /**
     * Get location from IP address (basic implementation).
     */
    private function getLocation(Request $request): ?string
    {
        // This is a placeholder; in production, use GeoIP service
        return null;
    }
}
