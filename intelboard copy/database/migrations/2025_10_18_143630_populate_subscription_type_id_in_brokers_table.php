<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Map subscription_tier values to subscription_type ids
        $tierMapping = [
            'bronze' => 1,   // Bronze subscription type
            'silver' => 2,   // Silver subscription type (or create if doesn't exist)
            'gold' => 2,     // Gold subscription type (maps to id 2 from the image)
        ];

        // Update each tier
        foreach ($tierMapping as $tier => $typeId) {
            DB::table('brokers')
                ->where('subscription_tier', $tier)
                ->update(['subscription_type_id' => $typeId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('brokers')->update(['subscription_type_id' => null]);
    }
};
