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
        Schema::table('weeks', function (Blueprint $table) {
            // Add columns for each weekday
            $table->date('monday')->nullable()->after('week');
            $table->date('tuesday')->nullable();
            $table->date('wednesday')->nullable();
            $table->date('thursday')->nullable();
            $table->date('friday')->nullable();
            $table->date('saturday')->nullable();
            $table->date('sunday')->nullable();
            // Drop old startday and endday
            if (Schema::hasColumn('weeks', 'startday')) {
                $table->dropColumn('startday');
            }
            if (Schema::hasColumn('weeks', 'endday')) {
                $table->dropColumn('endday');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weeks', function (Blueprint $table) {
            // Drop weekday columns
            $table->dropColumn(['monday','tuesday','wednesday','thursday','friday','saturday','sunday']);
            // Add back startday and endday
            $table->date('startday')->after('week');
            $table->date('endday');
        });
    }
};
