<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeFilter
{
    public const PERIOD_DAILY = 'daily';
    public const PERIOD_WEEKLY = 'weekly';
    public const PERIOD_MONTHLY = 'monthly';
    public const PERIOD_RANGE = 'range';

    protected const ALLOWED_PERIODS = [
        self::PERIOD_DAILY,
        self::PERIOD_WEEKLY,
        self::PERIOD_MONTHLY,
        self::PERIOD_RANGE,
    ];

    public function __construct(
        public readonly string $period,
        public readonly Carbon $startDate,
        public readonly Carbon $endDate
    ) {
    }

    public static function default(): self
    {
        return self::weekly();
    }

    public static function fromRequest(Request $request): self
    {
        $period = $request->input('period', self::PERIOD_WEEKLY);
        if (! in_array($period, self::ALLOWED_PERIODS, true)) {
            $period = self::PERIOD_WEEKLY;
        }

        return match ($period) {
            self::PERIOD_DAILY => self::daily(),
            self::PERIOD_WEEKLY => self::weekly(),
            self::PERIOD_MONTHLY => self::monthly(),
            self::PERIOD_RANGE => self::fromCustomRange(
                $request->input('start_date'),
                $request->input('end_date')
            ),
            default => self::weekly(),
        };
    }

    public static function daily(?Carbon $reference = null): self
    {
        $reference ??= Carbon::today();
        $start = $reference->copy()->startOfDay();
        $end = $reference->copy()->endOfDay();

        return new self(self::PERIOD_DAILY, $start, $end);
    }

    public static function weekly(?Carbon $reference = null): self
    {
        $reference ??= Carbon::today();
        $start = $reference->copy()->startOfWeek();
        $end = $reference->copy()->endOfWeek();

        return new self(self::PERIOD_WEEKLY, $start, $end);
    }

    public static function monthly(?Carbon $reference = null): self
    {
        $reference ??= Carbon::today();
        $start = $reference->copy()->startOfMonth();
        $end = $reference->copy()->endOfMonth();

        return new self(self::PERIOD_MONTHLY, $start, $end);
    }

    public static function fromCustomRange(?string $startDate, ?string $endDate): self
    {
        $start = $startDate ? Carbon::parse($startDate) : Carbon::today()->startOfWeek();
        $end = $endDate ? Carbon::parse($endDate) : Carbon::today();

        if ($start->gt($end)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
        }

        return new self(
            self::PERIOD_RANGE,
            $start->startOfDay(),
            $end->endOfDay()
        );
    }

    public static function make(string $period, Carbon $start, Carbon $end): self
    {
        if (! in_array($period, self::ALLOWED_PERIODS, true)) {
            $period = self::PERIOD_WEEKLY;
        }

        return new self($period, $start->copy()->startOfDay(), $end->copy()->endOfDay());
    }

    public function grouping(): string
    {
        return match ($this->period) {
            self::PERIOD_MONTHLY => 'month',
            self::PERIOD_WEEKLY => 'week',
            default => 'day',
        };
    }

    public function toArray(): array
    {
        return [
            'period' => $this->period,
            'start_date' => $this->startDate->toDateString(),
            'end_date' => $this->endDate->toDateString(),
        ];
    }
}
