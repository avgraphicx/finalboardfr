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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('google_id')->nullable();
            $table->string('name');
            $table->string('full_name')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->tinyInteger('role')->default(3);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->date('joining_date')->nullable();
            $table->boolean('active')->default(true);
            $table->string('company_name')->nullable();
            $table->string('logo')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->string('stripe_id')->nullable()->index();
            $table->string('pm_type')->nullable();
            $table->string('pm_last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
