<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rule;
use App\Services\SubscriptionService;

class StoreDriverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var User $user */
        $user = Auth::user();

        // Determine the broker user, whether the logged-in user is the broker or a supervisor
        $brokerUser = $user->isBroker() ? $user : $user->createdBy;

        if (!$brokerUser || !$brokerUser->isBroker()) {
            // Deny if we can't find a valid broker
            return false;
        }

        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = app(SubscriptionService::class);
        if (!$subscriptionService->hasActiveSubscription($brokerUser)) {
            // Deny if the broker has no active subscription plan defined
            return false;
        }

        $limitInfo = $subscriptionService->getDriverLimitInfo($brokerUser);

        // A limit of 0 implies unlimited drivers.
        if (($limitInfo['max'] ?? 0) <= 0) {
            return true;
        }

        return ($limitInfo['current'] ?? 0) < ($limitInfo['max'] ?? 0);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'driver_id' => ['required', 'string', 'max:50', Rule::unique('drivers', 'driver_id')],
            'full_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'license_number' => 'nullable|string|max:50',
            'ssn' => 'nullable|string|max:50',
            'default_percentage' => 'nullable|numeric|min:0|max:100',
            'default_rental_price' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        $errorMessage = 'You have reached the maximum number of drivers allowed by your subscription plan. Please upgrade your plan to add more drivers.';

        // For API requests, return JSON. For web requests, throw an exception.
        if ($this->expectsJson()) {
            throw new AuthorizationException($errorMessage, 403);
        }

        throw new AuthorizationException($errorMessage);
    }
}
