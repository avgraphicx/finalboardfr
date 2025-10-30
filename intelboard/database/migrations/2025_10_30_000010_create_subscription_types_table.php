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
        Schema::create('subscription_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('max_drivers')->default(0);
            $table->integer('max_files')->default(0)->comment('Maximum number of files allowed (0 = unlimited)');
            $table->string('stats_type', 50)->default('basic')->comment('Type of statistics access: basic, advanced, premium');
            $table->boolean('add_supervisor')->default(false);
            $table->boolean('custom_invoice')->default(false);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->string('stripe_plan_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_types');
    }
};
