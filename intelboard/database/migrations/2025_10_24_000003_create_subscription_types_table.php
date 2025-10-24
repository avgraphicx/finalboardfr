<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('max_drivers')->default(0);
            $table->boolean('add_supervisor')->default(false);
            $table->boolean('custom_invoice')->default(false);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->string('stripe_plan_id', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_types');
    }
};
