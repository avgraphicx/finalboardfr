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
        Schema::table('subscription_items', function (Blueprint $table) {
            $table->dropIndex(['subscription_id', 'stripe_price']);
        });

        Schema::table('subscription_items', function (Blueprint $table) {
            $table->renameColumn('subscription_id', 'cashier_subscription_id');
        });

        Schema::table('subscription_items', function (Blueprint $table) {
            $table->index(['cashier_subscription_id', 'stripe_price']);
            $table->foreign('cashier_subscription_id')
                ->references('id')
                ->on('cashier_subscriptions')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_items', function (Blueprint $table) {
            $table->dropForeign(['cashier_subscription_id']);
            $table->dropIndex(['cashier_subscription_id', 'stripe_price']);
        });

        Schema::table('subscription_items', function (Blueprint $table) {
            $table->renameColumn('cashier_subscription_id', 'subscription_id');
        });

        Schema::table('subscription_items', function (Blueprint $table) {
            $table->index(['subscription_id', 'stripe_price']);
        });
    }
};
