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
        Schema::table('brokers', function (Blueprint $table) {
            // Add subscription_type_id column
            $table->foreignId('subscription_type_id')->nullable()->constrained('subscription_type')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brokers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('subscription_type_id');
        });
    }
};
