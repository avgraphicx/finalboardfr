<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class StatsService
{
    /**
     * Collect dashboard statistics for the given broker.
     */
    public function getDashboardStats($broker)
    {
        // Drivers belonging to this broker
        $drivers = Driver::where('added_by', $broker->user_id);
        $driverIds = $drivers->pluck('id');

        // Payments for those drivers
        $payments = Payment::whereIn('driver_id', $driverIds);

        // ===== TOP DRIVER BY DAYS (parcel_rows_count) =====
        $top = Payment::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->select('driver_id', DB::raw('SUM(parcel_rows_count) as total_rows'))
            ->groupBy('driver_id')
            ->orderByDesc('total_rows')
            ->first();
        $topDriver = null;
        if ($top && $top->driver) {
            $topDriver = [
                'driver_id' => $top->driver_id,
                'total_rows' => $top->total_rows,
                'driver' => $top->driver,
            ];
        }
        // ===== TOP DRIVER BY Moneymade Intel =====
        $top = Payment::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->select('driver_id', DB::raw('SUM(total_invoice) as total_invoice'))
            ->groupBy('driver_id')
            ->orderByDesc('total_invoice')
            ->first();
        $topDriverInt = null;
        if ($top && $top->driver) {
            $topDriverInt = [
                'driver_id' => $top->driver_id,
                'total_invoice' => $top->total_invoice,
                'driver' => $top->driver,
            ];
        }
        // ===== TOP DRIVER BY Moneymade broker =====
        $top = Payment::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->select('driver_id', DB::raw('SUM(final_amount) as final_amount'))
            ->groupBy('driver_id')
            ->orderByDesc('final_amount')
            ->first();
        $topDriverOwn = null;
        if ($top && $top->driver) {
            $topDriverOwn = [
                'driver_id' => $top->driver_id,
                'final_amount' => $top->final_amount,
                'driver' => $top->driver,
            ];
        }
        // ===== TOP DRIVER BY PARCELS =====
        $topParcels = Payment::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->select('driver_id', DB::raw('SUM(total_parcels) as total_parcels'))
            ->groupBy('driver_id')
            ->orderByDesc('total_parcels')
            ->first();
        $topDriverParcels = null;
        if ($topParcels && $topParcels->driver) {
            $topDriverParcels = [
                'driver_id' => $topParcels->driver_id,
                'total_parcels' => $topParcels->total_parcels,
                'driver' => $topParcels->driver,
            ];
        }
        return [
            // ===== DRIVERS =====
            'total_drivers' => $drivers->count(),
'active_drivers' => $drivers->where('active', 1)->count(),
'missing_ssn' => $drivers->where('ssn', null)->count(),
'active_driver_percentage' => $drivers->count() > 0
    ? round(($drivers->where('active', 1)->count() / $drivers->count()) * 100, 1)
    : 0,
            'avg_rental_price' => round($drivers->avg('default_rental_price'), 2),
            'drivers_missing_info' => Driver::where('added_by', $broker->user_id)
                ->where(function ($q) {
                    $q->whereNull('ssn')->orWhereNull('license_number');
                })->count(),

            // ===== PAYMENTS =====
            'total_payments' => $payments->count(),
            'total_invoice_amount' => round($payments->sum('total_invoice'), 2),
            'total_final_amount' => round($payments->sum('final_amount'), 2),
            'total_parcels' => (int) $payments->sum('total_parcels'),
            'avg_final_amount' => round($payments->avg('final_amount'), 2),
            'total_broker_earnings' => round(
                $payments->sum('broker_van_cut') + $payments->sum('broker_pay_cut'),
                2
            ),
            // Average broker percentage across payments (0 if no payments)
            'avg_broker_percentage' => $payments->count() > 0 ? round($payments->avg('broker_percentage'), 2) : 0,
            // Average vehicule rental price across payments
            'avg_vehicule_rental_price' => $payments->count() > 0 ? round($payments->avg('vehicule_rental_price'), 2) : 0,
            'unpaid_payments' => $payments->where('paid', 0)->count(),
            'paid_payments' => $payments->where('paid', 1)->count(),

            // ===== TOP DRIVER BY DAYS =====
            'top_driver' => $topDriver,
            // ===== TOP DRIVER BY PARCELS =====
            'top_driver_parcels' => $topDriverParcels,
            // ===== TOP DRIVER BY INT INV =====
            'top_driver_int' => $topDriverInt,
            'top_driver_own' => $topDriverOwn,
        ];
    }
}
