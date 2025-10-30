<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Invoice;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class StatsService
{
    /**
     * Collect dashboard statistics for the given broker.
     *
     * @param  object  $broker
     * @return array
     */
    public function getDashboardStats($broker, $from = null, $to = null, $granularity = 'week'): array
    {
        // Normalize date range: convert date-only inputs to start/end of day to include full day
        $fromDt = null;
        $toDt = null;
        if ($from && $to) {
            try {
                $fromDt = Carbon::parse($from)->startOfDay();
                $toDt = Carbon::parse($to)->endOfDay();

                // Convert to UTC for comparison against DB timestamps (DB stores timestamps in UTC)
                $fromDtUtc = $fromDt->copy()->setTimezone('UTC');
                $toDtUtc = $toDt->copy()->setTimezone('UTC');
            } catch (\Exception $e) {
                // If parsing fails, leave as null so filters are not applied
                $fromDt = null;
                $toDt = null;
                $fromDtUtc = null;
                $toDtUtc = null;
            }
        } else {
            $fromDtUtc = null;
            $toDtUtc = null;
        }

        // Drivers belonging to this broker. Support both schemas: created_by or broker_id
        $driverBaseQuery = function () use ($broker) {
            $q = Driver::query();
            // only use broker_id if the column exists in this environment
            if (Schema::hasColumn('drivers', 'broker_id')) {
                $q->where(function ($sub) use ($broker) {
                    $sub->where('created_by', $broker->id)
                        ->orWhere('broker_id', $broker->id);
                });
            } else {
                $q->where('created_by', $broker->id);
            }
            return $q;
        };

        $drivers = $driverBaseQuery();
        $driverIds = $driverBaseQuery()->pluck('id')->toArray();

        // Invoices for those drivers
        $invoices = Invoice::whereIn('driver_id', $driverIds);

        // ===== TOP DRIVER BY DAYS (days_worked) =====
        $topRows = Invoice::with('driver')
            ->whereIn('driver_id', $driverIds)
            ->when(isset($fromDtUtc) && isset($toDtUtc), function ($q) use ($fromDtUtc, $toDtUtc) {
                $q->whereBetween('created_at', [$fromDtUtc->toDateTimeString(), $toDtUtc->toDateTimeString()]);
            })
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
            ->when(isset($fromDtUtc) && isset($toDtUtc), function ($q) use ($fromDtUtc, $toDtUtc) {
                $q->whereBetween('created_at', [$fromDtUtc->toDateTimeString(), $toDtUtc->toDateTimeString()]);
            })
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
            ->when(isset($fromDtUtc) && isset($toDtUtc), function ($q) use ($fromDtUtc, $toDtUtc) {
                $q->whereBetween('created_at', [$fromDtUtc->toDateTimeString(), $toDtUtc->toDateTimeString()]);
            })
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
            ->when($fromDt && $toDt, function ($q) use ($fromDt, $toDt) {
                $q->whereBetween('created_at', [$fromDt->toDateTimeString(), $toDt->toDateTimeString()]);
            })
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

        $totalDrivers = $driverBaseQuery()->count();
        $activeCount  = $driverBaseQuery()->where('active', 1)->count();

        // Base invoices query (apply date filter if provided)
        $invoices = Invoice::whereIn('driver_id', $driverIds)
            ->when(isset($fromDtUtc) && isset($toDtUtc), function ($q) use ($fromDtUtc, $toDtUtc) {
                $q->whereBetween('created_at', [$fromDtUtc->toDateTimeString(), $toDtUtc->toDateTimeString()]);
            });

        // fresh builders for paid/unpaid to avoid mutating shared $invoices builder
        $paidInvoices = Invoice::whereIn('driver_id', $driverIds)
            ->where('is_paid', 1)
            ->when(isset($fromDtUtc) && isset($toDtUtc), function ($q) use ($fromDtUtc, $toDtUtc) {
                $q->whereBetween('created_at', [$fromDtUtc->toDateTimeString(), $toDtUtc->toDateTimeString()]);
            });

        $unpaidInvoices = Invoice::whereIn('driver_id', $driverIds)
            ->where('is_paid', 0)
            ->when(isset($fromDtUtc) && isset($toDtUtc), function ($q) use ($fromDtUtc, $toDtUtc) {
                $q->whereBetween('created_at', [$fromDtUtc->toDateTimeString(), $toDtUtc->toDateTimeString()]);
            });

        return [
            // ===== DRIVERS =====
            'total_drivers'               => $totalDrivers,
            'active_drivers'              => $activeCount,
            // Drivers missing SSN or license
            'drivers_missing_ssn'         => $driverBaseQuery()->whereNull('ssn')->count(),
            'drivers_missing_license'     => $driverBaseQuery()->whereNull('license_number')->count(),
            'active_driver_percentage' => $totalDrivers > 0
                ? round(($activeCount / $totalDrivers) * 100, 1)
                : 0,
            'avg_rental_price'         => round($drivers->avg('default_rental_price'), 2),
            // Drivers missing any key info (SSN or license)
            'drivers_missing_info'         => $driverBaseQuery()
                ->where(function ($q) {
                    $q->whereNull('ssn')
                        ->orWhereNull('license_number');
                })
                ->count(),

            // ===== INVOICES =====
            'total_payments'            => $invoices->count(),
            'unpaid_invoices'           => $unpaidInvoices->count(),
            'total_invoice_amount'      => round($invoices->sum('invoice_total'), 2),
            'total_final_amount'        => round($invoices->sum('amount_to_pay_driver'), 2),
            'total_parcels'             => (int) $invoices->sum('total_parcels'),
            'avg_final_amount'          => round($invoices->avg('amount_to_pay_driver'), 2),
            // total broker earnings = sum(broker_share) - sum(expense.amount) for this broker
            'total_broker_earnings'     => round(
                (float) $invoices->sum('broker_share') - (float) Expense::where('broker_id', $broker->id)
                    ->when(isset($fromDt) && isset($toDt), function ($q) use ($fromDt, $toDt) {
                        $q->whereBetween('date', [$fromDt->toDateString(), $toDt->toDateString()]);
                    })->sum('amount'),
                2
            ),
            'avg_broker_percentage'     => $invoices->count() > 0
                ? round($invoices->avg('driver_percentage'), 2)
                : 0,
            'avg_vehicule_rental_price' => $invoices->count() > 0
                ? round($invoices->avg('vehicle_rental_price'), 2)
                : 0,
            'unpaid_payments'           => $unpaidInvoices->count(),
            'paid_payments'             => $paidInvoices->count(),
            // sum of invoice amounts for paid payments only
            'paid_payments_amount'      => round($paidInvoices->sum('invoice_total'), 2),
            // broker earnings by period (day/week/month) => returns ['period' => label, 'earnings']
            'broker_earnings_by_period'   => $this->computeBrokerEarningsByPeriod($driverIds, $broker->id, $from, $to, $granularity),

            // ===== TOP DRIVERS =====
            'top_driver'         => $topDriver,
            'top_driver_parcels' => $topDriverParcels,
            'top_driver_int'     => $topDriverInt,
            'top_driver_own'     => $topDriverOwn,
        ];
    }

    /**
     * Compute broker earnings per week: SUM(broker_share) - SUM(expense.amount)
     *
     * @param  \Illuminate\Support\Collection|array  $driverIds
     * @param  int  $brokerId
     * @return array
     */
    protected function computeBrokerEarningsByPeriod($driverIds, int $brokerId, $from = null, $to = null, $granularity = 'week'): array
    {
        // Normalize date range (local to this method) so it can be used safely
        $fromDt = null;
        $toDt = null;
        if ($from && $to) {
            try {
                $fromDt = Carbon::parse($from)->startOfDay();
                $toDt = Carbon::parse($to)->endOfDay();
            } catch (\Exception $e) {
                $fromDt = null;
                $toDt = null;
            }
        }

        // Decide invoice date column and expense date column
        $invoiceDateCol = 'created_at';
        $expenseDateCol = 'date';

        // Build period expressions depending on granularity
        switch ($granularity) {
            case 'day':
                $invoicePeriod = "DATE($invoiceDateCol)";
                $expensePeriod = "DATE($expenseDateCol)";
                $labelExpr = "DATE($invoiceDateCol)";
                $orderExpr = "DATE($invoiceDateCol)";
                break;
            case 'month':
                $invoicePeriod = "DATE_FORMAT($invoiceDateCol, '%Y-%m')";
                $expensePeriod = "DATE_FORMAT($expenseDateCol, '%Y-%m')";
                $labelExpr = "DATE_FORMAT($invoiceDateCol, '%Y-%m')";
                $orderExpr = "DATE_FORMAT($invoiceDateCol, '%Y-%m')";
                break;
            case 'week':
            default:
                // ISO week: year-week
                $invoicePeriod = "CONCAT(YEAR($invoiceDateCol), '-', LPAD(WEEK($invoiceDateCol, 3), 2, '0'))";
                $expensePeriod = "CONCAT(YEAR($expenseDateCol), '-', LPAD(WEEK($expenseDateCol, 3), 2, '0'))";
                $labelExpr = $invoicePeriod;
                $orderExpr = "YEAR($invoiceDateCol), WEEK($invoiceDateCol,3)";
                break;
        }

        // Base invoice query
        $invoiceQuery = Invoice::whereIn('driver_id', $driverIds);
        if (isset($fromDtUtc) && isset($toDtUtc)) {
            $invoiceQuery = $invoiceQuery->whereBetween($invoiceDateCol, [$fromDtUtc->toDateTimeString(), $toDtUtc->toDateTimeString()]);
        }

        $invoiceSums = $invoiceQuery
            ->select(DB::raw("$invoicePeriod as period"), DB::raw('SUM(COALESCE(broker_share,0)) as broker_sum'))
            ->groupBy('period')
            // order by the grouped alias 'period' to be compatible with ONLY_FULL_GROUP_BY
            ->orderBy('period')
            ->get()
            ->pluck('broker_sum', 'period')
            ->toArray();

        // Base expense query
        $expenseQuery = Expense::where('broker_id', $brokerId);
        if (isset($fromDt) && isset($toDt)) {
            // expense.date is a date-only column, use app date range (not UTC-converted)
            $expenseQuery = $expenseQuery->whereBetween($expenseDateCol, [$fromDt->toDateString(), $toDt->toDateString()]);
        }

        $expenseSums = $expenseQuery
            ->select(DB::raw("$expensePeriod as period"), DB::raw('SUM(COALESCE(amount,0)) as expense_sum'))
            ->groupBy('period')
            ->get()
            ->pluck('expense_sum', 'period')
            ->toArray();

        // merge periods
        $periods = array_unique(array_merge(array_keys($invoiceSums), array_keys($expenseSums)));
        // sort periods in natural order (they are YYYY-MM or YYYY-WW or date)
        sort($periods);

        $result = [];
        foreach ($periods as $period) {
            $brokerSum = isset($invoiceSums[$period]) ? (float) $invoiceSums[$period] : 0.0;
            $expenseSum = isset($expenseSums[$period]) ? (float) $expenseSums[$period] : 0.0;
            $earnings = round($brokerSum - $expenseSum, 2);

            $result[] = [
                'period' => $period,
                'earnings' => $earnings,
            ];
        }

        return $result;
    }
}
