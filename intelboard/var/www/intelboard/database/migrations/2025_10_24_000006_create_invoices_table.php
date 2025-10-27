<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('broker_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('cascade');
            $table->integer('week_number');
            $table->string('warehouse_name', 255)->nullable();
            $table->decimal('invoice_total', 10, 2)->default(0.00);
            $table->integer('days_worked')->default(0);
            $table->integer('total_parcels')->default(0);
            $table->decimal('vehicle_rental_price', 10, 2)->default(0.00);
            $table->decimal('driver_percentage', 5, 2)->default(0.00);
            $table->decimal('bonus', 10, 2)->default(0.00);
            $table->decimal('cash_advance', 10, 2)->default(0.00);
            $table->decimal('penalty', 10, 2)->default(0.00);
            // Computed fields (calculated on-the-fly or stored)
            $table->decimal('amount_to_pay_driver', 10, 2)->nullable()->comment('computed');
            $table->decimal('broker_share', 10, 2)->nullable()->comment('computed');
            $table->decimal('enterprise_net', 10, 2)->nullable()->comment('computed');
            $table->boolean('is_paid')->default(false);
            $table->string('pdf_path', 255)->nullable();
            $table->date('paid_at')->nullable();
            $table->timestamps();

            $table->index(['broker_id', 'week_number']);
            $table->index(['driver_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
