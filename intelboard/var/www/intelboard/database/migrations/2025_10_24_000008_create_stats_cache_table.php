<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stats_cache', function (Blueprint $table) {
            $table->id();
            $table->foreignId('broker_id')->constrained('users')->onDelete('cascade');
            $table->integer('week_number');
            $table->integer('year');
            $table->integer('total_invoices')->default(0);
            $table->integer('total_parcels')->default(0);
            $table->decimal('total_income', 10, 2)->default(0.00);
            $table->integer('total_paid_invoices')->default(0);
            $table->integer('total_unpaid_invoices')->default(0);
            $table->foreignId('top_driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->timestamps();

            $table->index(['broker_id', 'week_number', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stats_cache');
    }
};
