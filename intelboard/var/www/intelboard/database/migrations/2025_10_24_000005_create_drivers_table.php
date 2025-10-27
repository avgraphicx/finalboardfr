<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_id', 50)->unique(); // Custom readable ID (DRV-001)
            $table->string('full_name');
            $table->string('ssn', 50)->nullable(); // encrypted
            $table->string('license_number', 50)->nullable(); // encrypted
            $table->decimal('default_percentage', 5, 2)->default(0.00);
            $table->decimal('default_rental_price', 10, 2)->default(0.00);
            $table->boolean('active')->default(true);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
