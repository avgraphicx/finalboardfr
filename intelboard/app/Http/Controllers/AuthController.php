<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('index');
        }

        return view('pages.sign-in-basic');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => __('messages.invalid_credentials'),
        ])->onlyInput('email');
    }

    /**
     * Show the registration form.
     */
    public function showRegister(Request $request)
    {
        $plan = $request->query('plan', 'bronze'); // Default to bronze
        $interval = $request->query('interval', 'monthly'); // Default to monthly

        return view('pages.sign-up-basic', compact('plan', 'interval'));
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->full_name, // Also set name for legacy compatibility
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone,
            'role' => 2, // Broker
            'active' => true,
        ]);

        Auth::login($user);

        // Now handle the subscription
        $plan = $request->input('plan', 'bronze');
        $interval = $request->input('interval', 'monthly');
        $priceId = $this->getPriceId($plan, $interval);

        if (!$priceId) {
            return redirect()->route('dashboard')->with('error', 'Invalid subscription plan selected.');
        }

        // Redirect to a dedicated subscription page
        return redirect()->route('subscribe.view', ['price_id' => $priceId]);
    }

    /**
     * Get Stripe Price ID based on plan and interval.
     * Replace with your actual Price IDs from Stripe.
     */
    private function getPriceId($plan, $interval)
    {
        $prices = config('services.stripe.prices', []);

        $normalizedInterval = match ($interval) {
            'semiannual' => 'semiannually',
            'annual' => 'yearly',
            default => $interval,
        };

        return data_get($prices, "{$plan}.{$normalizedInterval}")
            ?? data_get($prices, "{$plan}.monthly");
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
                'full_name' => $googleUser->getName(),
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
