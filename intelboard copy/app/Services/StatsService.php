<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class StatsService
{
    /**
     * Collect dashboard statistics for the given broker.
     *
     * @param  object  $broker
     * @return array
     */
    public function getDashboardStats($broker): array
    {
        // Drivers belonging to this broker
        $drivers   = Driver::where('added_by', $broker->user_id);
        $driverIds = $drivers->pluck('id');

        // Payments for those drivers
        $payments = Payment::whereIn('driver_id', $driverIds);

        // ===== TOP DRIVER BY DAYS (parcel_rows_count) =====
        $topRows = Payment::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->select('driver_id', DB::raw('SUM(parcel_rows_count) AS total_rows'))
            ->groupBy('driver_id')
            ->orderByDesc('total_rows')
            ->first();

        $topDriver = null;
        if ($topRows && $topRows->driver) {
            $topDriver = [
                'driver_id'   => $topRows->driver_id,
                'total_rows'  => $topRows->total_rows,
                'driver'      => $topRows->driver,
            ];
        }

        // ===== TOP DRIVER BY INT INV (total_invoice) =====
        $topInv = Payment::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->select('driver_id', DB::raw('SUM(total_invoice) AS total_invoice'))
            ->groupBy('driver_id')
            ->orderByDesc('total_invoice')
            ->first();

        $topDriverInt = null;
        if ($topInv && $topInv->driver) {
            $topDriverInt = [
                'driver_id'     => $topInv->driver_id,
                'total_invoice' => $topInv->total_invoice,
                'driver'        => $topInv->driver,
            ];
        }

        // ===== TOP DRIVER BY BROKER EARNINGS (final_amount) =====
        $topOwn = Payment::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->select('driver_id', DB::raw('SUM(final_amount) AS final_amount'))
            ->groupBy('driver_id')
            ->orderByDesc('final_amount')
            ->first();

        $topDriverOwn = null;
        if ($topOwn && $topOwn->driver) {
            $topDriverOwn = [
                'driver_id'    => $topOwn->driver_id,
                'final_amount' => $topOwn->final_amount,
                'driver'       => $topOwn->driver,
            ];
        }

        // ===== TOP DRIVER BY PARCELS (total_parcels) =====
        $topParcels = Payment::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->select('driver_id', DB::raw('SUM(total_parcels) AS total_parcels'))
            ->groupBy('driver_id')
            ->orderByDesc('total_parcels')
            ->first();

        $topDriverParcels = null;
        if ($topParcels && $topParcels->driver) {
            $topDriverParcels = [
                'driver_id'      => $topParcels->driver_id,
                'total_parcels'  => $topParcels->total_parcels,
                'driver'         => $topParcels->driver,
            ];
        }

        $totalDrivers = $drivers->count();
        $activeCount  = $drivers->where('active', 1)->count();

        return [
            // ===== DRIVERS =====
            'total_drivers'               => $totalDrivers,
            'active_drivers'              => $activeCount,
            // Drivers missing SSN or license
            'drivers_missing_ssn'         => Driver::where('added_by', $broker->user_id)->whereNull('ssn')->count(),
            'drivers_missing_license'     => Driver::where('added_by', $broker->user_id)->whereNull('license_number')->count(),
            'active_driver_percentage' => $totalDrivers > 0
                ? round(($activeCount / $totalDrivers) * 100, 1)
                : 0,
            'avg_rental_price'         => round($drivers->avg('default_rental_price'), 2),
            // Drivers missing any key info (SSN or license)
            'drivers_missing_info'         => Driver::where('added_by', $broker->user_id)
                ->where(function ($q) {
                    $q->whereNull('ssn')
                      ->orWhereNull('license_number');
                })
                ->count(),

            // ===== PAYMENTS =====
            'total_payments'            => $payments->count(),
            'unpaid_invoices'            => $payments->where('paid', 0)->count(),
            'total_invoice_amount'      => round($payments->sum('total_invoice'), 2),
            'total_final_amount'        => round($payments->sum('final_amount'), 2),
            'total_parcels'             => (int) $payments->sum('total_parcels'),
            'avg_final_amount'          => round($payments->avg('final_amount'), 2),
            'total_broker_earnings'     => round(
                $payments->sum('broker_van_cut') + $payments->sum('broker_pay_cut'),
                2
            ),
            'avg_broker_percentage'     => $payments->count() > 0
                ? round($payments->avg('broker_percentage'), 2)
                : 0,
            'avg_vehicule_rental_price' => $payments->count() > 0
                ? round($payments->avg('vehicule_rental_price'), 2)
                : 0,
            'unpaid_payments'           => $payments->where('paid', 0)->count(),
            'paid_payments'             => $payments->where('paid', 1)->count(),
            // ===== BROKER EARNINGS BY WEEK =====
            'broker_earnings_by_week'   => Payment::whereIn('driver_id', $driverIds)
                                            ->select('week_number', DB::raw('SUM(total_invoice - final_amount) as earnings'))
                                            ->groupBy('week_number')
                                            ->orderBy('week_number')
                                            ->get()
                                            ->toArray(),

            // ===== TOP DRIVERS =====
            'top_driver'         => $topDriver,
            'top_driver_parcels' => $topDriverParcels,
            'top_driver_int'     => $topDriverInt,
            'top_driver_own'     => $topDriverOwn,
        ];
    }
}
