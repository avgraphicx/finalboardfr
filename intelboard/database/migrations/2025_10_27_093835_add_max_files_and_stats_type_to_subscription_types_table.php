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
        Schema::table('subscription_types', function (Blueprint $table) {
            $table->integer('max_files')->default(0)->after('max_drivers')
                ->comment('Maximum number of files allowed (0 = unlimited)');
            $table->string('stats_type', 50)->default('basic')->after('max_files')
                ->comment('Type of statistics access: basic, advanced, premium');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_types', function (Blueprint $table) {
            $table->dropColumn(['max_files', 'stats_type']);
        });
    }
};
