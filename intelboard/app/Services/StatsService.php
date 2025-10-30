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
        $filter ??= TimeFilter::default();

        $rangeStart = $filter->startDate->copy()->startOfDay();
        $rangeEnd = $filter->endDate->copy()->endOfDay();
        $weekNumbers = $this->weekNumbersWithinRange($filter);

        $driversQuery = Driver::where('created_by', $broker->id);
        $driverIds = (clone $driversQuery)->pluck('id');

        $invoicesBase = Invoice::where('broker_id', $broker->id)
            ->whereIn('driver_id', $driverIds);

        $invoicesInRange = (clone $invoicesBase)
            ->when(! empty($weekNumbers), function (Builder $query) use ($weekNumbers) {
                $query->whereIn('week_number', $weekNumbers);
            });

        // ===== TOP DRIVER BY DAYS (days_worked) =====
        $topDriver = $this->resolveTopDriver(
            (clone $invoicesInRange),
            'days_worked',
            'total_rows'
        );

        // ===== TOP DRIVER BY PARCELS =====
        $topDriverParcels = $this->resolveTopDriver(
            (clone $invoicesInRange),
            'total_parcels',
            'total_parcels'
        );

        // ===== TOP DRIVER BY INTELCOM INVOICE TOTAL =====
        $topDriverInt = $this->resolveTopDriver(
            (clone $invoicesInRange),
            'invoice_total',
            'total_invoice'
        );

        // ===== TOP DRIVER BY FINAL AMOUNT (amount_to_pay_driver) =====
        $topDriverOwn = $this->resolveTopDriver(
            (clone $invoicesInRange),
            'amount_to_pay_driver',
            'final_amount'
        );

        $totalDrivers = (clone $driversQuery)->count();
        $activeDrivers = (clone $driversQuery)->where('active', 1)->count();

        $invoiceCount = (clone $invoicesInRange)->count();
        $unpaidInvoices = (clone $invoicesInRange)->where('is_paid', 0)->count();
        $paidInvoices = (clone $invoicesInRange)->where('is_paid', 1)->count();

        $totalInvoiceAmount = (clone $invoicesInRange)->sum('invoice_total');
        $totalFinalAmount = (clone $invoicesInRange)->sum('amount_to_pay_driver');
        $totalParcels = (clone $invoicesInRange)->sum('total_parcels');
        $averageFinalAmount = (clone $invoicesInRange)->avg('amount_to_pay_driver') ?? 0;
        $averageBrokerPercentage = $invoiceCount > 0
            ? (clone $invoicesInRange)->avg('driver_percentage') ?? 0
            : 0;
        $averageVehicleRental = $invoiceCount > 0
            ? (clone $invoicesInRange)->avg('vehicle_rental_price') ?? 0
            : 0;
        $activePercentage = $totalDrivers > 0
            ? round(($activeDrivers / $totalDrivers) * 100, 1)
            : 0;

        $expensesInRange = $this->expenseQueryForRange($broker->id, $rangeStart, $rangeEnd);
        $expensesTotal = (clone $expensesInRange)->sum('amount');

        $totalBrokerEarnings = ((clone $invoicesInRange)->sum('broker_share') ?? 0) - $expensesTotal;

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
            'broker_earnings_series' => $this->computeBrokerEarningsSeries($driverIds, $broker->id, $filter, $weekNumbers),

            // Top performers (range bound)
            'top_driver' => $topDriver,
            'top_driver_parcels' => $topDriverParcels,
            'top_driver_int' => $topDriverInt,
            'top_driver_own' => $topDriverOwn,

            // Current filter snapshot
            'time_filter' => $filter->toArray(),
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
     * Build the expense query constrained to the provided range.
     */
    protected function expenseQueryForRange(int $brokerId, Carbon $rangeStart, Carbon $rangeEnd): Builder
    {
        return Expense::where('broker_id', $brokerId)
            ->whereNotNull('date')
            ->whereBetween('date', [$rangeStart->toDateString(), $rangeEnd->toDateString()]);
    }

    /**
     * Compute broker earnings by period (day/week/month) depending on the active filter.
     *
     * @param  \Illuminate\Support\Collection|array  $driverIds
     */
    protected function computeBrokerEarningsSeries($driverIds, int $brokerId, TimeFilter $filter, array $weekNumbers): array
    {
        if (empty($weekNumbers)) {
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
