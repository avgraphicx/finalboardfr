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
        Schema::table('subscription_type', function (Blueprint $table) {
            $table->integer('max_drivers')->default(10);
            $table->boolean('custom_invoice')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_type', function (Blueprint $table) {
            $table->dropColumn(['max_drivers', 'custom_invoice']);
        });
    }
};
