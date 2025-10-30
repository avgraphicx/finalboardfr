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
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('drivers', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->foreign('broker_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('broker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });

        Schema::table('stats_cache', function (Blueprint $table) {
            $table->foreign('broker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('top_driver_id')->references('id')->on('drivers')->onDelete('set null');
        });

        Schema::table('subscription_items', function (Blueprint $table) {
            $table->foreign('cashier_subscription_id')->references('id')->on('cashier_subscriptions')->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('user_activity', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('user_preferences', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys in reverse order of creation
        Schema::table('user_preferences', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('user_activity', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });
        Schema::table('subscription_items', function (Blueprint $table) {
            $table->dropForeign(['cashier_subscription_id']);
        });
        Schema::table('stats_cache', function (Blueprint $table) {
            $table->dropForeign(['broker_id']);
            $table->dropForeign(['top_driver_id']);
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['broker_id']);
            $table->dropForeign(['driver_id']);
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['broker_id']);
        });
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
