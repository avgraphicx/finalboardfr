<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('broker_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subscription_type_id')->constrained('subscription_types')->onDelete('cascade');
            $table->string('stripe_subscription_id', 255)->nullable();
            $table->string('stripe_status', 50)->default('active');
            $table->date('started_at');
            $table->date('ends_at');
            $table->decimal('price_paid', 10, 2)->default(0.00);
            $table->boolean('auto_renew')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
