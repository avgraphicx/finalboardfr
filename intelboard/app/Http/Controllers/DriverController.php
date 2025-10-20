<?php

namespace App\Http\Controllers;

use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class DriverController extends Controller
{
    // Show all drivers
    public function index()
    {
        $drivers = Driver::where('added_by', Auth::id())->get();
        return view('pages.drivers', compact('drivers'));
    }

    // DataTables AJAX Data Source
    public function getData(Request $request)
    {
        $query = Driver::query()
            ->with('addedBy')
            ->where('added_by', Auth::id());

        return DataTables::of($query)
            ->addColumn('checkbox', function ($driver) {
                return '<input class="form-check-input select-driver-checkbox" type="checkbox" value="' . $driver->id . '" aria-label="Select Driver">';
            })
            ->addColumn('driver_name', function ($driver) {
                return '<div class="lh-1">
                            <span class="fw-bold">' . e($driver->full_name) . '</span>
                        </div>
                        <div class="lh-1">
                            <span class="fs-11 text-muted">' . e($driver->driver_id) . '</span>
                        </div>';
            })
            ->addColumn('added_by_name', function ($driver) {
                return $driver->addedBy ? e($driver->addedBy->full_name) : 'N/A';
            })
            ->addColumn('action', function ($driver) {
                return '
                    <div class="hstack gap-2 fs-15">
                        <a href="' . route('drivers.show', $driver->id) . '" class="btn btn-icon btn-sm btn-primary" title="View"><i class="ri-eye-line"></i></a>
                        <a href="javascript:void(0);" data-id="' . $driver->id . '" class="btn btn-icon btn-sm btn-warning edit-driver-btn" title="Edit"><i class="ri-edit-line"></i></a>
                        <a href="javascript:void(0);" data-id="' . $driver->id . '" class="btn btn-icon btn-sm btn-danger delete-driver-btn" title="Delete"><i class="ri-delete-bin-line"></i></a>
                    </div>';
            })
            ->editColumn('default_percentage', function ($driver) {
                return $driver->default_percentage . '%';
            })
            ->editColumn('default_rental_price', function ($driver) {
                return '$' . number_format($driver->default_rental_price, 2);
            })
            ->filterColumn('driver_name', function ($query, $keyword) {
                $query->where('full_name', 'like', "%{$keyword}%");
            })
            ->rawColumns(['checkbox', 'driver_name', 'action'])
            ->setRowId('id')
            ->make(true);
    }

    // Add a new driver
public function store(Request $request)
{
    try {
        $validatedData = $this->validateDriver($request);
        $validatedData['added_by'] = Auth::id();

        // ✅ Always set driver as active by default (1 = true)
        $validatedData['active'] = 1;

        $driver = Driver::create($validatedData);

        // ✅ Return JSON for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.driver_added_success'),
                'driver'  => $driver
            ], 201);
        }

        // Fallback for non-AJAX requests
        return redirect()
            ->route('drivers.index')
            ->with('success', __('messages.driver_added_success'));

    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation failed for driver creation', [
            'errors' => $e->errors(),
            'input'  => $request->all()
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'errors'  => $e->errors()
            ], 422);
        }

        return redirect()
            ->route('drivers.index')
            ->withErrors($e->errors());

    } catch (\Exception $e) {
        \Log::error('Unexpected error during driver creation', [
            'message' => $e->getMessage(),
            'input'   => $request->all()
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'error'   => __('messages.unexpected_error')
            ], 500);
        }

        return redirect()
            ->route('drivers.index')
            ->with('error', __('messages.unexpected_error'));
    }
}



    // Show driver details
    public function show(Driver $driver)
    {
        $driver->load('addedBy');
        return view('pages.driver', compact('driver'));
    }

    // Edit driver (used via modal)
    public function edit(Driver $driver)
    {
        return response()->json($driver);
    }

    // Update driver
    public function update(Request $request, Driver $driver)
    {
        $validatedData = $this->validateDriver($request, $driver->id);
        $driver->update($validatedData);

        // For AJAX (inline) edit, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.driver_updated_success'),
                'driver'  => $driver,
            ], 200);
        }

        return redirect()->route('drivers.index')->with('success', __('messages.driver_updated_success'));
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

    // Validation logic for driver creation and update
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
        // keep nullable to prevent validation failure
        'active' => ['nullable', 'boolean'],
    ]);
}
}
