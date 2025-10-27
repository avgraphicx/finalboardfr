<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\SubscriptionService;

class CheckSubscriptionLimits
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $limit): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', __('messages.please_login'));
        }

        // Check if user has an active subscription
        if (!$this->subscriptionService->hasActiveSubscription($user)) {
            return $this->handleNoSubscription($request);
        }

        // Check specific limit
        switch ($limit) {
            case 'driver':
                if (!$this->subscriptionService->canAddDriver($user)) {
                    return $this->handleDriverLimitExceeded($request);
                }
                break;

            case 'supervisor':
                if (!$this->subscriptionService->canAddSupervisor($user)) {
                    return $this->handleSupervisorNotAllowed($request);
                }
                break;

            case 'custom_invoice':
                if (!$this->subscriptionService->canCreateCustomInvoice($user)) {
                    return $this->handleCustomInvoiceNotAllowed($request);
                }
                break;

            default:
                abort(500, 'Invalid subscription limit check: ' . $limit);
        }

        return $next($request);
    }

    /**
     * Handle when user has no active subscription.
     */
    protected function handleNoSubscription(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => __('messages.subscription_required'),
                'redirect' => route('subscription.index'),
            ], 403);
        }

        return redirect()->route('subscription.index')
            ->with('error', __('messages.subscription_required'));
    }

    /**
     * Handle when driver limit is exceeded.
     */
    protected function handleDriverLimitExceeded(Request $request): Response
    {
        $driverInfo = $this->subscriptionService->getDriverLimitInfo();

        $message = __('messages.max_drivers_reached', [
            'current' => $driverInfo['current'],
            'max' => $driverInfo['max'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'error' => $message,
                'limit_info' => $driverInfo,
            ], 403);
        }

        return back()->with('error', $message);
    }

    /**
     * Handle when supervisor feature is not allowed.
     */
    protected function handleSupervisorNotAllowed(Request $request): Response
    {
        $message = __('messages.add_supervisor_not_allowed');

        if ($request->expectsJson()) {
            return response()->json([
                'error' => $message,
            ], 403);
        }

        return back()->with('error', $message);
    }

    /**
     * Handle when custom invoice feature is not allowed.
     */
    protected function handleCustomInvoiceNotAllowed(Request $request): Response
    {
        $message = __('messages.custom_invoice_not_allowed');

        if ($request->expectsJson()) {
            return response()->json([
                'error' => $message,
            ], 403);
        }

        return back()->with('error', $message);
    }
}
