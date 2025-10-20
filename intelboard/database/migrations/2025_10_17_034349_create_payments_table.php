<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('cascade');
            $table->integer('week_number');
            $table->decimal('total_invoice', 10, 2);
            $table->integer('parcel_rows_count')->default(0);
            $table->decimal('vehicule_rental_price', 10, 2)->nullable();
            $table->decimal('broker_percentage', 10, 2)->nullable();
            $table->decimal('bonus', 10, 2)->default(0);
            $table->decimal('cash_advance', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
