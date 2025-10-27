<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionLead;
use App\Models\SubscriptionType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PublicSubscriptionController extends Controller
{
    /**
     * Display the public subscription checkout page.
     */
    public function show(Request $request): View
    {
        $plans = $this->loadPlans();

        $selectedSlug = $request->query('plan');
        $selectedPlan = $plans->firstWhere('slug', $selectedSlug) ?? $plans->first();

        if (! $selectedPlan) {
            abort(404, __('messages.checkout_no_plans_available'));
        }

        return view('subscribe', [
            'plans' => $plans,
            'selectedPlan' => $selectedPlan,
        ]);
    }

    /**
     * Store a public subscription lead.
     */
    public function store(Request $request): RedirectResponse
    {
        $plans = $this->loadPlans();

        if ($plans->isEmpty()) {
            abort(404, __('messages.checkout_no_plans_available'));
        }

        $validated = $request->validate([
            'plan' => ['required', Rule::in($plans->pluck('slug')->all())],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'company' => ['nullable', 'string', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'message' => ['nullable', 'string', 'max:800'],
        ]);

        $selectedPlan = $plans->firstWhere('slug', $validated['plan']);

        SubscriptionLead::create([
            'subscription_type_id' => $selectedPlan?->id,
            'plan_slug' => $selectedPlan?->slug,
            'plan_name' => $selectedPlan?->name,
            'plan_price' => $selectedPlan?->price,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => $validated['company'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'] ?? null,
        ]);

        return redirect()
            ->route('subscriptions.checkout', ['plan' => $selectedPlan?->slug])
            ->with('status', __('messages.checkout_success'));
    }

    /**
     * Load subscription types and hydrate with helper metadata.
     *
     * @return Collection<int, \App\Models\SubscriptionType>
     */
    private function loadPlans(): Collection
    {
        return SubscriptionType::orderBy('price')
            ->get()
            ->map(function (SubscriptionType $plan) {
                $plan->slug = Str::slug($plan->name);
                $plan->is_unlimited = $plan->max_drivers === null || $plan->max_drivers >= 99999;
                $plan->formatted_price = ($plan->price && $plan->price > 0)
                    ? number_format((float) $plan->price, 2, '.', ',')
                    : null;
                $plan->feature_list = $this->buildFeatureList($plan);

                return $plan;
            });
    }

    /**
     * Build a feature list for display based on plan attributes.
     *
     * @return array<int, string>
     */
    private function buildFeatureList(SubscriptionType $plan): array
    {
        $features = [
            __('messages.weekly_statistics'),
            __('messages.dashboard_statistics'),
        ];

        if ($plan->is_unlimited) {
            $features[] = __('messages.unlimited_drivers');
        } elseif ($plan->max_drivers) {
            $features[] = trans_choice('messages.max_drivers_count', $plan->max_drivers, ['count' => $plan->max_drivers]);
        }

        if ($plan->add_supervisor) {
            $features[] = __('messages.supervisor_account');
        }

        if ($plan->custom_invoice) {
            $features[] = __('messages.custom_invoice');
        }

        return array_unique($features);
    }
}
