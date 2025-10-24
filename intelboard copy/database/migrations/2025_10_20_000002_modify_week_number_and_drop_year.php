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
            // Change week_number to string to store YYYY-WW
            $table->string('week_number', 8)->change();
            // Drop the separate year column
            if (Schema::hasColumn('payments', 'year')) {
                $table->dropColumn('year');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Revert week_number back to integer
            $table->integer('week_number')->change();
            // Re-add year column
            $table->integer('year')->after('week_number');
        });
    }
};
