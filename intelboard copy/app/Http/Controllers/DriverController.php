<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    // Show all drivers page
    public function index()
    {
        // Pass current driver count to view for max_drivers check
        $driversCount = Driver::where('added_by', Auth::id())->count();
        return view('pages.drivers', compact('driversCount'));
    }

    // Custom paginated AJAX endpoint
public function getData(Request $request)
{
    $page = $request->get('page', 1);
    $limit = $request->get('limit', 10);
    $search = trim($request->get('search', ''));
    $activeOnly = $request->boolean('active_only', false); // 🆕 new flag
    $offset = ($page - 1) * $limit;

    $query = Driver::query()
        ->with('addedBy')
        ->where('added_by', Auth::id());

    if ($activeOnly) {
        $query->where('active', 1);
    }

    if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where('full_name', 'like', "%{$search}%")
              ->orWhere('driver_id', 'like', "%{$search}%")
              ->orWhere('license_number', 'like', "%{$search}%")
              ->orWhere('phone_number', 'like', "%{$search}%")
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
            'full_name' => $driver->full_name,
            'driver_id' => $driver->driver_id,
            'default_percentage' => $driver->default_percentage ?? 0,
            'default_rental_price' => $driver->default_rental_price ?? 0,
            'added_by_name' => $driver->addedBy ? $driver->addedBy->full_name : 'N/A',
            'active' => $driver->active,
        ];
    });

    return response()->json([
        'data' => $driversFormatted,
        'total' => $total,
        'page' => $page,
        'limit' => $limit,
    ]);
}

    // Add a new driver
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateDriver($request);
            $validatedData['added_by'] = Auth::id();
            $validatedData['active'] = 1; // default active

            $driver = Driver::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => __('messages.driver_added_success'),
                'driver'  => $driver
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => __('messages.unexpected_error')
            ], 500);
        }
    }

    // Show driver details
    public function show(Driver $driver)
    {
        $driver->load('addedBy');
        return view('pages.driver', compact('driver'));
    }

    // Edit driver
    public function edit(Driver $driver)
    {
        return response()->json($driver);
    }

    // Update driver
    public function update(Request $request, Driver $driver)
    {
        $validatedData = $this->validateDriver($request, $driver->id);
        $driver->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => __('messages.driver_updated_success'),
            'driver'  => $driver,
        ], 200);
    }

    // Delete single driver
    public function destroy(Driver $driver)
    {
        $driver->delete();
        return response()->json(['success' => true, 'message' => __('messages.driver_deleted_success')], 200);
    }

    // Delete multiple drivers
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:drivers,id',
        ]);

        $count = Driver::destroy($request->ids);

        return response()->json([
            'success' => true,
            'message' => __(':count drivers successfully deleted.', ['count' => $count]),
        ]);
    }

    // Validation logic
    private function validateDriver(Request $request, $ignoreId = null)
    {
        return $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'driver_id' => ['required', 'string', 'max:255', Rule::unique('drivers', 'driver_id')->ignore($ignoreId)],
            'license_number' => ['nullable', 'string', 'max:255'],
            'ssn' => ['nullable', 'string', 'max:255'],
            'default_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'default_rental_price' => ['nullable', 'numeric', 'min:0'],
            'active' => ['nullable', 'boolean'],
        ]);
    }
}
