<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Add warehouse identifier (e.g., RIDP, MONT, etc.)
            $table->string('warehouse', 32)->nullable()->after('week_number');
            // Optional composite index to speed up duplicate checks
            $table->index(['driver_id', 'week_number', 'warehouse']);
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['driver_id', 'week_number', 'warehouse']);
            $table->dropColumn('warehouse');
        });
    }
};
