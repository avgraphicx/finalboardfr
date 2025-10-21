<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Add a nullable warehouse_id column if it doesn't already exist
            if (!Schema::hasColumn('payments', 'warehouse_id')) {
                $table->unsignedBigInteger('warehouse_id')->nullable()->after('warehouse');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop the warehouse_id column
            $table->dropColumn('warehouse_id');
        });
    }
};
