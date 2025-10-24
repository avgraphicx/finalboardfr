<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DriverController extends Controller
{
    /**
     * Display a listing of drivers.
     */
    public function index(): View
    {
        $drivers = Driver::where('created_by', Auth::id())
            ->paginate(15);

        return view('pages.drivers.index', compact('drivers'));
    }

    /**
     * Get paginated drivers data for AJAX/API requests.
     */
    public function getData(Request $request)
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $search = trim($request->get('search', ''));
        $activeOnly = $request->boolean('active_only', false);
        $offset = ($page - 1) * $limit;

        $query = Driver::query()
            ->with('createdBy')
            ->where('created_by', Auth::id());

        if ($activeOnly) {
            $query->where('active', true);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('driver_id', 'like', "%{$search}%")
                  ->orWhere('license_number', 'like', "%{$search}%")
                  ->orWhere('ssn', 'like', "%{$search}%");
            });
        }

        $total = $query->count();

        $drivers = $query->offset($offset)
            ->limit($limit)
            ->get();

        $driversFormatted = $drivers->map(function ($driver) {
            return [
                'id' => $driver->id,
                'driver_id' => $driver->driver_id,
                'full_name' => $driver->full_name,
                'license_number' => $driver->license_number,
                'ssn' => $driver->ssn,
                'active' => $driver->active,
                'default_percentage' => $driver->default_percentage,
                'default_rental_price' => $driver->default_rental_price,
                'added_by_name' => $driver->createdBy ? $driver->createdBy->full_name : 'N/A',
            ];
        });

        return response()->json([
            'data' => $driversFormatted,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
        ]);
    }

    /**
     * Show the form for creating a new driver.
     */
    public function create(): View
    {
        return view('pages.drivers.create');
    }

    /**
     * Store a newly created driver in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'driver_id' => ['required', 'string', 'max:50', Rule::unique('drivers', 'driver_id')],
            'full_name' => 'required|string|max:255',
            'license_number' => 'nullable|string|max:50',
            'ssn' => 'nullable|string|max:50',
            'default_percentage' => 'nullable|numeric|min:0|max:100',
            'default_rental_price' => 'nullable|numeric|min:0',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['active'] = true;

        Driver::create($validated);

        return redirect()->route('drivers.index')
            ->with('success', __('messages.driver_added_success') ?? 'Driver created successfully.');
    }

    /**
     * Display the specified driver.
     */
    public function show(Driver $driver): View
    {
        $invoices = $driver->invoices()
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pages.drivers.show', compact('driver', 'invoices'));
    }

    /**
     * Show the form for editing the specified driver.
     */
    public function edit(Driver $driver): View
    {
        return view('pages.drivers.edit', compact('driver'));
    }

    /**
     * Update the specified driver in storage.
     */
    public function update(Request $request, Driver $driver): RedirectResponse
    {
        $validated = $request->validate([
            'driver_id' => ['required', 'string', 'max:50', Rule::unique('drivers', 'driver_id')->ignore($driver->id)],
            'full_name' => 'required|string|max:255',
            'license_number' => 'nullable|string|max:50',
            'ssn' => 'nullable|string|max:50',
            'default_percentage' => 'nullable|numeric|min:0|max:100',
            'default_rental_price' => 'nullable|numeric|min:0',
        ]);

        $driver->update($validated);

        return redirect()->route('drivers.show', $driver)
            ->with('success', __('messages.driver_updated_success') ?? 'Driver updated successfully.');
    }

    /**
     * Remove the specified driver from storage.
     */
    public function destroy(Driver $driver): RedirectResponse
    {
        $driver->delete();

        return redirect()->route('drivers.index')
            ->with('success', __('messages.driver_deleted_success') ?? 'Driver deleted successfully.');
    }

    /**
     * Delete multiple drivers.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:drivers,id',
        ]);

        $count = Driver::destroy($request->ids);

        return response()->json([
            'success' => true,
            'message' => __('messages.drivers_deleted', ['count' => $count]) ?? "$count drivers successfully deleted.",
        ]);
    }

    /**
     * Toggle driver active status.
     */
    public function toggleActive(Driver $driver): RedirectResponse
    {
        $driver->update(['active' => !$driver->active]);

        return redirect()->back()
            ->with('success', 'Driver status updated successfully.');
    }

    /**
     * Get driver earnings for current week.
     */
    public function earnings(Driver $driver): View
    {
        $weekNumber = now()->weekOfYear;

        $invoices = $driver->invoices()
            ->where('week_number', $weekNumber)
            ->get();

        $earnings = $invoices->sum('amount_to_pay_driver');
        $totalInvoices = $invoices->count();
        $totalParcels = $invoices->sum('total_parcels');

        return view('pages.drivers.earnings', compact('driver', 'earnings', 'totalInvoices', 'totalParcels'));
    }
}
