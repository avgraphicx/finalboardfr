<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubController extends Controller
{
    /**
     * Show the subscription creation page.
     */
    public function create(Request $request)
    {
        $priceId = $request->query('price_id');

        if (!$priceId) {
            return redirect()->route('landing')->with('error', 'No subscription plan selected.');
        }

        return view('pages.subscribe', [
            'intent' => Auth::user()->createSetupIntent(),
            'price_id' => $priceId
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'price_id' => 'required|string',
        ]);

        $user = $request->user();
        $paymentMethod = $request->payment_method;
        $priceId = $request->price_id;

        try {
            $user->newSubscription('default', $priceId)->create($paymentMethod);
            return redirect()->route('index')->with('success', 'Subscription successful!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function showPricing()
    {
        return view('pages.pricing');
    }
}
