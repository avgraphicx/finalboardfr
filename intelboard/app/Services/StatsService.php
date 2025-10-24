<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Invoice;
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
        // Drivers belonging to this broker (created_by field in new schema)
        $drivers   = Driver::where('created_by', $broker->id);
        $driverIds = $drivers->pluck('id');

        // Invoices for those drivers
        $invoices = Invoice::whereIn('driver_id', $driverIds);

        // ===== TOP DRIVER BY DAYS (days_worked) =====
        $topRows = Invoice::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->select('driver_id', DB::raw('SUM(days_worked) AS total_rows'))
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

        // ===== TOP DRIVER BY INT INV (invoice_total) =====
        $topInv = Invoice::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->select('driver_id', DB::raw('SUM(invoice_total) AS total_invoice'))
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

        // ===== TOP DRIVER BY BROKER EARNINGS (amount_to_pay_driver) =====
        $topOwn = Invoice::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->select('driver_id', DB::raw('SUM(amount_to_pay_driver) AS final_amount'))
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
        $topParcels = Invoice::with('driver')
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
            'drivers_missing_ssn'         => Driver::where('created_by', $broker->id)->whereNull('ssn')->count(),
            'drivers_missing_license'     => Driver::where('created_by', $broker->id)->whereNull('license_number')->count(),
            'active_driver_percentage' => $totalDrivers > 0
                ? round(($activeCount / $totalDrivers) * 100, 1)
                : 0,
            'avg_rental_price'         => round($drivers->avg('default_rental_price'), 2),
            // Drivers missing any key info (SSN or license)
            'drivers_missing_info'         => Driver::where('created_by', $broker->id)
                ->where(function ($q) {
                    $q->whereNull('ssn')
                      ->orWhereNull('license_number');
                })
                ->count(),

            // ===== INVOICES =====
            'total_payments'            => $invoices->count(),
            'unpaid_invoices'           => $invoices->where('is_paid', 0)->count(),
            'total_invoice_amount'      => round($invoices->sum('invoice_total'), 2),
            'total_final_amount'        => round($invoices->sum('amount_to_pay_driver'), 2),
            'total_parcels'             => (int) $invoices->sum('total_parcels'),
            'avg_final_amount'          => round($invoices->avg('amount_to_pay_driver'), 2),
            'total_broker_earnings'     => round(
                $invoices->sum('broker_share'),
                2
            ),
            'avg_broker_percentage'     => $invoices->count() > 0
                ? round($invoices->avg('driver_percentage'), 2)
                : 0,
            'avg_vehicule_rental_price' => $invoices->count() > 0
                ? round($invoices->avg('vehicle_rental_price'), 2)
                : 0,
            'unpaid_payments'           => $invoices->where('is_paid', 0)->count(),
            'paid_payments'             => $invoices->where('is_paid', 1)->count(),
            // ===== BROKER EARNINGS BY WEEK =====
            'broker_earnings_by_week'   => Invoice::whereIn('driver_id', $driverIds)
                                            ->select('week_number', DB::raw('SUM(broker_share) as earnings'))
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
