<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Broker;
use App\Models\Driver;
use App\Models\Invoice;
use App\Models\Expense;
use App\Services\StatsService;

class StatsServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_computes_paid_payments_amount_and_broker_earnings_by_week()
    {
        // Create a broker
        $broker = Broker::create([
            'user_id' => 1,
            'company_name' => 'Test Broker',
        ]);

        // Create two drivers for this broker
        $driverA = Driver::create([
            'created_by' => $broker->id,
            'full_name' => 'Driver A',
        ]);

        $driverB = Driver::create([
            'created_by' => $broker->id,
            'full_name' => 'Driver B',
        ]);

        // Week 1: two invoices, one paid
        Invoice::create([
            'driver_id' => $driverA->id,
            'week_number' => 1,
            'invoice_total' => 100.00,
            'broker_share' => 20.00,
            'amount_to_pay_driver' => 80.00,
            'is_paid' => 1,
        ]);

        Invoice::create([
            'driver_id' => $driverB->id,
            'week_number' => 1,
            'invoice_total' => 200.00,
            'broker_share' => 40.00,
            'amount_to_pay_driver' => 160.00,
            'is_paid' => 0,
        ]);

        // Week 2: one invoice paid
        Invoice::create([
            'driver_id' => $driverA->id,
            'week_number' => 2,
            'invoice_total' => 150.00,
            'broker_share' => 30.00,
            'amount_to_pay_driver' => 120.00,
            'is_paid' => 1,
        ]);

        // Add expenses for week 1 and week 2
        Expense::create([
            'broker_id' => $broker->id,
            'amount' => 10.00,
            'date' => now()->toDateString(),
            'week' => 1,
        ]);

        Expense::create([
            'broker_id' => $broker->id,
            'amount' => 15.00,
            'date' => now()->toDateString(),
            'week' => 2,
        ]);

        $service = new StatsService();
        $stats = $service->getDashboardStats($broker);

        // paid_payments_amount should be sum of invoice_total where is_paid = 1
        $this->assertEquals(100.00 + 150.00, $stats['paid_payments_amount']);

        // total_broker_earnings should be sum(broker_share) - sum(expenses)
        $expectedBrokerShare = 20.00 + 40.00 + 30.00; // 90
        $expectedExpenses = 10.00 + 15.00; // 25
        $this->assertEquals(round($expectedBrokerShare - $expectedExpenses, 2), $stats['total_broker_earnings']);

        // broker_earnings_by_week should have week 1 => (20+40)-10 = 50, week2 => 30-15 = 15
        $weekMap = collect($stats['broker_earnings_by_week'])->keyBy('week_number');
        $this->assertEquals(50.00, $weekMap[1]['earnings']);
        $this->assertEquals(15.00, $weekMap[2]['earnings']);
    }
}
