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
        Schema::table('cashier_subscriptions', function (Blueprint $table) {
            // Ensure the column exists before applying the FK (older installs may already have it)
            if (!Schema::hasColumn('cashier_subscriptions', 'user_id')) {
                return;
            }

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cashier_subscriptions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
