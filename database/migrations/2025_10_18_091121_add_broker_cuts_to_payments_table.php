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
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('broker_van_cut', 10, 2)->nullable()->after('broker_percentage');
            $table->decimal('broker_pay_cut', 10, 2)->nullable()->after('broker_van_cut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['broker_van_cut', 'broker_pay_cut']);
        });
    }
};
