<?php

namespace Tests\Feature;

use App\Models\Driver;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\User;
use App\Services\StatsService;
use App\Support\TimeFilter;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function createBroker(): User
    {
        return User::factory()->broker()->create();
    }

    protected function createDriver(User $broker, array $overrides = []): Driver
    {
        return Driver::create(array_merge([
            'driver_id' => 'DRV-' . uniqid(),
            'full_name' => 'Test Driver',
            'default_percentage' => 50,
            'default_rental_price' => 100,
            'created_by' => $broker->id,
        ], $overrides));
    }

    protected function createInvoice(User $broker, Driver $driver, Carbon $createdAt, array $overrides = []): Invoice
    {
        $data = array_merge([
            'broker_id' => $broker->id,
            'driver_id' => $driver->id,
            'week_number' => (int) $createdAt->format('W'),
            'invoice_total' => 1000,
            'days_worked' => 5,
            'total_parcels' => 100,
            'vehicle_rental_price' => 100,
            'driver_percentage' => 50,
            'bonus' => 0,
            'cash_advance' => 0,
            'penalty' => 0,
            'broker_share' => 100,
            'is_paid' => true,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ], $overrides);

        return Invoice::create($data);
    }

    protected function createExpense(User $broker, Carbon $date, array $overrides = []): Expense
    {
        return Expense::create(array_merge([
            'broker_id' => $broker->id,
            'title' => 'Fuel',
            'amount' => 50,
            'date' => $date->toDateString(),
            'week' => (int) $date->format('W'),
        ], $overrides));
    }

    public function test_stats_service_respects_custom_date_range(): void
    {
        $broker = $this->createBroker();
        $driver = $this->createDriver($broker);

        $insideDate = Carbon::parse('2024-01-10');
        $outsideDate = Carbon::parse('2024-02-15');

        $this->createInvoice($broker, $driver, $insideDate);
        $this->createInvoice($broker, $driver, $outsideDate, [
            'invoice_total' => 1500,
            'broker_share' => 200,
            'total_parcels' => 200,
        ]);

        $this->createExpense($broker, $insideDate);
        $this->createExpense($broker, $outsideDate, ['amount' => 75]);

        $filter = TimeFilter::make(
            TimeFilter::PERIOD_RANGE,
            Carbon::parse('2024-01-01'),
            Carbon::parse('2024-01-31')
        );

        $stats = app(StatsService::class)->getDashboardStats($broker, $filter);

        $this->assertSame(1, $stats['total_payments']);
        $this->assertEquals(1000.00, $stats['total_invoice_amount']);
        $this->assertEquals(100, $stats['total_parcels']);
        $this->assertEquals(50.00, $stats['total_broker_earnings']);
        $this->assertEquals('range', $stats['time_filter']['period']);
        $this->assertCount(1, $stats['broker_earnings_series']);
        $this->assertEquals(50.00, $stats['broker_earnings_series'][0]['earnings']);
        $this->assertNotNull($stats['top_driver']);
    }
}
