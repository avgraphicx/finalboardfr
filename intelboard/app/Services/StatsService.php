<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Expense;
use App\Models\Invoice;
use App\Support\TimeFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class StatsService
{
    /**
     * Collect dashboard statistics for the given broker.
     */
    public function getDashboardStats($broker, ?TimeFilter $filter = null): array
    {
        $applyFilter = $filter instanceof TimeFilter;
        $rangeStart = $applyFilter ? $filter->startDate->copy()->startOfDay() : null;
        $rangeEnd = $applyFilter ? $filter->endDate->copy()->endOfDay() : null;
        $weekNumbers = $applyFilter ? $this->weekNumbersWithinRange($filter) : [];

        $driversQuery = Driver::where('created_by', $broker->id);
        $driverIds = (clone $driversQuery)->pluck('id');

        $invoicesBase = Invoice::where('broker_id', $broker->id)
            ->whereIn('driver_id', $driverIds);

        $invoicesForStats = (clone $invoicesBase);
        if ($applyFilter && ! empty($weekNumbers)) {
            $invoicesForStats->whereIn('week_number', $weekNumbers);
        }

        // ===== TOP DRIVER BY DAYS (days_worked) =====
        $topDriver = $this->resolveTopDriver(
            (clone $invoicesForStats),
            'days_worked',
            'total_rows'
        );

        // ===== TOP DRIVER BY PARCELS =====
        $topDriverParcels = $this->resolveTopDriver(
            (clone $invoicesForStats),
            'total_parcels',
            'total_parcels'
        );

        // ===== TOP DRIVER BY INTELCOM INVOICE TOTAL =====
        $topDriverInt = $this->resolveTopDriver(
            (clone $invoicesForStats),
            'invoice_total',
            'total_invoice'
        );

        // ===== TOP DRIVER BY FINAL AMOUNT (amount_to_pay_driver) =====
        $topDriverOwn = $this->resolveTopDriver(
            (clone $invoicesForStats),
            'amount_to_pay_driver',
            'final_amount'
        );

        $totalDrivers = (clone $driversQuery)->count();
        $activeDrivers = (clone $driversQuery)->where('active', 1)->count();

        $invoiceCount = (clone $invoicesForStats)->count();
        $unpaidInvoices = (clone $invoicesForStats)->where('is_paid', 0)->count();
        $paidInvoices = (clone $invoicesForStats)->where('is_paid', 1)->count();

        $totalInvoiceAmount = (clone $invoicesForStats)->sum('invoice_total');
        $totalFinalAmount = (clone $invoicesForStats)->sum('amount_to_pay_driver');
        $totalParcels = (clone $invoicesForStats)->sum('total_parcels');
        $averageFinalAmount = (clone $invoicesForStats)->avg('amount_to_pay_driver') ?? 0;
        $averageBrokerPercentage = $invoiceCount > 0
            ? (clone $invoicesForStats)->avg('driver_percentage') ?? 0
            : 0;
        $averageVehicleRental = $invoiceCount > 0
            ? (clone $invoicesForStats)->avg('vehicle_rental_price') ?? 0
            : 0;
        $activePercentage = $totalDrivers > 0
            ? round(($activeDrivers / $totalDrivers) * 100, 1)
            : 0;

        $expensesQuery = Expense::where('broker_id', $broker->id);
        if ($applyFilter && $rangeStart && $rangeEnd) {
            $expensesQuery->whereNotNull('date')
                ->whereBetween('date', [$rangeStart->toDateString(), $rangeEnd->toDateString()]);
        }
        $expensesTotal = (clone $expensesQuery)->sum('amount');

        $totalBrokerEarnings = ((clone $invoicesForStats)->sum('broker_share') ?? 0) - $expensesTotal;

        return [
            // Driver stats (not range bound)
            'total_drivers' => $totalDrivers,
            'active_drivers' => $activeDrivers,
            'drivers_missing_ssn' => Driver::where('created_by', $broker->id)->whereNull('ssn')->count(),
            'drivers_missing_license' => Driver::where('created_by', $broker->id)->whereNull('license_number')->count(),
            'active_driver_percentage' => $activePercentage,

            // Financial/invoice stats (range bound)
            'total_payments' => $invoiceCount,
            'unpaid_invoices' => $unpaidInvoices,
            'paid_payments' => $paidInvoices,
            'unpaid_payments' => $unpaidInvoices,
            'total_invoice_amount' => round($totalInvoiceAmount, 2),
            'total_final_amount' => round($totalFinalAmount, 2),
            'total_parcels' => (int) $totalParcels,
            'avg_final_amount' => round($averageFinalAmount, 2),
            'total_broker_earnings' => round($totalBrokerEarnings, 2),
            'avg_broker_percentage' => round($averageBrokerPercentage, 2),
            'avg_vehicule_rental_price' => round($averageVehicleRental, 2),

            // Broker earnings over time
            'broker_earnings_series' => $this->computeBrokerEarningsSeries($driverIds, $broker->id, $filter, $weekNumbers, $applyFilter),

            // Top performers (range bound)
            'top_driver' => $topDriver,
            'top_driver_parcels' => $topDriverParcels,
            'top_driver_int' => $topDriverInt,
            'top_driver_own' => $topDriverOwn,

            // Current filter snapshot
            'time_filter' => $applyFilter ? $filter->toArray() : null,
        ];
    }

    /**
     * Resolve a top driver metric using the supplied aggregate field.
     *
     * @return array|null
     */
    protected function resolveTopDriver(Builder $invoices, string $aggregateField, string $alias): ?array
    {
        $topRecord = $invoices
            ->with('driver')
            ->select('driver_id', DB::raw("SUM({$aggregateField}) AS {$alias}"))
            ->groupBy('driver_id')
            ->orderByDesc($alias)
            ->first();

        if (! $topRecord || ! $topRecord->driver) {
            return null;
        }

        return [
            'driver_id' => $topRecord->driver_id,
            $alias => $topRecord->{$alias},
            'driver' => $topRecord->driver,
        ];
    }

    /**
     * Compute broker earnings by period (day/week/month) depending on the active filter.
     *
     * @param  \Illuminate\Support\Collection|array  $driverIds
     */
    protected function computeBrokerEarningsSeries($driverIds, int $brokerId, ?TimeFilter $filter, array $weekNumbers, bool $applyFilter): array
    {
        if (! $applyFilter) {
            $invoiceSums = Invoice::whereIn('driver_id', $driverIds)
                ->where('broker_id', $brokerId)
                ->select('week_number', DB::raw('SUM(COALESCE(broker_share,0)) as broker_sum'))
                ->groupBy('week_number')
                ->pluck('broker_sum', 'week_number')
                ->toArray();

            $expenseSums = Expense::where('broker_id', $brokerId)
                ->select('week', DB::raw('SUM(COALESCE(amount,0)) as expense_sum'))
                ->groupBy('week')
                ->pluck('expense_sum', 'week')
                ->toArray();

            $weeks = array_unique(array_merge(array_keys($invoiceSums), array_keys($expenseSums)));
            sort($weeks, SORT_NUMERIC);

            $series = [];
            foreach ($weeks as $week) {
                if ($week === null) {
                    continue;
                }
                $brokerSum = isset($invoiceSums[$week]) ? (float) $invoiceSums[$week] : 0.0;
                $expenseSum = isset($expenseSums[$week]) ? (float) $expenseSums[$week] : 0.0;
                $series[] = [
                    'label' => __('messages.week') . ' ' . $week,
                    'earnings' => round($brokerSum - $expenseSum, 2),
                ];
            }

            return $series;
        }

        if ($filter === null || empty($weekNumbers)) {
            return [];
        }

        $invoiceSums = Invoice::whereIn('driver_id', $driverIds)
            ->where('broker_id', $brokerId)
            ->whereIn('week_number', $weekNumbers)
            ->select('week_number', DB::raw('SUM(COALESCE(broker_share,0)) as broker_sum'))
            ->groupBy('week_number')
            ->pluck('broker_sum', 'week_number')
            ->toArray();

        $expenseSums = Expense::where('broker_id', $brokerId)
            ->whereNotNull('date')
            ->whereBetween('date', [$filter->startDate->toDateString(), $filter->endDate->toDateString()])
            ->get(['date', 'amount'])
            ->groupBy(function ($expense) {
                return Carbon::parse($expense->date)->isoWeek();
            })
            ->map(function ($group) {
                return $group->sum('amount');
            })
            ->toArray();

        $presentWeeks = array_values(array_unique(array_merge(
            array_keys($invoiceSums),
            array_keys($expenseSums)
        )));

        if (empty($presentWeeks)) {
            $presentWeeks = array_values(array_unique($weekNumbers));
        }

        sort($presentWeeks);

        $series = [];
        foreach ($presentWeeks as $week) {
            $brokerSum = isset($invoiceSums[$week]) ? (float) $invoiceSums[$week] : 0.0;
            $expenseSum = isset($expenseSums[$week]) ? (float) $expenseSums[$week] : 0.0;
            $earnings = round($brokerSum - $expenseSum, 2);

            $series[] = [
                'label' => __('messages.week') . ' ' . $week,
                'earnings' => $earnings,
            ];
        }

        return $series;
    }

    /**
     * Determine ISO week numbers within the provided filter range.
     */
    protected function weekNumbersWithinRange(TimeFilter $filter): array
    {
        $weeks = [];
        $cursor = $filter->startDate->copy()->startOfWeek();
        $end = $filter->endDate->copy()->endOfWeek();

        while ($cursor->lte($end)) {
            $weeks[] = (int) $cursor->isoWeek();
            $cursor->addWeek();
        }

        return array_values(array_unique($weeks));
    }
}
