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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_id', 50)->unique();
            $table->string('full_name');
            $table->string('phone_number', 20)->nullable();
            $table->string('ssn', 50)->nullable();
            $table->string('license_number', 50)->nullable();
            $table->decimal('default_percentage', 5, 2)->default(0.00);
            $table->decimal('default_rental_price', 10, 2)->default(0.00);
            $table->boolean('active')->default(true);
            $table->foreignId('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
